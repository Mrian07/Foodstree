if(_.isUndefined(window.vc)) var vc = {atts: {}};
(function ($) {

	// Inline Shortcode Extend
	window.ivan_sc_view_extend = window.InlineShortcodeView.extend({
		render: function() {
		  window.InlineShortcodeView_vc_flickr.__super__.render.call(this);

		  var scriptTag = this.$el.find('.ivan-script').val();

		  //console.log(scriptTag);

		  vc.frame_window.vc_iframe.addActivity(function(){
		    this.vc_iframe.vc_ivan_js(scriptTag);
		  });

		  return this;
		}
	});

	// Posts
	window.InlineShortcodeView_ivan_posts = window.ivan_sc_view_extend;

	// Projects
	window.InlineShortcodeView_ivan_projects = window.ivan_sc_view_extend;

	// GMap
	window.InlineShortcodeView_ivan_gmap = window.ivan_sc_view_extend;

	// Carousel
	window.InlineShortcodeView_ivan_carousel = window.InlineShortcodeView.extend({
	    controls_selector: '#vc_controls-template-container',
	    events: {
	      'click > .vc_controls .vc_element .vc_control-btn-delete': 'destroy',
	      'click > .vc_controls .vc_element .vc_control-btn-edit': 'edit',
	      'click > .vc_controls .vc_element .vc_control-btn-clone': 'clone',
	      'click > .vc_controls .vc_element .vc_control-btn-prepend': 'prependElement',
	      'click > .vc_controls .vc_control-btn-append': 'appendElement',
	      'click > .vc_empty-element': 'appendElement',
	      'mouseenter': 'resetActive',
	      'mouseleave': 'holdActive'
	    },
	    hold_active: false,
	    initialize: function(params) {
	      _.bindAll(this, 'holdActive');
	      window.InlineShortcodeViewContainer.__super__.initialize.call(this, params);
	      this.parent_view = vc.shortcodes.get(this.model.get('parent_id')).view;
	    },
	    resetActive: function(e) {
	      this.hold_active && window.clearTimeout(this.hold_active);
	    },
	    holdActive: function(e) {
	      this.resetActive();
	      this.$el.addClass('vc_hold-active');
	      var view = this;
	      this.hold_active = window.setTimeout(function(){
	        view.hold_active && window.clearTimeout(view.hold_active);
	        view.hold_active = false;
	        view.$el.removeClass('vc_hold-active');
	      }, 700);
	    },
	    content: function() {
	      if(this.$content === false) {
	        this.$content = this.$el.find('.vc_container-anchor:first').parent();
	        this.$el.find('.vc_container-anchor:first').remove();
	      }
	      return this.$content;
	    },
	    render: function() {
	      window.InlineShortcodeViewContainer.__super__.render.call(this);
	      this.content().addClass('vc_element-container');
	      this.$el.addClass('vc_container-block');

	      var scriptTag = this.$el.find('.ivan-script').val();

	      vc.frame_window.vc_iframe.addActivity(function(){
	        this.vc_iframe.vc_ivan_js(scriptTag);
	      });

	      return this;
	    },
	    changed: function() {
	      (this.$el.find('.vc_element[data-tag]').length == 0 && this.$el.addClass('vc_empty').find('> :first').addClass('vc_empty-element'))
	      || this.$el.removeClass('vc_empty').find('> .vc_empty-element').removeClass('vc_empty-element');
	    },
	    prependElement: function(e) {
	      _.isObject(e) && e.preventDefault();
	      this.prepend = true;
	      vc.add_element_block_view.render(this.model, true);
	    },
	    appendElement: function(e) {
	      _.isObject(e) && e.preventDefault();
	      vc.add_element_block_view.render(this.model);
	    },
	    addControls: function() {
	      var template = $(this.controls_selector).html(),
	        parent = vc.shortcodes.get(this.model.get('parent_id')),
	        data = {
	          name: vc.getMapped(this.model.get('shortcode')).name,
	          tag: this.model.get('shortcode'),
	          parent_name: vc.getMapped(parent.get('shortcode')).name,
	          parent_tag: parent.get('shortcode')
	        };
	      this.$controls = $(_.template(template, data, vc.template_options).trim()).addClass('vc_controls');
	      this.$controls.appendTo(this.$el);
	    },
	    multi_edit: function(e) {
	      var models = [], parent, children;
	      _.isObject(e) && e.preventDefault();
	      if(this.model.get('parent_id')) parent = vc.shortcodes.get(this.model.get('parent_id'));
	      if(parent) {
	        models.push(parent);
	        children = vc.shortcodes.where({parent_id: parent.get('id')});
	        vc.multi_edit_element_block_view.render(models.concat(children), this.model.get('id'));
	      } else {
	        vc.edit_element_block_view.render(this.model);
	      }
	    }
	});

	// Row
	window.InlineShortcodeView_vc_row = window.InlineShortcodeView.extend({
	  column_tag: 'vc_column',
	  events: {
	    'mouseenter': 'removeHoldActive'
	  },
	  layout: 1,
	  addControls: function() {
	    this.$controls = $('<div class="no-controls"></div>');
	    this.$controls.appendTo(this.$el);
	    return this;
	  },
	  removeHoldActive: function() {
	    vc.unsetHoldActive();
	  },
	  addColumn: function() {
	    vc.builder.create({
	      shortcode: this.column_tag,
	      parent_id: this.model.get('id')
	    }).render();
	  },
	  addElement: function(e) {
	    e && e.preventDefault();
	    this.addColumn();
	  },
	  changeLayout: function(e) {
	    e && e.preventDefault();
	    this.layoutEditor().render(this.model).show();
	  },
	  layoutEditor: function() {
	    if(_.isUndefined(vc.row_layout_editor)) vc.row_layout_editor = new vc.RowLayoutEditorPanelView({el: $('#vc_row-layout-panel')});
	    return vc.row_layout_editor;
	  },
	  convertToWidthsArray: function(string) {
	    return _.map(string.split(/_/), function(c){
	      var w = c.split('');
	      w.splice(Math.floor(c.length/2), 0, '/');
	      return w.join('');
	    });
	  },
	  changed: function() {
	    window.InlineShortcodeView_vc_row.__super__.changed.call(this);
	    this.addLayoutClass();
	  },
	  content: function() {
	    if(this.$content === false) this.$content = this.$el.find('.vc_container-anchor:first').parent();
	    this.$el.find('.vc_container-anchor:first').remove();
	    return this.$content;
	  },
	  addLayoutClass: function() {
	    this.$el.removeClass('vc_layout_' + this.layout);
	    this.layout = _.reject(vc.shortcodes.where({parent_id: this.model.get('id')}), function(model){return model.get('deleted')}).length;
	    this.$el.addClass('vc_layout_' + this.layout);
	  },
	  convertRowColumns: function(layout, builder) {
	    if(!layout) return false;
	    var view = this, columns_contents = [], new_model,
	      columns = this.convertToWidthsArray(layout);
	    vc.layout_change_shortcodes = [];
	    vc.layout_old_columns = vc.shortcodes.where({parent_id: this.model.get('id')});
	    _.each(vc.layout_old_columns, function(column){
	      column.set('deleted' , true);
	      columns_contents.push({shortcodes: vc.shortcodes.where({parent_id: column.get('id')}), params: column.get('params')});
	    });
	    _.each(columns, function(column){
	      var prev_settings = columns_contents.shift();
	      if(_.isObject(prev_settings)) {
	        new_model = builder.create({shortcode: this.column_tag, parent_id: this.model.get('id'), order: vc.shortcodes.nextOrder(), params: _.extend({}, prev_settings.params, {width: column})}).last();
	        _.each(prev_settings.shortcodes, function(shortcode){
	          shortcode.save({parent_id: new_model.get('id'), order: vc.shortcodes.nextOrder()}, {silent: true});
	          vc.layout_change_shortcodes.push(shortcode);
	        }, this);
	      } else {
	        new_model = builder.create({shortcode: this.column_tag, parent_id: this.model.get('id'), order: vc.shortcodes.nextOrder(), params: {width: column}}).last();
	      }
	    }, this);
	    _.each(columns_contents, function(column) {
	      _.each(column.shortcodes, function(shortcode){
	        shortcode.save({parent_id: new_model.get('id'), order: vc.shortcodes.nextOrder()}, {silent: true});
	        vc.layout_change_shortcodes.push(shortcode);
	        shortcode.view.rowsColumnsConverted && shortcode.view.rowsColumnsConverted()
	      }, this);
	    },this);
	    builder.render(function(){
	      _.each(vc.layout_change_shortcodes, function(shortcode){
	        shortcode.trigger('change:parent_id');
	        shortcode.view.rowsColumnsConverted && shortcode.view.rowsColumnsConverted();
	      });
	      _.each(vc.layout_old_columns, function(column){
	        column.destroy();
	      });
	      vc.layout_old_columns = [];
	      vc.layout_change_shortcodes = [];
	    });
	    return columns;
	  },
	  /* Custom Render */
	  render: function() {
	    window.InlineShortcodeView_vc_row.__super__.render.call(this);

	    var scriptTag = this.$el.find('.ivan-script').val();

	    vc.frame_window.vc_iframe.addActivity(function(){
	      this.vc_iframe.vc_ivan_js(scriptTag);
	    });

	    return this;
	  }
	  /* End Custom Render */
	});

})(window.jQuery);
if(_.isUndefined(window.vc)) var vc = {atts: {}};
(function ($) {
	 /**
		* Customizer Editor
		* @type {*}
		*/
		var VcCustomizerEditor = Backbone.View.extend({
		attrs: {},
		layouts: ['margin', 'border-width', 'padding'],
		positions: ['top', 'right', 'bottom', 'left'],
		$field: false,
		events: {
			// 'change [data-attribute]': 'attributeChanged'
		},
		initialize: function() {

		},
		render: function(value) {
			this.attrs = {};
			_.isString(value) && this.parse(value);
			// wp.media.vc_css_editor.init(this);

			return this;
		},
		parse: function(value) {
			value = value.replace(/\s*\{\s*([^\}]+)\s*\}\s*/g, '');
			//data_split[2] && this.parseAtts(data_split[2]);

			value && this.parseAtts(value);

		},
		parseAtts: function(string) {
			var _form = this.$el;

			 _.map(string.split(';'), function(val){
			 	if('' != val) {
				 	var val_s = val.split(':');

				 	var _type = val_s[0];
				 	var _val = val_s[1];

				 	_form.find('[data-property='+_type+']').val(_val);
			 	}
			 });	
		},
		save: function() {
			var string = '';
			this.attrs = {};
			_ivan_customizer_prefix = false;

			this.$el.find('.ivan-field').each( function() {
				var _val = $(this).val();

				if( $(this).hasClass('vc-color-control') == false ) {
					if($(this).attr('type') == 'text') {
						if(!_val.match(/^\d+(\.\d+){0,1}(%|in|cm|mm|em|ex|pt|pc|px|rem|vw|vh)$/)) {
						  _val = (isNaN(parseInt(_val)) ? '' : '' + parseInt(_val) + 'px');
						}
					}
				}

				if('' != _val) {
					string += $(this).attr('data-property') + ':' + _val + ';';
				}
			});

			/*
			if(_ivan_customizer_prefix == false) {
				var _prefix =  '{.vc_customizer_' + (+new Date) + '}';
				string = _prefix + string;
				_ivan_customizer_prefix = _prefix;
			}
			*/
			
			return string;
		},
	});
	/**
	 * Add new param to atts types list for vc
	 * @type {Object}
	 */
	vc.atts.ivan_customizer = {
		parse: function(param) {
			if(typeof(this.content) == 'function') {
				var $field = this.content().find('input.wpb_vc_param_value.' + param.param_name + '');
			}
			else {
				var $field = this.$el.find('input.wpb_vc_param_value.' + param.param_name + '');
			}

			var customizer_editor = $field.data('customizerEditor');

			var result = customizer_editor.save();

			return result;
		}
	};

	var _ivan_customizer_prefix = false;
	/**
	 * Find all fields with ivan editor type and initialize.
	 */
	$('[data-ivan-customizer=true]').each(function(){
		var $editor = $(this),
				$field = $editor.find('input.wpb_vc_param_value'),
				value = $field.val();
		$field.data('customizerEditor', new VcCustomizerEditor({el: $editor}).render(value));
	});
})(window.jQuery);
if(_.isUndefined(window.vc)) var vc = {atts: {}};
(function ($) {
	vc.atts.ivan_customizer_id = {
		parse: function(param) {

			return '.vc_' + (+new Date);

		}
	};

})(window.jQuery);
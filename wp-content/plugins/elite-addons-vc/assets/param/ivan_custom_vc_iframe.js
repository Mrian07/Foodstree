(function ($) {

	vc_iframe.vc_ivan_js = function(js) {
	  var script   = document.createElement("script");
	  script.type  = "text/javascript";
	  script.text  = js;
	  document.body.appendChild(script);
	  console.log('Ivan Customizer: JS Appended.');
	};
	
})(window.jQuery);
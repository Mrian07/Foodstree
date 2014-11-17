<?php if(true == ivan_get_option('enable-preloader')) : ?>
		<div id="page-loader">
			<!--<i class="fa fa-spinner fa-spin"></i>-->
			<div class="page-loader-spinner">
				<div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div>
			</div>
			<!--
			<div id="loader-wrapper">
				<div class="loader"><?php _e('Loading...', 'ivan_domain'); ?></div>
			</div>
			-->
		</div>
<?php endif; ?>
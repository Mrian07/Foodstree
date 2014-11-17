<?php
if( true == ivan_get_option('woo-display-sorting') ) : ?>

	<div class="woo-sorting-options">

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">

				<div class="catalog-results-number">
					<?php woocommerce_result_count(); ?>
				</div>

				<div class="catalog-orderby">
					<?php woocommerce_catalog_ordering(); ?>
				</div>

				<div class="hidden-xs hidden-sm catalog-pagination">
					<?php woocommerce_pagination(); ?>
				</div>

				<div class="clearfix"></div>

			</div>
		</div>

	</div>

<?php endif; ?>
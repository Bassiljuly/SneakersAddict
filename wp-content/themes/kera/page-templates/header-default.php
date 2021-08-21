
<div class="header-default">
    <div class="container">
        <div class="row">
			<!-- //LOGO -->
            <div class="header-logo col-md-2">
                <?php 
                	kera_tbay_get_page_templates_parts('logo'); 
                ?> 
            </div>
			
			<div class="header-mainmenu col-md-9">
				<?php kera_tbay_get_page_templates_parts('nav'); ?>
			</div>

			<div class="col-md-1">

				<?php if ( !(defined('KERA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && KERA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && defined('KERA_WOOCOMMERCE_ACTIVED') && KERA_WOOCOMMERCE_ACTIVED ): ?>
				<!-- Cart -->
				<div class="top-cart hidden-xs">
					<?php kera_tbay_get_woocommerce_mini_cart(); ?>
				</div>
				<?php endif; ?>

			</div>
        </div>
    </div>
</div>

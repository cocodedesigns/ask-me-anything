		  <?php if ( is_front_page() ) {  ?>
		  <div class="col-md-6">
			   <img class="img-responsive" src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
		   <?php } else { ?>
		   <div class="col-md-4">
		   <?php if ( ! dynamic_sidebar( 'sidebar' ) ) : ?>
		   <div class="pre-widget">
				<h3><?php _e('Widgetized Sidebar', 'chineserestaurant'); ?></h3>
				<p><?php _e('This panel is active and ready for you to add some widgets via the WP Admin', 'chineserestaurant'); ?></p>
			</div>
			<?php endif; 
			}
			?>
		  </div>
			
		 
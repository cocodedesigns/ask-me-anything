	<?php get_header(); ?>
	<div id="ktMain">
	<div class="container">
		<div class="row">
		  <div class="col-md-6">
		  <div class="row">
			<?php 
			  //Set the counter to 1
			  $i = 1;
			?>
			 <div class="col-md-4">
			<?php 
			  //Start the loop
			  if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
				  <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				   <div class="kt-article">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php if(has_post_thumbnail()) { 
						the_post_thumbnail();
						} else { ?> 
						<img class="attachment-post-thumbnail wp-post-image" src="<?php echo get_template_directory_uri(); ?>/img/noimage.png" alt="" />
						<?php } ?>
					</a>
					</div>	  
				  </div>		
			  <?php 
			  // After 3 close the row div and open a new one
			  if($i % 1 == 0) {echo '</div><div class="col-md-4">';}
			  //End stuff
			  $i++; endwhile; endif;
				?>
			</div>
			<div class="clearfix"></div>
			<?php 
            $badge_text = ketchupthemes_get_options('badge_text',THEMEPREFIX.'_general','');
            $badge_url = ketchupthemes_get_options('badge_url',THEMEPREFIX.'_general','');
            if($badge_text !="" && $badge_url !=""){?>
            <div id="kt-order-online">
            <a href="<?php echo ketchupthemes_get_options('badge_url',THEMEPREFIX.'_general','');  ?>" class="btn btn-danger">
            <?php echo  ketchupthemes_get_options('badge_text',THEMEPREFIX.'_general','');?>
            </a> 
            </div>
            <?php } ?>
			</div>
			<div class="clearfix"></div>
			<div id="kt-pagination">
				<div class="alignleft"><?php previous_posts_link(__( '&laquo; Newer posts', 'chineserestaurant' )) ?></div>
				<div class="alignright"><?php next_posts_link(__( 'Older posts &raquo;', 'chineserestaurant' )) ?></div>
			</div>
		  </div>
		  <?php get_sidebar(); ?>
		</div>
	</div>
	</div>
	<?php get_footer(); ?>   
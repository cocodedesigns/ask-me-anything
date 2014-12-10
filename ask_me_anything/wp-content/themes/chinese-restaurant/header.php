<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <?php if(ketchupthemes_get_options('favicon',THEMEPREFIX.'_general','')):?>
    <link rel="icon" href="<?php echo ketchupthemes_get_options('favicon',THEMEPREFIX.'_general',''); ?>" type="image/x-icon">
    <?php endif; ?> 
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="kt-wrapper">
	<div class="container" id="kt-logo">
		<div class="row">
			<div class="col-md-12"> 
				<h1><a href="<?php echo esc_url(home_url()); ?>">
				<?php echo get_bloginfo('name'); ?>
				</a></h1>
				<h2><?php bloginfo('description'); ?></h2>
			</div>
		</div>
	</div>
	<div id="kt-main-nav">
		<div class="container">
        <div class="row">
                <div class="col-md-12">
                
                <?php
                wp_nav_menu( array(
                'menu'              => 'primary',
                'theme_location'    => 'primary',
                'depth'             => 3,
                'container'         => false,
                'container_class'   => false,
                'fallback_cb'       =>'ketchupthemes_fallback',
                'menu_class'        => 'main-menu pull-right')
                );
                ?>
               </div>   
        </div>
    </div>  
    </div>
	
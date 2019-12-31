<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Business Roy
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="site">

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'business-roy' ); ?></a>

    <header id="masthead" class="site-header">

        <div class="nav-classic">
            <div class="container">
                <div class="row ">

                    <div class="col-lg-3 col-md-12">
                         <div class="site-branding">

                            <?php the_custom_logo(); ?>

                            <h1 class="site-title">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                    <?php bloginfo( 'name' ); ?>
                                </a>
                            </h1>
                            <?php 
                                $businessroy_description = get_bloginfo( 'description', 'display' );
                                if ( $businessroy_description || is_customize_preview() ) :?>
                                    <p class="site-description"><?php echo $businessroy_description; /* WPCS: xss ok. */ ?></p>
                            <?php endif; ?>                 
                        </div> <!-- .site-branding -->

                        <div class="header-nav-toggle">
                            <div class="one"></div>
                            <div class="two"></div>
                            <div class="three"></div>
                        </div><!-- Mobile navbar toggler -->

                    </div><!-- Col end -->
                    
                    <div class="col-lg-9 col-md-12 text-right">
                        <div class="box-header-nav main-menu-wapper">
                            <?php
                                wp_nav_menu( array(
                                        'theme_location'  => 'menu-1',
                                        'menu'            => 'primary-menu',
                                        'container'       => '',
                                        'container_class' => '',
                                        'container_id'    => '',
                                        'menu_class'      => 'main-menu',
                                    )
                                );
                            ?>
                        </div>
                    </div>

                </div><!-- .row end -->
            </div><!-- .container end -->
        </div>

    </header><!-- #masthead -->    

<?php
	if( is_front_page() ){ 
		/**
	     * Hook -  businessroy_action_banner_slider
	     *
	     * @hooked businessroy_banner_slider - 25
	     */

	    do_action('businessroy_action_banner_slider');
	}

    $breadcrumbs_enable = get_theme_mod('businessroy_enable_breadcrumbs', 'enable');

    if ($breadcrumbs_enable == 'enable') {

        if (!is_front_page() || !is_home()) {
            /**
             * @hook businessroy_breadcrumbs.
             *
             * @hooked businessroy_breadcrumbs.
             *
             */
            do_action('businessroy_breadcrumbs');
        }
    }
?>

	<div id="content" class="site-content">

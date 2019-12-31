<?php
/**
 * Business Roy functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Business Roy
 */

if ( ! function_exists( 'businessroy_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function businessroy_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Business Roy, use a find and replace
		 * to change 'business-roy' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'business-roy', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size('businessroy-medium', 375, 300, true);


		/**
		 * Enable support for post formats
		 *
		 * @link https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array( 'gallery', 'quote', 'audio', 'image', 'video' ) );


		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1'  => esc_html__( 'Primary Menu', 'business-roy' )
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'businessroy_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'businessroy_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function businessroy_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'businessroy_content_width', 640 );
}
add_action( 'after_setup_theme', 'businessroy_content_width', 0 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function businessroy_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Right Widget Sidebar Area', 'business-roy' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'business-roy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Left Widget Sidebar Area', 'business-roy' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'business-roy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area One', 'business-roy' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here.', 'business-roy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area Two', 'business-roy' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here.', 'business-roy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area Three', 'business-roy' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here.', 'business-roy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area Four', 'business-roy' ),
		'id'            => 'footer-4',
		'description'   => esc_html__( 'Add widgets here.', 'business-roy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));


}
add_action( 'widgets_init', 'businessroy_widgets_init' );


if ( ! function_exists( 'businessroy_fonts_url' ) ) :

	/**
	 * Register Google fonts for Business Roy
	 *
	 * Create your own businessroy_fonts_url() function to override in a child theme.
	 *
	 * @since Business Roy 1.0.0
	 *
	 * @return string Google fonts URL for the theme.
	 */

    function businessroy_fonts_url() {

        $fonts_url = '';

        $font_families = array();

        
        if ( 'off' !== _x( 'on', 'Roboto: on or off', 'business-roy' ) ) {
            $font_families[] = 'Roboto:400,400i,500,500i,700,700i';
        }

        if ( 'off' !== _x( 'on', 'Open Sans: on or off', 'business-roy' ) ) {
            $font_families[] = 'Open Sans:300,400,600,700,800';
        }

        if( $font_families ) {

            $query_args = array(

                'family' => urlencode( implode( '|', $font_families ) ),
                'subset' => urlencode( 'latin,latin-ext' ),
            );

            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
        }

        return esc_url ( $fonts_url );
    }

endif;

/**
 * Enqueue scripts and styles.
 */
function businessroy_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'businessroy-fonts', businessroy_fonts_url(), array(), null );

	// Load Bootstrap CSS Library File
	wp_enqueue_style( 'bootstrap', get_template_directory_uri(). '/assets/library/bootstrap/css/bootstrap' . esc_attr( $min ) . '.css');

	// Load Font-awesome CSS Library File
	wp_enqueue_style( 'fontawesome', get_template_directory_uri(). '/assets/library/fontawesome/css/all' . esc_attr( $min ) . '.css');

	// Load owl.carousel Library File
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri(). '/assets/library/owlcarousel/css/owl.carousel' . esc_attr( $min ) . '.css');

	// Load magnefic Library File
	wp_enqueue_style( 'magnefic', get_template_directory_uri(). '/assets/library/magnific-popup/magnefic' . esc_attr ( $min ) . '.css');


	wp_enqueue_style( 'businessroy-style', get_stylesheet_uri() );

	// Load responsive Library File
	wp_enqueue_style( 'responsive', get_template_directory_uri(). '/assets/css/responsive.css');

	//jquery.isotope
	wp_enqueue_script( 'isotope-pkgd', get_template_directory_uri() . '/assets/js/isotope.pkgd.js', array('jquery', 'imagesloaded' ), '1.0.0', true );

	wp_enqueue_script( 'odometer', get_template_directory_uri() . '/assets/js/odometer.js', array('jquery'), '1.0.0', true );

	//waypoints
	wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/assets//library/waypoints/waypoints' . esc_attr ( $min ) . '.js', array('jquery'), true );	

	//owl.carousel
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/library/owlcarousel/js/owl.carousel' . esc_attr ( $min ) . '.js', array('jquery'),'2.3.4', true );

	//magnific-popup
	wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/assets/library/magnific-popup/magnific-popup' . esc_attr ( $min ) . '.js', array('jquery'),'1.1.0', true );	

	//theia-sticky
	wp_enqueue_script( 'theia-sticky-sidebar', get_template_directory_uri() . '/assets/library/theia-sticky-sidebar/js/theia-sticky-sidebar' . esc_attr ( $min ) . '.js', array('jquery'), true );

	wp_enqueue_script( 'businessroy-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'business-roy', get_template_directory_uri() . '/assets/js/businessroy.js', array('jquery','masonry'), true );

	// Localize the script with new data
    $sticky_sidebar = get_theme_mod( 'businessroy_sticky_sidebar','enable' );

	wp_localize_script('business-roy', 'businessroy_script', array(
        'sticky_sidebar'=> $sticky_sidebar
    ));


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'businessroy_scripts' );


/**
 * Admin Enqueue scripts and styles.
*/
if ( ! function_exists( 'businessroy_admin_scripts' ) ) {

    function businessroy_admin_scripts( $hook ) {

    	if( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' && 'widgets.php' != $hook )

        return;

        wp_enqueue_script('businessroy-admin', get_template_directory_uri() . '/assets/js/businessroy-admin.js', array( 'jquery', 'jquery-ui-sortable', 'customize-controls' ) ); 
        wp_enqueue_style( 'businessroy-admin-style', get_template_directory_uri() . '/assets/css/businessroy-admin.css');    
    }
}
add_action('admin_enqueue_scripts', 'businessroy_admin_scripts');


/**
 * Sets the Businessroy Template Instead of front-page.
 */
function businessroy_front_page_set( $template ) {

  $businessroy_front_page = get_theme_mod( 'businessroy_enable_frontpage' ,false);

  if( true != $businessroy_front_page ){

    if ( 'posts' == get_option( 'show_on_front' ) ) {

      include( get_home_template() );

    } else {

      include( get_page_template() );
      
    }
  }
}
add_filter( 'businessroy_enable_front_page', 'businessroy_front_page_set' );


/**
 * Load Files.
 */
require get_template_directory() . '/inc/init.php';



/**
 * Fully Translation ready Multilingual Compatible with Polylang and WPML plugins.
*/

if( function_exists( 'pll_register_string' ) ){

	// Video Call To Action Section
	pll_register_string( 'video_calltoaction_title', get_theme_mod('businessroy_video_calltoaction_title'), 'Businessroy', true );
	pll_register_string( 'video_calltoaction_subtitle', get_theme_mod('businessroy_video_calltoaction_subtitle'), 'Businessroy', true );

	// Main Services Section
	pll_register_string( 'service_title', get_theme_mod('businessroy_service_title'), 'Businessroy', true );
	pll_register_string( 'service_subtitle', get_theme_mod('businessroy_service_sub_title'), 'Businessroy', true );

	// Call To Action Section
	pll_register_string( 'calltoaction_title', get_theme_mod('businessroy_calltoaction_title'), 'Businessroy', true );
	pll_register_string( 'calltoaction_subtitle', get_theme_mod('businessroy_calltoaction_subtitle'), 'Businessroy', true );
	pll_register_string( 'calltoaction_button', get_theme_mod('businessroy_calltoaction_button'), 'Businessroy', true );
	pll_register_string( 'calltoaction_button_one', get_theme_mod('businessroy_calltoaction_button_one'), 'Businessroy', true );

	// Portfolio Services Section
	pll_register_string( 'recentwork_title', get_theme_mod('businessroy_recentwork_title'), 'Businessroy', true );
	pll_register_string( 'recentwork_subtitle', get_theme_mod('businessroy_recentwork_sub_title'), 'Businessroy', true );

	// Counter Services Section
	pll_register_string( 'counter_title', get_theme_mod('businessroy_counter_title'), 'Businessroy', true );
	pll_register_string( 'counter_subtitle', get_theme_mod('businessroy_counter_sub_title'), 'Businessroy', true );

	// Blog Services Section
	pll_register_string( 'blog_title', get_theme_mod('businessroy_blog_title'), 'Businessroy', true );
	pll_register_string( 'blog_subtitle', get_theme_mod('businessroy_blog_sub_title'), 'Businessroy', true );
	pll_register_string( 'blog_readmore_btn', get_theme_mod('businessroy_blogtemplate_btn'), 'Businessroy', true );

	// Testimonial Services Section
	pll_register_string( 'testimonial_title', get_theme_mod('businessroy_testimonial_title'), 'Businessroy', true );
	pll_register_string( 'testimonial_subtitle', get_theme_mod('businessroy_testimonial_sub_title'), 'Businessroy', true );

	// Team Services Section
	pll_register_string( 'team_title', get_theme_mod('businessroy_team_title'), 'Businessroy', true );
	pll_register_string( 'team_subtitle', get_theme_mod('businessroy_team_sub_title'), 'Businessroy', true );
	

}
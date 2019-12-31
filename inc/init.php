<?php
/**
 * Main Custom admin functions area
 *
 * @param Business Roy
 *
 */


/**
 * Load Custom Themes functions that act independently of the theme functions.
 */
require get_theme_file_path('inc/themes-functions.php');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Customizer Sanitization.
 */
require get_template_directory() . '/inc/customizer/sanitize.php';

/**
 * Customizer Custom Controller.
 */
require get_template_directory() . '/inc/customizer/custom-controller.php';

/**
 * Dynamic Color.
 */
require get_template_directory() . '/inc/dynamic.php';

/**
 * Breadcrumbs.
 */
require get_template_directory() . '/inc/breadcrumbs/breadcrumbs.php';


/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {

	require get_template_directory() . '/inc/jetpack.php';
	
}
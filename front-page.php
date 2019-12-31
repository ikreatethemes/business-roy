<?php 
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Business Roy
 */
get_header();

/**
 * Enable Front Page
 */
do_action( 'businessroy_enable_front_page' );

$enable_front_page = get_theme_mod( 'businessroy_enable_frontpage' ,false);

    if ($enable_front_page == 1):

        $businessroy_home_sections = businessroy_homepage_section();

        foreach ($businessroy_home_sections as $businessroy_homepage_section) {

            $businessroy_homepage_section = str_replace('businessroy_', '', $businessroy_homepage_section);
            $businessroy_homepage_section = str_replace('_section', '', $businessroy_homepage_section);

            get_template_part( 'template-parts/section/section', $businessroy_homepage_section );
        }
        
    endif;

get_footer();
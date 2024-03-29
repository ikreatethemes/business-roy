<?php
/**
 * The template for displaying  page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Business Roy
 *
 * Template Name: Blog Template
 */

$layout = get_theme_mod( 'businessroy_blogtemplate_layout', 'none' );

$post_sidebar = esc_attr( get_post_meta($post->ID, 'businessroy_page_layouts', true ) );

if(!$post_sidebar){
    $post_sidebar =  esc_attr( get_theme_mod( 'businessroy_blog_template_sidebar','right' ) );
}


if ($post_sidebar == 'no') { 

    $colid = 12;

} elseif ($post_sidebar == 'left' || $post_sidebar == 'right'){

    $colid = 8;

}

$blog = get_theme_mod('businessroy_blogtemplate_postcat');

$blog_cat_id = explode(',', $blog);

$args = array(
    'posts_per_page' => 6,
    'post_type' => 'post',
    'paged'     => get_query_var( 'paged' ),					            
    'tax_query' => array(
        array(
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $blog_cat_id
        ),
    ),
);

get_header(); ?>

<div class="container">
	<div class="row">

		<?php if( $post_sidebar == 'left' && is_active_sidebar('sidebar-2') ){ get_sidebar('left'); } ?>
		
		<div id="primary" class="content-area col-lg-<?php echo intval ( $colid ); ?> col-md-<?php echo intval ( $colid ); ?> col-sm-12 <?php echo esc_attr( $layout  ); ?>" data-layout="<?php echo esc_attr( $layout  ); ?>">
			<main id="main" class="site-main">
				<div class="articlesListing blog-grid">	
					<?php
						query_posts( $args );

						if ( have_posts() ) :


							if( !empty( $layout ) && $layout == 'masonry2-rsidebar'){

								echo '<div class="businessroy-masonry">';
							}

								/* Start the Loop */
								while ( have_posts() ) : the_post();

									/*
									 * Include the Post-Type-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
									 */

									// Post Display Layout
									if( !empty( $layout ) && $layout == 'masonry2-rsidebar' ){
										
										get_template_part( 'template-parts/content', 'masonry' );
			
									}else {

										get_template_part( 'template-parts/content', get_post_format() );

									}

								endwhile;

							if( !empty( $layout ) && $layout == 'masonry2-rsidebar'){

								echo '</div>';
							}

							the_posts_pagination( 
			            		array(
								    'prev_text' => esc_html__( 'Prev', 'business-roy' ),
								    'next_text' => esc_html__( 'Next', 'business-roy' ),
								)
				            );

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif;
					?>
				</div><!-- Articales Listings -->

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php if( $post_sidebar == 'right' && is_active_sidebar('sidebar-1') ){ get_sidebar('right'); } ?>

	</div>
</div>

<?php get_footer();
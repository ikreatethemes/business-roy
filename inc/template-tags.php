<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Business Roy
 */

if ( ! function_exists( 'businessroy_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function businessroy_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( ' %s', 'post date', 'business-roy' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<div><span class="posted-on">' . $posted_on . '</span></div>'; // WPCS: XSS OK.

	}
endif;


if ( ! function_exists( 'businessroy_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function businessroy_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( ' %s', 'post author', 'business-roy' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<div><span class="byline"> ' . $byline . '</span></div>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'businessroy_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function businessroy_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'business-roy' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'business-roy' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'business-roy' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'business-roy' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'business-roy' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'business-roy' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'businessroy_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function businessroy_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<div class="blog-post-thumbnail">
				<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php
						the_post_thumbnail( 'post-thumbnail' );
					?>
				</a>
			</div>
			
		<?php

		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'businessroy_comments' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function businessroy_comments() {

		echo '<span class="comments-link"><i class="fa fa-comments"></i> ';
			
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'business-roy' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);

		echo '</span>'; // WPCS: XSS OK.

	}
endif;

/**
 * Category Lists.
 */
if ( ! function_exists( 'businessroy_category' ) ) :

	function businessroy_category() {
	/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'business-roy' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links"><i class="fas fa-folder-open"></i>' . '%1$s' . '</span>', $categories_list ); // WPCS: XSS OK.
		}
	}
endif;


/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function businessroy_excerpt_length( $length ) {

	$excerpt_length = get_theme_mod( 'businessroy_post_excerpt_length', 40 );
	
  if( is_admin() ){

    return $length;
    
  }elseif( is_front_page() ){

  	return 18;

  }else{

    return $excerpt_length;

  }

}
add_filter( 'excerpt_length', 'businessroy_excerpt_length', 999 );

/**
 * Filter the excerpt "read more" string.
 *
 * @param string $text "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function businessroy_excerpt_more($text){

    if(is_admin()){

        return $text;
    }

    return '&hellip;';
}
add_filter( 'excerpt_more', 'businessroy_excerpt_more' );
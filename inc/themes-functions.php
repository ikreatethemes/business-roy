<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @subpackage Business Roy
 *
 * @since 1.0.0
 *
 */
if ( ! function_exists( 'businessroy_section_title' ) ){
    /**
     * Section Main Title
     *
     * @since 1.0.0
     */
    function businessroy_section_title( $title, $sub_title ) { 

        if( !empty( $title ) || !empty( $sub_title ) ){ ?>

            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">

                    <?php if( !empty( $title ) ){ if( function_exists( 'pll_register_string' ) ){ ?>

                        <h2 class="section-title"><?php echo esc_html( pll__( $title ) ); ?></h2>

                    <?php }else{ ?>

                        <h2 class="section-title"><?php echo esc_html( $title ); ?></h2>

                    <?php } } if( !empty( $sub_title ) ){ if( function_exists( 'pll_register_string' ) ){ ?>

                          <div class="section-tagline"><?php echo esc_html( pll__( $sub_title ) ); ?></div>

                    <?php }else{ ?>

                            <div class="section-tagline"><?php echo esc_html( $sub_title ); ?></div>

                    <?php } } ?>

                </div>
            </div>
        <?php }
    }
}


if ( ! function_exists( 'businessroy_post_meta' ) ){
    /**
     * Post Meta Function
     *
     * @since 1.0.0
     */
    function businessroy_post_meta() { 
        
        $postdate    = get_theme_mod( 'businessroy_post_date_options', 'enable' );
        $postcomment = get_theme_mod( 'businessroy_post_comments_options', 'enable' );
        $postauthor  = get_theme_mod( 'businessroy_post_author_options', 'enable' );

      ?>

        <div class="entry-meta info">
            <?php
                if( !empty( $postdate ) && $postdate == 'enable' ) { businessroy_posted_on(); }
                if( !empty( $postauthor ) && $postauthor == 'enable' ) { businessroy_posted_by(); }
                if( !empty( $postcomment ) && $postcomment == 'enable' ) { businessroy_comments(); }
            ?>
        </div><!-- .entry-meta -->

       <?php
    }
}
add_action( 'businessroy_post_meta', 'businessroy_post_meta' , 10 );


if( ! function_exists( 'businessroy_post_format_media' ) ) :

    /**
     * Posts format declaration function.
     *
     * @since 1.0.0
     */
    function businessroy_post_format_media( $postformat ) {

        global $post;

        if( is_singular( ) ){

          $imagesize = 'post-thumbnail';

        }else{

            $imagesize = '';
        }

        if ($postformat == "gallery") {

            if (function_exists('has_block') && has_block('gallery', $post->post_content)) {

                $post_blocks = parse_blocks($post->post_content);

                $key = array_search('core/gallery', array_column($post_blocks, 'blockName'));
                
                $gallery_attachment_ids = $post_blocks[$key]['attrs']['ids'];

            }else {
                
                $gallery = get_post_gallery( $post->ID, false );

                $gallery_attachment_ids = array();

                if( count($gallery) and isset($gallery['ids'])) {

                    $gallery_attachment_ids = explode ( ",", $gallery['ids'] );

                }
            }

            if ( ! empty( $gallery_attachment_ids ) ){ ?>

                <div class="postgallery-carousel owl-carousel">

                    <?php foreach ( $gallery_attachment_ids as $gallery_attachment_id ) { ?>
                        
                        <img src="<?php echo wp_get_attachment_image_url($gallery_attachment_id, $imagesize); ?>"/>
                        
                    <?php } ?>

                </div>
                
            <?php } else { ?>
                
                <div class="blog-post-thumbnail">
                    <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                        <?php
                          the_post_thumbnail( $imagesize );
                        ?>
                    </a>
                </div>

            <?php } } else if( $postformat == "video" ){
            
            $get_content  = apply_filters( 'the_content', get_the_content() );
            $get_video    = get_media_embedded_in_content( $get_content, array( 'video', 'object', 'embed', 'iframe' ) );

            if( !empty( $get_video ) ){ ?>

                <div class="video">
                    <?php echo $get_video[0]; // WPCS xss ok. ?>
                </div>

        <?php }else{ ?>

                <div class="blog-post-thumbnail">
                    <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                        <?php
                          the_post_thumbnail( $imagesize );
                        ?>
                    </a>
                </div>

        <?php  } }else if( $postformat == "audio" ){

            $get_content  = apply_filters( 'the_content', get_the_content() );
            $get_audio    = get_media_embedded_in_content( $get_content, array( 'audio', 'iframe' ) );

            if( !empty( $get_audio ) ){ ?>

                <div class="audio">
                    <?php echo $get_audio[0]; // WPCS xss ok. ?>
                </div>

        <?php }else{  ?>

                <div class="blog-post-thumbnail">
                    <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                        <?php
                          the_post_thumbnail( $imagesize );
                        ?>
                    </a>
                </div>

        <?php } }else if( $postformat == "quote" ) { ?>

                <div class="post-format-media-quote">
                    <blockquote>
                        <?php the_content(); ?>
                    </blockquote>
                </div>

        <?php }else{ ?>

                <div class="blog-post-thumbnail">
                    <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                        <?php
                          the_post_thumbnail( $imagesize );
                        ?>
                    </a>
                </div>

        <?php }

    }

endif;


if ( ! function_exists( 'businessroy_footer_copyright' ) ){

    /**
     * Footer Copyright Information
     *
     * @since 1.0.0
     */
    function businessroy_footer_copyright() {

        echo esc_html( apply_filters( 'businessroy_copyright_text', $content = esc_html__('Copyright  &copy; ','business-roy') . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) .' - ' ) );

         printf( ' WordPress Theme : by %1$s', '<a href=" ' . esc_url('https://ikreatethemes.com/') . ' " rel="designer" target="_blank">'.esc_html__('Ikreate Themes','business-roy').'</a>' );
    }
}
add_action( 'businessroy_copyright', 'businessroy_footer_copyright', 5 );



/**
 * Breadcrumbs Section.
*/
if (! function_exists( 'businessroy_breadcrumbs' ) ):

    function businessroy_breadcrumbs(){

        $breadcrumb_image = get_theme_mod('businessroy_breadcrumbs_image'); ?>

            <section class="breadcrumb" style="background-image: url(<?php echo esc_url($breadcrumb_image); ?>);">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12 col-sm-12 col-xs-12 breadcrumb_wrapper">
                            <?php
                                if (is_single() || is_page()) {

                                    the_title('<h2 class="entry-title">', '</h2>');

                                } elseif (is_archive()) {

                                    the_archive_title('<h2 class="page-title">', '</h2>');
                                    the_archive_description('<div class="taxonomy-description">', '</div>');

                                } elseif (is_search()) { ?>

                                    <h2 class="page-title">
                                        <?php printf(esc_html__('Search Results for:', 'business-roy'), '%s', '<span>' . get_search_query() . '</span>'); ?>
                                    </h2>

                                <?php } elseif (is_404()) {

                                    echo '<h2 class="entry-title">' . esc_html('404 Error', 'business-roy') . '</h2>';

                                } elseif (is_home()) {

                                $page_for_posts_id = get_option('page_for_posts');
                                $page_title = get_the_title($page_for_posts_id);

                            ?>
                                    <h2 class="entry-title"><?php echo esc_html($page_title); ?></h2>

                            <?php }else{ ?>

                                    <h2 class="entry-title"><?php echo esc_html($page_title); ?></h2>

                            <?php } ?>

                                <nav id="breadcrumb" class="cp-breadcrumb">
                                    <?php
                                        breadcrumb_trail(array(
                                            'container' => 'div',
                                            'show_browse' => false,
                                        ));
                                    ?>
                                </nav>
                        </div>
                    </div>
                </div>
            </section>
        <?php
    }
endif;
add_action('businessroy_breadcrumbs', 'businessroy_breadcrumbs', 100);



/**
 * Main Slider Function Area
*/
if (! function_exists( 'businessroy_banner_slider' ) ):

    function businessroy_banner_slider(){ ?>

        <div id="banner-slider" class="banner-slider owl-carousel features-slider">
            <?php 
                $all_slider = get_theme_mod('businessroy_slider');

                if ($all_slider) {

                $banner_slider = json_decode( $all_slider );

                foreach ($banner_slider as $slider) {

                    $page_id = $slider->slider_page;

                if (!empty($page_id)) {

                    $slider_page = new WP_Query('page_id=' . $page_id);

                    if ($slider_page->have_posts()) { while ($slider_page->have_posts()) { $slider_page->the_post();
            ?>
                <div class="slider-item" style="background-image: url(<?php the_post_thumbnail_url(); ?>);">
                    <div class="banner-table">
                        <div class="banner-table-cell">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-8 mx-auto">
                                        <div class="slider-content">
                                            <h2 class="slider-title">
                                                <?php the_title(); ?>
                                            </h2>
                                            <?php the_excerpt(); ?>
                                        </div> <!-- slider content end-->
                                    </div> <!-- col end-->
                                </div> <!-- row end-->
                            </div><!-- container end -->
                        </div><!-- banner table cell end -->
                    </div><!-- banner table end -->
                </div>
            <?php } } } } } ?>
        </div><!-- Slider section end -->

    <?php }
endif;
add_action('businessroy_action_banner_slider', 'businessroy_banner_slider', 25);


/**
 * Our Service Featues Section.
*/
if (! function_exists( 'businessroy_promo_service' ) ):

    function businessroy_promo_service(){

        $features_options = get_theme_mod('businessroy_features_service_section','enable');
        $display_width = get_theme_mod('businessroy_promoservice_container_options','nocontainer');

        $block_space = get_theme_mod('businessroy_promoservice_gutters','no-gutters');
        
        if( !empty( $features_options ) && $features_options == 'enable' ){ ?>

        <section id="businessroyfeature" class="businessroyfeature">
            <div class="<?php echo esc_attr(  $display_width ); ?>">
                <div class="row">
                    <?php
                        $promo_service = get_theme_mod('businessroy_promo_service');
                        $count = 1;
                        if (!empty($promo_service)):

                        $pages = json_decode($promo_service);

                        foreach ($pages as $page):

                        $page_id = $page->promoservice_page;

                        if (!empty($page_id)):

                            $service_query = new WP_Query('page_id=' . $page_id);

                            if ( $service_query->have_posts() ): while ( $service_query->have_posts() ): $service_query->the_post();
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 feature-list <?php echo esc_attr( $block_space ); ?>">
                            <div class="box prime-column-<?php echo intval( $count ); ?>">
                                <div class="bottom-content">
                                    <div class="icon-box">
                                        <i class="<?php echo esc_attr( $page->promoservice_icon ); ?>"></i>
                                    </div>

                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                        </div>
                    <?php  $count++; endwhile;  endif; endif; endforeach; endif; ?>
                </div>
            </div>
        </section>

        <?php } }
endif;
add_action('businessroy_action_promo_service', 'businessroy_promo_service', 30);


/**
 * About Us Section.
*/
if (! function_exists( 'businessroy_about' ) ):

    function businessroy_about(){ 

        $aboutus_options = get_theme_mod('businessroy_aboutus_service_section','enable');
        
        if( !empty( $aboutus_options ) && $aboutus_options == 'enable' ){ ?>

        <section id="about_us_front" class="about_us_front">
            <div class="container">
                <div class="row">
                    <?php
                        $aboutus = get_theme_mod('businessroy_aboutus');

                        if (!empty( $aboutus ) ):

                        $aboutus_args = array(
                            'posts_per_page' => 1,
                            'post_type' => 'page',
                            'page_id' => $aboutus,
                            'post_status' => 'publish',
                        );

                        $aboutus_query = new WP_Query($aboutus_args);

                        if ( $aboutus_query->have_posts() ) : while ( $aboutus_query->have_posts() ) : $aboutus_query->the_post();
                    
                        $about_image = get_theme_mod('businessroy_aboutus_image');

                        $about_col = '';
                        if( !empty( $about_image ) ){
                            $about_col = 7;
                        }else{
                            $about_col = 12;
                        }
                    ?>
                        <div class="col-lg-<?php echo intval( $about_col ); ?> col-md-<?php echo intval( $about_col ); ?> col-sm-12">
                            <h2><?php the_title(); ?></h2>
                            <div><?php the_content(); ?></div>
                        </div>

                        <?php if (!empty($about_image)): ?>
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <div class="aboutimgwrap"><img src="<?php echo esc_url( wp_get_attachment_url( $about_image ) ); ?>"/></div>
                            </div>
                        <?php endif; ?>

                    <?php endwhile; endif; endif; ?>
                </div>
            </div>
        </section>

    <?php } }
endif;
add_action('businessroy_action_about', 'businessroy_about', 35);


/**
 * Video Call To Action Section.
*/
if (! function_exists( 'businessroy_video_calltoaction' ) ):

    function businessroy_video_calltoaction(){

        if( function_exists( 'pll_register_string' ) ){

            $video_cta_title = pll__( get_theme_mod('businessroy_video_calltoaction_title') );
            $video_cta_sub_title = pll__( get_theme_mod('businessroy_video_calltoaction_subtitle') );
        
        }else{

            $video_cta_title     = get_theme_mod( 'businessroy_video_calltoaction_title' );
            $video_cta_sub_title = get_theme_mod( 'businessroy_video_calltoaction_subtitle' );

        }

        $video_cta_bg_image  = get_theme_mod('businessroy_video_calltoaction_image');
        $yourtube_video_url  = get_theme_mod('businessroy_video_button_url');
        $video_cta_options = get_theme_mod('businessroy_video_cta_service_section','enable');

        if( !empty( $video_cta_options ) && $video_cta_options == 'enable' ){ ?>

            <div id="calltoactionvideo_promo_wrapper" class="calltoaction_promo_wrapper video_calltoaction" style="background-image:url(<?php echo esc_url( $video_cta_bg_image ); ?>);background-repeat:no-repeat;background-size:cover;background-attachment:fixed;background-position: center;">
                <div class="container">
                    
                    <div class="video_calltoaction_wrap">
                        <a href="<?php echo esc_url( $yourtube_video_url ); ?>" target="_blank" class="popup-youtube  box-shadow-ripples"><i class="fas fa-play "></i></a>
                    </div>

                    <div class="calltoaction_full_widget_content">

                        <h2><?php echo esc_html( $video_cta_title ); ?></h2>

                        <div class="calltoaction_subtitle">
                            <p><?php echo esc_html( $video_cta_sub_title ); ?></p>
                        </div>
                    </div>

                </div>
            </div>

    <?php } }
endif;
add_action('businessroy_action_video_calltoaction', 'businessroy_video_calltoaction', 40);


/**
 * Our Main Service Section.
*/
if (! function_exists( 'businessroy_service' ) ):
    function businessroy_service(){

        $title          = get_theme_mod('businessroy_service_title');
        $sub_title      = get_theme_mod('businessroy_service_sub_title');
        $service_layout = get_theme_mod('businessroy_service_layout', 'layout_one');
        $service_page   = get_theme_mod('businessroy_service');
        
        $services_options = get_theme_mod('businessroy_service_service_section','enable');
        
        if( !empty( $services_options ) && $services_options == 'enable' ){ ?>

        <section id="businessroyservices" class="businessroyservices <?php echo esc_attr( $service_layout ); ?>">
            <div class="container">
                
                <?php businessroy_section_title( $title, $sub_title ); ?>

                <div class="row">
                    <?php
                        if (!empty($service_page)):

                        $pages = json_decode($service_page);

                        foreach ($pages as $page):

                            $page_id = $page->service_page;

                            if (!empty($page_id)):

                            $service_query = new WP_Query('page_id=' . $page_id);

                            if ( $service_query->have_posts() ): while ( $service_query->have_posts() ): $service_query->the_post();

                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 feature-list">
                            <div class="box">
                                <?php if( !empty( $service_layout ) && $service_layout == 'layout_one' ){ ?>
                                    <figure>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('businessroy-medium'); ?>
                                        </a>
                                    </figure>
                                <?php } ?>

                                <div class="bottom-content">

                                    <?php if( !empty( $service_layout ) && $service_layout == 'layout_two' ){ ?>
                                        <div class="icon-box">
                                            <i class="<?php echo esc_attr($page->service_icon); ?>"></i>
                                        </div>
                                    <?php } ?>

                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                    <?php the_excerpt(); ?>


                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                        <?php echo esc_html(get_theme_mod('businessroy_service_button','Read More')); ?>
                                        <i class="fas fa-angle-double-right"></i>
                                    </a>

                                </div>
                            </div>
                        </div>
                       
                    <?php endwhile; endif; endif; endforeach; endif; ?>
                </div>
            </div>
        </section>

    <?php } }
endif;
add_action('businessroy_action_service', 'businessroy_service', 45);


/**
 * Call To Action Section.
*/
if (! function_exists( 'businessroy_calltoaction' ) ):

    function businessroy_calltoaction(){

        if( function_exists( 'pll_register_string' ) ){

            $cta_title       = pll__( get_theme_mod( 'businessroy_calltoaction_title' ) );
            $cta_sub_title   = pll__( get_theme_mod( 'businessroy_calltoaction_subtitle' ) );
            $button_text     = pll__( get_theme_mod('businessroy_calltoaction_button') );
            $button_text_one = pll__( get_theme_mod('businessroy_calltoaction_button_one') );
        
        }else{

            $cta_title       = get_theme_mod( 'businessroy_calltoaction_title' );
            $cta_sub_title   = get_theme_mod( 'businessroy_calltoaction_subtitle' );
            $button_text     = get_theme_mod('businessroy_calltoaction_button');
            $button_text_one = get_theme_mod('businessroy_calltoaction_button_one');

        }

        $cta_bg_image     = get_theme_mod('businessroy_calltoaction_image');
        $button_link      = get_theme_mod('businessroy_calltoaction_link');
        $button_link_one  = get_theme_mod('businessroy_calltoaction_link_one');
        $cta_options      = get_theme_mod('businessroy_cta_service_section','enable');

        if( !empty( $cta_options ) && $cta_options == 'enable' ){ ?>

            <div id="calltoaction_promo_wrapper" class="calltoaction_promo_wrapper" style="background-image:url(<?php echo esc_url( $cta_bg_image ); ?>);background-repeat:no-repeat;background-size:cover;background-attachment:fixed;background-position: center;">
                <div class="container">
                    <div class="calltoaction_full_widget_content">

                        <h2><?php echo esc_html( $cta_title ); ?></h2>

                        <div class="calltoaction_subtitle">
                            <p><?php echo esc_html( $cta_sub_title ); ?></p>
                        </div>
                    </div>

                    <div class="calltoaction_button_wrap">
                        <?php if( !empty( $button_text ) ){ ?>

                            <a href="<?php echo esc_url( $button_link ); ?>" class="btn btn-primary">
                                <?php echo esc_html( $button_text ); ?> <i class="fas fa-angle-double-right"></i>
                            </a>

                        <?php } if( !empty( $button_text_one ) ){ ?>

                            <a href="<?php echo esc_url( $button_link_one ); ?>" class="btn btn-border">
                                <?php echo esc_html( $button_text_one ); ?> <i class="fas fa-angle-double-right"></i>
                            </a>

                        <?php } ?>

                    </div>
                </div>
            </div>

    <?php } }
endif;
add_action('businessroy_action_calltoaction', 'businessroy_calltoaction', 50);


/**
 *  Our Work Portfolio Section.
*/
if (! function_exists( 'businessroy_recentwork' ) ):

    function businessroy_recentwork() {

        $title = get_theme_mod('businessroy_recentwork_title');
        $sub_title = get_theme_mod('businessroy_recentwork_sub_title');

        $businessroyportfolio_cat = get_theme_mod('businessroy_recent_work');

        $portfolio_options = get_theme_mod('businessroy_portfolio_section','enable');

        if( !empty( $portfolio_options ) && $portfolio_options == 'enable' ){ ?>

        <section id="businessroyportfolio" class="businessroyportfolio-section clearfix">
            <div class="container">

                <?php businessroy_section_title( $title, $sub_title ); ?>

                <?php
                    if($businessroyportfolio_cat){
                    $businessroyportfolio_cat_array = explode(',', $businessroyportfolio_cat) ;
                ?>  
                    <div class="businessroyportfolio-cat-name-list">
                        <!-- <div class="businessroyportfolio-cat-name active" data-filter="*"><?php echo esc_html_e('All Works','business-roy'); ?></div> -->
                        <?php 
                            foreach ($businessroyportfolio_cat_array as $businessroyportfolio_cat_single) {

                                $category_slug = "";
                                $category_slug = get_category($businessroyportfolio_cat_single);

                                if( is_object($category_slug)){

                                $category_slug = 'portfolio-'.$category_slug->term_id;
                        ?>
                                <div class="businessroyportfolio-cat-name" data-filter=".<?php echo esc_attr($category_slug); ?>">
                                    <?php echo esc_html(get_cat_name($businessroyportfolio_cat_single)); ?>
                                </div>

                        <?php } } ?>
                    </div>
                <?php } ?>

                <div class="businessroyportfolio-post-wrap clearfix">
                    <div class="businessroyportfolio-posts clearfix">
                        <?php 
                            if($businessroyportfolio_cat){
                            $count = 1;
                            $args = array( 'cat' => $businessroyportfolio_cat, 'posts_per_page' => -1 );
                            $query = new WP_Query($args);

                            if($query->have_posts()): while($query->have_posts()) : $query->the_post(); 

                                $categories = get_the_category();
                                $category_slug = "";
                                $cat_slug = array();

                            foreach ($categories as $category) {
                                $cat_slug[] = 'portfolio-'.$category->term_id;
                            }

                            $category_slug = implode(" ", $cat_slug);

                            if(has_post_thumbnail()){
                                $image_url = get_template_directory_uri().'/assets/images/portfolio-small-blank.png';
                                $businessroyimage = wp_get_attachment_image_src(get_post_thumbnail_id(),'businessroy-medium');    
                                $businessroyimage_large = wp_get_attachment_image_src(get_post_thumbnail_id(),'businessroy-medium');
                            }else{
                                $image_url = get_template_directory_uri().'/assets/images/portfolio-small.png';
                                $businessroyimage = "";
                            }

                        ?>
                            <div class="businessroyportfolio <?php echo esc_attr($category_slug); ?>">
                                <div class="businessroyportfolio-outer-wrap">
                                    <div class="businessroyportfolio-wrap" style="background-image: url(<?php echo esc_url( $businessroyimage[0] ) ?>);">
                                    
                                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php esc_attr(get_the_title()); ?>">

                                        <div class="businessroyportfolio-caption">

                                            <h3><?php the_title(); ?></h3>

                                            <a class="businessroyportfolio-link" href="<?php echo esc_url(get_permalink()); ?>"><i class="fa fa-link"></i></a>
                                            
                                            <?php if(has_post_thumbnail()){ ?>
                                                <a class="businessroyportfolio-image"  href="<?php echo esc_url( $businessroyimage_large[0] ) ?>"><i class="fas fa-expand"></i></a>
                                            <?php } ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endwhile; endif; wp_reset_postdata(); } ?>
                    </div>
                </div>

            </div>
        </section>

    <?php } }
endif;
add_action('businessroy_action_recentwork', 'businessroy_recentwork', 55);


/**
 *  Success Product Counter Section.
*/
if (! function_exists( 'businessroy_counter' ) ):

    function businessroy_counter(){
        
        $title = get_theme_mod('businessroy_counter_title');
        $sub_title = get_theme_mod('businessroy_counter_sub_title');

        $counter_bg = get_theme_mod('businessroy_counter_image');

        $counter_options = get_theme_mod('businessroy_counter_section','enable');
        if( !empty( $counter_options ) && $counter_options == 'enable' ){ ?>

        <section id="businessroycounter_wrap" class="businessroycounter_wrap" style="background-image:url(<?php echo esc_url( $counter_bg ); ?>);">
            <div class="container">

                <?php businessroy_section_title( $title, $sub_title ); ?>

                <div class="row businessroyteam-counter-wrap">
                    <?php
                        $counter_page = get_theme_mod('businessroy_counter');

                        if (!empty($counter_page)):

                        $counters = json_decode($counter_page);
                        $i = 1;
                        foreach ( $counters as $counter ):
                    ?>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="businessroycounter">
                                <div class="businessroycounter-count odometer odometer<?php echo esc_attr($i); ?>" data-count="<?php echo absint($counter->counter_number); ?>">
                                    99
                                </div>
                                <h6 class="businessroycounter-title">
                                    <?php echo esc_html( $counter->counter_title ); ?>
                                </h6>
                            </div>
                        </div>
                    <?php  $i++; endforeach; endif; ?>
                </div>
            </div>
        </section>

    <?php } }
endif;
add_action('businessroy_action_counter', 'businessroy_counter', 60);


/**
 *  Blog Section.
*/
if (! function_exists( 'businessroy_blog' ) ):
    function businessroy_blog(){

        $title = get_theme_mod('businessroy_blog_title');
        $sub_title = get_theme_mod('businessroy_blog_sub_title');

        if( function_exists( 'pll_register_string' ) ){ 

            $blogreadmore_btn = pll__( get_theme_mod( 'businessroy_blogtemplate_btn', 'Continue Reading' ) );

        }else{ 

            $blogreadmore_btn = get_theme_mod( 'businessroy_blogtemplate_btn', 'Continue Reading' );

        }

        $blog_options = get_theme_mod('businessroy_home_blog_section','enable');

        if( !empty( $blog_options ) && $blog_options == 'enable' ){ ?>

        <section id="businessroyblog" class="businessroyblog-list-area">
            <div class="container">

                <?php businessroy_section_title( $title, $sub_title ); ?>

                <div class="row">
                    <?php
                        $blog = get_theme_mod('businessroy_blog');
                        $cat_id = explode(',', $blog);
                        $blog_posts = get_theme_mod('businessroy_posts_num', 'three');

                        if ($blog_posts == 'three') {

                            $post_num = 3;

                        } else {

                            $post_num = 6;

                        }

                        $args = array(
                            'posts_per_page' => $post_num,
                            'post_type' => 'post',
                            'tax_query' => array(

                                array(
                                    'taxonomy' => 'category',
                                    'field' => 'term_id',
                                    'terms' => $cat_id
                                ),
                            ),
                        );

                        $blog_query = new WP_Query ($args);

                        if ( $blog_query->have_posts() ): while ( $blog_query->have_posts() ) : $blog_query->the_post();
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 articlesListing blog-grid">
                            <article id="post-<?php the_ID(); ?>" <?php post_class('article'); ?>>
                                <div class="blog-post-thumbnail">
                                    <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                        <?php the_post_thumbnail('businessroy-medium'); ?>
                                    </a>
                                </div>
                                <div class="box">
                                    <?php 

                                        the_title( '<h3 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); 

                                        if ( 'post' === get_post_type() ){ do_action( 'businessroy_post_meta', 10 ); } 
                                    ?>
                                    
                                    <div class="entry-content">
                                        <?php the_excerpt(); ?>
                                    </div>

                                    <div class="btns text-center">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                            <span><?php echo esc_html( $blogreadmore_btn ); ?> <i class="fas fa-angle-double-right"></i></span>
                                        </a>
                                    </div>
                                    
                                </div>

                            </article><!-- #post-<?php the_ID(); ?> -->
                        </div>
                    <?php endwhile; endif; ?>
                </div>
            </div>
        </section>

    <?php } }
endif;
add_action('businessroy_action_blog', 'businessroy_blog', 65);


/**
 *  Testimonial Section.
*/
if (! function_exists( 'businessroy_testimonial' ) ):
    function businessroy_testimonial(){

        $title = get_theme_mod('businessroy_testimonial_title');
        $sub_title = get_theme_mod('businessroy_testimonial_sub_title');

        $testimonial_bg = get_theme_mod('businessroy_testimonials_image');
        $testimonial_page = get_theme_mod('businessroy_testimonials'); 

        $testimonial_options = get_theme_mod('businessroy_testimonial_options','enable');
        if( !empty( $testimonial_options ) && $testimonial_options == 'enable' ){ ?>

        <section id="businessroytestimonial" class="businessroytestimonial" style="background-image:url(<?php echo esc_url( $testimonial_bg ); ?>);">
            <div class="container">

                <?php businessroy_section_title( $title, $sub_title ); ?>

                <div class="row">
                    <div class="owl-carousel owl-theme testimonial_slider">
                        <?php
                            if (!empty($testimonial_page)):

                            $testimonial_pages = json_decode($testimonial_page);

                            foreach ($testimonial_pages as $testimonial_page):

                            $page_id = $testimonial_page->testimonial_page;

                            if (!empty($page_id)):

                            $testimonial_query = new WP_Query('page_id=' . $page_id);

                            if ( $testimonial_query->have_posts() ): while ($testimonial_query->have_posts()): $testimonial_query->the_post();
                        ?>
                            <div class="testimonialbox">
                                <p><?php echo esc_html( wp_trim_words( get_the_content(), 25, '.' ) );?></p>
                                <div class="testimonialwrap">
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                    <div class="testimonialtitle">
                                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <div class="designation"><?php echo esc_html( $testimonial_page->designation ); ?></div>
                                    </div>
                                </div>
                            </div>

                        <?php endwhile; endif; endif; endforeach; endif; ?>

                    </div>
                </div>
            </div>
        </section>

    <?php } }
endif;
add_action('businessroy_action_testimonial', 'businessroy_testimonial', 70);


/**
 *  Our Team Member Section
*/
if (! function_exists( 'businessroy_team' ) ):
    function businessroy_team(){

        $title = get_theme_mod('businessroy_team_title');
        $sub_title = get_theme_mod('businessroy_team_sub_title');

        $team_page = get_theme_mod('businessroy_team');

        $team_options = get_theme_mod('businessroy_team_options','enable');
        if( !empty( $team_options ) && $team_options == 'enable' ){ ?>

        <section id="businessroyteam" class="businessroyteam">
            <div class="container">
                
                <?php businessroy_section_title( $title, $sub_title ); ?>

                <div class="row">
                    <?php

                        if (!empty( $team_page ) ):

                        $team_pages = json_decode($team_page);

                        foreach ($team_pages as $team_page):
                        
                        $page_id = $team_page->team_page;

                            if (!empty( $page_id )):

                            $team_query = new WP_Query('page_id=' . $page_id);

                            if ($team_query->have_posts()): while ($team_query->have_posts()): $team_query->the_post();
                    ?>

                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="teamwrap">
                                <figure>
                                    <?php the_post_thumbnail('businessroy-medium'); ?>
                                </figure>

                                <div class="teamdesc">

                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

                                    <?php if (!empty( $team_page->designation ) ): ?>

                                        <span><?php echo esc_html($team_page->designation); ?></span>

                                    <?php endif; ?>

                                    <?php the_excerpt(); ?>

                                    <ul class="sp_socialicon">
                                        <?php if (!empty( $team_page->facebook ) ) : ?>
                                            <li>
                                                <a href="<?php echo esc_url( $team_page->facebook ); ?>">
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                            </li>
                                        <?php endif; if (!empty( $team_page->twitter ) ) : ?>
                                            <li>
                                                <a href="<?php echo esc_url($team_page->twitter); ?>">
                                                    <i class="fab fa-twitter"></i>
                                                </a>
                                            </li>
                                        <?php endif; if (!empty( $team_page->linkedin ) ) : ?>
                                            <li>
                                                <a href="<?php echo esc_url($team_page->linkedin); ?>">
                                                    <i class="fab fa-linkedin-in"></i>
                                                </a>
                                            </li>
                                        <?php endif; if (!empty( $team_page->instagram ) ) : ?>
                                            <li>
                                                <a href="<?php echo esc_url($team_page->instagram); ?>">
                                                    <i class="fab fa-instagram"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>

                                </div>
                            </div>
                        </div>

                    <?php endwhile; endif; endif; endforeach; endif; ?>
                </div>
            </div>
        </section>

    <?php } }
endif;
add_action('businessroy_action_team', 'businessroy_team', 75);
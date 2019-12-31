<?php
/**
 * Dynamic css
*/
if (! function_exists('businessroy_dynamic_css')){

	function businessroy_dynamic_css(){

    
        $service_bg_color    = get_theme_mod('businessroy_service_bg_color','#004A8D');
        $service_fonts_color = get_theme_mod('businessroy_service_text_color','#ffffff');
        $fservices_toppadding = get_theme_mod('businessroy_promoservice_top_padding',0);
        $px = 'px';


        $primary_color    = get_theme_mod('businessroy_primary_color','#165da5');

		$businessroy_dynamic = '';

        /**
         * Theme Primary Color
        */

        // Theme Primary Background Colors.
        $businessroy_dynamic .= ".nav-classic .site-branding a:before, .nav-classic .site-branding, .box-header-nav .main-menu .page_item.current_page_item>a, .box-header-nav .main-menu .page_item:hover>a, .box-header-nav .main-menu>.menu-item.current-menu-item>a, .box-header-nav .main-menu>.menu-item:hover>a, .box-header-nav .main-menu .children>.page_item:hover>a, .box-header-nav .main-menu .sub-menu>.menu-item:hover>a, .nav-classic .header-nav-toggle div, .banner-slider.owl-carousel button.owl-dot, .video_calltoaction_wrap .box-shadow-ripples, .btn-primary, .btn-border:hover, .businessroyportfolio-cat-name, .articlesListing .article .info div:after, .widget_product_search a.button, .widget_product_search button, .widget_product_search input[type='submit'], .widget_search .search-submit, .page-numbers, a.button, button, input[type='submit'], .reply .comment-reply-link, .wpcf7 input[type='submit'], .wpcf7 input[type='button']{
            
            background-color: $primary_color;
            
        }\n";

        /*$businessroy_dynamic .= ".businessroyportfolio-caption{
            
            background-color: rgba($primary_color, 0.75);
            
        }\n";*/

        


        // Theme Primary Font Colors.
        $businessroy_dynamic .= ".businessroyservices.layout_two .feature-list .bottom-content a:hover, .businessroyportfolio-cat-name:hover, .businessroyportfolio-cat-name.active, .businessroyportfolio-cat-name-list .businessroyportfolio-cat-name:first-child, .businessroyportfolio-caption a, a:hover, a:focus, a:active, .businessroyteam .teamwrap .teamdesc h4 a:hover, .businessroyteam .teamwrap .teamdesc span, .site-footer .widget a:hover, .site-footer .widget a:hover::before, .site-footer .widget li:hover::before, .site-footer .textwidget ul li a, .businessroycopyright a, .businessroycopyright a.privacy-policy-link:hover, .widget-area .widget a:hover, .widget-area .widget a:hover::before, .widget-area .widget li:hover::before, .breadcrumb ul li, .breadcrumb ul li a:hover, .page-numbers.current, .page-numbers:hover, .prevNextArticle a:hover, .logged-in-as a, .wpcf7 input[type='submit']:hover, .wpcf7 input[type='button']:hover{

            color: $primary_color;
            
        }\n";

        $businessroy_dynamic .= "@media (max-width: 992px){
            .box-header-nav .main-menu .children>.page_item:hover>a, .box-header-nav .main-menu .sub-menu>.menu-item:hover>a {

                color: $primary_color !important;
            }
        }\n";


        // Theme Primary Border Colors.
        $businessroy_dynamic .= ".btn-primary, .btn-border:hover, .businessroyportfolio-cat-name, .businessroyportfolio-cat-name:hover, .businessroyportfolio-cat-name.active, .site-footer .widget h2.widget-title:before, .cross-sells h2:before, .cart_totals h2:before, .up-sells h2:before, .related h2:before, .woocommerce-billing-fields h3:before, .woocommerce-shipping-fields h3:before, .woocommerce-additional-fields h3:before, #order_review_heading:before, .woocommerce-order-details h2:before, .woocommerce-column--billing-address h2:before, .woocommerce-column--shipping-address h2:before, .woocommerce-Address-title h3:before, .woocommerce-MyAccount-content h3:before, .wishlist-title h2:before, .woocommerce-account .woocommerce h2:before, .widget-area .widget .widget-title:before, .comments-area .comments-title:before, .page-numbers, .page-numbers:hover, .wpcf7 input[type='submit'], .wpcf7 input[type='button'], .wpcf7 input[type='submit']:hover, .wpcf7 input[type='button']:hover{

            border-color: $primary_color;
            
        }\n";

        $businessroy_dynamic .= ".nav-classic .site-branding a:after{

            border-top: 90px solid $primary_color;
            
        }\n";



        // Features Services Top Padding.
        $businessroy_dynamic .= ".businessroyfeature{

            margin-top: $fservices_toppadding$px;
            
        }\n";


        // Background Colors.
        $businessroy_dynamic .= ".businessroyservices, .post-format-media-quote{

            background-color: $service_bg_color;
            
        }\n";


        // Font Colors.
        $businessroy_dynamic .= ".businessroyservices .section-title, 
        .businessroyservices .section-tagline, .post-format-media-quote{

            color: $service_fonts_color;
            
        }\n";


        wp_add_inline_style( 'businessroy-style', $businessroy_dynamic );
	}
}
add_action( 'wp_enqueue_scripts', 'businessroy_dynamic_css', 99 );
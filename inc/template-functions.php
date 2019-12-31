<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Business Roy
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function businessroy_body_classes($classes){

    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no';
    }

    //Web Page Layout
    if (get_theme_mod('businessroy_site_layout', 'full_width') == 'boxed') {
        $classes[] = 'boxed';
    }

    return $classes;
}

add_filter('body_class', 'businessroy_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function businessroy_pingback_header(){
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'businessroy_pingback_header');


/**
 *  Add Metabox.
*/
if( !function_exists( 'businessroy_page_layout_metabox' ) ):

    function businessroy_page_layout_metabox() {

        add_meta_box('businessroy_display_layout', 
            esc_html__( 'Display Page Layout Options', 'business-roy' ), 
            'businessroy_display_layout_callback', 
            array('page'), 
            'normal', 
            'high'
        );
    }
endif;
add_action('add_meta_boxes', 'businessroy_page_layout_metabox');

/**
 * Page and Post Page Display Layout Metabox function
*/

$businessroy_page_layouts =array(

    'leftsidebar' => array(
        'value'     => 'left',
        'label'     => esc_html__( 'Left Sidebar', 'business-roy' ),
        'thumbnail' => get_template_directory_uri() . '/assets/images/left-sidebar.png',
    ),

    'rightsidebar' => array(
        'value'     => 'right',
        'label'     => esc_html__( 'Right (Default)', 'business-roy' ),
        'thumbnail' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
    ),

     'nosidebar' => array(
        'value'     => 'no',
        'label'     => esc_html__( 'Full width', 'business-roy' ),
        'thumbnail' => get_template_directory_uri() . '/assets/images/no-sidebar.png',
    )
);

/**
 * Function for Page layout meta box
*/

if ( ! function_exists( 'businessroy_display_layout_callback' ) ) {
    function businessroy_display_layout_callback(){
        global $post, $businessroy_page_layouts;
        wp_nonce_field( basename( __FILE__ ), 'businessroy_settings_nonce' ); ?>
        <table>
            <tr>
              <td>            
                <?php
                  $i = 0;  
                  foreach ($businessroy_page_layouts as $field) {  
                  $businessroy_page_metalayouts = esc_attr( get_post_meta( $post->ID, 'businessroy_page_layouts', true ) ); 
                ?>            
                  <div class="radio-image-wrapper slidercat" id="slider-<?php echo intval( $i ); ?>" style="float: right; margin-right: 25px;">
                    <label class="description">
                        <span>
                          <img src="<?php echo esc_url( $field['thumbnail'] ); ?>" />
                        </span></br>
                        <input type="radio" name="businessroy_page_layouts" value="<?php echo esc_attr( $field['value'] ); ?>" <?php checked( esc_html( $field['value'] ), 
                            $businessroy_page_metalayouts ); if(empty($businessroy_page_metalayouts) && esc_html( $field['value'] ) =='right'){ echo "checked='checked'";  } ?>/>
                         <?php echo esc_html( $field['label'] ); ?>
                    </label>
                  </div>
                <?php  $i++; }  ?>
              </td>
            </tr>            
        </table>
    <?php
    }
}

/**
 * Save the custom metabox data
*/
if ( ! function_exists( 'businessroy_save_page_settings' ) ) {
    function businessroy_save_page_settings( $post_id ) { 
        global $businessroy_page_layouts, $post;
         if ( !isset( $_POST[ 'businessroy_settings_nonce' ] ) || !wp_verify_nonce( sanitize_key( $_POST[ 'businessroy_settings_nonce' ] ) , basename( __FILE__ ) ) ) 
            return;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)  
            return;        
        if (isset( $_POST['post_type'] ) && 'page' == $_POST['post_type']) {  
            if (!current_user_can( 'edit_page', $post_id ) )  
                return $post_id;  
        } elseif (!current_user_can( 'edit_post', $post_id ) ) {  
                return $post_id;  
        }  

        foreach ($businessroy_page_layouts as $field) {  
            $old = esc_attr( get_post_meta( $post_id, 'businessroy_page_layouts', true) );
            if ( isset( $_POST['businessroy_page_layouts']) ) { 
                $new = sanitize_text_field( wp_unslash( $_POST['businessroy_page_layouts'] ) );
            }
            if ($new && $new != $old) {  
                update_post_meta($post_id, 'businessroy_page_layouts', $new);  
            } elseif ('' == $new && $old) {  
                delete_post_meta($post_id,'businessroy_page_layouts', $old);  
            } 
         } 
    }
}
add_action('save_post', 'businessroy_save_page_settings');
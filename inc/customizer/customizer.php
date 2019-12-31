<?php
/**
 * Business Roy Theme Customizer Setting Panel
 *
 * @package Business Roy
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function businessroy_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {

		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'businessroy_customize_partial_blogname',
		) );

		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'businessroy_customize_partial_blogdescription',
		) );
	}


	/**
	 *	Enable Front Page.
	*/
	$wp_customize->add_section('businessroy_front_page', array(
        'title' => esc_html__('Enable Front Page', 'business-roy'),
        'priority' => 1
    ));

    $wp_customize->add_setting('businessroy_enable_frontpage', array(
    	'default' => false,
        'sanitize_callback' => 'businessroy_sanitize_checkbox',	//done
    ));

    $wp_customize->add_control('businessroy_enable_frontpage', array(
        'type' => 'checkbox',
        'label' => esc_html__('Enable Business Roy Style frontpage?', 'business-roy'),
        'section' => 'businessroy_front_page'
    ));


    /**
	 * Add General Settings Panel
	 *
	 * @since 1.0.0
	*/
	$wp_customize->add_panel(
	    'businessroy_general_settings_panel',
	    array(
	        'priority'       => 2,
	        'title'          => esc_html__( 'General Settings', 'business-roy' ),
	    )
	);


		$wp_customize->get_section( 'title_tagline' )->panel = 'businessroy_general_settings_panel';
		$wp_customize->get_section( 'title_tagline' )->priority = 5;

		$wp_customize->get_section( 'header_image' )->panel = 'businessroy_general_settings_panel';
		$wp_customize->get_section( 'header_image' )->priority = 7;

		$wp_customize->get_section( 'colors' )->title = esc_html__('Theme Colors Setting', 'business-roy');
		$wp_customize->get_section( 'colors' )->priority = 8;

		// Primary Color.
		$wp_customize->add_setting('businessroy_primary_color', array(
		    'default' => '#165da5',
		    'sanitize_callback' => 'sanitize_hex_color',
		));

		$wp_customize->add_control('businessroy_primary_color', array(
		    'type' => 'color',
		    'label' => esc_html__('Primary Color', 'business-roy'),
		    'section' => 'colors',
		    'priority' => 1,
		));

		$wp_customize->get_section( 'background_image' )->panel = 'businessroy_general_settings_panel';
		$wp_customize->get_section( 'background_image' )->priority = 15;

		$wp_customize->get_section( 'static_front_page' )->panel = 'businessroy_general_settings_panel';
		$wp_customize->get_section( 'static_front_page' )->priority = 20;


    // List All Pages
	$pages = array();

	$pages_obj = get_pages();

	$pages[''] = esc_html__('Select Page', 'business-roy');

	foreach ($pages_obj as $page) {
	    $pages[$page->ID] = $page->post_title;
	}

	// List All Category
	$categories = get_categories();
	$blog_cat = array();

	foreach ($categories as $category) {
	    $blog_cat[$category->term_id] = $category->name;
	}


	/**
	 * Home Page Settings
	*/
	$wp_customize->add_panel('businessroy_frontpage_settings', array(
		'title'		=>	esc_html__('Home Sections','business-roy'),
		'priority'	=>	35,
		'description' => esc_html__('Drag and Drop to Reorder', 'business-roy'). '<img class="businessroy-drag-spinner" src="'.admin_url('/images/spinner.gif').'">',
	));


		/**
		 *	Main Banner Slider.
		*/
		$wp_customize->add_section('businessroy_slider_section', array(
			'title'		=>	esc_html__('Home Slider Settings','business-roy'),
			'panel'		=> 'businessroy_frontpage_settings',
			'priority'  => -1
		));

		// Normal Page Slider Type
		$wp_customize->add_setting('businessroy_slider', array(
		    'sanitize_callback' => 'businessroy_sanitize_repeater',		//done
		    'default' => json_encode(array(
		        array(
		            'slider_page' => ''
		        )
		    ))
		));

		$wp_customize->add_control(new Businessroy_Repeater_Control( $wp_customize, 
			'businessroy_slider', 

			array(
			    'label' 	   => esc_html__('Banner Slider Page Settings', 'business-roy'),
			    'section' 	   => 'businessroy_slider_section',
			    'settings' 	   => 'businessroy_slider',
			    'cl_box_label' => esc_html__('Slider Settings Options', 'business-roy'),
			    'cl_box_add_control' => esc_html__('Add New Slider', 'business-roy'),
			),

		    array(

		        'slider_page' => array(
		            'type' => 'select',
		            'label' => esc_html__('Select Slider Page', 'business-roy'),
		            'options' => $pages
		        )
			)
		));


	/**
	 * Features Service Section 
	*/
	$wp_customize->add_section('businessroy_promoservice_section', array(
		'title'		=>	esc_html__('Features Service Section','business-roy'),
		'panel'		=> 'businessroy_frontpage_settings',
		'priority'  => businessroy_get_section_position('businessroy_promoservice_section')
	));


		/**
         * Enable/Disable Option
         *
         * @since 1.0.0
        */
        $wp_customize->add_setting('businessroy_features_service_section', array(
		    'default' => 'enable',
		    'sanitize_callback' => 'businessroy_sanitize_switch',     //done
		));

		$wp_customize->add_control(new Businessroy_Switch_Control($wp_customize, 'businessroy_features_service_section', array(
		    'label' => esc_html__('Enable / Disable', 'business-roy'),
		    'section' => 'businessroy_promoservice_section',
		    'switch_label' => array(
		        'enable' => esc_html__('Enable', 'business-roy'),
		        'disable' => esc_html__('Disable', 'business-roy'),
		    ),
		)));

		//  Features Service Page.
		$wp_customize->add_setting('businessroy_promo_service', array(
		    'sanitize_callback' => 'businessroy_sanitize_repeater',		//done
		    'default' => json_encode(array(
		        array(
		            'promoservice_page' => '',
		            'promoservice_icon' =>'fa fa-cogs',

		        )
		    ))
		));


		$wp_customize->add_setting('businessroy_promoservice_container_options',array(
			'default'			 =>	'nocontainer',
			'sanitize_callback'	 =>	'businessroy_sanitize_select'		//done	
		));

		$wp_customize->add_control( 'businessroy_promoservice_container_options', array(
			'label'	  =>	esc_html__('Display Width','business-roy'),
			'section' =>	'businessroy_promoservice_section',
			'type'	  =>	'select',
			'choices' => array(
				'nocontainer' => esc_html__('Full Width','business-roy'),
				'container'   => esc_html__( 'Boxed Width','business-roy' ),
			)
		));


		$wp_customize->add_setting('businessroy_promoservice_gutters',array(
			'default'			 =>	'no-gutters',
			'sanitize_callback'	 =>	'businessroy_sanitize_select'		//done	
		));

		$wp_customize->add_control( 'businessroy_promoservice_gutters', array(
			'label'	  =>	esc_html__('Block Gutter Space','business-roy'),
			'section' =>	'businessroy_promoservice_section',
			'type'	  =>	'select',
			'choices' => array(
				'nogutters' => esc_html__('With Padding Space','business-roy'),
				'no-gutters'   => esc_html__( 'Without Padding Space','business-roy' ),
			)
		));


        $wp_customize->add_setting( 'businessroy_promoservice_top_padding', array(
            'default'    => 0,
            'sanitize_callback' => 'sanitize_text_field'
        ));

        $wp_customize->add_control( 'businessroy_promoservice_top_padding', array(
            'type'      => 'number',
            'label'     => esc_html__( 'Enter Features Top Padding', 'business-roy' ),
            'section'   => 'businessroy_promoservice_section',
            'input_attrs' => array( 'step' => 1, 'min' => -80, 'max' => 40  ),
        ));


		$wp_customize->add_control(new Businessroy_Repeater_Control( $wp_customize, 
			'businessroy_promo_service', 

			array(
			    'label' 	   => esc_html__('Features Service Settings', 'business-roy'),
			    'section' 	   => 'businessroy_promoservice_section',
			    'settings' 	   => 'businessroy_promo_service',
			    'cl_box_label' => esc_html__('Features Service Settings', 'business-roy'),
			    'cl_box_add_control' => esc_html__('Add New Page', 'business-roy'),
			),

		    array(

		        'promoservice_page' => array(
		            'type' => 'select',
		            'label' => esc_html__('Select Features Service Page', 'business-roy'),
		            'options' => $pages
		        ),

		        'promoservice_icon' => array(
		            'type' => 'icons',
		            'label' => esc_html__('Choose Icon', 'business-roy'),
		            'default' => 'fa fa-cogs'
		        )
			)
		));


	/**
	 * About Us Section 
	*/
	$wp_customize->add_section('businessroy_aboutus_section', array(
		'title'		=>	esc_html__('About Us Section','business-roy'),
		'panel'		=> 'businessroy_frontpage_settings',
		'priority'  => businessroy_get_section_position('businessroy_aboutus_section')
	));

		/**
         * Enable/Disable Option
         *
         * @since 1.0.0
        */
        $wp_customize->add_setting('businessroy_aboutus_service_section', array(
		    'default' => 'enable',
		    'sanitize_callback' => 'businessroy_sanitize_switch',     //done
		));

		$wp_customize->add_control(new Businessroy_Switch_Control($wp_customize, 'businessroy_aboutus_service_section', array(
		    'label' => esc_html__('Enable / Disable', 'business-roy'),
		    'section' => 'businessroy_aboutus_section',
		    'switch_label' => array(
		        'enable' => esc_html__('Enable', 'business-roy'),
		        'disable' => esc_html__('Disable', 'business-roy'),
		    ),
		)));

		// About Us Page.
		$wp_customize->add_setting( 'businessroy_aboutus', array(
			'sanitize_callback' => 'absint'			//done
		) );

		$wp_customize->add_control( 'businessroy_aboutus', array(
			'label'    => esc_html__( 'Select Page ', 'business-roy' ),
			'section'  => 'businessroy_aboutus_section',
			'type'     => 'dropdown-pages'
		));

		// About Us Image.
		$wp_customize->add_setting('businessroy_aboutus_image', array(
			'sanitize_callback'	=> 'absint'		//done
		));

		$wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'businessroy_aboutus_image', array(
			'label'	   => esc_html__('Upload About Features Image','business-roy'),
			'section'  => 'businessroy_aboutus_section',
			'width'    => 600,
	        'height'   => 600,
		)));


	/**
	 * Video Call To Action Section
	*/
	$wp_customize->add_section('businessroy_video_calltoaction_section', array(
		'title'		=> esc_html__('Video Call To Action Section','business-roy'),
		'panel'		=> 'businessroy_frontpage_settings',
		'priority'  => businessroy_get_section_position('businessroy_video_calltoaction_section')
	));

		/**
         * Enable/Disable Option
         *
         * @since 1.0.0
        */
        $wp_customize->add_setting('businessroy_video_cta_service_section', array(
		    'default' => 'enable',
		    'sanitize_callback' => 'businessroy_sanitize_switch',     //done
		));

		$wp_customize->add_control(new Businessroy_Switch_Control($wp_customize, 'businessroy_video_cta_service_section', array(
		    'label' => esc_html__('Enable / Disable', 'business-roy'),
		    'section' => 'businessroy_video_calltoaction_section',
		    'switch_label' => array(
		        'enable' => esc_html__('Enable', 'business-roy'),
		        'disable' => esc_html__('Disable', 'business-roy'),
		    ),
		)));

		// Call To Action Video Button URL.
		$wp_customize->add_setting('businessroy_video_button_url', array(
			'sanitize_callback'	=> 'esc_url_raw'		//done
		));

		$wp_customize->add_control('businessroy_video_button_url', array(
			'label'	   => esc_html__('Enter Youtube Video URL','business-roy'),
			'section'  => 'businessroy_video_calltoaction_section',
			'type'	   => 'url'
		));

		// Video Call To Action Title.
		$wp_customize->add_setting('businessroy_video_calltoaction_title', array(
			'sanitize_callback'	=> 'sanitize_text_field'		//done
		));

		$wp_customize->add_control( 'businessroy_video_calltoaction_title', array(
			'label'	   => esc_html__('Enter Section Title','business-roy'),
			'section'  => 'businessroy_video_calltoaction_section',
			'type'	   => 'text',
		));

		// Video Call To Action Subtitle.
		$wp_customize->add_setting('businessroy_video_calltoaction_subtitle', array(
			'sanitize_callback'	=> 'sanitize_text_field'		//done
		));

		$wp_customize->add_control('businessroy_video_calltoaction_subtitle', array(
			'label'	   => esc_html__('Enter Section Subtitle','business-roy'),
			'section'  => 'businessroy_video_calltoaction_section',
			'type'	   => 'text',
		));

		// Video Call To Action Background Image.
		$wp_customize->add_setting('businessroy_video_calltoaction_image', array(
			'sanitize_callback'	=> 'esc_url_raw'		//done
		));

		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'businessroy_video_calltoaction_image', array(
			'label'	   => esc_html__('Upload Video Background Image','business-roy'),
			'section'  => 'businessroy_video_calltoaction_section',
			'type'	   => 'image',
		)));


	/**
	 * Our Service Section 
	*/
	$wp_customize->add_section('businessroy_service_section', array(
		'title'		=> esc_html__('Our Service Section','business-roy'),
		'panel'		=> 'businessroy_frontpage_settings',
		'priority'  => businessroy_get_section_position('businessroy_service_section')
	));

		/**
         * Enable/Disable Option
         *
         * @since 1.0.0
        */
        $wp_customize->add_setting('businessroy_service_service_section', array(
		    'default' => 'enable',
		    'sanitize_callback' => 'businessroy_sanitize_switch',     //done
		));

		$wp_customize->add_control(new Businessroy_Switch_Control($wp_customize, 'businessroy_service_service_section', array(
		    'label' => esc_html__('Enable / Disable', 'business-roy'),
		    'section' => 'businessroy_service_section',
		    'switch_label' => array(
		        'enable' => esc_html__('Enable', 'business-roy'),
		        'disable' => esc_html__('Disable', 'business-roy'),
		    ),
		)));

		// Our Service Section Title.
		$wp_customize->add_setting( 'businessroy_service_title', array(
			'sanitize_callback' => 'sanitize_text_field'			//done
		) );

		$wp_customize->add_control( 'businessroy_service_title', array(
			'label'    => esc_html__( 'Enter Service Section Title', 'business-roy' ),
			'section'  => 'businessroy_service_section',
			'type'     => 'text',
		));


		// Our Service Section Sub Title.
		$wp_customize->add_setting( 'businessroy_service_sub_title', array(
			'sanitize_callback' => 'sanitize_text_field'			//done
		) );

		$wp_customize->add_control( 'businessroy_service_sub_title', array(
			'label'    => esc_html__( 'Enter Service Section Sub Title', 'business-roy' ),
			'section'  => 'businessroy_service_section',
			'type'     => 'text',
		));

		//  Our Service Page.
		$wp_customize->add_setting('businessroy_service', array(
		    'sanitize_callback' => 'businessroy_sanitize_repeater',		//done
		    'default' => json_encode(array(
		        array(
		            'service_page' => '',
		            'service_icon' =>'fa fa-cogs'
		        )
		    ))
		));

		$wp_customize->add_control(new Businessroy_Repeater_Control( $wp_customize,
			'businessroy_service', 

			array(
			    'label' 	   => esc_html__('Our Service Settings', 'business-roy'),
			    'section' 	   => 'businessroy_service_section',
			    'settings' 	   => 'businessroy_service',
			    'cl_box_label' => esc_html__('Service Settings Options', 'business-roy'),
			    'cl_box_add_control' => esc_html__('Add New Page', 'business-roy'),
			),
		    array(
		        'service_page' => array(
		            'type' => 'select',
		            'label' => esc_html__('Select Service Page', 'business-roy'),
		            'options' => $pages
		        ),

		        'service_icon' => array(
		            'type' => 'icons',
		            'label' => esc_html__('Choose Icon', 'business-roy'),
		            'default' => 'fa fa-cogs'
		        )
			)
		));

		// Our Service Section Button text.
		$wp_customize->add_setting( 'businessroy_service_button', array(
			'sanitize_callback' => 'sanitize_text_field'			//done
		) );

		$wp_customize->add_control( 'businessroy_service_button', array(
			'label'    => esc_html__( 'Enter Services Button Text', 'business-roy' ),
			'section'  => 'businessroy_service_section',
			'type'     => 'text',
		));


		// Service Section Layout.
		$wp_customize->add_setting( 'businessroy_service_layout', array(
			'default' => 'layout_one',
			'sanitize_callback' => 'businessroy_sanitize_select'			//done
		) );

		$wp_customize->add_control( 'businessroy_service_layout', array(
			'label'    => esc_html__( 'Our Service Layout', 'business-roy' ),
			'section'  => 'businessroy_service_section',
			'type'     => 'select',
			'choices'  => array(
				'layout_one'  => esc_html__('Layout One', 'business-roy'),
				'layout_two'  =>esc_html__('Layout Two', 'business-roy'),
			)
		));


		// Services Section Background Color
		$wp_customize->add_setting('businessroy_service_bg_color', array(
		    'default' => '#004A8D',
		    'sanitize_callback' => 'sanitize_hex_color',
		));

		$wp_customize->add_control('businessroy_service_bg_color', array(
		    'type' => 'color',
		    'label' => esc_html__('Services Background Color', 'business-roy'),
		    'section' => 'businessroy_service_section',
		));


		// Services Section Text Color
		$wp_customize->add_setting('businessroy_service_text_color', array(
		    'default' => '#ffffff',
		    'sanitize_callback' => 'sanitize_hex_color',
		));

		$wp_customize->add_control('businessroy_service_text_color', array(
		    'type' => 'color',
		    'label' => esc_html__('Services Fonts Color', 'business-roy'),
		    'section' => 'businessroy_service_section',
		));



	/**
	 * Call To Action Section
	*/
	$wp_customize->add_section('businessroy_calltoaction_section', array(
		'title'		=>  esc_html__('Call To Action Section','business-roy'),
		'panel'		=> 'businessroy_frontpage_settings',
		'priority'  => businessroy_get_section_position('businessroy_calltoaction_section')
	));

		/**
         * Enable/Disable Option
         *
         * @since 1.0.0
        */
        $wp_customize->add_setting('businessroy_cta_service_section', array(
		    'default' => 'enable',
		    'sanitize_callback' => 'businessroy_sanitize_switch',     //done
		));

		$wp_customize->add_control(new Businessroy_Switch_Control($wp_customize, 'businessroy_cta_service_section', array(
		    'label' => esc_html__('Enable / Disable', 'business-roy'),
		    'section' => 'businessroy_calltoaction_section',
		    'switch_label' => array(
		        'enable' => esc_html__('Enable', 'business-roy'),
		        'disable' => esc_html__('Disable', 'business-roy'),
		    ),
		)));

		// Call To Action Image.
		$wp_customize->add_setting('businessroy_calltoaction_image', array(
			'sanitize_callback'	=> 'esc_url_raw'		//done
		));

		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'businessroy_calltoaction_image', array(
			'label'	   => esc_html__('Upload Background Image','business-roy'),
			'section'  => 'businessroy_calltoaction_section',
			'type'	   => 'image',
		)));


		// Call To Action Title.
		$wp_customize->add_setting('businessroy_calltoaction_title', array(
			'sanitize_callback'	=> 'sanitize_text_field'		//done
		));

		$wp_customize->add_control( 'businessroy_calltoaction_title', array(
			'label'	   => esc_html__('Enter Section Title','business-roy'),
			'section'  => 'businessroy_calltoaction_section',
			'type'	   => 'text',
		));

		// Call To Action Subtitle.
		$wp_customize->add_setting('businessroy_calltoaction_subtitle', array(
			'sanitize_callback'	=> 'sanitize_text_field'		//done
		));

		$wp_customize->add_control('businessroy_calltoaction_subtitle', array(
			'label'	   => esc_html__('Enter Section Subtitle','business-roy'),
			'section'  => 'businessroy_calltoaction_section',
			'type'	   => 'text'
		));

		// Call To Action Button.
		$wp_customize->add_setting('businessroy_calltoaction_button', array(
			'sanitize_callback'	=> 'sanitize_text_field'		//done
		));

		$wp_customize->add_control('businessroy_calltoaction_button', array(
			'label'	   => esc_html__('Enter Button One Text','business-roy'),
			'section'  => 'businessroy_calltoaction_section',
			'type'	   => 'text',
		));
		
		// Call To Action Button Link.
		$wp_customize->add_setting('businessroy_calltoaction_link', array(
			'sanitize_callback'	=> 'esc_url_raw'		//done
		));

		$wp_customize->add_control('businessroy_calltoaction_link', array(
			'label'	   => esc_html__('Enter Button One Link','business-roy'),
			'section'  => 'businessroy_calltoaction_section',
			'type'	   => 'url',
		));


		// Call To Action Button.
		$wp_customize->add_setting('businessroy_calltoaction_button_one', array(
			'sanitize_callback'	=> 'sanitize_text_field'		//done
		));

		$wp_customize->add_control('businessroy_calltoaction_button_one', array(
			'label'	   => esc_html__('Enter Button Two Text','business-roy'),
			'section'  => 'businessroy_calltoaction_section',
			'type'	   => 'text',
		));
		
		// Call To Action Button Link.
		$wp_customize->add_setting('businessroy_calltoaction_link_one', array(
			'sanitize_callback'	=> 'esc_url_raw'		//done
		));

		$wp_customize->add_control('businessroy_calltoaction_link_one', array(
			'label'	   => esc_html__('Enter Button Two Link','business-roy'),
			'section'  => 'businessroy_calltoaction_section',
			'type'	   => 'url',
		));


	/**
	 * Portfolio Work Section. 
	*/
	$wp_customize->add_section('businessroy_recentwork_section', array(
		'title'		=> esc_html__('Portfolio Section','business-roy'),
		'panel'		=> 'businessroy_frontpage_settings',
		'priority'  => businessroy_get_section_position('businessroy_recentwork_section')
	));

		/**
         * Enable/Disable Option
         *
         * @since 1.0.0
        */
        $wp_customize->add_setting('businessroy_portfolio_section', array(
		    'default' => 'enable',
		    'sanitize_callback' => 'businessroy_sanitize_switch',     //done
		));

		$wp_customize->add_control(new Businessroy_Switch_Control($wp_customize, 'businessroy_portfolio_section', array(
		    'label' => esc_html__('Enable / Disable', 'business-roy'),
		    'section' => 'businessroy_recentwork_section',
		    'switch_label' => array(
		        'enable' => esc_html__('Enable', 'business-roy'),
		        'disable' => esc_html__('Disable', 'business-roy'),
		    ),
		)));

		// Portfolio Work Section Title.
		$wp_customize->add_setting( 'businessroy_recentwork_title', array(
			'sanitize_callback' => 'sanitize_text_field', 	 //done	
		));

		$wp_customize->add_control('businessroy_recentwork_title', array(
			'label'		=> esc_html__( 'Enter Section Title', 'business-roy' ),
			'section'	=> 'businessroy_recentwork_section',
			'type'      => 'text'
		));

		// Our Service Section Sub Title.
		$wp_customize->add_setting( 'businessroy_recentwork_sub_title', array(
			'sanitize_callback' => 'sanitize_text_field'			//done
		) );

		$wp_customize->add_control( 'businessroy_recentwork_sub_title', array(
			'label'    => esc_html__( 'Enter Service Section Sub Title', 'business-roy' ),
			'section'  => 'businessroy_recentwork_section',
			'type'     => 'text',
		));

		// Portfolio Work Images.
		$wp_customize->add_setting( 'businessroy_recent_work', array(
			'sanitize_callback' => 'sanitize_text_field', 	 //done	
		));

		$wp_customize->add_control( new Businessroy_Multiple_Check_Control($wp_customize, 
			'businessroy_recent_work', 

			array(
				'label'		=> esc_html__( 'Select Category', 'business-roy' ),
				'settings'	=> 'businessroy_recent_work',
				'section'	=> 'businessroy_recentwork_section',
				'choices'	=> $blog_cat,
			)
		));


	/**
	 * Counter Section. 
	*/
	$wp_customize->add_section('businessroy_counter_section', array(
		'title'		=> 	esc_html__('Counter Section','business-roy'),
		'panel'		=> 'businessroy_frontpage_settings',
		'priority'  => businessroy_get_section_position('businessroy_counter_section')
	));

		/**
         * Enable/Disable Option
         *
         * @since 1.0.0
        */
        $wp_customize->add_setting('businessroy_counter_section', array(
		    'default' => 'enable',
		    'sanitize_callback' => 'businessroy_sanitize_switch',     //done
		));

		$wp_customize->add_control(new Businessroy_Switch_Control($wp_customize, 'businessroy_counter_section', array(
		    'label' => esc_html__('Enable / Disable', 'business-roy'),
		    'section' => 'businessroy_counter_section',
		    'switch_label' => array(
		        'enable' => esc_html__('Enable', 'business-roy'),
		        'disable' => esc_html__('Disable', 'business-roy'),
		    ),
		)));

		// Counter Section Title.
		$wp_customize->add_setting('businessroy_counter_title', array(
			'sanitize_callback'	=> 'sanitize_text_field'		//done
		));

		$wp_customize->add_control('businessroy_counter_title', array(
			'label'	   => esc_html__('Enter Section Title','business-roy'),
			'section'  => 'businessroy_counter_section',
			'type'	   => 'text',
		));


		// Our Service Section Sub Title.
		$wp_customize->add_setting( 'businessroy_counter_sub_title', array(
			'sanitize_callback' => 'sanitize_text_field'			//done
		) );

		$wp_customize->add_control( 'businessroy_counter_sub_title', array(
			'label'    => esc_html__( 'Enter Service Section Sub Title', 'business-roy' ),
			'section'  => 'businessroy_counter_section',
			'type'     => 'text',
		));

		// Counter Background Image.
		$wp_customize->add_setting('businessroy_counter_image', array(
			'sanitize_callback'	=> 'esc_url_raw'		//done
		));

		$wp_customize->add_control(new WP_Customize_Image_Control( $wp_customize, 'businessroy_counter_image', array(
			'label'	   => esc_html__('Upload Counter Background Image','business-roy'),
			'section'  => 'businessroy_counter_section',
			'type'	   => 'image',
		)));


		// Counter Section.
		$wp_customize->add_setting('businessroy_counter', array(
		    'sanitize_callback' => 'businessroy_sanitize_repeater',		//done
		    'default' => json_encode(array(
		        array(
		            'counter_title'  =>'',
		            'counter_number'  =>'',	            
		        )
		    ))
		));

		$wp_customize->add_control(new Businessroy_Repeater_Control( $wp_customize, 
			'businessroy_counter', 

			array(
			    'label' 	   => esc_html__('Counter Settings', 'business-roy'),
			    'section' 	   => 'businessroy_counter_section',
			    'settings' 	   => 'businessroy_counter',
			    'cl_box_label' => esc_html__('Counter Settings Options', 'business-roy'),
			    'cl_box_add_control' => esc_html__('Add New', 'business-roy'),
			),

		    array(

		        'counter_title' => array(
		            'type' => 'text',
		            'label' => esc_html__('Enter Counter Title', 'business-roy'),
		            'default' => ''
		        ),

		        'counter_number' => array(
		            'type' => 'text',
		            'label' => esc_html__('Enter Counter Number', 'business-roy'),
		            'default' => ''
		        ),
		        
			)
		));



	/* Blog Section. */
	$wp_customize->add_section('businessroy_blog_section', array(
		'title'		=> 	esc_html__('Blog Section','business-roy'),
		'panel'		=> 'businessroy_frontpage_settings',
		'priority'  => businessroy_get_section_position('businessroy_blog_section')
	));

		/**
         * Enable/Disable Option
         *
         * @since 1.0.0
        */
        $wp_customize->add_setting('businessroy_home_blog_section', array(
		    'default' => 'enable',
		    'sanitize_callback' => 'businessroy_sanitize_switch',     //done
		));

		$wp_customize->add_control(new Businessroy_Switch_Control($wp_customize, 'businessroy_home_blog_section', array(
		    'label' => esc_html__('Enable / Disable', 'business-roy'),
		    'section' => 'businessroy_blog_section',
		    'switch_label' => array(
		        'enable' => esc_html__('Enable', 'business-roy'),
		        'disable' => esc_html__('Disable', 'business-roy'),
		    ),
		)));

		// Blog Title.
		$wp_customize->add_setting('businessroy_blog_title', array(
			'sanitize_callback'	=> 'sanitize_text_field'		//done
		));

		$wp_customize->add_control('businessroy_blog_title', array(
			'label'	   => esc_html__('Enter Section Title','business-roy'),
			'section'  => 'businessroy_blog_section',
			'type'	   => 'text',
		));

		// Our Service Section Sub Title.
		$wp_customize->add_setting( 'businessroy_blog_sub_title', array(
			'sanitize_callback' => 'sanitize_text_field'			//done
		) );

		$wp_customize->add_control( 'businessroy_blog_sub_title', array(
			'label'    => esc_html__( 'Enter Service Section Sub Title', 'business-roy' ),
			'section'  => 'businessroy_blog_section',
			'type'     => 'text',
		));

		// Blog Posts.
		$wp_customize->add_setting('businessroy_blog', array(
		    'sanitize_callback' => 'sanitize_text_field',     //done
		));

		$wp_customize->add_control(new Businessroy_Multiple_Check_Control($wp_customize, 'businessroy_blog', array(
		    'label'    => esc_html__('Select Category To Show Posts', 'business-roy'),
		    'settings' => 'businessroy_blog',
		    'section'  => 'businessroy_blog_section',
		    'choices'  => $blog_cat,
		)));

		// Select Blog Post Layout.
		$wp_customize->add_setting('businessroy_posts_num',array(
			'default'			 =>	'three',
			'sanitize_callback'	 =>	'businessroy_sanitize_select'		//done	
		));

		$wp_customize->add_control( 'businessroy_posts_num', array(
			'label'	  =>	esc_html__('Select Number Of Blog Posts To Display','business-roy'),
			'section' =>	'businessroy_blog_section',
			'type'	  =>	'select',
			'choices' => array(
				'three' => esc_html__('3 Column Layout','business-roy'),
				'six'   => esc_html__( '6 Column Layout','business-roy' ),
			)
		));


	/* Testimonial Section. */
	$wp_customize->add_section('businessroy_testimonial_section', array(
		'title'		=> 	esc_html__('Testimonial Section','business-roy'),
		'panel'		=> 'businessroy_frontpage_settings',
		'priority'  => businessroy_get_section_position('businessroy_testimonial_section')
	));

		/**
         * Enable/Disable Option
         *
         * @since 1.0.0
        */
        $wp_customize->add_setting('businessroy_testimonial_options', array(
		    'default' => 'enable',
		    'sanitize_callback' => 'businessroy_sanitize_switch',     //done
		));

		$wp_customize->add_control(new Businessroy_Switch_Control($wp_customize, 'businessroy_testimonial_options', array(
		    'label' => esc_html__('Enable / Disable', 'business-roy'),
		    'section' => 'businessroy_testimonial_section',
		    'switch_label' => array(
		        'enable' => esc_html__('Enable', 'business-roy'),
		        'disable' => esc_html__('Disable', 'business-roy'),
		    ),
		)));


		// Blog Title.
		$wp_customize->add_setting('businessroy_testimonial_title', array(
			'sanitize_callback'	=> 'sanitize_text_field'		//done
		));

		$wp_customize->add_control('businessroy_testimonial_title', array(
			'label'	   => esc_html__('Enter Section Title','business-roy'),
			'section'  => 'businessroy_testimonial_section',
			'type'	   => 'text',
		));

		// Our Service Section Sub Title.
		$wp_customize->add_setting( 'businessroy_testimonial_sub_title', array(
			'sanitize_callback' => 'sanitize_text_field'			//done
		) );

		$wp_customize->add_control( 'businessroy_testimonial_sub_title', array(
			'label'    => esc_html__( 'Enter Service Section Sub Title', 'business-roy' ),
			'section'  => 'businessroy_testimonial_section',
			'type'     => 'text',
		));

		// Testimonial Image.
		$wp_customize->add_setting('businessroy_testimonials_image', array(
			'sanitize_callback'	=> 'esc_url_raw'		//done
		));

		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'businessroy_testimonials_image', array(
			'label'	   => esc_html__('Upload Testimonials Background Image','business-roy'),
			'section'  => 'businessroy_testimonial_section',
			'type'	   => 'image',
		)));

		//  Testimonial Page.
		$wp_customize->add_setting('businessroy_testimonials', array(
		    'sanitize_callback' => 'businessroy_sanitize_repeater',		//done
		    'default' => json_encode(array(
		        array(
		            'testimonial_page' => '',
		            'designation'=>'',
		        )
		    ))
		));

		$wp_customize->add_control(new Businessroy_Repeater_Control( $wp_customize, 
			'businessroy_testimonials', 

			array(
			    'label' 	   => esc_html__('Testimonials Settings', 'business-roy'),
			    'section' 	   => 'businessroy_testimonial_section',
			    'settings' 	   => 'businessroy_testimonials',
			    'cl_box_label' => esc_html__('Testimonial Settings Options', 'business-roy'),
			    'cl_box_add_control' => esc_html__('Add New Page', 'business-roy'),
			),
		    array(
		        'testimonial_page' => array(
		            'type' => 'select',
		            'label' => esc_html__('Select Testimonial Page', 'business-roy'),
		            'options' => $pages
		        ),

		        'designation' => array(
		            'type' => 'text',
		            'label' => esc_html__('Enter Designation', 'business-roy'),
		            'default' => ''
		        ),
			)
		));


	/* Team Section. */
	$wp_customize->add_section('businessroy_team_section', array(
		'title'		=> 	esc_html__('Our Team Section','business-roy'),
		'panel'		=> 'businessroy_frontpage_settings',
		'priority'  => businessroy_get_section_position('businessroy_team_section')
	));

		/**
         * Enable/Disable Option
         *
         * @since 1.0.0
        */
        $wp_customize->add_setting('businessroy_team_options', array(
		    'default' => 'enable',
		    'sanitize_callback' => 'businessroy_sanitize_switch',     //done
		));

		$wp_customize->add_control(new Businessroy_Switch_Control($wp_customize, 'businessroy_team_options', array(
		    'label' => esc_html__('Enable / Disable', 'business-roy'),
		    'section' => 'businessroy_team_section',
		    'switch_label' => array(
		        'enable' => esc_html__('Enable', 'business-roy'),
		        'disable' => esc_html__('Disable', 'business-roy'),
		    ),
		)));

		// Team Section Title.
		$wp_customize->add_setting( 'businessroy_team_title', array(
			'sanitize_callback' => 'sanitize_text_field'			//done
		) );

		$wp_customize->add_control( 'businessroy_team_title', array(
			'label'    => esc_html__( 'Enter Section Title', 'business-roy' ),
			'section'  => 'businessroy_team_section',
			'type'     => 'text',
		));

		// Our Service Section Sub Title.
		$wp_customize->add_setting( 'businessroy_team_sub_title', array(
			'sanitize_callback' => 'sanitize_text_field'			//done
		) );

		$wp_customize->add_control( 'businessroy_team_sub_title', array(
			'label'    => esc_html__( 'Enter Service Section Sub Title', 'business-roy' ),
			'section'  => 'businessroy_team_section',
			'type'     => 'text',
		));

		// Our Team Page.
		$wp_customize->add_setting('businessroy_team', array(
		    'sanitize_callback' => 'businessroy_sanitize_repeater',		//done
		    'default' => json_encode(array(
		        array(
		            'team_page'   => '',
		            'designation' =>'',
		            'facebook'    =>'',
		            'twitter'     =>'',
		            'linkedin'      =>'',
		            'instagram'   => '',
		        )
		    ))
		));

		$wp_customize->add_control(new Businessroy_Repeater_Control( $wp_customize, 
			'businessroy_team', 
			array(
			    'label' 	   => esc_html__('Team Settings', 'business-roy'),
			    'section' 	   => 'businessroy_team_section',
			    'settings' 	   => 'businessroy_team',
			    'cl_box_label' => esc_html__('Team Setting Options', 'business-roy'),
			    'cl_box_add_control' => esc_html__('Add New Page', 'business-roy'),
			),
		    array(

		        'team_page' => array(
		            'type'    => 'select',
		            'label'   => esc_html__('Select Team Page', 'business-roy'),
		            'options' => $pages
		        ),

		        'designation' => array(
		            'type'    => 'text',
		            'label'   => esc_html__('Enter Designation', 'business-roy'),
		            'default' => ''
		        ),

		        'facebook'  => array(
		            'type'   => 'url',
		            'label'  => esc_html__('Enter Facebook Link', 'business-roy'),
		            'default' => ''
		        ),

		        'twitter' 	=> array(
		            'type'    => 'url',
		            'label'   => esc_html__('Enter Twitter Link', 'business-roy'),
		            'default' => ''
		        ),

		        'linkedin'   => array(
		            'type'    => 'url',
		            'label'   => esc_html__('Enter Linkedin Link', 'business-roy'),
		            'default' => ''
		        ),
		        
		        'instagram' => array(
		            'type'    => 'url',
		            'label'   => esc_html__('Enter Instagram Link', 'business-roy'),
		            'default' => ''
		        )
			)
		));



	/**
	 * Theme Option Settings.
	*/
	$wp_customize->add_panel('businessroy_theme_options', array(
		'title'		=>	esc_html__('Theme Options','business-roy'),
		'priority'	=>	55,
	));

		// Site Layout.
		$wp_customize->add_section('businessroy_site_layout_section', array(
			'title'		=>	esc_html__('Site Layout','business-roy'),
			'panel'		=> 'businessroy_theme_options',
		));

			// Site Layout Options.
			$wp_customize->add_setting('businessroy_site_layout', array(
				'default' => 'full_width',
				'sanitize_callback' => 'businessroy_sanitize_select'         //done
			));

			$wp_customize->add_control('businessroy_site_layout', array(
				'label'   => esc_html__('Site Layout','business-roy'),
				'section' => 'businessroy_site_layout_section',
				'type'    => 'select',
				'choices' => array(
					'full_width' => esc_html__('Full Width','business-roy'),
					'boxed' => esc_html__('Boxed','business-roy'),			
				)
			));

		/**
		 * Page Layout Sidebar Options
		*/
		$wp_customize->add_section('businessroy_sidebar', array(
			'title'		=>	esc_html__('Display Sidebar Settings','business-roy'),
			'panel'		=> 'businessroy_theme_options',
		));

			// Enable or Disable Sticky Sidebar.
			$wp_customize->add_setting('businessroy_sticky_sidebar', array(
			    'default' => 'enable',
			    'sanitize_callback' => 'businessroy_sanitize_switch',     //done
			));

			$wp_customize->add_control(new Businessroy_Switch_Control($wp_customize, 'businessroy_sticky_sidebar', array(
			    'label' => esc_html__('Enable Sticky Sidebar', 'business-roy'),
			    'settings' => 'businessroy_sticky_sidebar',
			    'section' => 'businessroy_sidebar',
			    'switch_label' => array(
			        'enable' => esc_html__('Enable', 'business-roy'),
			        'disable' => esc_html__('Disable', 'business-roy'),
			    ),
			)));


			// Blog Sidebar Options.
			$wp_customize->add_setting('businessroy_blog_sidebar', array(
			    'default' => 'right',
			    'sanitize_callback' => 'businessroy_sanitize_select',     //done
			));

			$wp_customize->add_control('businessroy_blog_sidebar', array(
			    'label'   => esc_html__('Index Blog Posts Sidebar', 'business-roy'),
			    'section' => 'businessroy_sidebar',
			    'type'    => 'select',
			    'choices' => array(
			        'right' => esc_html__('Content / Sidebar', 'business-roy'),
			        'left' => esc_html__('Sidebar / Content', 'business-roy'),
			        'no' => esc_html__('Full Width', 'business-roy'),
			    ),
			));

			// Blog Archive Sidebar Options.
			$wp_customize->add_setting('businessroy_archive_sidebar', array(
			    'default' => 'right',
			    'sanitize_callback' => 'businessroy_sanitize_select',     //done
			));

			$wp_customize->add_control('businessroy_archive_sidebar', array(
			    'label'   => esc_html__('Blog Archive Sidebar', 'business-roy'),
			    'section' => 'businessroy_sidebar',
			    'type'    => 'select',
			    'choices' => array(
			        'right' => esc_html__('Content / Sidebar', 'business-roy'),
			        'left' => esc_html__('Sidebar / Content', 'business-roy'),
			        'no' => esc_html__('Full Width', 'business-roy'),	        
			    ),
			));

			// Page Sidebar Options.
			$wp_customize->add_setting('businessroy_page_sidebar', array(
			    'default' => 'right',
			    'sanitize_callback' => 'businessroy_sanitize_select',     //done
			));

			$wp_customize->add_control('businessroy_page_sidebar', array(
			    'label'   => esc_html__('Page Sidebar', 'business-roy'),
			    'section' => 'businessroy_sidebar',
			    'type'    => 'select',
			    'choices' => array(
			        'right' => esc_html__('Content / Sidebar', 'business-roy'),
			        'left' => esc_html__('Sidebar / Content', 'business-roy'),
			        'no' => esc_html__('Full Width', 'business-roy'),	        
			    ),
			));

			// Search Page Sidebar Options.
			$wp_customize->add_setting('businessroy_search_sidebar', array(
			    'default' => 'right',
			    'sanitize_callback' => 'businessroy_sanitize_select',     //done
			));

			$wp_customize->add_control('businessroy_search_sidebar', array(
			    'label'   => esc_html__('Search Page Sidebar', 'business-roy'),
			    'section' => 'businessroy_sidebar',
			    'type'    => 'select',
			    'choices' => array(
			        'right' => esc_html__('Content / Sidebar', 'business-roy'),
			        'left' => esc_html__('Sidebar / Content', 'business-roy'),
			        'no' => esc_html__('Full Width', 'business-roy'),	        
			    ),
			));


		/**
		 * Breadcrumbs Settings. 
		*/
		$wp_customize->add_section('businessroy_breadcrumb', array(
			'title'		=>	esc_html__('Breadcrumbs Setting','business-roy'),
			'panel'		=> 'businessroy_theme_options',
		));

		    // Enable or Disable Breadcrumb.
			$wp_customize->add_setting('businessroy_enable_breadcrumbs', array(
			    'default' => 'enable',
			    'sanitize_callback' => 'businessroy_sanitize_switch',     //done
			));

			$wp_customize->add_control(new Businessroy_Switch_Control($wp_customize, 'businessroy_enable_breadcrumbs', array(
			    'label' => esc_html__('Enable/Disable Breadcrumbs', 'business-roy'),
			    'settings' => 'businessroy_enable_breadcrumbs',
			    'section' => 'businessroy_breadcrumb',
			    'switch_label' => array(
			        'enable' => esc_html__('Enable', 'business-roy'),
			        'disable' => esc_html__('Disable', 'business-roy'),
			    ),
			)));

		    // Breadcrumb Image.
			$wp_customize->add_setting('businessroy_breadcrumbs_image', array(
				'sanitize_callback'	=> 'esc_url_raw'		//done
			));

			$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'businessroy_breadcrumbs_image', array(
				'label'	   => esc_html__('Upload Breadcrumbs Background Image','business-roy'),
				'section'  => 'businessroy_breadcrumb',
				'type'	   => 'image',
			)));


		/**
		 * Blog Template.
		*/
		$wp_customize->add_section('businessroy_blog_template', array(
			'title'		  => esc_html__('Blog Template Settings','business-roy'),
			'priority'	  => 65,
		));


			//  Blog Template Blog Posts by Category.
			$wp_customize->add_setting('businessroy_blogtemplate_postcat', array(
			    'sanitize_callback' => 'sanitize_text_field',     //done
			));

			$wp_customize->add_control(new Businessroy_Multiple_Check_Control($wp_customize, 'businessroy_blogtemplate_postcat', array(
			    'label'    => esc_html__('Select Category To Show Posts', 'business-roy'),
			    'settings' => 'businessroy_blogtemplate_postcat',
			    'section'  => 'businessroy_blog_template',
			    'choices'  => $blog_cat,
			    'description' => esc_html__('Note: Selected Category Only Work When you can select page template (
			    	Blog Template )','business-roy'),
			)));



			// Blog Sidebar Options.
			$wp_customize->add_setting('businessroy_blog_template_sidebar', array(
			    'default' => 'right',
			    'sanitize_callback' => 'businessroy_sanitize_select',     //done
			));

			$wp_customize->add_control('businessroy_blog_template_sidebar', array(
			    'label'   => esc_html__('Blog Template Layout Settings', 'business-roy'),
			    'section' => 'businessroy_blog_template',
			    'type'    => 'select',
			    'description' => esc_html__('Note: Blog Template Layout Only Work When you can select page template ( Blog Template )','business-roy'),
			    'choices' => array(
			        'right' => esc_html__('Content / Sidebar', 'business-roy'),
			        'left' => esc_html__('Sidebar / Content', 'business-roy'),
			        'no' => esc_html__('Full Width', 'business-roy'),
			    ),
			));


		$post_layout = array(
	        'none'  => esc_html__( 'Normal Layout', 'business-roy' ),
	        'masonry2-rsidebar'  => esc_html__( 'Masonry Layout', 'business-roy' )
	    );

			// Blog Template Layout.
			$wp_customize->add_setting('businessroy_blogtemplate_layout', array(
				'default'		=>	'none',
				'sanitize_callback'	=> 'businessroy_sanitize_select',	//done
			));

			$wp_customize->add_control('businessroy_blogtemplate_layout', array(
				'label'		=>	esc_html__('Post Display Layout','business-roy'),
				'section'	=> 'businessroy_blog_template',
				'type'		=> 'select',
				'choices' 	=> $post_layout
			));


		$post_description = array(
	        'none'     => esc_html__( 'None', 'business-roy' ),
	        'excerpt'  => esc_html__( 'Post Excerpt', 'business-roy' ),
	        'content'  => esc_html__( 'Post Content', 'business-roy' )
	    );
	        
	        $wp_customize->add_setting( 
	            'businessroy_post_description_options', 

	            array(
	                'default'           => 'excerpt',
	                'sanitize_callback' => 'businessroy_sanitize_select'
	            ) 
	        );
	        
	        $wp_customize->add_control( 
	            'businessroy_post_description_options', 

	            array(
	                'type' => 'select',
	                'label' => esc_html__( 'Post Description', 'business-roy' ),
	                'section' => 'businessroy_blog_template',
	                'choices' => $post_description
	            ) 
	        );


			// Blog Template Read More Button.
			$wp_customize->add_setting( 'businessroy_blogtemplate_btn', array(
				'default'           => esc_html__( 'Continue Reading','business-roy' ),
				'sanitize_callback' => 'sanitize_text_field',		//done
			));

			$wp_customize->add_control('businessroy_blogtemplate_btn', array(
				'label'		  => esc_html__( 'Enter Blog Button Text', 'business-roy' ),
				'section'	  => 'businessroy_blog_template',
				'type' 		  => 'text',
			));


			/**
	         * Number field for Excerpt Length section
	         *
	         * @since 1.0.0
	         */
	        $wp_customize->add_setting(
	            'businessroy_post_excerpt_length',
	            array(
	                'default'    => 50,
	                'sanitize_callback' => 'absint'
	            )
	        );

	        $wp_customize->add_control(
	            'businessroy_post_excerpt_length',

	            array(
	                'type'      => 'number',
	                'label'     => esc_html__( 'Enter Posts Excerpt Length', 'business-roy' ),
	                'section'   => 'businessroy_blog_template',
	            )
	        );


	        /**
	         * Enable/Disable Option for Post Elements Date
	         *
	         * @since 1.0.0
	        */
	        $wp_customize->add_setting('businessroy_post_date_options', array(
			    'default' => 'enable',
			    'sanitize_callback' => 'businessroy_sanitize_switch',     //done
			));

			$wp_customize->add_control(new Businessroy_Switch_Control($wp_customize, 'businessroy_post_date_options', array(
			    'label' => esc_html__('Post Meta Date', 'business-roy'),
			    'settings' => 'businessroy_post_date_options',
			    'section' => 'businessroy_blog_template',
			    'switch_label' => array(
			        'enable' => esc_html__('Enable', 'business-roy'),
			        'disable' => esc_html__('Disable', 'business-roy'),
			    ),
			)));


	        /**
	         * Enable/Disable Option for Post Elements Comments
	         *
	         * @since 1.0.0
	         */
	        $wp_customize->add_setting('businessroy_post_comments_options', array(
			    'default' => 'enable',
			    'sanitize_callback' => 'businessroy_sanitize_switch',     //done
			));

			$wp_customize->add_control(new Businessroy_Switch_Control($wp_customize, 'businessroy_post_comments_options', array(
			    'label' => esc_html__('Post Meta Comments', 'business-roy'),
			    'settings' => 'businessroy_post_comments_options',
			    'section' => 'businessroy_blog_template',
			    'switch_label' => array(
			        'enable' => esc_html__('Enable', 'business-roy'),
			        'disable' => esc_html__('Disable', 'business-roy'),
			    ),
			)));


	        /**
	         * Enable/Disable Option for Post Elements Tags
	         *
	         * @since 1.0.0
	         */
	        $wp_customize->add_setting('businessroy_post_author_options', array(
			    'default' => 'enable',
			    'sanitize_callback' => 'businessroy_sanitize_switch',     //done
			));

			$wp_customize->add_control(new Businessroy_Switch_Control($wp_customize, 'businessroy_post_author_options', array(
			    'label' => esc_html__('Post Meta Author', 'business-roy'),
			    'settings' => 'businessroy_post_author_options',
			    'section' => 'businessroy_blog_template',
			    'switch_label' => array(
			        'enable' => esc_html__('Enable', 'business-roy'),
			        'disable' => esc_html__('Disable', 'business-roy'),
			    ),
			)));

}
add_action( 'customize_register', 'businessroy_customize_register' );


/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function businessroy_customize_partial_blogname() {

	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function businessroy_customize_partial_blogdescription() {

	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
*/
function businessroy_customize_preview_js() {

	wp_enqueue_script( 'businessroy-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'businessroy_customize_preview_js' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * Enqueue required scripts/styles for customizer panel
 *
 * @since 1.0.0
 *
 */
function businessroy_customize_scripts(){

    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/library/fontawesome/css/all.min.css');

    wp_enqueue_style('businessroy-customizer', get_template_directory_uri() . '/assets/css/customizer.css');

    wp_enqueue_script('businessroy-customizer', get_template_directory_uri() . '/assets/js/customizer-admin.js', array('jquery', 'customize-controls'), true);
}
add_action('customize_controls_enqueue_scripts', 'businessroy_customize_scripts');



add_action('wp_ajax_businessroy_sections_reorder', 'businessroy_sections_reorder');

function businessroy_sections_reorder() {

    if (isset($_POST['sections'])) {

        set_theme_mod('businessroy_frontpage_sections', $_POST['sections']);
    }

    wp_die();
}

function businessroy_get_section_position($key) {

    $sections = businessroy_homepage_section();

    $position = array_search($key, $sections);

    $return = ( $position + 1 ) * 10;

    return $return;
}

if( !function_exists('businessroy_homepage_section') ){

	function businessroy_homepage_section(){

		$defaults = apply_filters('businessroy_homepage_sections',
			array(
				'businessroy_promoservice_section',
				'businessroy_aboutus_section',
				'businessroy_video_calltoaction_section',
				'businessroy_service_section',
				'businessroy_calltoaction_section',
				'businessroy_recentwork_section',
				'businessroy_counter_section',
				'businessroy_blog_section',
				'businessroy_testimonial_section',
				'businessroy_team_section'
			)
		);

		$sections = get_theme_mod('businessroy_frontpage_sections', $defaults);
		
        return $sections;
	}
}


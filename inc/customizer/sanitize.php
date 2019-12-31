<?php
/**
 *
 * Sanitize checkbox.
 *
 * @param  $input Whether the checkbox is input.
 */
function businessroy_sanitize_checkbox( $input ) {
  return ( ( isset( $input ) && true === $input ) ? true : false );
}

/**
 * Repeat Fields Sanitization
*/
function businessroy_sanitize_repeater($input){ 

  $input_decoded = json_decode( $input, true );

  $allowed_html = array(
      'br' => array(),
      'em' => array(),
      'strong' => array(),
      'a' => array(
      'href' => array(),
      'class' => array(),
      'id' => array(),
      'target' => array()
      ),
      'button' => array(
      'class' => array(),
      'id' => array()
    )
  ); 

  if(!empty($input_decoded)) {

    foreach ($input_decoded as $boxes => $box ){
      foreach ($box as $key => $value){
        $input_decoded[$boxes][$key] = sanitize_text_field( $value );
      }
    }
    return json_encode($input_decoded);
  }      
    return $input;
}

/**
* Sanitization Select.
*/
function businessroy_sanitize_select( $input, $setting ){
  //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
  $input = sanitize_key($input);
  //get the list of possible select options 
  $choices = $setting->manager->get_control( $setting->id )->choices;
  //return input if valid or return default option
  return ( array_key_exists( $input, $choices ) ? $input : $setting->default );  
}

/**
 * Switch Sanitization Function.
 *
 * @since 1.1
 */
function businessroy_sanitize_switch($input) {

    $valid_keys = array(
      'enable'  => esc_html__( 'Enable', 'business-roy' ),
      'disable' => esc_html__( 'Disable', 'business-roy' )
    );

    if ( array_key_exists( $input, $valid_keys ) ) {
      return $input;
    } else {
      return '';
    }
}
<?php

require_once get_stylesheet_directory().'/includes/mentoring.php';
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
	wp_enqueue_style('bootstrap_css',get_stylesheet_directory_uri().'/schedule-bootstrap.css');
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );
// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

// Add custom action after WPForms form submission
add_action( 'wpforms_process_complete', 'send_data_to_laravel', 10, 4 );
function send_data_to_laravel( $entry, $form_data, $fields, $entry_id ) {
	// Extract the form data
    $form_id = $form_data['id'];
    $form_title = $form_data['title'];
    $form_fields = $fields['fields'];

    // Prepare the data to send
//     $data = array(
//         'form_id' => $form_id,
//         'form_title' => $form_title,
//         'form_data' => $form_fields
//     );
	
	if($form_id == 1502){
	//echo "<pre>";
		$form_data = $_POST['wpforms']['complete'];
		//echo "</pre>";
		$form_values = [];
		foreach($form_data as $field){
			if($field['id'] == 3){
				$form_values['name'] = $field['value']; 
			}
			else if($field['id'] == 4){
				$form_values['email'] = $field['value']; 
			}
			else if($field['id'] == 5){
				$form_values['project_info'] = $field['value']; 
			}
			else if($field['id'] == 6){
				$form_values['expect'] = $field['value']; 
			}
		}
	}
	
	 // Send the data to your Laravel endpoint
    $response = wp_remote_post( 'https://berta.mentoring.berlin/api/project-save', array(
        'body' => $form_values,
    ) );

    // Check the response status

	if (!is_wp_error($response) && $response['response']['code'] === 200) {
		 $body = json_decode($response['body'], true);
   		 $message = $body['message'];

    		// Now you can use the $message value as needed
   		 echo $message;
	}else {
 	    $body = json_decode($response['body'], true);
   		$message = $body['message'];
		
		echo "failed ".$message;
	}
	echo "<hr>";
	echo "<pre>";
	print_r($response);
	echo "</pre>";
	
	die("testing ");
	
}
// END ENQUEUE PARENT ACTION

// Start of Application form shortcode
function berta_application_form_shortcode() {
	ob_start();
	get_template_part('template-application');
	return ob_get_clean();    
 } 
 add_shortcode( 'application_form_shortcode', 'berta_application_form_shortcode' ); 
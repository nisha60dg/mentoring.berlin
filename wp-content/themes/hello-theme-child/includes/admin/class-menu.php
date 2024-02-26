<?php
defined("ABSPATH") or die("Sorry, Direct access is not allowed");

class Mentoring_Admin_Menu {
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_menus' ) );
	}
	
	public function register_menus() {
		$setings   = add_menu_page( __( 'Mentoring Settings', 'berry' ),    __( 'Mentoring Settings', 'berry' ),   'manage_options','berry-settings', 'mentoring_admin_settings'); 

		// add_action( 'admin_print_styles-' . $setings, 'mentoring_admin_custom_css' );
	}

}

function mentoring_admin_custom_css(){
	// wp_enqueue_style('berry-admin', get_stylesheet_directory_uri().'/includes/admin/assets/admin-styles.css');
	// wp_register_script('berry-admin', get_stylesheet_directory_uri().'/includes/admin/assets/admin-script.js', array(), null, true);
	// $attributes = array(
    //     'ajaxurl' => admin_url( 'admin-ajax.php' )
	// );
	// wp_localize_script('berry-admin','berry',$attributes );
	// wp_enqueue_script('berry-admin');
}

$admin_menu = new Mentoring_Admin_Menu;
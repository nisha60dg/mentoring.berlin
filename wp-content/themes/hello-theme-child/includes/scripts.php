<?php

function my_enqueue_front_scripts()
{
    // print_r('script');die;
    wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', array(), null, true);

    // pr(get_permalink(1253));die;
    if (get_the_ID() == 1207) {

        // // if (str_replace("/", "", $_SERVER['REQUEST_URI']) == 'register') {
        wp_enqueue_script('my-registration-scripts', get_stylesheet_directory_uri() . '/assets/js/registration-page.js', '', '1.0', true);
    }
    if (get_the_ID() == 1253) {
        // pr('in');die;
        wp_enqueue_script('jquery-stripe', 'https://js.stripe.com/v2/', array( 'jquery' ), '1.0', true);
        wp_enqueue_script('jquery-card','https://cdnjs.cloudflare.com/ajax/libs/jquery-creditcardvalidator/1.0.0/jquery.creditCardValidator.js', array( 'jquery' ), '1.0', true);
        wp_enqueue_script('abc', get_stylesheet_directory_uri() . '/assets/js/payment-page.js', array( 'jquery' ), '1.0', true);
    }
    // wp_enqueue_script('ajax-scripts', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js','','1.14.7',true);
    // wp_enqueue_script('boostrap-scripts', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js','','4.3.1',true);

}
add_action('wp_enqueue_scripts', 'my_enqueue_front_scripts');

<?php

class Mentoring_Shortcodes
{

    public function __construct()
    {
        add_shortcode('mentoring_products',              array($this, 'get_mentoring_products'));
    }

    /**
     * Get and Display Products from API
     *  
     */
    public function get_mentoring_products()
    {
      
        $response = mentoring()->RESTAPI->Products->get();
        if ($response->status != 1)
            return false;

        $products = $response->data->Products;
        ob_start();
        include(get_stylesheet_directory() . '/templates/template-products.php');
        return ob_get_clean();
    }
}
new Mentoring_Shortcodes;

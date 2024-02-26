<?php

class Mentoring_APIS {

	/**
	 * The Mentoring_Users APIs handler instance variable
	 *
	 * @access public
	 * @since  1.0
	 * @var    Mentoring_Users
	 */
	public $Users;
	
	/**
	 * The Mentoring_Mentees APIs handler instance variable
	 *
	 * @access public
	 * @since  1.0
	 * @var    Mentoring_Mentees
	 */
	public $Mentees;
	
	/**
	 * The Mentoring_Orders APIs handler instance variable
	 *
	 * @access public
	 * @since  1.0
	 * @var    Mentoring_Orders
	 */
	public $Orders;

	/**
	 * The Mentoring_Products APIs handler instance variable
	 *
	 * @access public
	 * @since  1.0
	 * @var    Mentoring_Products
	 */
	public $Products;
	
    
    public function __construct() {
        $this->setup_api_objects();
       
    }


    /**
	 * Setup all objects
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function setup_api_objects() {

        $this->Mentees       		= new Mentoring_Mentees;
        $this->Users       			= new Mentoring_Users;
        $this->Orders    			= new Mentoring_Orders;
        $this->Products    			= new Mentoring_Products;
    }


}

?>
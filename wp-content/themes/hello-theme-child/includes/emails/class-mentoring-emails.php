<?php
/**
 * Emails
 *
 * This class handles all emails sent through Mentoring
 *
 * @package     Mentoring
 * @subpackage  Classes/Emails
 * @copyright   Copyright (c) 2015, Amit Kumar
 * @license     http://opensource.org/license/gpl-2.1.php GNU Public License
 * @since       1.6
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Mentoring_Emails class
 *
 * @since 1.0
 */
class Mentoring_Emails{

	/**
	 * Holds the from address
	 *
	 * @since 1.0
	 */
	private $from_address;

	/**
	 * Holds the from name
	 *
	 * @since 1.0
	 */
	private $from_name;

	/**
	 * Holds the email content type
	 *
	 * @since 1.0
	 */
	private $content_type;

	/**
	 * Holds the email headers
	 *
	 * @since 1.0
	 */
	private $headers;

	/**
	 * Whether to send email in HTML
	 *
	 * @since 1.0
	 */
	private $html = true;

	/**
	 * The email template to use
	 *
	 * @since 1.0
	 */
	private $template;

	/**
	 * The header text for the email
	 *
	 * @since 1.0
	 */
	private $heading = '';


	/**
	 * Get things going
	 *
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {

		add_action( 'mentoring_email_send_before', array( $this, 'send_before' ) );
		add_action( 'mentoring_email_send_after', array( $this, 'send_after' ) );
	}
	
	/**
	 * Get Emails Headers
	 * 
	 * 
	 * @since 1.0
	 * @return void
	 */
	public function get_headers(){

		if ( ! $this->headers ) {
			$this->headers  = "From: {$this->get_from_name()} <{$this->get_from_address()}>\r\n";
			$this->headers .= "Reply-To: {$this->get_from_address()}\r\n";
			$this->headers .= "Content-Type: {$this->get_content_type()}; charset=utf-8\r\n";
		}

		return apply_filters( 'mentoring_email_headers', $this->headers, $this );
	}

	/**
	 * Send the email
	 *
	 * @since 1.0
	 * @param string $to The To address
	 * @param string $subject The subject line of the email
	 * @param string $message The body of the email
	 * @param string|array $attachments Attachments to the email
	 */
	public function send( $emails, $subject, $message, $attachments = '' ) {

		if ( ! did_action( 'init' ) && ! did_action( 'admin_init' ) ) {
			_doing_it_wrong( __FUNCTION__, __( 'You cannot send emails with Mentoring_Emails until init/admin_init has been reached', 'wp-affiliates-coupons' ), null );
			return false;
		}

		/**
		 * Hooks before email is sent
		 *
		 * @since 1.0
		 */
		do_action( 'mentoring_email_send_before', $this );

		$message = $this->text_to_html( $message );

		$attachments = apply_filters( 'mentoring_email_attachments', $attachments, $this );

		$emails = explode(",", $emails);
		
		foreach($emails as $to){
			
			$sent = wp_mail( $to, $subject, $message, $this->get_headers(), $attachments );
		}

		/**
		 * Hooks after the email is sent
		 *
		 * @since 1.0
		 */
		do_action( 'mentoring_email_send_after', $this );

		return $sent;
	}

	/**
	 * Get the email from name
	 *
	 * @since 1.0
	 * @return string The email from name
	 */
	public function get_from_name() {

		if ( ! $this->from_name ) {
			$this->from_name = get_bloginfo( 'name' );
		}

		return apply_filters( 'mentoring_email_from_name', wp_specialchars_decode( $this->from_name ), $this );
	}

	/**
	 * Get the email from address
	 *
	 * @since 1.0
	 * @return string The email from address
	 */
	public function get_from_address() {
		if ( ! $this->from_address ) {
			$this->from_address = get_option( 'admin_email' );
		}

		return apply_filters( 'mentoring_email_from_address', $this->from_address, $this );
	}

	/**
	 * Get the email content type
	 *
	 * @since 1.0
	 * @return string The email content type
	 */
	public function get_content_type() {

		$this->content_type = 'text/html';

		return apply_filters( 'mentoring_email_content_type', $this->content_type, $this );
	}

	/**
	 * Converts text formatted HTML. This is primarily for turning line breaks into <p> and <br/> tags.
	 *
	 * @since 1.0
	 * @since 2.2.17 Adjusted the `wpautop()` call to no longer convert line breaks
	 */
	public function text_to_html( $message ) {
		if ( 'text/html' === $this->content_type || true === $this->html ) {
			$message = wpautop( make_clickable( $message ), false );
			$message = str_replace( '&#038;', '&amp;', $message );
		}

		return $message;
	}

	/**
	 * Add filters/actions before the email is sent
	 *
	 * @since 1.0
	 */
	public function send_before() {
		add_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		add_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		add_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );
	}

	/**
	 * Remove filters/actions after the email is sent
	 *
	 * @since 1.0
	 */
	public function send_after() {
		remove_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		remove_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		remove_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );

		// Reset heading to an empty string
		$this->heading = '';
	}
	
}

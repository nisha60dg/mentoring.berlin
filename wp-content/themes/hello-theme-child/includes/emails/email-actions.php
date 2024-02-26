<?php

/**
 * Manage all the email related actions
 *  
 * @package Mentoring\Emails
 * @since 1.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Sends a Verification email to newly registered Mentee User
 *
 * @since 1.0
 * @param object $user The ID of the assessment
 * @return void
 */
function process_mentoring_email_account_verification_notification($user_id = '')
{

	// pr($args, true);
	if (empty($user_id))
		return false;
		


	// Get User from CRM using Users Get API Endpoint
	$userResponse = mentoring()->RESTAPI->Users->get($user_id);
	// 
	// IF user empty return false;
	if ($userResponse->status == false)
		return false;

	// else define email object
	$emails = new Mentoring_Emails;

	$user = $userResponse->data;

	// $subject = 'Verify Your Email';
	$subject = 'Bestätigen Sie Ihre E-Mail';

	// include email subject content
	ob_start();
	include(get_stylesheet_directory() . '/templates/emails/email-verify-account-notification.php');
	$message = ob_get_clean();

	// echo $message; die;
	// Send email to the user
	if ($emails->send($user->email, $subject, $message))
		return true;

	return false;
}
add_action('mentoring_email_account_verification_notification', 'process_mentoring_email_account_verification_notification', 10, 2);


/**
 * Sends a Verified email to newly registered Mentee User
 *
 * @since 1.0
 * @param object $user The ID of the assessment
 * @return void
 */
function process_mentoring_email_account_verified($user_id = '')
{
	if (empty($user_id))
		return false;

	$userResponse = mentoring()->RESTAPI->Users->get($user_id);
	// 
	// IF user empty return false;
	if ($userResponse->status == false)
		return false;

	// else define email object
	$emails           = new Mentoring_Emails;

	$user = $userResponse->data;

	$subject = 'Verified Your Email';

	// include email subject content
	ob_start();
	include(get_stylesheet_directory() . '/templates/emails/email-verified-account-notification.php');
	$message = ob_get_clean();

	// echo $message; die;
	// Send email to the user
	if ($emails->send($user->email, $subject, $message))
		return true;

	return false;
}
add_action('mentoring_email_account_verified', 'process_mentoring_email_account_verified', 10, 2);


function process_mentoring_email_order_confirmation($data)
{

	if (empty($data['user_id']) && empty($data['mentee_id']))
		return false;

	$userResponse = mentoring()->RESTAPI->Users->get($data['user_id']);
	if ($userResponse->status == false)
		return false;

	$orderResponse = mentoring()->RESTAPI->Orders->get($data);
	if ($orderResponse->status == false)
		return false;
	$emails           = new Mentoring_Emails;

	$user = $userResponse->data;

	$subject = 'Order Reciept';

	// include email subject content
	ob_start();
	include(get_stylesheet_directory() . '/templates/emails/email-order-reciept-notification.php');
	$message = ob_get_clean();

	// echo $message; die;
	// Send email to the user
	if ($emails->send($user->email, $subject, $message))
		return true;

	return false;
}
add_action('mentoring_email_order_confirmation', 'process_mentoring_email_order_confirmation', 10, 2);


function process_mentoring_email_application_confirmation($data)
{

	$emails  = new Mentoring_Emails;

	$user_name = $data[''];

	$subject = 'User Mentoring Application';

	// include email subject content
	ob_start();
	include(get_stylesheet_directory() . '/templates/emails/email-application-notification.php');
	$message = ob_get_clean();

	// echo $message; die;
	// Send email to the user
	if ($emails->send(get_bloginfo('admin_email'), $subject, $message))
		return true;

	return false; 
}
add_action('mentoring_email_application_confirmation', 'process_mentoring_email_application_confirmation', 10, 2);

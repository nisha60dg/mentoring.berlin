<?php
function mentoring_do_actions()
{
	// do_action('mentoring_email_account_verification_notification', 180); die;
	if (isset($_REQUEST['mentoring_action'])) {
		$action = $_REQUEST['mentoring_action'];

		/**
		 * Fires for every action passed via `mentoring_action`.
		 *
		 * The dynamic portion of the hook name, `$action`, refers to the action passed via
		 * the `mentoring_action` parameter.
		 *
		 * @param array $_REQUEST Request data.
		 */
		do_action("mentoring_{$action}", $_REQUEST);
	}
}
add_action('init', 'mentoring_do_actions', 9);


 // Read cookie for new user
 function berta_application_user_cookie($atts) {
	if(isset($_COOKIE['user_id']) && !empty($_COOKIE['user_id'])){
		$userData = mentoring()->RESTAPI->Users->get($_COOKIE['user_id']);
		if(isset($atts['var']) && $atts['var']=="name")
			return "<h1 class='heading-title text-white'><span class='text-accent'>Hallo ".$userData->data->name.",</span></h1>";
		elseif(isset($atts['var']) && $atts['var']=="email")
			return $userData->data->email;
		elseif(isset($atts['var']) && $atts['var']=="id")
			return $userData->data->id;
		elseif(isset($atts['var']) && $atts['var']=="only_name")
			return $userData->data->name;
	}
 } 
 //add_action('init', 'berta_application_user_cookie', 10);
 add_shortcode( 'read_user_cookie', 'berta_application_user_cookie' );

/**
 * User Login validate from CRM
 * 
 */
function process_mentoring_user_login($data)
{
	$errors = array();	
	if (!isset($data['email']) || empty($data['email'])) {
		$errors['required_email'] = "Email address field is required";
	} else {
		if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Enter a valid email address';
		}
	}
	if (!isset($data['password']) || empty($data['password'])) {
		$errors['invalid_password'] = "Password field is required.";
	}
	if (empty($errors)) {
		 $response = mentoring()->RESTAPI->Users->loginUser($data);
		 if ($response->status == true) {
			unset($_COOKIE['user_id']);
			setcookie('user_id', $response->data->id, time() + 86400, '/');
			//pr($response); die('herer');
			if($response->data->mentee_level=='Approved'){
				wp_safe_redirect(get_permalink(1369));
				exit;
			}else{
				wp_safe_redirect(get_permalink(1366));
				exit;
			}
		}else{
			if (isset($response->errors) && !empty($response->errors)) {
				$errors = $response->errors;
			} else if ($api_errors = mentoring()->RESTAPI->Mentees->get_errors()) {
				$errors = $api_errors;
			}
			mentoring()->Errors->add_errors($errors);
		}
	}else {
		mentoring()->Errors->add_errors($errors);
	}
}
add_action('mentoring_user_login', 'process_mentoring_user_login');

/**
 * Create New user and Mentee account on CRM
 * 
 */
function process_mentoring_user_registration($data)
{
	// pr($data);die;
	$errors = array();
	/*if (!isset($data['product_service']) || empty($data['product_service'])) {
		$errors['required_product_service'] = "Product Service Required Please Select Product and Then Register";
	} else {
		$product = mentoring()->RESTAPI->Products->get($data['product_service']);
		if ($product->status != 1) {
			$errors['product_service'] = 'Select Valid Product';
		}
	}*/
	if (!isset($data['first_name']) || empty($data['first_name'])) {
		$errors['invalid_first_name'] = "First Name is required.";
	}
	if (!isset($data['last_name']) || empty($data['last_name'])) {
		$errors['invalid_last_name'] = "Last Name is required.";
	}
	if (!isset($data['user_email']) || empty($data['user_email'])) {
		$errors['required_user_email'] = "Email Address is required";
	} else {
		if (!filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) {
			$errors['user_email'] = 'Enter Valid Email Address';
		}
	}
	if (!isset($data['user_password']) || empty($data['user_password'])) {
		$errors['invalid_password'] = "Password is required.";
	}else if(!isset($data['user_confirm_password']) || empty($data['user_confirm_password'])){
		$errors['invalid_password'] = "Confirm Password is required.";
	}
	else if ($data['user_password'] != $data['user_confirm_password']) {
		$errors['invalid_last_name'] = "Password & confirm password mismatch.";
	}

	/*if (!isset($data['schedule_days']) || empty($data['schedule_days'])) {
		$errors['invalid_schedule_days'] = "Schedule Days are required.";
	}
	if (!isset($data['schedule_timings']) || empty($data['schedule_timings'])) {
		$errors['invalid_schedule_timings'] = "Schedule Timings are required.";
	}*/
	if (!isset($data['privacy_policy']) || empty($data['privacy_policy'])) {
		$errors['required_privacy_policy'] = "Privacy Policy Field required";
	}
	if (!isset($data['terms_conditions']) || empty($data['terms_conditions'])) {
		$errors['required_terms_conditions'] = "Terms and Conditions Field required";
	}
	if (empty($errors)) {
		$data['user_name'] = $data['first_name'] . " " . $data['last_name'];
		$response = mentoring()->RESTAPI->Users->createUser($data);
		// pr($response); die;
		if ($response->status == 1) {
			// Update User meta with CRM USER ID
			$menteeArray = [
				'user_id' => $response->data->id,
				'mentee_status' => 'new',
				'mentee_level' => 'free',
				/*'schedule_days' => implode(",", $data['schedule_days']),
				'schedule_timings' => implode(",", $data['schedule_timings']),
				'free_strategy_newsletter' => isset($data['free_strategy_newsletter']) ? 1 : 0*/
			];
			$menteeResponse = mentoring()->RESTAPI->Mentees->_createMentee($menteeArray);

			if ($menteeResponse->status == 1) {
				do_action('mentoring_email_account_verification_notification', $menteeArray['user_id']);
				wp_safe_redirect(get_permalink(1234));
			// wp_safe_redirect(get_permalink(1366));
				exit;
			}else{
				if (isset($response->errors) && !empty($response->errors)) {
					$errors = $response->errors;
				} else if ($api_errors = mentoring()->RESTAPI->Mentees->get_errors()) {
					$errors = $api_errors;
				}
			}
			// pr($menteeResponse);die;
			/* if ($menteeResponse->status == 1) {
				$orderArray = [
					'mentee_id' => $menteeResponse->data->id,
					'product_id' => $product->data->id,
					'user_id' => $response->data->id,
					'order_status' => 'completed',
					'total_amount' => $product->data->product_price,
					'payment_status' => 'paid'
				];
				if ($product->data->product_price > 0) {
					$orderArray['order_status']		=	'pending';
					$orderArray['payment_status']	=	'unpaid';
				}
				$orderResponse = mentoring()->RESTAPI->Orders->_createOrder($orderArray);
				// pr($orderResponse);die;
				if ($orderResponse->status == 1) {
					if ($product->data->product_price > 0) {
						// setcookie('order_id',$orderResponse->data->id,time(),+86400,'/');
						setcookie('user_id', $response->data->id, time() + 86400, '/');
						setcookie('mentee_id', $menteeResponse->data->id, time() + 86400, '/');
						wp_safe_redirect(get_permalink(1253) . "?product_id=" . $data['product_id']); // payment page
						exit;
					} else {
						do_action('mentoring_email_account_verification_notification', $menteeArray['user_id']);
						wp_safe_redirect(get_permalink(1234));
						exit;
					}
				} else {
					if (isset($orderResponse->errors) && !empty($orderResponse->errors)) {
						$errors = $orderResponse->errors;
					} else if ($api_errors = mentoring()->RESTAPI->Orders->get_errors()) {
						$errors = $api_errors;
					}
				}
			} else {
				if (isset($response->errors) && !empty($response->errors)) {
					$errors = $response->errors;
				} else if ($api_errors = mentoring()->RESTAPI->Mentees->get_errors()) {
					$errors = $api_errors;
				}
			}*/
		} else {
			if (isset($response->errors) && !empty($response->errors)) {
				$errors = $response->errors;
			} else if ($api_errors = mentoring()->RESTAPI->Users->get_errors()) {
				$errors = $api_errors;
			}
		}
	}
	if (!empty($errors)) {
		mentoring()->Errors->add_errors($errors);
	}
}
add_action('mentoring_user_registration', 'process_mentoring_user_registration');

/**
 * Verify Mentee Email Verification
 * 
 */
function process_mentoring_account_verification($data)
{
	$errors = [];

	if (!isset($data['id']) || empty($data['id'])) {
		$errors['invalid_user_id'] = "Invalid Data!";
	}
	if(!isset($_COOKIE['user_id']) && empty($_COOKIE['user_id'])){
		setcookie('user_id', $data['id'], time() + 86400, '/');
	}
	if (empty($errors)) {
		$userArray = ['email_verified_at' => date("Y-m-d H:i:s")];
		$userResponse = mentoring()->RESTAPI->Users->_updateUser( base64_decode($data['id']), $userArray);
		if ($userResponse->status == 1) {
		 	wp_safe_redirect(get_permalink(1237) . '/?notice=verified');
		//	setcookie('user_id', $data['id'], time() + 86400, '/');
		//	wp_safe_redirect(get_permalink(1366));
			exit;
		} else {
			if (isset($userResponse->errors) && !empty($userResponse->errors)) {
				$errors = $userResponse->errors;
			} else if ($api_errors = mentoring()->RESTAPI->Users->get_errors()) {
				$errors = $api_errors;
			}
		}
	}

	if (!empty($errors)) {
		mentoring()->Errors->add_errors($errors);
	}
}
add_action('mentoring_account_verification', 'process_mentoring_account_verification');


/**
 * Accept User Applications validate from CRM
 * 
 */
function process_mentoring_user_application($data)
{
	// pr($data);die;
	$errors = array();	
	if (!isset($data['email']) || empty($data['email'])) {
		$errors['email'] = "Email address field is required";
	} else {
		if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Enter a valid email address';
		}
	}
	if (!isset($data['name']) || empty($data['name'])) {
		$errors['invalid_name'] = "Name field is required.";
	}
	if (!isset($data['project_dec']) || empty($data['project_dec'])) {
		$errors['invalid_desc'] = "Project description is required.";
	}
	if (empty($errors)) {
		 // pr($data);die;
		 $response = mentoring()->RESTAPI->Mentees->userApplication($data);
		// pr($response); die;
		 if ($response->status == true) {
			do_action('mentoring_email_application_confirmation', array('user_name' => $data['name'],'user_email' => $data['email'], 'project_dec' => $data['project_dec'], 'mentoring_dec' => $data['mentoring_dec']));
			wp_safe_redirect(get_permalink(1237) . '/?notice=app_submit');
			exit;
		}else{
			if (isset($response->errors) && !empty($response->errors)) {
				$errors = $response->errors;
			} else if ($api_errors = mentoring()->RESTAPI->Mentees->get_errors()) {
				$errors = $api_errors;
			}
			mentoring()->Errors->add_errors($errors);
		}
	}else {
		mentoring()->Errors->add_errors($errors);
	}
}
add_action('mentoring_user_application', 'process_mentoring_user_application');

/**
 * Order Page
 * 
 */
function process_mentoring_user_order($data)
{
	$errors = array();	
	if (!isset($data['privacy_policy']) || empty($data['privacy_policy'])) {
		$errors['privacy_policy'] = "Aktivieren Sie das Kontrollkästchen, um die Allgemeinen Geschäftsbedingungen zu lesen und zu akzeptieren.";
	} 
	if (!isset($data['terms_conditions']) || empty($data['terms_conditions'])) {
		$errors['terms_conditions'] = "Datenschutzbestimmungen gelesen und akzeptiert zu haben.";
	}
	if (!isset($data['free_strategy_newsletter']) || empty($data['free_strategy_newsletter'])) {
		$errors['invalid_desc'] = "Aktivieren Sie das Kontrollkästchen, um die Bedingungen der 30-tägigen Geld-zurück-Garantie zu akzeptieren.";
	}
	if (!isset($data['package_rate']) || empty($data['package_rate'])) {
		$errors['package_rate'] = "Select one of package";
	}
	if (empty($errors)) {
		 // pr($data);die;
		  wp_safe_redirect(get_permalink(1253) . '/?package='.$data['package_rate']); 
		  exit;
	}else {
		mentoring()->Errors->add_errors($errors);
	}
}
add_action('mentoring_user_order', 'process_mentoring_user_order');
/**
 * Make Payment
 * 
 */
function process_mentoring_make_payment($data)
{
	if (!empty($data['stripeToken'])) {
		//set stripe secret key and publishable key
	/*	$stripe = array(
			"secret_key"      => "sk_test_51MATb3EalNRZpH2GfT714wLdJS38FUvfQOLdqtpmemnnSYCF0GcgQ7HDtDEhNy2t7mPwNcyf1ypoPOMa7KEEUahW00TqcMpn5H",
			"publishable_key" => "pk_test_51MATb3EalNRZpH2GCjgQgZyHlBhV6iKjF9u4LZqQ3fh99yBqvPwyHiAblkrMyxBprW5FKodvKTz497KoIyHzcmvU00LzOel8L5"
		); */
		$stripe = array(
			"secret_key"      => "sk_test_51LX5UuKyiv2cxXNOmpeqoUF6kCgEmLWtdCUHEj0KwHDReDdLtZ5dx0kEa26a5uPzEpCi38cy9NBVoBOT4x5ngACD002eFdf82m",
			"publishable_key" => "pk_test_51LX5UuKyiv2cxXNOmVFgOaEUzFrmWMdgDzKoVRinA11m4bC69RUPxK7FcD8K7z7flJ4u8NlBUNgj5VXyeqL3Brno00nyKCCK2l"
		);
		\Stripe\Stripe::setApiKey($stripe['secret_key']);
		
		// $customer = \Stripe\Customer::create(array(
		// 	'source'  => $data['stripeToken'],
		// ));
		if (isset($_COOKIE['user_id']) && !empty($_COOKIE['user_id'])) {
			$userResponse = mentoring()->RESTAPI->Users->get($_COOKIE['user_id']);
		
			if ($userResponse->status == 1) {
				$customer = \Stripe\Customer::create(array(
					'name' => $userResponse->data->name,
					'email' => $userResponse->data->email,
					'source'  =>'tok_visa',
				));
				//pr($customer);die;
				// details for which payment performed
				$payDetails = \Stripe\Charge::create(array(
					'customer' => $customer->id,
					'amount'   => ($data['total_amount'] * 100),
					'currency' =>  $data['currency_code'],
					'description' => $data['item_details'],
					//'source' => $data['stripeToken'],
				));
				// get payment details
				$paymenyResponse = $payDetails->jsonSerialize();
			//	pr($paymenyResponse);die;
				if ($paymenyResponse['status'] == 'succeeded') {
					// $successMessage = "The payment was successful. Order ID: {$data['order_number']}";
					if (isset($_COOKIE['user_id']) && !empty($_COOKIE['user_id'])) {
						// save order
						$orderArray = [
							'user_id'	=> $userResponse->data->id,
							'mentee_id'	=> $userResponse->data->mentee_id,
							'product_id' => 1,
							'order_status' => 'completed',
							'payment_status' => 'paid',
							'transaction_id' => $paymenyResponse['id'],
							'total_amount'	=>  $paymenyResponse['amount'] / 100,
							'rate_type'	=> $data['item_details'],
							'time'	=> $data['item_number'],
						];
					//	pr($orderArray);
						$orderResponse = mentoring()->RESTAPI->Orders->_createOrder($orderArray);
					//	pr($orderResponse);
					//	die();
						if ($orderResponse->status == 1) {
							do_action('mentoring_email_order_confirmation', array('user_id' => $userResponse->data->id, 'mentee_id' => $userResponse->data->mentee_id, 'transaction_id' => $paymenyResponse['id'], 'amount' => $paymenyResponse['amount'], 'currency' => $paymenyResponse['currency']));
							wp_safe_redirect(get_permalink(1237) . '/?notice=registered');
							exit;
							/*$userArray = ['email_verified_at' => date("Y-m-d H:i:s")];
							$userResponse = mentoring()->RESTAPI->Users->_updateUser($_COOKIE['user_id'], $userArray);
							if ($userResponse->status == 1) {
								do_action('mentoring_email_account_verified', $_COOKIE['user_id']);
								do_action('mentoring_email_order_confirmation', array('user_id' => $userResponse->data->id, 'mentee_id' => $userResponse->data->mentee_id, 'transaction_id' => $paymenyResponse['id'], 'amount' => $paymenyResponse['amount'], 'currency' => $paymenyResponse['currency']));
								wp_safe_redirect(get_permalink(1237) . '/?notice=registered');
								exit;
							} else {
								if (isset($userResponse->errors) && !empty($userResponse->errors)) {
									$errors = $userResponse->errors;
								} else if ($api_errors = mentoring()->RESTAPI->Users->get_errors()) {
									$errors = $api_errors;
								}
							}*/
						} else {
							if (isset($orderResponse->errors) && !empty($orderResponse->errors)) {
								$errors = $orderResponse->errors;
							} else if ($api_errors = mentoring()->RESTAPI->Mentees->get_errors()) {
								$errors = $api_errors;
							}
						}
						
					} else {
						$errors['order_error'] = "Invalid Data! Please try again.";
					}
				} else {

					$errors['payment_error'] = "Payment failed";
				}
			} else {
				if (isset($userResponse->errors) && !empty($userResponse->errors)) {
					$errors = $userResponse->errors;
				} else if ($api_errors = mentoring()->RESTAPI->Users->get_errors()) {
					$errors = $api_errors;
				}
			}
		} else {
			$errors['required_user'] = "User not found";
		}
	}
	if (!empty($errors)) {
		// pr($errors);
		// die;
		mentoring()->Errors->add_errors($errors);
	}
}
add_action('mentoring_make_payment', 'process_mentoring_make_payment');

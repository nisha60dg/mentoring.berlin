<?php

/**
 * Class Mentoring_Editions_API
 *
 * 
 */
class Mentoring_Users extends Mentoring_CURL
{

	private $errors;

	/**
	 * Object type to query for.
	 *
	 * @access public
	 * @since  1.0
	 * @var    string
	 */
	public $service = 'users';

	/**
	 * Object type to query for.
	 *
	 * @access public
	 * @since  1.0
	 * @var    string
	 */
	public $api_version = 'api/';

	/**
	 * Object type to query for.
	 *
	 * @access public
	 * @since  1.0
	 * @var    string
	 */
	public function get($user_id = '')
	{

		$args = array(
			'service'  =>  $this->api_version . $this->service,
		);

		if (isset($user_id) && !empty($user_id)) {
			$args['query_string'] = $user_id;
		}

		$response = $this->_get($args);

		$this->manage_response($response);

		if (empty($this->errors)) {
			return $response;
		}

		return false;
	}


	/**
	 * Object type to query for.
	 *
	 * @access public
	 * @since  1.0
	 * @var    string
	 */
	public function createUser($data)
	{

		$args = array(
			'service'  =>  $this->api_version . $this->service,
		);

		$args = wp_parse_args($data, $args);

		$response = $this->_post($args);

		$this->manage_response($response);

		if (empty($this->errors)) {
			return $response;
		}

		return false;
	}

	/**
	 * Object type to query for.
	 *
	 * @access public
	 * @since  1.0
	 * @var    string
	 */
	public function loginUser($data)
	{

		$args = array(
			'service'  =>  $this->api_version . $this->service . '/login',
		);

		$args = wp_parse_args($data, $args);

		$response = $this->_post($args);

		$this->manage_response($response);

		if (empty($this->errors)) {
			return $response;
		}

		return false;
	}


	public function _updateUser($user_id, $data)
	{
		if (empty($user_id))
			return false;

		$args = array(
			'service'  =>  $this->api_version . $this->service,
		);

		$query_string_array = !empty($user_id) ? $user_id : '';
		$args['query_string'] = $query_string_array;

		$args = wp_parse_args($data, $args);

		$response = $this->_put($args);
		$this->manage_response($response);

		if (empty($this->errors)) {
			return $response;
		}

		return false;
	}
	/**
	 * Object type to query for.
	 *
	 * @access public
	 * @since  1.0
	 * @var    string
	 */
	public function default_args()
	{
		return array(
			'service'  =>  $this->api_version . $this->service,
		);
	}

	/**
	 * Object type to query for.
	 *
	 * @access public
	 * @since  1.0
	 * @var    string
	 */
	public function manage_response($response)
	{

		$response_statuses = $this->mentoring_api_error_statuses();

		if (array_key_exists($response->response_code, $response_statuses)) {
			$this->add_error($response->code, $response->message);
		} else {
			return true;
		}
	}

	/**
	 * Register a submission error
	 *
	 * @since 1.0
	 */
	public function add_error($error_id, $message = '')
	{
		$this->errors[$error_id] = $message;
	}

	/**
	 * Print errors
	 *
	 * @since 1.0
	 */
	public function print_errors()
	{

		if (empty($this->errors)) {
			return;
		}

		echo '<div class="alert alert-danger mentoring-errors">';

		foreach ($this->errors as $error_id => $error) {

			echo '<p class="mentoring-error">' . esc_html($error) . '</p>';
		}

		echo '</div>';
	}

	/**
	 * Get errors
	 *
	 * @since 1.1
	 * @return array
	 */
	public function get_errors()
	{

		if (empty($this->errors)) {
			return array();
		}

		return $this->errors;
	}
}

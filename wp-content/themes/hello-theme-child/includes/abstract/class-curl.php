<?php
/**
 * Mentoring_CURL base class.
 *
 * The base class for all curl objects.
 *
 * @since  1.0
 */
abstract class Mentoring_CURL {


	/**
	 * Curl API Call Headers.
	 *
	 * @access public
	 * @var    string
	 */
	public $headers;

	/**
	 * Curl API Call URL endpoint.
	 *
	 * @access public
	 * @var    string
	 */
	public $api_url;

	/**
	 * Curl API Call URL PORT.
	 *
	 * @access public
	 * @var    string
	 */
	public $port;

	/**
	 * Curl API Endpoint URL.
	 *
	 * @access public
	 * @var    string
	 */
	public $endpoint_url;

	/**
	 * Curl API Endpoint URL.
	 *
	 * @access public
	 * @var    string
	 */
	public $resource_type;
	
	/**
	 * Curl API Endpoint URL.
	 *
	 * @access public
	 * @var    string
	 */
	public $post_data;

	/**
	 * Curl API Endpoint URL.
	 *
	 * @access public
	 * @var    string
	 */
	public $curl_method;
	
	/**
	 * Curl API Endpoint URL.
	 *
	 * @access public
	 * @var    string
	 */
	public $url_query_string;
	
	
	/**
	 * Curl API URL Parameters.
	 *
	 * @access public
	 * @var    string
	 */
	public $url_params;
	
	/**
	 * Curl API Endpoint URL.
	 *
	 * @access public
	 * @var    string
	 */
	public $curl_resource;
	
	/**
	 * Curl API Endpoint URL.
	 *
	 * @access public
	 * @var    string
	 */
	public $curl_http_code;


	/**
	 * Curl API Endpoint URL.
	 *
	 * @access public
	 * @var    string
	 */
	public $response;
	

	/**
	 * Get things started
	 *
	 * @access public
	 * @since  1.0
	*/
	public function __construct() {
		
		$this->headers = array(
			'Content-Type: application/json',
		);

		$this->api_url = mentoring()->Settings->get( 'api_url' );

		$this->port = '';
		
	}
	
	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _reset_endpoint( $print = false) {

		$this->url_params = '';
		$this->url_query_string = '';
	}

	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function set_api_endpoint() {

		$endpoint_url = $this->api_url;
		
		$endpoint_url = (empty($this->port)) ? $endpoint_url : $endpoint_url.':'.$this->port;

		$endpoint_url = (empty($this->resource_type)) ? $endpoint_url : $endpoint_url.'/'.$this->resource_type;
		
		
		$endpoint_url = (empty($this->url_params)) ? $endpoint_url : $endpoint_url.'/'.$this->url_params;

		$this->endpoint_url = (empty($this->url_query_string)) ? $endpoint_url : $endpoint_url.'?'.$this->url_query_string;
	}

	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _get($args = '', $debug = false, $headers = array()) {
		
		
		//Set API Endpoint URL
		$this->_set_service_endpoint($args);
		
		//Process arguments
		$this->_process_args($args);

		// Set CURL request method type
		$this->curl_method = 'GET';

		if(!empty($headers)){
			$this->headers[] = $headers; 
		}
		
		if( $debug == true){
			$response = $this->_call(); 
			echo $this->endpoint_url; 
			pr($args);
			pr($this->headers);
			pr($this->post_data);
			pr($response); die;
		}

		// Call CURL request
		return $this->_call();
	}

	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _post($args, $debug = false, $headers = array()) {
		
		$this->_set_service_endpoint($args);

		//Process arguments
		$this->_process_args($args);

		// Set CURL request method type
		$this->curl_method = 'POST';

		if(!empty($headers)){
			$this->headers[] = $headers; 
		}

		if($debug == true){
			$response = $this->_call();
			echo "POST CURL REQUEST: ". $this->endpoint_url; 
			pr($this->headers);
			pr($this->post_data);
			pr($response); 
			die;
		}

		// Call CURL request
		return $this->_call();
	}

	/**
	 * PUT request to update API data.
	 *
	 * Call API endpoint URL to update the API data
	 *
	 * @access public
	 * @return array|false array on success or false as default
	 */
	public function _put($args, $debug = false, $headers = array()) {
		
		$this->_set_service_endpoint($args);

		//Process arguments
		$this->_process_args($args);

		// Set CURL request method type
		$this->curl_method = 'PUT';
		
		if(!empty($headers)){
			$this->headers[] = $headers; 
		}

		if($debug == true){
			// $response = $this->_call();
			echo "URL ". $this->endpoint_url; 
			pr($this->headers);
			pr($this->post_data);
			// pr($response); 
			die;
		}

		// Call CURL request
		return $this->_call();
	}

	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _delete($args = '', $debug = false) {
		
		//Set API Endpoint URL
		$this->_set_service_endpoint($args);

		//Process arguments
		$this->_process_args($args);

		// Set CURL request method type
		$this->curl_method = 'DELETE';

		if($debug == true){
			$response = $this->_call();
			echo $this->endpoint_url; 
			pr($args);
			pr($this->headers);
			pr($this->post_data);
			pr($response); die;
		}

		// Call CURL request
		return $this->_call();
	}


	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _set_service_endpoint($args) {

		$this->_reset_endpoint();

		if(!isset($args['service']) || empty($args['service'])){
			return false;
		}

		$this->resource_type = $args['service'];
		
		$this->_manage_query_strings($args);

		//Set API Endpoint URL
		$this->set_api_endpoint();
	}

	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _manage_query_strings($args) {

		$this->url_query_string = '';
		if(isset($args['query_string']) && !empty($args['query_string'])){
			if(is_array($args['query_string']) || is_object($args['query_string'])){
				$this->url_query_string = http_build_query($args['query_string']);
			}else{
				$this->url_params = $args['query_string'];
			}
		}
	}

	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _call(){

		$this->_curl_init();

		$this->_curl_set_options();

		return $this->_exec();		
	}

	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _curl_init(){
		$this->curl_resource = curl_init();
		
	}


	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _curl_set_options(){

		curl_setopt( $this->curl_resource, CURLOPT_URL,$this->endpoint_url);

		curl_setopt( $this->curl_resource, CURLOPT_HTTPHEADER, $this->headers );
		
		curl_setopt( $this->curl_resource, CURLOPT_CUSTOMREQUEST, $this->curl_method );

		if( ($this->curl_method == "POST" || $this->curl_method == "PUT") && !empty($this->post_data)){

			curl_setopt( $this->curl_resource, CURLOPT_POST, true);

			curl_setopt( $this->curl_resource, CURLOPT_POSTFIELDS, $this->post_data );
		}else if($this->curl_method == "GET"){
			curl_setopt( $this->curl_resource, CURLOPT_HTTPGET, "GET" );
		}

		curl_setopt( $this->curl_resource, CURLOPT_RETURNTRANSFER, true );
	}

	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _exec(){
		
		$result = curl_exec($this->curl_resource);
		
		$this->curl_http_code = curl_getinfo($this->curl_resource, CURLINFO_HTTP_CODE);
		
		curl_close($this->curl_resource);
		
		return $this->_process_result($result);
	}


	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _process_args($args){

		if(isset($args['service'])){

			unset($args['service']);
		}
		if(isset($args['query_string'])){

			unset($args['query_string']);
		}

		$this->post_data = json_encode($args);
	}


	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _process_result($response){
		
		$response = json_decode($response);
		
		$response->response_code = $this->curl_http_code;

		return $response;
		
	}

	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _validate_auth_token(){

		return (isset($this->auth) && !empty($this->auth)) ? $this->auth : false;
		
	}

	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _response_handler($http_code){
		$response_statuses = $this->mentoring_api_error_statuses();
		return  array_key_exists( $http_code, $response_statuses ) ? $response_statuses[ $http_code ] : '';
		
	}

	/**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function mentoring_api_error_statuses(){ 		
		return  array(
			'400'	=>	'Bad Request',
			'401'	=>	'not authenticated',
			'403'	=>	'forbidden error',
			'404'	=>	'not found',
			'500'	=>	'general error',
			'501'	=>	'general error',
			'409'	=>	'Conflict',
		);
		
	}

}

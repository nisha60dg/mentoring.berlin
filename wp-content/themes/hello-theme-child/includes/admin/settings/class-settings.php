<?php

defined('ABSPATH') or die("Nope, Direct access is not allowed!");

class Mentoring_Settings {

	private $options;

	/**
	 * Get things started
	 *
	 * @since 1.0
	 * @return void
	*/
	public function __construct() {
		$this->options = get_option( 'mentoring_settings', array() );

		// Set up.
		add_action( 'admin_init', array( $this, 'register_settings' ) );		
	}	
	

	/**
	 * Get the value of a specific setting
	 *
	 * Note: By default, zero values are not allowed. If you have a custom
	 * setting that needs to allow 0 as a valid value, but sure to add its
	 * key to the filtered array seen in this method.
	 *
	 * @since  1.0
	 * @param  string  $key
	 * @param  mixed   $default (optional)
	 * @return mixed
	 */
	public function get( $key, $default = false ) {

		// Only allow non-empty values, otherwise fallback to the default
		$value = ! empty( $this->options[ $key ] ) ? $this->options[ $key ] : $default;

		/**
		 * Allow certain settings to accept 0 as a valid value without
		 * falling back to the default.
		 *
		 * @since  1.0
		 * @param  array
		 */
		$zero_values_allowed = (array) apply_filters( 'mentoring_settings_zero_values_allowed', array( 'referral_rate' ) );

		// Allow 0 values for specified keys only
		if ( in_array( $key, $zero_values_allowed ) ) {

			$value = isset( $this->options[ $key ] ) ? $this->options[ $key ] : null;
			$value = ( ! is_null( $value ) && '' !== $value ) ? $value : $default;

		}

		// Handle network-wide debug mode constant.
		if ( 'debug_mode' === $key ) {
			if ( defined( 'mentoring_WP_DEBUG' ) && mentoring_WP_DEBUG ) {
				$value = true;
			}
		}

		return $value;

	}

	/**
	 * Sets an option (in memory).
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param array $settings An array of `key => value` setting pairs to set.
	 * @param bool  $save     Optional. Whether to trigger saving the option or options. Default false.
	 * @return bool If `$save` is not false, whether the options were saved successfully. True otherwise.
	 */
	public function set( $settings, $save = false ) {
		foreach ( $settings as $option => $value ) {
			$this->options[ $option ] = $value;
		}

		if ( false !== $save ) {
			return $this->save();
		}

		return true;
	}

	/**
	 * Saves option values queued in memory.
	 *
	 * Note: If posting separately from the main settings submission process, this method should
	 * be called directly for direct saving to prevent memory pollution. Otherwise, this method
	 * is only accessible via the optional `$save` parameter in the set() method.
	 *
	 * @since 1.0
	 * @since 1.0 Added the `$options` parameter to facilitate direct saving.
	 * @access protected
	 *
	 * @see MyTemperament_Settings::set()
	 *
	 * @param array $options Optional. Options to save/overwrite directly. Default empty array.
	 * @return bool False if the options were not updated (saved) successfully, true otherwise.
	 */
	protected function save( $options = array() ) {
		$all_options = $this->get_all();

		if ( ! empty( $options ) ) {
			$all_options = array_merge( $all_options, $options );
		}

		$updated = update_option( 'mentoring_settings', $all_options );

		// Refresh the options array available in memory (prevents unexpected race conditions).
		$this->options = get_option( 'mentoring_settings', array() );

		return $updated;	
	}

	/**
	 * Get all settings
	 *
	 * @since 1.0
	 * @return array
	*/
	public function get_all() {
		return $this->options;
	}

	/**
	 * Add all settings sections and fields
	 *
	 * @since 1.0
	 * @return void
	*/
	function register_settings() {

		if ( false == get_option( 'mentoring_settings' ) ) {
			add_option( 'mentoring_settings' );
		}
		
		foreach( $this->get_registered_settings() as $tab => $settings ) {

			add_settings_section(
				'mentoring_settings_' . $tab,
				__return_null(),
				'__return_false',
				'mentoring_settings_' . $tab
			);

			foreach ( $settings as $key => $option ) {

				if( $option['type'] == 'checkbox' || $option['type'] == 'multicheck' || $option['type'] == 'radio' ) {
					$name = isset( $option['name'] ) ? $option['name'] : '';
				} else {
					$name = isset( $option['name'] ) ? '<label for="mentoring_settings[' . $key . ']">' . $option['name'] . '</label>' : '';
				}

				$callback = ! empty( $option['callback'] ) ? $option['callback'] : array( $this, $option['type'] . '_callback' );

				add_settings_field(
					'mentoring_settings[' . $key . ']',
					$name,
					is_callable( $callback ) ? $callback : array( $this, 'missing_callback' ),
					'mentoring_settings_' . $tab,
					'mentoring_settings_' . $tab,
					array(
						'id'       => $key,
						'desc'     => ! empty( $option['desc'] ) ? $option['desc'] : '',
						'name'     => isset( $option['name'] ) ? $option['name'] : null,
						'section'  => $tab,
						'size'     => isset( $option['size'] ) ? $option['size'] : null,
						'max'      => isset( $option['max'] ) ? $option['max'] : null,
						'min'      => isset( $option['min'] ) ? $option['min'] : null,
						'step'     => isset( $option['step'] ) ? $option['step'] : null,
						'options'  => isset( $option['options'] ) ? $option['options'] : '',
						'std'      => isset( $option['std'] ) ? $option['std'] : '',
						'disabled' => isset( $option['disabled'] ) ? $option['disabled'] : '',
						'class'    => isset( $option['class'] ) ? $option['class'] : ''
					)
				);
			}

		}

		// Creates our settings in the options table
		register_setting( 'mentoring_settings', 'mentoring_settings', array( $this, 'sanitize_settings' ) );

	}

	/**
	 * Retrieve the array of plugin settings
	 *
	 * @since 1.0
	 * @return array
	*/
	function sanitize_settings( $input = array() ) {

		if ( empty( $_POST['_wp_http_referer'] ) ) {
			return $input;
		}

		parse_str( $_POST['_wp_http_referer'], $referrer );

		$saved    = get_option( 'mentoring_settings', array() );
		if( ! is_array( $saved ) ) {
			$saved = array();
		}
		$settings = $this->get_registered_settings();
		$tab      = isset( $referrer['tab'] ) ? $referrer['tab'] : 'api_endpoints';

		$input = $input ? $input : array();

		/**
		 * Filters the input value for the MyTemperament settings tab.
		 *
		 * This filter is appended with the tab name, followed by the string `_sanitize`, for example:
		 *
		 *     `mentoring_settings_misc_sanitize`
		 *     `mentoring_settings_integrations_sanitize`
		 *
		 * @param mixed $input The settings tab content to sanitize.
		 */
		$input = apply_filters( 'mentoring_settings_' . $tab . '_sanitize', $input );

		// Ensure a value is always passed for every checkbox
		if( ! empty( $settings[ $tab ] ) ) {
			foreach ( $settings[ $tab ] as $key => $setting ) {

				// Single checkbox
				if ( isset( $settings[ $tab ][ $key ][ 'type' ] ) && 'checkbox' == $settings[ $tab ][ $key ][ 'type' ] ) {
					$input[ $key ] = ! empty( $input[ $key ] );
				}

				// Multicheck list
				if ( isset( $settings[ $tab ][ $key ][ 'type' ] ) && 'multicheck' == $settings[ $tab ][ $key ][ 'type' ] ) {
					if( empty( $input[ $key ] ) ) {
						$input[ $key ] = array();
					}
				}
			}
		}

		// Loop through each setting being saved and pass it through a sanitization filter
		foreach ( $input as $key => $value ) {

			// Get the setting type (checkbox, select, etc)
			$type              = isset( $settings[ $tab ][ $key ][ 'type' ] ) ? $settings[ $tab ][ $key ][ 'type' ] : false;
			$sanitize_callback = isset( $settings[ $tab ][ $key ][ 'sanitize_callback' ] ) ? $settings[ $tab ][ $key ][ 'sanitize_callback' ] : false;
			$input[ $key ]     = $value;

			if ( $type ) {

				if( $sanitize_callback && is_callable( $sanitize_callback ) ) {

					add_filter( 'mentoring_settings_sanitize_' . $type, $sanitize_callback, 10, 2 );

				}

				/**
				 * Filters the sanitized value for a setting of a given type.
				 *
				 * This filter is appended with the setting type (checkbox, select, etc), for example:
				 *
				 *     `mentoring_settings_sanitize_checkbox`
				 *     `mentoring_settings_sanitize_select`
				 *
				 * @param array  $value The input array and settings key defined within.
				 * @param string $key   The settings key.
				 */
				$input[ $key ] = apply_filters( 'mentoring_settings_sanitize_' . $type, $input[ $key ], $key );
			}

			/**
			 * General setting sanitization filter
			 *
			 * @param array  $input[ $key ] The input array and settings key defined within.
			 * @param string $key           The settings key.
			 */
			$input[ $key ] = apply_filters( 'mentoring_settings_sanitize', $input[ $key ], $key );

			// Now remove the filter
			if( $sanitize_callback && is_callable( $sanitize_callback ) ) {

				remove_filter( 'mentoring_settings_sanitize_' . $type, $sanitize_callback, 10 );

			}
		}

		add_settings_error( 'mytemp-notices', '', __( 'Settings updated.', 'mentoring' ), 'updated' );

		return array_merge( $saved, $input );

	}

	/**
	 * Sanitize the referral variable on save
	 *
	 * @since 1.0
	 * @return string
	*/
	public function sanitize_referral_variable( $value = '', $key = '' ) {

		if( 'referral_var' === $key ) {

			if( empty( $value ) ) {

				$value = 'ref';

			} else {

				$value = sanitize_key( $value );

			}

			update_option( 'mentoring_flush_rewrites', '1' );

		}

		return $value;
	}

	/**
	 * Sanitize text fields
	 *
	 * @since 1.0
	 * @return string
	*/
	public function sanitize_text_fields( $value = '', $key = '' ) {
		return sanitize_text_field( $value );
	}

	/**
	 * Sanitize URL fields
	 *
	 * @since 1.0
	 * @return string
	*/
	public function sanitize_url_fields( $value = '', $key = '' ) {
		return sanitize_text_field( $value );
	}

	/**
	 * Sanitize checkbox fields
	 *
	 * @since 1.0
	 * @return int
	*/
	public function sanitize_cb_fields( $value = '', $key = '' ) {
		return absint( $value );
	}

	/**
	 * Sanitize number fields
	 *
	 * @since 1.0
	 * @return int
	*/
	public function sanitize_number_fields( $value = '', $key = '' ) {
		return floatval( $value );
	}

	/**
	 * Sanitize rich editor fields
	 *
	 * @since 1.0
	 * @return int
	*/
	public function sanitize_rich_editor_fields( $value = '', $key = '' ) {
		return wp_kses_post( $value );
	}

	/**
	 * Set the capability needed to save mentoring settings
	 *
	 * @since 1.0
	 * @return string
	*/
	public function option_page_capability( $capability ) {
		return 'manage_mentoring_options';
	}

	/**
	 * Retrieve the array of plugin settings
	 *
	 * @since 1.0
	 * @return array
	*/
	function get_registered_settings() {

		// get currently logged in username
		$user_info = get_userdata( get_current_user_id() );
		$username  = $user_info ? esc_html( $user_info->user_login ) : '';

		//$emails_tags_list = mentoring_get_emails_tags_list();
		$emails_tags_list = '';

		$settings = array(
			/**
			 * Filters the default "General" settings.
			 *
			 * @param array $settings General settings.
			 */
			'api_endpoints'	=> apply_filters('mentoring_api_endpoints_settings',
				array(
					'api_endpoints_settings_header'	=>	array(
						'name' => '<strong>' . __( 'API Settings', 'mentoring' ) . '</strong>',
						'desc' => '',
						'type' => 'header'						
					),
                    'api_url' => array(
						'name' => __( 'API URL', 'mentoring' ),
						'desc' => __( 'Please enter the API URL.', 'mentoring' ),
						'type' => 'text',
						'sanitize_callback' => 'sanitize_text_field'
					),
				)
			),
			'payment_gateways' => apply_filters( 'mentoring_shortcodes',
				array(
					'payment_options_header' => array(
						'name' => '<strong>' . __( 'Stripe Settings', 'wp-affiliates-coupons' ) . '</strong>',
						'desc' => '',
						'type' => 'header'
					),
					'stripe_secret_key' => array(
						'name' => __( 'Secret Key', 'wp-affiliates-coupons' ),
						'desc' => __( "Please add your Stripe Secrte Key.", 'wp-affiliates-coupons' ),
						'type' => 'text',
                        'sanitize_callback' => 'sanitize_text_field'
					),
					'stripe_publication_key' => array(
						'name' => __( 'Publication Key', 'wp-affiliates-coupons' ),
						'desc' => __( "Please add your Stripe Merchant Account's Publication Key.", 'wp-affiliates-coupons' ),
						'type' => 'text',
                        'sanitize_callback' => 'sanitize_text_field'
                    ),
                    /*'staging_mode' => array(
						'name' => __( 'Staging Mode', 'mentoring' ),
						'desc' => __( 'Check this chechbox to enable the Staging mode for testing.', 'mentoring' ),
						'type' => 'checkbox'
					),*/
				)
			)
		);

		/**
		 * Filters the entire default settings array.
		 *
		 * @param array $settings Array of default settings.
		 */
		return apply_filters( 'mentoring_settings', $settings );
	}

	/**
	 * Header Callback
	 *
	 * Renders the header.
	 *
	 * @since 1.0
	 * @param array $args Arguments passed by the setting
	 * @return void
	 */
	function header_callback( $args ) {
		echo '<hr/>';
	}

	/**
	 * Checkbox Callback
	 *
	 * Renders checkboxes.
	 *
	 * @since 1.0
	 * @param array $args Arguments passed by the setting
	 * @global $this->options Array of all the MyTemperament Options
	 * @return void
	 */
	function checkbox_callback( $args ) {

		$checked  = isset( $this->options[ $args['id'] ] ) ? checked( 1, $this->options[ $args['id'] ], false) : '';
		$disabled = $this->is_setting_disabled( $args ) ? disabled( $args['disabled'], true, false ) : '';

		$html = '<label for="mentoring_settings[' . $args['id'] . ']">';
		$html .= '<input type="checkbox" id="mentoring_settings[' . $args['id'] . ']" name="mentoring_settings[' . $args['id'] . ']" value="1" ' . $checked . ' ' . $disabled . '/>&nbsp;';
		$html .= $args['desc'];
		$html .= '</label>';

		echo $html;
	}

	/**
	 * Multicheck Callback
	 *
	 * Renders multiple checkboxes.
	 *
	 * @since 1.0
	 * @param array $args Arguments passed by the setting
	 * @global $this->options Array of all the MyTemperament Options
	 * @return void
	 */
	function multicheck_callback( $args ) {

		if ( ! empty( $args['options'] ) ) {
			foreach( $args['options'] as $key => $option ) {
				if( isset( $this->options[$args['id']][$key] ) ) { $enabled = $option; } else { $enabled = NULL; }
				echo '<label for="mentoring_settings[' . $args['id'] . '][' . $key . ']">';
				echo '<input name="mentoring_settings[' . $args['id'] . '][' . $key . ']" id="mentoring_settings[' . $args['id'] . '][' . $key . ']" type="checkbox" value="' . $option . '" ' . checked($option, $enabled, false) . '/>&nbsp;';
				echo $option . '</label><br/>';
			}
			echo '<p class="description">' . $args['desc'] . '</p>';
		}
	}

	/**
	 * Radio Callback
	 *
	 * Renders radio boxes.
	 *
	 * @since 1.0
	 * @param array $args Arguments passed by the setting
	 * @global $this->options Array of all the MyTemperament Options
	 * @return void
	 */
	function radio_callback( $args ) {

		foreach ( $args['options'] as $key => $option ) :
			$checked = false;

			if ( isset( $this->options[ $args['id'] ] ) && $this->options[ $args['id'] ] == $key )
				$checked = true;
			elseif( isset( $args['std'] ) && $args['std'] == $key && ! isset( $this->options[ $args['id'] ] ) )
				$checked = true;

			echo '<label for="mentoring_settings[' . $args['id'] . '][' . $key . ']">';
			echo '<input name="mentoring_settings[' . $args['id'] . ']" id="mentoring_settings[' . $args['id'] . '][' . $key . ']" type="radio" value="' . $key . '" ' . checked(true, $checked, false) . '/>&nbsp;';
			echo $option . '</label><br/>';
		endforeach;

		echo '<p class="description">' . $args['desc'] . '</p>';
	}

	/**
	 * Text Callback
	 *
	 * Renders text fields.
	 *
	 * @since 1.0
	 * @param array $args Arguments passed by the setting
	 * @global $this->options Array of all the MyTemperament Options
	 * @return void
	 */
	function text_callback( $args ) {

		if ( isset( $this->options[ $args['id'] ] ) && ! empty( $this->options[ $args['id'] ] ) )
			$value = $this->options[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		// Must use a 'readonly' attribute over disabled to ensure the value is passed in $_POST.
		$readonly = $this->is_setting_disabled( $args ) ? __checked_selected_helper( $args['disabled'], true, false, 'readonly' ) : '';

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="text" class="' . $size . '-text" id="mentoring_settings[' . $args['id'] . ']" name="mentoring_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '" ' . $readonly . '/>';
		$html .= '<p class="description">'  . $args['desc'] . '</p>';

		echo $html;
	}

	/**
	 * URL Callback
	 *
	 * Renders URL fields.
	 *
	 * @since 1.0
	 * @param array $args Arguments passed by the setting
	 * @global $this->options Array of all the MyTemperament Options
	 * @return void
	 */
	function url_callback( $args ) {

		if ( isset( $this->options[ $args['id'] ] ) )
			$value = $this->options[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="url" class="' . $size . '-text" id="mentoring_settings[' . $args['id'] . ']" name="mentoring_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		$html .= '<p class="description">'  . $args['desc'] . '</p>';

		echo $html;
	}


	/**
	 * Number Callback
	 *
	 * Renders number fields.
	 *
	 * @since 1.0
	 * @param array $args Arguments passed by the setting
	 * @global $this->options Array of all the MyTemperament Options
	 * @return void
	 */
	function number_callback( $args ) {

		// Get value, with special consideration for 0 values, and never allowing negative values
		$value = isset( $this->options[ $args['id'] ] ) ? $this->options[ $args['id'] ] : null;
		$value = ( ! is_null( $value ) && '' !== $value && floatval( $value ) >= 0 ) ? floatval( $value ) : null;

		// Saving the field empty will revert to std value, if it exists
		$std   = ( isset( $args['std'] ) && ! is_null( $args['std'] ) && '' !== $args['std'] && floatval( $args['std'] ) >= 0 ) ? $args['std'] : null;
		$value = ! is_null( $value ) ? $value : ( ! is_null( $std ) ? $std : null );
		$value = mentoring_abs_number_round( $value );

		// Other attributes and their defaults
		$max  = isset( $args['max'] )  ? $args['max']  : 999999999;
		$min  = isset( $args['min'] )  ? $args['min']  : 0;
		$step = isset( $args['step'] ) ? $args['step'] : 1;
		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';

		$html  = '<input type="number" step="' . esc_attr( $step ) . '" max="' . esc_attr( $max ) . '" min="' . esc_attr( $min ) . '" class="' . $size . '-text" id="mentoring_settings[' . $args['id'] . ']" name="mentoring_settings[' . $args['id'] . ']" placeholder="' . esc_attr( $std ) . '" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		$html .= '<p class="description"> '  . $args['desc'] . '</p>';

		echo $html;
	}

	/**
	 * Textarea Callback
	 *
	 * Renders textarea fields.
	 *
	 * @since 1.0
	 * @param array $args Arguments passed by the setting
	 * @global $this->options Array of all the MyTemperament Options
	 * @return void
	 */
	function textarea_callback( $args ) {

		if ( isset( $this->options[ $args['id'] ] ) )
			$value = $this->options[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<textarea class="large-text" cols="50" rows="5" id="mentoring_settings_' . $args['id'] . '" name="mentoring_settings[' . $args['id'] . ']">' . esc_textarea( stripslashes( $value ) ) . '</textarea>';
		$html .= '<p class="description"> '  . $args['desc'] . '</p>';

		echo $html;
	}

	/**
	 * Password Callback
	 *
	 * Renders password fields.
	 *
	 * @since 1.0
	 * @param array $args Arguments passed by the setting
	 * @global $this->options Array of all the MyTemperament Options
	 * @return void
	 */
	function password_callback( $args ) {

		if ( isset( $this->options[ $args['id'] ] ) )
			$value = $this->options[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="password" class="' . $size . '-text" id="mentoring_settings[' . $args['id'] . ']" name="mentoring_settings[' . $args['id'] . ']" value="' . esc_attr( $value ) . '"/>';
		$html .= '<p class="description"> '  . $args['desc'] . '</p>';

		echo $html;
	}

	/**
	 * Missing Callback
	 *
	 * If a function is missing for settings callbacks alert the user.
	 *
	 * @since 1.0
	 * @param array $args Arguments passed by the setting
	 * @return void
	 */
	function missing_callback($args) {
		printf( __( 'The callback function used for the <strong>%s</strong> setting is missing.', 'mentoring' ), $args['id'] );
	}

	/**
	 * Select Callback
	 *
	 * Renders select fields.
	 *
	 * @since 1.0
	 * @param array $args Arguments passed by the setting
	 * @global $this->options Array of all the MyTemperament Options
	 * @return void
	 */
	function select_callback($args) {

		if ( isset( $this->options[ $args['id'] ] ) )
			$value = $this->options[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		$html = '<select id="mentoring_settings[' . $args['id'] . ']" name="mentoring_settings[' . $args['id'] . ']"/>';

		foreach ( $args['options'] as $option => $name ) :
			$selected = selected( $option, $value, false );
			$html .= '<option value="' . $option . '" ' . $selected . '>' . $name . '</option>';
		endforeach;

		$html .= '</select>';
		$html .= '<p class="description"> '  . $args['desc'] . '</p>';

		echo $html;
	}

	/**
	 * Rich Editor Callback
	 *
	 * Renders rich editor fields.
	 *
	 * @since 1.0
	 * @param array $args Arguments passed by the setting
	 * @global $this->options Array of all the MyTemperament Options
	 * @global $wp_version WordPress Version
	 */
	function rich_editor_callback( $args ) {

		if ( isset( $this->options[ $args['id'] ] ) )
			$value = $this->options[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		ob_start();
		wp_editor( stripslashes( $value ), 'mentoring_settings_' . $args['id'], array( 'textarea_name' => 'mentoring_settings[' . $args['id'] . ']' ) );
		$html = ob_get_clean();

		$html .= '<br/><p class="description"> '  . $args['desc'] . '</p>';

		echo $html;
	}

	/**
	 * Upload Callback
	 *
	 * Renders file upload fields.
	 *
	 * @since 1.0
	 * @param array $args Arguements passed by the setting
	 */
	function upload_callback( $args ) {
		if( isset( $this->options[ $args['id'] ] ) )
			$value = $this->options[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="text" class="' . $size . '-text" id="mentoring_settings[' . $args['id'] . ']" name="mentoring_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		$html .= '<span>&nbsp;<input type="button" class="mentoring_settings_upload_button button-secondary" value="' . __( 'Upload File', 'mentoring' ) . '"/></span>';
		$html .= '<p class="description"> '  . $args['desc'] . '</p>';

		echo $html;
	}


	/**
	 * Handles overriding and disabling the debug mode setting if globally enabled.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function handle_global_debug_mode_setting() {
		if ( defined( 'mentoring_WP_DEBUG' ) && true === mentoring_WP_DEBUG ) {
			$this->options['debug_mode'] = 1;

			// Globally enabled.
			add_filter( 'mentoring_settings_misc', function( $misc_settings ) {
				$misc_settings['debug_mode']['disabled'] = true;
				$misc_settings['debug_mode']['desc']     = sprintf( __( 'Debug mode is globally enabled via <code>mentoring_WP_DEBUG</code> set in <code>wp-config.php</code>. This setting cannot be modified from this screen. Logs are kept in <a href="%s">Affiliates > Tools</a>.', 'mentoring' ), mentoring_admin_url( 'tools', array( 'tab' => 'system_info' ) ) );

				return $misc_settings;
			} );
		}
	}

	/**
	 * Determines whether a setting is disabled.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param array $args Setting arguments.
	 * @return bool True or false if the setting is disabled, otherwise false.
	 */
	public function is_setting_disabled( $args ) {
		if ( isset( $args['disabled'] ) ) {
			return $args['disabled'];
		}
		return false;
	}


	/**
	 * Retrieves site data (plugin versions, integrations, etc) to be sent.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @return array
	 */
	public function get_site_data() {

		$data = array();

		$theme_data = wp_get_theme();
		$theme      = $theme_data->Name . ' ' . $theme_data->Version;

		$data['php_version']  = phpversion();
		$data['mentoring_version']  = MYTEMPERAMENT_VERSION;
		$data['wp_version']   = get_bloginfo( 'version' );
		$data['server']       = isset( $_SERVER['SERVER_SOFTWARE'] ) ? $_SERVER['SERVER_SOFTWARE'] : '';
		$data['install_date'] = get_post_field( 'post_date', mentoring_get_affiliate_area_page_id() );
		$data['multisite']    = is_multisite();
		$data['url']          = home_url();
		$data['theme']        = $theme;

		// Retrieve current plugin information
		if( ! function_exists( 'get_plugins' ) ) {
			include ABSPATH . '/wp-admin/includes/plugin.php';
		}

		$plugins        = array_keys( get_plugins() );
		$active_plugins = get_option( 'active_plugins', array() );

		foreach ( $plugins as $key => $plugin ) {
			if ( in_array( $plugin, $active_plugins ) ) {
				// Remove active plugins from list so we can show active and inactive separately
				unset( $plugins[ $key ] );
			}
		}

		$data['active_plugins']   = $active_plugins;
		$data['inactive_plugins'] = $plugins;
		$data['locale']           = get_locale();
		$data['participants']     = my_temperament()->participants->count( array( 'number' => -1 ) );

		return $data;
	}
}
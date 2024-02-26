<?php
/**
 * Admin Options Page
 *
 * @package     MyTemperament
 * @subpackage  Admin/Settings
 * @copyright   Copyright (c) 2020, Amit Kumar
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Options Page
 *
 * Renders the options page contents.
 *
 * @since 1.0
 * @return void
 */
function mentoring_admin_settings() {
	$active_tab = isset( $_GET[ 'tab' ] ) && array_key_exists( $_GET['tab'], mentoring_get_settings_tabs() ) ? $_GET[ 'tab' ] : 'api_endpoints';

	ob_start();
	?>
	<div class="wrap">
		<h2 class="nav-tab-wrapper">
			<?php mentoring_navigation_tabs( mentoring_get_settings_tabs(), $active_tab, array( 'settings-updated' => false ) ); ?>
		</h2>
		<div id="tab_container">
			<form method="post" action="options.php">
				<table class="form-table">
				<?php
				settings_fields( 'mentoring_settings' );
				do_settings_fields( 'mentoring_settings_' . $active_tab, 'mentoring_settings_' . $active_tab );
				?>
				</table>
				<?php submit_button(); ?>
			</form>
		</div><!-- #tab_container-->
	</div><!-- .wrap -->
	<?php
	echo ob_get_clean();
}


/**
 * Retrieves the settings tabs.
 *
 * @since 1.0
 *
 * @return array $tabs Settings tabs.
 */
function mentoring_get_settings_tabs() {

	$tabs                 = array();
	// $tabs['general']      = __( 'General', 'wp-temperament-assessment' );
	$tabs['api_endpoints']         = __( 'API Endpoints', 'wp-temperament-assessment' );
	$tabs['payment_gateways']       = __( 'Payments', 'wp-temperament-assessment' );

	/**
	 * Filters the list of settings tabs.
	 *
	 * @param array $tabs Settings tabs.
	 */
	return apply_filters( 'mentoring_settings_tabs', $tabs );
}

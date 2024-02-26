<?php
if (!class_exists('Mentoring')) :

    /**
     * Main Mentoring Class
     *
     * @since 1.0
     */
    final class Mentoring
    {
        /**
         * Mentoring instance.
         *
         * @access private
         * @since  1.0
         * @var    Mentoring The one true Mentoring
         */
        private static $instance;
        public static function instance()
        {
            if (!isset(self::$instance) && !(self::$instance instanceof Mentoring)) {
                self::$instance = new Mentoring;

                self::$instance->includes();
                self::$instance->setup_objects();
            }
            return self::$instance;
        }

        private function includes()
        {

            require_once get_stylesheet_directory() . '/includes/actions.php';
            require_once get_stylesheet_directory() . '/includes/mentoring-actions.php';
            require_once get_stylesheet_directory() . '/includes/misc-functions.php';
            require_once get_stylesheet_directory() . '/includes/admin/settings/class-settings.php';
            require_once get_stylesheet_directory() . '/includes/abstract/class-curl.php';
            require_once get_stylesheet_directory() . '/includes/class-errors.php';
            if (is_admin() || (defined('WP_CLI') && WP_CLI)) {
                require_once get_stylesheet_directory() . '/includes/admin/class-menu.php';
                require_once get_stylesheet_directory() . '/includes/admin/settings/display-settings.php';
            }

            // Include APIs
            require_once get_stylesheet_directory() . '/includes/api/class-api.php';
            require_once get_stylesheet_directory() . '/includes/api/class-users-api.php';
            require_once get_stylesheet_directory() . '/includes/api/class-mentees-api.php';
            require_once get_stylesheet_directory() . '/includes/api/class-orders-api.php';
            require_once get_stylesheet_directory() . '/includes/api/class-products-api.php';
            require_once get_stylesheet_directory() . '/includes/emails/class-mentoring-emails.php';
            require_once get_stylesheet_directory() . '/includes/emails/email-actions.php';
            require_once get_stylesheet_directory() . '/includes/scripts.php';
            require_once get_stylesheet_directory() . '/includes/class-shortcodes.php';

            require_once get_stylesheet_directory() . '/vendor/autoload.php';
            // require_once get_stylesheet_directory() . '/includes/class-stripe.php';
        }

        public function setup_objects()
        {

            self::$instance->Settings           = new Mentoring_Settings;
            self::$instance->Errors             = new Mentoring_Errors;
            self::$instance->RESTAPI            = new Mentoring_APIS;
            self::$instance->emails             = new Mentoring_Emails;
            // echo "<pre>";
            // print_r(self::$instance);
            // die();
        }
    }

endif; // End if class_exists check

function mentoring()
{
    return Mentoring::instance();
}
mentoring();

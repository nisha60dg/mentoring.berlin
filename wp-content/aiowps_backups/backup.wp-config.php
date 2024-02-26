<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mentoring_berlin' );

/** Database username */
define( 'DB_USER', 'mentoring' );

/** Database password */
define( 'DB_PASSWORD', 'DeuwacBesGherrUtyon3Gryxryldif' );

/** Database hostname */
define( 'DB_HOST', 'mentor1.sql.ghserv.net' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'nkn1bzfsafobb1sv3g3xi3qqeeidue' );
define( 'SECURE_AUTH_KEY',  'jqoz4hjb8blnlke70q4if3x3y8jtml' );
define( 'LOGGED_IN_KEY',    'mff0b7sstb49uy2cbpssvspjv4t5o6' );
define( 'NONCE_KEY',        'g86jssvbyfdtvthrf77gn6p1mk9j6r' );
define( 'AUTH_SALT',        'azg4xa849f5rv13ym7vouz9ymv873b' );
define( 'SECURE_AUTH_SALT', 'gfszgmnz4utr10kwn7fdpo9d0eqbcv' );
define( 'LOGGED_IN_SALT',   'wfankdlzbs8d4pjmecy64j9q96nkpg' );
define( 'NONCE_SALT',       'ifc7uha3hysl3tw7mexx4ost9i7zr5' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

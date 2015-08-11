<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'mikesbq90_wp2');

/** MySQL database username */
define('DB_USER', 'mikesbq90_wp2');

/** MySQL database password */
define('DB_PASSWORD', 'JDK5JKGqU1n^7');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */

define('AUTH_KEY',         'V0e1q2YHb7JTgYX19VJI4WnE2NyabV0hRTxiytO9qvELy37bHq5DdUL0K3cgGjVD');
define('SECURE_AUTH_KEY',  'E1xICTFs4qwIZJEHsVIhv2hda2Xmp0DWtQAC0QcU5BRXguDPVGb4BJZD3e0Gdu7R');
define('LOGGED_IN_KEY',    'IhfAw6kNYPIpOxFxoIHGFRMV6Eoq2gFNHhoSDf9Xd3BtPqzEb5wjUZsuFNZk397e');
define('NONCE_KEY',        'ktxOFAVrbgg1Q8uvSnV5EkgyrWylDO1K3iZwYgGv8NjvGNpweMpeWH1NzG2jxUUy');
define('AUTH_SALT',        '57uMWspGGn76lU8KbUCJ5SebHJSqoGEMAGFREMCn7iDghhlPmIQtlVjiCrLLvlrw');
define('SECURE_AUTH_SALT', 'mN8PAgK3yd8JJKoLyHof1WJ59KnNITX66J2EiiYY3UQ4pPIsU6AYLOi8gMcXKgvy');
define('LOGGED_IN_SALT',   'arV1CzjzjEp3in0xcMwVI6EQ38YKIMRtBuV7W5w404m3FWv1XP3OxyhmuVgmnqhN');
define('NONCE_SALT',       'Nz4MZVfVbBhORtkFbNBJKHZEqRIW4zwWcFaPzrNDwt7fdvMXJccSIC7TScP42pUk');
define('WP_TEMP_DIR',      '/home/mikesbq90/domains/getdeals.nl/public_html/wp-content/uploads');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'nl_NL');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
if(false)//$_SERVER['REMOTE_ADDR'] == '113.170.22.160' || $_SERVER['REMOTE_ADDR'] == '113.170.13.86')
{
	define('WP_DEBUG', true);
}
else{
	define('WP_DEBUG', false);
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

function d($data,$die=false)
{
	if($_SERVER['REMOTE_ADDR'] == '113.170.22.160' || $_SERVER['REMOTE_ADDR'] == '113.170.13.86' || $_SERVER['REMOTE_ADDR'] == '123.22.28.242')
	{
		echo '<pre>';
		print_r($data);
		echo '<pre/>';
		
		if($die){
			echo "------------------------\n";
			die('exit by debug');
		} 
	}
}
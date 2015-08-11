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
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         ';8*|jix1snf^B~+#1UcNJ;Q1aUg=(FPDNo;FJhZ.<g}$Qtlhp(>SBgmCJm 2Blqf');
define('SECURE_AUTH_KEY',  '_l3PO+~+&JY,-q`b$A$G:C,a2CIWkV._/:|+y 2_TBs|}iD`2G)Jple{bW$)K1E^');
define('LOGGED_IN_KEY',    'YK $..P-4Up-(2^7}-ES4a!UHHqOh|jmmp9<.IEU]+9eBuLeO&pP9O0 <EcrTf(5');
define('NONCE_KEY',        'YH8=+IO,DODEMz-A]Nv2;HrOTw^E}qb&EW5n[d<e+m|_t:|_(V!Z&jN+]{wzg|d-');
define('AUTH_SALT',        'MgN)nB&^e_HZ-V^J}3mN>tC:G(-1w]|NT sNH0$fQ||.1&TWed1]Ny,NT-F9zZ1K');
define('SECURE_AUTH_SALT', '-M=RjZ$8cD=:Ltzcm?>UWYxo,^Lb)wdMU</aYCB9j1`DRf&4%++Jjm`lae2Vy@_k');
define('LOGGED_IN_SALT',   'J|:T)w9r2S<-cZ |z{;3<%:jXK;!7GZ9%a]P:L+unw5-+.Sbf;+HH2`|{g($JB/k');
define('NONCE_SALT',       'GjX+Y2Z@q(kGizfEJ*F:tZROS9zjFR+W(h5~_}JDTbvpb!xBQ^5Z#{j~g_`AjzY3');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

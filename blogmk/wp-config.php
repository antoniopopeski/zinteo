<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'zinteo_wpmk');

/** MySQL database username */
define('DB_USER', 'zinteo_wpmk');

/** MySQL database password */
define('DB_PASSWORD', 'usLV,?#kHRbR');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '-UPL.QVEX6FpwJss_r@#U{+IV+wnkhv|[m6e/HeF ]]cvCYo_|ZVI1]fQ*!I@At5');
define('SECURE_AUTH_KEY',  'vk>xC~^6B(TU$8Wq&tE]+vNIG;*0n:a[DlUDi0Y*-UPy_if&)%_Y}&Q^48~,2[$$');
define('LOGGED_IN_KEY',    'RW7,a<)RWFA|17||?R-2MboVP8K`f-aW6bYcdYOk6 oOc?O&W+Id0N))ad_asYB7');
define('NONCE_KEY',        'L6f;KAgqPFKG10$y&CO5YK,c{%r*+$2U>H^th51S#;I1c75ZD0Y:E<a:+dlzxUNc');
define('AUTH_SALT',        'Om2qB?+CcbTGSs7#xZ_&5&ez~H =KM)x`|n-+uVpNf_^ 5Y/-ud^k.5oPBeh*|2h');
define('SECURE_AUTH_SALT', '[[Uk+8M5Uq#N2gmC1,wgoi2c)q`z*d_z++|.tY_Ofl7_znTmb.k7%ej)@0{Zwct6');
define('LOGGED_IN_SALT',   '%U{Lwdh<@I#y(AFB99 NM1|%0`f-fK7G-#[f`bc.QLo:Z?A(*7zcLq!=u-#FUB;]');
define('NONCE_SALT',       'b:>vH|7_j!FDs}bU(n[+_,(yP+TLGy%QsbE( -z1POTA4S1^kc}Ep(fxP$W5;Xl]');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

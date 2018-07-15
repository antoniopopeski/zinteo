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
define('DB_NAME', 'zinteo_wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '4[+xPW:~OJb^Qo`Y?aRiKQ3@p; |s]xP0UNGHtu ,r5||ryW:[.O+WZDC~gRL&=w');
define('SECURE_AUTH_KEY',  'cg+hk{3Ou]Soj|/+v;#2[V{^+_T@K ll3z[|ts Fv_0qaGh}PU)oG}A>x4 7!aVL');
define('LOGGED_IN_KEY',    'aGCKR%hn#|SzlilFL/e9(@qEFg=(*cv_}*MQe0.=xu+Mcd D{kvn&0M*)FzRR /.');
define('NONCE_KEY',        '/&U@jXmJ^5tT+WaICB:K7^|M8cTe)yeRs*0Z-;=UcYhLb3-tA_JL`r#Vm082|<d|');
define('AUTH_SALT',        '4q2wM)Q2q0H7L4bmWTEU.FR1!F^p]xZRMwQ9&bHOGw-rHt>deuY+fQ*T%eN@7(zO');
define('SECURE_AUTH_SALT', '-9Gr!}^U%E3I;1AC|1<b%zK=^dzw.JHk*g~!1_||2a~mK(#3Wt66AC4XHICs@tow');
define('LOGGED_IN_SALT',   'tc_/|Ut)UnSo#Z+[}RxzeQ?cn-M^%WG[gJ]{b#mW90C -JVLshIjJ-V-{/q(YpSN');
define('NONCE_SALT',       ' 6H>iMM8ZvvjHCK*bFDn-QH3mH8GwFoTP@6>;J5u#`qH+{wSYuI60+hG]g=F,evg');

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

<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
if ( file_exists( dirname( __FILE__ ) . '/wp-config-local.php' ) ) {
  include( dirname( __FILE__ ) . '/wp-config-local.php' );
} else {
	/** The name of the database for WordPress */
	define('DB_NAME', '');

	/** MySQL database username */
	define('DB_USER', '');

	/** MySQL database password */
	define('DB_PASSWORD', '');

	/** MySQL hostname */
	define('DB_HOST', '');

	/**
	 * For developers: WordPress debugging mode.
	 *
	 * Change this to true to enable the display of notices during development.
	 * It is strongly recommended that plugin and theme developers use WP_DEBUG
	 * in their development environments.
	 */
	define('WP_DEBUG', false);
}

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
define('AUTH_KEY',         'i>7-,>E-}KfP96h-8Pog9,{LYuI|JV#@!o*6%R[>|/-YJdGVqB.Yf&hOioqnqej6');
define('SECURE_AUTH_KEY',  'c{07|[b|f4QZM:;(hP{pn(7SLa|RL>W_-C%/L|-u]Q?`hJ-(dyrpbh?@,V)4E8<w');
define('LOGGED_IN_KEY',    '!a|c4dw Bt5H?^rgc%A`lx6.47U zn~F|rFx~&udFE.(MSTgxuWHiEe^Z*v{mBFH');
define('NONCE_KEY',        'EWI(uZ+mC0qIy0K5g=l,y|Lav^|~l7wm};jJr-{<.eH.30u--|pnil>WtXB-Da:2');
define('AUTH_SALT',        'f<At|12ac8ql3T(G8mW )MA-srIOKx;NZQZHBx})3E1C`-WGd,{#rZ0<Hf[Q-=(`');
define('SECURE_AUTH_SALT', ' h{kD{^pk[L{4!C#4|-mcK08>{`h}lQ]q{;8JXUiFb2Ce&[U!WA*PwOYi8_uCG2o');
define('LOGGED_IN_SALT',   'b+j]zX^N-c)-zF@~S*8Ew]v-e-/#l!VlE-F[>e~vOormJ H |<*oi,oV`ZMmHUu.');
define('NONCE_SALT',       'wd>$)c2+9)9=@tzE/2K#g#CA(S_M+*+-]>E|.z:C-v[}1oa]:-(p6TWaE1%#6-%Y');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

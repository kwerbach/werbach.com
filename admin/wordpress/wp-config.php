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
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/usr/home/kwerbach/public_html/wordpress/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'werbach_werblog2');


define('WP_MEMORY_LIMIT', '64M');


/** MySQL database username */
define('DB_USER', 'werbach_11');

/** MySQL database password */
define('DB_PASSWORD', 'sST7HmXb');

/** MySQL hostname */
define('DB_HOST', 'db139f.pair.com');

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
define('AUTH_KEY',         'z._!M!Gd~Pi+{Xs-=xBF8VFmucMBl5q3b )*XQ#xceyyJ[,s~7>W9Z]e!ol]T.:T');
define('SECURE_AUTH_KEY',  'tGelML,1)Pq*,n_B[}VWm]Xw%<,>Y3p]Y[3 /&Q5R?t~!kLw|gGtr-2fi,.TmTRR');
define('LOGGED_IN_KEY',    '8nX&154l0vXHEHh?J]o|6&2.&g-Z/tJ]n5r67k*s.zQ3@r=MV4j[B1D#|cJ29{.q');
define('NONCE_KEY',        '|Iki8-v]#Lh<qRF#3dgYwh<bV)^vI]}c3!B24XQ:u[98[L]3/~-O|I14W-+T?zm,');
define('AUTH_SALT',        ')xY?qE[g@-`R!9|7DUdOEn<~{hOHr0Q]0AV]Qm?NWw4+>SGuj[n*Jt9 |~NZ)F^;');
define('SECURE_AUTH_SALT', '>26.vESg&N}si-#e|~fx8#~uB|Wf+[Y@bHE[GvNnj3zv?oE!+Ii{uYDno!r2F^Y,');
define('LOGGED_IN_SALT',   '4kQq)&?1{Y5E#VZC|5#4vnO)=ex?Qw4!Xh|UxR25?F7n.1kwRtRIj=W|jk78OFW|');
define('NONCE_SALT',       '[f$.Z.(>3o|6|$p~5t,?l{rMh!Vw:}Z>5ks~7;ipTiRzqo9CA22~bdICK(PnNR}:');

/**#@-*/

define('WP_ALLOW_MULTISITE', true);

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
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

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

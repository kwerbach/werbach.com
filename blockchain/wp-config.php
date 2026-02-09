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
define('DB_NAME', 'kwerbach_wordpress1568633103');

/** MySQL database username */
define('DB_USER', 'kwerbach_18');

/** MySQL database password */
define('DB_PASSWORD', 'TY6t2ehz');

/** MySQL hostname */
define('DB_HOST', 'db91a.pair.com');

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
define('AUTH_KEY', 'TvKAN5hVD7zjKDwKz4rQMR4E69vxRiMMYyr8m6j7ceg6fu3bVL86gCezV5ueWjee');
define('SECURE_AUTH_KEY', '24U6SsGLUXVDxpF4zuWzEMpWtLbexHTfsCWu6vpvBgk7h5cjfpbD64d9nDfZ5heQ');
define('LOGGED_IN_KEY', 'djQv8CcRZt4uh344ikZLvCvjxGfxwDuFr9UqmpYv8e7u7B4jXeHqszQDUdzexTDw');
define('NONCE_KEY', 'KDbiD7YQf3GstpvVvQzX4mcCWQr2CRwh25FyMMHRsZaTDpEcTtkzTuHqaArpAg9G');
define('AUTH_SALT', 'vye6diUnDdK9HvKunSF5Ump88niKTz7NtYM63eVhtxZvDufPA3bJk9SjNkiFvvmN');
define('SECURE_AUTH_SALT', 'nKZQeMhumGFCqAPdsea9GSthbMxmttSWifJThjLED5fpSAp6HRiPKBPCdW985DMK');
define('LOGGED_IN_SALT', '7jufT4yNKAdYzdUqsLNdzJ5Dbcp8KPu9HiU77mQButNrzqn5Kaz8rpMZghvYq62Y');
define('NONCE_SALT', 'dcenDfAprUqnTEpFL2LCZbZ9zUwCL5zz5hJVvqQeiPziddXKRcxAhAnZpjRfWdft');

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
define('WPLANG', '');

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

/** enable wp-super-cache */
define('WP_CACHE', true);

/** enable direct filesystem access for theme/plugin installs */
define('FS_METHOD', 'direct');

define('WPCACHEHOME',"/usr/home/kwerbach/public_html/blockchain/wp-content/plugins/wp-super-cache/");
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

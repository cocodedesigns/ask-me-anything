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

// Dummy FACEBOOK account:
// ukkud@anappthat.com
// pass: 123123123

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ask_me_anything');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_POST_REVISIONS', false);

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '5&:vz<)p]7)|26OG.+T9O*+D#9YuvKNTu)Q]L#)a=p#|(+M,#)&:N(c1+BoZ.q-z');
define('SECURE_AUTH_KEY',  '-LMAoHW):SFj>ck_,StESb*6V9xV(x(DD.e;QR}6`Q6rXEg`|XM-dBjA~PUOm]J7');
define('LOGGED_IN_KEY',    'E`c2,a8Mrk^;0ZQm|r?R,f]hD[Y>q$ztm,n*llHL,[cGa_?O0uNW;X_]yiS5 uYQ');
define('NONCE_KEY',        'QoJD.NQsd{E)bOXI%9TYlVdI5Y=u=Ikxk2xHv3]!zxa5p5Q#a+]PmJNkio]MKdfw');
define('AUTH_SALT',        '-F0S!-K)t(n-`%R-4S&II_h}:J?3+&@|E`MG^9=efgE)SeFh`*2)k|NI$jE~<HTa');
define('SECURE_AUTH_SALT', 'RPFp8*&=9]5n6YI?/T?tVp,j/s:9e/}7P/,~UUmYw|d!M*G+3K%5.ic-E2XNgzSB');
define('LOGGED_IN_SALT',   'e}IBH_6@{cz:n^Gp1!N,ad%`VvtpH,kcWUq6XAwO0X{*Rz1_NS;!95pjR6)L_}?A');
define('NONCE_SALT',       'U^qh!rm5E=N?l}i+iJ+.O;e=V9DXb?E2]m~LbPl=N:>/{AUKlsj3nz|`ZF7&FQN+');

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

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

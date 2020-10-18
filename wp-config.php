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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'moonlight' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Y0UCnIcr;4<}#z##ujfz26TLiG^K|;/vB62{{+k/.wAEhJ9ct]M{o]5>^m$($a[L' );
define( 'SECURE_AUTH_KEY',  'tlN7IME$p`RvJ7,DAbi#APa>o9FdrHH?8oJl9yyHWeK.Rq{R3aR$K16!0F Juh,>' );
define( 'LOGGED_IN_KEY',    'R{Uo?T560zM>(HD|NPb&_V{FLL(f^N+>r,SoKSOMcv5:]]Y~8<j_<Ybs}RIpMQ0L' );
define( 'NONCE_KEY',        '<y^&Vd/4QK45GIegw3o_2Cs-N#SEI_f/JzWh&gZm+s^Dvg4;tt!`_[WMU<<f/u<f' );
define( 'AUTH_SALT',        '9MXNH4YMyfuZ{Xu6A1(f)A/N%U:v@]SC}S1W|`ZjXi0Cveoh)|__|1)k(PDcz|]O' );
define( 'SECURE_AUTH_SALT', 'r2vmwo z YN5R8;()Mon!`%j0[4.y)*CU&aTC7wK3STpxGbx&V](|$hW2,05tpKC' );
define( 'LOGGED_IN_SALT',   '>ZHJ`C>(x1=d&/_9cJ)`mBp;vlNOL<QNQV8G3ozRl]h?]i,-.zUH58) 2hL{mD$A' );
define( 'NONCE_SALT',       '%>cs(iks|D{{TGGfDR<{dEKBdt[{O> &waK%hakjB*+b^roEtk9x>>N?bjF{!!zm' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

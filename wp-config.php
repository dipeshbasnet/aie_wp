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
define( 'DB_NAME', 'AIE' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '>nGdr>a@Dkh1],t7TjTz8Lz9qkx8>T9ZSo({|6)f_94=HoYUw!b|-ReW+Kl4.9il' );
define( 'SECURE_AUTH_KEY',  '6fBsF9dleDqFe+ZjM2?_{*4GtioJ9RS>H-EFD:BN5zEylsSb%6(EccgG/*xk{g=m' );
define( 'LOGGED_IN_KEY',    '9%h`v.KG3Je$Sf`6Q:i:gu0+M:G</q]z[-BI:e<fCl(Gz-z[E3H,7jJUxgvGaVKP' );
define( 'NONCE_KEY',        'hA0jo1bknM{Wa +/(z5mQNM|/#iRFtj50,<2X&o[{9Rs?mGPg3+=Hx;iLO+`K$wp' );
define( 'AUTH_SALT',        '/k!WU*T@DCfsR*_8+<4S~]pPWYx2<Hgs}^sW0W+i8q3H#u$aY2`z5f&^Y1,5HdEo' );
define( 'SECURE_AUTH_SALT', '+7nbUvjG6Ifi:dnM&x*K/PlUD](gH aQ1qI;zgvgLgOlJJy.:q%N)YkLt]1QBOSz' );
define( 'LOGGED_IN_SALT',   ':,)bl2l_aI#{Yj9BuVDKnVV6r.u+l<h8G3Hl1z(ib(u}!7@C}yRXWkXK-:MTO-Qf' );
define( 'NONCE_SALT',       'H.L]T%.$63h&y3kK=8Q(W5Ye.3&!h`EOgo9L&]gA1U|/c)E{5~u0HfI61uM#6;Bk' );

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

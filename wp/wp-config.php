<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
// define( 'DB_NAME', 'macplast' );

// /** Database username */
// define( 'DB_USER', 'root' );

// /** Database password */
// define( 'DB_PASSWORD', 'root' );

// /** Database hostname */
// define( 'DB_HOST', 'localhost' );


/** The name of the database for WordPress */
define( 'DB_NAME', 'macplastsrl_db' );

/** Database username */
define( 'DB_USER', 'macplastsrl_admin' );

/** Database password */
define( 'DB_PASSWORD', ';h6Ub{D=eh[NL@d&' );

/** Database hostname */
define( 'DB_HOST', '192.168.0.73' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY',         'm,p-t2aL5fW}p0`Kvb*k{gbFO`o1}| !r1DE7Ii+z:RrsHe%6ODm.*,[v,k?E55@');
define('SECURE_AUTH_KEY',  ':8;Aun/HW0[?:GU-2b./dY?A:/cI T-Eu_)6s q0#]0|k,MW<7q8}FI)z4DL,p$@');
define('LOGGED_IN_KEY',    'vc2eM.+!cq$_S&k-Lu+xpTX1UjlA*I&z 0-hNJ}zxN~T&[nRBZS(;b_iYuAYkkan');
define('NONCE_KEY',        'Zz5qp-5r4~pBr(keFuM},,x|QJne:T|z|;f+{,mT1]2KDwvxKsxd6+Ydj;,:kV?X');
define('AUTH_SALT',        'fyH^3)wqvvYis1<~5w:Q_=E WY#vZQZ*-#*/gZ]!%/n8@Rs.2DlIG6pQD8J|n8iG');
define('SECURE_AUTH_SALT', 'UkWTqS:y#ER_Y/ [w2y?^[}tJfHj&vf#x>:/ o,-Vl*,|NJ2S;UOh!!<@_ta!^Rm');
define('LOGGED_IN_SALT',   'Mx?kEj(?U+Ba9;DKS_;b7KuDIoz(6-G-;-~Z:S+P@p+.s(4(p[uNx63Wj*HGM_h@');
define('NONCE_SALT',       'M]KaM7-L.V%+?=H8s]SB?3V&og8@M3x@[CPj3$d{.<aK=[|KtO{W+*Gr+u>+Ju.D');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */


define('WP_MEMORY_LIMIT', '512M');
define('WP_MAX_MEMORY_LIMIT', '512M'); // (facoltativo, ma aiuta in admin)



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

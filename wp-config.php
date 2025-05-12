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
define( 'DB_NAME', 'metalware' );

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
define( 'AUTH_KEY',         'khDc0wBageA~LdS]Hxa.S]ujT;o^W[Rs.j[+6&=Dvm#*7PT8>#~S+){y#!E#W)TY' );
define( 'SECURE_AUTH_KEY',  'lK&v3*vwfBB;ch?8a1G?}k[2ycA7b=OLuXi4YgK7/f-E`hU2$wbWzW<yQ;Fpe9q)' );
define( 'LOGGED_IN_KEY',    'dHU^t5u2im7GP.ER(6EV:{1GaG<&@*BA5zLS28k&uK@e:3Fl?Ec87UM,yk.+VtF(' );
define( 'NONCE_KEY',        'X?K6:[_.r),x7Do7.,SPa8vJ35Cgrv Xs]vn[:~E9tVKyNRfAcrXIZ@;RrHAjU}w' );
define( 'AUTH_SALT',        '9vM;Ax_vL%JC9N@}3|ARfo|BLGht-bRdN(y1/ @PO,n2<#zZ5y 1.Wo1xuv][X-(' );
define( 'SECURE_AUTH_SALT', 'El;:)yU[?|TqVc)aTfFef+_<8:iyewID84]R%)lLeLaKny*lpoC?Il<.9[LhN5!s' );
define( 'LOGGED_IN_SALT',   '+Sm.ZB<Pi:KSs{8a{f!jLf9sw8&`0brM<;qQGL1i35r$5|hb/6*cVvKKIH}WVr)G' );
define( 'NONCE_SALT',       '$>2REV*Q4i@vR;  0,pT<hNi|EC~;hh}/GA:j $}_buq[Q0f[RPj1,x_@k:/Z}jW' );

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

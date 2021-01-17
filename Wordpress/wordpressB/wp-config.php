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
define( 'DB_NAME', 'wordpressB' );

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
define( 'AUTH_KEY',         'VivY-C9+7n]H<|M,}v2T*e0~SwKDU=L:W^)ye3r/=z-80,-QeG1lWa5|RvCjxT-+' );
define( 'SECURE_AUTH_KEY',  'm%MBlCJi X;|M];o)T2i[%uutw;nC]|KPddI8N7t&7GxWY~(-#}`Lvb0;8a2Bbc?' );
define( 'LOGGED_IN_KEY',    '#:5Lt~q+S3CA_NscY8tX8l_JD]?COwDri+9Z+Ath(qZ{RNx&^#,E~}T6[&fdD}y=' );
define( 'NONCE_KEY',        'UZA_gIfnFq{AZ-ap]hb<H`_qV<.UJif1519d~,:nE9NC;wZjkbnvA[2Xe0nw#UbQ' );
define( 'AUTH_SALT',        '.o#?}*ae:lE <r=a=Xjmv9V@uNW0V!Ha1+u5OU$kA4d](oW]a_1pF@e9rpnBw!>j' );
define( 'SECURE_AUTH_SALT', '*@uy}HsV*6W6>)]n/=hbojdm?Y6Lbf5_MPxLhxA(ixA*r]LZg/)leP|1L`^=IKhO' );
define( 'LOGGED_IN_SALT',   'KUHy!Yus(ADy*{*Cx!9e@3x=4~SXt_[ EjX&>;Ffgc<rYK7^vx[tA$OcU,U|_-;u' );
define( 'NONCE_SALT',       '5SD#3Kn_HV,-*:zoj{/u8BLX3y41sEpQ7nbxODp[|71]nC@e0u!**:H_A(_M}yDf' );

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

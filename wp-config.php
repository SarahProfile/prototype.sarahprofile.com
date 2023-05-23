<?php
define( 'WP_CACHE', true );
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
define( 'DB_NAME', 'txdsfroc_wp57843' );

/** MySQL database username */
define( 'DB_USER', 'txdsfroc_wp57843' );

/** MySQL database password */
define( 'DB_PASSWORD', 'ps.7LS09-6' );

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
define( 'AUTH_KEY',         'bue56rzjyxtkj9ehk5m4voixotv0egur0k2w4g43zwhocfycp33htwd3opzvo6gl' );
define( 'SECURE_AUTH_KEY',  'zrmluci4408fns5pbicsq9bb7lcvqvt0iioihiiyxo3mjz74so1rxhhec6o9agsb' );
define( 'LOGGED_IN_KEY',    'a2bplgd53dieep4hmkmi2ivb34jlwtocqmoshmio3ylkx1ge6lptdq9wme6n6d0n' );
define( 'NONCE_KEY',        'qqkfddpulsmqj2kgk7mopbghhfhgrqot1ubhy9q5ix748lobnzmgsqrwljisyees' );
define( 'AUTH_SALT',        '9hzghil5gmdohiul2wlfshp7rdkt2lk3wacdxkuix9kq8mbnh2pladvjdcb27ihb' );
define( 'SECURE_AUTH_SALT', 'f8h0bzro2c8ltmqhuss1rpg41r6p4xvui92rfao4u0ttoqf1mjklxx6qvxl7ebcx' );
define( 'LOGGED_IN_SALT',   'rasvo2eypm2i6zugzjsymabofhiivzoklys2vwode8qpoelab1t4lpbhltdclsei' );
define( 'NONCE_SALT',       'afpynx4fbng5maltd3hcsxwztis4hikowrnb1pcxsxkv69ffyubprev5gnffanbd' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpzv_';

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

define( 'WP_AUTO_UPDATE_CORE', 'minor' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

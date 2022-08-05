<?php

// Configuration common to all environments
include_once __DIR__ . '/wp-config.common.php';

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
define('REVISR_GIT_PATH', 'https://github.com/Lucasyu777/FIT5120-TP10.git'); // Added by Revisr
define( 'DB_NAME', 'unaux_32302000_sunuv' );

/** Database username */
define( 'DB_USER', '32302000_6' );

/** Database password */
define( 'DB_PASSWORD', '2L99Sp4)0(' );

/** Database hostname */
define( 'DB_HOST', 'sql108.byetcluster.com' );

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
define( 'AUTH_KEY',         '2zyo74fjnurmetpteo1swkkxyiiatdq4zpolnqjl02nlpyslfnpyjnhjkfpcergi' );
define( 'SECURE_AUTH_KEY',  'bqifbp0xnkk3dcpz5bpoxqcr74kwsy8gfvufxo5psg480vatjjwyfkqwvu6juazc' );
define( 'LOGGED_IN_KEY',    '5pu96eywejqj2m4bgqc1rtasyoc8km15jahwowkxm2d3ewcujmouxd5aceab67hu' );
define( 'NONCE_KEY',        'kvahssrwh7dzfmuannqt4f7j5urfz0uulkprzdrvndqmdsd6hsk7ebnhlgcd7wev' );
define( 'AUTH_SALT',        'o4uxjdrxvyp3n5zrcghkii31tzlhtewbxbz3bdasoyvxdolfzy8ibasozt5duznb' );
define( 'SECURE_AUTH_SALT', 'kpjw6d4pxysliuhm0ojvycazowi5kceqgkmk3rxjuif0vsryievxrasetbokrv52' );
define( 'LOGGED_IN_SALT',   '7n1hcdr0hxql3vetqmxovya4t4eqiap4uuatgzr7tmngkgofycqnyugd4f7kqnb4' );
define( 'NONCE_SALT',       'lgzfmzsn16qgmdzkzhknktnqgntcxpp34hcbp789rnkqzh9dbnjpbgfrwxsbkjmb' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpba_';

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

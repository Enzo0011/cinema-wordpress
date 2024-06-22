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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'esgi_cinema');

/** Database username */
define('DB_USER', 'root');

/** Database password */
define('DB_PASSWORD', 'root123');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY',         'jWgf%MGGoa&VotbGr$i>chG/5f-gbyp>,qr2pL @T*&V0j y<2BX`PHlF3b[87Uk');
define('SECURE_AUTH_KEY',  '_tWn$dy^ci=syDeGB- BHFxEdYO*G)@/;8oD]&^M>d{E[/_hsSK0IT/m;4}Ojv5F');
define('LOGGED_IN_KEY',    '~J3j|f@{fb>`@wlahc!-RKzvE-xpKXWm#LS-g|3D020-.@8koYu6SFS A9o,y?sQ');
define('NONCE_KEY',        'z:dtUbAy]#HwYc=t`w]d<1$YBT!kHZ_p$:p!`Ny;[tAyJ AP9U#pY`[zb|ickM.n');
define('AUTH_SALT',        's-ijPltqX7&Sq(2z#Pp,pbTa9tf.bi>>HIwkHL27n%FWgZc<E[B%@D.2 `YM&6]A');
define('SECURE_AUTH_SALT', 'TO)_bA#Y9#]Cdfe#=wd4,3etlbynN[Yv2BbTPxUMQ1GWMlgs^w)fZ&*;[*xR3M14');
define('LOGGED_IN_SALT',   'w*>wE^utyM|C.NKuPN>HuW{e&g#=#uUzng5<m_[!,KSI/9=}gBR,Aq71owc4[  P');
define('NONCE_SALT',       '!D@9@O eodvHQG~VxiZl|G2VUN$/JgB@Q`<T4^,7Re`5uR+3~a0)u^2BC[m9HUzB');

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

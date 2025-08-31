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
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         'o &?B?EJC_K877DieI0aY`<OaQ9$LQr]>m|g`npcLj6.U81#?M7i;TDq:fZ|57Kq' );
define( 'SECURE_AUTH_KEY',  'a,LP$Oqm[0LaBw$n.0mGu]/DWH89RbU,0!>/n@Sa4F_FioqgUhPr6_&J@21Q]=OP' );
define( 'LOGGED_IN_KEY',    '6vHIIi%a&OF7jG=GoG+LdxFu-!>{@BeI?0VOhyS2@`V,eMYx,:!g,AYZ>eww4*g3' );
define( 'NONCE_KEY',        'XIrG2NFDDj86w?WL0Q|D,~OB:%iG+uu6q|;9N}bt:Rs;;n<]{{ph}+R,4Ih-!I&v' );
define( 'AUTH_SALT',        '-JUx#xGYR-Ks!icG|1]^===%^8U3;#Dio7bTVkl4!%rD>F$g8++qRm5O/}BY=p)*' );
define( 'SECURE_AUTH_SALT', 'Zs]w]vx@a,r7oUe-0<BkyY%a|}cv2UN9a,pp$>2nCgG;TG=AZL%[Fn;h}VKmUdVu' );
define( 'LOGGED_IN_SALT',   'T{^+tv1sUl@bbPApttskD?;HC*BKT<=4BYY+=KI36%Kf562a+7w2`X1zsepm^gaS' );
define( 'NONCE_SALT',       '|8(3F$t /y${ZF9z`?_x3lWZnL_(fD3RVWBTcY[Z9UsNvV1uywPHW(Ha]+)`;Njo' );

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

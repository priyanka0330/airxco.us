<?php
define('WP_CACHE', true); // WP-Optimize Cache
//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
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
define( 'DB_NAME', 'techtruckers_db' );
/** MySQL database username */
define( 'DB_USER', 'techtruckers2022us' );
/** MySQL database password */
define( 'DB_PASSWORD', 'Techtruckers@2022' );
/** MySQL hostname */
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
define( 'AUTH_KEY',         '#Rm<q(9sp$2@K/mmZ(&^H?Tm9->w{<PF7l%&BWxr93=|4y)@FlVi4L~{#cKd19Hb' );
define( 'SECURE_AUTH_KEY',  '3alB=c,86xuEUA[!&.zKVAN9z</>.z(iT;3{Q,S*{m>)0Vip:]b-PNGt>)eNE)-t' );
define( 'LOGGED_IN_KEY',    'sj(1Mcb[YhUQTmIx nk(^fiud5n{xQ]ms$/z:3Tl<JzcG=,E_dEKQ?ro2j9TUx!q' );
define( 'NONCE_KEY',        's})8GM{rh;y/%I|P6c)75qIY*;5TxuY!lYcJk9f.86#LlAv*^}NImI3cvn!Ubcdl' );
define( 'AUTH_SALT',        '*Q=8Nml1p5!kw^AR=YLRX*>ClX8lt4taa2@aBv]_4E3GseqEkE+IV/Jjbv&pPUnu' );
define( 'SECURE_AUTH_SALT', '8iDhge6yQA@p!|inysNDL>HTz,|*Z,,/gKPa=Hr?8MB:|@GIwhn(_qtt9y`Kuqo*' );
define( 'LOGGED_IN_SALT',   '7[zj3)U38<Y*7{9?1lF #s:Gl(,Y5;OjF}>>[lL|T7{Ifa%l-5J<vn2)d&A{kuvI' );
define( 'NONCE_SALT',       'Y50abfB@c5u8El5zj~dPE5B+rfs!?g`*pIDl.-J:NL=MrK&2I?}kN&UVhK$j`;^D' );
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
<?php
//Begin Really Simple Security session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple Security cookie settings
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
define( 'DB_NAME', 'hguusaov_wp313725' );
/** Database username */
define( 'DB_USER', 'hguusaov_wp313725' );
/** Database password */
define( 'DB_PASSWORD', '7p!yISt92)' );
/** Database hostname */
define( 'DB_HOST', 'localhost' );
/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'latin1');
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
define( 'AUTH_KEY',         'dpkuaxpurkeagwljig3lhrgamcfdnjiyov3k9zodoliovrqxxvakehohqmc4n1qb' );
define( 'SECURE_AUTH_KEY',  'acjmq3polh9ew86zb9vvae5jreclpgrzz0cyqe9yrbduzlrespnqoxt8vij1zk3p' );
define( 'LOGGED_IN_KEY',    'w9ofg0cxpeimouirs95lsf35d8y2armmlcqr73n5rq7ajtg4wtfyej0j0w6jwe2b' );
define( 'NONCE_KEY',        'xgfbw2f625ikezd1gemzebp66cvjthtuiy7pge9qyuvl2sowlxhqwdbzirzaygve' );
define( 'AUTH_SALT',        'loo6wfrfak2sp0jos56wq3e03gqjpk7abunjndpmmoywdlu10yrocdmasuh83xhw' );
define( 'SECURE_AUTH_SALT', 'cfwhvefgp9aub6rdk5qwze08ihogi7tih7ha7sy1fkqzxtnvwiygrwznvt9sulwv' );
define( 'LOGGED_IN_SALT',   'c1txms2me7cl3dz6mytww9gc5vh9ebqflirrhbxfd2clpf2t18xrcytwa3kzowbr' );
define( 'NONCE_SALT',       'kc0cnm33jik8pxrtlmin1fzsdy5qffebqjibkt4tidnjydnpmbhucrl8nnqikrhh' );
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
$table_prefix = 'usb_';
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
define('WP_CACHE', true);
/* Add any custom values between this line and the "stop editing" line. */
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

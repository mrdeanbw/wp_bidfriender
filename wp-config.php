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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'friendbi_wp560' );

/** MySQL database username */
// define( 'DB_USER', 'friendbi_wp560' );
define( 'DB_USER', 'root' );
/** MySQL database password */
// define( 'DB_PASSWORD', '3)6a8@1mSp' );
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
define( 'AUTH_KEY',         'rqok6d6ewd7qc4dpp48fsxidtpfwylq9p4kuqjgsrx0wuliapaeogjmjvbj8pvq0' );
define( 'SECURE_AUTH_KEY',  'dxlscth0l4jqafjzco1jwbkwdv5ujh48kep3cndb8behebvlnfsrmnk7ppsvrgyh' );
define( 'LOGGED_IN_KEY',    'eel5nasshuj4n3ev8o56u5kmfhvarwgjg55c2mqbx5lnxqxwdzzfubefy6o3zlg8' );
define( 'NONCE_KEY',        'xyyuonqh1xpgufzznq3z9lz27flwdnxqh8k8cwz16k2chz1aoah7au2hscjdk86u' );
define( 'AUTH_SALT',        '9gt5ydb8rswfcca9smjmsnwlw1ogxe6kolhllypgznomzxls6pofaln0ll8pr7v7' );
define( 'SECURE_AUTH_SALT', '72fdlmohjallnupovsuxdraugwwomp6ludy5nwk2xlsnqx60bhapbnzralpajq2k' );
define( 'LOGGED_IN_SALT',   'hlya6xgajqclfuj5sbok7jqn5vy6vymni2btz5j3ezgp1lvg1vovnqoyoapld3py' );
define( 'NONCE_SALT',       'gywxqycuw5kwgdkbedjsltc4kabyvlkjk57a8ejythaqlvwonik508ruachricgx' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpii_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */

define( 'WP_DEBUG', false );
define('COOKIE_DOMAIN', $_SERVER['HTTP_HOST'] );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

<?php
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
define( 'DB_NAME', '101_132_253_207' );

/** Database username */
define( 'DB_USER', '101_132_253_207' );

/** Database password */
define( 'DB_PASSWORD', 'eEASJLRpNAaZN7D6' );

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
define( 'AUTH_KEY',         'GM+ ^y8CUn8m!^V4C-r6dPowh  C6SfT7D$$6J^zD>ImE]y^Ep:}k)Li*)J.Kcf-' );
define( 'SECURE_AUTH_KEY',  'Z{eGo+#CBDg|.T/ M3iATDHbe?`UwFoiY{_xymB:>A=z]oE#(R%AX)M8/kcb<DyU' );
define( 'LOGGED_IN_KEY',    'EODKNh@HdbiO5{2@X5KMK0<TcFw*T<+;5Gyq+(DTQau3$:2a6#qd[N%<SL1foQUW' );
define( 'NONCE_KEY',        '<z`:[z?nf<*aEiM!+^Flnkbc??D+UK{@0Tq%e[T#q7[>qWTk7 ,y{-a~(dYCZ14|' );
define( 'AUTH_SALT',        '4wXp/8cq,S_/MYD~2d8G?bhGjNrvk5N@EK6h[h&NjM*a44p(jU7m1vWL#c;o<E@@' );
define( 'SECURE_AUTH_SALT', '|gKpL~RTchI]>F>~}aJxF];PcaDPg$0]U4)!dk~k$LWqfw@vSURyqgVy! C4|nU:' );
define( 'LOGGED_IN_SALT',   'F0-<{365x<9@Hndx->}AGox~jfD+NHYw1~|fX[91z0sS{6i ;TZdDyT3_b+CHRFA' );
define( 'NONCE_SALT',       'V[.>c-?.[=IsdJ43;L?RbIn|?Zj:N7(Dt.?A}8R3:Bk1}R:Q :)zQNAvH$&c.Nes' );

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

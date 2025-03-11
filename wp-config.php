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
define( 'DB_NAME', 'junit' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3307' );

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
define( 'AUTH_KEY',         '5S*|.PhH^lEwrpEBSvZdm+1*^Pj|]Z1gYMtwJ0)*G8Q]q~6Re,=YJb M:L]:V<rx' );
define( 'SECURE_AUTH_KEY',  'wI$N!}P$~>ezcl<2^t]u`$GHH0Z[IF0eDXaLJqNx8foEU?lua,<,8l4<cmEn$?;f' );
define( 'LOGGED_IN_KEY',    '`yMN6#JDO&j@@OJDTlbwP4Tc8+C*2Wc(5@~Sq|173Ae|Y0ki>2!ttTM8Qe(FC/%|' );
define( 'NONCE_KEY',        '~Q=qu=[iz,]0n+~%CMqO*-;!g#] [*;M]M|fUcFqWg`X89cw6UADW4]iO}4MZ/Zl' );
define( 'AUTH_SALT',        '2:4Z`?{5Fv.??P(r.PVBaJ.]&%M!&TZE-Dq8Ft!0ONM6KQj2<bOBj*b_O1%u);}V' );
define( 'SECURE_AUTH_SALT', '$#q9EiN@;@_Yo>Yr((s#k|;tMLgR:=6UH){:F;]b^d|Atz-j2.&]GSar/-GMJ1N}' );
define( 'LOGGED_IN_SALT',   '!c+K3>i&>aWk)+#jI45~p*d3sXbw>vh5,)Xf|Cf$CZI4RwZCN{mgJ5}r2)ZK71vj' );
define( 'NONCE_SALT',       'LX6vD-kpF5{6a!zTf^qY%#[wb6_f+S`,}M.WLd;U`a`bL4y=dAAA%w&(vOXFC.^M' );

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

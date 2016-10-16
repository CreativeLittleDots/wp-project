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

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '[vFkLblp>0_@UM+06VYL(rDu_$I^+o=DsX8EBt B8<K%^UH&BIQ*}]i!&>IFO;-M');
define('SECURE_AUTH_KEY',  ' m.{u:{]enB/w`4%qm+%2HY;1w{?QCZY$oT2kjwFkl(k5^^12g]_/L+Ca+C?aB(Q');
define('LOGGED_IN_KEY',    ')1?}9b3IR,yJtoi n}1LCZPs~Vz6jxRJ( IumLU6~B;<+wk1Hd-Y;+_;kbh^8Mh%');
define('NONCE_KEY',        ' qrO{PJTOG3t*+}3 <h]0bbwT}$]!-)g,?Pv|>5WKj_Fj_Nx}pnyZ)!e/~I6z1Rf');
define('AUTH_SALT',        '@b8Sj~k|d_#SMl0~y[]zL/G^eH(ec_8U~s<|Il+s`k%1~%R~a}c>mTxL2|Mqm~ghh');
define('SECURE_AUTH_SALT', 'NxM|l+}@7ZU)Z[Aczbp_/|ZDO:*=P{p1:tAT5+^kC^k)ss3L|&d:dDUC+~h*_.76Q');
define('LOGGED_IN_SALT',   'J!Wq1[{Jac/TsBgb_WHM|geU/|^6Zv?=c@wr-lo)aFd-@hXX]OwqnNinp}+Y/LJ2');
define('NONCE_SALT',       '5VR#z,Sw+9nC~)oGHYH+aXwW=_xFnE1HE|B]p&,.t 7]IQ$;^M6Ie:hMr@|Ne-|b');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

define('WP_ALLOW_MULTISITE', true);

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
define('DOMAIN_CURRENT_PATH', 'domain.com');  // only set this after wp-project has run and updated the network domain 

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	

/** Sets up WordPress project. */
require_once(ABSPATH . 'wp-project.php');

$project = new WP_Project('project_name', array(
	'staging' => array(
		'host' => '%s.staging.com',
		'password' => '(r5iegethkzA$fghVB'
	)
));

/** Define these because we need to be able to set sub sites urls without touching database*/
define('WP_2_HOME', WP_HOME . '/uk');
define('WP_2_SITEURL', WP_2_HOME);

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
## WP Project

Keeping up with development and production environments is difficult, and when using Wordpress you often end up having to ensure you separate you wp-config files and make sure you do not overwrite them between each environment.

At Creative Little Dots, we often develop locally on our machines, and then when were ready push to a staging environment for demonstration, and then the production once the changes are signed off, that is three different development areas.

It got us thinking, what if we could use just on wp-config file and pick up the current domain or ip address to route to the correct database credentials? It's surely possible right?

Well of course, and WP Project just does that! You are able to define an array of environments in minimal code using a built in regular expression handler.

## Installation

1. Download WP Project
2. Place wp-project.php in the root of you Wordpress installation
3. (If using WPMU) Place multisite-default-blog/ in your plugins folder
4. Merge wp-config.php in with your wp-config.php

## Manual Migration

To migrate, remove all instance of database connection information as follows;

```php
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'test');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');
```

Then copy the WP_Project instance into your wp-config as follows;

```php
/** Sets up WordPress project. */
require_once(ABSPATH . 'wp-project.php');

$project = new WP_Project('project_name', array(
	'staging' => array(
		'host' => '%s.staging.com',
		'password' => '(r5iegethkzA$fghVB'
	)
));
```

## Full Usage

Lets say you have three environments;

1. test.local (local)
2. test.stagingserver.com (staging)
3. test-company.com (production)

You should set up your WP Project as follows;

```php
/** Sets up WordPress project. */
require_once(ABSPATH . 'wp-project.php');

$project = new WP_Project('test', array(
	'local' => array(
		'host' => 'test.local', // defaults to test.local
		'database' => 'test', // defaults to test
		'username' => 'root', // defaults to test
		'password' => 'root'
	),
	'staging' => array(
		'host' => 'test.stagingserver.com', // defaults to test.staging
		'database' => 'stagingserver_test', // defaults to staging_test
		'username' => 'stagingserver_test', // defaults to staging_test
		'password' => '(r5iegethkzA$fg'
	),
	'production' => array(
		'host' => 'test-company.com', // defaults to test.com
		'database' => 'testcomp_wp', // defaults to production_test
		'username' => 'testcomp_wp', // defaults to production_test
		'password' => 'ethkzA$fghVB'
	)
));
```
## Simplifying

Bearing in mind we are using a regular expression handler, to get the most out of WP Project you should could do the following with the above;

```php
/** Sets up WordPress project. */
require_once(ABSPATH . 'wp-project.php');

// the first argument of WP_Project becomes accessible with %s or %1$s in credentials, %1$s = 'test'
// the array key of each environment becomes accessible with %s or %2$s in credentials, %2$s = 'local'

$project = new WP_Project('test', array(
	'local' => array(
		'username' => 'root', // defaults to test
		'password' => 'root'
	),
	'stagingserver' => array(
		'host' => '%s.%s.com', // defaults to test.stagingserver
		'password' => '(r5iegethkzA$fg'
	),
	'testcomp' => array(
		'host' => '%s-company.com', // defaults to test.com
		'database' => '%2%s_wp', // defaults to testcomp_test
		'username' => '%2%s_wp', // defaults to testcomp_test
		'password' => 'ethkzA$fghVB'
	)
));
```

## License

[GNU General Public License v3.0](http://www.gnu.org/licenses/gpl-3.0.html)
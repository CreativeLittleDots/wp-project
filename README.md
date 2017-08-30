## WP Project

Keeping up with development and production environments is difficult, and when using Wordpress you often end up having to ensure you separate your wp-config files and make sure you do not overwrite when uploading between each environment.

At Creative Little Dots, we often develop locally on our machines, and then push to a staging environment for demonstration, and finally push to production once the changes are signed off - that is three different development areas!

It got us thinking, what if we could use just one wp-config file and pick up the current domain or ip address to route to the correct database credentials? It's surely possible right?

Well of course it is, and WP Project just does that! 

You are able to define an array of environments in minimal code using a built in regular expression handler.

## Installation

Installation is more complicated due to how Wordpress allocated urls to sites within the network. We are hoping Wordpress will authorise a request we have made that will reduce the number of steps below for WPMU.

1. Download WP Project
2. Place `wp-project.php` in the root of you Wordpress installation
3. Merge `wp-config.php` in with your `wp-config.php`
4. (If using WPMU) Place `wpmu-home-contsants.php` and `wp-cli-update-domain.php` in your mu-plugins folder
5. (If using WPMU) Run `wp project update domain` command

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

Then copy the `wp-project.php` instance into your wp-config as follows;

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

And that your current environment is `staging` as per the third argument of `WP_Project` constructor. 

> **Note:** Unfortuantely we had to add this optional third argument for current environment for users running WPMU as when running any commands WP CLI has to know which environment to use.

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
), 'staging');
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
), 'stagingserver');
```

## WPMU

WP Project supports WPMU through manipulating the `WP_HOME` and `WP_SITEURL`. However a nuance with how Wordpress works is that you must remove update `wp_blogs` and `wp_sites` tables and change the domain to the domain you want for the environment. This is because there are not available filters to manipulate these. 

To solve this problem, firstly [install WP CLI](http://wp-cli.org/), and then simply run the `wp project update domain` command.

After this you can define sub sites accordingly if you wish;

```php
/** Define these because we need to be able to set sub sites urls without touching database*/
define('WP_2_HOME', WP_HOME . '/subfolder');
define('WP_2_SITEURL', WP_2_HOME);
```

## License

[GNU General Public License v3.0](http://www.gnu.org/licenses/gpl-3.0.html)

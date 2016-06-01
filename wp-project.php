<?php
    
/**
 * The project configuration for WordPress
 *
 *
 */
 
class WP_Project {
	 
	public $project = 'project';
	public $environments = array(
	    'local' => array(
		    'database' => '%1$s.local',
		    'username' => 'root',
		    'password' => 'root'
	    ),
	    'production' => array(
		    'database' => '%1$s_wp',
		    'username' => '%1$s_wp',
	    )
    );
 	
 	public function __construct($project = 'project', $environments = array()) {
	 	
	 	if( defined('WP_DEBUG') && WP_DEBUG ) {
    
		    error_reporting(E_ALL);
		    ini_set('display_errors', true);   
		    
		}
		    
		$this->project = $project;
		$this->prepare_environments($environments);
        $env = $this->get_environment();
        
        define('DB_NAME', $env->database);
        define('DB_USER', substr($env->username, 0, 16 ));
        define('DB_PASSWORD', $env->password);
        
        if( ! defined('DOMAIN_CURRENT_PATH') ) {
            
	        define('WP_HOME', $this->origin_url($env->host));	        
	        
	        if( defined('MULTISITE') && MULTISITE && defined('SITE_ID_CURRENT_SITE') && SITE_ID_CURRENT_SITE ) {
	        
	            $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Could not connect to server.' );
	            mysqli_select_db($link, DB_NAME) or die('Could not select database.');
	            
	            mysqli_query($link, "UPDATE " . $GLOBALS['table_prefix'] . "site SET domain = '" . $env->host . "' WHERE id = " . SITE_ID_CURRENT_SITE);
	            mysqli_query($link, "UPDATE " . $GLOBALS['table_prefix'] . "blogs SET domain = '" . $env->host . "' WHERE site_id = " . SITE_ID_CURRENT_SITE);
	            
	        }  
	        
		} else {
			
			define('WP_HOME', $this->origin_url(DOMAIN_CURRENT_PATH));
			
		}
		
		define('WP_SITEURL', WP_HOME);
		
		! defined('WP_CONTENT_FOLDER') && define('WP_CONTENT_FOLDER', 'wp-content');
		define('WP_CONTENT_URL', WP_SITEURL . DIRECTORY_SEPARATOR . WP_CONTENT_FOLDER);
	    
	    if( defined('WP_DEBUG') && WP_DEBUG ) {
	
		    error_reporting(NULL);
		    ini_set('display_errors', false);
		    
		}
	 	
 	}
 	
 	public function prepare_environments($environments = array()) {
	 	
	 	$this->environments = array_replace_recursive($this->environments, $environments);
	 	
	 	foreach($this->environments as $key => &$environment) {
		 	
		 	$environment = array_merge(array(
		 		'host' => '%1$s',
			    'database' => '%2$s_%1$s',
			    'username' => '%2$s_%1$s',
			    'password' => ''
	 		), $environment);
	 		
	 		$environment = (object) array(
		 		'host' => sprintf($environment['host'], $this->project, $key),
			    'database' => sprintf($environment['database'], $this->project, $key),
			    'username' => sprintf($environment['username'], $this->project, $key),
			    'password' => $environment['password']
	 		);
		 	
	 	}
	 	
 	}
	
	public function get_environment($env = null) {
		
		if($env) {
			return $this->environments[$env];	
		}
		
		$environments = array_filter($this->environments, function($environment) {
			return $environment->host === $_SERVER['HTTP_HOST'];
		});
		
		return end($environments);
		
	}
	
	public function origin_protocol() {
	    
	    $ssl = ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' );
	    
	    return substr( strtolower( $_SERVER['SERVER_PROTOCOL'] ), 0, strpos( strtolower( $_SERVER['SERVER_PROTOCOL'] ), '/' ) ) . ( ( $ssl ) ? 's' : '' );
	    
	}
	
	public function origin_url($domain = null) {
		
		$domain = $domain ? $domain : $this->origin_domain();
	    
	    return $this->origin_protocol() . '://' . $domain;
	    
	}
	 
}

    
?>
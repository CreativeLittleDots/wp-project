<?php
	
if ( !defined( 'WP_CLI' ) ) return;

class Project_Update_Domain extends WP_CLI_Command
{
	
	/**
     * Execute the console command.
     *
     * @return void
     */
	public function update() {

		if( defined( 'MULTISITE' ) && MULTISITE && defined( 'DOMAIN_CURRENT_PATH' ) && DOMAIN_CURRENT_PATH ) {
        
            $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Could not connect to server.' );
            mysqli_select_db($link, DB_NAME) or die('Could not select database.');
            
            if( defined('SITE_ID_CURRENT_SITE') && SITE_ID_CURRENT_SITE ) { 
            
				mysqli_query($link, "UPDATE " . $GLOBALS['table_prefix'] . "site SET domain = '" . DOMAIN_CURRENT_PATH . "' WHERE id = " . SITE_ID_CURRENT_SITE);
				mysqli_query($link, "UPDATE " . $GLOBALS['table_prefix'] . "blogs SET domain = '" . DOMAIN_CURRENT_PATH . "' WHERE site_id = " . SITE_ID_CURRENT_SITE);
				
			}
            
        } 
		
	}

}

WP_CLI::add_command( 'project update domain', [new Project_Update_Domain(), 'update'] );
<?php
/*
Plugin Name: MultiSite WP_HOME and WP_SITEURL
Plugin URI: http://doublesharp.com/
Description: Allows wp_options values to be overwritten in wp-config.php for MultiSite
Author: Justin Silver
Version: 1.0
Author URI: http://doublesharp.com
License: GPL2
*/
 
/**
 * Replace this site's WP_SITEURL URL based on constant values
 *
 * @param String  $url - The original URL
 * @return String - The replaced URL if overridden in wp-config.php
 */
function _ms_config_wp_siteurl( $url = '' ) {
    if (is_multisite()):
        global $blog_id, $current_site;
        $cur_blog_id = defined( 'BLOG_ID_CURRENT_SITE' )?
            BLOG_ID_CURRENT_SITE :
            1;
        $key = ( $blog_id!=$cur_blog_id )? $blog_id.'_' : '';
        $constant = 'WP_'.$key.'SITEURL';
        if ( defined( $constant ) )
            return untrailingslashit( constant($constant) );
    endif;
    return $url;
}
add_filter( 'option_siteurl', '_ms_config_wp_siteurl' );
 
/**
 * Replace this site's WP_HOME URL based on constant values
 *
 * @param String  $url - The original URL
 * @return String - The replaced URL if overridden in wp-config.php
 */
function _ms_config_wp_home( $url = '' ) {
    if (is_multisite()):
        global $blog_id;
        $cur_blog_id = defined( 'BLOG_ID_CURRENT_SITE' )?
            BLOG_ID_CURRENT_SITE :
            1;
        $key = ( $blog_id!=$cur_blog_id )? $blog_id.'_' : '';
        $constant = 'WP_'.$key.'HOME';
        if ( defined( $constant ) )
            return untrailingslashit( constant($constant) );
    endif;
    return $url;
}
add_filter( 'option_home',    '_ms_config_wp_home'    );
?>

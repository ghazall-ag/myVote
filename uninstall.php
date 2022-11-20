<?php
/*
* Uninstall plugin
*/

if (!defined('WP_UNINSTALL_PLUGIN'))
	exit();

if (is_multisite())
{
	
	$sites=wp_get_sites();
		
		foreach($sites as $site)
		{
			
			switch_to_blog($site['blog_id']);
			
			uninstall();
			
		}
		
		restore_current_blog();
	
	
}else
{
	
		uninstall();
	
}


function uninstall()
{
	global $wpdb;
	
	
	$wpdb->query("delete from $wpdb->postmeta where meta_key like 'vote-%'");
	
	
	
	
}

?>
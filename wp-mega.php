<?php
/**
* Plugin Name: WP Mega 
* Description: WP Mega is a light but powerful plugin that can replace many plugins and make your site securer, faster, and smoother. Core features: <strong>Post Views Counter</strong>, <strong>Facebook Commenting System</strong>, <strong>Login/Logout Redirection</strong>, <strong>Insert Header &amp; Footer</strong>, <strong>Dashboard Access Control</strong> &amp; so on.
* Version: 1.0 
* Plugin URI: https://www.thecodist.co/
* Author: Nur Hossain
* Author URI: https://www.mohammad.win/
*/

if(!defined('WP_MEGA_DIR_URL')) define('WP_MEGA_DIR_URL', plugin_dir_url(__FILE__));
if(!defined('WP_MEGA_DIR_PATH')) define('WP_MEGA_DIR_PATH', plugin_dir_path(__FILE__));

if(!class_exists('WP_Mega'))
{
	class WP_Mega
	{
		public $ID;
		function __construct($id=0)
		{
			$this->init();
			$this->ID = $id;
			$this->set_properties();
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(__CLASS__, 'codist_link') );
			}
		function init()
		{
			foreach(glob(WP_MEGA_DIR_PATH.'inc/class/admin/*.php') as $file)
			{
				include_once($file);
				}
			foreach(glob(WP_MEGA_DIR_PATH.'inc/class/*.php') as $file)
			{
				include_once($file);
				}
			}
		function get_properties()
		{
			return get_object_vars($this);
			}
		function set_properties()
		{
			$properties = $this->get_properties();
			if(empty($properties)) return null;
			$wpms = $this->get_value();
			foreach($properties as $k=>$v)
			{
				if(isset($wpms[$k])) $this->$k = $wpms[$k];
				}
			}
		static function get_current_user_role()
		{
			}
			
		static function get_all_post_types()
		{
			global $wpdb;
			$post_types = $wpdb->get_results("SELECT DISTINCT post_type FROM {$wpdb->prefix}posts", ARRAY_A);
			return array_column($post_types, 'post_type');
			}			
		function get_value()
		{
			return get_option('wp_mega_settings_wms'); 
			}



		static function codist_link( $links )
		{
			$p_url = get_admin_url().'admin.php?page=wp_mega';
		 	$text = "<a href='{$p_url}'' target='_parent'>Settings</a>";
		 	$text .= ' | <a href="https://www.thecodist.co/?utm_referrer=wp_mega_plugin" target="_blank">{Code Happines}</a>';
		   	array_unshift($links, $text);
		   	return $links;
			}
		}
	$wp_mega = new WP_Mega();
	$wp_mega_settings = $wpms = $wp_mega->get_value();
	}

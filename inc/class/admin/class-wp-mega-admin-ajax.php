<?php
if(!class_exists('WP_Mega_Admin_AJAX'))
{
	class WP_Mega_Admin_AJAX
	{
		static $skip_fields = array('action','ajax_action','_wpnonce');
		function __construct()
		{
			add_action('wp_ajax_wp_mega_admin_ajax', array($this,'ajax'));
			add_action('wp_ajax_nopriv_wp_mega_admin_ajax', array($this,'ajax'));
			}
		function ajax()
		{
			if(!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'wp_mega')) die(json_encode(array(
				'status'	=> 0,
				'data'		=> 'Security check fails!',
				)));
			$method = $_POST['ajax_action'];
			if(method_exists($this, $method)) die(json_encode(array(
				'status'	=> 1,
				'data'		=> $this->$method(),
				)));
			die(json_encode(array(
				'status'	=> 0,
				'data'		=> 'No valid method found to handle the request.',
				)));
			}
		function show_admin_panel()
		{
			$class = $_POST['class'];
			if(!class_exists($class)) return "Invalid class name";
			$object = new $class();
			return $object->show_admin_panel();
			}
		function save_form_options()
		{
			$o_key = 'wp_mega_settings_wms';
			$value = get_option($o_key, array());
			foreach($_POST as $k=>$v)
			{
				$key = strtolower(trim(str_replace("[]", '', $k)));
				if(in_array($key, self::$skip_fields)) continue;
				$value[$key] = $v;
				update_option($o_key, $value);
				}
			return array('status'=>1,'data'=>'Saved');
			}
		function save_wp_mega_dashboard_access_settings()
		{
			return $this->save_form_options();
			}

		function save_wp_mega_log_redirect_settings()
		{
			return $this->save_form_options();
			}
		function save_wp_mega_admin_bar_settings()
		{
			return $this->save_form_options();
			}
		function save_wp_mega_remove_filter_settings()
		{
			return $this->save_form_options();
			}
		}
	$wpaa = new WP_Mega_Admin_AJAX();
	}
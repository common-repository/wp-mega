<?php
if(!class_exists('WP_Mega_Remove_Filter'))
{
	class WP_Mega_Remove_Filter extends WP_Mega
	{
		public $wp_mega_remove_filter;
		function __construct()
		{
			parent::__construct();
			add_action('init', array($this,'remove_filters'));
			}
		function remove_filters()
		{
			if(empty($this->wp_mega_remove_filter)) return null;
			$filters = explode("\n", $this->wp_mega_remove_filter);
			foreach($filters as $filter)
			{
				$parts = explode(',', $filter);
				if(empty($parts[0]) || empty($parts[1])) continue;
				remove_filter(trim($parts[0]),trim($parts[1]),10);
				}
			}

		function show_admin_panel()
		{
			global $wpms;
			$html = "<h2>Remove Filter</h2>";
			$html .= "<form class='codist_admin_form'>";

			$key = 'wp_mega_remove_filter';
			$html .= "<div class='codist-col-12'>";
				$html .= "<label>Remove Filters (filter_name, filter_function) <br></label>";
				$html .= "<textarea name='wp_mega_remove_filter'>{$this->wp_mega_remove_filter}</textarea>";
			$html .= "</div>";

			$html .= wp_nonce_field('wp_mega','_wpnonce',true,false);
			$html .= "<input type='submit' value='save'>";
			$html .= "<input type='hidden' name='action' value='wp_mega_admin_ajax'>";
			$html .= "<input type='hidden' name='ajax_action' value='save_form_options'>";
			$html .= "</form>";
			return $html;
			}			
		}
	$wprf = new WP_Mega_Remove_Filter();
	}
<?php
if(!class_exists('WP_Mega_Admin_Bar'))
{
	class WP_Mega_Admin_Bar extends WP_Mega
	{
		public $wp_mega_admin_bar_enable;
		public $wp_mega_admin_bar_role;

		function __construct()
		{
			parent::__construct();
			add_action('init', array($this,'control_admin_bar'));
			}

		function control_admin_bar()
		{
			if(!is_user_logged_in()) return false;
			if($this->wp_mega_admin_bar_enable == 0) return false;
			$user = get_user_by('ID', get_current_user_id());
			$user_role = reset($user->roles);
			if(!in_array($user_role, $this->wp_mega_admin_bar_role))
			{
				show_admin_bar(false);
				add_filter('show_admin_bar', '__return_false');
				} 
			}

		function show_admin_panel()
		{
			$roles = get_editable_roles();

			$html = "<h2>Admin Bar Settings</h2>";
			$html .= "<form class='codist_admin_form'>";
 
			$status = $this->wp_mega_admin_bar_enable;
			$staus_1 = ($status == 1) ? 'selected' : '';
			$staus_0 = ($status == 0) ? 'selected' : '';
			$html .= "<div class='codist-col-12'>";
			$html .= "<div class='label-wrap'><label>Status</label></div>";
			$html .= "<div class='value-wrap'>";
				$html .= "<select name='wp_mega_admin_bar_enable'>";
					$html .= "<option value='1' {$staus_1}>Enabled</option>";
					$html .= "<option value='0' {$staus_0}>Disabled</option>";
				$html .= "</select>";
			$html .= "</div>";

			$html .= "</div>";

			$html .= "<div class='codist-col-12'>";
				$html .= "<div class='label-wrap'><label>Following roles can see admin bar</label></div>";
				$html .= "<div class='value-wrap'>";
				foreach($roles as $k=>$v)
				{
					$checked = in_array($k, $this->wp_mega_admin_bar_role) ? ' checked ' : '';
					$html .= "<div class='codist-col-6'><input type='checkbox' name='wp_mega_admin_bar_role[]' value='{$k}' {$checked}> ".ucwords($k).'</div>';
					}
				$html .= "</div>";

			$html .= "</div>";
			$html .= wp_nonce_field('wp_mega','_wpnonce',true,false);
			$html .= "<input type='submit' value='save'>";
			$html .= "<input type='hidden' name='action' value='wp_mega_admin_ajax'>";
			$html .= "<input type='hidden' name='ajax_action' value='save_form_options'>";
			$html .= "</form>";
			return $html;
			}
		}
		$wmab = new WP_Mega_Admin_Bar();
	}
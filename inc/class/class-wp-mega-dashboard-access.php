<?php
if(!class_exists('WP_Mega_Dashboard_Access'))
{
	class WP_Mega_Dashboard_Access extends WP_Mega
	{
		public $wp_mega_dashboard_access_enable = false;
		public $wp_mega_dashboard_access_role = array();
		function __construct()
		{
			parent::__construct();
			add_action('admin_init', array($this,'control_access'));
			}
		function control_access()
		{
			if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
				return null;
			global $wpms;
			if(!is_user_logged_in()) return null;
			if($this->wp_mega_dashboard_access_enable != 1) return null;
			$user = get_user_by('ID', get_current_user_id());
			$user_role = reset($user->roles);
			$allowed = in_array($user_role, $this->wp_mega_dashboard_access_role) ? 1 : 0;
			if (!$allowed && !current_user_can('manage_options') && $_SERVER['PHP_SELF'] != '/wp-admin/admin-ajax.php'):
				wp_redirect(site_url());
				exit;
				endif;
 			}
		function show_admin_panel()
		{
			$roles = get_editable_roles();
			$html = "<h2>Dashboard Access Control</h2>";
			$html .= "<form class='codist_admin_form'>";
			
			$status = $this->wp_mega_dashboard_access_enable;
			$staus_1 = ($status == 1) ? 'selected' : '';
			$staus_0 = ($status == 0) ? 'selected' : '';
			$html .= "<div class='codist-col-12'>";
			$html .= "<div class='label-wrap'><label>Status</label></div>";

			$html .= "<div class='value-wrap'>";
				$html .= "<select name='wp_mega_dashboard_access_enable'>";
					$html .= "<option value='1' {$staus_1}>Enabled</option>";
					$html .= "<option value='0' {$staus_0}>Disabled</option>";
				$html .= "</select>";
			$html .= "</div>";

			$html .= "</div>";
			
			$html .= "<div class='codist-col-12'>";
			$html .= "<div class='label-wrap'><label>Following roles have access privilege:</label></div>";
			$html .= "<div class='value-wrap'>";
				foreach($roles as $k=>$v)
				{
					$checked = (in_array($k, $this->wp_mega_dashboard_access_role) || $k == 'administrator') ? ' checked ' : '';
					$disabled = ($k == 'administrator') ? 'disabled' : '';
					$html .= "<div class='codist-col-6'><input type='checkbox' name='wp_mega_dashboard_access_role[]' value='{$k}' {$checked} {$disabled}> ".ucwords($k).'</div>';
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
	$wmda = new WP_Mega_Dashboard_Access();
	}
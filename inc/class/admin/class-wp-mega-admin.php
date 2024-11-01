<?php
if(!class_exists('WP_Mega_Admin'))
{
	class WP_Mega_Admin extends Codist_Admin_Panel
	{
		function __construct()
		{
			parent::__construct();
			$this->set_prefix('wp_mega_admin_');
			$this->set_menu_options();
			add_action('admin_menu', array($this,'add_menu_pages'));
			add_action('admin_footer', array($this,'footer_content'));
			add_action('admin_footer', array($this,'wp_mega_footer_content'));
			}

		function wp_mega_footer_content()
		{
			ob_start();
			?> 
			<style type="text/css">
				.admin-header-logo { height: 75px; width: auto; margin: 25px auto 50px; }
				textarea { width: 100%; overflow: auto; min-height: 200px;}
				.textarea_tab { background-color: #333; color: #efefef; font-size: 17px; font-family: arial; font-weight: 500; }
				.wp-mega-header-wrap { height: auto; width: 100%; display: inline-block; text-align: center; }

				ul.codist-admin-menu-wrap li a {color: #8ec531; font-weight: 500;}
			</style>
			<script type="text/javascript">
				
			</script>
			<?php 
			$html = ob_get_contents();
			ob_get_clean();
			echo $html;
			}

		function get_header()
		{
			return "<div class='wp-mega-header-wrap'><img class='admin-header-logo' src='".WP_MEGA_DIR_URL."assets/img/plugin-logo.png' alt='WP Mega'></div>";
			}

		function set_menu_options()
		{
			$options  = array(
				array(
					'icon'		=> 'fa fa-bars',
					'label'		=> 'Admin Bar',
					'class'		=> 'WP_Mega_Admin_Bar',
					'action'	=> 'show_admin_panel'
					),
				array(
					'icon'		=> 'fa fa-lock',
					'label'		=> 'Dashboard Access',
					'class'		=> 'WP_Mega_Dashboard_Access',
					'action'	=> 'show_admin_panel'
					),
				array(
					'icon'		=> 'fa fa-sign-out-alt',
					'label'		=> 'Login | Logout Redirect',
					'class'		=> 'WP_Mega_Log_Redirect',
					'action'	=> 'show_admin_panel'
					),
				array(
					'icon'		=> 'fab fa-facebook',
					'label'		=> 'Facebook Commenting',
					'class'		=> 'WP_Mega_FB_Comment',
					'action'	=> 'show_admin_panel',
					),
				array(
					'icon'		=> 'fa fa-globe',
					'label'		=> 'Insert Header | Footer',
					'class'		=> 'WP_Mega_Header_Footer',
					'action'	=> 'show_admin_panel',
					),
				array(
					'icon'		=> 'fas fa-chart-line',
					'label'		=> 'Views Counter',
					'class'		=> 'WP_Mega_Views_Counter',
					'action'	=> 'show_admin_panel',
					),
				array(
					'icon'		=> 'fa fa-eye',
					'label'		=> 'Reveal ID',
					'class'		=> 'WP_Mega_Reveal_ID',
					'action'	=> 'show_admin_panel',
					),
				array(
					'icon'		=> 'fa fa-cut',
					'label'		=> 'Remove Version (CSS / JS)',
					'class'		=> 'WP_Mega_Remove_Version',
					'action'	=> 'show_admin_panel',
					),
				array(
					'icon'		=> 'fa fa-cut',
					'label'		=> 'Remove Filters',
					'class'		=> 'WP_Mega_Remove_Filter',
					'action'	=> 'show_admin_panel',
					),

				);
			$this->menu_options = $options;
			}

		function add_menu_pages()
		{
			add_menu_page('WP Mega', 'WP Mega', 'manage_options', 'wp_mega', array($this,'show_content'), 'dashicons-admin-settings');
			}

		function show_content()
		{
			echo $this->show_panel();
			}
		function get_right_content()
		{
			$html = "<div class='sidebar-wrap'>";
			$w_rating = "<div class='widget-wrap'>";
			$w_rating .= "<h2 class='title'>Rate Us, PLEASE!</h2>";
			$w_rating .= "<p class='content'>If our plugin has helped you have a better website, please rate our plugin so that other people can also be benefited. <a href='https://wordpress.org/plugins/search/wp-mega/'><strong>Click here</strong></a> for rating!</p>";
			$w_rating .= "</div>";

			$html .= $w_rating;
			$html .= "</div>";
			return $html;
			}
		}
		$wp_mega_admin = $wpma = new WP_Mega_Admin();
	}
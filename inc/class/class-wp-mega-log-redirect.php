<?php
if(!class_exists('WP_Mega_Log_Redirect'))
{
	class WP_Mega_Log_Redirect extends WP_Mega
	{
		public $wp_mega_log_redirect_enable;
		public $wp_mega_logout_redirect_url;
		public $wp_mega_login_redirect_url;
		function __construct()
		{
			parent::__construct();
			add_action('wp_login', array($this,'login_redirect'));
			add_action('wp_logout', array($this,'logout_redirect'));
			add_action('wp_footer', array($this,'footer_content'));
			}

		function footer_content()
		{
			$url = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : home_url();
			$logout_url = wp_logout_url($url);
			ob_start();
			?>
			<script type="text/javascript">
				var $j = jQuery.noConflict();
				$j(document).ready(function(){
					$j("a[href='#logout']").attr('href','<?php echo $logout_url; ?>');
				})
			</script>
			<?php 
			$html = ob_get_contents();
			ob_get_clean();
			echo $html;
			}

		function login_redirect()
		{
			if($this->wp_mega_log_redirect_enable != 1) return null;
			$url = $this->wp_mega_login_redirect_url;
			if(empty($url)) $url = site_url();
			if(is_numeric($url)) $url = get_permalink($url);
			if($url)
			{
				wp_redirect($url);
				exit();
				}
			}

		function logout_redirect()
		{
			if($this->wp_mega_log_redirect_enable != 1) return null;
			$url = $this->wp_mega_logout_redirect_url;
			if(empty($url)) $url = site_url();
			if(is_numeric($url)) $url = get_permalink();
			if($url)
			{
				wp_redirect($url);
				exit();
				}
			}


		function show_admin_panel()
		{
			global $wpms;
			$html = "<h2>Login/Logout Redirect Settings</h2>";
			$html .= "<form class='codist_admin_form'>";

			$staus_1 = ($this->wp_mega_log_redirect_enable == 1) ? 'selected' : '';
			$staus_0 = ($this->wp_mega_log_redirect_enable == 0) ? 'selected' : '';
			$html .= "<div class='codist-col-12'>";
			$html .= "<div class='label-wrap'><label>Status</label></div>";
			$html .= "<div class='value-wrap'>";
				$html .= "<select name='wp_mega_log_redirect_enable'>";
					$html .= "<option value='1' {$staus_1}>Enabled</option>";
					$html .= "<option value='0' {$staus_0}>Disabled</option>";
				$html .= "</select>";
			$html .= "</div>";
			$html .= "</div>";
			

			$html .= "<div class='codist-col-12'>";
				$html .= "<div class='label-wrap'><label>Login redirect URL</label></div>";
				$html .= "<div class='value-wrap'><input type='text' name='wp_mega_login_redirect_url' value='{$this->wp_mega_login_redirect_url}'></div>";
			$html .= "</div>";

			$html .= "<div class='codist-col-12'>";
				$html .= "<div class='label-wrap'><label>Logout redirect URL</div></label>";
				$html .= "<div class='value-wrap'><input type='text' name='wp_mega_logout_redirect_url' value='{$this->wp_mega_logout_redirect_url}'></div>";
			$html .= "</div>";

			$html .= wp_nonce_field('wp_mega','_wpnonce',true,false);
			$html .= "<input type='submit' value='save'>";
			$html .= "<input type='hidden' name='action' value='wp_mega_admin_ajax'>";
			$html .= "<input type='hidden' name='ajax_action' value='save_form_options'>";
			$html .= "</form>";
			return $html;
			}
		}
	$wpmlr = new WP_Mega_Log_Redirect();
	}
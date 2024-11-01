<?php
if(!function_exists('WP_Mega_Remove_Version'))
{
	class WP_Mega_Remove_Version extends WP_Mega
	{
		public $wp_mega_remove_version;
		function __construct()
		{
			parent::__construct();
			$this->prepare();
			}
		function prepare()
		{
			if($this->wp_mega_remove_version == 0) return null;
			add_filter('script_loader_src', array($this,'remove'), 15, 1);
			add_filter('style_loader_src', array($this,'remove'), 15, 1);
			}


		function show_admin_panel()
		{
			global $wpms;
			$html = "<h2>Remove Version from CSS / JavaScript Files</h2>";
			$html .= "<form class='codist_admin_form'>";

			$staus_1 = ($this->wp_mega_remove_version == 1) ? 'selected' : '';
			$staus_0 = ($this->wp_mega_remove_version == 0) ? 'selected' : '';
			$html .= "<div class='codist-col-12'>";
				$html .= "<div class='label-wrap'><label>Status</label></div>";
				$html .= "<div class='value-wrap'>";
					$html .= "<select name='wp_mega_remove_version'>";
						$html .= "<option value='1' {$staus_1}>Enabled</option>";
						$html .= "<option value='0' {$staus_0}>Disabled</option>";
					$html .= "</select>";
				$html .= "</div>";
			$html .= "</div>";

			$html .= wp_nonce_field('wp_mega','_wpnonce',true,false);
			$html .= "<input type='submit' value='save'>";
			$html .= "<input type='hidden' name='action' value='wp_mega_admin_ajax'>";
			$html .= "<input type='hidden' name='ajax_action' value='save_form_options'>";
			$html .= "</form>";
			return $html;
			}

		function remove($src)
		{
			$req = explode('?ver', $src);
			if(count($req) > 1) return $req[0];
			$req = explode('&ver', $src);
			return $req[0];
			}
		}
		$wpmrv = new WP_Mega_Remove_Version();
	}
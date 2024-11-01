<?php
if(!class_exists('WP_Mega_Header_Footer'))
{
	class WP_Mega_Header_Footer extends WP_Mega
	{
		public $wp_mega_header_content;
		public $wp_mega_footer_content;

		function __construct()
		{
			parent::__construct();
			add_action('wp_head', array($this,'header_content'));
			add_action('wp_footer', array($this, 'footer_content'));
			}

		function header_content()
		{
			global $wpms;
			echo stripcslashes($this->wp_mega_header_content);
			}
		function footer_content()
		{
			global $wpms;
			echo stripslashes($this->wp_mega_footer_content);
			}

		function show_admin_panel()
		{
			global $wpms;
			$html = "<h2>Header Content</h2>";
			$html .= "<form class='codist_admin_form'>";

 			$value = stripslashes($this->wp_mega_header_content);
			$html .= "<div class='codist-col-12'>";
				$html .= "<label>Header Content (HTML / CSS / JavaScript)<br></label>";
				$html .= "<textarea name='wp_mega_header_content' id='header_tabable'  class='textarea_tab'>{$value}</textarea>";
			$html .= "</div>";


			$value = stripcslashes($this->wp_mega_footer_content);
			$html .= "<div class='codist-col-12'>";
				$html .= "<label>Footer Content (HTML / CSS / JavaScript)</label><br>";
				$html .= "<textarea name='wp_mega_footer_content' id='footer_tabable' class='textarea_tab'>{$value}</textarea>";
			$html .= "</div>";

			$html .= wp_nonce_field('wp_mega','_wpnonce',true,false);
			$html .= "<input type='submit' value='save'>";
			$html .= "<input type='hidden' name='action' value='wp_mega_admin_ajax'>";
			$html .= "<input type='hidden' name='ajax_action' value='save_form_options'>";
			$html .= "</form>";

			$html .= "<script type='text/javascript'>enableTab('header_tabable');enableTab('footer_tabable');</script>";
			return $html;
			}
		}
	$wfhm = new WP_Mega_Header_Footer();
	}
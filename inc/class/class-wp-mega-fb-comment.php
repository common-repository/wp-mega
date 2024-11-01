<?php
if(!class_exists('WP_Mega_FB_Comment'))
{
	class WP_Mega_FB_Comment extends WP_Mega
	{
		public $wp_mega_fb_comment_enable = false;
		public $wp_mega_fb_comment_app_id = 0;
		public $wp_mega_fb_comment_width = '100%';
		public $wp_mega_fb_comment_num_comments = 5;
		public $wp_mega_fb_comment_title = 'Discussions';
		public $url;

		function __construct()
		{
			parent::__construct();
			add_filter('the_content', array($this, 'show_fb_comment'));
			}

		function show_fb_comment($content)
		{
			return $content.$this->show();
			}

		function get_url()
		{
			global $post;
			return get_permalink($post->ID);
			}

		function show()
		{
			return null;
			$html = "<div class='wp-mega-fb-comment-wrap'>";
				if(!empty($this->wp_mega_fb_comment_title)) $html .= "<p>{$this->wp_mega_fb_comment_title}</p>";
				$html .= "<div class='fb-comments' data-href='{$this->get_url()}' data-numposts='{$this->wp_mega_fb_comment_num_comments}' width='{$this->wp_mega_fb_comment_width}' style='width: {$this->wp_mega_fb_comment_width};'></div>";
			$html .= "</div>";
			return $html;
			}

		function show_admin_panel()
		{
			global $wpms;
			$html = "<h2>Facebook Comment Settings</h2>";
			$html .= "<form class='codist_admin_form'>";

			$staus_1 = ($this->wp_mega_fb_comment_enable == 1) ? 'selected' : '';
			$staus_0 = ($this->wp_mega_fb_comment_enable == 0) ? 'selected' : '';
			
			$html .= "<div class='codist-col-12'>";
			$html .= "<div class='label-wrap'><label>Status</label></div>";
			$html .= "<div class='value-wrap'>";
				$html .= "<select name='wp_mega_fb_comment_enable'>";
					$html .= "<option value='1' {$staus_1}>Enabled</option>";
					$html .= "<option value='0' {$staus_0}>Disabled</option>";
				$html .= "</select>";
			$html .= "</div>";
			$html .= "</div>";			
			
 			$html .= "<div class='codist-col-12'>";
 				$html .= "<div class='label-wrap'><label>Faceook App ID</label></div>";
 				$html .= "<div class='value-wrap'><input type='text' name='wp_mega_fb_comment_app_id' value='{$this->wp_mega_fb_comment_app_id}'></div>";
 			$html .= "</div>";

			$html .= "<div class='codist-col-12'>";
				$html .= "<div class='label-wrap'><label>Number of Comments</label></div>";
				$html .= "<div class='value-wrap'><input type='text' name='wp_mega_fb_comment_num_comments' value='{$this->wp_mega_fb_comment_num_comments}'></div>";
			$html .= "</div>";

			$html .= "<div class='codist-col-12'>";
				$html .= "<div class='label-wrap'><label>Comment Title</label></div>";
				$html .= "<div class='value-wrap'><input type='text' name='wp_mega_fb_comment_title' value='{$this->wp_mega_fb_comment_title}'></div>";
			$html .= "</div>";

			$html .= "<div class='codist-col-12'>";
				$html .= "<div class='label-wrap'><label>Comment Box Width</label></div>";
				$html .= "<div class='value-wrap'><input type='text' name='wp_mega_fb_comment_width' value='{$this->wp_mega_fb_comment_width}'></div>";
			$html .= "</div>";

			$html .= wp_nonce_field('wp_mega','_wpnonce',true,false);
			$html .= "<input type='submit' value='save'>";
			$html .= "<input type='hidden' name='action' value='wp_mega_admin_ajax'>";
			$html .= "<input type='hidden' name='ajax_action' value='save_form_options'>";
			$html .= "</form>";
			return $html;
			}
		}
	$wpfc = new WP_Mega_FB_Comment();
	}
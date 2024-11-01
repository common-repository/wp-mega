<?php
if(!class_exists('SPCA'))
{
	class SPCA
	{
		public $post_id;
		public $field;
		function __construct()
		{
			add_shortcode('show_post_content',array($this,'shortcode'));
			add_shortcode('SPC',array($this,'shortcode'));
			add_shortcode('spc',array($this,'shortcode'));
			add_shortcode('spca',array($this,'shortcode'));
			}


		function shortcode($atts)
		{
			$params = shortcode_atts(
				array(
					'post_id'	=> 0,
					'field'		=> 'post_content',
					),
				$atts
				);
			$this->post_id = intval($params['post_id']);
			$this->field = $params['field'];
			if(!$this->post_id) return null;
			$spc_post = get_post($this->post_id);
			$html = do_shortcode($spc_post->post_content);
			$html .= "<style type='text/css'>".get_post_meta($this->post_id,'_wpb_shortcodes_custom_css',true)."</style>";
			return $html;
			}
		}
	$spca = new SPCA();
	}
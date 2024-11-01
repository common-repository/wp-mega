<?php
if(!class_exists('WP_Mega_Views_Counter'))
{
	class WP_Mega_Views_Counter extends WP_Mega
	{
		public $wp_mega_views_counter_enable = false;
		public $wp_mega_views_counter_show_after_post = false;
		function __construct()
		{
			parent::__construct();
			add_action('wp_footer', array($this,'update_counter'));
			add_action('the_content', array($this, 'show_after_post'));
			add_shortcode('simple_views_counter', array($this,'shortcode'));
			if($this->wp_mega_views_counter_enable == 1) add_action('admin_init', array($this,'add_views_column'));
			}

		function add_views_column()
		{
			$post_types = $this->get_all_post_types();
			foreach($post_types as $pt)
			{
				add_filter("manage_{$pt}_posts_columns", array($this,'set_custom_edit_counter_column'));
				add_action("manage_{$pt}_posts_custom_column", array($this,'custom_counter_column'), 10, 2 );
				add_action("manage_edit-{$pt}_sortable_columns", array($this,'custom_sortable_counter_column'));
				}
			}

		function custom_sortable_counter_column($columns)
		{
			$columns['Views'] = 'Views';
			return $columns;
			}

		function set_custom_edit_counter_column($columns)
		{
		    //$columns['Views'] = __( 'Views', 'WP_Mega' );
		    $columns = array_slice($columns, 0, 1, true) + array('Views'=>'Views')+ array_slice($columns, 1, count($columns) - 1, true);
		    return $columns;
			}

		function custom_counter_column( $column, $post_id ) 
		{
		    switch($column) 
		    {
		        case 'Views' :
		        	$counter =  get_post_meta($post_id, 'wp_mega_views_counter', true);
		        	if(!$counter) $counter = 0;
		        	echo $counter;
		            break;
		    	}
			}
		function shortcode($atts)
		{
			$params = shortcode_atts(array(
				'ID'		=> get_queried_object_id(),
				'action'	=> 'show_counter',
				),$atts);
			$this->ID = $params['ID'];
			$action = $params['action'];
			if(method_exists($this, $action)) return $this->$action();
			}
		function get_counter()
		{
			if(!$this->ID) $this->ID = get_queried_object_id();
			if(is_single() || is_page())
				return get_post_meta($this->ID, 'wp_mega_views_counter', true);
			else 
				return get_option('wp_mega_views_counter_tax_'.$this->ID);
			}

		function show_after_post($content)
		{
			if(!$this->wp_mega_views_counter_show_after_post || is_front_page()) return $content;
			return $content.$this->show_counter();
			}

		function show_counter()
		{
			$html = "<div class='wp-views-counter-wrap'><i class='fa fa-eye'></i> ".$this->get_counter()." </div>";
			return $content.$html;
			}
		function update_counter()
		{
			if(!$this->wp_mega_views_counter_enable) return null;
			$id = get_queried_object_id();
			if(is_single() || is_page())
			{
				$current = (int) get_post_meta($id, 'wp_mega_views_counter', true);
				$current++;
				update_post_meta($id,'wp_mega_views_counter', $current);
				}
			else
			{
				$key = 'wp_mega_views_counter_tax_'.$id;
				$current = (int) get_option($key, 0);
				$current++;
				update_option($key, $current);
				}
			return null;
			}

		function show_admin_panel()
		{
 			$html = "<h2>Views Counter</h2>";
			$html .= "<form class='codist_admin_form'>";
			
			$status = $this->wp_mega_views_counter_enable;
			$staus_1 = ($status == 1) ? 'selected' : '';
			$staus_0 = ($status == 0) ? 'selected' : '';
			$html .= "<div class='codist-col-12'>";
				$html .= "<div class='label-wrap'><label>Status</label></div>";
			
				$html .= "<div class='value-wrap'>";
				$html .= "<select name='wp_mega_views_counter_enable'>";
					$html .= "<option value='1' {$staus_1}>Enabled</option>";
					$html .= "<option value='0' {$staus_0}>Disabled</option>";
				$html .= "</select>";
				$html .= "</div>";

			$html .= "</div>";
			
			$status = $this->wp_mega_views_counter_show_after_post;
			$option_1 = ($status == 1) ? 'checked' : '';
			$option_0 = ($status == 0) ? 'checked' : '';

			$html .= "<div class='codist-col-12'>";
			$html .= "<div class='label-wrap'><label>Show views counter after post?</label></div>";
			$html .= "<div class='value-wrap'>";
				$html .= "<input type='radio' name='wp_mega_views_counter_show_after_post' value='1' {$option_1}> Yes ";
				$html .= "<input type='radio' name='wp_mega_views_counter_show_after_post' value='0' {$option_0}> No ";
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
	$wpmvsc = new WP_Mega_Views_Counter();		
	}
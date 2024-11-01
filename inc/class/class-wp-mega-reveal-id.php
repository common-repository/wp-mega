<?php
if(!class_exists('WP_Mega_Reveal_ID'))
{
	class WP_Mega_Reveal_ID extends WP_Mega
	{
		public $wp_mega_reveal_id_enable;
		function __construct()
		{
			parent::__construct();
			add_action('admin_init', array($this,'reveal_ID'));
			}

		function show_admin_panel()
		{
 			$html = "<h2>Reveal ID</h2>";
			$html .= "<form class='codist_admin_form'>";
			$status = $this->wp_mega_reveal_id_enable;
			$status_1 = ($status == 1) ? 'selected' : '';
			$status_0 = ($status == 0) ? 'selected' : '';
			$html .= "<div class='codist-col-12'>";
				$html .= "<div class='label-wrap'><label>Status</label></div>";
				$html .= "<div class='value-wrap'>";
				$html .= "<select name='wp_mega_reveal_id_enable'>";
					$html .= "<option value='1' {$status_1}>Enabled</option>";
					$html .= "<option value='0' {$status_0}>Disabled</option>";
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

		function reveal_ID()
		{
			if($this->wp_mega_reveal_id_enable != 1) return null;
			$post_types = $this->get_all_post_types();
			foreach($post_types as $pt)
			{
				add_filter("manage_{$pt}_posts_columns", array($this,'set_custom_edit_reveal_columns'));
				add_action("manage_{$pt}_posts_custom_column", array($this,'custom_reveal_column'), 10, 2 );
				add_action("manage_edit-{$pt}_sortable_columns", array($this,'custom_sortable_reveal_column'));
				}
			}

		function custom_sortable_reveal_column($columns)
		{
			$columns['ID'] = 'ID';
			return $columns;
			}

		function set_custom_edit_reveal_columns($columns)
		{
		    $columns = array_slice($columns, 0, 1, true) + array('ID'=>'ID')+ array_slice($columns, 1, count($columns)-1, true);
		    return $columns;
			}

		// Add the data to the custom columns for the book post type:
		function custom_reveal_column( $column, $post_id ) 
		{
		    switch($column) 
		    {
		        case 'ID' :
		        	echo $post_id;
		            break;
		    	}
			}
		}
	$wpmrid = new WP_Mega_Reveal_ID();
	}
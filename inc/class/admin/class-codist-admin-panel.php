<?php
if(!class_exists('Codist_Admin_Panel'))
{
	class Codist_Admin_Panel
	{
		public $prefix = 'codist_';
		public $menu;
		public $menu_options;
		function __construct()
		{
			add_action('admin_init', array(__CLASS__,'register_scripts'));
			}
		static function register_scripts()
		{
			//wp_enqueue_style('font-awesome','//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', null, null, 'all');
			}

		function footer_content()
		{
			ob_start();
			?>
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
			<style type="text/css">
				.codist-admin-panel-wrap { width: 100%; height: auto; display: inline-block; float: none; padding-right: 20px; box-sizing: border-box; }
				<?php 
					for($i =1; $i<=12; $i++)
					{
						$w = 100/12 * $i;
						echo ".codist-col-{$i} { width: {$w}%; }";
						}
				?>
				div[class*='codist-col-']{ position: relative; font-size: 14px; line-height: 26px; min-height: 1px; padding: 0; display: inline-block; float: left; clear: none;  box-sizing: border-box;  }
				form.codist_admin_form div[class*='codist-col-12']{ background: #f7f7f7; border-bottom: 1px solid #aaa;}
				div.codist-admin-loading, 
					div.codist-admin-updated { display: none;  height: 100%; width: 100%; position: absolute; background: rgba(255,255,255, 0.9); z-index: 9990; top: 0; left: 0;  }
				div.codist-admin-updated { background: rgba(255,255,255, 0.9) }
				div.header-wrap { width: 100%; height: auto; display: inline-block; min-height: 100px; }
				div.sidebar-wrap { background: #eee; height: 100%; }
				div.content-wrap { width: 100%; height: auto; padding: 0 25px; box-sizing: border-box; }

				ul.codist-admin-menu-wrap{ margin: 0; padding: 0; }
				ul.codist-admin-menu-wrap li { width: 100%; height: auto; display: inline-block; line-height: 30px; margin: 0px;  padding: 5px 0 5px 5px; border-bottom: 1px solid #aaa; box-sizing: border-box; cursor: pointer; }
				ul.codist-admin-menu-wrap li:hover { background: #dfdfdf; }
				ul.codist-admin-menu-wrap li i { width: 20px; margin-right: 5px; font-size: 16px; }
				ul.codist-admin-menu-wrap li a { text-decoration: none; font-size: 15px; font-weight: normal; line-height: 30px; }

				ul.codist-admin-menu-wrap li.active-menu-item { background: #8ec531; }
				ul.codist-admin-menu-wrap li.active-menu-item a,
					ul.codist-admin-menu-wrap li.active-menu-item i { color: #fff; }				

				form.codist_admin_form label { color: #777; font-weight: bold; line-height: 20px !important; } 
				form.codist_admin_form input[type='submit'] { background: #8ec531; color: #fff; margin: 10px 0; text-transform: capitalize;  border: none; padding: 5px 25px; line-height: 30px; cursor: pointer; display: inline-block; font-weight: bold; }
				form.codist_admin_form input[type='submit']:hover { background: #333; }
				form.codist_admin_form input[type='text'],
					form.codist_admin_form input[type='number'],
					form.codist_admin_form input[type='email'],
					form.codist_admin_form input[type='password']{
					width: 100%; display: inline-block; padding: 5px 10px; border: 1px solid #aaa; height: 30px;
				}

				.label-wrap { height: 100%; position: relative; width: 30%; }
				.value-wrap { width: 70%; background: #fff; }
				.label-wrap,
					.value-wrap{ float: left; display: inline-block; padding: 10px; box-sizing: border-box;}

				/* SIDEBAR */
				.sidebar-wrap .widget-wrap { box-shadow: 0 0 5px #777; background: #fff !important; display: inline-block; width: 100%; height: auto; padding: 10px; box-sizing: border-box; } 
				.widget-wrap h2.title { margin: 0 0 10px 0; padding-bottom: 10px; width: 100%; height: auto; display: Inline-block; border-bottom: 2px solid #8ec531; color: #8ec531; }
				.widget-wrap p.content { font-size: 14px !important	; line-height: 22px; }
		
				/* LOADING EFFECT */
				.box-center{ position: absolute; top: 50%; left: 50%; margin: -20px 0 0 -20px;}
				.codist-spinner {position: relative; width: 40px; height: 40px; background-color: #8ec531; margin: 0 auto; -webkit-animation: sk-rotateplane 1.2s infinite ease-in-out; animation: sk-rotateplane 1.2s infinite ease-in-out; }
				@-webkit-keyframes sk-rotateplane {
				  0% { -webkit-transform: perspective(120px) }
				  50% { -webkit-transform: perspective(120px) rotateY(180deg) }
				  100% { -webkit-transform: perspective(120px) rotateY(180deg)  rotateX(180deg) }
				}

				@keyframes sk-rotateplane {
				  0% { 
				    transform: perspective(120px) rotateX(0deg) rotateY(0deg);
				    -webkit-transform: perspective(120px) rotateX(0deg) rotateY(0deg) 
				  } 50% { 
				    transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg);
				    -webkit-transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg) 
				  } 100% { 
				    transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
				    -webkit-transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
				  }
				}

				.icon-updated { color: #8ec531; font-size: 40px; }			

			</style>
			<script type="text/javascript">
				var $j = jQuery.noConflict();
				var _wpnonce = '<?php echo wp_create_nonce('wp_mega'); ?>';
				var ADMIN_AJAX_URL = '<?php echo admin_url('admin-ajax.php'); ?>';
				$j(document).ready(function(){
					var debug = true;
					function clog(data){
						if(debug) console.log(data);
					}
					function preventDefault(e){
						e.preventDefault();
						e.stopPropagation();
					}
					function showLoading(){
						hideUpdated();
						$j('.codist-admin-loading').show();
					}
					function hideLoading(){
						$j('.codist-admin-loading').hide();
					}
					function showUpdated(){
						hideLoading();
						$j('.codist-admin-updated').show();
						setTimeout(hideUpdated, 2000);
					}
					function hideUpdated(){
						$j('.codist-admin-updated').hide();
					}


					// Load admin panel 
					$j(document).on('click','.codist-admin-li-item', function(e){
						preventDefault(e);
						var clickedItem = $j(this);
						var action = '<?php echo $this->prefix;?>ajax';
						var ajaxAction = $j(this).attr('data-action');
						var className = $j(this).attr('data-class')
						var data = '_wpnonce='+_wpnonce+'&action='+action+'&ajax_action='+ajaxAction+'&class='+className;
						$j.ajax({
							url 		: ADMIN_AJAX_URL,
							method 		: 'POST', 
							data 		: data, 
							dataType 	: 'json',
							beforeSend 	: function(){
								clog(data);
								showLoading();
							},
							success 	: function(response){
								hideLoading();
								if(response.status == 1){
									$j('.codist-admin-content-wrap').html(response.data);
								} else {
									alert('Security check fails! The page will be refreshed.');
									window.location.reload();
								}
								$j('*').removeClass('active-menu-item');
								$j(clickedItem).addClass('active-menu-item');

							}
						})
					})

					$j(document).on('submit','.codist_admin_form',function(e){
						preventDefault(e);
						var dataString = $j(this).serialize();
						$j.ajax({
							url 		: ADMIN_AJAX_URL,
							data 		: dataString,
							method 		: 'POST',
							dataType 	: 'json',
							beforeSend 	: function(){
								clog(dataString);
								showLoading();
							},
							success 	: function(response){
								clog(response.data);
								showUpdated();
							}
						})
					})
				})
					// Tab index in textarea 
					function enableTab(id) {
					    var el = document.getElementById(id);
					    el.onkeydown = function(e) {
					        if (e.keyCode === 9) { // tab was pressed

					            // get caret position/selection
					            var val = this.value,
					                start = this.selectionStart,
					                end = this.selectionEnd;

					            // set textarea value to: text before caret + tab + text after caret
					            this.value = val.substring(0, start) + '\t' + val.substring(end);

					            // put caret at right position again
					            this.selectionStart = this.selectionEnd = start + 1;

					            // prevent the focus lose
					            return false;

					        }
					    };
					}				
			</script>
			<?php 
			$html = ob_get_contents();
			ob_get_clean();
			echo $html;
			}
		function set_prefix($prefix)
		{
			$this->prefix = $prefix;
			}

		function show_panel()
		{
			$html = "<div class='codist-admin-panel-wrap'>";
			$html .= "<div class='codist-col-12'><div class='header-wrap'>".$this->get_header()."</div></div>";
			$html .= "<div class='codist-col-3'><div class='menubar-wrap'>".$this->get_left_content()."</div></div>";
			$html .= "<div class='codist-col-6'>
						<div class='codist-admin-loading'><div class='box-center'><div class='codist-spinner'></div></div></div>
						<div class='codist-admin-updated'><div class='box-center'><i class='icon-updated fas fa-check'></div></i></div>
						<div class='content-wrap'>".$this->get_middle_content()."</div>
					</div>";
			$html .= "<div class='codist-col-3'><div class='sidebar-wrap'>".$this->get_right_content()."</div></div>";
			$html .= "</div>";
			return $html;
			}
		function get_header()
		{	
			return 'header';
			}

		function get_left_content()
		{
			return $this->get_menu();
			}
		function get_menu()
		{
			if(empty($this->menu_options)) return null;
			$html = "<ul class='codist-admin-menu-wrap'>";
			foreach($this->menu_options as $s)
			{
				$icon = isset($s['icon']) ? $s['icon'] : '';
				$href = isset($s['href']) ? $s['href'] : '#';
				$class = isset($s['class']) ? $s['class'] : '';
				$label = isset($s['label']) ? $s['label'] : '';
				$action = isset($s['action']) ? $s['action'] : '';
				$html .= "<li data-action='{$action}' data-class='{$class}' class='codist-admin-li-item'><div class='codist-admin-menu-item'><i class='{$icon}'></i> <a href='{$href}' class='{$class}'>{$label}</a></div>";
				if(isset($s['submenu']))
				{
					$html .= "<ul class='submenu'>";
					foreach($s['submenu'] as $sm)
					{
						$icon = isset($sm['icon']) ? $sm['icon'] : '';
						$href = isset($sm['href']) ? $sm['href'] : '#';
						$class = isset($sm['class']) ? $sm['class'] : '';
						$label = isset($sm['label']) ? $sm['label'] : '';
						$action = isset($sm['action']) ? $sm['action'] : '';
						$html .= "<li data-action='{$action}' data-class='{$class}' class='codist-admin-li-item'><div class='codist-admin-submenu-item'><i class='{$icon}'></i> <a data-action='{$action}' href='{$href}' class='{$class}'>{$label}</a></div></li>";
						}
					$html .= "</ul>";
					}
				$html .= "</li>";
				}
			$html .= "</ul>";
			return $html;
			}
		function set_menu_options()
		{
			$this->menu_options = array();
			}
		function get_right_content()
		{
			return "right content";
			}
		function get_middle_content()
		{
			$wp_mega = new WP_Mega_FB_Comment();
			return "<div class='codist-admin-content-wrap'>Please select an option from left side!<br><br><br><br><br></div>";
			}

		}
	$cap = new Codist_Admin_Panel();
	}
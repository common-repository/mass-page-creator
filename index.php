<?php
	 /* Plugin Name: Mass Page Creator
    Description: Allows you to create pages in bulk.
    Version: .12
    Author: Kyle Foulks
    Author URI: http://twitter.com/KyleFoulks
	License: GPLv2
    */
	
	function mpc_menu(){
		add_options_page( 'Mass Page Creator', 'Mass Page Creator', 'manage_options', 'mass_page_creator', 'mpc_display_page');
	}
	
	function mpc_display_page(){
		echo '<h2>Mass Page Creator</h2>';
		echo 'Enter your page titles below. The order will automatically be added to each page, based on the order you enter them into this editor.  ';
		echo '<div id="mpc_wrap">';
		echo '<form method="post" action="options-general.php?page=mass_page_creator">';
			echo '<table id="addable">';
						echo '<tr>
								<td><h4>Page Title:</h4></td>
						';
						$i = 1;
						while ($i <= 10):
							echo '
							<tr>
								<td><input type="text" name="title[]"></td>
							</tr>';
							$i++;
						endwhile;
			echo '</table><br>';
			
			echo '<a id="one_more_field">Add 1 More Field</a><br>';
			echo '<a id="ten_more_fields">Add 10 More Fields</a>';
			
			echo '<br><br>';
			echo '<h4>Which parent page should these pages be added to? (optional)</h4>';
			
			$args = array(
				'depth'            => 0,
				'child_of'         => 0,
				'selected'         => 0,
				'echo'             => 1,
				'show_option_none' => 'Main Page (No Parent)',
				'name'             => 'page_parent');
			
			wp_dropdown_pages($args).'<br><br>';
			echo '<br><input id="submit" style="margin-top: 15px;" class="button button-primary" type="submit" value="Add Pages">';
		echo '</form>';
		
			if(isset($_POST['title'])){
				$order = 0;
				foreach($_POST['title'] as $title) {
					if($title != ''){
						$order++;
						$my_post = array(
							  'menu_order'    => $order,
							  'post_title'    => $title,
							  'post_status'   => 'publish',
							  'post_author'   => 1,
							  'post_type'      => 'page',
							  'post_parent' => $_POST['page_parent']
							);
							wp_insert_post( $my_post );
					}
				}
			}
			echo '</div>';//close out the mpc_wrap div
			
			//include the contact form
			$contact_info = plugin_dir_path( __FILE__ ) . 'contact/form.php';
			include ($contact_info);
		}
	
	add_action('admin_menu','mpc_menu');
	
	//load our javascript only on the Mass Page Creator settings page.
	if($_GET['page'] == 'mass_page_creator'){
		add_action('admin_enqueue_scripts','mpc_load_admin_js');
	};
	
	function mpc_load_admin_js(){
		wp_register_script( 'mpc_admin_script', plugins_url('js/mpc_admin.js', __FILE__) );
		wp_enqueue_script('mpc_admin_script');
		
		//load the style for our contact form
		wp_register_style( 'contact-form-style', plugins_url('contact/style.css', __FILE__));
		wp_enqueue_style('contact-form-style');
		
		wp_register_script( 'contact-form-java', plugins_url('contact/js/contact.js', __FILE__) );
		wp_enqueue_script('contact-form-java');
	}
	
?>
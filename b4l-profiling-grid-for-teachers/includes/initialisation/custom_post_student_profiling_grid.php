<?php

/*
 Plugin Name: Student Profiling Grid Plugin
 Description: Plugin for assigning the grades to students on the basis of their progress
 Version: 1.0
 Author: Muhammad Uzair
 Author URI: https://www.linkedin.com/in/uzair043/
*/

wp_enqueue_script("jquery");
wp_enqueue_script('jquery-ui');
wp_enqueue_script('jquery-ui-tabs');
wp_enqueue_style( 'wp-admin' );

require_once( 'create-profiling_grid.php');

function check_student($val) {
	global $post;

	if(is_array(get_post_meta($post->ID, "student_portfolio", true)))
		$checkbox_values = get_post_meta($post->ID, "student_portfolio", true);
	else
		$checkbox_values = array();

	if(in_array($val, $checkbox_values))
		return " checked";
}

function custom_post_student_portfolio() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => 'Student Profiling Grid',
		'singular_name'       => 'Student Profiling Grid',
		'menu_name'           => 'Student Profiling Grid',
		'parent_item_colon'   => 'Parent Student Profiling Grid',
		'all_items'           => 'Student Profiling Grids',
		'view_item'           => 'View Student Profiling Grid',
		'add_new_item'        => 'Add New Student Profiling Grid',
		'edit_item'           => 'Edit Student Profiling Grid',
		'update_item'         => 'Update Student Profiling Grid',
		'search_items'        => 'Search Student Profiling Grids',
		'not_found'           => 'Not Found',
		'not_found_in_trash'  => 'Not found in Trash'
	);

// Set other options for Custom Post Type

	$args = array(
		'label'               => 'student_portfolio',
		'description'         => 'A custom post to assign language levels to students based on their proficiency.',
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor'),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'menu_icon'			  => plugins_url('../../images/portfolios.png', __FILE__),
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capabilities'     => array(
			'edit_post' => 'edit_student_portfolio',
			'edit_posts' => 'edit_student_portfolios',
			'edit_others_posts' => 'edit_other_student_portfolios',
			'edit_published_posts' => 'edit_published_student_portfolios',
			'publish_posts' => 'publish_student_portfolios',
			'read_post' => 'read_student_portfolio',
			'read_posts' => 'read_student_portfolios',
			'read_private_posts' => 'read_private_student_portfolios',
			'delete_post' => 'delete_student_portfolio'
		)

	);

	// Registering your Custom Post Type
	register_post_type( 'student_portfolio', $args );

}

add_action( 'init', 'custom_post_student_portfolio');

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/

function metabox_student()
{
	add_action('add_meta_boxes', function(){
		add_meta_box('student', 'Student Grid Badges', 'student_grades', 'student_portfolio');
	});

	function student_grades($post){
		include(plugin_dir_path( dirname( __FILE__ ) ) . 'utils/js_send_badge.php');
		include(plugin_dir_path( dirname( __FILE__ ) ) . 'utils/style.php');

		$descriptions = array(
			'A1' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
			Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
			Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
			'A2' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
			Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
			Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
			'B1' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
			Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
			Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
			'B2' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
			Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
			Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
			'C1' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
			Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
			Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
			'C2' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
			Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
			Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
		);

		foreach ($descriptions as $level=>$description) {
			?>
			<div style="overflow:hidden;">
				<div id="result_<?php echo $level; ?>" style="float:left;">
					<input type="checkbox" name="input_badge_student_grid_name" id="badge_<?php echo $level; ?>" class="input-badge input-hidden" value="<?php echo $level; ?>"/>
					<label for="badge_<?php echo $level; ?>">
						<img id="image_<?php echo $level; ?>" src="<?php echo plugin_dir_url( __FILE__ ); ?>../../images/badges/student_levels/<?php echo $level; ?>.png" width="100px" height="100px" />
					</label>
				</div>
				<div style="float:left;">
					<p id="description_<?php echo $level; ?>"><?php echo $description; ?></p>
				</div>
			</div>
			<?php
			}
			?>
			<br />
			<div id="result_send_badge_student_grid">
				<input type="button" id="send_badges_student_grid" onclick="javascript:sendBadgesStudentGrid('<?php echo get_post_meta($post->ID,'_portfolio_language',true); ?>')" class="button button-primary" value="Send badges to yourself" />
			</div>
		<?php
	}
}

add_action('init', 'metabox_student');

/* Adds the metabox student portfolio language into the badge custom post type */
function metabox_student_portfolio_language(){
	add_action('add_meta_boxes', function(){
		add_meta_box('id_meta_box_student_portfolio_language', 'Student portfolio language', 'student_portfolio_language', 'student_portfolio', 'side', 'high');
	});

	function student_portfolio_language($post){
		if( is_plugin_active( "open-badges-framework/open-badges-framework.php" ) ) {
			// Display the children of the right PARENT
		    $parents = apply_filters( 'plugin_get_sub', $parents );
		    echo '<div style="margin-bottom:5px;"><b>Most important languages :</b></div>';
		    ?>

		    <select name="language" id="language">
		    	<option value="Select">Select</option>
			    <?php
				    foreach ((array)$parents['most-important'] as $language) {
				    	if( get_post_meta( $post->ID,'_passport_language',true ) == $language->term_id ){
				    		echo '<option selected="selected" value="' . $language->term_id . '">' . $language->name . '</option>';
				    	}else{
				    		echo '<option value="' . $language->term_id . '">' . $language->name . '</option>';
				    	}
				    }
			    ?>
		    </select>

		    <!-- Remove comment to have the list of all fields
		    <select name="field" id="field"> <option value="Select" selected disabled hidden>Select</option>  -->
		    <?php
			    /*foreach ($parents as $parent) {
			        foreach ($parent as $language) {
			            echo '<option value="' . $language->term_id . '">';
			            echo $language->name . '</option>';
			        }
			    }*/
		    ?>
		    <!-- </select> -->

			<?php	
		} 
	}
}
add_action('init', 'metabox_student_portfolio_language');

/* Adds the metabox student portfolio language into the badge custom post type */
function metabox_student_name(){
	add_action('add_meta_boxes', function(){
		add_meta_box('id_student', 'Student', 'student_func', 'student_portfolio', 'side', 'high');
	});

	function student_func($post){
		$students = get_users( [ 'role__in' => [ 'student' ] ] ); ?>

		<select name="student" id="student">
			<option value="Select">Select</option>
		    <?php
		    foreach ( $students as $student ) {
		    	if( get_post_meta( $post->ID,'_student',true ) == $student->ID ){
		   			echo '<option selected="selected" value="' . $student->ID . '">' . $student->display_name . '</option>';
		   		}else{
		   			echo '<option value="' . $student->ID . '">' . $student->display_name . '</option>';
		   		}
		   	}
		    ?>
	    </select>

	    <?php
		
	}
}
add_action('init', 'metabox_student_name');

add_action('save_post', function($id){
	global $post;

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post->ID;
	}

	if(isset($_POST['result'])){
			update_post_meta($id, "result", $_POST['result']);
	}

	if(isset($_POST['student_portfolio'])){
		update_post_meta($post->ID, "student_portfolio", $_POST['student_portfolio']);
	}
	else
		update_post_meta($post->ID, "student_portfolio", array());

	if(isset($_POST['language'])){
		update_post_meta($post->ID, "_portfolio_language", $_POST['language']);
	}

	if(isset($_POST['student'])){
		update_post_meta($post->ID, "_student", $_POST['student']);
	}

});

///////////////////////////////////////////////
///////////////////////////////////////////////
add_action('admin_menu', 'sp_profiling_grid_add_settings');

function sp_profiling_grid_add_settings(){
	add_submenu_page(
		'edit.php?post_type=student_portfolio',
		'Create portfolio',
		'Settings',
		'manage_options',
		'create_portfolio',
		'create_profiling_grid_callback' );
}

?>

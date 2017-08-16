<?php

/*
 Plugin Name: Student Portfolio Plugin
 Description: Plugin for assigning the grades to students on the basis of their progress
 Version: 1.0
 Author: Muhammad Uzair
 Author URI: https://www.linkedin.com/in/uzair043/
*/

wp_enqueue_script("jquery");
wp_enqueue_script('jquery-ui');
wp_enqueue_script('jquery-ui-tabs');
wp_enqueue_style( 'wp-admin' );

require_once( 'create-portfolio.php');

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
		'name'                => 'Student Portfolio',
		'singular_name'       => 'Student Portfolio',
		'menu_name'           => 'Student Portfolio',
		'parent_item_colon'   => 'Parent Student Portfolio',
		'all_items'           => 'Student Portfolios',
		'view_item'           => 'View Student Portfolio',
		'add_new_item'        => 'Add New Student Portfolio',
		'edit_item'           => 'Edit Student Portfolio',
		'update_item'         => 'Update Student Portfolio',
		'search_items'        => 'Search Student Portfolios',
		'not_found'           => 'Not Found',
		'not_found_in_trash'  => 'Not found in Trash'
	);

// Set other options for Custom Post Type

	$args = array(
		'label'               => 'student_portfolio',
		'description'         => 'A custom post to assign language levels to students based on their proficiency.',
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor', ),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'portfolios',
		'show_in_nav_menus'   => true,
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
		add_meta_box('student', 'Student Portfolio', 'student_grades', 'student_portfolio');
	});

	function student_grades($post){
		$value = 'yes';
		$counter = 0;
		$counter_li = 1;
		$counter_re = 1;
		$counter_si = 1;
		$counter_sp = 1;
		$counter_wr = 1;

		$result = get_post_meta($post->ID, 'result', true);

		$t_portfolio = array(

			 "language" => array(

					"li" => array(

						11 => "I can recognise familiar words and very basic phrases concerning myself, my family and immediate concrete surroundings when people speak slowly and clearly.",
						21 => "I can understand phrases and the highest frequency vocabulary related to areas of most immediate personal relevance (e.g. very basic personal and family information, shopping, local area, employment).
						I can catch the main point in short, clear, simple messages and announcements. ",
						31 => "I can understand the main points of clear standard speech on familiar matters regularly encountered in work, school, leisure, etc.
						I can understand the main point of many radio or TV programmes on current affairs or topics of personal or professional interest when the delivery is relatively slow and clear. ",
						41 => "I can understand extended speech and lectures and follow even complex lines of argument provided the topic is reasonably familiar.
						I can understand most TV news and current affairs programmes. I can understand the majority of films in standard dialect. ",
						51 => "I can understand extended speech even when it is not clearly structured and when relationships are only implied and not signalled explicitly.
						I can understand television programmes and films without too much effort. ",
						61 => "I have no difficulty in understanding any kind of spoken language, whether live or broadcast, even when delivered at fast native speed, provided.
						I have some time to get familiar with the accent. "
					),
					"re" => array(
						11 => "I can understand familiar names, words and very simple sentences, for example on notices and posters or in catalogues.",
						21 => "I can read very short, simple texts.
						I can find specific, predictable information in simple everyday material such as advertisements, prospectuses, menus and timetables and I can understand short simple personal letters. ",
						31 => "I can understand texts that consist mainly of high frequency everyday or job-related language.
						I can understand the description of events, feelings and wishes in personal letters. ",
						41 => "I can read articles and reports concerned with contemporary problems in which the writers adopt particular attitudes or viewpoints.
						I can understand contemporary literary prose. ",
						51 => "I can understand long and complex factual and literary texts, appreciating distinctions of style.
						I can understand specialised articles and longer technical instructions, even when they do not relate to my field. ",
						61 => "I can read with ease virtually all forms of the written language, including abstract, structurally or linguistically complex texts such as manuals, specialised articles and literary works."
					),
					"si" => array(
						11 => "I can interact in a simple way provided the other person is prepared to repeat or rephrase things at a slower rate of speech and help me formulate what I'm trying to say.
						I can ask and answer simple questions in areas of immediate need or on very familiar topics. ",
						21 => "I can communicate in simple and routine tasks requiring a simple and direct exchange of information on familiar topics and activities.
						I can handle very short social exchanges, even though I can't usually understand enough to keep the conversation going myself. ",
						31 => "I can deal with most situations likely to arise whilst travelling in an area where the language is spoken.
						I can enter unprepared into conversation on topics that are familiar, of personal interest or pertinent to everyday life (e.g. family, hobbies, work, travel and current events). ",
						41 => "I can interact with a degree of fluency and spontaneity that makes regular interaction with native speakers quite possible.
						I can take an active part in discussion in familiar contexts, accounting for and sustaining my views. ",
						51 => "I can express myself fluently and spontaneously without much obvious searching for expressions.
						I can use language flexibly and effectively for social and professional purposes.
						I can formulate ideas and opinions with precision and relate my contribution skilfully to those of other speakers. ",
						61 => "I can take part effortlessly in any conversation or discussion and have a good familiarity with idiomatic expressions and colloquialisms.
						I can express myself fluently and convey finer shades of meaning precisely.
						If I do have a problem I can backtrack and restructure around the difficulty so smoothly that other people are hardly aware of it. "
					),
					"sp" => array(
						11 => "I can use simple phrases and sentences to describe where I live and people I know.",
						21 => "I can use a series of phrases and sentences to describe in simple terms my family and other people, living conditions, my educational background and my present or most recent job.",
						31 => "I can connect phrases in a simple way in order to describe experiences and events, my dreams, hopes and ambitions.
						I can briefly give reasons and explanations for opinions and plans.
						I can narrate a story or relate the plot of a book or film and describe my reactions. ",
						41 => "I can present clear, detailed descriptions on a wide range of subjects related to my field of interest.
						I can explain a viewpoint on a topical issue giving the advantages and disadvantages of various options. ",
						51 => "I can present clear, detailed descriptions of complex subjects integrating sub-themes, developing particular points and rounding off with an appropriate conclusion.",
						61 => "I can present a clear, smoothly-flowing description or argument in a style appropriate to the context and with an effective logical structure which helps the recipient to notice and remember significant points. "
					),
					"wr" => array(
						11 => "I can write a short, simple postcard, for example sending holiday greetings.
						I can fill in forms with personal details, for example entering my name, nationality and address on a hotel registration form. ",
						21 => "I can write short, simple notes and messages relating to matters in areas of immediate needs.
						I can write a very simple personal letter, for example thanking someone for something. ",
						31 => "I can write simple connected text on topics which are familiar or of personal interest.
						I can write personal letters describing experiences and impressions. ",
						41 => "I can write clear, detailed text on a wide range of subjects related to my interests.
						I can write an essay or report, passing on information or giving reasons in support of or against a particular point of view.
						I can write letters highlighting the personal significance of events and experiences. ",
						51 => "I can express myself in clear, well-structured text, expressing points of view at some length.
						I can write about complex subjects in a letter, an essay or a report, underlining what I consider to be the salient issues.
						I can select style appropriate to the reader in mind. ",
						61 => "I can write clear, smoothly-flowing text in an appropriate style.
						I can write complex letters, reports or articles which present a case with an effective logical structure which helps the recipient to notice and remember significant points.
						I can write summaries and reviews of professional or literary works."
					),
				)

			);

		?>


		<p>
		"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
		Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
		Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
		Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>

	</br></br>
	<div id="result_content" style="float:right;">
		<center><h1>Current Result</h1></center>
		<div id="result"></div>
	</div>
	</br>

			<!--</br></br><p id="result">Result</p></br>value="<?php echo $result ?>-->

			<?php include(plugin_dir_path( dirname( __FILE__ ) ) . 'utils/js_student_portfolio.php'); ?>
			<?php include(plugin_dir_path( dirname( __FILE__ ) ) . 'utils/js_send_badge.php'); ?>
			<?php include(plugin_dir_path( dirname( __FILE__ ) ) . 'utils/style.php'); ?>

			<script>
        jQuery(document).ready(function(jQuery) {
          jQuery('#tabs').tabs();
          jQuery(".nav-tab").click(function(){
            jQuery(".nav-tab").removeClass("nav-tab-active");
            jQuery(this).addClass("nav-tab-active");
          });
        });
      </script>

			<div id="tabs">
        <div id="tabs-elements">
					<h2 class="nav-tab-wrapper">
	          <ul>
	            <li><a href="#tabs-1"><div class="nav-tab nav-tab-active"><?php _e( 'Listening','b4l-portofolio' ); ?></div></a></li>
	            <li><a href="#tabs-2"><div class="nav-tab"><?php _e( 'Reading','b4l-portofolio' ); ?></div></a></li>
	            <li><a href="#tabs-3"><div class="nav-tab"><?php _e( 'Spoken Interaction','b4l-portofolio' ); ?></div></a></li>
							<li><a href="#tabs-4"><div class="nav-tab"><?php _e( 'Spoken Production','b4l-portofolio' ); ?></div></a></li>
							<li><a href="#tabs-5"><div class="nav-tab"><?php _e( 'Writing','b4l-portofolio' ); ?></div></a></li>
	          </ul>
					</h2>
        </div>
				<div id="tabs-1">
						<?php
							for($i = 0 ; $i < count($t_portfolio["language"]["li"]); $i++){
								echo '<br>'.  '<input type="checkbox" name="student_portfolio[]" id="li'.$counter_li.'" value="'.$value.$counter.'" style="margin-left: 30px;" ' . check_student($value.$counter) . '>' .  $t_portfolio["language"]["li"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_li++;
							}
						?>
				</div>
				<div id="tabs-2">
							<?php
							for($i = 0 ; $i < count($t_portfolio["language"]["re"]); $i++){
								echo '<br>'.  '<input type="checkbox" name="student_portfolio[]" id="re'.$counter_re.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_student($value.$counter) . '>' .  $t_portfolio["language"]["re"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_re++;
							}
						?>
				</div>
				<div id="tabs-3">
						<?php
							for($i = 0 ; $i < count($t_portfolio["language"]["si"]); $i++){
								echo '<br>'.  '<input type="checkbox" name="student_portfolio[]" id="si'.$counter_si.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_student($value.$counter) . '>' .  $t_portfolio["language"]["si"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_si++;
							}
						?>

				</div>
				<div id="tabs-4">
						<?php
							for($i = 0 ; $i < count($t_portfolio["language"]["sp"]); $i++){
								echo '<br>'.  '<input type="checkbox" name="student_portfolio[]" id="sp'.$counter_sp.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_student($value.$counter) . '> ' .  $t_portfolio["language"]["sp"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_sp++;
							}
						?>
				</div>
				<div id="tabs-5">
						<?php
							for($i = 0 ; $i < count($t_portfolio["language"]["wr"]); $i++){
								echo '<br>'.  '<input type="checkbox" name="student_portfolio[]" id="wr'.$counter_wr.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_student($value.$counter) . '> ' .  $t_portfolio["language"]["wr"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_wr++;
							}
						?>
				</div>
			</div>
		<br />
		<?php
	}
}

add_action('init', 'metabox_student');

/* Adds the metabox student portfolio language into the badge custom post type */

add_action('add_meta_boxes','add_meta_box_student_portfolio_language');

function add_meta_box_student_portfolio_language(){
	add_meta_box('id_meta_box_student_portfolio_language', 'Student portfolio language', 'meta_box_student_portfolio_language', 'student_portfolio', 'side', 'high');
}

function meta_box_student_portfolio_language($post){
	if(is_plugin_active("badges-issuer-for-wp/badges-issuer-for-wp.php")) {
		$val = "";
		if(get_post_meta($post->ID,'_portofolio_language',true))
		  $val = get_post_meta($post->ID,'_portofolio_language',true);

		display_languages_select_form(true, $val);
	}
}

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

	if(isset($_POST['language']))
		update_post_meta($post->ID, "_portofolio_language", $_POST['language']);

});

///////////////////////////////////////////////
///////////////////////////////////////////////
add_action('admin_menu', 'sp_add_settings');

function sp_add_settings(){
	add_submenu_page(
		'edit.php?post_type=student_portfolio',
		'Create Portfolio',
		'Settings',
		'manage_options',
		'create_portfolio',
		'create_student_portfolio_callback' );
}

?>

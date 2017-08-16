<?php

/*
 Plugin Name: Teacher Portfolio Plugin
 Description: Plugin for assigning the grades to teachers on the basis of their progress
 Version: 1.0
 Author: Muhammad Uzair
 Author URI: https://www.linkedin.com/in/uzair043/
*/


wp_enqueue_script("jquery");
wp_enqueue_script('jquery-ui');
wp_enqueue_script('jquery-ui-tabs');
wp_enqueue_style( 'wp-admin' );

require_once( 'create-portfolio.php');

function check_teacher($val) {
	global $post;

	if(is_array(get_post_meta($post->ID, "teacher_portfolio", true)))
		$checkbox_values = get_post_meta($post->ID, "teacher_portfolio", true);
	else
		$checkbox_values = array();

		if(in_array($val, $checkbox_values))
		return " checked";
}

function custom_post_teacher_portfolio() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => 'Teacher Portfolio', 'Post Type General Name',
		'singular_name'       => 'Teacher Portfolio', 'Post Type Singular Name',
		'menu_name'           => 'Teacher Portfolio',
		'parent_item_colon'   => 'Parent Teacher Portfolio',
		'all_items'           => 'Teacher Portfolios',
		'view_item'           => 'View Teacher Portfolio',
		'add_new_item'        => 'Add New Teacher Portfolio',
		'edit_item'           => 'Edit Teacher Portfolio',
		'update_item'         => 'Update Teacher Portfolio',
		'search_items'        => 'Search Teacher Portfolios',
		'not_found'           => 'Not Found',
		'not_found_in_trash'  => 'Not found in Trash'
	);

// Set other options for Custom Post Type

	$args = array(
		'label'               => 'teacher_portfolio',
		'description'         => 'A custom post to assign language levels to teacher based on their proficiency.',
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
			'edit_post' => 'edit_teacher_portfolio',
			'edit_posts' => 'edit_teacher_portfolios',
			'edit_others_posts' => 'edit_other_teacher_portfolios',
			'edit_published_posts' => 'edit_published_teacher_portfolios',
			'publish_posts' => 'publish_teacher_portfolios',
			'read_post' => 'read_teacher_portfolio',
			'read_posts' => 'read_teacher_portfolios',
			'read_private_posts' => 'read_private_teacher_portfolios',
			'delete_post' => 'delete_teacher_portfolio'
		)

		//s'taxonomies'          => array( 'category' ),
	);

	// Registering your Custom Post Type
	register_post_type( 'teacher_portfolio', $args );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/

add_action( 'init', 'custom_post_teacher_portfolio', 0 );



function metabox_teacher()
{
	add_action('add_meta_boxes', function(){
		add_meta_box('teacher', 'Teacher Portfolio', 'teacher_grades', 'teacher_portfolio');
	});

	function teacher_grades($post){
		$value = 'yes';
		$counter = 0;
		$counter_lp = 1;
		$counter_la = 1;
		$counter_ltq = 1;
		$counter_ltp = 1;
		$counter_te = 1;
		$counter_mks = 1;
		$counter_lcp = 1;
		$counter_imm = 1;
		$counter_ast = 1;
		$counter_td = 1;
		$counter_dm = 1;
		$t_portfolio = array(

			 "language" => array(

					"lp" => array(

						11 => "Studying the language at tertiary level. B1 proficiency.",
						21 => "Studying the language at tertiary level. B2 proficiency.",
						31 => "A B2 certificate in the language; oral competence at C1 level.",
						41 => "A C1 examination certificate (eg CAE); oral competence at C2 level.",
						51 => "Degree in the language, or: A C2 examination certificate (eg CPE).",
						61 => "Native speaker, or: Language degree or C2 certificate plus a natural command of the language."
					),
					"la" => array(
						11 => "Answer simple queries with the help of reference works.",
						21 => "Answer queries related to high frequency structures.",
						31 => "Give correct models of usage on most occasions. Answer most language queries satisfactorily at A1-B1, using reference sources as necessary.",
						41 => "Give correct models of usage on most occasions. Answer language queries adequately though not always comprehensively, using reference sources as necessary.",
						51 => "Give correct examples of usage on all occasions. Answer language queries reliably.",
						61 => "Provide clear explanations. Teach usage and register at all levels. Understand what is confusing learners. Give comprehensive, accurate answers to queries."
					)
				),
			  "qualifications" => array(
					"ltq" => array(
						11 => "Taking a certificate in teaching the target language. or: Following an internal training course.",
						21 => " A minimum of 30 hours documented, structured training in language awareness and methodology of teaching the target language.",
						31 => "A minimum of 60 hours of documented, structured training in teaching the target language.",
						41 => " Degree in the target language, or: Internationally recognised (min. 100 hour) certificate in teaching the target language.",
						51 => "Degree or degree module in teaching the target language, or: Internationally recognised (min. 100 hour) certificate in teaching the target language.",
						61 => " Masters degree or module in language teaching or applied linguistics, or: Postgraduate or professional diploma in teaching the language (min. 200 hours)"
					),
					"ltp" => array(
						11 => "Experience of team teaching, or: Of acting as a teacher’s assistant.",
						21 => "Experience of supervision and assessment while teaching phases of lessons.",
						31 => "A minimum of 2 hours of documented, assessed teaching practice. Has been observed & had feedback on some actual teaching.",
						41 => " A minimum of 6 hours of documented, assessed teaching practice. Has been observed & had feedback on at least 5 hrs of real teaching.",
						51 => " A minimum of 12 hours of documented, assessed teaching practice. Has been observed & had feedback on at least 8 hours of teaching.",
						61 => "A minimum of 18 hours of documented, assessed teaching practice. Has been observed & had feedback on at least 12 hours of teaching."
					),
					"te" => array(
						11 => " Taught some lessons, or: Parts of lessons at one or two levels.",
						21 => "Own class(es) but limited experience which only includes teaching at lower levels.",
						31 => " A minimum of 200 hours, documented teaching experience. Taught a range of levels up to B1.",
						41 => " A minimum of 800 hours, documented teaching experience. Taught all levels except C1 & C2.",
						51 => "A minimum of 2,400 hours, documented teaching experience. Taught all levels except C2, examination or specialised classes.",
						61 => "A minimum of 4,000 hours, documented teaching experience. Taught all levels successfully, general, exam and specialised."
					)
				),
			"core_competencies" => array(
					"mks" => array(
						11 => "Sensitisation to learning theories and features of language. Familiarity with a limited range of techniques and materials for one or two levels.",
						21 => "Basic understanding of learning theories and features of language. Familiarity with techniques and materials for 2+ levels. Select new techniques & materials with <spanadvice from colleagues.",
						31 => "Familiarity with theories of language learning and with learning styles. Familiarity with an expanding range of techniques and materials. Choose which to apply based on the needs of a particular group. Evaluate usefulness of techniques and materials in teaching context.",
						41 => "Familiarity with learning theory, learning styles and learning strategies. Identify the theoretical rationale behind a wide range of techniques and materials, with which familiar. Evaluate appropriateness of techniques and materials in different teaching situations.",
						51 => "Good familiarity with teaching approaches, learning styles, strategies. Provide theoretical rationale for teaching approach and for a very wide range of techniques / materials. Evaluate materials effectively from practical and theoretical perspectives.",
						61 => "Detailed knowledge of theories of language and learning. Select an optimum combination of techniques to suit each type of learner and learning situation & provide clear theoretical rationale for decisions."
					),
					"lcp" => array(
						11 => "Work with lesson plans in teachers’ notes to published materials.",
						21 => "Use published or in-house materials to develop plans for different types of lessons. Plan phases and timing of various lesson types.",
						31 => " Use a syllabus and specified materials to prepare lesson plans that are well-balanced and meet the needs of the group;. Adjust these plans as required. Take account of lesson outcomes in planning next lesson.",
						41 => " Analyse individual learners’ needs in detail, including learning-to-learn. Plan clear main and supplementary objectives for lessons. Provide a rationale for lesson stages. Select/design supplementary activities. Ensure lesson-to-lesson coherence.",
						51 => "Plan a balanced, varied scheme of work for a module based on detailed needs analysis. Design tasks to exploit linguistic and communicative potential of materials. Design multi-level tasks to meet individual needs and lesson objectives.",
						61 => " Plan an entire course with recycling and revision. Create or select appropriate activities for balanced learning modules with communicative and linguistic content. Design multi-level tasks to meet individual needs and lesson objectives."

					),
					"imm" => array(

						11 => " Alternate between whole class teaching and pair practice following suggestions in a teachers’ guide.",
						21 => " Manage teacher-class interaction effectively. Give clear instructions for pair and group work. Monitor the resulting activity. Give clear feedback.",
						31 => " Set up pairs and groups efficiently. Ensure all learners are involved in productive pair and group work. Monitor performance at all times. Bring the class back together and manage feedback.",
						41 => "Set up a varied and balanced sequence of class, group and pair work appropriate to the lesson objectives. Monitor individual and group work effectively providing or eliciting appropriate feedback.",
						51 => "Set up group interaction focused on multiple learning objectives. Monitor individual and group performances accurately and thoroughly. Give various forms of relevant individual feedback.",
						61 => "Facilitate task-based learning. Manage learner-centred, multi-level group work. Derive appropriate action points from monitoring and analysis of the interaction."
					),
					"ast" => array(

						11 => " Supervise and mark class quizzes and progress tests.",
						21 => " Supervise and mark tests. Write a class quiz or revision activity to revise recent work.",
						31 => "Select suitable progress tests and set up and supervise them. Use the results and simple oral and written tasks to assess learners’ progress and things to work on. Use a homework marking code to increase language awareness.",
						41 => " Conduct tests and interviews if given material to do so. Train learners to code their errors to increase language awareness. Design or select appropriate quizzes, revision activities, and progress tests. CEFR standardisation experience.",
						51 => " Coordinate placement testing and progress assessment (oral & written). Use video & hw codes to help learners recognise strengths / weaknesses. Use CEFR criteria reliably to assess spoken and written proficiency.",
						61 => "Write progress tests. Develop assessment tasks. Run CEFR standardisation sessions. Use video & hw codes to help learners recognise strengths / weaknesses. Use CEFR criteria reliably to assess spoken and written proficiency."
					)

				),
			"complementary_skills" => array(
					"td" => array(

						11 => "Take part in training sessions. Cooperate with colleagues with set tasks. Regularly observe real teaching.",
						21 => " Take an active part in group work during training. Liaise well with other teachers. Observe & team-teach with teachers at restricted levels. Act on observation feedback.",
						31 => " Take an active part in various kindsof in-service training/development. Actively seek advice from colleagues and relevant books. Observe colleagues at various levels. Act on colleagues’ feedback on serial observations of own teaching.",
						41 => " Develop awareness and competence through professional reading. Lead discussions sometimes and exchange ideas about materials and techniques. Seek opportunities to be observed and receive feedback on own teaching.",
						51 => "Act as mentor to less experienced colleagues. Lead a training session or even series of sessions given materials to use and distance support from a colleague. Seek opportunities for peerobservation.",
						61 => "Create a series of training modules for less experienced teachers. Run a teacher CPD programme Take part in institutional or (inter) national projects. Observe colleagues and provide effective feedback."
					),
					"dm" => array(

						11 => " Write a worksheet following conventions. Follow menus to operate software. Download from resource sites.",
						21 => "Search effectively for material on the internet. Select and download from resource sites. Organize materials in hierarchically structured folders.",
						31 => "Use data projectors for class lessons with internet, DVD etc. Use software for handling images, DVDs, sound files. Use a camcorder to record tasks. Set a class an exercise with CALL materials.",
						41 => "Create lessons with downloaded texts, pictures, graphics, etc. Devise tasks using internet-based media such as wikis, blogs, webquests. Set & supervise individual CALL work. Coordinate project work with media (camcorder, internet downloads etc).",
						51=> "Use PowerPoint for presentations, including animation. Train students to select and use CALL exercises effectively. Use authoring program to create CALL. Troubleshoot with basic equipment (e.g. data projector, printer).",
						61 => " Show colleagues how to use new soft/hardware, incl. authoring programs. Design blended learning modules. Use any standard Windows software, including media, video editing. Troubleshoot hardware."
					)
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

			<!--</br></br><p id="result">Result</p></br>-->

			<?php include(plugin_dir_path( dirname( __FILE__ ) ) . 'utils/js_teacher_portfolio.php'); ?>
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
	            <li><a href="#tabs-1"><div class="nav-tab nav-tab-active"><?php _e( 'Language','b4l-portofolio' ); ?></div></a></li>
	            <li><a href="#tabs-2"><div class="nav-tab"><?php _e( 'Qualifications','b4l-portofolio' ); ?></div></a></li>
	            <li><a href="#tabs-3"><div class="nav-tab"><?php _e( 'Core Competencies','b4l-portofolio' ); ?></div></a></li>
							<li><a href="#tabs-4"><div class="nav-tab"><?php _e( 'Complementary Skills','b4l-portofolio' ); ?></div></a></li>
	          </ul>
					</h2>
        </div>
				<div id="tabs-1">
					<br />
					<b>&#9679;Language Proficiency</b></br>
						<?php
							for($i = 0 ; $i < count($t_portfolio["language"]["lp"]); $i++){
								echo '<br>' . '<input type="checkbox" name="teacher_portfolio[]" id="lp'.$counter_lp.'" value="'.$value.$counter.'" style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["language"]["lp"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_lp++;
							}
						?>

					<br><b>&#9679;Language Awareness</b><br>
						<?php
							for($i = 0 ; $i < count($t_portfolio["language"]["la"]); $i++){
								echo '<br>'. '<input type="checkbox" name="teacher_portfolio[]" id="la'.$counter_la.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["language"]["la"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_la++;
							}
						?>

				</div>
				<div id="tabs-2">
					<br />
						<b>&#9679;Language Teacher Qualifications</b></br>
							<?php
							for($i = 0 ; $i < count($t_portfolio["qualifications"]["ltq"]); $i++){
								echo '<br>'. '<input type="checkbox" name="teacher_portfolio[]" id="ltq'.$counter_ltq.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["qualifications"]["ltq"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_ltq++;
							}
						?>

					<br><b>&#9679;Language Teaching Practice</b><br>
						<?php
							for($i = 0 ; $i < count($t_portfolio["qualifications"]["ltp"]); $i++){
								echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="ltp'.$counter_ltp.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["qualifications"]["ltp"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_ltp++;
							}
						?>

					<br><b>&#9679;Teaching Experience</b><br>
						<?php
							for($i = 0 ; $i < count($t_portfolio["qualifications"]["te"]); $i++){
								echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="te'.$counter_te.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["qualifications"]["te"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_te++;
							}
						?>
				</div>
				<div id="tabs-3">
					<br />
					<b>&#9679;Methodology: knowledge and skills</b></br>
						<?php
							for($i = 0 ; $i < count($t_portfolio["core_competencies"]["mks"]); $i++){
								echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="mks'.$counter_mks.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["core_competencies"]["mks"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_mks++;
							}
						?>
					<br><b>&#9679;Lesson and Course Planning</b><br>
						<?php
							for($i = 0 ; $i < count($t_portfolio["core_competencies"]["lcp"]); $i++){
								echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="lcp'.$counter_lcp.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["core_competencies"]["lcp"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_lcp++;
							}
						?>

					<br><b>&#9679;Interaction Management and Monitoring</b><br>
						<?php
							for($i = 0 ; $i < count($t_portfolio["core_competencies"]["imm"]); $i++){
								echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="imm'.$counter_imm.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["core_competencies"]["imm"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_imm++;
							}
						?>

					<br><b>&#9679;Assessment</b><br>
						<?php
							for($i = 0 ; $i < count($t_portfolio["core_competencies"]["ast"]); $i++){
								echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="ast'.$counter_ast.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["core_competencies"]["ast"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_ast++;
							}
						?>
				</div>
				<div id="tabs-4">
					<br />
					<b>&#9679;Teacher Development</b></br>
						<?php
							for($i = 0 ; $i < count($t_portfolio["complementary_skills"]["td"]); $i++){
								echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="td'.$counter_td.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '> ' .  $t_portfolio["complementary_skills"]["td"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_td++;
							}
						?>
					<br><b>&#9679;Digital Media</b><br>
						<?php
							for($i = 0 ; $i < count($t_portfolio["complementary_skills"]["dm"]); $i++){
								echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="dm'.$counter_dm.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["complementary_skills"]["dm"][$i+1 . 1]. '</br>';
								$counter++;
								$counter_dm++;
							}
						?>
				</div>
			</div>
		<br />
		<?php
	}
}
add_action('init', 'metabox_teacher');

/* Adds the metabox teacher portfolio language into the badge custom post type */

add_action('add_meta_boxes','add_meta_box_teacher_portfolio_language');

function add_meta_box_teacher_portfolio_language(){
	add_meta_box('id_meta_box_teacher_portfolio_language', 'Teacher portfolio language', 'meta_box_teacher_portfolio_language', 'teacher_portfolio', 'side', 'high');
}

function meta_box_teacher_portfolio_language($post){
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

	if(isset($_POST['teacher_portfolio']))
			update_post_meta($post->ID, "teacher_portfolio", $_POST['teacher_portfolio']);
	else
		update_post_meta($post->ID, "teacher_portfolio", array());

	if(isset($_POST['language']))
		update_post_meta($post->ID, "_portofolio_language", $_POST['language']);

});

///////////////////////////////////////////////
///////////////////////////////////////////////
add_action('admin_menu', 'tp_add_settings');

function tp_add_settings(){
	add_submenu_page(
		'edit.php?post_type=teacher_portfolio',
		'Teacher Portfolio Settings',
		'Settings',
		'manage_options',
		'create_portfolio',
		'create_portfolio_callback' );
}

?>

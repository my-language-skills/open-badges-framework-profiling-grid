<?php

/*
 Plugin Name: Teacher Profiling Grid Plugin
 Description: Plugin for assigning the grades to teachers on the basis of their progress
 Version: 1.0
 Author: Muhammad Uzair
 Author URI: https://www.linkedin.com/in/uzair043/
*/


wp_enqueue_script("jquery");
wp_enqueue_script('jquery-ui');
wp_enqueue_script('jquery-ui-tabs');
wp_enqueue_style( 'wp-admin' );

require_once( 'create-profiling_grid.php');

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
		'name'                => __('Teacher Profiling Grid','b4l-profiling-grid-for-teachers'),
		'singular_name'       => __('Teacher Profiling Grid','b4l-profiling-grid-for-teachers'),
		'menu_name'           => __('Teacher Profiling Grid','b4l-profiling-grid-for-teachers'),
		'parent_item_colon'   => __('Parent Teacher Profiling Grid','b4l-profiling-grid-for-teachers'),
		'all_items'           => __('Teacher Profiling Grids','b4l-profiling-grid-for-teachers'),
		'view_item'           => __('View Teacher Profiling Grid','b4l-profiling-grid-for-teachers'),
		'add_new_item'        => __('Add New Teacher Profiling Grid','b4l-profiling-grid-for-teachers'),
		'edit_item'           => __('Edit Teacher Profiling Grid','b4l-profiling-grid-for-teachers'),
		'update_item'         => __('Update Teacher Profiling Grid','b4l-profiling-grid-for-teachers'),
		'search_items'        => __('Search Teacher Profiling Grids','b4l-profiling-grid-for-teachers'),
		'not_found'           => __('Not Found','b4l-profiling-grid-for-teachers'),
		'not_found_in_trash'  => __('Not found in Trash','b4l-profiling-grid-for-teachers')
	);

// Set other options for Custom Post Type

	$args = array(
		'label'               => 'teacher_portfolio',
		'description'         => __('A custom post to assign language levels to teacher based on their proficiency.','b4l-profiling-grid-for-teachers'),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor' ),
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
	);

	// Registering your Custom Post Type
	register_post_type( 'teacher_portfolio', $args );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/

add_action( 'init', 'custom_post_teacher_portfolio');



function metabox_teacher()
{
	add_action('add_meta_boxes', function(){
		add_meta_box('teacher', __('Teacher portfolio','b4l-profiling-grid-for-teachers'), 'teacher_grades', 'teacher_portfolio');
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

						11 => __("Studying the language at tertiary level. B1 proficiency.",'b4l-profiling-grid-for-teachers'),
						21 => __("Studying the language at tertiary level. B2 proficiency.",'b4l-profiling-grid-for-teachers'),
						31 => __("A B2 certificate in the language; oral competence at C1 level.",'b4l-profiling-grid-for-teachers'),
						41 => __("A C1 examination certificate (eg CAE); oral competence at C2 level.",'b4l-profiling-grid-for-teachers'),
						51 => __("Degree in the language, or: A C2 examination certificate (eg CPE).",'b4l-profiling-grid-for-teachers'),
						61 => __("Native speaker, or: Language degree or C2 certificate plus a natural command of the language.",'b4l-profiling-grid-for-teachers')
					),
					"la" => array(
						11 => __("Answer simple queries with the help of reference works.",'b4l-profiling-grid-for-teachers'),
						21 => __("Answer queries related to high frequency structures.",'b4l-profiling-grid-for-teachers'),
						31 => __("Give correct models of usage on most occasions. Answer most language queries satisfactorily at A1-B1, using reference sources as necessary.",'b4l-profiling-grid-for-teachers'),
						41 => __("Give correct models of usage on most occasions. Answer language queries adequately though not always comprehensively, using reference sources as necessary.",'b4l-profiling-grid-for-teachers'),
						51 => __("Give correct examples of usage on all occasions. Answer language queries reliably.",'b4l-profiling-grid-for-teachers'),
						61 => __("Provide clear explanations. Teach usage and register at all levels. Understand what is confusing learners. Give comprehensive, accurate answers to queries.",'b4l-profiling-grid-for-teachers')
					)
				),
			  "qualifications" => array(
					"ltq" => array(
						11 => __("Taking a certificate in teaching the target language. or: Following an internal training course.",'b4l-profiling-grid-for-teachers'),
						21 => __(" A minimum of 30 hours documented, structured training in language awareness and methodology of teaching the target language.",'b4l-profiling-grid-for-teachers'),
						31 => __("A minimum of 60 hours of documented, structured training in teaching the target language.",'b4l-profiling-grid-for-teachers'),
						41 => __(" Degree in the target language, or: Internationally recognised (min. 100 hour) certificate in teaching the target language.",'b4l-profiling-grid-for-teachers'),
						51 => __("Degree or degree module in teaching the target language, or: Internationally recognised (min. 100 hour) certificate in teaching the target language.",'b4l-profiling-grid-for-teachers'),
						61 => __(" Masters degree or module in language teaching or applied linguistics, or: Postgraduate or professional diploma in teaching the language (min. 200 hours)",'b4l-profiling-grid-for-teachers')
					),
					"ltp" => array(
						11 => __("Experience of team teaching, or: Of acting as a teacher’s assistant.",'b4l-profiling-grid-for-teachers'),
						21 => __("Experience of supervision and assessment while teaching phases of lessons.",'b4l-profiling-grid-for-teachers'),
						31 => __("A minimum of 2 hours of documented, assessed teaching practice. Has been observed & had feedback on some actual teaching.",'b4l-profiling-grid-for-teachers'),
						41 => __(" A minimum of 6 hours of documented, assessed teaching practice. Has been observed & had feedback on at least 5 hrs of real teaching.",'b4l-profiling-grid-for-teachers'),
						51 => __(" A minimum of 12 hours of documented, assessed teaching practice. Has been observed & had feedback on at least 8 hours of teaching.",'b4l-profiling-grid-for-teachers'),
						61 => __("A minimum of 18 hours of documented, assessed teaching practice. Has been observed & had feedback on at least 12 hours of teaching.",'b4l-profiling-grid-for-teachers')
					),
					"te" => array(
						11 => __(" Taught some lessons, or: Parts of lessons at one or two levels.",'b4l-profiling-grid-for-teachers'),
						21 => __("Own class(es) but limited experience which only includes teaching at lower levels.",'b4l-profiling-grid-for-teachers'),
						31 => __(" A minimum of 200 hours, documented teaching experience. Taught a range of levels up to B1.",'b4l-profiling-grid-for-teachers'),
						41 => __(" A minimum of 800 hours, documented teaching experience. Taught all levels except C1 & C2.",'b4l-profiling-grid-for-teachers'),
						51 => __("A minimum of 2,400 hours, documented teaching experience. Taught all levels except C2, examination or specialised classes.",'b4l-profiling-grid-for-teachers'),
						61 => __("A minimum of 4,000 hours, documented teaching experience. Taught all levels successfully, general, exam and specialised.",'b4l-profiling-grid-for-teachers')
					)
				),
			"core_competencies" => array(
					"mks" => array(
						11 => __("Sensitisation to learning theories and features of language. Familiarity with a limited range of techniques and materials for one or two levels.",'b4l-profiling-grid-for-teachers'),
						21 => __("Basic understanding of learning theories and features of language. Familiarity with techniques and materials for 2+ levels. Select new techniques & materials with advice from colleagues.",'b4l-profiling-grid-for-teachers'),
						31 => __("Familiarity with theories of language learning and with learning styles. Familiarity with an expanding range of techniques and materials. Choose which to apply based on the needs of a particular group. Evaluate usefulness of techniques and materials in teaching context.",'b4l-profiling-grid-for-teachers'),
						41 => __("Familiarity with learning theory, learning styles and learning strategies. Identify the theoretical rationale behind a wide range of techniques and materials, with which familiar. Evaluate appropriateness of techniques and materials in different teaching situations.",'b4l-profiling-grid-for-teachers'),
						51 => __("Good familiarity with teaching approaches, learning styles, strategies. Provide theoretical rationale for teaching approach and for a very wide range of techniques / materials. Evaluate materials effectively from practical and theoretical perspectives.",'b4l-profiling-grid-for-teachers'),
						61 => __("Detailed knowledge of theories of language and learning. Select an optimum combination of techniques to suit each type of learner and learning situation & provide clear theoretical rationale for decisions.",'b4l-profiling-grid-for-teachers')
					),
					"lcp" => array(
						11 => __("Work with lesson plans in teachers’ notes to published materials.",'b4l-profiling-grid-for-teachers'),
						21 => __("Use published or in-house materials to develop plans for different types of lessons. Plan phases and timing of various lesson types.",'b4l-profiling-grid-for-teachers'),
						31 => __("Use a syllabus and specified materials to prepare lesson plans that are well-balanced and meet the needs of the group;. Adjust these plans as required. Take account of lesson outcomes in planning next lesson.",'b4l-profiling-grid-for-teachers'),
						41 => __("Analyse individual learners’ needs in detail, including learning-to-learn. Plan clear main and supplementary objectives for lessons. Provide a rationale for lesson stages. Select/design supplementary activities. Ensure lesson-to-lesson coherence.",'b4l-profiling-grid-for-teachers'),
						51 => __("Plan a balanced, varied scheme of work for a module based on detailed needs analysis. Design tasks to exploit linguistic and communicative potential of materials. Design multi-level tasks to meet individual needs and lesson objectives.",'b4l-profiling-grid-for-teachers'),
						61 => __("Plan an entire course with recycling and revision. Create or select appropriate activities for balanced learning modules with communicative and linguistic content. Design multi-level tasks to meet individual needs and lesson objectives.",'b4l-profiling-grid-for-teachers')

					),
					"imm" => array(

						11 => __("Alternate between whole class teaching and pair practice following suggestions in a teachers’ guide.",'b4l-profiling-grid-for-teachers'),
						21 => __("Manage teacher-class interaction effectively. Give clear instructions for pair and group work. Monitor the resulting activity. Give clear feedback.",'b4l-profiling-grid-for-teachers'),
						31 => __("Set up pairs and groups efficiently. Ensure all learners are involved in productive pair and group work. Monitor performance at all times. Bring the class back together and manage feedback.",'b4l-profiling-grid-for-teachers'),
						41 => __("Set up a varied and balanced sequence of class, group and pair work appropriate to the lesson objectives. Monitor individual and group work effectively providing or eliciting appropriate feedback.",'b4l-profiling-grid-for-teachers'),
						51 => __("Set up group interaction focused on multiple learning objectives. Monitor individual and group performances accurately and thoroughly. Give various forms of relevant individual feedback.",'b4l-profiling-grid-for-teachers'),
						61 => __("Facilitate task-based learning. Manage learner-centred, multi-level group work. Derive appropriate action points from monitoring and analysis of the interaction.",'b4l-profiling-grid-for-teachers')
					),
					"ast" => array(

						11 => __("Supervise and mark class quizzes and progress tests.",'b4l-profiling-grid-for-teachers'),
						21 => __("Supervise and mark tests. Write a class quiz or revision activity to revise recent work.",'b4l-profiling-grid-for-teachers'),
						31 => __("Select suitable progress tests and set up and supervise them. Use the results and simple oral and written tasks to assess learners’ progress and things to work on. Use a homework marking code to increase language awareness.",'b4l-profiling-grid-for-teachers'),
						41 => __("Conduct tests and interviews if given material to do so. Train learners to code their errors to increase language awareness. Design or select appropriate quizzes, revision activities, and progress tests. CEFR standardisation experience.",'b4l-profiling-grid-for-teachers'),
						51 => __("Coordinate placement testing and progress assessment (oral & written). Use video & hw codes to help learners recognise strengths / weaknesses. Use CEFR criteria reliably to assess spoken and written proficiency.",'b4l-profiling-grid-for-teachers'),
						61 => __("Write progress tests. Develop assessment tasks. Run CEFR standardisation sessions. Use video & hw codes to help learners recognise strengths / weaknesses. Use CEFR criteria reliably to assess spoken and written proficiency.",'b4l-profiling-grid-for-teachers')
					)

				),
			"complementary_skills" => array(
					"td" => array(

						11 => __("Take part in training sessions. Cooperate with colleagues with set tasks. Regularly observe real teaching.",'b4l-profiling-grid-for-teachers'),
						21 => __("Take an active part in group work during training. Liaise well with other teachers. Observe & team-teach with teachers at restricted levels. Act on observation feedback.",'b4l-profiling-grid-for-teachers'),
						31 => __("Take an active part in various kindsof in-service training/development. Actively seek advice from colleagues and relevant books. Observe colleagues at various levels. Act on colleagues’ feedback on serial observations of own teaching.",'b4l-profiling-grid-for-teachers'),
						41 => __("Develop awareness and competence through professional reading. Lead discussions sometimes and exchange ideas about materials and techniques. Seek opportunities to be observed and receive feedback on own teaching.",'b4l-profiling-grid-for-teachers'),
						51 => __("Act as mentor to less experienced colleagues. Lead a training session or even series of sessions given materials to use and distance support from a colleague. Seek opportunities for peerobservation.",'b4l-profiling-grid-for-teachers'),
						61 => __("Create a series of training modules for less experienced teachers. Run a teacher CPD programme Take part in institutional or (inter) national projects. Observe colleagues and provide effective feedback.",'b4l-profiling-grid-for-teachers')
					),
					"dm" => array(

						11 => __("Write a worksheet following conventions. Follow menus to operate software. Download from resource sites.",'b4l-profiling-grid-for-teachers'),
						21 => __("Search effectively for material on the internet. Select and download from resource sites. Organize materials in hierarchically structured folders.",'b4l-profiling-grid-for-teachers'),
						31 => __("Use data projectors for class lessons with internet, DVD etc. Use software for handling images, DVDs, sound files. Use a camcorder to record tasks. Set a class an exercise with CALL materials.",'b4l-profiling-grid-for-teachers'),
						41 => __("Create lessons with downloaded texts, pictures, graphics, etc. Devise tasks using internet-based media such as wikis, blogs, webquests. Set & supervise individual CALL work. Coordinate project work with media (camcorder, internet downloads etc).",'b4l-profiling-grid-for-teachers'),
						51=> __("Use PowerPoint for presentations, including animation. Train students to select and use CALL exercises effectively. Use authoring program to create CALL. Troubleshoot with basic equipment (e.g. data projector, printer).",'b4l-profiling-grid-for-teachers'),
						61 => __("Show colleagues how to use new soft/hardware, incl. authoring programs. Design blended learning modules. Use any standard Windows software, including media, video editing. Troubleshoot hardware.",'b4l-profiling-grid-for-teachers')
					)
				)
			);

		?>


		<p>
			<?php
			_e("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
			Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
			Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",'b4l-profiling-grid-for-teachers');
			?>
		</p>

		<!-- Level aquired for each section -->
		<div id="result_content">
			<center><h1><?php _e('Current Result','b4l-profiling-grid-for-teachers'); ?></h1></center>
			<?php
				echo __("Language level : ",'b4l-profiling-grid-for-teachers') . get_language_level($post, $value) . "<br>";
				echo __("Qualifications level : ",'b4l-profiling-grid-for-teachers') . get_qualifications_level($post, $value) . "<br>";
				echo __("Core Competencies level : ",'b4l-profiling-grid-for-teachers') . get_core_competencies_level($post, $value) . "<br>";
				echo __("Complementary Skills level : ",'b4l-profiling-grid-for-teachers') . get_complementary_skills_level($post, $value) . "<br>";
			?>
		</div>

		<?php include(plugin_dir_path( dirname( __FILE__ ) ) . 'utils/js_teacher_profiling_grid.php'); ?>
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

		<div id="tabs" style="border: 0px;">

			<h2 class="nav-tab-wrapper">
	          <ul>
	            <li style="border: 0px;"><a href="#tabs-1" class="nav-tab nav-tab-active"><?php _e( 'Language','b4l-portofolio' ); ?></a></li>
	            <li style="border: 0px;"><a href="#tabs-2" class="nav-tab"><?php _e( 'Qualifications','b4l-portofolio' ); ?></a></li>
	            <li style="border: 0px;"><a href="#tabs-3" class="nav-tab"><?php _e( 'Core Competencies','b4l-portofolio' ); ?></a></li>
				<li style="border: 0px;"><a href="#tabs-4" class="nav-tab"><?php _e( 'Complementary Skills','b4l-portofolio' ); ?></a></li>
	          </ul>
			</h2>

			<div id="tabs-1" style="border: 0px;">
				<input type="hidden" id="post_ID" value="<?php echo $post->ID; ?>"/>
				<br>

				<b>&#9679; <?php _e('Language Proficiency','b4l-profiling-grid-for-teachers'); ?> </b><br>
				<?php
					for($i = 0 ; $i < count($t_portfolio["language"]["lp"]); $i++){
						echo '<br>' . '<input type="checkbox" name="teacher_portfolio[]" id="lp'.$counter_lp.'" value="'.$value.$counter.'" style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["language"]["lp"][$i+1 . 1]. '</br>';
						$counter++;
						$counter_lp++;
					}
				?>
				<br>

				<b>&#9679; <?php _e('Language Awareness','b4l-profiling-grid-for-teachers'); ?> </b><br>
				<?php
					for($i = 0 ; $i < count($t_portfolio["language"]["la"]); $i++){
						echo '<br>'. '<input type="checkbox" name="teacher_portfolio[]" id="la'.$counter_la.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["language"]["la"][$i+1 . 1]. '</br>';
						$counter++;
						$counter_la++;
					}
				?>
				<br>

				<?php _e('Evidence :','b4l-profiling-grid-for-teachers'); ?>
				<?php
					//If a file is already uploaded we allows the user to show the evidence or to delete it
					if(get_post_meta($post->ID,'file_tab_a',true)){

						echo get_post_meta($post->ID,'file_tab_a',true);
				 ?>

						<br>
						<div style="margin-top: 5px;">
							<!-- Show the evidence (by clickin, open the file in a new tab) -->
							<input id="show_evidence" type="button" class="button button-primary" value="Show Evidence" onclick="window.open('<?php echo content_url() . '/uploads/profiling-grids/teacher-files/' . get_current_user_id() . '/' . get_post_meta($post->ID,'file_tab_a',true) . ''; ?>')"/>
							<!-- Delete the evidence (delete the file on the server) -->
							<input id="delete_evidence_button" name="file_tab_a" type="button" class="button button-secondary" value="<?php _e('Delete Evidence','b4l-profiling-grid-for-teachers'); ?>" />
							<div id="result_delete_evidence">
								
							</div>
						</div>

					<?php

					} 
					//IF not, we allows the user to upload a file
					else{ ?>
						<input name="file_tab_a" accept=".pdf, .png, .jpeg, .jpg" type="file"/>
						<div id="error-content">

						</div>
						<div id="result_upload_files">
							<input id="upload_files_button" type="button" class="button button-primary" value="<?php _e('Upload file','b4l-profiling-grid-for-teachers'); ?>" />
						</div>
					<?php
					}
					
				?>
			</div>

			<div id="tabs-2" style="border: 0px;">
				<br>
				<b>&#9679; <?php _e('Language Teacher Qualifications','b4l-profiling-grid-for-teachers'); ?> </b><br>
				<?php
					for($i = 0 ; $i < count($t_portfolio["qualifications"]["ltq"]); $i++){
						echo '<br>'. '<input type="checkbox" name="teacher_portfolio[]" id="ltq'.$counter_ltq.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["qualifications"]["ltq"][$i+1 . 1]. '</br>';
						$counter++;
						$counter_ltq++;
					}
				?>
				<br>

				<b>&#9679; <?php _e('Language Teaching Practice','b4l-profiling-grid-for-teachers'); ?> </b><br>
				<?php
					for($i = 0 ; $i < count($t_portfolio["qualifications"]["ltp"]); $i++){
						echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="ltp'.$counter_ltp.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["qualifications"]["ltp"][$i+1 . 1]. '</br>';
						$counter++;
						$counter_ltp++;
					}
				?>
				<br>

				<b>&#9679; <?php _e('Teaching Experience','b4l-profiling-grid-for-teachers'); ?> </b><br>
				<?php
					for($i = 0 ; $i < count($t_portfolio["qualifications"]["te"]); $i++){
						echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="te'.$counter_te.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["qualifications"]["te"][$i+1 . 1]. '</br>';
						$counter++;
						$counter_te++;
					}
				?>
				<br>

				<?php _e('Evidence :','b4l-profiling-grid-for-teachers'); ?> 
				<?php
					if(get_post_meta($post->ID,'file_tab_b',true)){
						echo get_post_meta($post->ID,'file_tab_b',true);
				 ?>
						<br>
						<div style="margin-top: 5px;">
							<input id="show_evidence" type="button" class="button button-primary" value="Show Evidence" onclick="window.open('<?php echo content_url() . '/uploads/profiling-grids/teacher-files/' . get_current_user_id() . '/' . get_post_meta($post->ID,'file_tab_b',true) . ''; ?>')"/>

							<input id="delete_evidence_button" name="file_tab_b" type="button" class="button button-secondary" value="Delete Evidence" />
							<div id="result_delete_evidence">
								
							</div>
						</div>
					<?php
					} else{ ?>
						<input name="file_tab_b" accept=".pdf, .png, .jpeg, .jpg" type="file"/>
						<div id="error-content">
							
						</div>
						<div id="result_upload_files">
							<input id="upload_files_button" type="button" class="button button-primary" value="<?php _e('Upload file','b4l-profiling-grid-for-teachers'); ?>" />
						</div>
					<?php
					}
				?>
			</div>

			<div id="tabs-3" style="border: 0px;">
				<br>
				<b>&#9679; <?php _e('Methodology: knowledge and skills','b4l-profiling-grid-for-teachers'); ?> </b><br>
				<?php
					for($i = 0 ; $i < count($t_portfolio["core_competencies"]["mks"]); $i++){
						echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="mks'.$counter_mks.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["core_competencies"]["mks"][$i+1 . 1]. '</br>';
						$counter++;
						$counter_mks++;
					}
				?>
				<br>

				<b>&#9679; <?php _e('Lesson and Course Planning','b4l-profiling-grid-for-teachers'); ?> </b><br>
				<?php
					for($i = 0 ; $i < count($t_portfolio["core_competencies"]["lcp"]); $i++){
						echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="lcp'.$counter_lcp.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["core_competencies"]["lcp"][$i+1 . 1]. '</br>';
						$counter++;
						$counter_lcp++;
					}
				?>
				<br>

				<b>&#9679; <?php _e('Interaction Management and Monitoring','b4l-profiling-grid-for-teachers'); ?> </b><br>
				<?php
					for($i = 0 ; $i < count($t_portfolio["core_competencies"]["imm"]); $i++){
						echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="imm'.$counter_imm.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["core_competencies"]["imm"][$i+1 . 1]. '</br>';
						$counter++;
						$counter_imm++;
					}
				?>
				<br>

				<b>&#9679; <?php _e('Assessment','b4l-profiling-grid-for-teachers'); ?> </b><br>
				<?php
					for($i = 0 ; $i < count($t_portfolio["core_competencies"]["ast"]); $i++){
						echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="ast'.$counter_ast.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["core_competencies"]["ast"][$i+1 . 1]. '</br>';
						$counter++;
						$counter_ast++;
					}
				?>
				<br>

				Evidence :
				<?php
					if(get_post_meta($post->ID,'file_tab_c',true)){
						echo get_post_meta($post->ID,'file_tab_c',true);
				 ?>
						<br>
						<div style="margin-top: 5px;">
							<input id="show_evidence" type="button" class="button button-primary" value="Show Evidence" onclick="window.open('<?php echo content_url() . '/uploads/profiling-grids/teacher-files/' . get_current_user_id() . '/' . get_post_meta($post->ID,'file_tab_c',true) . ''; ?>')"/>
							
							<input id="delete_evidence_button" name="file_tab_c" type="button" class="button button-secondary" value="Delete Evidence" />
							<div id="result_delete_evidence">

							</div>
						</div>
					<?php
					} else{ ?>
						<input name="file_tab_c" accept=".pdf, .png, .jpeg, .jpg" type="file"/>
						<div id="error-content">
							
						</div>
						<div id="result_upload_files">
							<input id="upload_files_button" type="button" class="button button-primary" value="<?php _e('Upload file','b4l-profiling-grid-for-teachers'); ?>" />
						</div>
					<?php
					}
				?>
			</div>

			<div id="tabs-4" style="border: 0px;">
				<br>
				<b>&#9679; <?php _e('Teacher Development','b4l-profiling-grid-for-teachers'); ?> </b><br>
				<?php
					for($i = 0 ; $i < count($t_portfolio["complementary_skills"]["td"]); $i++){
						echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="td'.$counter_td.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '> ' .  $t_portfolio["complementary_skills"]["td"][$i+1 . 1]. '</br>';
						$counter++;
						$counter_td++;
					}
				?>
				<br>

				<b>&#9679; <?php _e('Digital Media','b4l-profiling-grid-for-teachers'); ?> </b><br>
				<?php
					for($i = 0 ; $i < count($t_portfolio["complementary_skills"]["dm"]); $i++){
						echo '<br>'.  '<input type="checkbox" name="teacher_portfolio[]" id="dm'.$counter_dm.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_teacher($value.$counter) . '>' .  $t_portfolio["complementary_skills"]["dm"][$i+1 . 1]. '</br>';
						$counter++;
						$counter_dm++;
					}
				?>
				<br>
					
				<?php _e('Evidence :','b4l-profiling-grid-for-teachers'); ?>
				<?php
					if(get_post_meta($post->ID,'file_tab_d',true)){
						echo get_post_meta($post->ID,'file_tab_d',true);
				 ?>
						<br>
						<div style="margin-top: 5px;">
							<input id="show_evidence" type="button" class="button button-primary" value="Show Evidence" onclick="window.open('<?php echo content_url() . '/uploads/profiling-grids/teacher-files/' . get_current_user_id() . '/' . get_post_meta($post->ID,'file_tab_d',true) . ''; ?>')"/>
							
							<input id="delete_evidence_button" name="file_tab_d" type="button" class="button button-secondary" value="Delete Evidence" />
							<div id="result_delete_evidence">

							</div>
						</div>
					<?php
					} else{ ?>
						<input name="file_tab_d" accept=".pdf, .png, .jpeg, .jpg" type="file"/>
						<div id="error-content">
							
						</div>
						<div id="result_upload_files">
							<input id="upload_files_button" type="button" class="button button-primary" value="<?php _e('Upload file','b4l-profiling-grid-for-teachers'); ?>" />
						</div>
					<?php
					}
				?>
			</div>
		</div>
		<br>
	<?php
	}
}
add_action('init', 'metabox_teacher');

//Return the language level
function get_language_level($post, $value){
	$i = 0;
	$j = 6;

	while($i <= 5 && in_array( $value.$i, get_post_meta( $post->ID, "teacher_portfolio", true ) ) && $j <= 11 && in_array( $value.$j, get_post_meta( $post->ID, "teacher_portfolio", true ) ) ){
		$i++;
		$j++;
	}

	if( $i == 6 && $j == 12 ){
		$result = 'T6';
	}else{
		switch (true){
			case ( $i%6 == 0 && $j%6 == 0 ):
				$result = __('No level','b4l-profiling-grid-for-teachers');
				break;
			case ( $i%6 == 1 && $j%6 == 1 ): 
				$result = 'T1';
				break;
			case ( $i%6 == 2 && $j%6 == 2 ): 
				$result = 'T2';
				break;
			case ( $i%6 == 3 && $j%6 == 3 ): 
				$result = 'T3';
				break;
			case ( $i%6 == 4 && $j%6 == 4 ): 
				$result = 'T4';
				break;
			case ( $i%6 == 5 && $j%6 == 5 ): 
				$result = 'T5';
				break;
		}
	}

	return $result;
}

//Return the qualifications level
function get_qualifications_level($post, $value){
	$i = 12;
	$j = 18;
	$k = 24;

	while($i <= 17 && in_array( $value.$i, get_post_meta( $post->ID, "teacher_portfolio", true ) ) && $j <= 23 && in_array( $value.$j, get_post_meta( $post->ID, "teacher_portfolio", true ) ) && $k <= 29 && in_array( $value.$k, get_post_meta( $post->ID, "teacher_portfolio", true ) ) ){
		$i++;
		$j++;
		$k++;
	}

	if( $i == 18 && $j == 24 && $k == 30 ){
		$result = 'T6';
	}else{
		switch (true){
			case ( $i%6 == 0 && $j%6 == 0 && $k%6 == 0 ):
				$result = __('No level','b4l-profiling-grid-for-teachers');
				break;
			case ( $i%6 == 1 && $j%6 == 1 && $k%6 == 1 ): 
				$result = 'T1';
				break;
			case ( $i%6 == 2 && $j%6 == 2 && $k%6 == 2 ): 
				$result = 'T2';
				break;
			case ( $i%6 == 3 && $j%6 == 3 && $k%6 == 3 ): 
				$result = 'T3';
				break;
			case ( $i%6 == 4 && $j%6 == 4 && $k%6 == 4 ): 
				$result = 'T4';
				break;
			case ( $i%6 == 5 && $j%6 == 5 && $k%6 == 5 ): 
				$result = 'T5';
				break;
		}
	}

	return $result;
}

//Return the core competencies level
function get_core_competencies_level($post, $value){
	$i = 30;
	$j = 36;
	$k = 42;
	$l = 48;

	while($i <= 35 && in_array( $value.$i, get_post_meta( $post->ID, "teacher_portfolio", true ) ) && $j <= 41 && in_array( $value.$j, get_post_meta( $post->ID, "teacher_portfolio", true ) ) && $k <= 47 && in_array( $value.$k, get_post_meta( $post->ID, "teacher_portfolio", true ) ) && $l <= 53 && in_array( $value.$l, get_post_meta( $post->ID, "teacher_portfolio", true ) ) ){
		$i++;
		$j++;
		$k++;
		$l++;
	}

	if( $i == 36 && $j == 42 && $k == 48 && $l == 54 ){
		$result = 'T6';
	}else{
		switch (true){
			case ( $i%6 == 0 && $j%6 == 0 && $k%6 == 0 && $l%6 == 0 ):
				$result = __('No level','b4l-profiling-grid-for-teachers');
				break;
			case ( $i%6 == 1 && $j%6 == 1 && $k%6 == 1 && $l%6 == 1 ): 
				$result = 'T1';
				break;
			case ( $i%6 == 2 && $j%6 == 2 && $k%6 == 2 && $l%6 == 2 ): 
				$result = 'T2';
				break;
			case ( $i%6 == 3 && $j%6 == 3 && $k%6 == 3 && $l%6 == 3 ): 
				$result = 'T3';
				break;
			case ( $i%6 == 4 && $j%6 == 4 && $k%6 == 4 && $l%6 == 4 ): 
				$result = 'T4';
				break;
			case ( $i%6 == 5 && $j%6 == 5 && $k%6 == 5 && $l%6 == 5 ): 
				$result = 'T5';
				break;
		}
	}

	return $result;
}

//Return the complementary skills level
function get_complementary_skills_level($post, $value){
	$i = 54;
	$j = 60;

	while($i <= 59 && in_array( $value.$i, get_post_meta( $post->ID, "teacher_portfolio", true ) ) && $j <= 65 && in_array( $value.$j, get_post_meta( $post->ID, "teacher_portfolio", true ) ) ){
		$i++;
		$j++;
	}

	if( $i == 60 && $j == 66 ){
		$result = 'T6';
	}else{
		switch (true){
			case ( $i%6 == 0 && $j%6 == 0 ):
				$result = __('No level','b4l-profiling-grid-for-teachers');
				break;
			case ( $i%6 == 1 && $j%6 == 1 ): 
				$result = 'T1';
				break;
			case ( $i%6 == 2 && $j%6 == 2 ): 
				$result = 'T2';
				break;
			case ( $i%6 == 3 && $j%6 == 3 ): 
				$result = 'T3';
				break;
			case ( $i%6 == 4 && $j%6 == 4 ): 
				$result = 'T4';
				break;
			case ( $i%6 == 5 && $j%6 == 5 ): 
				$result = 'T5';
				break;
		}
	}

	return $result;
}

/* Adds the metabox teacher portfolio language into the badge custom post type */
function metabox_teacher_portfolio_language(){
	add_action('add_meta_boxes', function(){
		add_meta_box('id_meta_box_teacher_portfolio_language', __('Teacher portfolio language','b4l-profiling-grid-for-teachers'), 'teacher_portfolio_language', 'teacher_portfolio', 'side', 'high');
	});

	function teacher_portfolio_language($post){
		if( is_plugin_active( "open-badges-framework/open-badges-framework.php" ) ) {
			// Display the children of the right PARENT
		    $parents = apply_filters( 'plugin_get_sub', $parents );
		    echo '<div style="margin-bottom:5px;"><b>';
		    _e('Most important languages :','b4l-profiling-grid-for-teachers');
		    echo '</b></div>';
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
add_action('init', 'metabox_teacher_portfolio_language');

//Add the teacher metabox (teacher realated to this profilling grid)
function metabox_teach(){
	add_action('add_meta_boxes', function(){
		add_meta_box('id_teacher', __('Teacher','b4l-profiling-grid-for-teachers'), 'func_teacher', 'teacher_portfolio', 'side', 'high');
	});

	function func_teacher($post){
		$teachers = get_users( [ 'role__in' => [ 'teacher' ] ] ); ?>

		<select name="teacher" id="teacher">
			<option value="Select">Select</option>
		    <?php
		    foreach ( $teachers as $teacher ) {
		    	if( get_post_meta( $post->ID,'_teacher',true ) == $teacher->ID ){
		   			echo '<option selected="selected" value="' . $teacher->ID . '">' . $teacher->display_name . '</option>';
		   		}else{
		   			echo '<option value="' . $teacher->ID . '">' . $teacher->display_name . '</option>';
		   		}
		   	}
		    ?>
	    </select>

	    <?php
	}
}
add_action('init', 'metabox_teach');

//Save the metaboxes
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
		update_post_meta($post->ID, "_portfolio_language", $_POST['language']);

	if(isset($_POST['teacher']))
		update_post_meta($post->ID, "_teacher", $_POST['teacher']);

});

// Add the custom columns to the teacher_portfolio post type:
/*add_filter( 'manage_teacher_portfolio_posts_columns', 'set_custom_edit_teacher_portfolio_columns' );
function set_custom_edit_teacher_portfolio_columns($columns) {
    $columns['pf_teacher'] = __( 'Teacher','b4l-portofolio' );
    $columns['pf_language'] = __( 'Language','b4l-portofolio' );

    return $columns;
}

// Add the data to the custom columns for the teacher_portfolio post type:
add_action( 'manage_teacher_portfolio_posts_custom_column' , 'custom_teacher_portfolio_column', 10, 2 );
function custom_teacher_portfolio_column( $column, $post_id ) {
    switch ( $column ) {

        case 'pf_teacher' :
            echo get_post_meta( $post->ID,'_teacher',true );
            break;

        case 'pf_language' :
        	$language_id = get_post_meta( $post->ID,'_portfolio_language',true );
            echo $language_id; 
            break;

    }
}*/

///////////////////////////////////////////////
///////////////////////////////////////////////
add_action('admin_menu', 'tp_portfolio_add_settings');

function tp_portfolio_add_settings(){
	add_submenu_page(
		'edit.php?post_type=teacher_portfolio',
		'Teacher portfolio Settings',
		__('Settings','b4l-profiling-grid-for-teachers'),
		'manage_options',
		'create_portfolio',
		'create_profiling_grid_callback' );
}

?>

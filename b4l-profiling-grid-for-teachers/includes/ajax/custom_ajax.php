<?php

    require_once '../../../../../wp-load.php';

    //mimic the actuall admin-ajax
    define('DOING_AJAX', true);

    if (!isset( $_POST['action']))
        die('-1');

    //Typical headers
    header('Content-Type: text/html');
    send_nosniff_header();

    //Disable caching
    header('Cache-Control: no-cache');
    header('Pragma: no-cache');

    $action = esc_attr(trim($_POST['action']));

    //A bit of security
    $allowed_actions = array(
        'action_send_badge_portfolio',
        'action_send_badges_student_grid',
        'action_upload_files',
        'action_delete_evidence'
    );

    /* AJAX action to send a badge from a portfolio*/

    add_action('CUSTOMAJAX_action_upload_files', 'action_upload_files');

    function action_upload_files() {
      $data = array();

      if(isset($_FILES))
      {
          global $current_user;
          get_currentuserinfo();

          $error = false;
          $files = array();

          $uploaddir = plugin_dir_path( dirname( __FILE__ ) ) . '../../../uploads/profiling-grids/'.$_POST['type_user'].'/';
          $uploaddir = $uploaddir.get_current_user_id().'/';

          if (!file_exists($uploaddir))
            mkdir($uploaddir, 0777, true);

          foreach($_FILES as $file)
          {
              if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
              {
                  update_post_meta($_POST['post_ID'], $_POST['tab'], basename($file['name']));
                  $files[] = basename($file['name']);
              }
              else
              {
                  $error = true;
              }
          }
          $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
          echo json_encode($data);
      }
    }

    add_action('CUSTOMAJAX_action_delete_evidence', 'action_delete_evidence');

    function action_delete_evidence() {
      $data = array();
      $dir = wp_upload_dir();
      $file = "";
      $error = false;

      if( unlink( $dir['basedir'] . '/portfolios-grids/' . $_POST['type_user'] . '/' . get_current_user_id() . '/' . get_post_meta($_POST['post_ID'],$_POST['tab'],true) ) )
      {
        $file = get_post_meta( $_POST['post_ID'],$_POST['tab'],true );
        delete_post_meta( $_POST['post_ID'], $_POST['tab'] );
      }
      else if ( get_post_meta( $_POST['post_ID'],$_POST['tab'],true ) )
      {
        $file = get_post_meta( $_POST['post_ID'],$_POST['tab'],true );
        delete_post_meta( $_POST['post_ID'], $_POST['tab'] );
      }
      else
      {
        $error = true;
      }
      $data = ($error) ? array('error' => 'There was an error deleting your files') : array('file' => $file);
      echo json_encode($data);
    }


    add_action('CUSTOMAJAX_action_send_badge_portfolio', 'action_send_badge_portfolio');

    function action_send_badge_portfolio() {
      global $current_user;
      get_currentuserinfo();

      $badges = get_all_badges();
      $badge_infos = get_badge($_POST['badge_name'], $badges, "English");

      $url_json_files = content_url('uploads/badges-issuer/json/');
      $path_dir_json_files = plugin_dir_path( dirname( __FILE__ ) ) . '../../../uploads/badges-issuer/json/';

      $badge = new Badge($badge_infos['name'], $badge_infos['name'], $_POST['badge_language'], "", $badge_infos['description'], $badge_infos['image'], $url_json_files, $path_dir_json_files);

      $mail = $current_user->user_email;

      $badge->create_json_files($mail);

      if($badge->send_mail($mail, null)) {
        echo "<img src='".plugins_url( '../../images/sended.png', __FILE__ )."' width='200px' height='190px' />";
        $content = '<center><h1>Current Result</h1></center><div id="result"></div>';
        echo "<script>
        setTimeout(function(){
          jQuery('#result_content').html('".$content."');
        }, 2000);
        </script>";
      }
      else
        echo "<img src='".plugins_url( '../../images/not_sended.png', __FILE__ )."' width='200px' height='190px' />";
    }

    add_action('CUSTOMAJAX_action_send_badges_student_grid', 'action_send_badges_student_grid');

    function action_send_badges_student_grid() {
      global $current_user;
      get_currentuserinfo();

      $url_json_files = content_url('uploads/badges-issuer/json/');
      $path_dir_json_files = plugin_dir_path( dirname( __FILE__ ) ) . '../../../uploads/badges-issuer/json/';

      $badge = new Badge($_POST['badge_name'], $_POST['badge_level'], $_POST['badge_language'], "", $_POST['badge_description'], $_POST['badge_image'], $url_json_files, $path_dir_json_files);

      $mail = $current_user->user_email;

      $badge->create_json_files($mail);

      if($badge->send_mail($mail, null)) {
        echo "<img src='".plugins_url( '../../images/sended.png', __FILE__ )."' width='95px' height='90px' />";
        $content_input_checkbox = '<input type="checkbox" name="input_badge_student_grid_name" id="badge_'.$_POST['badge_level'].'" class="input-badge input-hidden" value="'.$_POST['badge_level'].'"/><label for="badge_'.$_POST['badge_level'].'"><img id="image_'.$_POST['badge_level'].'" src="'.$_POST['badge_image'].'" width="100px" height="100px" /></label>';

        echo "<script>
        setTimeout(function(){
          jQuery('#result_".$_POST['badge_level']."').html('".$content_input_checkbox."');
        }, 2000);
        </script>";
      }
      else
        echo "<img src='".plugins_url( '../../images/not_sended.png', __FILE__ )."' width='50px' height='40px' />";
    }

    if(in_array($action, $allowed_actions)) {
        if(is_user_logged_in())
            do_action('CUSTOMAJAX_'.$action);
    } else {
        die('-1');
    }

?>

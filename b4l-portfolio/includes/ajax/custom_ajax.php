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
        'action_send_badge_portfolio'
    );

    /* AJAX action to send a badge from a portfolio*/

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

    if(in_array($action, $allowed_actions)) {
        if(is_user_logged_in())
            do_action('CUSTOMAJAX_'.$action);
    } else {
        die('-1');
    }

?>

<?php wp_enqueue_script("jquery"); ?>

<script>

  function sendBadgePortfolio(badge, language) {
    var data = {
      'action': 'action_send_badge_portfolio',
      'badge_name': badge.toLowerCase(),
      'badge_language': language
    };

    jQuery("#result_content").html("<img src='<?php echo plugins_url( '../../images/sending.gif', __FILE__ ); ?>' width='250px' height='250px' />");

    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
    jQuery.post("<?php echo plugins_url( '../ajax/custom_ajax.php', __FILE__ ); ?>", data, function(response) {
      jQuery("#result_content").html(response);
    });
  }

  </script>

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

  function sendBadgesStudentGrid(language) {
    var badges_selected = [];
    jQuery('input[name="input_badge_student_grid_name"]:checked').each(function() {
      badges_selected.push(this.value);
    });

    badges_selected.forEach(function(level) {
      var data = {
        'action': 'action_send_badges_student_grid',
        'badge_name': level,
        'badge_level': level,
        'badge_language': language,
        'badge_description': jQuery('#description_'+level).text(),
        'badge_image': jQuery('#image_'+level).attr('src')
      };

      jQuery("#result_"+level).html("<img src='<?php echo plugins_url( '../../images/sending.gif', __FILE__ ); ?>' width='100px' height='100px' />");
      jQuery("#result_send_badge_student_grid").html("<img src='<?php echo plugins_url( '../../images/sending.gif', __FILE__ ); ?>' width='50px' height='50px' />");

      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post("<?php echo plugins_url( '../ajax/custom_ajax.php', __FILE__ ); ?>", data, function(response) {
        jQuery("#result_"+level).html(response);
        jQuery("#result_send_badge_student_grid").html('<input type="button" id="send_badges_student_grid" onclick="javascript:sendBadgesStudentGrid("'+language+'")" class="button button-primary" value="Send badges to yourself" />');
      });
    });

  }

</script>

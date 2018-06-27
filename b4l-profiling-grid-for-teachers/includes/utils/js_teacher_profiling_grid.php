<?php wp_enqueue_script("jquery"); ?>
<script>

function printResult(badge) {
  var teacher_badge_start = '<center><img src="<?php echo plugin_dir_url( __FILE__ ); ?>../../images/badges/teacher_levels/';
  var badge_end = '.png" width="100px" height="100px" /></center><br />';

  var content = teacher_badge_start
                +badge
                +badge_end;

  <?php
  global $post;
  if(is_plugin_active("badges-issuer-for-wp/badges-issuer-for-wp.php")) {
  ?>
    var content = content+'<center><button onclick="sendBadgePortfolio'+"('"+badge+"', '<?php echo get_post_meta($post->ID,'_portfolio_language',true); ?>')"+'">Send this badge to yourself</button></center><br />';
  <?php
  }
  ?>
  return content;
}

jQuery( document ).ready(function() {
    setInterval(function(){
      var T1 = false;
			var T2 = false;
			var T3 = false;
			var T4 = false;
			var T5 = false;
			var T6 = false;
			var default_result = true;

      /// Checking if T1 is activated
			/// Print the result if only T1 is active
			if(		document.getElementById("lp1").checked &&
			   		document.getElementById("la1").checked &&
			   		document.getElementById("ltq1").checked &&
			   		document.getElementById("ltp1").checked &&
			   		document.getElementById("te1").checked &&
			   		document.getElementById("mks1").checked &&
			   		document.getElementById("lcp1").checked &&
			   		document.getElementById("imm1").checked &&
			   		document.getElementById("ast1").checked &&
			   		document.getElementById("td1").checked &&
			   		document.getElementById("dm1").checked
      ){
			  T1 = true;
				default_result = false;
				jQuery("#result").html(printResult("T1"));
			}


			/// Checking if T2 is activated
			/// Print the result if only T1 and T2 are active
			if(T1 &&
				   	document.getElementById("lp2").checked &&
			   		document.getElementById("la2").checked &&
			   		document.getElementById("ltq2").checked &&
			   		document.getElementById("ltp2").checked &&
			   		document.getElementById("te2").checked &&
			   		document.getElementById("mks2").checked &&
			   		document.getElementById("lcp2").checked &&
			   		document.getElementById("imm2").checked &&
			   		document.getElementById("ast2").checked &&
			   		document.getElementById("td2").checked &&
			   		document.getElementById("dm2").checked
      ){
				T2 = true;
				jQuery("#result").html(printResult("T2"));
			}

			/// Checking if T3 is activated
			/// Print the result if only T1, T2 and T3 are active
			if(T2 &&
				   	document.getElementById("lp3").checked &&
			   		document.getElementById("la3").checked &&
			   		document.getElementById("ltq3").checked &&
			   		document.getElementById("ltp3").checked &&
			   		document.getElementById("te3").checked &&
			   		document.getElementById("mks3").checked &&
			   		document.getElementById("lcp3").checked &&
			   		document.getElementById("imm3").checked &&
			   		document.getElementById("ast3").checked &&
			   		document.getElementById("td3").checked &&
			   		document.getElementById("dm3").checked
      ){
				T3 = true;
				jQuery("#result").html(printResult("T3"));
			}

			/// Checking if T4 is activated
			/// Print the result if only T1, T2, T3 and T4 are active
			if(T3 &&
				   	document.getElementById("lp4").checked &&
			   		document.getElementById("la4").checked &&
			   		document.getElementById("ltq4").checked &&
			   		document.getElementById("ltp4").checked &&
			   		document.getElementById("te4").checked &&
			   		document.getElementById("mks4").checked &&
			   		document.getElementById("lcp4").checked &&
			   		document.getElementById("imm4").checked &&
			   		document.getElementById("ast4").checked &&
			   		document.getElementById("td4").checked &&
			   		document.getElementById("dm4").checked
      ){
				T4 = true;
				jQuery("#result").html(printResult("T4"));
			}


			/// Checking if T5 is activated
			/// Print the result if only T1, T2, T3, T4 and T5 are active
			if(T4 &&
				   	document.getElementById("lp5").checked &&
			   		document.getElementById("la5").checked &&
			   		document.getElementById("ltq5").checked &&
			   		document.getElementById("ltp5").checked &&
			   		document.getElementById("te5").checked &&
			   		document.getElementById("mks5").checked &&
			   		document.getElementById("lcp5").checked &&
			   		document.getElementById("imm5").checked &&
			   		document.getElementById("ast5").checked &&
			   		document.getElementById("td5").checked &&
			   		document.getElementById("dm5").checked
      ){
				T5 = true;
				jQuery("#result").html(printResult("T5"));
			}


			/// Checking if T6 is activated
			/// Print the result if only T1, T2, T3, T4, T5 and T6 are active
			if(T5 &&
				   	document.getElementById("lp6").checked &&
			   		document.getElementById("la6").checked &&
			   		document.getElementById("ltq6").checked &&
			   		document.getElementById("ltp6").checked &&
			   		document.getElementById("te6").checked &&
			   		document.getElementById("mks6").checked &&
			   		document.getElementById("lcp6").checked &&
			   		document.getElementById("imm6").checked &&
			   		document.getElementById("ast6").checked &&
			   		document.getElementById("td6").checked &&
			   		document.getElementById("dm6").checked
      ){
				T6 = true;
				jQuery("#result").html(printResult("T6"));
			}

			if(default_result){
				jQuery("#result").html("");
			}

		}, 500);


    // Variable to store your files
    var files;
    var id;
    var tab;

    // Prepare upload
    jQuery('input[type=file]').on('change', function(event){
      files = event.target.files;
      tab = jQuery(this).attr('name');
      id = jQuery("#post_ID").val();
    });

    jQuery('#upload_files_button').click(uploadFiles);

    // Catch the form submit and upload the files
    function uploadFiles(event)
    {
        console.log("in upload");
        event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening

        // START A LOADING SPINNER HERE

        // Create a formdata object and add the files
        var data = new FormData();
        jQuery.each(files, function(key, value)
        {
            data.append(key, value);
        });
        data.append("action", "action_upload_files");
        data.append("post_ID", id);
        data.append("tab", tab);
        data.append("type_user", "teacher-files");

        jQuery("#result_upload_files").html("<img src='<?php echo plugins_url( '../../images/sending.gif', __FILE__ ); ?>' width='50px' height='50px' />");

        jQuery.ajax({
            url: "<?php echo plugins_url( '../ajax/custom_ajax.php', __FILE__ ); ?>",
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(data, textStatus, jqXHR)
            {
                if(typeof data.error === 'undefined')
                {
                    var files_string = "";
                    data.files.forEach(function(element){
                        files_string = files_string + element + "<br />";
                    });

                    jQuery("#result_upload_files").html(
                      "File uploaded : <br />"+files_string
                    );
                }
                else
                {
                    // Handle errors here
                    console.log('ERRORS: ' + data.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                // Handle errors here
                console.log('ERRORS: ' + textStatus);
                // STOP LOADING SPINNER
            }
        });
    }

    jQuery('#delete_evidence_button').click(deleteEvidence);
    function deleteEvidence(event){
	    tab = jQuery(this).attr('name');
	    id = jQuery("#post_ID").val();
    	var data = new FormData();

    	data.append("action", "action_delete_evidence");
        data.append("post_ID", id);
        data.append("tab", tab);
        data.append("type_user", "teacher-files");

        jQuery.ajax({
            url: "<?php echo plugins_url( '../ajax/custom_ajax.php', __FILE__ ); ?>",
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(data, textStatus, jqXHR)
            {
                if(typeof data.error === 'undefined')
                {
                	var file_string = data.file;

                    jQuery("#result_delete_evidence").html(
                      "File deleted : <br />"+file_string
                    );

                    location.reload();
                }
                else
                {
                    // Handle errors here
                    console.log('ERRORS: ' + data.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                // Handle errors here
                console.log('ERRORS: ' + textStatus);
                // STOP LOADING SPINNER
            }
        });
    }

});

</script>

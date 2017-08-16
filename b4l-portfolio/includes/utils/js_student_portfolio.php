<?php wp_enqueue_script("jquery"); ?>
<script>

function printResult(badge) {
  var student_badge_start = '<center><img src="<?php echo plugin_dir_url( __FILE__ ); ?>../../images/badges/student_levels/';
  var badge_end = '.png" width="100px" height="100px" /></center><br />';

  var content = student_badge_start
                +badge
                +badge_end;

  <?php
  global $post;
  if(is_plugin_active("badges-issuer-for-wp/badges-issuer-for-wp.php")) {
  ?>
    var content = content+'<center><button onclick="sendBadgePortfolio'+"('"+badge+"', '<?php echo get_post_meta($post->ID,'_portofolio_language',true); ?>')"+'">Send this badge to yourself</button></center><br />';
  <?php
  }
  ?>
  return content;
}

jQuery( document ).ready(function() {
  setInterval(function(){
			var A1 = false;
			var A2 = false;
			var B1 = false;
			var B2 = false;
			var C1 = false;
			var C2 = false;
			var default_result = true;

			/// Checking if A1 is activated
			if(
						document.getElementById("li1").checked &&
			   		document.getElementById("re1").checked &&
			   		document.getElementById("si1").checked &&
			   		document.getElementById("sp1").checked &&
			   		document.getElementById("wr1").checked
			){
			  A1 = true;
				default_result = false;

				jQuery("#result").html(printResult("A1"));
			}


			/// Checking if A2 is activated
			if(A1 &&
				   	document.getElementById("li2").checked &&
			   		document.getElementById("re2").checked &&
			   		document.getElementById("si2").checked &&
			   		document.getElementById("sp2").checked &&
			   		document.getElementById("wr2").checked
      ){
				A2 = true;
				jQuery("#result").html(printResult("A2"));
			}

			/// Checking if B1 is activated
			if(A2 &&
				   	document.getElementById("li3").checked &&
			   		document.getElementById("re3").checked &&
			   		document.getElementById("si3").checked &&
			   		document.getElementById("sp3").checked &&
			   		document.getElementById("wr3").checked ){
				B1 = true;
				jQuery("#result").html(printResult("B1"));
			}

			/// Checking if B2 is activated
			if(B1 &&
				   	document.getElementById("li4").checked &&
			   		document.getElementById("re4").checked &&
			   		document.getElementById("si4").checked &&
			   		document.getElementById("sp4").checked &&
			   		document.getElementById("wr4").checked ){
				B2 = true;
				jQuery("#result").html(printResult("B2"));
			}


			/// Checking if C1 is activated
			if(B2 &&
				   	document.getElementById("li5").checked &&
			   		document.getElementById("re5").checked &&
			   		document.getElementById("si5").checked &&
			   		document.getElementById("sp5").checked &&
			   		document.getElementById("wr5").checked
      ){
				C1 = true;
				jQuery("#result").html(printResult("C1"));
			}


			/// Checking if C2 is activated
			if(C1 &&
				   	document.getElementById("li6").checked &&
			   		document.getElementById("re6").checked &&
			   		document.getElementById("si6").checked &&
			   		document.getElementById("sp6").checked &&
			   		document.getElementById("wr6").checked ){
				C2 = true;
				jQuery("#result").html(printResult("C2"));
			}

			if(default_result){
				jQuery("#result").html("");
			}
    }, 500);
});

</script>

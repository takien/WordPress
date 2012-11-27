<?php
/**
 * Embed recaptcha on Form
 * @author  : takien
 * @link  : http://takien.com
 * @version  : 1.0
 */
require_once(dirname(__FILE__).'/inc/recaptcha/recaptchalib.php');


/**
 * Recaptcha POST check
 *
 *
 */
$publickey = "RECAPCTHA_PUBLIC_KEY"; // you got this from the signup page
$privatekey = "RECAPTCHA_PRIVATE_KEY";
$resp = recaptcha_check_answer ($privatekey,
$_SERVER["REMOTE_ADDR"],
$_POST["recaptcha_challenge_field"],
$_POST["recaptcha_response_field"]);

/* validate*/
if (!$resp->is_valid) {
	echo 'Incorect captcha';
}

/**
 * Recaptcha Head script
 *
 *
 */
add_action('wp_head','recaptcha_script');
function recaptcha_script(){
	?>
	<script type="text/javascript">
	 var RecaptchaOptions = {
		theme : 'custom',
		custom_theme_widget: 'recaptcha_widget'
	 };
	 </script>
	<?php
}

/**
 * Recaptcha form HTML
 *
 */

?>
<!--captcha-->
<div id="recaptcha_widget" style="display:none">
	
	<div style="margin-bottom:5px;" id="recaptcha_image"></div>
	<div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div>
	
	<span class="recaptcha_only_if_image">Enter the words above:</span>
	<span class="recaptcha_only_if_audio">Enter the numbers you hear:</span>
	
	<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
	
	
</div>

<script type="text/javascript"
src="http://www.google.com/recaptcha/api/challenge?k=<?php echo $publickey;?>">
</script>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#recaptcha_image').attr('title','Click to reload captcha').click(function(){
			javascript:Recaptcha.reload();
			return false;
		});
	});
</script>
<noscript>
	<iframe src="http://www.google.com/recaptcha/api/noscript?k=<?php echo $publickey;?>"
height="300" width="500" frameborder="0"></iframe><br>
<textarea name="recaptcha_challenge_field" rows="3" cols="40">
</textarea>
<input type="hidden" name="recaptcha_response_field"
value="manual_challenge">
</noscript>
<!--/captcha-->
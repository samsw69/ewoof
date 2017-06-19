<?php
/**
 *
 * URL: www.freecontactform.com
 *
 * Version: FreeContactForm Free V2.2
 *
 * Copyright (c) 2013 Stuart Cochrane
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * Note: This is NOT the same code as the PRO version
 *
 */

if(isset($_POST['Email_Address'])) {

	include 'freecontactformsettings.php';

	function died($error) {
		echo "Sorry, but there were error(s) found with the form you submitted. ";
		echo "These errors appear below.<br /><br />";
		echo $error."<br /><br />";
		echo "Please go back and fix these errors.<br /><br />";
		die();
	}

	if(!isset($_POST['Full_Name']) ||
		!isset($_POST['Email_Address']) ||
		!isset($_POST['Dog_Name']) ||
		!isset($_POST['Address']) ||
		!isset($_POST['Home_Tel']) ||
		!isset($_POST['Mobile_Tel']) ||
		!isset($_POST['Work_Tel']) ||
    !isset($_POST['Add_Info']) ||
    !isset($_POST['AntiSpam'])
  ) {
  		died('Sorry, there appears to be a problem with your form submission.');
  }

  $full_name = $_POST['Full_Name']; // required
	$email_from = $_POST['Email_Address']; // required
	$dog_name = $_POST['Dog_Name']; // required
	$address = $_POST['Address']; // required
	$home_tel = $_POST['Home_Tel']; // required
	$mobile_tel = $_POST['Mobile_Tel']; // required
	$work_tel = $_POST['Work_Tel']; // not required
	$add_info = $_POST['Add_Info']; // required
	$antispam = $_POST['AntiSpam']; // required

	$error_message = "";

	$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(preg_match($email_exp,$email_from)==0) {
  	$error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
  if(strlen($full_name) < 2) {
  	$error_message .= 'Your Name does not appear to be valid.<br />';
  }
  if(strlen($dog_name) < 2) {
    $error_message .= 'Dogs name does not appear to be valid.<br />';
  }
  if(strlen($address) < 10) {
    $error_message .= 'Your address does not appear to be valid.<br />';
  }
  if(strlen($home_tel) < 11) {
    $error_message .= 'Your home telephone number does not appear to be valid.<br />';
  }
  if(strlen($mobile_tel) < 1) {
    $error_message .= 'Your mobile number does not appear to be valid.<br />';
  }
  if(strlen($work_tel) < 1) {
    $error_message .= 'Your work telephone number does not appear to be valid.<br />';
  }
  if(strlen($add_info) < 2) {
    $error_message .= 'Please write N/A if there is no further information that we need to know about.<br />';
  }


  if($antispam <> $antispam_answer) {
	$error_message .= 'The Anti-Spam answer you entered is not correct.<br />';
  }

  if(strlen($error_message) > 0) {
  	died($error_message);
  }
	$email_message = "Form details below.\r\n";

	function clean_string($string) {
	  $bad = array("content-type","bcc:","to:","cc:");
	  return str_replace($bad,"",$string);
	}

  $email_message .= "Full Name: ".clean_string($full_name)."\r\n";
	$email_message .= "Dogs Name: ".clean_string($dog_name)."\r\n";
	$email_message .= "Address: ".clean_string($address)."\r\n";
	$email_message .= "Home Tel: ".clean_string($home_tel)."\r\n";
	$email_message .= "Mobile Tel: ".clean_string($mobile_tel)."\r\n";
	$email_message .= "Work Tel: ".clean_string($work_tel)."\r\n";
	$email_message .= "Additional Information: ".clean_string($add_info)."\r\n";

$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($email_to, $email_subject, $email_message, $headers);
header("Location: $thankyou");
?>
<script>location.replace('<?php echo $thankyou;?>')</script>
<?php
}
die();
?>
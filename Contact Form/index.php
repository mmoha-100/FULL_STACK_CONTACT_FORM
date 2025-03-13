<?php
	// Too Much Dynamic:
	$minUsernameLen = 4;
	$maxUsernameLen = 100;

	$minMessageLen = 10;
	$maxMessageLen = 500;

	// Passing the Variables to JavaScript:
	echo 
		"
			<script>
				const minUsernameLen = $minUsernameLen;
				const maxUsernameLen = $maxUsernameLen;

				const minMessageLen = $minMessageLen;
				const maxMessageLen = $maxMessageLen;
			</script>
		";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//Filtering the Inputs:
		$username = trim(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
		$email = $_POST['email']; // Using [type='email'] Will do the This Job
		$mobile = trim(filter_var($_POST["mobile"], FILTER_SANITIZE_NUMBER_INT));
		$msg = trim(filter_var($_POST['message'], FILTER_SANITIZE_STRING));

		$errors = array();

		if(strlen($username) > $maxUsernameLen || strlen($username)< $minUsernameLen) {
			$errors[] = "The Username Must be Between $minUsernameLen and $maxUsernameLen Letters";
		}
		if((strlen($msg)<$minMessageLen || strlen($msg)>$maxMessageLen) && $msg!=''){
			$errors[] = "The Message Must be Between $minMessageLen and $maxMessageLen Letters";
		}

		// Sending the Inputs' Values:
		if(empty($errors)) {
			$header = 'From: '.$email.'\r\n';
			$myEmail = 'mohamed.ghalib.habib@gmail.com';
			$subject = 'Contact Form';	

			mail($myEmail, $subject, $msg, $header);

			//Clear Data After Sending
			$username = '';
			$email = '';
			$mobile = '';
			$msg = '';
		}

		/*
			Explanation for Each Flag:
				1- FILTER_SANITIZE_STRING => to Remove HTML Tags
				2- FILTER_SANITIZE_NUMBER_INT => Removing Everything 
					Except For [Integers, +, -] + it Will be Used if the
					User Entered a Letter by Mistake; the Reg expression 
					Will Take Specific Format
		*/
	}
?>
<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='UTF-8' />
		<meta name='viewport' content='width=device-width, initial-scale=1.0' />

		<title>Contact Form</title>

		<!-- Google Fonts -->
		<link rel='preconnect' href='https://fonts.googleapis.com'>
		<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
		<link href='https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap' rel='stylesheet'>

		<!-- CSS Files -->
		<link rel='stylesheet' href='css/bootstrap.min.css'>
		<link rel='stylesheet' href='css/all.min.css'>
		<link rel='stylesheet' href='css/normalize.css'>
		<link rel='stylesheet' href='css/contact.css'>
	<head>
	<body>
		<div class='container'>
			<form class='contact-form' action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
				<div class="errors-area">
					<?php 
						if(!empty($errors)) {
							echo "<div class='alert alert-danger'>";
							echo "<strong>Errors:</strong><br>";
							foreach($errors as $e){
								echo "--$e.<br>";
							}
							echo "</div>";
							$errors = array();
						}else{
							if ($_SERVER["REQUEST_METHOD"] == "POST") {
							echo "<div class='alert alert-success'>";
							echo "The Message Has Been Sent <strong>Successfully!<strong>";
							echo "</div>";
						}
						}
					?>
				</div>
				<div class="required">
					<input data-goal='username' type='text' name='username' placeholder='Username:' value='<?php if(isset($username)) echo $username;?>' required />
					<div class="alert alert-danger d-none"><strong>Username Must be Between 4 & 500 Letters</strong></div>
				</div>
				<div class="required">
					<input data-goal='email' type='email' name='email' placeholder='Email:' value='<?php if(isset($email)) echo $email;?>' required />
					<div class="alert alert-danger d-none"><strong>Invalid Email</strong></div>
				</div>
				<input data-goal='mobile' type='text' name='mobile' placeholder='Phone Number:' value='<?php if(isset($mobile)) echo $mobile;?>' />
				<div class="alert alert-danger d-none"><strong>Invalid Mobile Phone</strong></div>
				<textarea data-goal='message' name='message' placeholder='Message:'><?php if(isset($message)) echo $message ?></textarea>
				<div class="alert alert-danger d-none"><strong>Message Must be Between 10 & 500 Letters</strong></div>
				<input class='btn btn-success d-block' type='submit' value='Send Message'/>
			</form>
		</div>
		<script src='js/bootstrap.min.js'>
		<script src='js/all.min.js'></script>
		<script src='js/main.js'></script>
	</body>
</html>
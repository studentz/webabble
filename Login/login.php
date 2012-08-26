<?php
require "../InputClass.php";
require "../Sharedfx.php";
session_start();
$mysession = new inputsession();
$myconn = new extmysqli(dbServer, dbUser, dbPassword, dbName);

if (array_key_exists($_POST['login'])) {

		if (!empty($_POST['username'])) {
			$username = $myconn->real_escape_string($_POST['username']);
		} else {
			$username = FALSE;
			echo '<p class="error">You forgot to enter your email address!</p>';
		}
	
	// Validate the password:
		if (!empty($_POST['password'])) {
			$password = $myconn->real_escape_string($_POST['password']);
		} else {
			$password = FALSE;
			echo '<p class="error">You forgot to enter your password!</p>';
		}
	
		if ($username && $password) { // If everything's OK.
	
		// Query the database:
		$sql = "SELECT `IdUser` FROM `users` WHERE (`username`='$username' AND `password`=SHA1('$password') AND active IS TRUE)";
		if (!$result = $myconn->query($sql))  trigger_error("Query: $sql\n<br />MySQL Error: " . $myconn->error);
		
		if (@$result->num_rows == 1) { // A match was made.

			$row = $result->fetch_array(MYSQLI_ASSOC);
			// Register the values & redirect:
			$mysession->set_IdUser( $row["IdUser"]); 
			mysqli_free_result($result);
			
			$result->close();
			$myconn->close();
							
			$url = BASE_URL .'index.php'; // Define the URL:
			/* ob_end_clean(); // Delete the buffer.  */
			header("Location: $url");
			exit(); // Quit the script.
				
		} else { // No match was made.
			echo '<p class="error">Either the email address and password entered do not match those on file or you have not yet activated your account.</p>';
		}
		
	} else { // If everything wasn't OK.
		echo '<p class="error">Please try again.</p>';
	}
	
	

}

if (array_key_exists($_POST['register'])) { // Handle the form.

	
	
	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);
	
	// Assume invalid values:
	$firstname = $lastname = $regemail = $regpasswd = FALSE;
	
	// Check for a first name:
	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $trimmed['first_name'])) {
		$firstname = $myconn->real_escape_string($trimmed['first_name']);
	} else {
		echo '<p class="error">Please enter your first name!</p>';
	}
	
	// Check for a last name:
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['lastname'])) {
		$lastname =$myconn->real_escape_string($trimmed['last_name']);
	} else {
		echo '<p class="error">Please enter your last name!</p>';
	}
	
	// Check for an email address:
	if (preg_match ('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/', $trimmed['regemail'])) {
		$regemail = $myconn->real_escape_string($trimmed['email']);
	} else {
		echo '<p class="error">Please enter a valid email address!</p>';
	}
	

	// Check for a password and match against the confirmed password:
	if (preg_match ('/^\w{4,20}$/', $trimmed['regpasswd']) ) {
		
			$regpasswd = $myconn->real_escape_string ($trimmed['regpasswd']);
		
	} else {
		echo '<p class="error">Please enter a valid password!</p>';
	}
	
	if ($firstname && $lastname && $regemail && $regpasswd) { // If everything's OK...

		// Make sure the email address is available:
		$sql = "SELECT user_id FROM users WHERE email='$regemail'";
		if (!$result = $myconn->query($sql))  trigger_error ("Query: $sql\n<br />MySQL Error: " . $myconn->error);
		
		if (@$result->num_rows == 0) { // Available.
		
			// Create the activation code:
			$a = md5(uniqid(rand(), true));
		
			// Add the user to the database:
			$sql = "INSERT INTO users (IdUser, FirstName,LastName,username,  password, email, active, registrationDate) VALUES ('$regemail', SHA1('$password'), '$fn', '$ln', '$a', NOW() )";
			if (! $result = $myconn->query($sql)) trigger_error("Query: $sql\n<br />MySQL Error: " . $myconn->error);

			if ($myconn->affected_rows == 1) { // If it ran OK.
			
				// Send the email:
				$body = "Thank you for registering at <YOUR SITE NAME>. To activate your account, please click on this link:\n\n";
				$body .= BASE_URL . 'activate.php?x=' . urlencode($regemail) . "&y=$a";
				mail($trimmed['email'], 'Registration Confirmation', $body, 'From: you@youremail.com');
				
				// Finish the page:
				echo '<h3>Thank you for registering! A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.</h3>';
				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.
				
			}
                        else { // If it did not run OK.
				echo '<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
			}
			
		}
                else { // The email address is not available.
			echo '<p class="error">That email address has already been registered. If you have forgotten your password, use the link at right to have your password sent to you.</p>';
		}
		
	}
        else { // If one of the data tests failed.
		echo '<p class="error">Please re-enter your passwords and try again.</p>';
	}

	mysqli_close($dbc);

} // End of the main Submit conditional.

?>

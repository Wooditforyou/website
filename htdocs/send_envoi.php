<?php
if(isset($_POST['email'])) {
    $email_to = "contact@wooditforyou.be";
    $email_subject = "Contact Form";
 
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 
 
    // validation expected data exists
    if(!isset($_POST['name']) || !isset($_POST['message'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 
 		function test_input($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
		} 
		
		$name = $email = $messagz = "";
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		  $name = test_input($_POST["name"]);
		  $email_from = test_input($_POST["email"]);
		  $message = test_input($_POST["message"]);
		}
		

 
 
    $error_message = "";


		if (!filter_var($email_from, FILTER_VALIDATE_EMAIL)) {
		  $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
		}
 
	  if(!preg_match("/^[A-Za-z .'-]+$/",$name)) {
	    $error_message .= 'The Name you entered does not appear to be valid.<br />';
	  }
 
	  if(strlen($message) < 2) {
	    $error_message .= 'The message you entered do not appear to be valid.<br />';
	  }
 
	  if(strlen($error_message) > 0) {
	    died($error_message);
	  }
 
 

    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }  
    $email_message = "Form details below.\n\n";   
    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Message: ".clean_string($message)."\n";
 	
		$mailheader = "From: ".$email_from."\r\n"; 
		$mailheader .= "Reply-To: ".$email_from."\r\n"; 
		$mailheader .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$mailheader .= "X-Mailer: PHP/" . phpversion(); 
		mail($email_to, $email_subject, $email_message, $mailheader) or die ("Failure"); 

		header ("location: index.html?sent#contact");
 		die();
}
?>


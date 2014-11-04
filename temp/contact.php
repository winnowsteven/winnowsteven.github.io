<?php
$to      = "info@winnow-analytics.com";
$subject = "Inquiry";
$body = $_REQUEST["body"];
$name = $_REQUEST["name"];
$email = $_REQUEST["email"];
$phone = $_REQUEST["phone"];
$compname = $_REQUEST["compname"];
$designation = $_REQUEST["designation"];

$text .= "\n\nMy Name Is: " . $name;
$text .= "\n\nMy Phone No is: " . $phone;
$text .= "\n\nMy Designation is: " . $designation;
$text .= "\n\nMy Message Is: " . $body;

$dodgy_strings = array(
                "content-type:"
                ,"mime-version:"
                ,"multipart/mixed"
                ,"bcc:"
);

function is_valid_email($email) {
  return preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $email);
}

function contains_bad_str($str_to_test) {
  $bad_strings = array(
                "content-type:"
                ,"mime-version:"
                ,"multipart/mixed"
		,"Content-Transfer-Encoding:"
                ,"bcc:"
		,"cc:"
		,"to:"
  );
  
  foreach($bad_strings as $bad_string) {
    if(eregi($bad_string, strtolower($str_to_test))) {
      echo "$bad_string found. Suspected injection attempt - mail not being sent.";
      exit;
    }
  }
}

function contains_newlines($str_to_test) {
   if(preg_match("/(%0A|%0D|\\n+|\\r+)/i", $str_to_test) != 0) {
     echo "newline found in $str_to_test. Suspected injection attempt - mail not being sent.";
     exit;
   }
} 

if($_SERVER['REQUEST_METHOD'] != "POST"){
   echo("Unauthorized attempt to access page.");
   exit;
}

if (!is_valid_email($email)) {
header("Location: http://www.winnow-analytics.com/contact_invalidEmail.html?name=".$name."&email=".$email."&company=".$compname."&designation=".$designation."&phone=".$phone."&query=".$body."\"");
//  echo 'Invalid email id. Please hit the back button and try again.';
  exit;
}

contains_bad_str($email);
contains_bad_str($subject);
contains_bad_str(body);

contains_newlines($email);
contains_newlines($subject);

$headers = "From: $email";

mail($to,$subject,$text, $headers);
header("Location: http://www.winnow-analytics.com/thank-you.html");
?>
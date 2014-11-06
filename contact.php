
<?php

// Contact name
$name ="$name"; 

// Mail of sender
$email="$email"; 

// Details
$phone_number="$phone";

// Details
$message="$detail";



// From 
$header="from: $name <$email>";

// Enter your email address
$to ='steven.suting@winnow.in';
$send_contact=mail($to,$name,$phone_number,$message,$header);

// Check, if message sent to your email 
// display message "We've recived your information"
if($send_contact){
echo "We've recived your contact information";
}
else {
echo "ERROR";
}
header("Location: http://www.AnalyticsTraining.Guru");
?>

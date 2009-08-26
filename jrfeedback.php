<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>JRFeedback</title>
</head>
<body>

<p>This page not intended for humans. Thanks for playing, though.</p>

<?php 	
if (array_key_exists('feedback', $_REQUEST)) {
	$feedbackType = $_REQUEST['feedbackType'];
	$appName = $_REQUEST['appName'];
	$appVersion = $_REQUEST['version'];
	
	// if they choose not to give us their email, I will use my own
	// if I left the email blank it would come from 
	// suppressed@auma.pair.com or anonymous@auma.pair.com
	// FogBugz would try to send them an email and generate another 
	// ticket telling me "Undelivered Mail Returned to Sender"
	// TODO: It'd be nice to make sure the string looks like a 
	// real email address but I'll assume everyone is playing nice.
	if ($_REQUEST['email'] != '') {
	    $email = $_REQUEST['email'];
	} else {
        $email = 'feedback_test_noreturnaddressgiven@old-jewel.com';
    }
	$feedback = $_REQUEST['feedback'];
	$bundleID = $_REQUEST['bundleID'];
	$systemProfile = $_REQUEST['systemProfile'];

	if ($_REQUEST['name'] != '') {
	    $senderName = $_REQUEST['name'];
	} else {
        $senderName = '(user chose to not give name)';
    }

	$headers = 'From: ' . $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
	
	$t = date("n\/j\/Y  H:i:s");

	$msg .= "$feedback\n";

	// include user's name in message body
	$msg .= "\n--------\n";
	$msg .= "\nfrom $senderName on $t\n";
	$msg .= "\n--------\n\n";

	$msg .= "Bundle ID: $bundleID\n";
	$msg .= "System Profile: $systemProfile\n";
	
	// include a timestamp in the subject so that each report has a unique subject
	// this way, Mail.app will see each message as the beginning of a new message thread
	// making followup easier
	mail("feedback@old-jewel.com", "[$feedbackType] $appName $appVersion ($t)", $msg, $headers);
}
?>

</body>
</html>

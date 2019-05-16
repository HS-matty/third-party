<?php

/*  
    Feedback 1.0
    Internet International http://www.INTERNETintl.com

    PHPNuke 5, Author Francisco Burzi (fburzi@ncc.org.ve)
    http://www.phpnuke.org/

    php Addon Feedback 1.0 - Copyright (c) 2001 by Jack Kozbial
    http://www.InternetIntl.com
    jack@internetintl.com

    This program is free software. You can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License.
*/

if (!eregi("modules.php", $PHP_SELF)) {
    die ("You can't access this file directly...");
}

/**********************************/
/* Configuration                  */
/*                                */
/* You can change this:           */
/* $index = 0; (right side off)   */
/**********************************/

$index = 1;
$subject = "$sitename Feedback";
$formname = "Feedback Form";

/***********************************************************************************/

include("header.php");

$form_block = "
    <center><font class=\"title\"><b>$sitename: $formname</b></font>
    <br><br><font class=\"content\">All comments and suggestions<br>
    about <b>$sitename</b><br>
    are very welcome and a valuable<br>
    source of information for us. Thanks!</font>
    <FORM METHOD=\"post\" ACTION=\"modules.php?op=modload&amp;name=Feedback&amp;file=index\">
    <P><strong>Your Name:</strong><br>
    <INPUT type=\"text\" NAME=\"sender_name\" VALUE=\"$sender_name\" SIZE=30></p>
    <P><strong>Your E-Mail Address:</strong><br>
    <INPUT type=\"text\" NAME=\"sender_email\"  VALUE=\"$sender_email\" SIZE=30></p>
    <P><strong>Message:</strong><br>
    <TEXTAREA NAME=\"message\" COLS=30 ROWS=5 WRAP=virtual>$message</TEXTAREA></p>
    <INPUT type=\"hidden\" name=\"opi\" value=\"ds\">
    <P><INPUT TYPE=\"submit\" NAME=\"submit\" VALUE=\"Send This Form\"></p>
    </FORM></center>
";

OpenTable();
if ($opi != "ds") {
    echo "$form_block";
} else if ($opi == "ds") {
    if ($sender_name == "") {
	$name_err = "<center><font color=red>Please enter your name!</font></center><br>";
	$send = "no";
    } 
    if ($sender_email == "") {
	$email_err = "<center><font color=red>Please enter your e-mail address!</font></center><br>";
	$send = "no";
    } 
    if ($message == "") {
    	$message_err = "<center><font color=red>Please enter a message!</font></center><br>";
	$send = "no";
    } 
    if ($send != "no") {
	$msg = "$sitename\n";
	$msg .= "Sender's Name:    $sender_name\n";
	$msg .= "Sender's E-Mail:  $sender_email\n";
	$msg .= "Message:          $message\n\n";
	$to = $adminmail;
	$subject = "My Nuke Site Feedback";
	$mailheaders = "From: $nukeurl <> \n";
	$mailheaders .= "Reply-To: $sender_email\n\n";
	mail($to, $subject, $msg, $mailheaders);
	echo "<P><center>Mail has been sent!</center></p>";
	echo "<P><center>Thank you for contacting us</center></p>";
        // echo "<P><center>you can add more text here</center></p>";
    } else if ($send == "no") {
	echo "$name_err";
	echo "$email_err";
	echo "$message_err";
	echo "$form_block";  
    } 
}
CloseTable();   
include("footer.php");

?>
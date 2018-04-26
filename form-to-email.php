<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];
$subject = $_POST['subject'];
//Validate first
if(empty($name)||empty($visitor_email)) 
{
    echo "Name and email are mandatory!";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}
$email_from="akshanshohm1999@gmail.com";
$to = $visitor_email;
$email_subject = "New Form submission";
$email_body = "You have received a new message from the user $name.\n".
    "Here is the message:\n .$message.\n".
$headers =  'MIME-Version: 1.0' . "\r\n"; 
$headers .= 'From:' . "\r\n".$email_from;
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
if(mail($to,$email_subject,$email_body,$headers))
//done. redirect to thank-you page.
{header('Location: thank-you.html');
}
else{
    echo "Connection Error";
}

// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
   
?> 
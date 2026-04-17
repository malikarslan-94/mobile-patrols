<?php
/**
 * Only runs on a host with PHP (e.g. Apache + PHP, or `php -S localhost:8080`).
 * Static dev servers (`npm start`, `serve`, Python http.server) do NOT execute PHP —
 * the browser may download this file instead. The contact form uses FormSubmit for static hosting.
 */

define("RECIPIENT_NAME", "ZSY Security Services");
define("RECIPIENT_EMAIL", "malikarslan.dev@gmail.com");

$success = false;

$userName = isset($_POST['username']) ? preg_replace("/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['username']) : "";
$senderEmail = isset($_POST['email']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email']) : "";
$userPhone = isset($_POST['phone']) ? preg_replace("/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['phone']) : "";
$userSubject = isset($_POST['subject']) ? preg_replace("/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['subject']) : "";
$message = isset($_POST['message']) ? preg_replace("/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message']) : "";

if ($userName && $senderEmail && $userPhone && $userSubject && $message) {
	$to = RECIPIENT_EMAIL;
	$subject = "Contact form: " . $userSubject;

	$msgBody = "Name: " . $userName . "\r\n";
	$msgBody .= "Email: " . $senderEmail . "\r\n";
	$msgBody .= "Phone: " . $userPhone . "\r\n";
	$msgBody .= "Service: " . $userSubject . "\r\n\r\n";
	$msgBody .= "Message:\r\n" . $message . "\r\n";

	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
	$headers .= "From: " . $userName . " <" . $senderEmail . ">\r\n";
	$headers .= "Reply-To: " . $senderEmail . "\r\n";

	$success = mail($to, $subject, $msgBody, $headers);

	header("Location: contact.html?message=Successful");
	exit;
}

header("Location: contact.html?message=Failed");
exit;

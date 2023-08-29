﻿<?php
$siteOwnersEmail = 'manav.kumar2108@gmail.com';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['contactName']);
    $email = trim($_POST['contactEmail']);
    $subject = trim($_POST['contactSubject']);
    $contact_message = trim($_POST['contactMessage']);

    // Initialize error array
    $error = [];

    // Check Name
    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
    }

    // Check Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Please enter a valid email address.";
    }

    // Check Message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Please enter your message. It should have at least 15 characters.";
    }

    // Subject
    if ($subject === '') {
        $subject = "Contact Form Submission";
    }

    // Construct email message
    $message = "Email from: " . $name . "<br />";
    $message .= "Email address: " . $email . "<br />";
    $message .= "Message: <br />";
    $message .= $contact_message;
    $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

    // Set From: header
    $from = $name . " <" . $email . ">";

    // Email Headers
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    if (empty($error)) {
        ini_set("sendmail_from", $siteOwnersEmail);
        $mail = mail($siteOwnersEmail, $subject, $message, $headers);

        if ($mail) {
            echo "OK";
        } else {
            echo "Something went wrong. Please try again.";
        }
    } else {
        $response = implode("<br />\n", $error);
        echo $response;
    }
}
?>

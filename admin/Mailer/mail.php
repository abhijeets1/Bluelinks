<?php
    function sendOTP($receiver_email,$otp) {
        require_once __DIR__.'/vendor/autoload.php';
        require_once __DIR__.'/functions.php';
        require_once __DIR__.'/config.php';
        $mailer = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $sender_email = 'bluelinksservice@gmail.com';
            $sender_name = 'Bluelinks';
            $mailer -> SMTPDebug = CONTACTFORM_PHPMAILER_DEBUG_LEVEL;
            $mailer -> isSMTP();
            $mailer -> Host = CONTACTFORM_SMTP_HOSTNAME;
            $mailer -> SMTPAuth = true;
            $mailer -> Username = CONTACTFORM_SMTP_USERNAME;
            $mailer -> Password = CONTACTFORM_SMTP_PASSWORD;
            $mailer -> SMTPSecure = CONTACTFORM_SMTP_ENCRYPTION;
            $mailer -> Port = CONTACTFORM_SMTP_PORT;
            $mailer -> setFrom($sender_email, $sender_name);
            $mailer -> addAddress($receiver_email);
            $mailer -> addReplyTo($sender_email);
            $mailer -> isHTML(true);
            $mailer -> Subject = 'OTP for Signup Verification';
            $mailer -> Body = '<h1>Bluelinks</h1><h3>Your OTP is : ' . $otp . '</h3>';
            if(!($mailer->send())) {
                return 0;
            } else {
                return 1;
            }
        } catch (Exception $e) {
            redirectWithError("An error occurred while trying to send your message: " . $mailer->ErrorInfo);
        }
    }
?>
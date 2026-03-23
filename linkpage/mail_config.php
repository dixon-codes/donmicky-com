<?php
/**
 * Central mail configuration for Donmicky Real Estate Developers
 * Uses PHPMailer with Gmail SMTP
 *
 * SETUP INSTRUCTIONS:
 * 1. Replace GMAIL_ADDRESS with your Gmail address (e.g. donmicky@gmail.com)
 * 2. For GMAIL_APP_PASSWORD: Go to Google Account → Security → 2-Step Verification → App Passwords
 *    Create an App Password for "Mail" → copy the 16-character code → paste below
 * 3. RECIPIENT_EMAIL is where all form submissions are sent
 */

define('GMAIL_ADDRESS',    'donmicky@gmail.com');       // <-- change to your Gmail
define('GMAIL_APP_PASSWORD', 'xxxx xxxx xxxx xxxx');    // <-- paste your 16-char App Password
define('RECIPIENT_EMAIL',  'info@donmicky.co.tz');       // destination for all form emails

require_once __DIR__ . '/../PHPMailer-6.9.1/src/PHPMailer.php';
require_once __DIR__ . '/../phpmailer/src/SMTP.php';
require_once __DIR__ . '/../phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Send an email via Gmail SMTP.
 *
 * @param string $subject   Email subject
 * @param string $htmlBody  HTML body of the email
 * @param string $replyTo   Reply-to address (sender from the form)
 * @param string $replyName Name of the reply-to person
 * @return bool|string true on success, error string on failure
 */
function sendMail(string $subject, string $htmlBody, string $replyTo = '', string $replyName = ''): bool|string
{
    $mail = new PHPMailer(true);
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = GMAIL_ADDRESS;
        $mail->Password   = GMAIL_APP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender
        $mail->setFrom(GMAIL_ADDRESS, 'Donmicky Real Estate Developers');

        // Recipient
        $mail->addAddress(RECIPIENT_EMAIL, 'Donmicky Real Estate');

        // Reply-To (the person who submitted the form)
        if ($replyTo) {
            $mail->addReplyTo($replyTo, $replyName ?: $replyTo);
        }

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $htmlBody;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return $mail->ErrorInfo;
    }
}

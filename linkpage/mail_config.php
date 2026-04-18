<?php
/**
 * Central mail configuration for Donmicky Real Estate Developers
 * Uses PHPMailer with SiteGround SMTP (your own domain email)
 *
 * SETUP:
 * 1. MAIL_PASSWORD → the password you set for info@donmicky.co.tz in SiteGround cPanel
 * 2. That's it. No Gmail, no App Passwords, nothing else.
 */

define('MAIL_FROM',     'info@donmicky.co.tz');      // the email account in SiteGround cPanel
define('MAIL_PASSWORD', 'Korogwe2023');    // <-- paste the cPanel email password here
define('RECIPIENT_1',   'info@donmicky.co.tz');   // primary recipient
define('RECIPIENT_2',   'donmicklem@gmail.com');    // secondary recipient

require_once __DIR__ . '/../PHPMailer-6.9.1/src/PHPMailer.php';
require_once __DIR__ . '/../phpmailer/src/SMTP.php';
require_once __DIR__ . '/../phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Send an email via SiteGround SMTP.
 *
 * @param string $subject   Email subject
 * @param string $htmlBody  HTML body of the email
 * @param string $replyTo   Reply-to address (the person who submitted the form)
 * @param string $replyName Name of the reply-to person
 * @return bool|string true on success, error string on failure
 */
function sendMail(string $subject, string $htmlBody, string $replyTo = '', string $replyName = ''): bool|string
{
    $mail = new PHPMailer(true);
    try {
        // SiteGround SMTP — uses your own domain mail server
        $mail->isSMTP();
        $mail->Host       = 'mail.donmicky.co.tz';   // SiteGround mail server for your domain
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_FROM;
        $mail->Password   = MAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SiteGround recommends 465/SMTPS
        $mail->Port       = 465;

        // SiteGround shared hosting uses one SSL cert for many domains,
        // which causes a CN mismatch. This disables the verification.
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ],
        ];

        // Sender — shows "Donmicky Real Estate Developers <info@donmicky.co.tz>"
        $mail->setFrom(MAIL_FROM, 'Donmicky Real Estate Developers');

        // Both recipients get every form submission
        $mail->addAddress(RECIPIENT_1, 'Donmicky Real Estate');
        $mail->addAddress(RECIPIENT_2, 'Donmicky (Personal)');

        // Reply-To set to whoever filled the form so you can reply directly to them
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

<?php
/**
 * MAIL DEBUG SCRIPT — DELETE THIS FILE AFTER TESTING
 */

require_once __DIR__ . '/linkpage/form_security.php';

// Load PHPMailer directly here with full debug
require_once __DIR__ . '/PHPMailer-6.9.1/src/PHPMailer.php';
require_once __DIR__ . '/phpmailer/src/SMTP.php';
require_once __DIR__ . '/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

ob_start();

try {
    $mail->isSMTP();
    $mail->SMTPDebug  = 3; // Full debug output
    $mail->Debugoutput = 'echo';

    $mail->Host       = 'mail.donmicky.co.tz';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@donmicky.co.tz';
    $mail->Password   = 'Korogwe2023';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ],
    ];

    $mail->setFrom('info@donmicky.co.tz', 'Donmicky Real Estate Developers');
    $mail->addAddress('dixomium@gmail.com', 'Test');
    $mail->isHTML(true);
    $mail->Subject = 'Debug Test';
    $mail->Body    = '<p>Debug test email</p>';

    $mail->send();
    $debug = ob_get_clean();
    echo '<div style="font-family:monospace;padding:20px;background:#f0fff0;border:2px solid green;">
            <h2 style="color:green;">✅ Sent!</h2>
            <pre>' . htmlspecialchars($debug) . '</pre>
          </div>';

} catch (Exception $e) {
    $debug = ob_get_clean();
    echo '<div style="font-family:monospace;padding:20px;background:#fff0f0;border:2px solid red;">
            <h2 style="color:red;">❌ Failed: ' . htmlspecialchars($mail->ErrorInfo) . '</h2>
            <h3>Full SMTP log:</h3>
            <pre style="font-size:12px;white-space:pre-wrap;">' . htmlspecialchars($debug) . '</pre>
          </div>';
}

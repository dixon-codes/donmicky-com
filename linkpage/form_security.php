<?php
/**
 * form_security.php – Shared form protection for Donmicky Real Estate
 *
 * Provides:
 *  - CSRF token generation & verification
 *  - Honeypot bot detection
 *  - Session-based rate limiting (max 5 POSTs per form per hour per client)
 *  - Input sanitization helpers
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ──────────────────────────────────────────────────────────────
// CSRF TOKEN
// ──────────────────────────────────────────────────────────────

/**
 * Generate (or reuse) a CSRF token stored in the session.
 * @return string 64-char hex token
 */
function csrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Output a hidden CSRF input field.
 */
function csrfField(): string {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrfToken(), ENT_QUOTES) . '" />';
}

/**
 * Verify the submitted CSRF token.
 * Returns true if valid, false otherwise.
 */
function verifyCsrf(): bool {
    $submitted = $_POST['csrf_token'] ?? '';
    $stored    = $_SESSION['csrf_token'] ?? '';
    if (!$submitted || !$stored) return false;
    return hash_equals($stored, $submitted);
}

// ──────────────────────────────────────────────────────────────
// HONEYPOT BOT DETECTION
// ──────────────────────────────────────────────────────────────

/**
 * Output a honeypot field (hidden from humans via CSS, bots fill it).
 */
function honeypotField(): string {
    return '
    <div style="position:absolute;left:-9999px;top:-9999px;opacity:0;height:0;overflow:hidden;" aria-hidden="true" tabindex="-1">
        <label>Leave this blank <input type="text" name="website_url" value="" autocomplete="off" tabindex="-1" /></label>
    </div>';
}

/**
 * Returns true if the honeypot was filled (i.e. a bot submission).
 */
function isHoneypotTripped(): bool {
    return !empty($_POST['website_url']);
}

// ──────────────────────────────────────────────────────────────
// RATE LIMITING  (session-based, per form key)
// ──────────────────────────────────────────────────────────────

define('RATE_LIMIT_MAX',    5);     // max submissions
define('RATE_LIMIT_WINDOW', 3600);  // per hour (seconds)

/**
 * Check whether the current client has exceeded the rate limit for $formKey.
 * Call BEFORE processing the form.  Returns true if limit exceeded.
 */
function isRateLimited(string $formKey): bool {
    $now = time();
    $key = 'rl_' . $formKey;

    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = ['count' => 0, 'window_start' => $now];
    }

    $data = &$_SESSION[$key];

    // Reset window if expired
    if ($now - $data['window_start'] > RATE_LIMIT_WINDOW) {
        $data = ['count' => 0, 'window_start' => $now];
    }

    if ($data['count'] >= RATE_LIMIT_MAX) {
        return true;  // blocked
    }

    $data['count']++;
    return false;
}

// ──────────────────────────────────────────────────────────────
// INPUT SANITIZATION
// ──────────────────────────────────────────────────────────────

/**
 * Sanitize a plain text field: strip tags, trim whitespace, cap length.
 */
function sanitizeText(string $value, int $maxLen = 200): string {
    $value = strip_tags($value);
    $value = trim($value);
    $value = mb_substr($value, 0, $maxLen);
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Sanitize a full name field: letters, spaces, hyphens, apostrophes only.
 * Supports Latin-extended characters (Swahili, French, etc.).
 */
function sanitizeName(string $value): string {
    $value = trim($value);
    // Keep letters (incl. accented), spaces, hyphens, apostrophes
    $value = preg_replace("/[^\p{L}\s'\-]/u", '', $value);
    $value = trim(preg_replace('/\s{2,}/', ' ', $value)); // collapse multiple spaces
    $value = mb_substr($value, 0, 100);
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Sanitize and validate an email address.
 * Returns the sanitized email or empty string if invalid.
 */
function sanitizeEmail(string $value): string {
    $value = trim($value);
    $value = filter_var($value, FILTER_SANITIZE_EMAIL);
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return '';
    }
    if (mb_strlen($value) > 254) return '';
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Sanitize a phone number: allow digits, spaces, +, -, (, ) only.
 */
function sanitizePhone(string $value): string {
    $value = trim($value);
    $value = preg_replace('/[^0-9+\-()\s]/', '', $value);
    $value = mb_substr($value, 0, 30);
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Sanitize a multi-line message / description.
 */
function sanitizeMessage(string $value, int $maxLen = 2000): string {
    $value = strip_tags($value);
    $value = trim($value);
    $value = mb_substr($value, 0, $maxLen);
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

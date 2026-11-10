<?php
/**
 * The Detective's Desk — University Clone Project
 * config.php — site configuration, session bootstrap & small helpers
 */

declare(strict_types=1);

// ---- Session -------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ---- Paths ----------------------------------------------------------------
define('ROOT_DIR', dirname(__DIR__));
define('DATA_DIR', ROOT_DIR . '/data');
define('USERS_FILE', DATA_DIR . '/users.json');
define('SCORES_FILE', DATA_DIR . '/scores.json');

// ---- Site -----------------------------------------------------------------
define('SITE_NAME', "The Detective's Desk");
define('SITE_TAGLINE', 'The online detective game with a new murder mystery every day.');

date_default_timezone_set('Asia/Dhaka');

// ---- JSON file helpers (used as a tiny database) ---------------------------
function json_read(string $file, array $fallback = []): array
{
    if (!is_file($file)) {
        return $fallback;
    }
    $fp = fopen($file, 'r');
    if (!$fp) {
        return $fallback;
    }
    flock($fp, LOCK_SH);
    $raw  = stream_get_contents($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    $data = json_decode((string) $raw, true);
    return is_array($data) ? $data : $fallback;
}

function json_write(string $file, array $data): bool
{
    if (!is_dir(dirname($file))) {
        mkdir(dirname($file), 0775, true);
    }
    $fp = fopen($file, 'c+');
    if (!$fp) {
        return false;
    }
    flock($fp, LOCK_EX);
    ftruncate($fp, 0);
    fwrite($fp, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    return true;
}

// ---- View helpers ----------------------------------------------------------
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    // Keeps links working both from the web root and a sub-folder such as /detekts-clone/
    $base = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/\\');
    if ($base === '/' || $base === '\\') {
        $base = '';
    }
    // When the current script sits in /api we must go one level up.
    if (str_contains($base, '/api')) {
        $base = substr($base, 0, strrpos($base, '/api'));
    }
    return $base . '/' . ltrim($path, '/');
}

function redirect(string $path): never
{
    header('Location: ' . url($path));
    exit;
}

// Current signed-in detective (null = guest)
function current_user(): ?array
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }
    static $cached = null;
    if ($cached !== null && $cached['id'] === $_SESSION['user_id']) {
        return $cached;
    }
    foreach (json_read(USERS_FILE) as $u) {
        if (($u['id'] ?? null) === $_SESSION['user_id']) {
            unset($u['password']);
            $cached = $u;
            return $cached;
        }
    }
    return null;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_check(?string $token): bool
{
    return is_string($token) && hash_equals($_SESSION['csrf'] ?? '', $token);
}

// Deterministic "detectives on today's case" number for the hero badge
function detectives_today(): int
{
    $users   = count(json_read(USERS_FILE));
    $scores  = count(json_read(SCORES_FILE));
    $daySeed = (int) date('zn'); // changes daily
    return 21 + $users * 3 + $scores + ($daySeed % 17);
}

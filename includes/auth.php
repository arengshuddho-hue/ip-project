<?php
/**
 * auth.php — detective accounts: register, sign in, sign out.
 * Accounts are stored in data/users.json (a tiny JSON "database").
 */

require_once __DIR__ . '/config.php';

function users_all(): array
{
    return json_read(USERS_FILE, []);
}

function users_save(array $users): void
{
    json_write(USERS_FILE, $users);
}

function find_user_by_email(string $email): ?array
{
    $email = strtolower(trim($email));
    foreach (users_all() as $u) {
        if (strcasecmp((string) ($u['email'] ?? ''), $email) === 0) {
            return $u;
        }
    }
    return null;
}

function register_user(string $name, string $email, string $password): array
{
    $errors = [];
    $name  = trim($name);
    $email = strtolower(trim($email));

    if (mb_strlen($name) < 2 || mb_strlen($name) > 40) {
        $errors[] = 'Badge name must be 2–40 characters.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }
    if (!$errors && find_user_by_email($email)) {
        $errors[] = 'That email already carries a badge. Try signing in.';
    }
    if ($errors) {
        return ['ok' => false, 'errors' => $errors];
    }

    $users = users_all();
    $user  = [
        'id'        => 'det_' . bin2hex(random_bytes(8)),
        'name'      => $name,
        'email'     => $email,
        'password'  => password_hash($password, PASSWORD_DEFAULT),
        'joined'    => date('Y-m-d H:i:s'),
        'streak'    => 0,
        'points'    => 0,
    ];
    $users[] = $user;
    users_save($users);

    unset($user['password']);
    return ['ok' => true, 'user' => $user];
}

function login_user(string $email, string $password): array
{
    $user = find_user_by_email($email);
    if (!$user || !password_verify($password, (string) ($user['password'] ?? ''))) {
        return ['ok' => false, 'errors' => ['Wrong email or password. The precinct checked twice.']];
    }
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    return ['ok' => true, 'user' => $user];
}

function logout_user(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}

// ---- Scores / standings ----------------------------------------------------
function record_score(string $userId, string $userName, int $score, string $caseTitle, bool $correct): void
{
    $scores = json_read(SCORES_FILE, []);
    $scores[] = [
        'user_id'   => $userId,
        'user'      => $userName,
        'score'     => $score,
        'case'      => $caseTitle,
        'verdict'   => $correct ? 'correct' : 'wrong',
        'played_at' => date('Y-m-d H:i:s'),
    ];
    json_write(SCORES_FILE, $scores);
}

function standings_top(int $limit = 10): array
{
    $scores = json_read(SCORES_FILE, []);
    $best = [];
    foreach ($scores as $s) {
        $id = $s['user_id'] ?? 'guest';
        if (!isset($best[$id]) || $best[$id]['score'] < $s['score']) {
            $best[$id] = $s;
        }
    }
    usort($best, fn($a, $b) => $b['score'] <=> $a['score']);
    return array_slice(array_values($best), 0, $limit);
}

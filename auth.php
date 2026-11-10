<?php
/**
 * auth.php — detective sign-in / create account (PHP sessions)
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

$user = current_user();
$errors = [];
$notice = '';
$mode = ($_POST['mode'] ?? $_GET['mode'] ?? 'signin') === 'register' ? 'register' : 'signin';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !csrf_check($_POST['csrf'] ?? null)) {
    http_response_code(403);
    exit('Bad token — refresh the page.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($user)) {
    if (($_POST['action'] ?? '') === 'logout') {
        logout_user();
        redirect('index.php');
    }

    $mode = ($_POST['mode'] ?? 'signin') === 'register' ? 'register' : 'signin';
    if ($mode === 'register') {
        $res = register_user((string) ($_POST['name'] ?? ''), (string) ($_POST['email'] ?? ''), (string) ($_POST['password'] ?? ''));
        if ($res['ok']) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $res['user']['id'];
            redirect('case.php');
        }
        $errors = $res['errors'];
    } else {
        $res = login_user((string) ($_POST['email'] ?? ''), (string) ($_POST['password'] ?? ''));
        if ($res['ok']) {
            redirect('case.php');
        }
        $errors = $res['errors'];
    }
}

$page_title = "Detective sign-in — " . SITE_NAME;
$body_class = 'page-auth';
require __DIR__ . '/includes/header.php';
?>
<main class="auth-shell">
  <?php if ($user): ?>
  <div class="auth-card paper">
    <h1 class="auth-title"><svg class="ic accent-ic"><use href="#i-user"/></svg> Your badge</h1>
    <p class="auth-copy mono">Signed in as <strong><?= e($user['name']) ?></strong><br><?= e($user['email']) ?></p>
    <div class="badge-stats">
      <div class="badge-stat"><span class="mono"><?= count(array_filter(json_read(SCORES_FILE, []), fn($s) => ($s['user_id'] ?? '') === $user['id'])) ?></span><span class="type-sm">cases closed</span></div>
      <div class="badge-stat"><span class="mono">—</span><span class="type-sm">current streak</span></div>
    </div>
    <p class="auth-copy type-sm">Your evidence, corkboard and verdicts are saved to your badge while you investigate.</p>
    <form method="post" action="<?= e(url('auth.php')) ?>">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <input type="hidden" name="action" value="logout">
      <button class="btn btn-dark full" type="submit">Hand in your badge (sign out)</button>
    </form>
    <a class="type-sm auth-link" href="<?= e(url('case.php')) ?>">Back to the desk</a>
  </div>
  <?php else: ?>
  <div class="auth-card paper">
    <h1 class="auth-title"><svg class="ic accent-ic"><use href="#i-user"/></svg> <?= $mode === 'register' ? 'Join the precinct' : 'Sign in to Detekts' ?></h1>
    <p class="auth-copy mono">Needed for interviews. Your corkboard, notepad and discovered clues are saved to your badge and restored the next time you sit down.</p>

    <?php if ($errors): ?>
    <ul class="auth-errors">
      <?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <form method="post" action="<?= e(url('auth.php')) ?>" novalidate>
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <input type="hidden" name="mode" value="<?= e($mode) ?>">

      <?php if ($mode === 'register'): ?>
      <label class="field">
        <span class="field-label">Badge name</span>
        <input type="text" name="name" required maxlength="40" placeholder="e.g. Det. Rahman" value="<?= e($_POST['name'] ?? '') ?>">
      </label>
      <?php endif; ?>

      <label class="field">
        <span class="field-label">Email</span>
        <input type="email" name="email" required placeholder="detective@precinct.example" value="<?= e($_POST['email'] ?? '') ?>">
      </label>

      <label class="field">
        <span class="field-label">Password</span>
        <span class="field-pass">
          <input type="password" name="password" required minlength="6" placeholder="••••••••">
        </span>
      </label>

      <button class="btn btn-open full" type="submit"><?= $mode === 'register' ? 'Create account' : 'Sign in' ?></button>
    </form>

    <div class="or-row"><span></span>or<span></span></div>
    <button class="btn btn-dark full" type="button" title="Demo project: Google sign-in is not connected">Continue with Google</button>

    <div class="auth-foot">
      <?php if ($mode === 'register'): ?>
        <a class="type-sm auth-link" href="<?= e(url('auth.php')) ?>">Already have a badge? Sign in</a>
      <?php else: ?>
        <a class="type-sm auth-link" href="<?= e(url('auth.php?mode=register')) ?>">Create an account</a>
      <?php endif; ?>
      <a class="type-sm auth-link" href="<?= e(url('index.php')) ?>">Back to the desk</a>
    </div>
  </div>
  <?php endif; ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

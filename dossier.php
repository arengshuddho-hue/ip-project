<?php
/**
 * case.php?dossier=N — read-only dossier for archived (cold) cases.
 * Rendered inside the same file to keep the project small.
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/auth.php';

$num = (int) ($_GET['dossier'] ?? 0);
$case = ARCHIVE_CASES[$num] ?? null;
$user = current_user();

// today's case is playable — send detectives straight to the desk
if ($case && !empty($case['today'])) {
    redirect('case.php');
}

$page_title = ($case ? "Case #{$num}: {$case['title']}" : 'Unknown case') . ' — ' . SITE_NAME;
$body_class = 'page-sub';
require __DIR__ . '/includes/header.php';
?>
<main class="sub-page narrow">
  <a class="btn btn-ghost btn-back" href="<?= e(url('archive.php')) ?>"><svg class="ic"><use href="#i-back"/></svg> Case archive</a>

  <?php if ($case): ?>
  <div class="case-file paper dossier">
    <div class="brief-head">
      <div>
        <p class="case-no type-sm">Case #<?= $num ?></p>
        <h1 class="case-title"><?= e($case['title']) ?></h1>
      </div>
      <span class="stamp">COLD CASE</span>
    </div>
    <div class="brief-facts mono">
      <p><span class="fact-label">Filed</span> <strong><?= e($case['date']) ?></strong> <span class="fact-label">Precinct avg.</span> <strong><?= e($case['avg']) ?></strong></p>
    </div>
    <?php if (!empty($case['summary'])): ?><p class="brief-intro"><?= e($case['summary']) ?></p><?php endif; ?>
    <p class="dossier-note">The full evidence locker for this case is available to registered detectives from the archive terminal. <?= $user ? '' : '<a class="tlink" href="' . e(url('auth.php')) . '">Sign in</a> to request the file.' ?></p>
    <div class="dossier-people">
      <img class="polaroid" src="<?= e(url('assets/img/' . $case['img'])) ?>" alt="">
      <div>
        <p class="type-sm victim-head">File thumbnail</p>
        <p class="type-sm muted">Cold-case dossiers keep a single evidence photograph on record. The interactive scenes are retired after the precinct closes the review window.</p>
      </div>
    </div>
  </div>
  <?php else: ?>
  <div class="case-file paper">
    <h1 class="case-title">Case not on record</h1>
    <p class="brief-intro">The precinct has no file under that number. Check the <a class="tlink" href="<?= e(url('archive.php')) ?>">case archive</a>.</p>
  </div>
  <?php endif; ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

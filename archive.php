<?php
/**
 * archive.php — the cold-case archive (20 cases on record)
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/auth.php';

$user = current_user();
$filter = $_GET['filter'] ?? 'all'; // all | mine
$mine = [];
if ($user) {
    foreach (json_read(SCORES_FILE, []) as $s) {
        if (($s['user_id'] ?? '') === $user['id']) {
            $mine[$s['case']] = $s;
        }
    }
}

$page_title = "Case archive — " . SITE_NAME;
$body_class = 'page-sub';
require __DIR__ . '/includes/header.php';
?>
<main class="sub-page">
  <a class="btn btn-ghost btn-back" href="<?= e(url('index.php')) ?>"><svg class="ic"><use href="#i-back"/></svg> Back to the desk</a>
  <div class="sub-head split-head">
    <div>
      <p class="kicker type-sm accent">The Detective's Desk</p>
      <h1 class="h2 left">Case archive</h1>
      <p class="mono muted"><?= count(ARCHIVE_CASES) ?> cases on record · <?= $user ? 'your verdicts are marked below' : 'sign in to track your verdicts' ?></p>
    </div>
    <nav class="sub-links">
      <a href="<?= e(url('standings.php')) ?>">Standings</a>
      <a href="<?= e(url('auth.php')) ?>"><?= $user ? 'Your badge' : 'Your badge' ?></a>
    </nav>
  </div>

  <div class="filter-tabs">
    <a class="filter<?= $filter !== 'mine' ? ' is-active' : '' ?>" href="<?= e(url('archive.php?filter=all')) ?>">All cases</a>
    <a class="filter<?= $filter === 'mine' ? ' is-active' : '' ?>" href="<?= e(url('archive.php?filter=mine')) ?>">My accusations</a>
  </div>

  <div class="archive-list">
    <?php foreach (ARCHIVE_CASES as $num => $case): ?>
      <?php if ($filter === 'mine' && !isset($mine[$case['title']])) continue; ?>
      <article class="archive-card paper">
        <img class="archive-photo" src="<?= e(url('assets/img/' . $case['img'])) ?>" alt="">
        <div class="archive-body">
          <p class="archive-meta mono">
            Case #<?= $num ?>
            <?php if (!empty($case['today'])): ?><span class="stamp small">Today's case</span><span class="playing">● Playing now</span><?php endif; ?>
            <?php if (empty($case['today'])): ?> Filed <?= e($case['date']) ?><?php endif; ?>
            <?php if (!empty($case['today'])): ?> · detectives avg. <?= e($case['avg']) ?><?php endif; ?>
          </p>
          <h2 class="archive-title type-h3"><?= e($case['title']) ?></h2>
          <?php if (!empty($case['summary'])): ?><p class="archive-sum"><?= e($case['summary']) ?></p><?php endif; ?>
          <?php if (isset($mine[$case['title']])): ?>
            <p class="archive-verdict mono">Your verdict: <?= (int) $mine[$case['title']]['score'] ?> pts · <?= e($mine[$case['title']]['verdict']) ?></p>
          <?php elseif (empty($case['today'])): ?><p class="archive-sign type-sm">Sign in to record a verdict</p><?php endif; ?>
        </div>
        <div class="archive-actions">
          <a class="type-sm dossier-link" href="<?= e(url('case.php?dossier=' . $num)) ?>">Dossier</a>
          <?php if (!empty($case['today'])): ?>
            <a class="btn btn-open" href="<?= e(url('case.php')) ?>"><svg class="ic"><use href="#i-folder"/></svg> Open case</a>
          <?php else: ?>
            <a class="btn btn-open" href="<?= e(url('case.php?dossier=' . $num)) ?>"><svg class="ic"><use href="#i-folder"/></svg> Open case</a>
          <?php endif; ?>
        </div>
      </article>
    <?php endforeach; ?>
    <?php if ($filter === 'mine'): ?>
      <?php if (!$user): ?><p class="empty-note">You are browsing as a guest. <a class="tlink" href="<?= e(url('auth.php')) ?>">Sign in</a> to record verdicts.</p>
      <?php elseif (!$mine): ?><p class="empty-note">No accusations on record yet. <a class="tlink" href="<?= e(url('case.php')) ?>">Open today's case</a> to close your first one.</p><?php endif; ?>
    <?php endif; ?>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

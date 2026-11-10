<?php
/**
 * standings.php — precinct leaderboard (best score per detective)
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

$user = current_user();
$top = standings_top(12);

$page_title = "Precinct standings — " . SITE_NAME;
$body_class = 'page-sub';
require __DIR__ . '/includes/header.php';
?>
<main class="sub-page narrow">
  <a class="btn btn-ghost btn-back" href="<?= e(url('archive.php')) ?>"><svg class="ic"><use href="#i-back"/></svg> Case archive</a>
  <div class="head-center">
    <p class="kicker type-sm accent">Precinct</p>
    <h1 class="h2">Standings</h1>
    <p class="lead center">Best closed case per detective. Solve today's case and claim your spot.</p>
  </div>

  <?php if (!$top): ?>
  <div class="case-file paper">
    <p class="empty-note">No verdicts on the board yet. <a class="tlink" href="<?= e(url('case.php')) ?>">Open today's case</a> and be the first name on it.</p>
  </div>
  <?php else: ?>
  <div class="case-file paper standings">
    <table class="stand-table">
      <thead>
        <tr><th class="mono">#</th><th>Detective</th><th>Case</th><th class="mono right">Score</th><th>Verdict</th></tr>
      </thead>
      <tbody>
        <?php foreach ($top as $i => $row): ?>
        <tr class="<?= ($user && ($row['user_id'] ?? '') === $user['id']) ? 'is-you' : '' ?>">
          <td class="mono"><?= $i + 1 ?></td>
          <td><?= e($row['user'] ?? 'Detective') ?><?= ($user && ($row['user_id'] ?? '') === $user['id']) ? ' <span class="you-tag type-sm">you</span>' : '' ?></td>
          <td class="stand-case"><?= e($row['case'] ?? '') ?></td>
          <td class="mono right"><?= (int) $row['score'] ?></td>
          <td><span class="pill <?= ($row['verdict'] ?? '') === 'correct' ? 'pill-ok' : 'pill-no' ?> type-sm"><?= e($row['verdict'] ?? '—') ?></span></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

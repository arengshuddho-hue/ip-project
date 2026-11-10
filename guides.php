<?php
/**
 * guides.php — the field manual index
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';

$page_title = "How to Solve a Case: Detective Game Guides & Tips";
$body_class = 'page-sub';
require __DIR__ . '/includes/header.php';
?>
<main class="sub-page">
  <a class="btn btn-ghost btn-back" href="<?= e(url('index.php')) ?>"><svg class="ic"><use href="#i-back"/></svg> Back to the desk</a>
  <div class="head-center">
    <p class="kicker type-sm accent">Field Manual</p>
    <h1 class="h2">How to solve a case</h1>
    <p class="lead center">Everything a new detective needs: the order of an investigation, how to run an interrogation, how to read an evidence corkboard, and how daily scores are earned.</p>
  </div>

  <div class="guides-list">
    <?php foreach (GUIDES as $g): ?>
    <article class="paper-card guide-card rot<?= array_search($g, GUIDES, true) % 3 ?>">
      <p class="type-sm guide-meta"><?= e($g['tag']) ?> · <?= e($g['read']) ?></p>
      <h2 class="type-h3 guide-title"><a href="<?= e(url('guide.php?slug=' . urlencode($g['slug']))) ?>"><?= e($g['title']) ?></a></h2>
      <p><?= e($g['desc']) ?></p>
      <a class="type-sm guide-link" href="<?= e(url('guide.php?slug=' . urlencode($g['slug']))) ?>"><svg class="ic"><use href="#i-dossier"/></svg> Read the guide <svg class="ic"><use href="#i-arrow"/></svg></a>
    </article>
    <?php endforeach; ?>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

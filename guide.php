<?php
/**
 * guide.php — a single field-manual article
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';

$slug = (string) ($_GET['slug'] ?? '');
$guide = null;
foreach (GUIDES as $g) {
    if ($g['slug'] === $slug) {
        $guide = $g;
        break;
    }
}

$page_title = ($guide['title'] ?? 'Guide not found') . ' — ' . SITE_NAME;
$body_class = 'page-sub';
require __DIR__ . '/includes/header.php';
?>
<main class="sub-page narrow">
  <a class="btn btn-ghost btn-back" href="<?= e(url('guides.php')) ?>"><svg class="ic"><use href="#i-back"/></svg> Field manual</a>
  <?php if ($guide): ?>
  <article class="case-file paper article">
    <p class="type-sm guide-meta"><?= e($guide['tag']) ?> · <?= e($guide['read']) ?></p>
    <h1 class="case-title"><?= e($guide['title']) ?></h1>
    <div class="article-body">
      <?php foreach ($guide['body'] as $part): ?>
        <h2><?= e($part['h']) ?></h2>
        <p><?= e($part['p']) ?></p>
      <?php endforeach; ?>
    </div>
    <div class="article-foot">
      <a class="btn btn-red" href="<?= e(url('case.php')) ?>">Try it on today's case</a>
    </div>
  </article>
  <?php else: ?>
  <div class="case-file paper">
    <h1 class="case-title">Guide not found</h1>
    <p class="brief-intro">That page is not in the manual. Back to the <a class="tlink" href="<?= e(url('guides.php')) ?>">field manual</a>.</p>
  </div>
  <?php endif; ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

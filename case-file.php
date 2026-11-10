<?php
/**
 * case-file.php — a single records-room article
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';

$slug = (string) ($_GET['slug'] ?? '');
$file = null;
foreach (CASE_FILES as $f) {
    if ($f['slug'] === $slug) {
        $file = $f;
        break;
    }
}

$page_title = ($file['title'] ?? 'File not found') . ' — ' . SITE_NAME;
$body_class = 'page-sub';
require __DIR__ . '/includes/header.php';
?>
<main class="sub-page narrow">
  <a class="btn btn-ghost btn-back" href="<?= e(url('case-files.php')) ?>"><svg class="ic"><use href="#i-back"/></svg> Records room</a>
  <?php if ($file): ?>
  <article class="case-file paper article">
    <div class="file-media article-media">
      <img src="<?= e(url($file['img'])) ?>" alt="<?= e($file['title']) ?>">
      <?php if (!empty($file['latest'])): ?><span class="stamp stamp-media">Latest</span><?php endif; ?>
    </div>
    <p class="type-sm guide-meta"><?= e($file['tag']) ?> · <?= e($file['read']) ?></p>
    <h1 class="case-title"><?= e($file['title']) ?></h1>
    <div class="article-body">
      <?php foreach ($file['body'] as $part): ?>
        <h2><?= e($part['h']) ?></h2>
        <p><?= e($part['p']) ?></p>
      <?php endforeach; ?>
    </div>
    <div class="article-foot">
      <a class="btn btn-outline" href="<?= e(url('case.php')) ?>">Work a case of your own <svg class="ic"><use href="#i-arrow"/></svg></a>
    </div>
  </article>
  <?php else: ?>
  <div class="case-file paper">
    <h1 class="case-title">File not found</h1>
    <p class="brief-intro">That file is not in the records room. Back to <a class="tlink" href="<?= e(url('case-files.php')) ?>">The Case Files</a>.</p>
  </div>
  <?php endif; ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

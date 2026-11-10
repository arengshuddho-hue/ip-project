<?php
/**
 * case-files.php — the records room (real case studies)
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';

$page_title = "The Case Files — Real Investigations & the Evidence That Solved Them";
$body_class = 'page-sub';
require __DIR__ . '/includes/header.php';
?>
<main class="sub-page narrow-wide">
  <a class="btn btn-ghost btn-back" href="<?= e(url('index.php')) ?>"><svg class="ic"><use href="#i-back"/></svg> Back to the desk</a>
  <div class="head-center">
    <p class="kicker type-sm accent">Records Room</p>
    <h1 class="h2">The Case Files: Real Criminal Investigations and Forensic Evidence</h1>
    <p class="lead center">Real investigations, forensic breakthroughs, and the evidence that solved them.</p>
  </div>

  <div class="files-list">
    <?php foreach (CASE_FILES as $file): ?>
    <article class="file-card big">
      <div class="file-media">
        <img src="<?= e(url($file['img'])) ?>" alt="<?= e($file['title']) ?>" loading="lazy">
        <?php if (!empty($file['latest'])): ?><span class="stamp stamp-media">Latest</span><?php endif; ?>
      </div>
      <div class="file-body">
        <p class="file-meta type-sm"><?= e($file['tag']) ?> · <?= e($file['read']) ?></p>
        <h2 class="type-h3 file-title"><a href="<?= e(url('case-file.php?slug=' . urlencode($file['slug']))) ?>"><?= e($file['title']) ?></a></h2>
        <p class="file-desc"><?= e($file['desc']) ?></p>
        <a class="type-sm file-link" href="<?= e(url('case-file.php?slug=' . urlencode($file['slug']))) ?>"><svg class="ic"><use href="#i-folder"/></svg> Open the file <svg class="ic"><use href="#i-arrow"/></svg></a>
      </div>
    </article>
    <?php endforeach; ?>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

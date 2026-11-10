<?php
/**
 * index.php — the desk (landing page)
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';

$page_title = "Online Detective Game - A New Murder Mystery Every Day";
$body_class = 'page-home';
require __DIR__ . '/includes/header.php';
?>

<!-- ============ HERO ============ -->
<section class="hero" id="top">
  <div class="hero-bg" role="presentation"></div>
  <div class="hero-veil" role="presentation"></div>
  <div class="wrap hero-inner">
    <p class="hero-brand type-sm">The Detective's Desk</p>
    <h1 class="hero-title">The online detective game with a new murder mystery every&nbsp;day.</h1>
    <p class="hero-sub">A free browser detective game: work the crime scene, question the suspects, and string the clues together on your corkboard. Close the case before the precinct clock runs out.</p>
    <p class="hero-live"><svg class="ic"><use href="#i-people"/></svg> <?= detectives_today() ?> detectives on today's case</p>
    <div class="hero-cta">
      <a class="btn btn-primary" href="<?= e(url('case.php')) ?>">Open today's case</a>
      <a class="btn btn-ghost" href="<?= e(url('archive.php')) ?>">Browse cold cases</a>
    </div>
  </div>
  <a class="hero-scroll" href="#manual" aria-label="Scroll down"><svg class="ic"><use href="#i-chev-down"/></svg></a>
  <p class="hero-next type-sm">Field Manual</p>
</section>

<!-- ============ HOW A CASE IS CLOSED ============ -->
<section class="section section-dark" id="manual">
  <div class="wrap">
    <p class="kicker center type-sm">Field Manual</p>
    <h2 class="h2 center">How a case is closed</h2>
    <p class="lead center">New to the job? The <a class="tlink" href="<?= e(url('guides.php')) ?>">detective field manual</a> walks through how to play a murder mystery game, how to solve a case step by step, and how to run an interrogation. Curious how real crimes were cracked? Browse <a class="tlink" href="<?= e(url('case-files.php')) ?>">The Case Files</a>.</p>

    <div class="steps-grid">
      <?php foreach (STEPS as $i => $step): ?>
      <article class="paper-card step-card rot<?= $i % 4 ?>">
        <span class="step-num"><?= $i + 1 ?></span>
        <svg class="step-ic"><use href="#i-<?= e($step['icon']) ?>"/></svg>
        <h3 class="type-h3"><?= e($step['title']) ?></h3>
        <p><?= e($step['text']) ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ TOOLS OF THE TRADE ============ -->
<section class="section section-stripe">
  <div class="wrap">
    <p class="kicker center type-sm accent">Equipment</p>
    <h2 class="h2 center">Tools of the trade</h2>
    <p class="lead center">Everything a detective needs to crack a daily crime case mystery — from the crime-scene photos to the final accusation.</p>

    <div class="tools-grid">
      <?php foreach (TOOLS as $tool): ?>
      <article class="tool-card">
        <span class="tool-ic"><svg class="ic"><use href="#i-<?= e($tool['icon']) ?>"/></svg></span>
        <h3 class="type-h3"><?= e($tool['title']) ?></h3>
        <p><?= e($tool['text']) ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ THE REAL CASE FILES ============ -->
<section class="section section-dark">
  <div class="wrap">
    <div class="split-head">
      <div>
        <p class="kicker type-sm red">Records Room</p>
        <h2 class="h2 left">The Real Case Files</h2>
        <p class="lead">Real investigations taken apart clue by clue: the anomaly at the scene, the alibi that broke, and the evidence that ended the argument.</p>
      </div>
      <a class="btn btn-outline" href="<?= e(url('case-files.php')) ?>">Browse the records room <svg class="ic"><use href="#i-arrow"/></svg></a>
    </div>

    <div class="files-grid">
      <?php foreach (array_slice(CASE_FILES, 0, 2) as $file): ?>
      <article class="file-card">
        <div class="file-media">
          <img src="<?= e(url($file['img'])) ?>" alt="<?= e($file['title']) ?>" loading="lazy">
          <?php if (!empty($file['latest'])): ?><span class="stamp stamp-media">Latest</span><?php endif; ?>
        </div>
        <div class="file-body">
          <p class="file-meta type-sm"><?= e($file['tag']) ?> · <?= e($file['read']) ?></p>
          <h3 class="type-h3 file-title"><a href="<?= e(url('case-file.php?slug=' . urlencode($file['slug']))) ?>"><?= e($file['title']) ?></a></h3>
          <p class="file-desc"><?= e($file['desc']) ?></p>
          <a class="type-sm file-link" href="<?= e(url('case-file.php?slug=' . urlencode($file['slug']))) ?>"><svg class="ic"><use href="#i-folder"/></svg> Open the file <svg class="ic"><use href="#i-arrow"/></svg></a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ FAQ ============ -->
<section class="section section-darker">
  <div class="wrap narrow">
    <p class="kicker center type-sm">Case notes</p>
    <h2 class="h2 center">Questions before your first shift</h2>
    <div class="faq-list">
      <?php foreach (FAQS as $i => $faq): ?>
      <details class="faq" <?= $i === 0 ? 'open' : '' ?>>
        <summary class="type-h3"><?= e($faq['q']) ?><svg class="ic chev"><use href="#i-chev-down"/></svg></summary>
        <p><?= e($faq['a']) ?></p>
      </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ JOIN THE PRECINCT ============ -->
<section class="section section-darker cta-section">
  <div class="wrap">
    <div class="cta-card paper">
      <span class="cta-blob" aria-hidden="true"></span>
      <p class="kicker center type-sm">Recruitment</p>
      <h2 class="h2 center dark">Join the precinct</h2>
      <p class="lead center dark">Guest detectives can play any open case. Sign in to save your clues, build your streak, interrogate suspects, and claim your spot on the precinct leaderboard.</p>
      <div class="cta-actions">
        <a class="btn btn-red" href="<?= e(url('auth.php')) ?>">Sign in as a detective</a>
        <a class="btn btn-paper" href="<?= e(url('case.php')) ?>">Play as a guest</a>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

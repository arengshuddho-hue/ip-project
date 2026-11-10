<?php
/** footer.php — site footer + shared JS */
?>
<footer class="site-footer">
  <div class="wrap footer-grid">
    <div class="footer-brand">
      <p class="footer-logo">The Detective's Desk</p>
      <p class="footer-note">The online detective game with a new murder mystery every day. Close the case before the precinct clock runs out.</p>
    </div>
    <nav class="footer-nav" aria-label="Footer">
      <p class="footer-head">Precinct</p>
      <a href="<?= e(url('index.php')) ?>">The desk</a>
      <a href="<?= e(url('case.php')) ?>">Today's case</a>
      <a href="<?= e(url('archive.php')) ?>">Cold cases</a>
      <a href="<?= e(url('standings.php')) ?>">Standings</a>
    </nav>
    <nav class="footer-nav" aria-label="Records">
      <p class="footer-head">Records room</p>
      <a href="<?= e(url('guides.php')) ?>">Field manual</a>
      <a href="<?= e(url('case-files.php')) ?>">The case files</a>
      <a href="<?= e(url('auth.php')) ?>">Sign in</a>
    </nav>
  </div>
  <div class="wrap footer-legal">
    <p>© <?= date('Y') ?> The Detective's Desk — educational clone built with HTML, CSS, JavaScript &amp; PHP for a university project. Not affiliated with detekts.com.</p>
  </div>
</footer>

<script src="<?= e(url('assets/js/main.js')) ?>?v=1.0"></script>
<?php if (!empty($extra_js)): ?>
<?php foreach ((array) $extra_js as $js): ?>
<script src="<?= e(url($js)) ?>?v=1.0"></script>
<?php endforeach; endif; ?>
</body>
</html>

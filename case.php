<?php
/**
 * case.php — today's case: the playable investigation.
 * Tabs are switched with JS; evidence & interviews persist in $_SESSION;
 * the accusation is graded server-side with a real POST form.
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/auth.php';

$C = TODAY_CASE;
$user = current_user();

// ---- state ----------------------------------------------------------------
$_SESSION['case50'] ??= ['evidence' => [], 'interviews' => [], 'accused' => null];
$state = &$_SESSION['case50'];

// hours until the next daily drop
$nextDropIn = 24 - (int) date('G');

// ---- accusation (server-side POST) ----------------------------------------
$verdict = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'accuse') {
    if (!csrf_check($_POST['csrf'] ?? null)) {
        http_response_code(403);
        exit('Bad token — refresh the page.');
    }
    if (empty($state['accused'])) {
        $accused = preg_replace('/[^a-z]/', '', (string) ($_POST['suspect'] ?? ''));
        $motive  = preg_replace('/[^a-z\-]/', '', (string) ($_POST['motive'] ?? ''));

        $foundEv   = count($state['evidence']);
        $cracked   = 0;
        foreach ($C['suspects'] as $s) {
            if (count($state['interviews'][$s['id']] ?? []) >= count($s['qa'])) {
                $cracked++;
            }
        }
        $correct = ($accused === $C['culprit']);
        $motiveOk = ($correct && $motive === $C['culprit_motive']);

        $score = $foundEv * 5 + $cracked * 5 + ($correct ? 60 : 0) + ($motiveOk ? 15 : 0);

        $state['accused'] = [
            'suspect'  => $accused,
            'motive'   => $motive,
            'correct'  => $correct,
            'motiveOk' => $motiveOk,
            'score'    => $score,
            'evidence' => $foundEv,
            'cracked'  => $cracked,
            'at'       => date('Y-m-d H:i:s'),
        ];
        if ($user) {
            record_score($user['id'], $user['name'], $score, $C['title'], $correct);
        }
    }
    $verdict = $state['accused'];
}

$foundCount = count($state['evidence']);
$crackedCount = 0;
foreach ($C['suspects'] as $s) {
    if (count($state['interviews'][$s['id']] ?? []) >= count($s['qa'])) {
        $crackedCount++;
    }
}
$liveScore = $foundCount * 5 + $crackedCount * 5;
$pct = ($state['accused']['score'] ?? $liveScore) > 0
    ? min(100, (int) round((($state['accused']['score'] ?? $liveScore) / $C['max_score']) * 100))
    : 0;

// state snapshot for JS
$jsState = [
    'found'      => array_values($state['evidence']),
    'interviews' => $state['interviews'],
    'accused'    => $state['accused'],
];

$page_title = "Case #{$C['number']}: {$C['title']} — " . SITE_NAME;
$body_class = 'page-case';
$extra_js = ['assets/js/case.js'];
require __DIR__ . '/includes/header.php';
?>

<!-- ============ TOP BAR ============ -->
<header class="case-top">
  <div class="case-top-left">
    <span class="tab-label type-sm">Today's case</span>
    <span class="drop type-sm"><svg class="ic"><use href="#i-clock"/></svg> Next drop in <?= $nextDropIn ?>h</span>
  </div>
  <div class="case-top-right">
    <span class="score-badge" title="Your case score"><span class="score-pct"><?= $pct ?>%</span></span>
    <a class="icon-btn" href="<?= e(url('standings.php')) ?>" title="Precinct standings"><svg class="ic"><use href="#i-trophy"/></svg></a>
    <a class="icon-btn" href="<?= e(url('archive.php')) ?>" title="Case archive"><svg class="ic"><use href="#i-folder"/></svg></a>
    <?php if ($user): ?>
      <a class="icon-btn who" href="<?= e(url('auth.php')) ?>" title="<?= e($user['name']) ?>"><svg class="ic"><use href="#i-user"/></svg></a>
    <?php else: ?>
      <a class="icon-btn" href="<?= e(url('auth.php')) ?>" title="Sign in"><svg class="ic"><use href="#i-user"/></svg></a>
    <?php endif; ?>
  </div>
</header>

<main class="case-shell">
  <!-- ============ TAB NAV ============ -->
  <nav class="case-tabs" role="tablist" aria-label="Case sections">
    <button class="tab is-active" data-tab="brief"><svg class="ic"><use href="#i-dossier"/></svg> Brief</button>
    <button class="tab" data-tab="scene"><svg class="ic"><use href="#i-search"/></svg> Scene</button>
    <button class="tab" data-tab="people"><svg class="ic"><use href="#i-people"/></svg> People</button>
    <button class="tab" data-tab="evidence"><svg class="ic"><use href="#i-evidence"/></svg> Evidence <span class="count" id="ev-count"><?= $foundCount ?></span></button>
    <button class="tab" data-tab="reports"><svg class="ic"><use href="#i-reports"/></svg> Reports <span class="count">1</span></button>
    <button class="tab" data-tab="interviews"><svg class="ic"><use href="#i-interview"/></svg> Interviews <span class="count" id="int-count"><?= $crackedCount ?></span></button>
    <button class="tab" data-tab="timeline"><svg class="ic"><use href="#i-clock"/></svg> Timeline</button>
    <button class="tab tab-accuse" data-tab="accuse"><svg class="ic"><use href="#i-accuse"/></svg> Accuse</button>
  </nav>

  <!-- ============ CASE FILE ============ -->
  <div class="case-file paper">

    <!-- ---------- BRIEF ---------- -->
    <section class="panel is-active" id="panel-brief" role="tabpanel">
      <div class="brief-head">
        <div>
          <p class="case-no type-sm">Case #<?= $C['number'] ?></p>
          <h1 class="case-title"><?= e($C['title']) ?></h1>
        </div>
        <span class="stamp"><?= e($C['stamp']) ?></span>
      </div>
      <div class="brief-facts mono">
        <p><span class="fact-label">Victim</span> <strong><?= e($C['victim']) ?></strong> <span class="fact-label">Window</span> <strong><?= e($C['window']) ?></strong></p>
        <p><span class="fact-label">Details</span> <?= e($C['details']) ?></p>
      </div>

      <div class="brief-grid">
        <p class="brief-intro"><?= e($C['intro']) ?></p>
        <aside class="victim-card">
          <p class="victim-head type-sm">The victim</p>
          <div class="victim-flex">
            <img class="polaroid" src="<?= e(url('assets/img/p-orson.png')) ?>" alt="Orson Kestrel">
            <p class="victim-note"><?= e($C['victim_note']) ?></p>
          </div>
        </aside>
      </div>

      <h2 class="paper-h">Ties to the victim</h2>
      <div class="ties-grid">
        <?php foreach ($C['suspects'] as $s): ?>
        <article class="tie">
          <img src="<?= e(url($s['img'])) ?>" alt="<?= e($s['name']) ?>">
          <div>
            <p class="tie-name"><strong><?= e($s['name']) ?></strong> — <?= e($s['tie']) ?></p>
            <p class="tie-secret"><?= e($s['secret']) ?></p>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- ---------- SCENE ---------- -->
    <section class="panel" id="panel-scene" role="tabpanel" hidden>
      <h2 class="paper-h">The crime scenes</h2>
      <p class="scene-hint">Click the pulsing markers to bag hidden evidence. Three locations, five pieces.</p>

      <?php
      $scenes = [
          ['id' => 'booth', 'img' => 'scene-booth.png', 'title' => 'The projection booth', 'hot' => [
              ['ev' => 'ev-reel',  'x' => 42, 'y' => 48],
              ['ev' => 'ev-glass', 'x' => 63, 'y' => 66],
              ['ev' => 'ev-keys',  'x' => 80, 'y' => 28],
          ]],
          ['id' => 'lobby', 'img' => 'scene-lobby.png', 'title' => 'The lobby during the reception', 'hot' => [
              ['ev' => 'ev-letter', 'x' => 30, 'y' => 52],
          ]],
          ['id' => 'basement', 'img' => 'scene-basement.png', 'title' => 'The basement electrical room', 'hot' => [
              ['ev' => 'ev-panel', 'x' => 55, 'y' => 46],
          ]],
      ];
      foreach ($scenes as $scene): ?>
      <figure class="scene" data-scene="<?= e($scene['id']) ?>">
        <figcaption class="type-sm"><?= e($scene['title']) ?></figcaption>
        <div class="scene-img">
          <img src="<?= e(url('assets/img/' . $scene['img'])) ?>" alt="<?= e($scene['title']) ?>">
          <?php foreach ($scene['hot'] as $h): $found = in_array($h['ev'], $state['evidence'], true); ?>
          <button class="hotspot<?= $found ? ' is-found' : '' ?>"
                  data-ev="<?= e($h['ev']) ?>"
                  style="left:<?= $h['x'] ?>%;top:<?= $h['y'] ?>%"
                  aria-label="Examine: <?= e($C['evidence'][$h['ev']]['name']) ?>">
            <span class="ring"></span><span class="tick">✓</span>
          </button>
          <?php endforeach; ?>
        </div>
      </figure>
      <?php endforeach; ?>
    </section>

    <!-- ---------- PEOPLE ---------- -->
    <section class="panel" id="panel-people" role="tabpanel" hidden>
      <h2 class="paper-h">Persons of interest</h2>
      <p class="scene-hint">Six people were inside the Rialto when the lights failed. Select one to sit them down for an interview.</p>
      <div class="people-grid">
        <?php foreach ($C['suspects'] as $s): $cracked = count($state['interviews'][$s['id']] ?? []) >= count($s['qa']); ?>
        <button class="person<?= $cracked ? ' is-cracked' : '' ?>" data-suspect="<?= e($s['id']) ?>">
          <img src="<?= e(url($s['img'])) ?>" alt="<?= e($s['name']) ?>">
          <span class="person-name"><?= e($s['name']) ?></span>
          <span class="person-role type-sm"><?= e($s['role']) ?></span>
          <?php if ($cracked): ?><span class="person-cracked type-sm">Cracked</span><?php endif; ?>
        </button>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- ---------- EVIDENCE ---------- -->
    <section class="panel" id="panel-evidence" role="tabpanel" hidden>
      <h2 class="paper-h">Evidence locker</h2>
      <p class="scene-hint">Everything you bag at the scenes lands here — and on your corkboard.</p>
      <div id="evidence-list" class="ev-list">
        <?php if (!$foundCount): ?>
          <p class="empty-note">Nothing bagged yet. Work the <button class="linklike" data-goto="scene">crime scenes</button> first.</p>
        <?php endif; ?>
        <?php foreach ($C['evidence'] as $id => $ev): if (in_array($id, $state['evidence'], true)): ?>
        <article class="ev-card" data-ev="<?= e($id) ?>">
          <p class="ev-name type-h3"><?= e($ev['name']) ?> <span class="ev-pts mono">+<?= (int) $ev['points'] ?></span></p>
          <p><?= e($ev['text']) ?></p>
        </article>
        <?php endif; endforeach; ?>
      </div>
    </section>

    <!-- ---------- REPORTS ---------- -->
    <section class="panel" id="panel-reports" role="tabpanel" hidden>
      <h2 class="paper-h">Forensic reports</h2>
      <article class="ev-card">
        <p class="ev-name type-h3">Lab report — relay board <span class="ev-pts mono">R-118</span></p>
        <p>Relay housing shows pry marks on the inside face; fine glass deposition underneath the board rather than beside it. Conclusion: the relay was pulled apart after power loss, from inside the booth, by someone standing at the operator's position.</p>
      </article>
      <article class="ev-card">
        <p class="ev-name type-h3">Lab report — film stock <span class="ev-pts mono">R-119</span></p>
        <p>Recovered film did not snap under tension; it melted along 40cm of its length. Melt patterns are consistent with the lamp running while the shutter was jammed open. Conclusion: the blackout did not stop the projector — someone arranged for it to keep running.</p>
      </article>
    </section>

    <!-- ---------- INTERVIEWS ---------- -->
    <section class="panel" id="panel-interviews" role="tabpanel" hidden>
      <h2 class="paper-h">Interrogation room</h2>
      <div class="int-layout">
        <div class="int-list" id="int-list">
          <?php foreach ($C['suspects'] as $s): $asked = count($state['interviews'][$s['id']] ?? []); ?>
          <button class="int-suspect" data-suspect="<?= e($s['id']) ?>">
            <img src="<?= e(url($s['img'])) ?>" alt="">
            <span>
              <span class="int-name"><?= e($s['name']) ?></span>
              <span class="int-role type-sm"><?= e($s['role']) ?></span>
              <span class="int-progress mono"><?= $asked ?>/<?= count($s['qa']) ?> asked</span>
            </span>
          </button>
          <?php endforeach; ?>
        </div>
        <div class="int-room" id="int-room">
          <p class="empty-note">Select a suspect on the left, then ask your questions. Press them with what you know — cracked suspects are worth +5 each.</p>
        </div>
      </div>
    </section>

    <!-- ---------- TIMELINE ---------- -->
    <section class="panel" id="panel-timeline" role="tabpanel" hidden>
      <h2 class="paper-h">The night at the Rialto</h2>
      <ol class="timeline">
        <?php foreach ($C['timeline'] as $t): $locked = false; ?>
        <li class="tl-item<?= $locked ? ' is-locked' : '' ?>">
          <span class="tl-time mono"><?= e($t['time']) ?></span>
          <p><?= e($t['event']) ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
    </section>

    <!-- ---------- ACCUSE ---------- -->
    <section class="panel" id="panel-accuse" role="tabpanel" hidden>
      <?php if (!empty($state['accused'])): ?>
        <?php $a = $state['accused']; $culprit = null; foreach ($C['suspects'] as $s) if ($s['id'] === $C['culprit']) $culprit = $s; ?>
        <div class="verdict">
          <p class="stamp big <?= $a['correct'] ? 'stamp-ok' : 'stamp-no' ?>"><?= $a['correct'] ? 'CASE CLOSED' : 'WRONG ACCUSATION' ?></p>
          <h2 class="paper-h center"><?= $a['correct'] ? 'The precinct accepts your closing argument.' : 'The precinct throws your argument out.' ?></h2>
          <div class="verdict-box">
            <p><span class="fact-label">You accused</span> <strong><?= e($C['suspects'][array_search($a['suspect'], array_column($C['suspects'], 'id'))]['name'] ?? '—') ?></strong></p>
            <p><span class="fact-label">Motive</span> <?= e($C['motives'][$a['motive']] ?? '—') ?> <?= $a['motiveOk'] ? '✓' : '' ?></p>
            <?php if (!$a['correct']): ?>
            <p><span class="fact-label">Truth</span> It was <strong><?= e($culprit['name']) ?></strong>. <?= e($C['solution']) ?></p>
            <?php else: ?>
            <p><?= e($C['solution']) ?></p>
            <?php endif; ?>
          </div>
          <div class="score-break">
            <div class="score-row"><span>Evidence bagged (<?= (int) $a['evidence'] ?> × 5)</span><span class="mono"><?= (int) ($a['evidence'] * 5) ?></span></div>
            <div class="score-row"><span>Suspects cracked (<?= (int) $a['cracked'] ?> × 5)</span><span class="mono"><?= (int) ($a['cracked'] * 5) ?></span></div>
            <div class="score-row"><span>Correct accusation</span><span class="mono"><?= $a['correct'] ? 60 : 0 ?></span></div>
            <div class="score-row"><span>Motive proven</span><span class="mono"><?= $a['motiveOk'] ? 15 : 0 ?></span></div>
            <div class="score-row total"><span>Case score</span><span class="mono"><?= (int) $a['score'] ?>/<?= (int) $C['max_score'] ?></span></div>
          </div>
          <p class="verdict-note type-sm">The next case drops in <?= $nextDropIn ?>h. <a class="tlink" href="<?= e(url('archive.php')) ?>">Browse the cold-case archive</a> in the meantime.</p>
        </div>
      <?php else: ?>
      <h2 class="paper-h">Make the accusation</h2>
      <p class="scene-hint">Name the culprit and state the motive. One accusation per shift — the precinct grades your closing argument out of <?= (int) $C['max_score'] ?>.</p>
      <form class="accuse-form" method="post" action="<?= e(url('case.php')) ?>" id="accuse-form">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="accuse">
        <p class="accuse-label type-sm">I accuse</p>
        <div class="accuse-grid" role="radiogroup" aria-label="Suspect">
          <?php foreach ($C['suspects'] as $s): ?>
          <label class="accuse-opt">
            <input type="radio" name="suspect" value="<?= e($s['id']) ?>" required>
            <img src="<?= e(url($s['img'])) ?>" alt="">
            <span><?= e($s['name']) ?></span>
            <span class="type-sm"><?= e($s['role']) ?></span>
          </label>
          <?php endforeach; ?>
        </div>
        <p class="accuse-label type-sm">The motive was</p>
        <div class="motive-list" role="radiogroup" aria-label="Motive">
          <?php foreach ($C['motives'] as $mid => $mtext): ?>
          <label class="motive-opt"><input type="radio" name="motive" value="<?= e($mid) ?>" required><span><?= e($mtext) ?></span></label>
          <?php endforeach; ?>
        </div>
        <button class="btn btn-red accuse-btn" type="submit">Close the case</button>
        <p class="type-sm accuse-warn">You have bagged <strong id="accuse-ev"><?= $foundCount ?>/5</strong> pieces of evidence. The case file holds everything you need — interrogations are where the bonus marks live.</p>
      </form>
      <?php endif; ?>
    </section>
  </div>
</main>

<!-- ============ CORKBOARD / NOTEPAD ============ -->
<div class="desk-tools">
  <button class="desk-btn" id="btn-corkboard"><svg class="ic"><use href="#i-board"/></svg> Corkboard <span class="mono" id="cork-count"><?= $foundCount ?></span></button>
  <button class="desk-btn" id="btn-notepad"><svg class="ic"><use href="#i-pencil"/></svg> Notepad</button>
</div>

<aside class="drawer" id="drawer-notepad" hidden>
  <header class="drawer-head paper">
    <p class="type-sm">Detective notepad</p>
    <button class="drawer-close" data-close aria-label="Close">×</button>
  </header>
  <textarea id="notepad" placeholder="Jot down theories, times, names... (saved in this browser)"></textarea>
  <p class="type-sm drawer-foot">Notes save automatically to this browser.</p>
</aside>

<aside class="drawer" id="drawer-corkboard" hidden>
  <header class="drawer-head paper">
    <p class="type-sm">Evidence corkboard</p>
    <button class="drawer-close" data-close aria-label="Close">×</button>
  </header>
  <div class="cork" id="cork">
    <p class="empty-note" id="cork-empty">No pins yet. Bag evidence at the scenes to pin it here.</p>
    <!-- pinned evidence cards are injected by case.js -->
  </div>
</aside>

<!-- state snapshot for the game script -->
<script>
window.__CASE_STATE__    = <?= json_encode($jsState, JSON_UNESCAPED_UNICODE) ?>;
window.__CASE_EVIDENCE__ = <?= json_encode($C['evidence'], JSON_UNESCAPED_UNICODE) ?>;
window.__CASE_SUSPECTS__ = {
<?php foreach ($C['suspects'] as $s): ?>
  <?= json_encode($s['id']) ?>: { name: <?= json_encode($s['name']) ?>, qa: <?= json_encode($s['qa'], JSON_UNESCAPED_UNICODE) ?> },
<?php endforeach; ?>
};
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>

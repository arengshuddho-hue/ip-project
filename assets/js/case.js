/* case.js — the investigation: tabs, scene hotspots, interviews, corkboard.
   Talks to api/game.php with fetch() for evidence & interviews. */
(function () {
  'use strict';

  const CSRF = document.querySelector('input[name="csrf"]')?.value || '';
  const state = window.__CASE_STATE__ || { found: [], interviews: {}, accused: null };

  const api = (payload) =>
    fetch('api/game.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(Object.assign({ csrf: CSRF }, payload)),
    }).then((r) => r.json());

  // ================= TABS =================
  const tabs = document.querySelectorAll('.tab');
  const panels = document.querySelectorAll('.panel');
  const activate = (name) => {
    tabs.forEach((t) => t.classList.toggle('is-active', t.dataset.tab === name));
    panels.forEach((p) => {
      const on = p.id === 'panel-' + name;
      p.hidden = !on;
      p.classList.toggle('is-active', on);
    });
  };
  tabs.forEach((t) => t.addEventListener('click', () => activate(t.dataset.tab)));

  // After a graded accusation, land on the verdict
  if (state.accused) activate('accuse');

  // ================= Live score badge =================
  const MAX_SCORE = 130;
  const updateScoreBadge = () => {
    let crackedTotal = 0;
    Object.keys(asked).forEach((sid) => {
      const s = (window.__CASE_SUSPECTS__ || {})[sid];
      if (s && asked[sid].length >= s.qa.length) crackedTotal++;
    });
    const pct = Math.min(100, Math.round(((found.size * 5 + crackedTotal * 5) / MAX_SCORE) * 100));
    const badge = document.querySelector('.score-pct');
    if (badge) badge.textContent = pct + '%';
  };

  // ================= EVIDENCE =================
  const evCount = document.getElementById('ev-count');
  const evList = document.getElementById('evidence-list');
  const corkCount = document.getElementById('cork-count');
  const found = new Set(state.found);

  const emptyNote = () => evList.querySelector('.empty-note');
  const renderEvidenceCard = (item) => {
    const card = document.createElement('article');
    card.className = 'ev-card';
    card.dataset.ev = item.id;
    card.innerHTML =
      '<p class="ev-name type-h3">' + item.name +
      ' <span class="ev-pts mono">+' + item.points + '</span></p><p>' + item.text + '</p>';
    evList.prepend(card);
  };

  const pinToCork = (item) => {
    const cork = document.getElementById('cork');
    const empty = document.getElementById('cork-empty');
    if (empty) empty.remove();
    const pin = document.createElement('div');
    pin.className = 'cork-pin';
    pin.innerHTML = '<span class="cp-name">' + item.name + '</span><p>' + item.text + '</p>';
    cork.prepend(pin);
  };

  // pre-pin already found evidence
  state.found.forEach((id) => {
    const btn = document.querySelector('.hotspot[data-ev="' + id + '"]');
    if (btn) btn.classList.add('is-found');
  });

  document.querySelectorAll('.hotspot').forEach((hs) => {
    hs.addEventListener('click', async () => {
      const id = hs.dataset.ev;
      if (found.has(id)) return;
      const res = await api({ action: 'find_evidence', id });
      if (!res.ok) return;
      found.add(id);
      hs.classList.add('is-found');
      renderEvidenceCard(res.item);
      pinToCork(res.item);
      evCount.textContent = res.count;
      corkCount.textContent = res.count;
      document.getElementById('accuse-ev').textContent = res.count + '/5';
      if (emptyNote()) emptyNote().remove();
      updateScoreBadge();
      // small toast
      toast('Bagged: ' + res.item.name + ' (+' + res.item.points + ')');
    });
  });

  // ================= INTERVIEWS =================
  const suspectBtns = document.querySelectorAll('.int-suspect');
  const room = document.getElementById('int-room');
  const intCount = document.getElementById('int-count');
  const asked = state.interviews || {};

  const personBtn = document.querySelector('.person[data-suspect]:not(.person)');
  // People panel buttons jump to interviews
  document.querySelectorAll('.person').forEach((p) =>
    p.addEventListener('click', () => {
      activate('interviews');
      const target = document.querySelector('.int-suspect[data-suspect="' + p.dataset.suspect + '"]');
      if (target) target.click();
    })
  );

  const renderRoom = async (suspect) => {
    suspectBtns.forEach((b) => b.classList.toggle('is-active', b.dataset.suspect === suspect));
    const btn = document.querySelector('.int-suspect[data-suspect="' + suspect + '"]');
    const name = btn.querySelector('.int-name').textContent;
    const role = btn.querySelector('.int-role').textContent;

    room.innerHTML =
      '<div class="int-header"><img src="' + btn.querySelector('img').src + '" alt="">' +
      '<div><h3>' + name + '</h3><p class="int-sub">' + role + '</p></div></div>' +
      '<div id="qa-log"></div><div id="q-holder"></div>';

    // preload already-asked Q&A
    for (const qi of asked[suspect] || []) {
      const res = await api({ action: 'ask', suspect, q: qi });
      if (res.ok) addQA(res, false);
    }
    buildQuestions(suspect);
  };

  const addQA = (res, animate) => {
    const log = document.getElementById('qa-log');
    const block = document.createElement('div');
    block.className = 'qa-block' + (animate === false ? '' : '');
    block.innerHTML = '<p class="qa-q">Q: ' + res.q + '</p><p class="qa-a">' + res.a + '</p>';
    log.appendChild(block);
    return block;
  };

  const buildQuestions = (suspect) => {
    const holder = document.getElementById('q-holder');
    if (!holder) return;
    holder.innerHTML = '';
    const total = parseInt(document.querySelector('.int-suspect[data-suspect="' + suspect + '"] .int-progress').textContent, 10);
    // We rebuild the full question list from the embedded data:
    const data = window.__CASE_SUSPECTS__[suspect];
    data.qa.forEach((qa, qi) => {
      const b = document.createElement('button');
      b.type = 'button';
      b.className = 'q-btn' + ((asked[suspect] || []).includes(qi) ? ' is-done' : '');
      b.textContent = qa.q;
      b.addEventListener('click', async () => {
        if ((asked[suspect] || []).includes(qi)) return;
        const res = await api({ action: 'ask', suspect, q: qi });
        if (!res.ok) return;
        (asked[suspect] = asked[suspect] || []).push(qi);
        b.classList.add('is-done');
        addQA(res, true);
        const prog = document.querySelector('.int-suspect[data-suspect="' + suspect + '"] .int-progress');
        prog.textContent = res.asked + '/' + res.total + ' asked';
        intCount.textContent = res.crackedTotal;
        updateScoreBadge();
        if (res.cracked && !b.dataset.crackNoted) {
          b.dataset.crackNoted = '1';
          const note = document.createElement('p');
          note.className = 'int-cracked-note';
          note.textContent = '— ' + data.name + ' has cracked. +5 case points.';
          document.getElementById('qa-log').appendChild(note);
          document.querySelector('.person[data-suspect="' + suspect + '"]')?.classList.add('is-cracked');
        }
      });
      holder.appendChild(b);
    });
  };

  suspectBtns.forEach((b) => b.addEventListener('click', () => renderRoom(b.dataset.suspect)));

  // ================= Corkboard live data =================
  // (pre-pin already-bagged evidence on load)
  document.addEventListener('DOMContentLoaded', () => {
    (state.found || []).forEach((id) => {
      const item = window.__CASE_EVIDENCE__[id];
      if (item) pinToCork(Object.assign({ id }, item));
    });
  });

  // ================= Toast =================
  let toastTimer = null;
  const toast = (msg) => {
    let el = document.getElementById('dd-toast');
    if (!el) {
      el = document.createElement('div');
      el.id = 'dd-toast';
      el.style.cssText =
        'position:fixed;left:50%;bottom:88px;transform:translateX(-50%);' +
        'background:#1c130c;color:#ece4d4;border:1px solid #e8a04c;' +
        'font-family:Courier Prime,monospace;font-size:13px;padding:10px 18px;z-index:60;' +
        'box-shadow:0 10px 30px rgba(0,0,0,.5);transition:opacity .25s ease';
      document.body.appendChild(el);
    }
    el.textContent = msg;
    el.style.opacity = '1';
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => { el.style.opacity = '0'; }, 2600);
  };
})();

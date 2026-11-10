/* main.js — shared behaviour: drawers (corkboard / notepad) & small helpers */
(function () {
  'use strict';

  // ---- drawers -------------------------------------------------------------
  const drawers = document.querySelectorAll('.drawer');
  const openDrawer = (id) => {
    drawers.forEach((d) => { d.hidden = d.id !== id; });
  };
  const closeDrawers = () => drawers.forEach((d) => { d.hidden = true; });

  const btnNotepad = document.getElementById('btn-notepad');
  const btnCork = document.getElementById('btn-corkboard');
  if (btnNotepad) btnNotepad.addEventListener('click', () => {
    const d = document.getElementById('drawer-notepad');
    const willOpen = d.hidden;
    closeDrawers();
    if (willOpen) openDrawer('drawer-notepad');
  });
  if (btnCork) btnCork.addEventListener('click', () => {
    const d = document.getElementById('drawer-corkboard');
    const willOpen = d.hidden;
    closeDrawers();
    if (willOpen) openDrawer('drawer-corkboard');
  });
  document.querySelectorAll('[data-close]').forEach((b) =>
    b.addEventListener('click', closeDrawers)
  );
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeDrawers();
  });

  // ---- notepad persistence (localStorage) -----------------------------------
  const pad = document.getElementById('notepad');
  if (pad) {
    pad.value = localStorage.getItem('dd-notepad') || '';
    let t = null;
    pad.addEventListener('input', () => {
      clearTimeout(t);
      t = setTimeout(() => localStorage.setItem('dd-notepad', pad.value), 300);
    });
  }

  // ---- jump links inside panels (e.g. empty evidence note → scene) ----------
  document.querySelectorAll('[data-goto]').forEach((el) =>
    el.addEventListener('click', () => {
      const tab = document.querySelector('.tab[data-tab="' + el.dataset.goto + '"]');
      if (tab) tab.click();
    })
  );
})();

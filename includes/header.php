<?php
/**
 * header.php — common <head>, fonts, CSS, SVG icon sprite.
 * Set $page_title / $body_class before including.
 */
if (!defined('ROOT_DIR')) {
    require_once __DIR__ . '/config.php';
}
$page_title = $page_title ?? SITE_NAME;
$body_class = $body_class ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($page_title) ?></title>
<meta name="description" content="The Detective's Desk — a free browser detective game with a new murder mystery every day. Educational PHP clone project.">
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🕵️</text></svg>">
<link rel="stylesheet" href="<?= e(url('assets/css/style.css')) ?>?v=1.0">
</head>
<body class="<?= e($body_class) ?>">

<!-- SVG icon sprite -->
<svg xmlns="http://www.w3.org/2000/svg" style="display:none" aria-hidden="true">
  <symbol id="i-dossier" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M5 3h11l3 3v15H5zM8 8h7M8 12h7M8 16h4"/></symbol>
  <symbol id="i-search" viewBox="0 0 24 24"><circle cx="10.5" cy="10.5" r="6" fill="none" stroke="currentColor" stroke-width="1.8"/><path stroke="currentColor" stroke-width="1.8" d="m15.5 15.5 5 5"/></symbol>
  <symbol id="i-people" viewBox="0 0 24 24"><circle cx="8" cy="9" r="3.2" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="16.5" cy="10.5" r="2.4" fill="none" stroke="currentColor" stroke-width="1.8"/><path fill="none" stroke="currentColor" stroke-width="1.8" d="M3 20c.6-3.4 2.6-5 5-5s4.4 1.6 5 5M14.6 15.6c2.8.2 4.5 1.6 5.4 4.4"/></symbol>
  <symbol id="i-scales" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M12 4v16M7 20h10M12 6l-5 2m5-2 5 2M7 8l-2.5 6a3 3 0 0 0 5 0zM17 8l-2.5 6a3 3 0 0 0 5 0z"/></symbol>
  <symbol id="i-calendar" viewBox="0 0 24 24"><rect x="4" y="5.5" width="16" height="15" rx="1.5" fill="none" stroke="currentColor" stroke-width="1.8"/><path stroke="currentColor" stroke-width="1.8" d="M4 10h16M8 3.5v4M16 3.5v4"/></symbol>
  <symbol id="i-pin" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M12 3a6 6 0 0 1 6 6c0 4.2-4.4 8.8-6 11.4C10.4 17.8 6 13.2 6 9a6 6 0 0 1 6-6z"/><circle cx="12" cy="9" r="2.2" fill="none" stroke="currentColor" stroke-width="1.8"/></symbol>
  <symbol id="i-chat" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M4 5h16v11H9l-5 4z"/></symbol>
  <symbol id="i-trophy" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M7 4h10v5a5 5 0 0 1-10 0zM7 5H4v2a3 3 0 0 0 3 3M17 5h3v2a3 3 0 0 1-3 3M12 14v4M8.5 20.5h7"/></symbol>
  <symbol id="i-flame" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M12 3s5.5 4.6 5.5 10a5.5 5.5 0 0 1-11 0c0-2 1-4.3 2.4-6 .3 1.4 1 2.4 2 2.9C10.6 8 11 5.6 12 3z"/></symbol>
  <symbol id="i-note" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M5 4h14v12l-4 4H5zM15 20v-4h4M8 9h8M8 13h5"/></symbol>
  <symbol id="i-evidence" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8" fill="none" stroke="currentColor" stroke-width="1.8"/><path fill="none" stroke="currentColor" stroke-width="1.8" d="M12 8v4l2.5 2.5"/></symbol>
  <symbol id="i-reports" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M6 3h9l3 3v15H6zM9 9h6M9 13h6M9 17h4"/></symbol>
  <symbol id="i-interview" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M4 5h13v9H8l-4 3zM14 10h6v7h-2v2l-2.5-2"/></symbol>
  <symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8" fill="none" stroke="currentColor" stroke-width="1.8"/><path fill="none" stroke="currentColor" stroke-width="1.8" d="M12 7v5l3.5 2"/></symbol>
  <symbol id="i-accuse" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="m13 3 8 8-9 9-8-8V5a2 2 0 0 1 2-2z"/><circle cx="8.5" cy="8.5" r="1.4"/></symbol>
  <symbol id="i-folder" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M3 6h6l2 2h10v11H3z"/></symbol>
  <symbol id="i-user" viewBox="0 0 24 24"><circle cx="12" cy="8.5" r="3.5" fill="none" stroke="currentColor" stroke-width="1.8"/><path fill="none" stroke="currentColor" stroke-width="1.8" d="M5 20c1-4 3.6-6 7-6s6 2 7 6"/></symbol>
  <symbol id="i-arrow" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M4 12h15m-6-6 6 6-6 6"/></symbol>
  <symbol id="i-back" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M20 12H5m6-6-6 6 6 6"/></symbol>
  <symbol id="i-chev-down" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="m6 9 6 6 6-6"/></symbol>
  <symbol id="i-board" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="9" cy="9" r="1.6"/><circle cx="15" cy="12" r="1.6"/><circle cx="10" cy="16" r="1.6"/><path d="m9 9 6 3M15 12l-5 4" fill="none" stroke="currentColor" stroke-width="1.2"/></symbol>
  <symbol id="i-pencil" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="m4 20 1-4L16.5 4.5a2.1 2.1 0 0 1 3 3L8 19z"/></symbol>
  <symbol id="i-bulb" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M9 18h6M10 21h4M12 3a6 6 0 0 1 4 10.5c-.8.7-1 1.5-1 2.5h-6c0-1-.2-1.8-1-2.5A6 6 0 0 1 12 3z"/></symbol>
  <symbol id="i-eye" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M2.5 12S6 5.8 12 5.8 21.5 12 21.5 12 18 18.2 12 18.2 2.5 12 2.5 12z"/><circle cx="12" cy="12" r="2.6" fill="none" stroke="currentColor" stroke-width="1.8"/></symbol>
</svg>

<?php // Top app bar is rendered per-page when needed ?>

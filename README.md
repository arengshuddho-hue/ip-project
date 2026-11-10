# The Detective's Desk — PHP Clone

> A full-stack clone of **[detekts.com](https://detekts.com)** — an online detective game with a new murder mystery every day — rebuilt from scratch with **HTML, CSS, JavaScript & PHP** as a university project.

![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?logo=php&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?logo=javascript&logoColor=black)
![License](https://img.shields.io/badge/Use-Educational-green)

**Live demo (local):** `http://localhost/detekts-clone/index.php` · No database required — runs on a JSON file store.

---

## Table of Contents

1. [About the Project](#1-about-the-project)
2. [Screenshots](#2-screenshots)
3. [Feature List](#3-feature-list)
4. [Technology Stack](#4-technology-stack)
5. [Installation & Run](#5-installation--run)
6. [বাংলায় চালানোর নিয়ম](#6-বাংলায়-চালানোর-নিয়ম)
7. [Demo Walkthrough (for the viva)](#7-demo-walkthrough-for-the-viva)
8. [Pages & Routes](#8-pages--routes)
9. [Project Structure](#9-project-structure)
10. [Security Implementation](#10-security-implementation)
11. [Scoring System](#11-scoring-system)
12. [Data Storage](#12-data-storage)
13. [Troubleshooting](#13-troubleshooting)
14. [Resetting Demo Data](#14-resetting-demo-data)
15. [Disclaimer](#15-disclaimer)

---

## 1. About the Project

**The Detective's Desk** is a browser-based detective game where the player investigates a
murder-mystery case: reading the dossier, searching crime-scene photographs for hidden
evidence, interrogating suspects, and finally accusing a culprit with a stated motive.

This project is a **working clone** of that concept, implemented without any framework —
only core **HTML, CSS, JavaScript and PHP**. It was built to demonstrate:

- a complete multi-page PHP application with session-based state,
- a playable game loop backed by **server-side scoring**,
- secure form handling (CSRF tokens, input whitelisting, output escaping),
- a responsive "noir" design system with self-hosted fonts (works fully offline).

---

## 2. Screenshots

| | |
|---|---|
| ![Landing page](docs/screenshots/01-home.png) | ![Case brief](docs/screenshots/02-case-brief.png) |
| *The desk (landing page)* | *Case #50 — the brief* |
| ![Crime scene](docs/screenshots/03-crime-scene.png) | ![Interrogation](docs/screenshots/04-interrogation.png) |
| *Crime scene — clickable evidence hotspots* | *Interrogation room* |
| ![Accusation](docs/screenshots/05-accusation.png) | ![Case archive](docs/screenshots/06-case-archive.png) |
| *Accusation form (server-graded)* | *Cold-case archive* |

---

## 3. Feature List

**Gameplay**
- 📁 **Daily case file** — Case #50, *The Silent Projector Incident*: a full mystery with victim, 6 suspects, 5 evidence pieces and a solution.
- 🖼️ **Interactive crime scenes** — 3 illustrated locations with pulsing hotspots; click to "bag" evidence (+5 points each).
- 🗣️ **Interrogation room** — every suspect has a scripted Q&A set; ask all questions to *crack* them (+5 each). Answers contradict alibis and hint at the truth.
- 📌 **Evidence corkboard & notepad** — pinned evidence cards and a notepad that autosaves to the browser (localStorage).
- ⏱️ **Timeline & forensic reports** — the night reconstructed minute-by-minute; lab reports that separate facts from claims.
- ⚖️ **Server-graded accusation** — one accusation per case, graded by PHP out of 130 with a full score breakdown.
- 🏆 **Precinct standings** — signed-in detectives get their best verdict on the leaderboard.
- 🗄️ **Case archive** — 20 cold cases with read-only dossiers.

**Application**
- Session-based guest vs. signed-in play.
- Registration / login / logout with hashed passwords.
- CSRF-protected POST forms and a JSON game API (`api/game.php`).
- Fully responsive — desktop, tablet and phone layouts.
- Self-hosted fonts and images — **no internet required after setup**.

---

## 4. Technology Stack

| Layer | Technology | Where it is used |
|---|---|---|
| Structure | HTML5 | 10 pages, semantic markup |
| Presentation | CSS3 (custom properties, grid, animations) | `assets/css/style.css` (~716 lines, noir design system) |
| Behaviour | Vanilla JavaScript (ES6) | `assets/js/main.js` (shared), `assets/js/case.js` (game) |
| Server | PHP 8+ (sessions, `password_hash()`, JSON I/O) | all `*.php`, `includes/`, `api/game.php` |
| Storage | JSON flat files + `flock()` locking | `data/users.json`, `data/scores.json` |
| Fonts | Special Elite, Karla, Courier Prime (woff2, self-hosted) | `assets/fonts/` |

No framework, no build step, no database server — the project runs as-is.

---

## 5. Installation & Run

### Prerequisites

Any one of the following:

- **XAMPP** (Apache + PHP 8) — recommended for Windows, or
- **PHP 8.0+** CLI — for the built-in development server.

### Option A — XAMPP (recommended)

1. Install XAMPP from <https://www.apachefriends.org>.
2. Start **Apache** from the XAMPP Control Panel (MySQL is **not** needed).
3. Copy the `detekts-clone` folder into the web root:
   - Windows: `C:\xampp\htdocs\detekts-clone`
   - macOS: `/Applications/XAMPP/htdocs/detekts-clone`
   - Linux: `/opt/lampp/htdocs/detekts-clone`
4. Open <http://localhost/detekts-clone/index.php>.

### Option B — PHP built-in server

```bash
cd detekts-clone
php -S localhost:8090
```

Then open <http://localhost:8090>.

> The project also works from a **sub-folder** — all URLs are generated relative to
> the running script (`url()` helper in `includes/config.php`).

---

## 6. বাংলায় চালানোর নিয়ম

### XAMPP দিয়ে (সবচেয়ে সহজ)

1. **XAMPP** ইনস্টল করুন: <https://www.apachefriends.org>
2. XAMPP Control Panel থেকে **Apache** চালু (Start) করুন। MySQL লাগবে না — সব ডেটা JSON ফাইলে সেভ হয়।
3. পুরো `detekts-clone` ফোল্ডারটি কপি করে রাখুন: `C:\xampp\htdocs\detekts-clone`
4. ব্রাউজারে খুলুন: **http://localhost/detekts-clone/index.php**
5. ব্যস! "Open today's case" বাটনে ক্লিক করলেই গেম শুরু।

### PHP দিয়ে (XAMPP ছাড়া)

```bash
cd detekts-clone
php -S localhost:8090
```

তারপর ব্রাউজারে: <http://localhost:8090>

### প্রেজেন্টেশনে যা দেখাবেন

1. হোমপেজ → **Open today's case**
2. **Scene** ট্যাব → ছবির জ্বলজ্বলে দাগে ক্লিক করে ৫টি evidence বের করুন (+৫ করে)
3. **Interviews** ট্যাব → সন্দেহভাজনের সব প্রশ্ন করুন (সব প্রশ্ন = "cracked", +৫)
4. **Timeline** ট্যাব → ওই রাতের ঘটনার সময়রেখা দেখুন
5. **Accuse** ট্যাব → অপরাধী ও motive বেছে সাবমিট → PHP নিজে স্কোর হিসাব করে রায় দেবে (সর্বোচ্চ ১৩০)
6. **Sign in** করলে স্কোর leaderboard-এ (Standings) যাবে; guest হয়েও খেলা যায়
7. নিচে বাঁয়ে **Corkboard / Notepad** বাটন → evidence pin ও নোট সেভ

<details>
<summary>🎬 <b>গেমের সমাধান (ভাইভার আগে দেখে নিন — spoiler!)</b></summary>

অপরাধী: **Elliot Shaw** (House electrician) —
Motive: **"Cover up stolen equipment before the endowment audit"**.
পুরো সমাধান Accuse করার পর সাইটেই দেখানো হয়।

</details>

---

## 7. Demo Walkthrough (for the viva)

A suggested 5-minute presentation flow:

| Step | Page | What to show | Concept demonstrated |
|---|---|---|---|
| 1 | `index.php` | Landing page, noir theme, FAQ accordion | CSS design system, `<details>` element |
| 2 | `case.php` → Brief | Case file, victim card, suspect list | PHP templates via `include` |
| 3 | Scene | Click 2–3 hotspots, open Evidence tab | JS events, session-persisted state |
| 4 | Interviews | Ask all questions of one suspect | JS state + PHP session merge |
| 5 | Timeline & Reports | Cross-check the 20:12 key / 20:38 breaker | Critical-thinking gameplay |
| 6 | Accuse | Submit correct culprit + motive | **POST form → server-side grading** |
| 7 | Sign in | Register, then Standings | Sessions, `password_hash()`, JSON store |
| 8 | Code peek | `case.php` (grading logic), `config.php` (CSRF) | Clean, commented PHP |

**Solution (spoiler):** the culprit is **Elliot Shaw**, motive **"Cover up stolen equipment before the endowment audit"** — the full reasoning is revealed on-screen after the accusation.

---

## 8. Pages & Routes

| Page | File | Description |
|---|---|---|
| The desk (landing) | `index.php` | Hero, how-it-works, tools, case files, FAQ, join CTA |
| Today's case (game) | `case.php` | 8 tabs: Brief / Scene / People / Evidence / Reports / Interviews / Timeline / Accuse |
| Case archive | `archive.php` | 20 cold cases + "My accusations" filter |
| Cold-case dossier | `dossier.php?dossier=N` | Read-only case file for archived cases |
| Field manual | `guides.php` | Index of 3 guide articles |
| Guide article | `guide.php?slug=…` | Full guide text (dynamic routing) |
| Records room | `case-files.php` | Real-case study index |
| Case study | `case-file.php?slug=…` | D.B. Cooper & Zodiac articles |
| Sign in / badge | `auth.php` | Register, login, logout, profile |
| Standings | `standings.php` | Leaderboard (best score per detective) |
| Game API | `api/game.php` | JSON endpoint (evidence & interview actions via `fetch()`) |

---

## 9. Project Structure

```
detekts-clone/
├── index.php                  # Landing page
├── case.php                   # Today's case — the playable game
├── archive.php                # Cold-case archive
├── dossier.php                # Read-only dossiers for archived cases
├── guides.php / guide.php     # Field manual (index + articles)
├── case-files.php / case-file.php
├── auth.php                   # Sign in / register / badge
├── standings.php              # Leaderboard
├── README.md                  # This file
├── api/
│   └── game.php               # JSON endpoint used by fetch()
├── includes/
│   ├── config.php             # Session, paths, helpers, CSRF
│   ├── data.php               # All case/story content (arrays)
│   ├── auth.php               # Register / login / score functions
│   ├── header.php             # <head>, icon sprite, shared markup
│   └── footer.php             # Footer + script tags
├── assets/
│   ├── css/style.css          # The whole noir design system
│   ├── js/main.js             # Shared behaviour (nav, FAQ, links)
│   ├── js/case.js             # Game logic (tabs, hotspots, corkboard…)
│   ├── img/                   # Noir artwork (hero, scenes, portraits)
│   └── fonts/                 # Self-hosted woff2 fonts
├── data/
│   ├── users.json             # Registered detectives (auto-managed)
│   └── scores.json            # Recorded verdicts (auto-managed)
└── docs/
    └── screenshots/           # Images used by this README
```

---

## 10. Security Implementation

| Threat | Defence | Code |
|---|---|---|
| Cross-Site Request Forgery | Random CSRF token on every session, verified with `hash_equals()` on all POST | `includes/config.php` |
| Cross-Site Scripting (XSS) | All dynamic output escaped with `htmlspecialchars()` via the `e()` helper | every view |
| SQL-style injection | Not applicable — JSON store; inputs additionally whitelisted with `preg_replace()` | `case.php`, `includes/auth.php` |
| Password theft | `password_hash()` (bcrypt) / `password_verify()`; passwords never stored in plain text | `includes/auth.php` |
| Session fixation | `session_regenerate_id(true)` on login and registration | `includes/auth.php` |
| Malicious file writes | `flock()` exclusive locking + JSON re-encode on every save | `includes/config.php` |

---

## 11. Scoring System

The accusation is graded **server-side** in `case.php`:

| Item | Points |
|---|---|
| Evidence bagged — 5 pieces × 5 | 25 |
| Suspects cracked (all questions asked) — 5 × 5 | 25 |
| Correct accusation | 60 |
| Correct motive | 15 |
| **Maximum case score** | **130** |

- One accusation per case per session — like the real site.
- The live score badge (top-right) updates as you investigate.
- Signed-in detectives get their best score recorded on the Standings board.

---

## 12. Data Storage

The project deliberately avoids a database server to stay portable:

- `data/users.json` — registered accounts (id, name, email, hashed password, joined date).
- `data/scores.json` — one row per recorded verdict (user, score, case, verdict, time).
- Reads use a shared lock, writes an exclusive lock (`flock()`), so concurrent requests stay safe.
- Per-player game state (evidence found, interviews asked, accusation) lives in `$_SESSION['case50']`.

---

## 13. Troubleshooting

| Problem | Fix |
|---|---|
| Blank page / "403 Forbidden" in XAMPP | Make sure Apache is running and the folder sits directly inside `htdocs` |
| Score or sign-in not saving | Give write permission to the `data/` folder (Windows: usually automatic) |
| Fonts look different | The woff2 files in `assets/fonts/` must be present — do not delete them |
| Played the case already, want to retry | Delete the site cookies for `localhost`, or see [Resetting Demo Data](#14-resetting-demo-data) |
| Port 8090 busy | Use another port: `php -S localhost:9000` |

---

## 14. Resetting Demo Data

To wipe accounts and scores back to a clean state, empty both files to `[]`
(or simply delete them — they are recreated automatically):

```
data/users.json   →  []
data/scores.json  →  []
```

To replay today's case in the same browser, clear the site's cookies (the game
state is stored in the PHP session).

---

## 15. Disclaimer

Built as an **educational clone** for a university course. All story text, code and
images in this folder were produced for this project; the original site concept and
design inspiration belong to [detekts.com](https://detekts.com). This project is not
affiliated with, endorsed by, or connected to the original site in any way.

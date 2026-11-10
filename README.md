# The Detective's Desk — PHP Clone (University Project)

A full clone of **detekts.com** ("The Detective's Desk" — an online detective game) built with **HTML, CSS, JavaScript & PHP** for a university demo.

> Educational project only — not affiliated with detekts.com.

---

## 🇧🇩 বাংলায় পড়ার জন্য (How to run — Bangla)

### XAMPP দিয়ে চালানো (সবচেয়ে সহজ)

1. **XAMPP** ডাউনলোড ও ইনস্টল করুন: https://www.apachefriends.org
2. XAMPP Control Panel খুলে **Apache** চালু (Start) করুন। (MySQL লাগবে না — ডেটা JSON ফাইলে সেভ হয়)
3. পুরো `detekts-clone` ফোল্ডারটি কপি করে রাখুন:
   - Windows: `C:\xampp\htdocs\detekts-clone`
   - macOS: `/Applications/XAMPP/htdocs/detekts-clone`
4. ব্রাউজারে খুলুন: **http://localhost/detekts-clone/index.php**
5. ব্যাস! সাইট চলবে। গেম খেলতে "Open today's case" বাটনে ক্লিক করুন।

### অথবা PHP built-in server দিয়ে (XAMPP ছাড়া)

কম্পিউটারে PHP (৮.০+) থাকলে:

```bash
cd detekts-clone
php -S localhost:8090
```

তারপর ব্রাউজারে: http://localhost:8090

### ডেমো কীভাবে দেখাবেন (ভাইভা/প্রেজেন্টেশনের জন্য)

1. হোমপেজ → **Open today's case**
2. **Scene** ট্যাব → ৩টি ছবিতে জ্বলজ্বলে দাগে ক্লিক করে ৫টি evidence বের করুন (প্রতিটি +৫ পয়েন্ট)
3. **Interviews** ট্যাব → সন্দেহভাজন বেছে সব প্রশ্ন করুন (সব প্রশ্ন = suspect "cracked", +৫)
4. **Timeline** ট্যাব → রাতের ঘটনার সময়রেখা দেখুন
5. **Accuse** ট্যাব → অপরাধী ও motive বেছে ফর্ম সাবমিট করুন → PHP স্কোর হিসাব করে রায় দেবে (সর্বোচ্চ ১৩০)
6. **Sign in** করলে স্কোর leaderboard (Standings) এ যায়; guest হিসেবেও খেলা যায়
7. **Notepad** ও **Corkboard** বাটন (নিচে বামে) → নোট সেভ ও evidence pin করা

<details>
<summary>🎬 গেমের সমাধান (ভাইভার আগে দেখে নিন — spoiler!)</summary>

অপরাধী: **Elliot Shaw** (House electrician) — Motive: **"Cover up stolen equipment before the endowment audit"**। পুরো সমাধান Accuse করার পর সাইটেই দেখানো হয়।

</details>

---

## 🇬🇧 English

### Pages

| Page | File | What it does |
|---|---|---|
| The desk (landing) | `index.php` | Hero, how-it-works, tools, case files, FAQ, join CTA |
| Today's case (game) | `case.php` | 8 tabs: Brief / Scene / People / Evidence / Reports / Interviews / Timeline / Accuse |
| Case archive | `archive.php` | 20 cold cases + "My accusations" filter |
| Dossier | `dossier.php` | Read-only file for archived cases |
| Field manual | `guides.php`, `guide.php` | 3 full guide articles |
| Records room | `case-files.php`, `case-file.php` | Real-case study articles |
| Sign in / badge | `auth.php` | Register, login, logout, profile |
| Standings | `standings.php` | Leaderboard (best score per detective) |
| Game API | `api/game.php` | JSON endpoint used by fetch() for evidence & interviews |

### Tech & techniques shown

- **PHP**: sessions, `password_hash()` auth, CSRF tokens, JSON file storage (`data/*.json`), form handling, server-side scoring
- **JavaScript**: tab SPA behaviour, `fetch()` API calls, localStorage notepad, dynamic DOM (corkboard, Q&A log)
- **CSS**: noir design system (Special Elite / Karla / Courier Prime — self-hosted fonts), paper & corkboard textures, responsive grid
- **Security**: CSRF check on every POST, `htmlspecialchars()` output escaping, `preg_replace` input whitelisting

### Project structure

```
detekts-clone/
├── index.php, case.php, archive.php, dossier.php
├── guides.php, guide.php, case-files.php, case-file.php
├── auth.php, standings.php
├── api/game.php              ← JSON endpoint (evidence / interviews)
├── includes/
│   ├── config.php            ← session, paths, helpers, csrf
│   ├── data.php              ← all case/story content
│   ├── auth.php              ← register / login / scores
│   ├── header.php, footer.php
├── assets/
│   ├── css/style.css         ← the whole noir design system
│   ├── js/main.js, case.js   ← shared + game logic
│   ├── img/*.png             ← AI-generated noir artwork
│   └── fonts/*.woff2         ← self-hosted fonts (works offline)
└── data/                     ← users.json, scores.json (auto-managed)
```

### Scoring

| Item | Points |
|---|---|
| Evidence bagged (5 pieces) | 5 × 5 = 25 |
| Suspects cracked (all questions asked) | 5 × 5 = 25 |
| Correct accusation | 60 |
| Correct motive | 15 |
| **Maximum case score** | **130** |

One accusation per session (one per case — like the real site). Signed-in users get their verdict recorded on the standings board.

### Resetting demo data

Delete `data/users.json` and `data/scores.json` (or empty them to `[]`) to wipe accounts and scores.

---

*Built as an educational clone. All story text, code and images in this folder were produced for this project; the original site concept belongs to detekts.com.*

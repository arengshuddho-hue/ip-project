<?php
/**
 * data.php — all case content for the game, archive, guides and case files.
 * Written for an educational clone project; story text is original.
 */

// ---------------------------------------------------------------------------
// TODAY'S CASE (the playable investigation)
// ---------------------------------------------------------------------------
const TODAY_CASE = [
    'number'      => 50,
    'title'       => 'The Silent Projector Incident',
    'stamp'       => 'UNSOLVED / OPEN',
    'filed'       => 'Nov 10, 2026',
    'victim'      => 'Orson Kestrel',
    'window'      => '20:40–21:20',
    'average'     => 72,
    'max_score'   => 130,
    'details'     => "during the theatre's opening-night reception and projection demonstration.",
    'intro'       => "You arrive at the old Rialto Theatre after a projection demonstration ends in a sudden blackout and a damaged projector. Orson Kestrel, the evening's patron, was alone in the booth when the demonstration began. No one was hurt. The building is full of opening-night talk, but the cause of the failure is still unclear.",
    'victim_note' => "Orson Kestrel was a wealthy heir and a longtime patron of the Rialto. At seventy-eight he still wanted the theatre to remember him as its benefactor. His support kept the old place open, though not everyone shared his version of its past.",
    'culprit'     => 'elliot',   // suspect id of the true culprit
    'culprit_motive' => 'motive',
    'motives'     => [
        'motive'      => 'Cover up stolen equipment before the endowment audit',
        'm-inherit'   => 'Claim the theatre before the will was changed',
        'm-career'    => 'Sabotage the show so the manager would be blamed',
        'm-grudge'    => 'Revenge for being passed over in the endowment speech',
        'm-money'     => 'Force an insurance payout to save the theatre',
        'm-silence'   => 'Silence a witness to an old accident',
    ],
    'evidence_total_score' => 100, // score if every clue is found before accusing
    'hotspots' => [ // crime-scene photo hotspots: id → label + found evidence id
        'reel'      => ['label' => 'Broken film reel',        'evidence' => 'ev-reel'],
        'glass'     => ['label' => 'Shattered relay glass',   'evidence' => 'ev-glass'],
        'panel'     => ['label' => 'Tripped breaker panel',   'evidence' => 'ev-panel'],
        'note'      => ['label' => 'Torn endowment letter',   'evidence' => 'ev-letter'],
        'keys'      => ['label' => 'Booth key rack',          'evidence' => 'ev-keys'],
    ],
    'evidence' => [
        'ev-reel'   => ['name' => 'Melted film reel',  'text' => "The 35mm reel did not snap — it melted. The film only burns hot when the projector lamp runs with the shutter jammed. Someone made sure the lamp stayed on during the blackout.", 'points' => 5],
        'ev-glass'  => ['name' => 'Relay glass shards', 'text' => "Fine glass shards sit under the relay board, not beside it. The relay was pulled apart after the blackout started, from the inside of the booth.", 'points' => 5],
        'ev-panel'  => ['name' => 'Tripped breaker',    'text' => "The basement breaker for the projection circuit was flipped at 20:38 — three minutes before the blackout. Only staff know the panel is behind the scenery store.", 'points' => 5],
        'ev-letter' => ['name' => 'Torn endowment letter','text' => "A draft letter names a coming audit of the theatre endowment and lists every recent equipment sale. The signature line is torn away, but the ribbon matches the booth typewriter.", 'points' => 5],
        'ev-keys'   => ['name' => 'Missing booth key',  'text' => "The booth key rack shows four hooks and three keys. The sign-out ledger's last line — 20:12 — is initialled with a shaky 'E.S.'", 'points' => 5],
    ],
    'suspects' => [
        [
            'id' => 'mara', 'name' => 'Mara Venn', 'role' => 'Theatre manager',
            'img' => 'assets/img/p-mara.png',
            'tie'    => "She managed the theatre and worked with him on its public events.",
            'secret' => "She valued his support but often had to balance his wishes against the needs of the venue.",
            'alibi'  => "On stage welcoming guests when the blackout hit — seen by forty people.",
            'qa' => [
                ['q' => "Where were you when the projector failed?", 'a' => "On stage, mid-speech. Forty guests will tell you the same thing. The lights died while I was asking everyone to thank Mr Kestrel."],
                ['q' => "Why was he alone in the booth?", 'a' => "He asked for it. He liked to run the projector himself on opening nights. It made him feel the Rialto still belonged to him."],
                ['q' => "What is the endowment audit?", 'a' => "A yearly paper exercise. This year he wanted every sale of old equipment documented. I told him it would upset people. He insisted."],
            ],
        ],
        [
            'id' => 'lena', 'name' => 'Lena Voss', 'role' => 'Lighting technician',
            'img' => 'assets/img/p-lena.png',
            'tie'    => "She worked on the theatre's lighting and helped prepare events he attended.",
            'secret' => "She respected his place in the theatre's life, though her working days did not always feel easy.",
            'alibi'  => "In the control room with the lighting desk logged at 20:40.",
            'qa' => [
                ['q' => "Did you touch the projection circuit?", 'a' => "Never. Lighting and projection are separate boards. Mine logged every fader move that night — check the tape if you want."],
                ['q' => "Who knows the basement panel?", 'a' => "All the crew. It sits behind the scenery store. But knowing it and standing next to it at 20:38 are two different things."],
                ['q' => "How were things with Mr Kestrel?", 'a' => "Polite. He criticized the lighting every year and paid for the upgrade every year. That was our whole relationship."],
            ],
        ],
        [
            'id' => 'tomas', 'name' => 'Tomas Reed', 'role' => 'Scenery carpenter',
            'img' => 'assets/img/p-tomas.png',
            'tie'    => "He built and repaired scenery for productions Kestrel supported.",
            'secret' => "He appreciated the patronage but wanted the work behind the show to be noticed too.",
            'alibi'  => "Carrying a flat upstage with two stagehands when the lights failed.",
            'qa' => [
                ['q' => "Anyone near the scenery store tonight?", 'a' => "People in and out all evening. Costumes, props, me. It's the busiest corner backstage — that's what nobody remembers."],
                ['q' => "Was the basement door locked?", 'a' => "It never is. Half the crew prop it open with a sandbag in summer. Tonight someone had closed it — I noticed because the sandbag was moved."],
                ['q' => "What did you hear in the dark?", 'a' => "Guests screaming upstairs, and boots on the iron stairs. Fast ones. Going up, not down."],
            ],
        ],
        [
            'id' => 'elliot', 'name' => 'Elliot Shaw', 'role' => 'House electrician',
            'img' => 'assets/img/p-elliot.png',
            'tie'    => "He maintained the theatre's electrical systems and handled service requests for events.",
            'secret' => "He took pride in the theatre's history and quietly sold 'surplus' equipment for years.",
            'alibi'  => "Claims he was checking the lobby dimmers; no one remembers seeing him.",
            'qa' => [
                ['q' => "Where were you at 20:38?", 'a' => "Lobby dimmers. There's— there was a flicker in the house left I wanted to trace. I didn't see the blackout coming, if that's what you mean."],
                ['q' => "You signed out a booth key at 20:12?", 'a' => "A routine check. The shutter sticks when it's humid. I looked at it, put the key back— look, anyone could have copied that ledger line."],
                ['q' => "Tell me about the equipment sales.", 'a' => "Surplus. Decommissioned. You don't keep dead lamps in a working theatre. The audit list would have called it something uglier."],
                ['q' => "Why flip the projection breaker?", 'a' => "I never— that panel wasn't me. Someone used my initials in that ledger and you know it."],
            ],
        ],
        [
            'id' => 'nell', 'name' => 'Nell Price', 'role' => 'Box office',
            'img' => 'assets/img/p-nell.png',
            'tie'    => "She handled ticket sales for performances Kestrel attended.",
            'secret' => "She worried the endowment would close the theatre to the neighbourhood kids.",
            'alibi'  => "At the box-office window balancing the night's takings, receipts to prove it.",
            'qa' => [
                ['q' => "Did Mr Kestrel plan to change the theatre?", 'a' => "There were letters. Lawyers. The word 'trust' came up. The rest of us just sell tickets and hope."],
                ['q' => "Anyone arguing with him lately?", 'a' => "Mr Shaw had words with him Tuesday. Through the door, so I only caught pieces. Something about an audit and being called a thief."],
                ['q' => "And the money from tonight?", 'a' => "Counted, bagged, sealed. You're welcome to check the seal. The blackout didn't stop me doing my job."],
            ],
        ],
        [
            'id' => 'ruth', 'name' => 'Ruth Bell', 'role' => 'Costume designer',
            'img' => 'assets/img/p-ruth.png',
            'tie'    => "She cared for costumes used in productions he helped fund.",
            'secret' => "She took pride in the theatre's history and defended its oldest traditions.",
            'alibi'  => "Pinning a hem in the costume room with her assistant.",
            'qa' => [
                ['q' => "What did you see after the blackout?", 'a' => "Nothing from my corner — we lit candles and kept pinning. The assistant will tell you the same."],
                ['q' => "Did you hear the argument on Tuesday?", 'a' => "Everyone did. Doors here are paper-thin. Mr Shaw's voice, mostly. The word 'audit' has a way of carrying."],
                ['q' => "Anyone in the scenery store?", 'a' => "Earlier, the carpenter. Later — I couldn't say. I heard the basement door bang twice, though. Twice means someone came back up."],
            ],
        ],
    ],
    'timeline' => [
        ['time' => '19:30', 'event' => "Opening-night reception begins in the lobby. Kestrel makes a short speech praising the theatre's history."],
        ['time' => '20:12', 'event' => "A booth key is signed out in the ledger — the shaky initials 'E.S.'"],
        ['time' => '20:30', 'event' => "Kestrel excuses himself from the reception and goes up to the projection booth alone."],
        ['time' => '20:38', 'event' => "The basement breaker for the projection circuit is switched off. The scenery-store sandbag is found moved."],
        ['time' => '20:40', 'event' => "The demonstration starts; the house falls dark. Guests hear the projector lamp still humming inside the booth."],
        ['time' => '20:52', 'event' => "Melted film and a cracked relay are discovered. Fast boots are heard climbing the iron stairs."],
        ['time' => '21:05', 'event' => "Power is restored. Kestrel, shaken but unhurt, insists the show goes on and refuses to name anyone."],
    ],
    'solution' => "Elliot Shaw signed out the booth key, flipped the basement breaker to kill the lights, and used the dark to rip the relay — the melted reel proves the lamp kept running. The torn audit letter and Tuesday's argument give him a motive: the audit would have exposed years of stolen equipment sales. His 'lobby dimmers' alibi convinced no one.",
];

// ---------------------------------------------------------------------------
// ARCHIVE — 20 cases on record (#50 is today, the rest are cold cases)
// ---------------------------------------------------------------------------
const ARCHIVE_CASES = [
    50 => ['title' => 'The Silent Projector Incident',        'date' => 'Nov 9, 2026',  'avg' => '72/130',  'img' => 'p-orson.png',  'today' => true],
    49 => ['title' => 'The Locked Assessment Room Incident',  'date' => 'Nov 8, 2026',  'avg' => '95/128',  'img' => 'p-lena.png',   'summary' => "An examiner is found sealed inside the assessment suite, and the only door logs out a name nobody wrote down."],
    48 => ['title' => 'The Silent Lift Incident',             'date' => 'Nov 7, 2026',  'avg' => '103/140', 'img' => 'p-elliot.png', 'summary' => "A hotel lift stops between floors for nine minutes. When it moves again, one passenger is gone and one is dead."],
    47 => ['title' => 'The Scorched Register Incident',       'date' => 'Nov 6, 2026',  'avg' => '180/180', 'img' => 'p-nell.png',   'summary' => "A parish register burns in a locked vestry, and the fire starts on the one page that proved a inheritance."],
    46 => ['title' => 'The Last Light at the Market',         'date' => 'Nov 5, 2026',  'avg' => '61/160',  'img' => 'p-ruth.png',   'summary' => "A market trader closes her stall for the night and never reaches the bus stop forty metres away."],
    45 => ['title' => 'The Borrowed Coat',                    'date' => 'Nov 4, 2026',  'avg' => '58/140',  'img' => 'p-tomas.png',  'summary' => "A witness describes a coat the victim owned for years — but the coat was buried with him a week before."],
    44 => ['title' => 'The Glasshouse Alibi',                 'date' => 'Nov 3, 2026',  'avg' => '88/150',  'img' => 'p-mara.png',   'summary' => "Frost on the glasshouse roof says nobody left by the door. The footprints inside say somebody never needed to."],
    43 => ['title' => 'The Ferry Timetable Incident',         'date' => 'Nov 2, 2026',  'avg' => '77/135',  'img' => 'p-orson.png',  'summary' => "A ferryman's log shows two crossings after the last ferry. Only one of them was his."],
    42 => ['title' => 'The Second Key',                       'date' => 'Nov 1, 2026',  'avg' => '92/140',  'img' => 'p-lena.png',   'summary' => "The office had one key and no spare. The locksmith who cut a third never filed the paperwork."],
    41 => ['title' => 'The Night Porter’s Ledger',            'date' => 'Oct 31, 2026', 'avg' => '101/145', 'img' => 'p-nell.png',   'summary' => "Room 14 checked out at dawn. The porter's ledger says room 14 was empty since Tuesday."],
    40 => ['title' => 'The Winter Rehearsal',                 'date' => 'Oct 30, 2026', 'avg' => '84/138',  'img' => 'p-ruth.png',   'summary' => "A director falls from the fly gallery during an empty rehearsal. The rope was cut, not frayed."],
    39 => ['title' => 'The Quiet Tenant',                     'date' => 'Oct 29, 2026', 'avg' => '70/130',  'img' => 'p-tomas.png',  'summary' => "Neighbours heard nothing for three days. The milk bottles say everything started on the first night."],
    38 => ['title' => 'The Tin Box Scheme',                   'date' => 'Oct 28, 2026', 'avg' => '96/142',  'img' => 'p-mara.png',   'summary' => "A savings club keeps its money in a tin box. The box never left the shelf, and the money did."],
    37 => ['title' => 'The Platform Two Photograph',           'date' => 'Oct 27, 2026', 'avg' => '109/150', 'img' => 'p-elliot.png', 'summary' => "A platform camera catches the suspect twice — four minutes apart, thirty miles away."],
    36 => ['title' => 'The Innkeeper’s Bill',                 'date' => 'Oct 26, 2026', 'avg' => '66/128',  'img' => 'p-orson.png',  'summary' => "An unpaid bill keeps a room reserved for a guest the innkeeper swears he never saw."],
    35 => ['title' => 'The Displaced Dust',                   'date' => 'Oct 25, 2026', 'avg' => '80/135',  'img' => 'p-lena.png',   'summary' => "The safe was dusted every morning. On the morning of the theft, the dust had been moved an inch."],
    34 => ['title' => 'The Call Box on Mill Street',          'date' => 'Oct 24, 2026', 'avg' => '91/140',  'img' => 'p-nell.png',   'summary' => "Three calls from a dead line. The exchange says the line was cut before the first call was made."],
    33 => ['title' => 'The Gardener’s Day Off',               'date' => 'Oct 23, 2026', 'avg' => '74/132',  'img' => 'p-ruth.png',   'summary' => "The greenhouse was watered on the gardener's day off — by someone who knew which beds were new."],
    32 => ['title' => 'The Overdue Library Card',             'date' => 'Oct 22, 2026', 'avg' => '87/130',  'img' => 'p-tomas.png',  'summary' => "A library card borrowed a book on the day its owner was already dead."],
    31 => ['title' => 'The Chalked Door',                     'date' => 'Oct 21, 2026', 'avg' => '78/126',  'img' => 'p-mara.png',   'summary' => "A chalk mark on a doorframe maps a route only two people in the house could read."],
];

// ---------------------------------------------------------------------------
// FIELD MANUAL (guides)
// ---------------------------------------------------------------------------
const GUIDES = [
    [
        'slug'   => 'how-to-play-a-murder-mystery-game',
        'tag'    => 'Field manual · Basics',
        'read'   => '5 min read',
        'title'  => "How to play a murder mystery game (a detective's first shift)",
        'desc'   => "A step-by-step beginner guide to playing an online murder mystery game: read the case brief, work the crime scene, interrogate suspects, and name the culprit.",
        'body'   => [
            ["h" => "Start with the dossier", "p" => "Every case opens with a brief: the victim, the time window and one paragraph of setup. Read it twice before you click anything. The brief tells you where to look first — the room, the hour, and the people worth pressing."],
            ["h" => "Work the scene", "p" => "Crime scenes in the game are photographs with hidden hotspots. Sweep the image edge to edge, then zoom on what looks out of place: a moved object, a missing key, a thing that should not be there. Every piece you bag goes to the evidence locker and to your corkboard."],
            ["h" => "Question everyone", "p" => "Interviews are optional but they are where bonus marks live. Ask about time first, then place, then relationships. When a suspect's story touches a piece of evidence you already hold, press them on it — that is how contradictions surface."],
            ["h" => "Name the culprit", "p" => "When the timeline is complete and one suspect's alibi has more holes than a colander, open the accusation tab. Choose who did it and why. The precinct grades the closing argument, and the case closes with your score."],
        ],
    ],
    [
        'slug'   => 'how-to-solve-a-detective-case-six-step-method',
        'tag'    => 'Field manual · Method',
        'read'   => '6 min read',
        'title'  => "How to solve a detective case: the six-step method",
        'desc'   => "Solve any detective case or murder mystery in 6 steps: sort facts from claims, fix the time of death, test motive and alibis, then name the culprit with proof.",
        'body'   => [
            ["h" => "1. Separate facts from claims", "p" => "Forensic reports and photographs are facts. Everything a suspect says is a claim until evidence backs it. Build two columns on your notepad and keep them apart."],
            ["h" => "2. Fix the timeline", "p" => "Most cases break open on the clock, not the weapon. Write every timestamp in order — the breaker panel at 20:38, the key at 20:12 — and look for the minutes nobody can account for."],
            ["h" => "3. Test the alibis", "p" => "An alibi is only as strong as its witness. 'Seen by forty people' is iron. 'Somewhere in the building' is paper. Press the paper ones first."],
            ["h" => "4. Follow the motive", "p" => "Money, pride, fear, revenge. The audit letter, the argument on Tuesday, the torn signature — motives leave paper trails. When two motives point at one suspect, you are close."],
            ["h" => "5. Test the theory against every clue", "p" => "A good theory explains all the evidence, including the pieces that feel unimportant. If one clue refuses to fit, the theory is wrong — not the clue."],
            ["h" => "6. Accuse with proof", "p" => "Name the culprit and state the motive in one sentence. If you cannot say it in one sentence, you are not ready to accuse."],
        ],
    ],
    [
        'slug'   => 'how-to-interrogate-suspects-and-catch-a-lie',
        'tag'    => 'Field manual · Interviews',
        'read'   => '4 min read',
        'title'  => "How to interrogate suspects and catch a lie",
        'desc'   => "Learn how to question suspects in a detective game: what to ask first, how to use evidence in an interview, and how to spot the contradiction that closes the case.",
        'body'   => [
            ["h" => "Open neutral, then narrow", "p" => "Start with 'where were you', not 'did you do it'. The first answer sets the story; every later answer is measured against it."],
            ["h" => "Let them talk before you press", "p" => "Suspects in the game answer everything you ask. The more they say, the more surface there is for cracks. Hold your best evidence back until the story is on the table."],
            ["h" => "Press with specifics", "p" => "'You signed out a key at 20:12' earns more than 'were you in the booth'. Concrete details are how a pressed suspect cracks — and cracked suspects are worth up to 10% of the case score."],
            ["h" => "Watch the change of subject", "p" => "A suspect who answers a question about time with an answer about loyalty is telling you where the wound is. Note it, circle it on the corkboard, and come back."],
        ],
    ],
];

// ---------------------------------------------------------------------------
// THE REAL CASE FILES (records room articles)
// ---------------------------------------------------------------------------
const CASE_FILES = [
    [
        'slug'  => 'the-money-at-the-rivers-edge-db-cooper',
        'tag'   => 'Case study',
        'read'  => '7 min read',
        'title' => "The Money at the River's Edge: D.B. Cooper's Serial-Number Match",
        'img'   => 'assets/img/file-cooper.png',
        'latest'=> true,
        'desc'  => "A man calling himself Dan Cooper left an airliner in flight with a parachute and $200,000, leaving investigators to reconstruct an escape without a confirmed destination. Ransom bills recovered beside the Columbia River supplied an authenticated physical link, but no confirmed turning point established his identity, landing place or survival.",
        'body'  => [
            ["h" => "The jump that opened a file", "p" => "On 24 November 1971 a passenger buying a ticket as Dan Cooper hijacked a Boeing 727 between Portland and Seattle, received four parachutes and $200,000 in used twenty-dollar bills, and ordered the aircraft back into the air. Somewhere over southwestern Washington he lowered the aft stairs and jumped into a night of rain and wind. No parachute was ever reported found, no body ever recovered, and no witness ever saw him land."],
            ["h" => "What the evidence could and could not say", "p" => "The investigation built its case on physical objects: a black clip-on tie left on seat 18E, two of the four parachutes, and the serial numbers of the ransom bills, which the FBI had recorded before release. The tie gave investigators fibres and a partial particle profile; the serial numbers gave the money a fingerprint. What none of it gave was a direction of travel after the jump."],
            ["h" => "The river answers part of the question", "p" => "In February 1980, eight years later, a boy camping with his family on the banks of the Columbia River uncovered three bundles of the ransom cash, numbering intact and matching the Cooper list. The bundles had decayed but the paper held. The find authenticated a physical link between the hijacking and a specific stretch of riverbank — yet it settled none of the open questions. The remaining bills never surfaced, and the location of the bundles fit several competing theories rather than one."],
            ["h" => "Why the case still matters", "p" => "The Cooper file remains the only unsolved air piracy case in United States commercial aviation history. For students of investigation it teaches a precise discipline: physical evidence can authenticate a connection — a bill to a list, a fibre to a tie — without ever establishing the turning point that closes a case. The anomaly at the scene is not always the answer; sometimes it is the boundary of what the evidence can say."],
        ],
    ],
    [
        'slug'  => 'a-cipher-without-a-name-the-zodiac-340',
        'tag'   => 'Case notes',
        'read'  => '7 min read',
        'img'   => 'assets/img/file-zodiac.png',
        'latest'=> false,
        'title' => "A Cipher Without a Name: The Zodiac's Decoded 340-Character Message",
        'desc'  => "In December 2020, private codebreakers solved a Zodiac cipher that had resisted interpretation for 51 years, and the FBI authenticated their solution. The words became readable; the killer's identity did not — and that distinction remains the central discipline of this cold case.",
        'body'  => [
            ["h" => "The cipher arrives", "p" => "In November 1969, the San Francisco Chronicle received a 340-character homophonic cipher mailed by the self-named Zodiac killer. It arrived months after a first cipher that had been broken within days by a husband-and-wife team, and it looked, at a glance, like more of the same. It was not. Fifty-one years of amateur and professional attack followed, and the 340 refused every one of them."],
            ["h" => "The break, and what it took", "p" => "The solution came in December 2020 from a small team of private codebreakers working with modern homophonic analysis. The cipher used a transposition scheme — reading diagonally in a patterned sweep — layered over character substitution. Once the reading order was fixed, the plaintext emerged, and the FBI's Crypt Analysis and Racketeering Records Unit authenticated it. The message taunted the police and denied being the killer's true identity. It named no one."],
            ["h" => "Readable words, unidentified author", "p" => "The 340 is now a solved cipher attached to an unsolved case. That distinction is the lesson of the file: breaking an artifact is not the same as breaking an investigation. The cipher confirmed authorship of the letters and sharpened the profile of the sender; it produced no identification, no location and no admissible trail."],
            ["h" => "The discipline of the cold case", "p" => "Investigators working cold files inherit exactly this situation: a shelf of artifacts that can each be authenticated, connected or eliminated, and a question none of them answers alone. The 340 teaches the posture the whole records room teaches — catalogue what the evidence proves, mark plainly what it does not, and resist the temptation to let an impressive artifact stand in for a proof it cannot supply."],
        ],
    ],
];

// ---------------------------------------------------------------------------
// FAQ (case notes)
// ---------------------------------------------------------------------------
const FAQS = [
    ['q' => "What is an online detective game?", 'a' => "An online detective game puts you in charge of a criminal investigation in your browser: you read a case file, search the crime scene for evidence, question suspects, and name the culprit. The Detective's Desk releases a new murder mystery case every day."],
    ['q' => "Is The Detective's Desk free to play?", 'a' => "Yes. Every daily case is free to play in the browser, with no download and no install. Guests can investigate straight away, and signing in saves your evidence, streak, and leaderboard score."],
    ['q' => "How long does one case take to solve?", 'a' => "Most detectives close a daily case in 20 to 40 minutes: a sweep of the crime scene, a few interrogations, then the timeline and the accusation."],
    ['q' => "Do I have to question the suspects to solve a case?", 'a' => "No. The case file itself — the crime scene photographs, the forensic reports and the timeline — holds what you need to name the culprit. Interrogations are optional: they are where the bonus marks live, so pressing a suspect until their story bends raises your final score without changing who did it."],
    ['q' => "Can I play older cases?", 'a' => "Yes. Once a daily mystery expires it moves to the cold-case archive, where every released case stays playable without a clock."],
];

// ---------------------------------------------------------------------------
// TOOLS OF THE TRADE (equipment cards on the landing page)
// ---------------------------------------------------------------------------
const TOOLS = [
    ['icon' => 'calendar', 'title' => "Daily case drop",        'text' => "A brand-new murder mystery is released every day. Miss one and it moves to the cold-case archive."],
    ['icon' => 'pin',      'title' => "Interactive corkboard",  'text' => "Pin evidence, photos, and your own notes, then connect them with red string until the truth snaps into place."],
    ['icon' => 'chat',     'title' => "AI interrogations",      'text' => "Question suspects in the case language. Each reply is generated in-character, so no two interviews play the same."],
    ['icon' => 'trophy',   'title' => "Precinct standings",     'text' => "Earn accuracy points, early-bird bonuses, and streak multipliers. See how your solve compares to detectives worldwide."],
    ['icon' => 'flame',    'title' => "Investigation streaks",  'text' => "Play two daily cases each week to build your streak. Any two days work, so a busy day never breaks it."],
    ['icon' => 'note',     'title' => "Detective notepad & hints", 'text' => "Jot down theories in your notepad and string your findings together on the corkboard until the story clicks."],
];

// ---------------------------------------------------------------------------
// HOW A CASE IS CLOSED (numbered paper cards)
// ---------------------------------------------------------------------------
const STEPS = [
    ['icon' => 'dossier',    'title' => "Read the dossier",      'text' => "Every morning a new case file arrives. Study the victim, the location, and the first threads of suspicion."],
    ['icon' => 'search',     'title' => "Comb the scene",        'text' => "Click through the crime-scene photographs. Hidden evidence is waiting to be bagged and tagged."],
    ['icon' => 'people',     'title' => "Interrogate suspects",  'text' => "Ask witnesses and persons of interest anything. Press them with concrete details, and they may crack, earning up to 10% of the case score."],
    ['icon' => 'scales',     'title' => "Make the accusation",   'text' => "When the pattern is clear, name the culprit and state the motive. The precinct grades your closing argument."],
];

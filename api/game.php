<?php
/**
 * api/game.php — tiny JSON endpoint the case page talks to via fetch().
 * Actions: state | find_evidence | ask
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';

header('Content-Type: application/json; charset=utf-8');

$_SESSION['case50'] ??= ['evidence' => [], 'interviews' => [], 'accused' => null];
$state = &$_SESSION['case50'];
$C = TODAY_CASE;

$body = json_decode(file_get_contents('php://input') ?: '[]', true) ?: [];
$action = (string) ($body['action'] ?? '');

if ($action !== 'state' && !csrf_check($body['csrf'] ?? null)) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'bad token']);
    exit;
}

switch ($action) {
    case 'state':
        echo json_encode(['ok' => true, 'state' => $state]);
        exit;

    case 'find_evidence':
        $id = (string) ($body['id'] ?? '');
        if (!isset($C['evidence'][$id])) {
            echo json_encode(['ok' => false, 'error' => 'unknown evidence']);
            exit;
        }
        if (!in_array($id, $state['evidence'], true) && empty($state['accused'])) {
            $state['evidence'][] = $id;
        }
        echo json_encode([
            'ok'     => true,
            'found'  => $state['evidence'],
            'count'  => count($state['evidence']),
            'total'  => count($C['evidence']),
            'item'   => ['id' => $id] + $C['evidence'][$id],
        ]);
        exit;

    case 'ask':
        $sid = (string) ($body['suspect'] ?? '');
        $qi  = (int) ($body['q'] ?? -1);
        $suspect = null;
        foreach ($C['suspects'] as $s) {
            if ($s['id'] === $sid) {
                $suspect = $s;
                break;
            }
        }
        if (!$suspect || !isset($suspect['qa'][$qi])) {
            echo json_encode(['ok' => false, 'error' => 'unknown question']);
            exit;
        }
        if (empty($state['accused'])) {
            $state['interviews'][$sid] ??= [];
            if (!in_array($qi, $state['interviews'][$sid], true)) {
                $state['interviews'][$sid][] = $qi;
            }
        }
        $asked  = count($state['interviews'][$sid]);
        $total  = count($suspect['qa']);
        echo json_encode([
            'ok'       => true,
            'q'        => $suspect['qa'][$qi]['q'],
            'a'        => $suspect['qa'][$qi]['a'],
            'asked'    => $asked,
            'total'    => $total,
            'cracked'  => $asked >= $total,
            'crackedTotal' => count(array_filter(array_map(
                fn($s) => count($state['interviews'][$s['id']] ?? []) >= count($s['qa']),
                $C['suspects']
            ))),
        ]);
        exit;

    default:
        echo json_encode(['ok' => false, 'error' => 'unknown action']);
        exit;
}

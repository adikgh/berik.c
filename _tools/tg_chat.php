<?php
// Ботқа жазылған чаттардың id-сын көрсетеді (CLI):  php _tools/tg_chat.php <бот токені>
// Алдымен ботты чатқа қосып, чатқа кез келген хабар жазыңыз.
$tok = $argv[1] ?? '';
if ($tok === '') { $f = dirname(__DIR__) . '/config/tg_conf.php'; $c = is_file($f) ? include $f : []; $tok = $c['token'] ?? ''; }
if ($tok === '') exit("Токен жоқ: php _tools/tg_chat.php <token>\n");
$r = json_decode((string)@file_get_contents('https://api.telegram.org/bot' . $tok . '/getUpdates'), true);
if (empty($r['ok'])) exit("Telegram жауап бермеді не токен қате\n");
$seen = [];
foreach ($r['result'] as $u) {
	$m = $u['message'] ?? $u['channel_post'] ?? $u['my_chat_member'] ?? null;
	if (!$m || empty($m['chat'])) continue;
	$ch = $m['chat'];
	if (isset($seen[$ch['id']])) continue;
	$seen[$ch['id']] = 1;
	echo $ch['id'] . '  ' . ($ch['title'] ?? trim(($ch['first_name'] ?? '') . ' ' . ($ch['last_name'] ?? ''))) . '  (' . $ch['type'] . ")\n";
}
if (!$seen) echo "Чат табылмады. Ботты чатқа қосып, хабар жазып, қайта іске қосыңыз\n";

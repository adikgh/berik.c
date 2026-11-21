<?php
// Жаңа заявка туралы Telegram хабары. Баптау: config/tg_conf.php (git-ке кірмейді), үлгісі tg_conf.example.php.
function tg_conf() {
	$f = __DIR__ . '/tg_conf.php';
	$c = is_file($f) ? include $f : null;
	return is_array($c) && !empty($c['token']) && !empty($c['chat_id']) ? $c : null;
}

function tg_send($text) {
	$c = tg_conf();
	if (!$c || !function_exists('curl_init')) return false;
	$ch = curl_init('https://api.telegram.org/bot' . $c['token'] . '/sendMessage');
	curl_setopt_array($ch, [
		CURLOPT_POST => true,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CONNECTTIMEOUT => 3,
		CURLOPT_TIMEOUT => 5,
		CURLOPT_POSTFIELDS => ['chat_id' => $c['chat_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'],
	]);
	$r = json_decode((string)curl_exec($ch), true);
	curl_close($ch);
	return !empty($r['ok']);
}

// Заявка мәтіні. $st: 'new' (компания ашылды), 'code' (WhatsApp кодын күтіп тұр), 'fail' (ашылмады)
function tg_lead($d, $st, $r = null) {
	$h = function ($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); };
	$types = ['fast' => 'Фастфуд', 'delivery' => 'Доставка', 'cafe' => 'Кафе, асхана', 'coffee' => 'Кофейня', 'other' => 'Басқа'];
	$head = ['new' => '🟢 Жаңа тіркелу', 'code' => '🟡 Заявка: WhatsApp кодын күтуде', 'fail' => '🔴 Заявка: тіркелу аяқталмады'][$st];
	$p = (string)$d['phone'];
	$ph = strlen($p) == 10 ? '+7 ' . substr($p, 0, 3) . ' ' . substr($p, 3, 3) . ' ' . substr($p, 6, 2) . ' ' . substr($p, 8, 2) : $p;
	$t = "<b>$head</b>\n\n"
		. '🏪 ' . $h($d['company']) . ', ' . $h($d['city']) . "\n"
		. '🍽 ' . $h($types[$d['type']] ?? $d['type']) . "\n"
		. '👤 ' . $h($d['name']) . "\n"
		. '📞 ' . $h($ph) . ' · <a href="https://wa.me/7' . $h($p) . '">WhatsApp</a>' . "\n"
		. '💳 Тариф: ' . $h(ucfirst($d['plan'])) . "\n";
	if ($d['code'] !== '') $t .= '🎁 Шақыру коды: ' . $h($d['code']) . "\n";
	if (is_array($r)) $t .= "\n" . 'Компания №' . (int)$r['cid'] . ' · касса коды ' . $h($r['code']) . ' · сынақ ' . $h($r['until']) . " дейін\n";
	if ($st == 'fail' && is_string($r)) $t .= "\nҚате: " . $h($r) . "\n";
	$t .= "\n🌐 " . $h(strtoupper($GLOBALS['lang'] ?? 'kz')) . ' · ' . date('d.m.Y H:i');
	return tg_send($t);
}

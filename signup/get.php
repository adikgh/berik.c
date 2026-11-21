<?php
// Тіркелу: ?reg (форма) → WhatsApp қосулы болса ?reg_code (растау коды) → компания ашылады. Жауап JSON.
include dirname(__DIR__) . '/config.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
function out($a) { exit(json_encode($a, JSON_UNESCAPED_UNICODE)); }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') out(['ok' => false, 'msg' => w('Қате сұрау')]);
if (!is_file(ROOT . '/config/db.php')) out(['ok' => false, 'msg' => w('Тіркеу уақытша жұмыс істемейді. WhatsApp-қа жазыңыз')]);
require ROOT . '/config/db.php';
require ROOT . '/config/wa_lib.php';
require ROOT . '/config/reg.php';
require ROOT . '/config/tg.php';
new db;
if (!db::$connect) out(['ok' => false, 'msg' => w('Тіркеу уақытша жұмыс істемейді. WhatsApp-қа жазыңыз')]);
@mysqli_set_charset(db::$connect, 'utf8mb4');
session_start();

$ip = preg_replace('/[^0-9a-f:.]/i', '', (string)@$_SERVER['REMOTE_ADDR']);
$adm = $s['adm']; $pos = $s['pos'];

function finish($d) {
	global $adm, $pos;
	$r = reg::create($d);
	if (!is_array($r)) { tg_lead($d, 'fail', $r); out(['ok' => false, 'msg' => $r]); }
	tg_lead($d, 'new', $r);
	rl_hit('reg_ok|' . $GLOBALS['ip']);
	unset($_SESSION['reg']);
	$_SESSION['reg_done'] = $r;
	out(['ok' => true, 'company' => $r['company'], 'phone' => $r['phone'], 'pin' => $r['pin'], 'until' => $r['until'],
		'adm' => $adm . '/', 'pos' => $pos . '/?code=' . rawurlencode($r['code'])]);
}

// 1) Форма
if (isset($_GET['reg'])) {
	if (trim((string)@$_POST['website']) !== '') out(['ok' => false, 'msg' => w('Қате сұрау')]); // бот
	if (rl_over('reg_ok|' . $ip, 3, 86400) || rl_over('reg_try|' . $ip, 20, 3600)) out(['ok' => false, 'msg' => w('Тым көп әрекет. Кейінірек көріңіз не WhatsApp-қа жазыңыз')]);
	rl_hit('reg_try|' . $ip);
	if (empty($_POST['agree'])) out(['ok' => false, 'msg' => w('Шарттармен келісуіңіз керек')]);
	$d = reg::check($_POST);
	if (isset($d['msg'])) out(['ok' => false] + $d);

	if (wa_on()) {
		// Нөмірді WhatsApp кодымен растаймыз
		unset($d['user']);
		$_SESSION['reg'] = $d;
		$r = otp_start('reg', 0, $d['phone']);
		if ($r == 'wait') $r = 'sent';
		if ($r == 'limit') out(['ok' => false, 'msg' => w('Код тым жиі сұралды. 15 минуттан кейін көріңіз')]);
		if ($r != 'sent') { tg_lead($d, 'fail', 'WhatsApp коды жіберілмеді'); out(['ok' => false, 'msg' => w('WhatsApp-қа код жіберілмеді. Нөмірді тексеріңіз не бізге жазыңыз')]); }
		tg_lead($d, 'code');
		out(['ok' => true, 'st' => 'code', 'phone' => wa_mask($d['phone']), 'test' => otp_test_code()]);
	}
	finish($d);
}

// 2) Растау коды
if (isset($_GET['reg_code'])) {
	$d = @$_SESSION['reg'];
	if (!$d) out(['ok' => false, 'msg' => w('Уақыт өтіп кетті. Форманы қайта толтырыңыз')]);
	$r = otp_check('reg', @$_POST['code']);
	if (!is_int($r)) {
		$m = ['wrong' => w('Код қате'), 'expired' => w('Кодтың уақыты өтті. Қайта жіберіңіз'), 'limit' => w('Тым көп әрекет. Кодты қайта жіберіңіз'), 'none' => w('Кодты қайта жіберіңіз')];
		out(['ok' => false, 'msg' => $m[$r] ?? w('Код қате')]);
	}
	// Код келгенше нөмір басқа жерден тіркелмеді ме, қайта тексереміз
	$d2 = reg::check($d + ['agree' => 1]);
	if (isset($d2['msg'])) out(['ok' => false] + $d2);
	finish($d2);
}

// Кодты қайта жіберу
if (isset($_GET['reg_resend'])) {
	$d = @$_SESSION['reg'];
	if (!$d) out(['ok' => false, 'msg' => w('Уақыт өтіп кетті. Форманы қайта толтырыңыз')]);
	$r = otp_start('reg', 0, $d['phone']);
	if ($r == 'wait') out(['ok' => false, 'msg' => w('Бір минуттан кейін қайта жіберуге болады')]);
	if ($r != 'sent') out(['ok' => false, 'msg' => w('Код тым жиі сұралды. 15 минуттан кейін көріңіз')]);
	out(['ok' => true, 'test' => otp_test_code()]);
}

out(['ok' => false, 'msg' => w('Қате сұрау')]);

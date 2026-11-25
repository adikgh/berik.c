<?
	// BERIK POS сатылым сайты: ортақ баптаулар. Байланыс пен бағаларды осы жерден өзгертесіз.
	// Тіл: ?lang=kz|ru|en|uz|ky → cookie. Мәтін кодта қазақша жазылады: w('Қазақша'), аудармасы config/words.php-та.
	define('ROOT', __DIR__);
	date_default_timezone_set('Asia/Aqtau');

	$s = [
		'name'     => 'BERIK POS',
		'phone'    => '+7 777 432 11 99',   // көрінетін нөмір
		'wa'       => '77774321199',        // WhatsApp нөмірі, тек сандар
		'tg'       => '',                   // Telegram логин, бос болса көрінбейді
		'ig'       => '',                   // Instagram логин
		'email'    => '',
		'trial'    => 14,                   // тегін күндер саны
	];

	// Live (*.gprog.kz) пен локалдың сілтемелері
	$is_live = (bool)preg_match('~gprog\.kz$~i', (string)@$_SERVER['HTTP_HOST']);
	$s['adm'] = $is_live ? 'https://admb.gprog.kz' : 'http://adm.berik.c';
	$s['pos'] = $is_live ? 'https://posb.gprog.kz' : 'http://pos.berik.c';
	$s['dlv'] = $is_live ? 'https://dlvb.gprog.kz' : 'http://dlv.berik.c';
	$s['login'] = $s['adm'];

	// ---------- тіл ----------
	$langs = ['kz' => 'Қазақша', 'ru' => 'Русский', 'en' => 'English', 'uz' => 'Oʻzbekcha', 'ky' => 'Кыргызча'];
	$lang = 'kz';
	if (isset($_GET['lang']) && isset($langs[$_GET['lang']])) {
		$lang = $_GET['lang'];
		setcookie('lang', $lang, ['expires' => time() + 3600 * 24 * 365, 'path' => '/', 'samesite' => 'Lax']);
	} elseif (isset($_COOKIE['lang']) && isset($langs[$_COOKIE['lang']])) $lang = $_COOKIE['lang'];
	$html_lang = ['kz' => 'kk', 'ru' => 'ru', 'en' => 'en', 'uz' => 'uz', 'ky' => 'ky'][$lang];

	$WORDS = null;
	// Мәтін: қазақша жол кілт болады. Аудармасы жоқ болса қазақшасы шығады.
	function w($kz) {
		global $lang, $WORDS;
		if ($lang === 'kz') return $kz;
		if ($WORDS === null) $WORDS = include ROOT.'/config/words.php';
		$i = ['ru' => 0, 'en' => 1, 'uz' => 2, 'ky' => 3][$lang];
		return isset($WORDS[$kz][$i]) && $WORDS[$kz][$i] !== '' ? $WORDS[$kz][$i] : $kz;
	}
	// %s, %d бар мәтін
	function wf($kz, ...$a) { return vsprintf(w($kz), $a); }
	function e($t) { return htmlspecialchars((string)$t, ENT_QUOTES, 'UTF-8'); }
	function we($kz) { return e(w($kz)); }
	// Сілтеме: тіл cookie-де сақталады, сондықтан ?lang= қоспаймыз
	function lang_url($l) {
		$u = strtok((string)@$_SERVER['REQUEST_URI'], '?');
		$q = $_GET; $q['lang'] = $l;
		return $u.'?'.http_build_query($q);
	}

	// ---------- тарифтер ----------
	// Тариф аты базадағы company_tariff.name-мен бірдей (Start / Pro / Max): тіркелгенде сынақ осы тарифпен ашылады.
	// mods: config/modules бойынша кодтар. Free (сынақ) — бәрі ашық.
	$plans = [
		['key' => 'free', 'name' => 'Free', 'price' => '0', 'usd' => '0', 'per' => wf('%d күн', $s['trial']),
			'for' => w('Бәрін тегін көріп шығыңыз'),
			'items' => [w('Барлық модуль ашық'), w('Карта керек емес'), w('Мәзірді енгізуге көмектесеміз')]],
		['key' => 'start', 'name' => 'Start', 'price' => '9 990', 'usd' => '19', 'per' => w('айына'),
			'for' => w('Бір кассалы шағын кафе'),
			'items' => [w('Касса және ауысым'), w('Админ, мәзір, есептер'), w('Раздача және курьер'), w('QR мәзір, онлайн тапсырыс')]],
		['key' => 'pro', 'name' => 'Pro', 'price' => '29 990', 'usd' => '49', 'per' => w('айына'), 'top' => true,
			'for' => w('Доставкасы бар кафе'),
			'items' => [w('Start-тағының бәрі'), w('Кухня экраны'), w('Склад, накладной, өзіндік құн'), w('ОПиУ, РНП, ABC анализ'), w('Акциялар мен кэшбэк'), w('Офлайн касса (Windows)')]],
		['key' => 'max', 'name' => 'Max', 'price' => '59 990', 'usd' => '99', 'per' => w('айына'),
			'for' => w('Бірнеше филиал, желі'),
			'items' => [w('Pro-дағының бәрі'), w('Бірнеше филиал бір жерде'), w('ЖИ: накладной мен мәзірді фотодан енгізу'), w('Агрегаторлар (кезекте)'), w('Жеке баптау және оқыту')]],
	];
	// Тарифтер бетіндегі салыстыру: модуль → қай тарифтен бастап
	$mods = [
		['pos', w('Касса'), 'start'], ['adm', w('Админ және есептер'), 'start'], ['dst', w('Раздача'), 'start'],
		['dlv', w('Курьер қосымшасы'), 'start'], ['online', w('QR мәзір, онлайн тапсырыс'), 'start'],
		['ktc', w('Кухня экраны'), 'pro'], ['stock', w('Склад және накладной'), 'pro'], ['fin', w('ОПиУ, РНП, ABC анализ'), 'pro'],
		['mkt', w('Акциялар мен кэшбэк'), 'pro'], ['offline', w('Офлайн касса (Windows)'), 'pro'],
		['ai', w('ЖИ көмекшісі'), 'max'], ['net', w('Филиалдар желісі'), 'max'], ['agg', w('Яндекс Еда, Glovo, Wolt'), 'max'],
	];

	$wa_link = 'https://wa.me/'.$s['wa'].'?text='.rawurlencode(w('Сәлеметсіз бе! BERIK POS туралы білгім келеді.'));
	$v = @filemtime(__DIR__.'/assets/css/site.css').'-'.@filemtime(__DIR__.'/assets/js/site.js');

	// 3D сурет: файлы бар болса ғана шығады
	function obj3d($n, $cls = '', $alt = '') {
		$f = '/assets/img/3d/'.$n.'.webp';
		if (!is_file(ROOT.$f)) $f = '/assets/img/3d/'.$n.'.png';
		if (!is_file(ROOT.$f)) return '';
		return '<img class="o3d '.$cls.'" src="'.$f.'?v='.@filemtime(ROOT.$f).'" alt="'.e($alt).'" loading="lazy" decoding="async">';
	}

	// Иконкалар (inline SVG, бір жиын, stroke 1.5)
	function icon($n) {
		$p = [
			'check' => '<path d="M20 6 9 17l-5-5"/>',
			'x'     => '<path d="M18 6 6 18M6 6l12 12"/>',
			'cash'  => '<rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2.5"/><path d="M6 10v4M18 10v4"/>',
			'chef'  => '<path d="M6 13.9A4 4 0 0 1 7 6a5 5 0 0 1 10 0 4 4 0 0 1 1 7.9V20H6z"/><path d="M6 17h12"/>',
			'box'   => '<path d="M21 8 12 3 3 8v8l9 5 9-5z"/><path d="m3 8 9 5 9-5M12 13v8"/>',
			'bike'  => '<circle cx="5.5" cy="17" r="3"/><circle cx="18.5" cy="17" r="3"/><path d="M15 6h2l3 11M5.5 17 9 9h6l-3.5 8M9 9 7.5 6H5"/>',
			'user'  => '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>',
			'chart' => '<path d="M3 3v18h18"/><path d="M7 15l4-4 3 3 5-6"/>',
			'map'   => '<path d="M9 4 3 6v14l6-2 6 2 6-2V4l-6 2z"/><path d="M9 4v14M15 6v14"/>',
			'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
			'coin'  => '<circle cx="12" cy="12" r="9"/><path d="M9 9h4.5a1.5 1.5 0 0 1 0 3H10a1.5 1.5 0 0 0 0 3h5M12 7v2M12 15v2"/>',
			'lock'  => '<rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/>',
			'qr'    => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h3v3M21 14v7h-4M14 18v3"/>',
			'store' => '<path d="M3 9 5 4h14l2 5M3 9h18v2a3 3 0 0 1-6 0 3 3 0 0 1-6 0 3 3 0 0 1-6 0zM5 13v7h14v-7"/><path d="M10 20v-4h4v4"/>',
			'phone' => '<rect x="6" y="2" width="12" height="20" rx="3"/><path d="M11 18h2"/>',
			'wifi'  => '<path d="M2 2l20 20M8.5 16.5a5 5 0 0 1 7 0M5 13a10 10 0 0 1 5.2-2.7M19 13a10 10 0 0 0-2.3-1.6M12 20h.01"/>',
			'gift'  => '<rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13M19 12v9H5v-9M7.5 8a2.5 2.5 0 0 1 0-5C11 3 12 8 12 8s1-5 4.5-5a2.5 2.5 0 0 1 0 5"/>',
			'spark' => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4M6 6l2.5 2.5M15.5 15.5 18 18M6 18l2.5-2.5M15.5 8.5 18 6"/>',
			'receipt'=> '<path d="M5 3h14v18l-2.5-1.5L14 21l-2-1.5L10 21l-2.5-1.5L5 21z"/><path d="M9 8h6M9 12h6M9 16h3"/>',
			'globe' => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/>',
			'arrow' => '<path d="M5 12h14M13 6l6 6-6 6"/>',
			'down'  => '<path d="m6 9 6 6 6-6"/>',
			'wa'    => '<path d="M3.5 20.5 5 16a8.5 8.5 0 1 1 3 3z"/><path d="M9 9.5c0 3 2.5 5.5 5.5 5.5l1-1.5-2-1-1 .8a4 4 0 0 1-2-2l.8-1-1-2z"/>',
			'mail'  => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
			'tg'    => '<path d="M21 4 3 11l6 2 2 6 3-4 5 4z"/><path d="m9 13 8-6"/>',
			'dl'    => '<path d="M12 3v12M7 10l5 5 5-5M4 20h16"/>',
			'print' => '<path d="M7 9V3h10v6"/><rect x="3" y="9" width="18" height="8" rx="2"/><path d="M7 14h10v7H7z"/>',
			'sync'  => '<path d="M20 11a8 8 0 0 0-14.5-4.5L4 8M4 4v4h4M4 13a8 8 0 0 0 14.5 4.5L20 16M20 20v-4h-4"/>',
			'win'   => '<rect x="3" y="4" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/>',
			'bell'  => '<path d="M6 16V11a6 6 0 0 1 12 0v5l2 2H4z"/><path d="M10 21h4"/>',
			'help'  => '<circle cx="12" cy="12" r="9"/><path d="M9.5 9.5a2.5 2.5 0 0 1 5 0c0 1.5-2.5 2-2.5 3.5M12 17h.01"/>',
			'shield'=> '<path d="M12 3 5 6v6c0 4 3 7.5 7 9 4-1.5 7-5 7-9V6z"/><path d="m9 12 2 2 4-4"/>',
			'cup'   => '<path d="M4 8h13v5a6 6 0 0 1-6 6h-1a6 6 0 0 1-6-6zM17 10h1.5a2.5 2.5 0 0 1 0 5H17M8 3v2M12 3v2"/>',
		];
		return '<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.($p[$n] ?? '').'</svg>';
	}

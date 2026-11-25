<?
	include dirname(__DIR__).'/config.php';
	require ROOT.'/config/poswin.php';
	$pw = poswin_latest();
	$pw_meta = $pw ? 'v'.$pw['ver'].' · '.round($pw['size'] / 1048576).' '.w('МБ') : 'Windows';
	$page = [
		'id'    => 'app',
		'title' => w('Windows-қа арналған касса программасы | BERIK POS'),
		'desc'  => w('BERIK POS касса программасы Windows 7, 8, 10, 11-ге: интернетсіз сатады, чекті диалогсыз басады, кухня чегін бөлек принтерге жібереді, өзі жаңарады.'),
	];
	$cta_h = w('Программаны сынақ кезінде тегін қолданыңыз');
	include ROOT.'/block/head.php';
	include ROOT.'/block/header.php';
?>
<main>
<section class="ph">
	<div class="wrap ph_split ph_app">
		<div>
			<div class="crumb rv"><a href="/"><?=we('Басты бет')?></a><span>/</span><span><?=we('Касса программасы')?></span></div>
			<h1 class="rv"><?=we('Интернет өшсе де касса сата береді')?></h1>
			<p class="lead rv"><?=we('Windows-қа орнатылатын касса программасы. Тапсырыс компьютердің өзінде сақталады, интернет болса бірден серверге кетеді, болмаса қосылғанда өзі жібереді.')?></p>
			<div class="hero_btn rv">
				<a class="btn btn_lg" href="/app/dl.php" rel="nofollow"><?=icon('dl')?><?=we('Жүктеу')?></a>
				<a class="btn btn_lg btn_soft" href="#setup"><?=we('Қалай орнатылады')?></a>
			</div>
			<p class="dl_meta rv"><span class="tk"><?=e($pw_meta)?></span><?=we('Windows 7 SP1, 8, 10, 11 · Pro тарифінде, сынақ кезінде тегін')?></p>
		</div>
		<div class="rv"><? include ROOT.'/block/win.php' ?></div>
	</div>
</section>

<section class="sec">
	<div class="wrap">
		<div class="sec_h rv">
			<h2><?=we('Браузердегі кассадан не айырмашылығы бар')?></h2>
			<p><?=we('Касса сол, мәзір де сол. Программа оған интернетсіз жұмыс пен принтерді қосады')?></p>
		</div>
		<div class="feat feat3">
			<? foreach ([
				['wifi', w('Интернетсіз сатады'), w('Касса компьютердің өзінде жұмыс істейді. Байланыс үзілсе, тапсырыс пен ауысым жоғалмайды.')],
				['sync', w('Өзі синхрондайды'), w('Интернет болса әр минут сайын тапсырыстарды жібереді, мәзір мен баптауды алады.')],
				['print', w('Чек диалогсыз басылады'), w('«Сақтау» басылғанда чек бірден шығады, принтер таңдау терезесі ашылмайды.')],
				['chef', w('Кухня чегі бөлек принтерге'), w('Клиент чегі кассада, кухня чегі аспаздың принтерінде шығады.')],
				['bell', w('Сайттан тапсырыс дыбыспен'), w('QR мәзір мен сайттан келген тапсырыс дыбыспен шығады, «Қабылдау» басылады.')],
				['shield', w('Өзі жаңарады'), w('Жаңа нұсқа шыққанда программа өзі жаңарады, қайта орнату керек емес.')],
			] as $f): ?>
			<div class="ft rv"><span class="ft_i"><?=icon($f[0])?></span><h3><?=e($f[1])?></h3><p><?=e($f[2])?></p></div>
			<? endforeach ?>
		</div>
	</div>
</section>

<section class="sec sec_soft">
	<div class="wrap">
		<div class="split">
			<div class="split_t rv">
				<span class="eyebrow"><?=we('Офлайн режим')?></span>
				<h2><?=we('Интернет жоқта не істейді, не істемейді')?></h2>
				<p><?=we('Кассаға керектің бәрі компьютерде тұрады. Клиент базасы мен кэшбэк қауіпсіздік үшін тек серверде, сондықтан олар интернет келгенде ғана көрінеді.')?></p>
			</div>
			<div class="box rv">
				<div class="box_h"><b><?=we('Интернетсіз')?></b></div>
				<ul class="chk chk_t">
					<li><?=icon('check')?><?=we('Тапсырыс қабылдау, чек басу')?></li>
					<li><?=icon('check')?><?=we('Мәзір, баға, стоп-лист, жеткізу аймақтары')?></li>
					<li><?=icon('check')?><?=we('Ауысым ашу және жабу')?></li>
					<li><?=icon('check')?><?=we('Кухня чегі')?></li>
					<li class="off"><?=icon('x')?><?=we('Клиент базасы мен кэшбэк, интернет келгенде')?></li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="sec" id="setup">
	<div class="wrap">
		<div class="sec_h rv">
			<h2><?=we('Орнату 5 минут')?></h2>
			<p><?=we('Компания коды тіркелгенде беріледі, админде де тұрады')?></p>
		</div>
		<ol class="steps">
			<li class="rv"><span class="tk">01</span><b><?=we('Жүктейсіз')?></b><small><?=we('Соңғы нұсқа осы беттен')?></small></li>
			<li class="rv"><span class="tk">02</span><b><?=we('Орнатасыз')?></b><small><?=we('Әрі қарай, әрі қарай, дайын')?></small></li>
			<li class="rv"><span class="tk">03</span><b><?=we('Компания кодын жазасыз')?></b><small><?=we('Бір рет, программа компьютерді есте сақтайды')?></small></li>
			<li class="rv"><span class="tk">04</span><b><?=we('PIN-мен кіресіз')?></b><small><?=we('Кассир өз PIN кодымен ауысым ашады')?></small></li>
		</ol>
		<div class="more rv"><a class="btn btn_lg" href="/app/dl.php" rel="nofollow"><?=icon('dl')?><?=we('Жүктеу')?></a></div>
	</div>
</section>

<section class="sec sec_soft">
	<div class="wrap wrap_n">
		<div class="sec_h rv"><h2><?=we('Сұрақтар')?></h2></div>
		<div class="faq rv">
			<details><summary><?=we('Қандай компьютер керек?')?><?=icon('down')?></summary><p><?=we('Windows 7 SP1, 8, 10 не 11 орнатылған кез келген компьютер не моноблок, 32 және 64 бит. Чек принтері Windows-та орнатылған болса жетеді.')?></p></details>
			<details><summary><?=we('Программа тегін бе?')?><?=icon('down')?></summary><p><?=wf('Программа Pro және Max тарифтерінде бар. Алғашқы %d күн барлық модуль тегін, программа да.', $s['trial'])?></p></details>
			<details><summary><?=we('Бір мекемеде бірнеше компьютерге қоюға бола ма?')?><?=icon('down')?></summary><p><?=we('Иә. Әр компьютер өз кассасы болып тіркеледі, тапсырыстар бір серверге жиналады.')?></p></details>
			<details><summary><?=we('Чек шықпаса не істеймін?')?><?=icon('down')?></summary><p><?=we('Программаның «Принтер» мәзірінен чек принтерін таңдаңыз. «Microsoft Print to PDF» сияқты виртуал принтер таңдалып қалмағанын тексеріңіз. Болмаса WhatsApp-қа жазыңыз, қашықтан көмектесеміз.')?></p></details>
			<details><summary><?=we('Браузердегі кассамен бірге қолдануға бола ма?')?><?=icon('down')?></summary><p><?=we('Иә. Бір кассир программада, екіншісі планшетте браузерде сата алады. Барлық тапсырыс бір жерде көрінеді.')?></p></details>
		</div>
	</div>
</section>

<? include ROOT.'/block/cta.php' ?>
</main>
<? include ROOT.'/block/footer.php' ?>

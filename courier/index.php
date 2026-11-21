<?
	include dirname(__DIR__).'/config.php';
	$page = [
		'id'    => 'courier',
		'title' => w('Доставкаға | BERIK POS'),
		'desc'  => wf('Курьер қосымшасы телефонда: тапсырыстар, мекенжай, төлем түрі. Жеткізу аймақтары және курьердің күндік есебі. %d күн тегін.', $s['trial']),
	];
	$cta_h = w('Жеткізуді ретке келтірейік');
	include ROOT.'/block/head.php';
	include ROOT.'/block/header.php';
?>
<main>
<section class="ph">
	<div class="wrap ph_split">
		<div>
			<div class="crumb rv"><a href="/"><?=we('Басты бет')?></a><span>/</span><span><?=we('Доставкаға')?></span></div>
			<h1 class="rv"><?=we('Курьер тапсырысты телефоннан көреді, сіз ақшаны көресіз')?></h1>
			<p class="lead rv"><?=we('Мекенжай, клиент нөмірі, төлем түрі курьердің телефонында. Күн соңында кім неше тапсырыс жеткізгені және кассаға қанша тапсыратыны дайын тұрады.')?></p>
			<div class="hero_btn rv"><a class="btn btn_lg" href="/signup/"><?=we('Тегін бастау')?><?=icon('arrow')?></a><a class="btn btn_lg btn_soft" href="#report"><?=we('Күндік есеп')?></a></div>
		</div>
		<div class="rv"><?=obj3d('bag', '', w('Курьер сөмкесі'))?></div>
	</div>
</section>

<section class="sec">
	<div class="wrap">
		<div class="sec_h rv"><h2><?=we('Жеткізуде ең көп уақыт алатын үш сұрақ')?></h2><p><?=we('Үшеуінің жауабы бір экранда')?></p></div>
		<div class="cards3">
			<div class="ft rv"><span class="ft_i"><?=icon('bike')?></span><h3><?=we('«Курьер қайда?»')?></h3><p><?=we('Әр тапсырыстың күйі көрінеді: кухняда, жиналды, жолда, жеткізілді. Қай курьерде екені және қашан шыққаны жазылады.')?></p></div>
			<div class="ft rv"><span class="ft_i"><?=icon('coin')?></span><h3><?=we('«Ақша кімде?»')?></h3><p><?=we('Курьер жинаған қолма-қол мен Kaspi тапсырыс бойынша есептеледі, өз ақысы шегеріледі.')?></p></div>
			<div class="ft rv"><span class="ft_i"><?=icon('map')?></span><h3><?=we('«Жеткізу қанша тұрады?»')?></h3><p><?=we('Қала аймақтарға бөлінеді. Кассир аймақты таңдаса, бағасы чекке өзі қосылады.')?></p></div>
		</div>
	</div>
</section>

<section class="sec sec_soft">
	<div class="wrap">
		<div class="split">
			<div class="split_t rv">
				<span class="eyebrow"><?=we('Жеткізу аймақтары')?></span>
				<h2><?=we('Әр аймаққа өз бағасы мен уақыты')?></h2>
				<p><?=we('Қаланы өзіңізге ыңғайлы аймақтарға бөлесіз. Белгілі сомадан асса, жеткізуді тегін етуге болады.')?></p>
			</div>
			<div class="box rv">
				<table class="tbl">
					<thead><tr><th><?=we('Аймақ')?></th><th class="r"><?=we('Баға')?></th><th class="r"><?=we('Уақыт')?></th><th class="r"><?=we('Тегін')?></th></tr></thead>
					<tbody>
						<tr><td><?=we('1-аймақ, орталық')?></td><td class="r">500 ₸</td><td class="r">30 <?=we('мин')?></td><td class="r">8 000 ₸</td></tr>
						<tr><td><?=we('2-аймақ')?></td><td class="r">700 ₸</td><td class="r">45 <?=we('мин')?></td><td class="r">10 000 ₸</td></tr>
						<tr><td><?=we('3-аймақ, шеткі')?></td><td class="r">1 000 ₸</td><td class="r">60 <?=we('мин')?></td><td class="r">15 000 ₸</td></tr>
						<tr><td><?=we('Қала сырты')?></td><td class="r">1 500 ₸</td><td class="r">75 <?=we('мин')?></td><td class="r">—</td></tr>
					</tbody>
				</table>
				<p class="note"><?=we('Мысал. Аймақтар мен бағаларды админде өзіңіз қоясыз')?></p>
			</div>
		</div>

		<div class="split split_r" id="report">
			<div class="split_t rv">
				<span class="eyebrow"><?=we('Курьердің күндік есебі')?></span>
				<h2><?=we('Кешке ақшаны санап отырмайсыз')?></h2>
				<p><?=we('Ауысым соңында әр курьер бойынша есеп шығады. Kaspi курьерге түсетіндіктен, ол да жиналған ақшаға кіреді. Есеп сақталады, кейін ашып қарауға болады.')?></p>
				<ul class="chk"><li><?=icon('check')?><?=we('Курьер тек өз тапсырыстарын көреді')?></li><li><?=icon('check')?><?=we('Клиентке бір басумен қоңырау')?></li><li><?=icon('check')?><?=we('Қосымша орнатпайды, браузерде ашылады')?></li></ul>
			</div>
			<div class="box rv">
				<div class="box_h"><b>Ержан Сапаров</b><small>10:00–23:00</small></div>
				<div class="rows">
					<div><span><?=we('Жеткізілген тапсырыс')?></span><b class="num" data-to="18">18</b></div>
					<div><span><?=we('Қолма-қол')?></span><b>38 200 ₸</b></div>
					<div><span>Kaspi</span><b>74 200 ₸</b></div>
					<div><span><?=we('Курьер ақысы')?></span><b>−12 600 ₸</b></div>
					<div class="tot"><span><?=we('Кассаға')?></span><b class="num" data-to="99800">99 800 ₸</b></div>
				</div>
				<p class="note"><?=we('Мысал есеп. Кассаға = жиналған қолма-қол мен Kaspi, минус курьер ақысы')?></p>
			</div>
		</div>
	</div>
</section>

<? include ROOT.'/block/cta.php' ?>
</main>
<? include ROOT.'/block/footer.php' ?>

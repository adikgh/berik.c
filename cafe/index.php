<?
	include dirname(__DIR__).'/config.php';
	$page = [
		'id'    => 'cafe',
		'title' => w('Кафеге | BERIK POS'),
		'desc'  => wf('Кафеге арналған касса: зал, өзімен алу, жеткізу, кухня экраны, өзіндік құн, склад және ауысым есебі. %d күн тегін.', $s['trial']),
	];
	$cta_h = w('Кафеңізде бүгін көріп көріңіз');
	include ROOT.'/block/head.php';
	include ROOT.'/block/header.php';
?>
<main>
<section class="ph">
	<div class="wrap ph_split">
		<div>
			<div class="crumb rv"><a href="/"><?=we('Басты бет')?></a><span>/</span><span><?=we('Кафеге')?></span></div>
			<h1 class="rv"><?=we('Кассадан кухняға дейін бір тапсырыс, бір экран')?></h1>
			<p class="lead rv"><?=we('Кассир тапсырысты енгізген сәтте аспаз оны экраннан көреді. Әр тағамның өзіндік құны, складтағы қалдық және ауысым кассасы өзі есептеледі.')?></p>
			<div class="hero_btn rv"><a class="btn btn_lg" href="/signup/"><?=we('Тегін бастау')?><?=icon('arrow')?></a><a class="btn btn_lg btn_soft" href="#cost"><?=we('Өзіндік құн қалай есептеледі')?></a></div>
		</div>
		<div class="rv"><?=obj3d('burger', '', w('Бургер, фри және сусын'))?></div>
	</div>
</section>

<section class="sec">
	<div class="wrap">
		<div class="split">
			<div class="split_t rv">
				<span class="eyebrow"><?=we('Кухня экраны')?></span>
				<h2><?=we('Аспаз кезекті көреді, кассир дайынын біледі')?></h2>
				<p><?=we('Тапсырыс кухняға бірден түседі. Қайсысы неше минут күтіп тұрғаны көрінеді, кешігіп жатқаны ерекшеленеді.')?></p>
				<ul class="chk"><li><?=icon('check')?><?=we('Зал, өзімен алу, жеткізу бір кезекте')?></li><li><?=icon('check')?><?=we('Тағамға пікір: «пиязсыз», «ащы емес»')?></li><li><?=icon('check')?><?=we('Алдын ала тапсырыс уақытында түседі')?></li></ul>
			</div>
			<div class="box rv">
				<div class="box_h"><b><?=we('Кухня')?> · 3</b><small>13:12</small></div>
				<div class="kitch">
					<div class="kt"><div class="kt_h"><span class="tk">№312</span><em class="late">14 <?=we('мин')?></em></div><small><?=we('Зал · 4-үстел')?></small><div>2× <?=we('Лағман')?></div><div>1× <?=we('Манты, 5 дана')?></div><div class="ph_btn"><?=we('Дайын')?></div></div>
					<div class="kt"><div class="kt_h"><span class="tk">№313</span><em>6 <?=we('мин')?></em></div><small><?=we('Өзімен алу')?></small><div>1× <?=we('Дабл бургер')?></div><small><?=we('Пиязсыз')?></small><div class="ph_btn"><?=we('Дайын')?></div></div>
					<div class="kt"><div class="kt_h"><span class="tk">№314</span><em>1 <?=we('мин')?></em></div><small><?=we('Жеткізу')?></small><div>2× <?=we('Лаваш тауық')?></div><div>2× <?=we('Кола 0.5')?></div><div class="ph_btn"><?=we('Дайын')?></div></div>
				</div>
			</div>
		</div>

		<div class="split split_r" id="cost">
			<div class="split_t rv">
				<span class="eyebrow"><?=we('Өзіндік құн')?></span>
				<h2><?=we('Қай тағам табыс әкелетінін білесіз')?></h2>
				<p><?=we('Тағам құрамын бір рет енгізесіз. Накладной бойынша шикізат бағасы өзгерсе, өзіндік құн да қайта есептеледі.')?></p>
				<ul class="chk"><li><?=icon('check')?><?=we('Накладной фотодан не Excel-ден')?></li><li><?=icon('check')?><?=we('Склад қалдығы нақты уақытта')?></li><li><?=icon('check')?><?=we('Әр тағамның маржасы мен ABC тобы')?></li></ul>
			</div>
			<div class="box rv">
				<div class="box_h"><b><?=we('Чизбургер')?></b><small><?=we('Сату бағасы')?> 1 900 ₸</small></div>
				<table class="tbl">
					<thead><tr><th><?=we('Шикізат')?></th><th class="r"><?=we('Мөлшері')?></th><th class="r"><?=we('Құны')?></th></tr></thead>
					<tbody>
						<tr><td><?=we('Булочка')?></td><td class="r">1 <?=we('дана')?></td><td class="r">110 ₸</td></tr>
						<tr><td><?=we('Сиыр котлеті')?></td><td class="r">120 <?=we('г')?></td><td class="r">420 ₸</td></tr>
						<tr><td><?=we('Чеддер')?></td><td class="r">20 <?=we('г')?></td><td class="r">90 ₸</td></tr>
						<tr><td><?=we('Соус, көкөніс')?></td><td class="r">45 <?=we('г')?></td><td class="r">75 ₸</td></tr>
						<tr><td><?=we('Қорап, салфетка')?></td><td class="r">1</td><td class="r">65 ₸</td></tr>
					</tbody>
				</table>
				<div class="rows" style="margin-top:8px"><div><span><?=we('Өзіндік құн')?> · 40%</span><b>760 ₸</b></div><div class="tot"><span><?=we('Пайда')?> · 60%</span><b>1 140 ₸</b></div></div>
				<p class="note"><?=we('Мысал. Сандар сіздің бағаларыңызбен есептеледі')?></p>
			</div>
		</div>

		<div class="split">
			<div class="split_t rv">
				<span class="eyebrow"><?=we('Ауысым')?></span>
				<h2><?=we('Ауысым жабылғанда касса өзі есептеледі')?></h2>
				<p><?=we('Кассир ауысымды ашқанда кассадағы ақшаны жазады. Жапқанда жүйе қолма-қол, Kaspi және карта бойынша қанша болуы керегін көрсетеді.')?></p>
			</div>
			<div class="box rv">
				<div class="box_h"><b><?=we('Ауысым')?> <span class="tk">№86</span></b><small>09:00–22:00</small></div>
				<div class="rows">
					<div><span><?=we('Чек саны')?></span><b class="num" data-to="143">143</b></div>
					<div><span><?=we('Орташа чек')?></span><b>3 260 ₸</b></div>
					<div><span>Kaspi</span><b>281 900 ₸</b></div>
					<div><span><?=we('Карта')?></span><b>64 300 ₸</b></div>
					<div><span><?=we('Қолма-қол')?></span><b>119 980 ₸</b></div>
					<div class="tot"><span><?=we('Барлығы')?></span><b class="num" data-to="466180">466 180 ₸</b></div>
				</div>
				<p class="note"><?=we('Мысал есеп')?></p>
			</div>
		</div>
	</div>
</section>

<section class="sec sec_soft">
	<div class="wrap">
		<div class="sec_h rv"><h2><?=we('Әр қызметкер өз бөлімін ғана көреді')?></h2><p><?=we('Құқықтарды өзіңіз бересіз')?></p></div>
		<div class="cards4">
			<div class="ft rv"><span class="ft_i"><?=icon('cash')?></span><h3><?=we('Кассир')?></h3><p><?=we('Тапсырыс, төлем, ауысым. Кассаға PIN кодпен кіреді')?></p></div>
			<div class="ft rv"><span class="ft_i"><?=icon('chef')?></span><h3><?=we('Аспаз')?></h3><p><?=we('Кухня экраны, стоп-лист, накладной')?></p></div>
			<div class="ft rv"><span class="ft_i"><?=icon('box')?></span><h3><?=we('Раздача')?></h3><p><?=we('Дайын тапсырыстар, курьерге беру')?></p></div>
			<div class="ft rv"><span class="ft_i"><?=icon('chart')?></span><h3><?=we('Иесі')?></h3><p><?=we('Бәрі, кез келген жерден, телефоннан да')?></p></div>
		</div>
	</div>
</section>

<? include ROOT.'/block/cta.php' ?>
</main>
<? include ROOT.'/block/footer.php' ?>

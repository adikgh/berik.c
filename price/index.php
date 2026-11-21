<?
	include dirname(__DIR__).'/config.php';
	$page = [
		'id'    => 'price',
		'title' => w('Тарифтер | BERIK POS'),
		'desc'  => wf('BERIK POS тарифтері: Start 9 990 ₸, Pro 29 990 ₸, Max 59 990 ₸ айына. %d күн тегін, ұзақ мерзімге сыйлық айлар.', $s['trial']),
	];
	include ROOT.'/block/head.php';
	include ROOT.'/block/header.php';
	$ord = ['start' => 1, 'pro' => 2, 'max' => 3];
?>
<main>
<section class="ph">
	<div class="wrap">
		<div class="crumb rv"><a href="/"><?=we('Басты бет')?></a><span>/</span><span><?=we('Тарифтер')?></span></div>
		<div class="ph_in">
			<h1 class="rv"><?=we('Кафеңіздің көлеміне қарай тариф')?></h1>
			<p class="lead rv"><?=wf('Тіркелгенде %d күн бойы барлық модуль тегін ашылады. Сосын керек тарифті таңдап, Kaspi арқылы төлейсіз.', $s['trial'])?></p>
		</div>
	</div>
</section>

<section class="sec" style="padding-top:32px">
	<div class="wrap">
		<? include ROOT.'/block/plans.php' ?>
	</div>
</section>

<section class="sec sec_soft">
	<div class="wrap">
		<div class="sec_h rv"><h2><?=we('Модульдерді салыстыру')?></h2><p><?=we('Әр тариф алдыңғысының бәрін қамтиды')?></p></div>
		<div class="cmp_w rv">
			<table class="cmp">
				<thead><tr><th><?=we('Модуль')?></th><th>Start<small>9 990 ₸</small></th><th class="col_top">Pro<small>29 990 ₸</small></th><th>Max<small>59 990 ₸</small></th></tr></thead>
				<tbody>
				<? foreach ($mods as $m): ?>
				<tr><td><?=e($m[1])?></td>
					<? foreach ($ord as $k => $n): ?><td class="<?=$k == 'pro' ? 'col_top' : ''?>"><?=$n >= $ord[$m[2]] ? icon('check') : '<span class="no">—</span>'?></td><? endforeach ?>
				</tr>
				<? endforeach ?>
				</tbody>
			</table>
		</div>
		<p class="note" style="text-align:center"><?=we('Касса, филиал, тағам және ай сайынғы тапсырыс лимиттері тарифке байланысты. Нақтысын тіркелгеннен кейін «Оплата» бетінде көресіз.')?></p>
	</div>
</section>

<section class="sec">
	<div class="wrap">
		<div class="sec_h rv"><h2><?=we('Ұзақ мерзімге сыйлық айлар')?></h2><p><?=we('Жеңілдік емес, қосымша тегін ай')?></p></div>
		<div class="bonus">
			<div class="rv"><b>6 <?=we('ай')?> <em>+1</em></b><p><?=we('6 айға төлесеңіз, 7 ай қолданасыз')?></p></div>
			<div class="rv"><b>12 <?=we('ай')?> <em>+2</em></b><p><?=we('12 айға төлесеңіз, 14 ай қолданасыз')?></p></div>
			<div class="rv"><b>24 <?=we('ай')?> <em>+6</em></b><p><?=we('24 айға төлесеңіз, 30 ай қолданасыз')?></p></div>
		</div>
	</div>
</section>

<section class="sec sec_soft">
	<div class="wrap wrap_n">
		<div class="sec_h rv"><h2><?=we('Төлем туралы')?></h2></div>
		<div class="faq rv">
			<details><summary><?=we('Қалай төлеймін?')?><?=icon('down')?></summary><p><?=we('Админдегі «Оплата» бетінде Kaspi QR бар. Төлеп, чекті WhatsApp-қа жібересіз, мерзім ұзартылады.')?></p></details>
			<details><summary><?=we('Тарифті кейін ауыстыруға бола ма?')?><?=icon('down')?></summary><p><?=we('Иә, кез келген уақытта. Жаңа тариф келесі төлемнен бастап қолданылады.')?></p></details>
			<details><summary><?=we('Сынақ біткенде деректер өшіп қала ма?')?><?=icon('down')?></summary><p><?=we('Жоқ. Мәзір, тапсырыстар мен есептер сақталады. Төлегеннен кейін жұмысты сол жерден жалғастырасыз.')?></p></details>
			<details><summary><?=we('Шақыру бонусы қалай есептеледі?')?><?=icon('down')?></summary><p><?=we('Сіз шақырған компания төлеген әр айдан бонус аласыз: алғашқы 3 айда 30%, 12-айға дейін 10%, 24-айға дейін 5%, кейін 1%. Бонуспен өз жазылымыңызды төлей аласыз.')?></p></details>
		</div>
	</div>
</section>

<? include ROOT.'/block/cta.php' ?>
</main>
<? include ROOT.'/block/footer.php' ?>

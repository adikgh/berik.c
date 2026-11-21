<?
	include dirname(__DIR__).'/config.php';
	$page = [
		'id'    => 'contacts',
		'title' => w('Байланыс | BERIK POS'),
		'desc'  => w('BERIK POS-пен байланыс: WhatsApp, телефон. Тіркелуге, мәзірді енгізуге және баптауға көмектесеміз.'),
	];
	include ROOT.'/block/head.php';
	include ROOT.'/block/header.php';
?>
<main>
<section class="ph">
	<div class="wrap ph_split">
		<div>
			<div class="crumb rv"><a href="/"><?=we('Басты бет')?></a><span>/</span><span><?=we('Байланыс')?></span></div>
			<h1 class="rv"><?=we('Сұрағыңыз болса, жазыңыз')?></h1>
			<p class="lead rv"><?=we('Тіркелуге, мәзірді енгізуге, принтер мен кассаны баптауға көмектесеміз. Әдетте WhatsApp-қа 15 минут ішінде жауап береміз.')?></p>
		</div>
		<div class="rv"><?=obj3d('boxes')?></div>
	</div>
</section>
<section class="sec" style="padding-top:32px">
	<div class="wrap">
		<div class="cont">
			<a class="rv" href="<?=e($wa_link)?>" target="_blank" rel="noopener"><?=icon('wa')?><b>WhatsApp</b><small><?=e($s['phone'])?></small></a>
			<a class="rv" href="tel:+<?=e($s['wa'])?>"><?=icon('phone')?><b><?=we('Телефон')?></b><small><?=e($s['phone'])?></small></a>
			<a class="rv" href="/signup/"><?=icon('arrow')?><b><?=we('Өзіңіз бастаңыз')?></b><small><?=wf('Тіркелу 2 минут, %d күн тегін', $s['trial'])?></small></a>
			<? if ($s['tg']): ?><a class="rv" href="https://t.me/<?=e($s['tg'])?>" target="_blank" rel="noopener"><?=icon('tg')?><b>Telegram</b><small>@<?=e($s['tg'])?></small></a><? endif ?>
			<? if ($s['email']): ?><a class="rv" href="mailto:<?=e($s['email'])?>"><?=icon('mail')?><b>Email</b><small><?=e($s['email'])?></small></a><? endif ?>
		</div>
	</div>
</section>
</main>
<? include ROOT.'/block/footer.php' ?>

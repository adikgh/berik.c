<?
	include dirname(__DIR__).'/config.php';
	$page = [
		'id'    => 'signup',
		'title' => w('Тегін тіркелу | BERIK POS'),
		'desc'  => wf('BERIK POS-қа өзіңіз тіркеліңіз: компания, касса, админ және %d күн тегін сынақ бірден ашылады.', $s['trial']),
	];
	include ROOT.'/block/head.php';
	include ROOT.'/block/header.php';
	$plan = in_array(@$_GET['plan'], ['free', 'start', 'pro', 'max'], true) ? $_GET['plan'] : 'free';
	$code = substr(preg_replace('/[^a-z0-9_]/', '', strtolower((string)@$_GET['code'])), 0, 40);
	$types = ['fast' => w('Фастфуд'), 'delivery' => w('Доставка'), 'cafe' => w('Кафе, асхана'), 'coffee' => w('Кофейня'), 'other' => w('Басқа')];
	$T = [
		'go' => w('Компанияны ашу'), 'wait' => w('Ашылып жатыр…'), 'err' => w('Қате шықты. Қайта көріңіз'), 'net' => w('Интернет байланысын тексеріңіз'),
		'fill' => w('Барлық өрісті толтырыңыз'), 'agree' => w('Шарттармен келісуіңіз керек'),
		'e_company' => w('Компания атауын жазыңыз'), 'e_city' => w('Қаланы жазыңыз'), 'e_name' => w('Атыңызды жазыңыз'),
		'e_phone' => w('Телефон нөмірін толық жазыңыз'), 'e_password' => w('Пароль кемінде 6 таңба болсын'),
		'show' => w('Көрсету'), 'hide' => w('Жасыру'), 'test' => w('Тест коды:'), 'resent' => w('Код қайта жіберілді'),
		'copy' => w('Көшіру'), 'copied' => w('Көшірілді'),
	];
?>
<main class="su">
	<div class="wrap su_in">
		<div class="su_txt">
			<div class="crumb"><a href="/"><?=we('Басты бет')?></a><span>/</span><span><?=we('Тіркелу')?></span></div>
			<h1><?=we('Компанияңызды 2 минутта ашыңыз')?></h1>
			<p class="lead"><?=wf('Форманы толтырсаңыз, бәрі өзі дайындалады. %d күн бойы барлық модуль тегін, карта керек емес.', $s['trial'])?></p>
			<ul class="su_get">
				<li><?=icon('store')?><div><b><?=we('Компания мен филиал')?></b><small><?=we('Атауы мен қаласы, бірінші филиал')?></small></div></li>
				<li><?=icon('chart')?><div><b><?=we('Админ кабинеті')?></b><small><?=we('Телефон нөміріңіз бен пароліңізбен кіресіз')?></small></div></li>
				<li><?=icon('cash')?><div><b><?=we('Касса')?></b><small><?=we('Кассаға кіретін PIN код бірден беріледі')?></small></div></li>
				<li><?=icon('gift')?><div><b><?=wf('%d күн тегін', $s['trial'])?></b><small><?=we('Сосын тарифті өзіңіз таңдайсыз')?></small></div></li>
			</ul>
			<?=obj3d('printer', 'su_o')?>
		</div>

		<div>
			<!-- 1. Форма -->
			<div class="su_step on" data-s="1">
				<form class="form" id="suForm" novalidate autocomplete="on">
					<h2><?=we('Тегін тіркелу')?></h2>
					<p class="sub"><?=we('Барлық өріс міндетті, шақыру кодынан басқа')?></p>

					<div class="fld_2">
						<label class="fld"><span><?=we('Компания атауы')?></span><input name="company" type="text" maxlength="120" autocomplete="organization" placeholder="<?=we('Мысалы, Yaki Sushi')?>" required></label>
						<label class="fld"><span><?=we('Қала')?></span><input name="city" type="text" maxlength="80" autocomplete="address-level2" placeholder="<?=we('Мысалы, Ақтау')?>" required></label>
					</div>
					<div class="fld"><span><?=we('Мекеме түрі')?></span>
						<div class="chips">
							<? $i = 0; foreach ($types as $k => $t): ?><label><input type="radio" name="type" value="<?=$k?>"<?=$i++ ? '' : ' checked'?>><span><?=e($t)?></span></label><? endforeach ?>
						</div>
					</div>
					<label class="fld"><span><?=we('Атыңыз')?></span><input name="name" type="text" maxlength="80" autocomplete="name" placeholder="<?=we('Мысалы, Айдос')?>" required></label>
					<label class="fld"><span><?=we('Телефон')?> <small>· <?=we('админге кіретін логин')?></small></span><input name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="8 (700) 000-00-00" required></label>
					<label class="fld"><span><?=we('Пароль')?> <small>· <?=we('кемінде 6 таңба')?></small></span>
						<span class="pw"><input name="password" type="password" minlength="6" maxlength="72" autocomplete="new-password" required><button type="button"><?=we('Көрсету')?></button></span>
					</label>
					<div class="fld_2">
						<label class="fld"><span><?=we('Тариф')?></span>
							<select name="plan">
								<? foreach ($plans as $p): ?><option value="<?=$p['key']?>"<?=$p['key'] == $plan ? ' selected' : ''?>><?=e($p['name'])?><?=$p['key'] == 'free' ? '' : ' · '.e($p['price']).' ₸'?></option><? endforeach ?>
							</select>
						</label>
						<label class="fld"><span><?=we('Шақыру коды')?> <small>· <?=we('бар болса')?></small></span><input name="code" type="text" maxlength="40" autocomplete="off" value="<?=e($code)?>" placeholder="aidos"></label>
					</div>
					<label class="hp" aria-hidden="true">Website<input name="website" type="text" tabindex="-1" autocomplete="off"></label>
					<label class="agree"><input type="checkbox" name="agree" value="1" checked><span><?=we('Деректерімді BERIK POS жүйесінде сақтауға келісемін')?></span></label>
					<button class="btn btn_lg btn_full" type="submit"><span><?=we('Компанияны ашу')?></span><?=icon('arrow')?></button>
					<p class="form_msg" id="suMsg" role="alert"></p>
					<p class="form_note"><?=wf('Алғашқы %d күн тегін. Тариф кейін, төлем кезінде таңдалады', $s['trial'])?></p>
				</form>
			</div>

			<!-- 2. WhatsApp коды -->
			<div class="su_step" data-s="2">
				<div class="form">
					<h2><?=we('Нөміріңізді растаңыз')?></h2>
					<p class="sub"><?=we('WhatsApp-қа 4 санды код жібердік:')?> <b id="suPh"></b></p>
					<div class="code_in"><input inputmode="numeric" maxlength="1" aria-label="1"><input inputmode="numeric" maxlength="1" aria-label="2"><input inputmode="numeric" maxlength="1" aria-label="3"><input inputmode="numeric" maxlength="1" aria-label="4"></div>
					<p class="form_msg" id="suCodeMsg" role="alert" style="text-align:center"></p>
					<p class="form_note" id="suTest"></p>
					<p class="form_note"><button type="button" class="lnk_btn" id="suResend"><?=we('Кодты қайта жіберу')?></button> · <button type="button" class="lnk_btn" id="suBack"><?=we('Нөмірді өзгерту')?></button></p>
				</div>
			</div>

			<!-- 3. Дайын -->
			<div class="su_step" data-s="3" id="suDone">
				<div class="form">
					<div class="done_h"><span class="done_i"><?=icon('check')?></span><div><h2><?=we('Компания ашылды')?></h2><p class="sub" data-f="company"></p></div></div>
					<div class="acc">
						<div><span><?=we('Админ логині')?></span><b data-f="phone"></b></div>
						<div><span><?=we('Пароль')?></span><b><?=we('формаға жазғаныңыз')?></b></div>
						<div><span><?=we('Касса сілтемесі')?></span><b><span data-f="posl"></span><button type="button" class="copy" data-c="posl"><?=we('Көшіру')?></button></b></div>
						<div><span><?=we('Кассаға PIN')?></span><b class="pin" data-f="pin"></b></div>
						<div><span><?=we('Тегін сынақтың соңғы күні')?></span><b data-f="until"></b></div>
					</div>
					<p class="note"><?=we('PIN кодты жазып алыңыз. Оны админде «Жұмысшылар» бөлімінен өзгертуге болады.')?></p>
					<div class="done_btn">
						<a class="btn btn_lg" data-f="adm" href="#" target="_blank" rel="noopener"><?=we('Админге кіру')?><?=icon('arrow')?></a>
						<a class="btn btn_lg btn_line" data-f="pos" href="#" target="_blank" rel="noopener"><?=we('Кассаны ашу')?></a>
					</div>
					<p class="form_note"><?=we('Админде «Жұмысты бастау» тізімі мәзірді, қызметкерлерді және чекті баптауға көмектеседі')?></p>
				</div>
			</div>
		</div>
	</div>
</main>
<script>window.SU_T = <?=json_encode($T, JSON_UNESCAPED_UNICODE)?>;</script>
<? include ROOT.'/block/footer.php' ?>

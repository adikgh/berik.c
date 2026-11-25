<?
	$nav = [
		['/features/', w('Мүмкіндіктер'), 'features'],
		['/cafe/', w('Кафеге'), 'cafe'],
		['/courier/', w('Доставкаға'), 'courier'],
		['/app/', w('Программа'), 'app'],
		['/price/', w('Тарифтер'), 'price'],
		['/contacts/', w('Байланыс'), 'contacts'],
	];
?>
<header class="hd" id="top">
	<div class="wrap hd_in">
		<a class="brand" href="/" aria-label="BERIK POS">
			<img src="/assets/img/logo/berik-icon.svg" alt="" width="32" height="32">
			<span>BERIK <b>POS</b></span>
		</a>
		<nav class="nav" id="nav">
			<? foreach ($nav as $n): ?>
			<a href="<?=$n[0]?>"<?=$n[2] == $page['id'] ? ' class="on" aria-current="page"' : ''?>><?=e($n[1])?></a>
			<? endforeach ?>
			<a class="nav_m" href="<?=e($s['login'])?>"><?=we('Кіру')?></a>
		</nav>
		<div class="hd_act">
			<div class="lng" id="lng">
				<button type="button" class="lng_b" aria-haspopup="true" aria-expanded="false"><?=icon('globe')?><span><?=strtoupper($lang == 'kz' ? 'қаз' : $lang)?></span></button>
				<div class="lng_m" role="menu">
					<? foreach ($langs as $lk => $ln): ?><a role="menuitem" href="<?=e(lang_url($lk))?>"<?=$lk == $lang ? ' class="on"' : ''?>><?=e($ln)?></a><? endforeach ?>
				</div>
			</div>
			<a class="hd_login hide_m" href="<?=e($s['login'])?>"><?=we('Кіру')?></a>
			<a class="btn btn_sm" href="/signup/"><?=we('Тегін бастау')?></a>
			<button class="burger" id="burger" type="button" aria-label="<?=we('Мәзір')?>" aria-expanded="false" aria-controls="nav"><span></span><span></span></button>
		</div>
	</div>
</header>

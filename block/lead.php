<!-- Өтінім -->
<section class="sec" id="lead">
	<div class="wrap">
		<div class="cta">
			<div class="cta_txt">
				<h2><?=e($lead_h ?? 'Мекемеңізде көріп көріңіз')?></h2>
				<p>Нөміріңізді қалдырыңыз, 15 минут ішінде хабарласып, жүйені көрсетеміз.</p>
				<ul>
					<li><?=icon('check')?> <?=$s['trial']?> күн тегін</li>
					<li><?=icon('check')?> Мәзірді өзіміз енгіземіз</li>
					<li><?=icon('check')?> Міндеттеме жоқ</li>
				</ul>
			</div>
			<form class="form" id="leadForm" data-wa="<?=e($s['wa'])?>" novalidate>
				<label><span>Атыңыз</span><input id="lead_name" name="name" type="text" autocomplete="name" placeholder="Мысалы, Айдос" required></label>
				<label><span>Телефон</span><input id="lead_phone" name="phone" type="tel" autocomplete="tel" placeholder="8 (700) 000-00-00" required></label>
				<label><span>Мекеме түрі</span>
					<select name="type" id="lead_type">
						<? $sel = $page['id'] == 'courier' ? 'Доставка' : ($page['id'] == 'cafe' ? 'Кафе / асхана' : ''); ?>
						<? foreach (['Фастфуд', 'Доставка', 'Кафе / асхана', 'Кофейня', 'Басқа'] as $o): ?><option<?=$o == $sel ? ' selected' : ''?>><?=$o?></option><? endforeach ?>
					</select>
				</label>
				<label><span>Шақыру коды <small>(бар болса)</small></span><input id="lead_code" name="code" type="text" autocomplete="off" placeholder="Мысалы, aidos" maxlength="40"></label>
				<input type="hidden" name="plan" value="">
				<button class="btn btn_lg btn_full" type="submit">Өтінім жіберу</button>
				<p class="form_note">Батырманы басқанда өтінім WhatsApp арқылы жіберіледі.</p>
			</form>
		</div>
	</div>
</section>

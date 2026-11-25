<footer class="ft_w">
	<div class="wrap ft_in">
		<div class="ft_col ft_brand">
			<a class="brand" href="/"><img src="/assets/img/logo/berik-icon.svg" alt="" width="28" height="28"><span>BERIK <b>POS</b></span></a>
			<p><?=we('Кафе мен доставкаға арналған касса жүйесі')?></p>
			<div class="ft_lang"><? foreach ($langs as $lk => $ln): ?><a href="<?=e(lang_url($lk))?>"<?=$lk == $lang ? ' class="on"' : ''?>><?=e($ln)?></a><? endforeach ?></div>
		</div>
		<div class="ft_col">
			<b><?=we('Өнім')?></b>
			<a href="/features/"><?=we('Мүмкіндіктер')?></a><a href="/price/"><?=we('Тарифтер')?></a><a href="/cafe/"><?=we('Кафеге')?></a><a href="/courier/"><?=we('Доставкаға')?></a><a href="/app/"><?=we('Windows программасы')?></a>
		</div>
		<div class="ft_col">
			<b><?=we('Бастау')?></b>
			<a href="/signup/"><?=we('Тегін тіркелу')?></a><a href="<?=e($s['adm'])?>"><?=we('Админге кіру')?></a><a href="<?=e($s['pos'])?>"><?=we('Кассаға кіру')?></a><a href="/#faq"><?=we('Сұрақтар')?></a>
		</div>
		<div class="ft_col">
			<b><?=we('Байланыс')?></b>
			<a href="tel:+<?=e($s['wa'])?>"><?=e($s['phone'])?></a>
			<a href="<?=e($wa_link)?>" target="_blank" rel="noopener">WhatsApp</a>
			<? if ($s['tg']): ?><a href="https://t.me/<?=e($s['tg'])?>" target="_blank" rel="noopener">Telegram</a><? endif ?>
			<? if ($s['ig']): ?><a href="https://instagram.com/<?=e($s['ig'])?>" target="_blank" rel="noopener">Instagram</a><? endif ?>
			<? if ($s['email']): ?><a href="mailto:<?=e($s['email'])?>"><?=e($s['email'])?></a><? endif ?>
		</div>
	</div>
	<div class="wrap ft_b"><span>© <?=date('Y')?> BERIK POS</span><a class="gprog_bl gp_made" href="https://gprog.kz" target="_blank" rel="noopener"><span>#gprog-та</span><svg class="gprog_heart" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 21s-7.5-4.6-9.6-9.3C.9 8.3 3 4.5 6.6 4.5c2.1 0 3.6 1.2 4.4 2.5.8-1.3 2.3-2.5 4.4-2.5 3.6 0 5.7 3.8 4.2 7.2C19.5 16.4 12 21 12 21z"/></svg><span>жасалған</span></a></div>
</footer>

<a class="wa_fab" href="<?=e($wa_link)?>" target="_blank" rel="noopener" aria-label="WhatsApp"><?=icon('wa')?></a>

<script src="/assets/pl/jquery.min.js"></script>
<script src="/assets/pl/jquery.mask.min.js"></script>
<script>window.LANG = <?=json_encode($lang)?>;</script>
<script src="/assets/js/site.js?v=<?=$v?>"></script>
</body>

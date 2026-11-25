<?
	// Windows программасының терезесі (CSS): касса + Офлайн/Онлайн белгісі ауысады. $win_o = 3D зат көрсету (true/false)
	$win_items = [[w('Дабл бургер'), '2 400'], [w('Лаваш тауық'), '1 900'], [w('Фри'), '900'], [w('Кола 0.5'), '600'], [w('Манты, 5 дана'), '1 800'], [w('Лағман'), '2 200']];
?>
<div class="win_w">
	<div class="win" aria-hidden="true">
		<div class="win_bar">
			<span class="win_t"><img src="/assets/img/logo/berik-icon.svg" alt="" width="14" height="14">BERIK POS · <?=we('Касса')?>-1</span>
			<span class="win_c"><i></i><i></i><i></i></span>
		</div>
		<div class="win_b">
			<div class="win_m">
				<div class="win_cats"><span class="on"><?=we('Бургер')?></span><span><?=we('Лаваш')?></span><span><?=we('Ыстық тағам')?></span><span><?=we('Сусын')?></span></div>
				<div class="win_grid"><? foreach ($win_items as $i => $it): ?><div<?=$i == 0 ? ' class="on"' : ''?>><b><?=e($it[0])?></b><small><?=$it[1]?> ₸</small></div><? endforeach ?></div>
			</div>
			<div class="win_cart">
				<div class="win_ch"><span class="tk">№249</span><small><?=we('Өзімен алу')?></small></div>
				<div class="win_l"><span>2× <?=we('Дабл бургер')?></span><b>4 800</b></div>
				<div class="win_l"><span>1× <?=we('Фри')?></span><b>900</b></div>
				<div class="win_l"><span>2× <?=we('Кола 0.5')?></span><b>1 200</b></div>
				<div class="win_tot"><span><?=we('Барлығы')?></span><b>6 900 ₸</b></div>
				<div class="ph_btn"><?=we('Сақтау')?></div>
			</div>
		</div>
		<div class="win_st"><span class="win_s1"><span class="dot dot_a"></span><?=we('Офлайн')?> · <?=we('3 тапсырыс күтуде')?></span><span class="win_s2"><span class="dot"></span><?=we('Онлайн')?> · <?=we('бәрі серверге жіберілді')?></span></div>
	</div>
	<? if (!isset($win_o) || $win_o): ?><?=obj3d('printer', 'win_o', w('Чек принтері'))?><? endif ?>
</div>

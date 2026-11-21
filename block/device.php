<?
	// Hero: 3D ноутбук (админ статистикасы) + телефон (курьер) + 3D заттар. Скроллда ноутбук ашылады (site.js --open).
	$bars = [[w('Дс'), 52], [w('Сс'), 61], [w('Ср'), 48], [w('Бс'), 70], [w('Жм'), 88], [w('Сб'), 100], [w('Жс'), 76]];
	$today = 4;
?>
<div class="scene" id="scene" aria-hidden="true">
	<div class="lap">
		<div class="lap_lid">
			<div class="lap_scr">
				<div class="ad">
					<div class="ad_side">
						<img src="/assets/img/logo/berik-icon.svg" alt="">
						<i class="on"></i><i></i><i></i><i></i><i></i>
					</div>
					<div class="ad_main">
						<div class="ad_top">
							<b><?=we('Статистика')?></b>
							<div class="seg"><span class="on"><?=we('Күн')?></span><span><?=we('Апта')?></span><span><?=we('Ай')?></span><span><?=we('Жыл')?></span></div>
						</div>
						<div class="ad_stats">
							<div><small><?=we('Түсім')?></small><b class="num" data-to="466180">466 180 ₸</b><em class="up">+12% <?=we('кешемен')?></em></div>
							<div><small><?=we('Чек')?></small><b class="num" data-to="143">143</b><em>+9 <?=we('кешемен')?></em></div>
							<div><small><?=we('Орташа чек')?></small><b>3 260 ₸</b><em>−40 ₸</em></div>
						</div>
						<div class="ad_row">
							<div class="ad_chart">
								<small><?=we('Апта бойынша түсім')?></small>
								<div class="bars">
									<? foreach ($bars as $i => $b): ?><span class="<?=$i == $today ? 'on' : ''?>" style="--h:<?=$b[1]?>"><i></i><em><?=e($b[0])?></em></span><? endforeach ?>
								</div>
							</div>
							<div class="ad_top5">
								<small><?=we('Көп сатылған')?></small>
								<p><span><?=we('Чизбургер')?></span><b>64</b></p>
								<p><span><?=we('Лаваш тауық')?></span><b>51</b></p>
								<p><span><?=we('Фри')?></span><b>47</b></p>
								<p><span><?=we('Пицца пепперони')?></span><b>23</b></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="lap_base"><i></i></div>
	</div>

	<div class="phn">
		<div class="phn_scr">
			<div class="ph_top"><b><?=we('Менің тапсырыстарым')?></b><span>Ержан</span></div>
			<div class="ph_card">
				<div class="ph_h"><span class="tk">№251</span><em class="st_road"><?=we('Жолда')?></em></div>
				<p><?=we('Абай даңғылы 52, 14-пәтер')?></p>
				<small><?=we('2-аймақ · 18:40-қа дейін')?></small>
				<div class="ph_sum"><b>7 300 ₸</b><span><?=we('Қолма-қол')?></span></div>
				<div class="ph_btn"><?=we('Жеткізілді')?></div>
			</div>
			<div class="ph_card ph_dim">
				<div class="ph_h"><span class="tk">№254</span><em><?=we('Күтуде')?></em></div>
				<p><?=we('Төле би көшесі 118')?></p>
			</div>
		</div>
	</div>

	<div class="tag_f tag_f1"><span class="dot"></span><span class="tk">№248</span><?=we('Кухняда · 6 мин')?></div>
	<?=obj3d('printer', 'sc_o1')?>
	<?=obj3d('burger', 'sc_o2')?>
</div>

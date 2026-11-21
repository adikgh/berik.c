<div class="plans">
	<? foreach ($plans as $p): ?>
	<div class="plan rv<?=!empty($p['top']) ? ' plan_top' : ''?>">
		<div class="plan_h">
			<h3><?=e($p['name'])?></h3>
			<? if (!empty($p['top'])): ?><span class="plan_b"><?=we('Танымал')?></span><? endif ?>
		</div>
		<p class="plan_for"><?=e($p['for'])?></p>
		<div class="plan_p">
			<b><?=e($p['price'])?> ₸</b><small>/ <?=e($p['per'])?></small>
			<? if ($p['usd'] !== '0'): ?><span class="plan_usd">$<?=e($p['usd'])?></span><? endif ?>
		</div>
		<ul><? foreach ($p['items'] as $i): ?><li><?=icon('check')?><?=e($i)?></li><? endforeach ?></ul>
		<a class="btn btn_full <?=!empty($p['top']) ? '' : 'btn_line'?>" href="/signup/?plan=<?=e($p['key'])?>"><?=$p['key'] == 'free' ? we('Тегін бастау') : wf('%s-пен бастау', $p['name'])?></a>
	</div>
	<? endforeach ?>
</div>

<!-- Тіркелуге шақыру -->
<section class="sec" id="start">
	<div class="wrap">
		<div class="cta rv">
			<div class="cta_txt">
				<h2><?=e($cta_h ?? w('Бүгін бастап көріңіз'))?></h2>
				<p><?=wf('Форманы толтырасыз, компанияңыз бірден ашылады: касса, админ, филиал және %d күн тегін сынақ. Карта керек емес.', $s['trial'])?></p>
				<div class="cta_btn">
					<a class="btn btn_lg" href="/signup/"><?=we('Тегін тіркелу')?><?=icon('arrow')?></a>
					<a class="btn btn_lg btn_soft" href="<?=e($wa_link)?>" target="_blank" rel="noopener"><?=icon('wa')?>WhatsApp</a>
				</div>
			</div>
			<div class="cta_art" aria-hidden="true">
				<?=obj3d('bag', 'cta_o1')?><?=obj3d('boxes', 'cta_o2')?>
			</div>
		</div>
	</div>
</section>

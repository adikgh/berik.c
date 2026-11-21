(function () {
	var d = document, root = d.documentElement;
	root.classList.add('js');
	var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;

	// Шапка көлеңкесі
	var hd = d.querySelector('.hd');
	function onSc() { if (hd) hd.classList.toggle('is_sc', window.scrollY > 8); }
	window.addEventListener('scroll', onSc, { passive: true }); onSc();

	// Мобильді мәзір
	var bg = d.getElementById('burger'), nav = d.getElementById('nav');
	if (bg && nav) {
		var setNav = function (o) { nav.classList.toggle('open', o); bg.setAttribute('aria-expanded', o ? 'true' : 'false'); d.body.style.overflow = o ? 'hidden' : ''; };
		bg.addEventListener('click', function () { setNav(!nav.classList.contains('open')); });
		nav.querySelectorAll('a').forEach(function (a) { a.addEventListener('click', function () { setNav(false); }); });
	}

	// Тіл мәзірі
	var lng = d.getElementById('lng');
	if (lng) {
		var lb = lng.querySelector('.lng_b');
		lb.addEventListener('click', function (e) { e.stopPropagation(); var o = !lng.classList.contains('open'); lng.classList.toggle('open', o); lb.setAttribute('aria-expanded', o); });
		d.addEventListener('click', function () { lng.classList.remove('open'); lb.setAttribute('aria-expanded', 'false'); });
		d.addEventListener('keydown', function (e) { if (e.key === 'Escape') lng.classList.remove('open'); });
	}

	// Скроллда көріну: бір топтағы элементтер кезекпен (stagger)
	var rv = d.querySelectorAll('.rv');
	if ('IntersectionObserver' in window && !reduce) {
		var io = new IntersectionObserver(function (es) {
			es.forEach(function (en) {
				if (!en.isIntersecting) return;
				var el = en.target, sib = el.parentNode ? Array.prototype.filter.call(el.parentNode.children, function (x) { return x.classList.contains('rv'); }) : [];
				var i = sib.indexOf(el);
				el.style.setProperty('--d', (Math.max(0, i) % 6) * 0.07 + 's');
				el.classList.add('in');
				io.unobserve(el);
			});
		}, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
		rv.forEach(function (el) { io.observe(el); });
	} else rv.forEach(function (el) { el.classList.add('in'); });

	// Сан өсіп шығады
	function tween(el) {
		var to = +el.getAttribute('data-to'), tx = el.textContent, m = tx.match(/\d[\d\s]*\d|\d/), suf = m ? tx.slice(m.index + m[0].length) : '', t0 = null;
		if (reduce || !to) return;
		function f(t) {
			if (!t0) t0 = t;
			var k = Math.min(1, (t - t0) / 1100), v = Math.round(to * (1 - Math.pow(1 - k, 3)));
			el.textContent = v.toLocaleString('ru-RU').replace(/,/g, ' ') + suf;
			if (k < 1) requestAnimationFrame(f);
		}
		requestAnimationFrame(f);
	}

	// Hero: ноутбук ашылады (жүктелгенде), скроллда заттар сәл көтеріледі
	var sc = d.getElementById('scene');
	if (sc) {
		if (!reduce) {
			sc.style.setProperty('--open', 0);
			sc.querySelectorAll('.bars i').forEach(function (b) { b.style.setProperty('--grow', 0); });
			var t0 = null;
			var open = function (t) {
				if (!t0) t0 = t;
				var k = Math.min(1, (t - t0) / 1400), e = 1 - Math.pow(1 - k, 3);
				sc.style.setProperty('--open', e.toFixed(4));
				if (k < 1) requestAnimationFrame(open);
				else {
					sc.querySelectorAll('.bars i').forEach(function (b) { b.style.setProperty('--grow', 1); });
					sc.querySelectorAll('.num[data-to]').forEach(tween);
				}
			};
			setTimeout(function () { requestAnimationFrame(open); }, 250);
			var tick = false;
			var lift = function () {
				tick = false;
				var r = sc.getBoundingClientRect();
				var p = Math.max(-1, Math.min(1, -r.top / Math.max(1, r.height)));
				sc.style.setProperty('--lift', (p * 60).toFixed(1));
			};
			window.addEventListener('scroll', function () { if (!tick) { tick = true; requestAnimationFrame(lift); } }, { passive: true });
		}
	}

	// Тапсырыстың жолы: экран ортасындағы қадам белсенді болады
	var steps = d.querySelectorAll('.story_s'), objs = d.querySelectorAll('.story_o'), lbl = d.getElementById('storyStep');
	if (steps.length && 'IntersectionObserver' in window) {
		var so = new IntersectionObserver(function (es) {
			es.forEach(function (en) {
				if (!en.isIntersecting) return;
				var i = en.target.getAttribute('data-i');
				steps.forEach(function (s) { s.classList.toggle('on', s.getAttribute('data-i') === i); });
				objs.forEach(function (o) { o.classList.toggle('on', o.getAttribute('data-i') === i); });
				if (lbl) lbl.textContent = en.target.getAttribute('data-t');
			});
		}, { rootMargin: '-45% 0px -45% 0px' });
		steps.forEach(function (s) { so.observe(s); });
	}

	// Ішкі беттердегі графиктер мен сандар көрінгенде
	if ('IntersectionObserver' in window) {
		var no = new IntersectionObserver(function (es) {
			es.forEach(function (en) { if (en.isIntersecting) { tween(en.target); no.unobserve(en.target); } });
		}, { threshold: 0.4 });
		d.querySelectorAll('.box .num[data-to]').forEach(function (n) { no.observe(n); });
	}

	// Шақыру коды: ?code=nick сілтемесінен келсе 60 күн есте сақталады
	function cleanCode(v) { return String(v || '').toLowerCase().replace(/[^a-z0-9_]/g, '').slice(0, 40); }
	try {
		var q = cleanCode(new URLSearchParams(location.search).get('code'));
		if (q) localStorage.setItem('berik_code', JSON.stringify({ c: q, t: Date.now() }));
	} catch (x) {}
	function savedCode() {
		try { var sv = JSON.parse(localStorage.getItem('berik_code') || 'null'); if (sv && Date.now() - sv.t < 60 * 864e5) return sv.c; } catch (x) {}
		return '';
	}

	// ---------- тіркелу ----------
	var form = d.getElementById('suForm');
	if (!form) return;
	var T = window.SU_T || {};
	var msg = d.getElementById('suMsg'), btn = form.querySelector('button[type=submit]');
	if (form.code && !form.code.value) form.code.value = savedCode();
	if (window.jQuery && jQuery.fn.mask) jQuery(form.phone).mask('8 (700) 000-00-00');
	form.querySelectorAll('input, select').forEach(function (i) { i.addEventListener('input', function () { i.classList.remove('err'); msg.textContent = ''; }); });
	var pwb = form.querySelector('.pw button');
	if (pwb) pwb.addEventListener('click', function () { var p = form.password; p.type = p.type === 'password' ? 'text' : 'password'; pwb.textContent = p.type === 'password' ? T.show : T.hide; });

	function step(n) { d.querySelectorAll('.su_step').forEach(function (s) { s.classList.toggle('on', s.getAttribute('data-s') === n); }); window.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' }); }
	function post(url, data, cb) {
		var x = new XMLHttpRequest();
		x.open('POST', url); x.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		x.onload = function () { var r = null; try { r = JSON.parse(x.responseText); } catch (e) {} cb(r || { ok: false, msg: T.err }); };
		x.onerror = function () { cb({ ok: false, msg: T.net }); };
		x.send(data);
	}
	function done(r) {
		var b = d.getElementById('suDone');
		b.querySelector('[data-f=company]').textContent = r.company;
		b.querySelector('[data-f=phone]').textContent = r.phone;
		b.querySelector('[data-f=pin]').textContent = r.pin;
		b.querySelector('[data-f=until]').textContent = r.until;
		b.querySelector('[data-f=adm]').href = r.adm;
		b.querySelector('[data-f=pos]').href = r.pos;
		b.querySelector('[data-f=posl]').textContent = r.pos;
		try { localStorage.removeItem('berik_code'); } catch (x) {}
		step('3');
	}
	function fail(r) {
		msg.textContent = r.msg || T.err;
		if (r.field && form[r.field]) { form[r.field].classList.add('err'); form[r.field].focus(); }
	}

	form.addEventListener('submit', function (e) {
		e.preventDefault();
		var bad = null;
		['company', 'city', 'name'].forEach(function (k) { if (!bad && !form[k].value.trim()) bad = k; });
		if (!bad && form.phone.value.replace(/\D/g, '').length !== 11) bad = 'phone';
		if (!bad && form.password.value.length < 6) bad = 'password';
		if (bad) { form[bad].classList.add('err'); form[bad].focus(); msg.textContent = T['e_' + bad] || T.fill; return; }
		if (!form.agree.checked) { msg.textContent = T.agree; return; }
		btn.disabled = true; btn.querySelector('span').textContent = T.wait;
		post('/signup/get.php?reg', new URLSearchParams(new FormData(form)).toString(), function (r) {
			btn.disabled = false; btn.querySelector('span').textContent = T.go;
			if (r.ok && r.st === 'code') {
				d.getElementById('suPh').textContent = r.phone;
				if (r.test) d.getElementById('suTest').textContent = T.test + ' ' + r.test;
				step('2'); setTimeout(function () { var c = d.querySelector('.code_in input'); if (c) c.focus(); }, 300);
			} else if (r.ok) done(r);
			else fail(r);
		});
	});

	// Растау коды: 4 ұяшық
	var cin = d.querySelectorAll('.code_in input'), cmsg = d.getElementById('suCodeMsg');
	function codeVal() { return Array.prototype.map.call(cin, function (i) { return i.value; }).join(''); }
	function sendCode() {
		var c = codeVal(); if (c.length < 4) return;
		cin.forEach(function (i) { i.disabled = true; });
		post('/signup/get.php?reg_code', 'code=' + encodeURIComponent(c), function (r) {
			cin.forEach(function (i) { i.disabled = false; });
			if (r.ok) done(r);
			else { cmsg.textContent = r.msg || T.err; cin.forEach(function (i) { i.value = ''; }); cin[0].focus(); }
		});
	}
	cin.forEach(function (inp, i) {
		inp.addEventListener('input', function () {
			inp.value = inp.value.replace(/\D/g, '').slice(-1); cmsg.textContent = '';
			if (inp.value && cin[i + 1]) cin[i + 1].focus();
			if (codeVal().length === 4) sendCode();
		});
		inp.addEventListener('keydown', function (e) { if (e.key === 'Backspace' && !inp.value && cin[i - 1]) cin[i - 1].focus(); });
		inp.addEventListener('paste', function (e) {
			var t = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 4);
			if (!t) return; e.preventDefault();
			cin.forEach(function (c, j) { c.value = t[j] || ''; });
			if (t.length === 4) sendCode();
		});
	});
	var rs = d.getElementById('suResend');
	if (rs) rs.addEventListener('click', function () {
		post('/signup/get.php?reg_resend', '', function (r) { cmsg.textContent = r.ok ? T.resent : (r.msg || T.err); if (r.test) d.getElementById('suTest').textContent = T.test + ' ' + r.test; });
	});
	var bk = d.getElementById('suBack');
	if (bk) bk.addEventListener('click', function () { step('1'); });

	// Көшіру
	d.querySelectorAll('.copy').forEach(function (c) {
		c.addEventListener('click', function () {
			var t = d.querySelector('[data-f=' + c.getAttribute('data-c') + ']').textContent;
			if (navigator.clipboard) navigator.clipboard.writeText(t).then(function () { c.textContent = T.copied; setTimeout(function () { c.textContent = T.copy; }, 1500); });
		});
	});
})();

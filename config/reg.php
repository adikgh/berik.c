<?php
// Сайттан өзі тіркелу (2026-11-21). Форма толтырылса базада ашылады:
//   company (+ code #n<id>), company_branch (1-филиал), user (директор, bcrypt пароль),
//   company_staff: директор (2) — админге кіреді, менеджер (4) PIN-мен — кассаға кіреді,
//   company_sub (тариф, шақырушы), company_payment method='trial' — 14 күн тегін сынақ.
// Логика dev панеліндегі dev::company_add / trial_add-пен бірдей (сайт бөлек болғандықтан осында көшірілген).

class reg {
	public static $trial_days = 14;
	public static $types = ['fast', 'delivery', 'cafe', 'coffee', 'other'];

	public static function e($s) { return mysqli_real_escape_string(db::$connect, trim((string)$s)); }
	public static function row($sql) { $q = db::query($sql); return $q && $q !== true ? mysqli_fetch_assoc($q) : null; }
	public static function one($sql) { $q = db::query($sql); $r = $q && $q !== true ? mysqli_fetch_row($q) : null; return $r ? $r[0] : null; }
	public static function tb($t) { $q = db::query("SHOW TABLES LIKE '" . self::e($t) . "'"); return $q && mysqli_num_rows($q) > 0; }
	public static function phone($p) { return substr(preg_replace('/\D/', '', (string)$p), -10); }
	public static function phone_txt($p) { return strlen($p) == 10 ? '8 (' . substr($p, 0, 3) . ') ' . substr($p, 3, 3) . '-' . substr($p, 6, 2) . '-' . substr($p, 8, 2) : $p; }
	public static function pass_hash($p) { return password_hash((string)$p, PASSWORD_DEFAULT); }
	public static function pass_ok($in, $st) {
		$in = (string)$in; $st = (string)$st;
		if ($in === '' || $st === '') return false;
		if (password_get_info($st)['algo']) return password_verify($in, $st);
		return hash_equals($st, $in);
	}

	// Форманы тексеру. Қате болса ['msg' => ..., 'field' => ...], дұрыс болса тазаланған массив
	public static function check($p) {
		$d = [
			'company' => mb_substr(trim(strip_tags((string)@$p['company'])), 0, 120),
			'city' => mb_substr(trim(strip_tags((string)@$p['city'])), 0, 80),
			'name' => mb_substr(trim(strip_tags((string)@$p['name'])), 0, 80),
			'phone' => self::phone(@$p['phone']),
			'password' => (string)@$p['password'],
			'type' => in_array(@$p['type'], self::$types, true) ? $p['type'] : 'other',
			'plan' => in_array(@$p['plan'], ['free', 'start', 'pro', 'max'], true) ? $p['plan'] : 'free',
			'code' => substr(preg_replace('/[^a-z0-9_]/', '', strtolower((string)@$p['code'])), 0, 40),
		];
		if ($d['company'] === '') return ['msg' => w('Компания атауын жазыңыз'), 'field' => 'company'];
		if ($d['city'] === '') return ['msg' => w('Қаланы жазыңыз'), 'field' => 'city'];
		if ($d['name'] === '') return ['msg' => w('Атыңызды жазыңыз'), 'field' => 'name'];
		if (strlen($d['phone']) != 10 || $d['phone'][0] != '7') return ['msg' => w('Телефон нөмірін толық жазыңыз'), 'field' => 'phone'];
		if (mb_strlen($d['password']) < 6) return ['msg' => w('Пароль кемінде 6 таңба болсын'), 'field' => 'password'];
		if (mb_strlen($d['password']) > 72) return ['msg' => w('Пароль тым ұзын'), 'field' => 'password'];

		$u = self::row("select * from `user` where phone = '" . $d['phone'] . "' limit 1");
		if ($u) {
			// Нөмір базада бар: тек өз паролімен (басқа біреудің нөмірін директор етіп жазуға болмайды)
			if (!self::pass_ok($d['password'], $u['password'])) return ['msg' => w('Бұл нөмір жүйеде бар. Сол нөмірдің паролін жазыңыз не админде парольді қалпына келтіріңіз'), 'field' => 'password'];
			$dir = self::row("select c.name from company_staff s join company c on c.id = s.company_id where s.user_id = '" . (int)$u['id'] . "' and s.positions_id = 2 and s.archive = 0 limit 1");
			if ($dir) return ['msg' => sprintf(w('Бұл нөмірге «%s» компаниясы тіркелген. Админге кіріңіз'), $dir['name']), 'field' => 'phone', 'login' => 1];
		}
		$d['user'] = $u;
		if ($d['code'] !== '' && self::tb('company_ref') && !self::row("select id from company_ref where nick = '" . self::e($d['code']) . "' and arh = 0")) return ['msg' => w('Шақыру коды табылмады. Тексеріңіз не бос қалдырыңыз'), 'field' => 'code'];
		return $d;
	}

	// Сынақ қай тарифпен: таңдаған тариф (атауы бойынша), болмаса Pro, болмаса біріншісі
	public static function tariff($plan) {
		if (!self::tb('company_tariff')) return null;
		$want = $plan === 'free' ? 'pro' : $plan;
		$t = self::row("select * from company_tariff where arh = 0 and lower(name) = '" . self::e($want) . "' limit 1");
		return $t ?: self::row("select * from company_tariff where arh = 0 order by number, id limit 1");
	}

	// Компания ашу. Нәтиже: массив (company, phone, pin, until, cid) не қате мәтіні
	public static function create($d) {
		$now = date('Y-m-d H:i:s');
		mysqli_begin_transaction(db::$connect);
		try {
			db::query("insert into company (name, city, type_def, start_dt, ins_dt) values ('" . self::e($d['company']) . "', '" . self::e($d['city']) . "', '', '$now', '$now')");
			$cid = (int)mysqli_insert_id(db::$connect);
			if (!$cid) throw new Exception('company: ' . mysqli_error(db::$connect));
			$code = '#n' . $cid; $i = 1;
			while (self::row("select id from company where code = '" . self::e($code) . "' and id <> '$cid'")) $code = '#n' . $cid . '_' . $i++;
			db::query("update company set code = '" . self::e($code) . "' where id = '$cid'");
			// Тек өзі алып кету мен кафе болса, жеткізу өшіп тұрады (кейін админде қосылады)
			if (in_array($d['type'], ['coffee'], true)) db::query("update company set delivery = 0 where id = '$cid'");

			db::query("insert into company_branch (number, name, company_id) values (1, '" . self::e($d['company']) . "', '$cid')");
			$bid = (int)mysqli_insert_id(db::$connect);

			$u = $d['user'];
			if (!$u) {
				if (!db::query("insert into `user` (name, phone, password, `right`, ins_dt) values ('" . self::e($d['name']) . "', '" . $d['phone'] . "', '" . self::e(self::pass_hash($d['password'])) . "', 1, '$now')"))
					throw new Exception('user: ' . mysqli_error(db::$connect));
				$u = self::row("select * from `user` where phone = '" . $d['phone'] . "' limit 1");
			} elseif (!$u['right']) db::query("update `user` set `right` = 1 where id = '" . (int)$u['id'] . "'");
			if (!$u) throw new Exception('user not found');
			$uid = (int)$u['id'];

			// директор — админ; менеджер — касса (PIN)
			if (!db::query("insert into company_staff (user_id, positions_id, company_id) values ('$uid', 2, '$cid')")) throw new Exception('staff: ' . mysqli_error(db::$connect));
			$pin = random_int(1000, 9999);
			db::query("insert into company_staff (user_id, positions_id, company_id, branch_id, code) values ('$uid', 4, '$cid', " . ($bid ?: 'NULL') . ", '$pin')");

			// жазылым және тегін сынақ
			$until = date('Y-m-d', strtotime('+' . (self::$trial_days - 1) . ' days'));
			if (self::tb('company_sub')) {
				$t = self::tariff($d['plan']);
				$rid = 0;
				if ($d['code'] !== '' && self::tb('company_ref')) $rid = (int)self::one("select id from company_ref where nick = '" . self::e($d['code']) . "' and arh = 0 limit 1");
				db::query("insert into company_sub (company_id, tariff_id, paid_until, ref_id, note, upd_dt) values ('$cid', " . ($t ? (int)$t['id'] : 'NULL') . ", '$until', " . ($rid ?: 'NULL') . ", '" . self::e(mb_substr(w('Сайттан тіркелді') . ': ' . $d['type'] . ', ' . $d['plan'], 0, 250)) . "', '$now')");
				if ($t && self::tb('company_payment')) {
					$from = date('Y-m-d');
					db::query("insert into company_payment (company_id, tariff_id, price, months, bonus_months, amount, method, date_from, date_to, paid_dt, comment, user_id)
						values ('$cid', '" . (int)$t['id'] . "', 0, 0, 0, 0, 'trial', '$from', '$until', '$from', '" . self::e(w('Сайттан тіркелді')) . "', '$uid')");
				}
			}
			mysqli_commit(db::$connect);
		} catch (Throwable $e) {
			mysqli_rollback(db::$connect);
			error_log('berikpos reg: ' . $e->getMessage());
			return w('Тіркеу сәтсіз болды. Қайта көріңіз не WhatsApp-қа жазыңыз');
		}
		return ['cid' => $cid, 'code' => substr($code, 1), 'company' => $d['company'], 'phone' => self::phone_txt($d['phone']), 'pin' => (string)$pin, 'until' => date('d.m.Y', strtotime($until))];
	}
}

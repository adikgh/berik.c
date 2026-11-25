<?php
// Windows касса программасының соңғы нұсқасы (GitHub releases/latest). 30 минут temp-те кэш, GitHub жауап бермесе — releases беті.
const POSWIN_REPO = 'adikgh/berik_poswin';

function poswin_latest($fetch = true) {
	$f = sys_get_temp_dir() . '/berikpos_poswin.json';
	$c = is_file($f) ? json_decode((string)@file_get_contents($f), true) : null;
	if (is_array($c) && time() - (int)@$c['t'] < 1800) return $c;
	if (!$fetch) return is_array($c) ? $c : null;
	$api = 'https://api.github.com/repos/' . POSWIN_REPO . '/releases/latest';
	$raw = '';
	if (function_exists('curl_init')) {
		$ch = curl_init($api);
		curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 5, CURLOPT_FOLLOWLOCATION => true, CURLOPT_HTTPHEADER => ['User-Agent: berikpos-site', 'Accept: application/vnd.github+json']]);
		$raw = (string)curl_exec($ch);
		curl_close($ch);
	}
	if ($raw === '') {
		$ctx = stream_context_create(['http' => ['timeout' => 4, 'header' => "User-Agent: berikpos-site\r\nAccept: application/vnd.github+json\r\n"]]);
		$raw = (string)@file_get_contents($api, false, $ctx);
	}
	$r = json_decode($raw, true);
	if (!empty($r['assets'])) {
		foreach ($r['assets'] as $a) {
			if (preg_match('/\.exe$/i', (string)$a['name'])) {
				$c = ['t' => time(), 'ver' => ltrim((string)$r['tag_name'], 'v'), 'url' => $a['browser_download_url'],
					'size' => (int)$a['size'], 'date' => substr((string)$r['published_at'], 0, 10)];
				@file_put_contents($f, json_encode($c));
				return $c;
			}
		}
	}
	if (is_array($c)) { $c['t'] = time() - 1500; @file_put_contents($f, json_encode($c)); return $c; } // ескі кэш, 5 мин кейін қайта сұрайды
	return null;
}

function poswin_url() {
	$c = poswin_latest();
	return $c ? $c['url'] : 'https://github.com/' . POSWIN_REPO . '/releases/latest';
}

<?php
// 3D суреттердің фонын мөлдір етеді (бір рет іске қосылады, CLI):  php _tools/obj3d.php
// Кіріс: _tools/3d_src/<аты>.png (Figma-дан 1024px). Шығыс: assets/img/3d/<аты>.webp (+ .png), ені 720px.
// light — ашық фон (#f3f3f1): көлеңке жартылай мөлдір қалады. dark — қара фон (ақ заттар үшін): көлеңкесіз.
ini_set('memory_limit', '1024M');
set_time_limit(0);
$root = dirname(__DIR__);
$list = ['bag' => 'light', 'burger' => 'light', 'boxes' => 'light', 'printer' => 'dark', 'receipt' => 'dark'];

function cut($src, $mode) {
	$im = imagecreatefromstring(file_get_contents($src));
	$w = imagesx($im); $h = imagesy($im);
	$px = function ($x, $y) use ($im) { $c = imagecolorat($im, $x, $y); return [($c >> 16) & 255, ($c >> 8) & 255, $c & 255]; };
	// фон түсі: шеттегі пикселдердің 90-перцентилі (суреттің бұрыштары ортасынан сәл қараңғы болады)
	$cs = [];
	for ($x = 0; $x < $w; $x += 4) { $cs[] = $px($x, 0); $cs[] = $px($x, $h - 1); }
	for ($y = 0; $y < $h; $y += 4) { $cs[] = $px(0, $y); $cs[] = $px($w - 1, $y); }
	$bg = [];
	for ($k = 0; $k < 3; $k++) { $v = array_column($cs, $k); sort($v); $bg[$k] = $v[(int)(count($v) * .9)]; }
	$seen = array_fill(0, $w * $h, 0); $A = array_fill(0, $w * $h, 255);
	$q = new SplQueue();
	for ($x = 0; $x < $w; $x++) { $q->enqueue([$x, 0]); $q->enqueue([$x, $h - 1]); }
	for ($y = 0; $y < $h; $y++) { $q->enqueue([0, $y]); $q->enqueue([$w - 1, $y]); }
	while (!$q->isEmpty()) {
		list($x, $y) = $q->dequeue(); $i = $y * $w + $x;
		if ($seen[$i]) continue;
		$c = $px($x, $y);
		if ($mode == 'dark') {
			$m = max($c);
			if ($m >= 130) continue;
			$a = $m <= 18 ? 0 : (int)(255 * ($m - 18) / 112);
		} else {
			$d = max(0, $bg[0] - $c[0], $bg[1] - $c[1], $bg[2] - $c[2]);
			$l = max(0, $c[0] - $bg[0], $c[1] - $bg[1], $c[2] - $bg[2]);
			if ($l > 16 || $d >= 46 || max($c) - min($c) > 14) continue;
			$a = $d <= 6 ? 0 : (int)(255 * ($d - 6) / 40);
		}
		$seen[$i] = 1; $A[$i] = $a;
		foreach ([[$x + 1, $y], [$x - 1, $y], [$x, $y + 1], [$x, $y - 1]] as $n)
			if ($n[0] >= 0 && $n[0] < $w && $n[1] >= 0 && $n[1] < $h && !$seen[$n[1] * $w + $n[0]]) $q->enqueue($n);
	}
	$out = imagecreatetruecolor($w, $h);
	imagealphablending($out, false); imagesavealpha($out, true);
	imagefill($out, 0, 0, imagecolorallocatealpha($out, 0, 0, 0, 127));
	$x0 = $w; $y0 = $h; $x1 = 0; $y1 = 0;
	for ($y = 0; $y < $h; $y++) for ($x = 0; $x < $w; $x++) {
		$i = $y * $w + $x; $a = $A[$i];
		if ($a == 0) continue;
		$c = $px($x, $y);
		if ($seen[$i]) {
			$af = $a / 255;
			if ($mode == 'dark') $c = [min(255, (int)($c[0] / $af)), min(255, (int)($c[1] / $af)), min(255, (int)($c[2] / $af))];
			else for ($k = 0; $k < 3; $k++) $c[$k] = max(0, min(255, (int)(($c[$k] - (1 - $af) * $bg[$k]) / $af)));
		}
		imagesetpixel($out, $x, $y, imagecolorallocatealpha($out, $c[0], $c[1], $c[2], 127 - (int)($a / 2)));
		if ($x < $x0) $x0 = $x; if ($y < $y0) $y0 = $y; if ($x > $x1) $x1 = $x; if ($y > $y1) $y1 = $y;
	}
	// бос шетін қиып, 720px-ке кішірейтеміз
	$m = 8; $x0 = max(0, $x0 - $m); $y0 = max(0, $y0 - $m); $x1 = min($w - 1, $x1 + $m); $y1 = min($h - 1, $y1 + $m);
	$cw = $x1 - $x0 + 1; $ch = $y1 - $y0 + 1;
	$sc = min(1, 720 / max($cw, $ch));
	$nw = (int)round($cw * $sc); $nh = (int)round($ch * $sc);
	$fin = imagecreatetruecolor($nw, $nh);
	imagealphablending($fin, false); imagesavealpha($fin, true);
	imagefill($fin, 0, 0, imagecolorallocatealpha($fin, 0, 0, 0, 127));
	imagecopyresampled($fin, $out, 0, 0, $x0, $y0, $nw, $nh, $cw, $ch);
	return $fin;
}

@mkdir($root . '/assets/img/3d', 0775, true);
foreach ($list as $n => $mode) {
	$src = __DIR__ . '/3d_src/' . $n . '.png';
	if (!is_file($src)) { echo "жоқ: $src\n"; continue; }
	$t = microtime(true);
	$im = cut($src, $mode);
	imagepng($im, $root . "/assets/img/3d/$n.png", 9);
	if (function_exists('imagewebp')) imagewebp($im, $root . "/assets/img/3d/$n.webp", 86);
	echo "$n: " . imagesx($im) . 'x' . imagesy($im) . ' (' . round(microtime(true) - $t, 1) . "s)\n";
}

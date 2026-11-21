<!doctype html>
<html lang="<?=$html_lang?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<title><?=e($page['title'])?></title>
	<meta name="description" content="<?=e($page['desc'])?>">
	<meta name="theme-color" content="#f6f7f5">
	<link rel="icon" href="/assets/img/logo/favicon-32.png" type="image/png">
	<link rel="icon" href="/assets/img/logo/berik-icon.svg" type="image/svg+xml">
	<link rel="apple-touch-icon" href="/assets/img/logo/apple-touch-icon.png">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="BERIK POS">
	<meta property="og:title" content="<?=e($page['og'] ?? $page['title'])?>">
	<meta property="og:description" content="<?=e($page['desc'])?>">
	<meta property="og:image" content="/assets/img/logo/og.jpg">
	<? foreach ($langs as $lk => $ln): ?><link rel="alternate" hreflang="<?=['kz' => 'kk', 'ru' => 'ru', 'en' => 'en', 'uz' => 'uz', 'ky' => 'ky'][$lk]?>" href="?lang=<?=$lk?>">
	<? endforeach ?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap">
	<link rel="stylesheet" href="/assets/css/site.css?v=<?=$v?>">
</head>
<body class="pg_<?=e($page['id'])?>">

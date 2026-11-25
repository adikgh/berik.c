<?php
// Windows программасын жүктеу: соңғы нұсқаның .exe файлына жібереді
require dirname(__DIR__) . '/config/poswin.php';
header('Cache-Control: no-store');
header('Location: ' . poswin_url(), true, 302);

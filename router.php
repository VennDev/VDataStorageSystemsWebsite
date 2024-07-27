<?php

$url = parse_url($_SERVER['REQUEST_URI']);
$path = $url['path'];

$publicDir = __DIR__ . '/src/venndev';

if (file_exists($publicDir . $path)) return false;

$_SERVER['SCRIPT_NAME'] = '/index.php';
include_once __DIR__ . '/src/venndev/index.php';
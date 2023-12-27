<?php
require_once('config.php');
require_once('helper.php');

$path = $_SERVER['PATH_INFO'] ?? '/page';
$segments = explode('/', $path);

$mod = $segments[1] ?? 'page';
$page = $segments[2] ?? 'home';

session_start();
if ( !in_array($page, ['login', 'home'])) {
    if ( !isset($_SESSION['isLogin']) ) {
        header('location: '. site_url('/user/login'));
    }
}

$base = dirname(__FILE__);
$file = "{$base}/module/{$mod}/{$page}.php";
if (file_exists($file)) {
    require_once($file);
} else {
    require_once("{$base}/error404.php");
}
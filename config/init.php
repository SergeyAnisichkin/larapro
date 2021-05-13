<?php


    if (!defined('ROOT')) define('ROOT', dirname(__DIR__));
    if (!defined('WWW')) define('WWW', ROOT . '/public');
    if (!defined('APP')) define('APP', ROOT . '/app');
    if (!defined('CORE')) define('CORE', ROOT . '/resources');
    if (!defined('LIBS')) define('LIBS', ROOT . '/resources/libs');
    if (!defined('CACHE')) define('CACHE', ROOT . '/tmp/cache');
    if (!defined('CONF')) define('CONF', ROOT . '/config');
    if (!defined('LAYOUT')) define('LAYOUT', 'app.blade.php');
    if (!defined('GALLERY')) define('GALLERY', '/public/uploads/gallery');
    if (!defined('IMG')) define('IMG', '/public/uploads/single');


    $host = FALSE;
    $allowed_hosts = 'http://laravel.blog.san/index.php';

    if (isset($_SERVER['HTTP_HOST'])) {
        $host = $_SERVER['HTTP_HOST'];
        $allowed_hosts = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
    }

    // http://laravel.blog.san/index.php
    //http://laravel.blog.san/
    $app_path = preg_replace("#[^/]+$#", '', $allowed_hosts);
    //http://laravel.blog.san/
    $app_path = str_replace('/public/', '', $app_path);

    if (!defined('PATH')) define('PATH', $app_path);
    if (!defined('ADMIN')) define('ADMIN', PATH . 'admin/index');







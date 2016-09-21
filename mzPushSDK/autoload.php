<?php
/**
 * 自动加载类
 *
 * User: even
 * Date: 2016/9/21
 * Time: 15:18
 */



function loadClass($class) {
    $file_path = __DIR__ . '/' . $class . '.php';
    if (file_exists($file_path)) {
        include_once $file_path;
    } elseif (file_exists($file_path = __DIR__ . '/utils/' . $class . '.php')) {
        include_once $file_path;
    } else {
        throw new MzException($class . ' not find');
    }
}

spl_autoload_register('loadClass');
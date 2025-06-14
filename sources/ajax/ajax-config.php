<?php
if (!isset($_SESSION)) {
    session_set_cookie_params(['SameSite' => 'None']);
    session_start();
}
ob_start();
error_reporting(0);
define('_lib', '../../admin/lib/');
define('_source_lib', '../lib/');
global $d;
global $lang;
include _lib . "config.php";
include_once _lib . "function.php";
include_once _lib . "class.php";
$d = new func_index($config);
//include_once _source_lib . "lang.php";
include_once _source_lib . "info.php";
include_once _source_lib . "function.php";
if (count(get_json('lang')) > 1) {
    $lang = $_SESSION['lang'];
    define("URLLANG",  URLPATH . $_SESSION['lang'] . '/');
} else {
    $_SESSION['lang'] = LANG;
    define("URLLANG",  URLPATH);
}
$where_lang = "and lang ='" . $_SESSION['lang'] . "'";
define("_lang",  $_SESSION['lang']);
define("_where_lang",  $where_lang);

<?php
if (count(get_json('lang')) > 1) {
    if (isset($_REQUEST['lang']) && $_REQUEST['lang']) {
        $_SESSION['lang'] = $_REQUEST['lang'];
    } else {
        if (!isset($_SESSION['lang'])) {
            $_SESSION['lang'] = LANG;
            header("Location:" . URLPATH . LANG . '/');
        } else {
            header("Location:" . URLPATH . $_SESSION['lang'] . '/');
        }
    }
    $lang = $_SESSION['lang'];
    define("URLLANG",  URLPATH . $_SESSION['lang'] . '/');
} else {
    $_SESSION['lang'] = LANG;
    define("URLLANG",  URLPATH);
}
$where_lang = "and lang ='" . $_SESSION['lang'] . "'";
define("_lang",  $_SESSION['lang']);
define("_where_lang",  $where_lang);

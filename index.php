<?php
if (!isset($_SESSION)) {
    //session_set_cookie_params(['SameSite' => 'None']);
    session_start();
}
ob_start();
error_reporting(0);
// Hiển thị lỗi start
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// Hiển thị lổi end
define('_source', './sources/');
define('_lib', './admin/lib/');
define('_source_lib', 'sources/lib/');
/* Timezone */
date_default_timezone_set('Asia/Ho_Chi_Minh');
//session_destroy();
global $d;
global $lang;
include _lib . "config.php";

include_once _lib . "function.php";
include_once _lib . "class.php";

// Fix database connection initialization for PHP 8.1 (same as admin panel)
$d = new func_index();
$d->servername = $config['database']['servername'];
$d->username = $config['database']['username'];
$d->password = $config['database']['password'];
$d->database = $config['database']['database'];
$d->refix = $config['database']['refix'];
$d->connect();
include_once _source_lib . "lang.php";
include_once _source_lib . "info.php";
include_once _source_lib . "function.php";
include _source_lib . "file_router_index.php";
$ZERO_PATH = _lib . "Mobile_Detect.php";
require_once($ZERO_PATH);
$detect = new Mobile_Detect;
if (!isset($_SESSION['token'])) {
    token();
}
$url_page = getCurrentPageURL();

?>
<!DOCTYPE html>
<html lang="<?= _lang ?>">

<head>
    <base href="<?= URLPATH ?>" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include _source . "module/seo.php" ?>
    <?php include _source . "templates/css.php" ?>
    <?php if ($com != '') { ?>
        <?= $row['seo_head'] ?>
    <?php } ?>
    <?php
    header("Cache-Control: public, max-age=86400");
    header("Expires: " . gmdate("D, d M Y H:i:s", time() + 86400) . " GMT");
    ?>

</head>

<body>

    <?php
    include 'limit.php';
    include _source . "all.php";
    include _source . "module/menu-mobile.php";
    include _source . "_header.php";
    include _source . "module/slider.php";
    ?>

    <div class="wrapper <?php if ($com != '') echo 'wrapper-detail'; ?>">
        <?php include _source . $source . ".php"; ?>
    </div>

    <?php include _source . "_footer.php"; ?>
    <?php include _source . "module/hotrotructuyen.php" ?>
    <?php include _source . "templates/js.php" ?>
    <?php include 'sitemap/seo_footer.inc'; ?>

    <?php if ($com != '') { ?>
        <?= $row['seo_body'] ?>
    <?php } ?>

</body>

</html>
<?php $d->disconnect() ?>
<?php
$rf = str_replace('www.', '', $_SERVER["SERVER_NAME"]);
// $config['database']['refix'] = "db_";
// $config['database']['servername'] = 'localhost';
// $config['database']['username'] = 'root';
// $config['database']['password'] = '';
// $config['database']['database'] = 'cergy';
$config = array(
    'database' => array(
        'refix' => "db_",
        'servername' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'cms_81'
    ),
    'lang' => array(
        '0' => array(
            "code"  => "vi",
            "name"  => "Tiếng việt",
            "image" => "templates/images/icon_vn.webp",
            "price" => "VND"
        )
        
    ),
    "product" => array(
        "thong_so" => "0",
        "video" => "0",
        "file" => "0",
        "ma_sp" => "1",
        "gia" => "1",
        "khuyen_mai" => "1",
        "don_vi_tinh" => "0",
        "paging" => "15",
        "thuoctinh" => "1"
    ),
    "posts" => array(
        "video" => "0",
        "file" => "0",
        "paging" => "12"
    ),
    "category" => array(
        "index" => true,
        "noibat" => false
    ),
    "dev" => array(
        "display" => true
    ),
    "cart" => array(
        "display" => true
    )
);

define("URLPATH", "http://" . $_SERVER["SERVER_NAME"] . "/HIEP-CMS-8/");
define("urladmin", "http://" . $_SERVER["SERVER_NAME"] . "/HIEP-CMS-8/admin/");
define('_hiep_code', '199611');
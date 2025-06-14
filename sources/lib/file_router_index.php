<?php
$com = (isset($_REQUEST['com'])) ? addslashes($_REQUEST['com']) : "";

//kiểm tra bảng db_category
$row = $d->simple_fetch("select * from #_category where alias='$com' $where_lang ");
if (count($row ?? []) > 0 && $com != '') {
    $row_module = $d->simple_fetch("select templates from #_module where id = " . $row['module'] . " ");
    $nav_active =  $d->get_nav_act($row['id_code']);
    $source = $row_module['templates'];
    $type = 'website';
} elseif ($d->num_rows("select * from #_tintuc where alias='$com' $where_lang ") > 0 && $com != '') { //kiểm tra bảng db_tintuc
    //lấy chi tiết bài viết
    $row = $d->simple_fetch("select * from #_tintuc where alias='$com' $where_lang ");
    //lấy danh mục bài viết
    $category = $d->simple_fetch("select * from #_category where id_code = " . $row['id_loai'] . " $where_lang ");
    $nav_active =  $d->get_nav_act($category['id_code'] ?? 0);
    if (count($category ?? []) > 0) {
        $row_module = $d->simple_fetch("select templates from #_module where id = " . $category['module'] . " ");
        $source = $row_module['templates'] . '-detail';
        $type = 'article';
        $tinlienquan = $d->getNewss($row['id_loai'], 'ten,alias,hinh_anh,mo_ta', '', '0,8', ' and id_code <> ' . $row['id_code'] . '');
    } else {
        $source = '404';
    }
} elseif ($d->num_rows("select * from #_sanpham where alias='$com' $where_lang ") > 0 && $com != '') { //kiểm tra bảng db_sanpham
    //lấy chi tiết bài viết
    $row = $d->simple_fetch("select * from #_sanpham where alias='$com' $where_lang ");
    //lấy danh mục bài viết
    $category = $d->simple_fetch("select * from #_category where id_code = " . $row['id_loai'] . " $where_lang ");
    $nav_active =  $d->get_nav_act($category['id_code'] ?? 0);
    if (count($category ?? []) > 0) {
        $row_module = $d->simple_fetch("select templates from #_module where id = " . $category['module'] . " ");
        $source = $row_module['templates'] . '-detail';
        $type = 'product';
    } else {
        $source = '404';
    }
} elseif ($d->num_rows("select * from #_album where alias='$com' $where_lang ") > 0 && $com != '') { //kiểm tra bảng db_album
    //lấy chi tiết bài viết
    $row = $d->simple_fetch("select * from #_album where alias='$com' $where_lang ");
    //lấy danh mục bài viết
    $category = $d->simple_fetch("select * from #_category where id_code = " . $row['id_loai'] . " $where_lang ");
    if (count($category ?? []) > 0) {
        $row_module = $d->simple_fetch("select templates from #_module where id = " . $category['module'] . " ");
        $source = $row_module['templates'] . '-detail';
        $type = 'article';
    } else {
        $source = '404';
    }
} elseif ($d->num_rows("select * from #_video where alias='$com' $where_lang ") > 0 && $com != '') { //kiểm tra bảng db_album
    $row = $d->simple_fetch("select * from #_video where alias='$com' $where_lang ");
    $category = $d->simple_fetch("select * from #_category where id_code = " . $row['id_loai'] . " $where_lang ");
    if (count($category ?? []) > 0) {
        $row_module = $d->simple_fetch("select templates from #_module where id = " . $category['module'] . " ");
        $source = $row_module['templates'] . '-detail';
        $type = 'article';
    } else {
        $source = '404';
    }
} elseif ($com == 'sitemap') {
    $source = 'sitemap';
} elseif ($com == 'tags') {
    $source = 'tin-tuc';
} elseif ($com == 'search') {
    $source = 'search';
} elseif ($com == 'thanhcong') {
    $source = 'thanhcong';
} elseif ($com == '') {

    $source = 'index';
    $row = $d->simple_fetch("select * from #_seo where lang='" . $_SESSION['lang'] . "'");
    $type = 'business.business';
} elseif ($com == '404') {
    $source = '404';
} else {
    $source = '404';
}

// var_dump($source);
// var_dump($com);

<?php



if (!defined('_source')) die("Error");
$a = (isset($_REQUEST['a'])) ? addslashes($_REQUEST['a']) : "";

$link_option = '';
if (isset($_GET['search'])) {
    $link_option .= '&search=' . addslashes($_GET['search']);
}
if (isset($_GET['key'])) {
    $link_option .= '&key=' . addslashes($_GET['key']);
}
if (isset($_GET['page'])) {
    $link_option .= '&page=' . addslashes($_GET['page']);
}
$row_setting = $d->simple_fetch("select setting from #_module where id = 3 ");
$setting = $row_setting['setting'];
$arrr_setting = json_decode($setting, true);

switch ($a) {
    case "man":
        showdulieu();
        $template = @$_REQUEST['p'] . "/hienthi";
        break;
    case "add":
        showdulieu();
        $template = @$_REQUEST['p'] . "/them";
        break;
    case "edit":
        showdulieu();
        $template = @$_REQUEST['p'] . "/them";
        break;
    case "save":
        luudulieu($id_module);
        break;
    case "delete":
        xoadulieu($id_module);
        break;
    case "delete_all":
        xoadulieu_mang($id_module);
        break;
    default:
        $template = "index";
}


function show_menu_tintuc_hd($menus = array(), $parrent = 0, &$chuoi = '')
{
    foreach ($menus as $val) {
        if ($val['id_loai'] == $parrent) {
            $chuoi .= $val['id'] . ',';
            show_menu_tintuc_hd($menus, $val['id'], $chuoi);
        }
    }
    return $chuoi;
}
function showdulieu()
{
    global $d, $items, $limit, $loai, $total_page, $where_search;
    $loai = $d->array_category(0, '', $_GET['loaitin'], 3);
    $loai .= $d->array_category(0, '', $_GET['loaitin'], 18);
    if ($_REQUEST['a'] == 'man') {
        if (isset($_GET['search']) and $_GET['key'] != '' and $_GET['search'] != '') {
            if ($_GET['search'] == 'loai') {
                $id_code = $_GET['key'];
                $list_id = $id_code . $d->getIdsub($id_code);
                $where_search = " and id_loai in ($list_id)";
                $loai = $d->array_category(0, '', $id_code, 3);
            } else {
                $col    =   addslashes($_GET['search']);
                $value  =   addslashes($_GET['key']);
                $where_search = " and $col like '%" . $value . "%' ";
            }
        }
        $limit = 10;
        $items = $d->o_fet("select * from #_sanpham where lang ='" . LANG . "' $where_search order by so_thu_tu asc, cap_nhat desc, id desc limit 0, $limit");
        $total_records = $d->num_rows("select * from #_sanpham where lang ='" . LANG . "' $where_search order by so_thu_tu asc, cap_nhat desc, id desc");
        $total_page = ceil($total_records / $limit);
    } else {
        if (isset($_REQUEST['id'])) {
            @$id = addslashes($_REQUEST['id']);
            $items = $d->o_fet("select * from #_sanpham where id_code =  '" . $id . "'");
            $loai = $d->array_category(0, '', $items[0]['id_loai'], 3);
            $loai .= $d->array_category(0, '', $items[0]['id_loai'], 18);
        }
    }
}

function luudulieu($id_module)
{
    // echo implode(',', $_POST['sanpham_dicung']);
    // die();
    global $d;
    global $link_option;
    global $arrr_setting;
    if ($arrr_setting['option_resize'] != '') {
        $option_resize = $arrr_setting['option_resize'];
    } else {
        $option_resize = "auto";
    }
    if ($d->checkPermission_edit($id_module) == 1) {
        $id = (isset($_REQUEST['id'])) ? addslashes($_REQUEST['id']) : "";

        $file_name = $d->fns_Rand_digit(0, 9, 12);
        if ($id != '') {

            $alias0      = addslashes($_POST['alias'][0]);
            if ($d->checkLink($alias0, $id) == 0) {
                $alias0 .= "-" . rand(0, 9);
            }
            $hinh_anh = addslashes($_POST['hinh_anh']);

            if ($file_download = Uploadfile("file_download", 'file', '../img_data/files/', $alias0)) {
                $hinhanh = $d->o_fet("select file from #_sanpham where id_code = '" . $id . "'");
                @unlink('../img_data/files/' . $hinhanh[0]['file']);
                $file_dw = $file_download;
            }
            $id_loai    =   addslashes($_POST['id_loai']);
            $so_thu_tu  =   $_POST['so_thu_tu'] != '' ? $_POST['so_thu_tu'] : 0;
            $hien_thi   =   isset($_POST['hien_thi']) ? 1 : 0;

            $data0['ten']   =   addslashes($_POST['ten'][0]);
            $d->reset();
            $d->setTable('cf_parent');
            $d->setWhere('id', $id);
            if ($d->update($data0)) {
                //upload hình album
                $arr_img = isset($_POST['hinh_anh_slide']) ? $_POST['hinh_anh_slide'] : array();
                $d->o_que("delete from #_sanpham_hinhanh where id_sp = $id");
                for ($i = 0; $i < count($arr_img); $i++) {
                    unset($data_img);
                    $data_img['id_sp'] = $id;
                    $data_img['hinh_anh'] = $arr_img[$i];
                    $data_img['stt'] = $_POST['hinh_anh_slide_stt'][$i];
                    $d->reset();
                    $d->setTable('#_sanpham_hinhanh');
                    $d->insert($data_img);
                }
                // End upload hình album
                $arr_thuoctinh = isset($_POST['id_thuoctinh']) ? $_POST['id_thuoctinh'] : array();
                if (is_array($arr_thuoctinh) && count($arr_thuoctinh) > 0) {
                    for ($i = 0; $i < count($arr_thuoctinh); $i++) {
                        $id_thuoctinh = $arr_thuoctinh[$i];
                        if ($id_thuoctinh != '') {
                            $arr_ten_tt = isset($_POST['ten_' . $id_thuoctinh]) ? $_POST['ten_' . $id_thuoctinh] : array();
                            for ($j = 0; $j < count($arr_ten_tt); $j++) {
                                if ($_POST['id_thuoctinh_ct_' . $id_thuoctinh][$j] != '') {
                                    $id_thuoctinh_ct = $_POST['id_thuoctinh_ct_' . $id_thuoctinh][$j];
                                    $row_sp = $d->simple_fetch("select * from #_sanpham_chitiet where id_sp = " . $id . " and id = " . $id_thuoctinh_ct . " ");
                                    $data_tt['id_sp']           =   $id;
                                    $data_tt['id_thuoctinh']    =   $id_thuoctinh;
                                    $data_tt['ten']             =   addslashes($_POST['ten_' . $id_thuoctinh][$j]);
                                    $data_tt['mo_ta']           =   addslashes($_POST['mo_ta_' . $id_thuoctinh][$j]);
                                    $data_tt['ma']              =   addslashes($_POST['ma_' . $id_thuoctinh][$j]);
                                    $data_tt['gia']             =   addslashes($_POST['gia_' . $id_thuoctinh][$j]);
                                    $data_tt['khuyen_mai']      =   addslashes($_POST['khuyen_mai_' . $id_thuoctinh][$j]);
                                    // $data_tt['ft_dang']      =   addslashes($_POST['ft_dang']);
                                    if ((int)$_POST['so_luong_' . $id_thuoctinh][$j] > 0) {
                                        $data_tt['so_luong']        =   $row_sp['so_luong'] + (int)$_POST['so_luong_' . $id_thuoctinh][$j];
                                    } else {
                                        $data_tt['so_luong']        =   $row_sp['so_luong'];
                                    }
                                    $data_tt['hinh_anh']        =   addslashes($_POST['hinh_anh_' . $id_thuoctinh][$j]);
                                    $d->reset();
                                    $d->setTable('#_sanpham_chitiet');
                                    $d->setWhere('id', $id_thuoctinh_ct);
                                    if ($d->update($data_tt)) {
                                        //thêm thuộc tính con
                                        $arr_thuoctinh_sub_ten = isset($_POST['ten_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]]) ? $_POST['ten_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]] : array();
                                        if (is_array($arr_thuoctinh_sub_ten) && count($arr_thuoctinh_sub_ten) > 0) {
                                            $arr_thuoctinh_sub_mota = $_POST['mo_ta_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                            $arr_thuoctinh_sub_ma = $_POST['ma_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                            $arr_thuoctinh_sub_sl = $_POST['so_luong_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                            $arr_thuoctinh_sub_id = $_POST['id_thuoctinh_ct_sub_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                            for ($y = 0; $y < count($arr_thuoctinh_sub_ten); $y++) {
                                                if ($arr_thuoctinh_sub_id[$y] == '') {
                                                    $data_tt_sub['id_sp']           =   $id;
                                                    $data_tt_sub['id_loai']         =   $id_thuoctinh_ct;
                                                    $data_tt_sub['id_thuoctinh']    =   (int)$_POST['thuoc_tinh2'];
                                                    $data_tt_sub['ten']             =   addslashes($arr_thuoctinh_sub_ten[$y]);
                                                    $data_tt_sub['mo_ta']           =   addslashes($arr_thuoctinh_sub_mota[$y]);
                                                    $data_tt_sub['ma']              =   addslashes($arr_thuoctinh_sub_ma[$y]);
                                                    if ((int)$arr_thuoctinh_sub_sl[$y] > 0) {
                                                        $data_tt_sub['so_luong']        =   (int)$arr_thuoctinh_sub_sl[$y];
                                                    }
                                                    $d->reset();
                                                    $d->setTable('#_sanpham_chitiet');
                                                    $d->insert($data_tt_sub);
                                                } else {
                                                    $id_thuoctinh_ct_sub = $arr_thuoctinh_sub_id[$y];
                                                    $row_sub = $d->simple_fetch("select * from #_sanpham_chitiet where id = '" . $id_thuoctinh_ct_sub . "' ");
                                                    $data_tt_sub['id_sp']           =   $id;
                                                    $data_tt_sub['id_loai']         =   $row_sub['id_loai'];
                                                    $data_tt_sub['id_thuoctinh']    =   (int)$_POST['thuoc_tinh2'];
                                                    $data_tt_sub['ten']             =   addslashes($arr_thuoctinh_sub_ten[$y]);
                                                    $data_tt_sub['mo_ta']           =   addslashes($arr_thuoctinh_sub_mota[$y]);
                                                    $data_tt_sub['ma']              =   addslashes($arr_thuoctinh_sub_ma[$y]);


                                                    $d->reset();
                                                    $d->setTable('#_sanpham_chitiet');
                                                    $d->setWhere('id', $id_thuoctinh_ct_sub);
                                                    $d->update($data_tt_sub);
                                                }
                                            }
                                        }


                                        $arr_img_tt = isset($_POST['album_tt_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]]) ? $_POST['album_tt_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]] : array();
                                        // var_dump($arr_img_tt);
                                        // var_dump($id_thuoctinh);
                                        // var_dump($_POST['stt_' . $id_thuoctinh][$j]);
                                        // die('toi day');
                                        // $arr_img_tt = $_POST['album_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                        // echo count($arr_img_tt);

                                        // if ($j == 2) {
                                        //     var_dump(count($arr_ten_tt));
                                        //     var_dump($arr_img_tt);
                                        //     var_dump($id_thuoctinh);
                                        //     var_dump($_POST['stt_' . $id_thuoctinh][$j]);

                                        //     if($arr_img_tt[0] == "")
                                        //     {
                                        //         echo 'rỗng';
                                        //     } else {
                                        //         echo 'có dữ liệu';
                                        //     }

                                        //     var_dump(!empty($arr_img_tt));
                                        //     die('tới đây');
                                        // }
                                        if (is_array($arr_img_tt) && !empty($arr_img_tt) && $arr_img_tt[0] != "") {
                                            for ($y = 0; $y < count($arr_img_tt); $y++) {
                                                $data_img_ct['id_sp']       = $id;
                                                $data_img_ct['id_chitiet']  = $id_thuoctinh_ct;
                                                $data_img_ct['hinh_anh']    = $arr_img_tt[$y];
                                                $data_img_ct['stt']         = $y;
                                                $data_img_ct['title']       = '';

                                                // echo $data_img_ct['id_sp'];
                                                // echo  $data_img_ct['id_chitiet'];
                                                // echo $data_img_ct['hinh_anh'];
                                                // echo $data_img_ct['stt'];
                                                // echo  $data_img_ct['title'];
                                                // die('vo dayu');
                                                $d->reset();
                                                $d->setTable('#_sanpham_hinhanh');
                                                $d->insert($data_img_ct);
                                            }
                                        }
                                    }
                                } else {
                                    if ($_POST['ten_' . $id_thuoctinh][$j] != '') {
                                        $data_tt['id_sp']           =   $id;
                                        $data_tt['id_thuoctinh']    =   $id_thuoctinh;
                                        $data_tt['ten']             =   addslashes($_POST['ten_' . $id_thuoctinh][$j]);
                                        $data_tt['mo_ta']           =   addslashes($_POST['mo_ta_' . $id_thuoctinh][$j]);
                                        $data_tt['ma']              =   addslashes($_POST['ma_' . $id_thuoctinh][$j]);
                                        $data_tt['gia']              =   addslashes($_POST['gia_' . $id_thuoctinh][$j]);
                                        $data_tt['khuyen_mai']              =   addslashes($_POST['khuyen_mai_' . $id_thuoctinh][$j]);
                                        if ((int)$_POST['so_luong_' . $id_thuoctinh][$j] > 0) {
                                            $data_tt['so_luong']        =   (int)$_POST['so_luong_' . $id_thuoctinh][$j];
                                        } else {
                                            $data_tt['so_luong']        =   0;
                                        }
                                        $data_tt['hinh_anh']        =   addslashes($_POST['hinh_anh_' . $id_thuoctinh][$j]);
                                        $d->reset();
                                        $d->setTable('#_sanpham_chitiet');
                                        if ($id_ct = $d->insert($data_tt)) {


                                            //thêm thuộc tính con
                                            $arr_thuoctinh_sub_ten = $_POST['ten_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                            if (count($arr_thuoctinh_sub_ten) > 0) {
                                                $arr_thuoctinh_sub_mota = $_POST['mo_ta_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                                $arr_thuoctinh_sub_ma = $_POST['ma_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                                $arr_thuoctinh_sub_sl = $_POST['so_luong_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                                for ($y = 0; $y < count($arr_thuoctinh_sub_ten); $y++) {
                                                    $data_tt_sub['id_sp']           =   $id;
                                                    $data_tt_sub['id_loai']         =   $id_ct;
                                                    $data_tt_sub['id_thuoctinh']    =   (int)$_POST['thuoc_tinh2'];
                                                    $data_tt_sub['ten']             =   addslashes($arr_thuoctinh_sub_ten[$y]);
                                                    $data_tt_sub['mo_ta']           =   addslashes($arr_thuoctinh_sub_mota[$y]);
                                                    $data_tt_sub['ma']              =   addslashes($arr_thuoctinh_sub_ma[$y]);
                                                    if ((int)$arr_thuoctinh_sub_sl[$y] > 0) {
                                                        $data_tt_sub['so_luong']        =   (int)$arr_thuoctinh_sub_sl[$y];
                                                    }
                                                    $d->reset();
                                                    $d->setTable('#_sanpham_chitiet');
                                                    $d->insert($data_tt_sub);
                                                }
                                            }

                                            $arr_img_tt = $_POST['album_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                            if (count($arr_img_tt) > 0) {
                                                for ($y = 0; $y < count($arr_img_tt); $y++) {
                                                    $data_img_ct['id_sp']       = $id;
                                                    $data_img_ct['id_chitiet']  = $id_ct;
                                                    $data_img_ct['hinh_anh']    = $arr_img_tt[$y];
                                                    $data_img_ct['stt']         = $y;
                                                    $data_img_ct['title']       = '';
                                                    $d->reset();
                                                    $d->setTable('#_sanpham_hinhanh');
                                                    $d->insert($data_img_ct);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                foreach (get_json('lang') as $key => $value) {
                    $data['id_loai'] = $id_loai;
                    $data['video'] = $d->clear(addslashes($_POST['ma_video']));
                    $data['file'] = $file_dw;
                    $data['link_khac'] = $d->clear(addslashes($_POST['link_khac']));
                    if ($_POST['link_khac'] != '') {
                        $data['loai_file']  = addslashes($_POST['loai_file']);
                    }
                    $data['ten'] = $d->clear(addslashes($_POST['ten'][$key]));
                    $data['linkshopee'] = $d->clear(addslashes($_POST['linkshopee'][$key]));
                    $data['brand'] = $d->clear(addslashes($_POST['brand'][$key]));
                    $data['dung_tich'] = $d->clear(addslashes($_POST['dung_tich'][$key]));
                    $data['lieu_luong'] = $d->clear(addslashes($_POST['lieu_luong'][$key]));
                    $data['slug']            = addslashes($_POST['slug'][$key]);
                    // $data['sanpham_dicung'] = implode(',', $_POST['sanpham_dicung']);
                    if ($hinh_anh != '') {
                        $data['hinh_anh'] = $hinh_anh;
                    }
                    $data['mo_ta'] = $d->clear(addslashes($_POST['mo_ta'][$key]));
                    $data['noi_dung'] = $d->clear(addslashes($_POST['noi_dung'][$key]));
                    if (isset($_POST['nameinfo_' . $value['code']])) {
                        $arr_info = array();
                        foreach ($_POST['nameinfo_' . $value['code']] as $i => $items) {
                            $detail_info = $_POST['detailinfo_' . $value['code']][$i];
                            $name_info = $items;
                            if ($name_info != '' and $detail_info != '') {
                                array_push($arr_info, $name_info . '%%%' . $detail_info);
                            }
                        }
                        if ($_POST['nameinfo_' . $value['code']][0] == '' and count($arr_info) == 1) {
                            $str_arr = "";
                            $data['thong_so_kt'] = "";
                        } else {
                            $str_arr = addslashes(json_encode($arr_info));
                            $data['thong_so_kt'] = $str_arr;
                        }
                    }

                    $data['alias']          = addslashes($_POST['alias'][$key]);
                    if ($d->checkLink($data['alias'], $_POST['id_row'][$key]) == 0) {
                        $data['alias'] .= "-" . rand(0, 9);
                    }
                    $data['dvt']            =   $d->clear(addslashes($_POST['dvt'][$key]));
                    $data['title']          =   $d->clear(addslashes($_POST['title'][$key]));
                    $data['keyword']        =   $d->clear(addslashes($_POST['keyword'][$key]));
                    $data['des']            =   addslashes($_POST['des'][$key]);
                    $data['seo_head']        = addslashes($_POST['seo_head'][$key]);
                    $data['seo_body']        = addslashes($_POST['seo_body'][$key]);
                    $data['cap_nhat']       =   time();
                    $data['hien_thi']       =   $hien_thi;
                    $data['ft_dang']       =   $_POST['ft_dang'];
                    $data['tinhtrang']       =   $_POST['tinhtrang'];
                    $data['nofollow']       =   isset($_POST['nofollow']) ? 1 : 0;
                    $data['noindex']        =   isset($_POST['noindex']) ? 1 : 0;
                    $data['so_thu_tu']      =   $so_thu_tu;
                    $data['ma_sp']          =   $d->clear(addslashes($_POST['ma_sp']));
                    $data['da_ban']          =   $d->clear(addslashes($_POST['da_ban']));
                    $data['gia']           =   (isset($_POST['gia']) && $_POST['gia'] != '') ? str_replace(",", "", $d->clear(addslashes($_POST['gia']))) : 0;
                    $data['khuyen_mai']    =   (isset($_POST['gia']) && $_POST['khuyen_mai'] != '') ? str_replace(",", "", $d->clear(addslashes($_POST['khuyen_mai']))) : 0;
                    $data['gia_flash_sale']        =   $d->clear(addslashes($_POST['gia_flash_sale']));
                    $data['flash_sale']    =   $d->clear(addslashes($_POST['flash_sale']));

                    if ($_POST['id_row'][$key] == '') {
                        $data['id_code'] = $d->clear(addslashes($id));
                        $data['lang']  =   $value['code'];
                        $d->reset();
                        $d->setTable('#_sanpham');
                        $d->insert($data);
                    } else {
                        $d->reset();
                        $d->setTable('#_sanpham');
                        $d->setWhere('id', $_POST['id_row'][$key]);
                        $d->update($data);
                    }
                }
                // Cập nhật sitemap sau khi thêm/sửa sản phẩm
                update_sitemap();
                $d->redirect("index.php?p=san-pham&a=man" . $link_option);
            } else {
                $d->alert("Cập nhật dữ liệu bị lỗi!");
                $d->redirect("Cập nhật dữ liệu bị lỗi", "index.php?p=san-pham&a=man" . $link_option);
            }
        } else {

            $alias0      = addslashes($_POST['alias'][0]);
            if ($d->checkLink($alias0) == 0) {
                $alias0 .= "-" . rand(0, 9);
            }
            $hinh_anh = addslashes($_POST['hinh_anh']);
            if ($file_download = Uploadfile("file_download", 'file', '../img_data/files/', $alias0)) {
                $file_dw = $file_download;
            }
            $id_loai        =   addslashes($_POST['id_loai']);
            $so_thu_tu      =   $_POST['so_thu_tu'] != '' ? $_POST['so_thu_tu'] : 0;
            $hien_thi       =   isset($_POST['hien_thi']) ? 1 : 0;
            $data0['ten']   =   addslashes($_POST['ten'][0]);
            $d->reset();
            $d->setTable('cf_parent');
            if ($id_code = $d->insert($data0)) {
                //upload hình album
                $arr_img = isset($_POST['hinh_anh_slide']) ? $_POST['hinh_anh_slide'] : array();
                if (is_array($arr_img) && count($arr_img) > 0) {
                    for ($i = 0; $i < count($arr_img); $i++) {
                        $data_img['id_sp'] = $id_code;
                        $data_img['hinh_anh'] = $arr_img[$i];
                        $data_img['stt'] = $_POST['hinh_anh_slide_stt'][$i];
                        $d->reset();
                        $d->setTable('#_sanpham_hinhanh');
                        $d->insert($data_img);
                    }
                }
                // End upload hình album

                //thêm thuộc tính sản phẩm
                $arr_thuoctinh = isset($_POST['id_thuoctinh']) ? $_POST['id_thuoctinh'] : array();
                if (is_array($arr_thuoctinh) && count($arr_thuoctinh) > 0) {
                    for ($i = 0; $i < count($arr_thuoctinh); $i++) {
                        $id_thuoctinh = $arr_thuoctinh[$i];
                        if ($id_thuoctinh) {
                            $arr_ten_tt = isset($_POST['ten_' . $id_thuoctinh]) ? $_POST['ten_' . $id_thuoctinh] : array();
                            for ($j = 0; $j < count($arr_ten_tt); $j++) {
                                if ($_POST['ten_' . $id_thuoctinh][$j] != '') {
                                    $data_tt['id_sp']           =   $id_code;
                                    $data_tt['id_thuoctinh']    =   $id_thuoctinh;
                                    $data_tt['ten']             =   addslashes($_POST['ten_' . $id_thuoctinh][$j]);
                                    $data_tt['mo_ta']           =   addslashes($_POST['mo_ta_' . $id_thuoctinh][$j]);
                                    $data_tt['ma']              =   addslashes($_POST['ma_' . $id_thuoctinh][$j]);
                                    $data_tt['gia']              =   addslashes($_POST['gia_' . $id_thuoctinh][$j]);
                                    $data_tt['khuyen_mai']              =   addslashes($_POST['khuyen_mai_' . $id_thuoctinh][$j]);
                                    if ((int)$_POST['so_luong_' . $id_thuoctinh][$j] > 0) {
                                        $data_tt['so_luong']        =   (int)$_POST['so_luong_' . $id_thuoctinh][$j];
                                    }
                                    $data_tt['hinh_anh']        =   addslashes($_POST['hinh_anh_' . $id_thuoctinh][$j]);
                                    $d->reset();
                                    $d->setTable('#_sanpham_chitiet');
                                    if ($id_ct = $d->insert($data_tt)) {

                                        // $arr_img_tt = $_POST['album_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                        // if (count($arr_img_tt) > 0) {
                                        //     for ($y = 0; $y < count($arr_img_tt); $y++) {
                                        //         $data_img_ct['id_sp']       = $id_code;
                                        //         $data_img_ct['id_chitiet']  = $id_ct;
                                        //         $data_img_ct['hinh_anh']    = $arr_img_tt[$y];
                                        //         $data_img_ct['stt']         = $y;
                                        //         $data_img_ct['title']       = '';
                                        //         $d->reset();
                                        //         $d->setTable('#_sanpham_hinhanh');
                                        //         $d->insert($data_img_ct);
                                        //     }
                                        // }

                                        //thêm thuộc tính con
                                        $arr_thuoctinh_sub_ten = $_POST['ten_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                        if (count($arr_thuoctinh_sub_ten) > 0) {
                                            $arr_thuoctinh_sub_mota = $_POST['mo_ta_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                            $arr_thuoctinh_sub_ma = $_POST['ma_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                            $arr_thuoctinh_sub_sl = $_POST['so_luong_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                            $arr_thuoctinh_sub_id = $_POST['id_thuoctinh_ct_sub_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                            for ($y = 0; $y < count($arr_thuoctinh_sub_ten); $y++) {
                                                if ($arr_thuoctinh_sub_id[$y] == '') {
                                                    $data_tt_sub['id_sp']           =   $id;
                                                    $data_tt_sub['id_loai']         =   $id_ct;
                                                    $data_tt_sub['id_thuoctinh']    =   (int)$_POST['thuoc_tinh2'];
                                                    $data_tt_sub['ten']             =   addslashes($arr_thuoctinh_sub_ten[$y]);
                                                    $data_tt_sub['mo_ta']           =   addslashes($arr_thuoctinh_sub_mota[$y]);
                                                    $data_tt_sub['ma']              =   addslashes($arr_thuoctinh_sub_ma[$y]);
                                                    if ((int)$arr_thuoctinh_sub_sl[$y] > 0) {
                                                        $data_tt_sub['so_luong']        =   (int)$arr_thuoctinh_sub_sl[$y];
                                                    }
                                                    $d->reset();
                                                    $d->setTable('#_sanpham_chitiet');
                                                    $d->insert($data_tt_sub);
                                                } else {
                                                    $id_thuoctinh_ct_sub = $arr_thuoctinh_sub_id[$y];
                                                    $row_sub = $d->simple_fetch("select * from #_sanpham_chitiet where id = '" . $id_thuoctinh_ct_sub . "' ");
                                                    $data_tt_sub['id_sp']           =   $id;
                                                    $data_tt_sub['id_loai']         =   $row_sub['id_loai'];
                                                    $data_tt_sub['id_thuoctinh']    =   (int)$_POST['thuoc_tinh2'];
                                                    $data_tt_sub['ten']             =   addslashes($arr_thuoctinh_sub_ten[$y]);
                                                    $data_tt_sub['mo_ta']           =   addslashes($arr_thuoctinh_sub_mota[$y]);
                                                    $data_tt_sub['ma']              =   addslashes($arr_thuoctinh_sub_ma[$y]);


                                                    $d->reset();
                                                    $d->setTable('#_sanpham_chitiet');
                                                    $d->setWhere('id', $id_thuoctinh_ct_sub);
                                                    $d->update($data_tt_sub);
                                                }
                                            }
                                        }


                                        $arr_img_tt = $_POST['album_tt_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                        //     var_dump($arr_img_tt);
                                        //     var_dump($id_thuoctinh);
                                        //     var_dump($_POST['stt_' . $id_thuoctinh][$j]);
                                        //    echo $j;
                                        //     die('chay to iday');
                                        if ($arr_img_tt[0] != "") {
                                            for ($y = 0; $y < count($arr_img_tt); $y++) {
                                                $data_img_ct['id_sp']       = $id_code;
                                                $data_img_ct['id_chitiet']  = $id_ct;
                                                $data_img_ct['hinh_anh']    = $arr_img_tt[$y];
                                                $data_img_ct['stt']         = $y;
                                                $data_img_ct['title']       = '';

                                                // die('vo toi day');
                                                $d->reset();
                                                $d->setTable('#_sanpham_hinhanh');
                                                $d->insert($data_img_ct);
                                            }
                                        }




                                        //thêm thuộc tính con
                                        $arr_thuoctinh_sub_ten = $_POST['ten_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                        if (count($arr_thuoctinh_sub_ten) > 0) {
                                            $arr_thuoctinh_sub_mota = $_POST['mo_ta_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                            $arr_thuoctinh_sub_ma = $_POST['ma_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                            $arr_thuoctinh_sub_sl = $_POST['so_luong_' . $id_thuoctinh . '_' . $_POST['stt_' . $id_thuoctinh][$j]];
                                            for ($y = 0; $y < count($arr_thuoctinh_sub_ten); $y++) {
                                                $data_tt_sub['id_sp']           =   $id_code;
                                                $data_tt_sub['id_loai']         =   $id_ct;
                                                $data_tt_sub['id_thuoctinh']    =   (int)$_POST['thuoc_tinh2'];
                                                $data_tt_sub['ten']             =   addslashes($arr_thuoctinh_sub_ten[$y]);
                                                $data_tt_sub['mo_ta']           =   addslashes($arr_thuoctinh_sub_mota[$y]);
                                                $data_tt_sub['ma']              =   addslashes($arr_thuoctinh_sub_ma[$y]);
                                                if ((int)$arr_thuoctinh_sub_sl[$y] > 0) {
                                                    $data_tt_sub['so_luong']        =   (int)$arr_thuoctinh_sub_sl[$y];
                                                }
                                                $d->reset();
                                                $d->setTable('#_sanpham_chitiet');
                                                $d->insert($data_tt_sub);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                foreach (get_json('lang') as $key => $value) {
                    $data['id_loai'] = $id_loai;
                    $data['video'] = $d->clear(addslashes($_POST['ma_video']));
                    $data['file'] = $file_dw;
                    $data['link_khac'] = $d->clear(addslashes($_POST['link_khac']));
                    if ($_POST['link_khac'] != '') {
                        $data['loai_file']  = addslashes($_POST['loai_file']);
                    }
                    $data['ten'] = $d->clear(addslashes($_POST['ten'][$key]));
                    $data['slug']            = addslashes($_POST['slug'][$key]);
                    $data['linkshopee']            = addslashes($_POST['linkshopee'][$key]);
                    $data['brand']            = addslashes($_POST['brand'][$key]);
                    $data['dung_tich']            = addslashes($_POST['dung_tich'][$key]);
                    $data['lieu_luong']            = addslashes($_POST['lieu_luong'][$key]);
                    // $data['sanpham_dicung'] = implode(',', $_POST['sanpham_dicung']);
                    $data['hinh_anh'] = $hinh_anh;
                    $data['mo_ta'] = $d->clear(addslashes($_POST['mo_ta'][$key]));
                    $data['noi_dung'] = $d->clear(addslashes($_POST['noi_dung'][$key]));
                    $data['noi_dung_1'] = $d->clear(addslashes($_POST['noi_dung_1'][$key]));
                    $data['noi_dung_2'] = $d->clear(addslashes($_POST['noi_dung_2'][$key]));
                    if (isset($_POST['nameinfo_' . $value['code']])) {
                        $arr_info = array();
                        foreach ($_POST['nameinfo_' . $value['code']] as $i => $items) {
                            $detail_info = $_POST['detailinfo_' . $value['code']][$i];
                            $name_info = $items;
                            if ($name_info != '' and $detail_info != '') {
                                array_push($arr_info, $name_info . '%%%' . $detail_info);
                            }
                        }
                        if ($_POST['nameinfo_' . $value['code']][0] == '' and count($arr_info) == 1) {
                            $str_arr = "";
                            $data['thong_so_kt'] = "";
                        } else {
                            $str_arr = addslashes(json_encode($arr_info));
                            $data['thong_so_kt'] = $str_arr;
                        }
                    }

                    $data['alias'] = $d->clear(addslashes($_POST['alias'][$key]));
                    if ($d->checkLink($data['alias'], $id) == 0) {
                        $data['alias'] .= "-" . rand(10, 999);
                    }
                    $data['title']          =   $d->clear(addslashes($_POST['title'][$key]));
                    $data['dvt']            =   $d->clear(addslashes($_POST['dvt'][$key]));
                    $data['keyword']        =   $d->clear(addslashes($_POST['keyword'][$key]));
                    $data['des']            =   addslashes($_POST['des'][$key]);
                    $data['seo_head']        = addslashes($_POST['seo_head'][$key]);
                    $data['seo_body']        = addslashes($_POST['seo_body'][$key]);
                    $data['ngay_dang']      =   time();
                    $data['cap_nhat']       =   time();
                    $data['hien_thi']       =   $hien_thi;
                    $data['ft_dang']       =   $_POST['ft_dang'];
                    $data['tinhtrang']       =   $_POST['tinhtrang'];
                    $data['nofollow']       =   isset($_POST['nofollow']) ? 1 : 0;
                    $data['noindex']        =   isset($_POST['noindex']) ? 1 : 0;
                    $data['so_thu_tu']      =   $so_thu_tu;
                    $data['ma_sp']          =   $d->clear(addslashes($_POST['ma_sp']));
                    $data['da_ban']          =   $d->clear(addslashes($_POST['da_ban']));
                    $data['gia']            =   (isset($_POST['gia']) && $_POST['gia'] != '') ? str_replace(",", "", $d->clear(addslashes($_POST['gia']))) : 0;
                    $data['khuyen_mai']     =   (isset($_POST['khuyen_mai']) && $_POST['khuyen_mai'] != '') ? str_replace(",", "", $d->clear(addslashes($_POST['khuyen_mai']))) : 0;
                    $data['gia_flash_sale']        =   $d->clear(addslashes($_POST['gia_flash_sale']));
                    $data['flash_sale']     =   $d->clear(addslashes($_POST['flash_sale']));

                    $data['id_code']        =   $id_code;
                    $data['lang']           =   $value['code'];
                    $d->reset();
                    $d->setTable('#_sanpham');
                    $d->insert($data);
                }
                // Cập nhật sitemap sau khi thêm/sửa sản phẩm
                update_sitemap();
                $d->redirect("index.php?p=san-pham&a=man" . $link_option);
            } else {
                $d->alert("Thêm dữ liệu bị lỗi!");
                $d->redirect("Thêm dữ liệu bị lỗi", "index.php?p=san-pham&a=man" . $link_option);
            }
        }
    } else {
        $d->redirect("index.php?p=san-pham&a=man&" . $link_option);
    }
}

function xoadulieu($id_module)
{
    global $d;
    global $link_option;
    if ($d->checkPermission_dele($id_module) == 1) {
        if (isset($_GET['id'])) {
            $id =  addslashes($_GET['id']);
            $d->reset();
            $d->setTable('#_sanpham');
            $d->setWhere('id_code', $id);
            if ($d->delete()) {
                $d->o_que("delete from cf_parent where id = $id ");
                $d->o_que("delete from #_sanpham_hinhanh where id_sp = $id ");
                $d->o_que("delete from #_sanpham_chitiet where id_sp = $id ");
                // Cập nhật sitemap sau khi xóa sản phẩm
                update_sitemap();
                $d->redirect("index.php?p=san-pham&a=man" . $link_option);
            } else {
                $d->alert("Xóa dữ liệu bị lỗi!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=san-pham&a=man" . $link_option);
            }
        } else {
            $d->alert("Không nhận được dữ liệu!");
            $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=san-pham&a=man" . $link_option);
        }
    } else {
        $d->redirect("index.php?p=san-pham&a=man" . $link_option);
    }
}

function xoadulieu_mang($id_module)
{
    global $d;
    global $link_option;
    if ($d->checkPermission_dele($id_module) == 1) {
        if (isset($_POST['chk_child'])) {
            $chuoi = "";
            foreach ($_POST['chk_child'] as $val) {
                $chuoi .= $val . ',';
            }
            $chuoi = trim($chuoi, ',');
            if ($d->o_que("delete from #_sanpham where id_code in ($chuoi)")) {
                $d->o_que("delete from cf_parent where id in ($chuoi) ");
                $d->o_que("delete from #_sanpham_hinhanh where id_sp in ($chuoi) ");
                $d->o_que("delete from #_sanpham_chitiet where id_sp in ($chuoi)  ");
                // Cập nhật sitemap sau khi xóa nhiều sản phẩm
                update_sitemap();
                $d->redirect("index.php?p=san-pham&a=man" . $link_option);
            } else {
                $d->alert("Không nhận được dữ liệu!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=san-pham&a=man" . $link_option);
            }
        } else $d->redirect("index.php?p=san-pham&a=man" . $link_option);
    } else {
        $d->redirect("index.php?p=san-pham&a=man" . $link_option);
    }
}

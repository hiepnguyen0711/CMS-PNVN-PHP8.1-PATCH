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
$row_setting = $d->simple_fetch("select setting from #_module where id = 1 ");
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
function showdulieu()
{

    global $d, $items, $loai, $total_page, $limit, $total_records, $where_search;
    $loai = $d->array_category(0, '', $_GET['loaitin'], 1);

    if ($_REQUEST['a'] == 'man') {

        if (isset($_GET['search']) and $_GET['key'] != ''  and $_GET['search'] != '') {
            if ($_GET['search'] == 'loai') {
                $id_code = $_GET['key'];
                $list_id = $id_code . $d->getIdsub($id_code);
                $where_search = " and id_loai in ($list_id)";
                $loai = $d->array_category(0, '', $id_code, 1);
            } else {
                $col    =   addslashes($_GET['search']);
                $value  =   addslashes($_GET['key']);
                $where_search = " and $col like '%" . $value . "%' ";
            }
        }

        $limit = 20;
        $items = $d->o_fet("select * from #_album where lang ='" . LANG . "' $where_search order by so_thu_tu asc, cap_nhat desc, id desc limit 0, $limit");
        $total_records = $d->num_rows("select id from #_album where lang ='" . LANG . "' $where_search order by so_thu_tu asc, cap_nhat desc, id desc");
        $total_page = ceil($total_records / $limit);
    } else {

        if (isset($_REQUEST['id'])) {
            @$id = addslashes($_REQUEST['id']);
            $items = $d->o_fet("select * from #_album where id_code =  '" . $id . "'");
            $loai = $d->array_category(0, '', $items[0]['id_loai'], 1);
        }
    }
}

function luudulieu($id_module)
{

    global $d;
    global $link_option;
    global $arrr_setting;
    if ($arrr_setting['size_img'] != '') {
        $size = explode('x', $arrr_setting['size_img']);
        $w = (int)$size[0];
        $h = (int)$size[1];
    } else {
        $w = 300;
        $h = 300;
    }

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

            $id_loai    =   addslashes($_POST['id_loai']);
            $so_thu_tu  =   $_POST['so_thu_tu'] != '' ? $_POST['so_thu_tu'] : 0;
            $hien_thi   =   isset($_POST['hien_thi']) ? 1 : 0;

            $data0['ten']   =   addslashes($_POST['ten'][0]);
            $d->reset();
            $d->setTable('cf_parent');
            $d->setWhere('id', $id);
            if ($d->update($data0)) {
                //upload hình album
                $arr_img = isset($_POST['album']) ? $_POST['album'] : array();
                $d->o_que("delete from #_album_hinhanh where id_album = $id");
                // var_dump($arr_img);
                // die();
                for ($i = 0; $i < count($arr_img); $i++) {
                    unset($data_img);
                    $data_img['id_album'] = $id;
                    $data_img['hinh_anh'] = $arr_img[$i];
                    $data_img['stt'] = $_POST['album_slide_stt'][$i];
                    // var_dump($data_img);
                    // die();
                    $d->reset();
                    $d->setTable('#_album_hinhanh');
                    $d->insert($data_img);
                }
                // End upload hình album
                foreach (get_json('lang') as $key => $value) {
                    $data['id_loai'] = $id_loai;
                    $data['ten'] = $d->clear(addslashes($_POST['ten'][$key]));
                    if ($hinh_anh != '') {
                        $data['hinh_anh'] = $hinh_anh;
                    }
                    $data['noi_dung'] = $d->clear(addslashes($_POST['noi_dung'][$key]));
                    $data['alias']          = addslashes($_POST['alias'][$key]);
                    if ($d->checkLink($data['alias'], $_POST['id_row'][$key]) == 0) {
                        $data['alias'] .= "-" . rand(0, 9);
                    }
                    $data['title'] = $d->clear(addslashes($_POST['title'][$key]));
                    $data['keyword'] = $d->clear(addslashes($_POST['keyword'][$key]));
                    $data['des'] = addslashes($_POST['des'][$key]);
                    $data['cap_nhat'] = time();
                    $data['hien_thi'] = $hien_thi;
                    $data['so_thu_tu'] = $so_thu_tu;
                    $d->reset();
                    $d->setTable('#_album');
                    $d->setWhere('id', $_POST['id_row'][$key]);
                    $d->update($data);
                }
                $d->redirect("index.php?p=gallery&a=man" . $link_option);
            } else {
                $d->alert("Cập nhật dữ liệu bị lỗi!");
                $d->redirect("Cập nhật dữ liệu bị lỗi", "index.php?p=gallery&a=man" . $link_option);
            }
        } else {
            $alias0      = addslashes($_POST['alias'][0]);
            if ($d->checkLink($alias0) == 0) {
                $alias0 .= "-" . rand(0, 9);
            }
            $hinh_anh = addslashes($_POST['hinh_anh']);

            $id_loai        =   addslashes($_POST['id_loai']);
            $so_thu_tu      =   $_POST['so_thu_tu'] != '' ? $_POST['so_thu_tu'] : 0;
            $hien_thi       =   isset($_POST['hien_thi']) ? 1 : 0;
            $data0['ten']   =   addslashes($_POST['ten'][0]);
            $d->reset();
            $d->setTable('cf_parent');
            if ($id_code = $d->insert($data0)) {
                //upload hình album
                $arr_img = isset($_POST['album']) ? $_POST['album'] : array();
                if (is_array($arr_img) && count($arr_img) > 0) {
                    for ($i = 0; $i < count($arr_img); $i++) {
                        $data_img['id_album'] = $id_code;
                        $data_img['hinh_anh'] = $arr_img[$i];
                        $data_img['stt'] = $_POST['album_slide_stt'][$i];
                        $d->reset();
                        $d->setTable('#_album_hinhanh');
                        $d->insert($data_img);
                    }
                }
                // End upload hình album

                foreach (get_json('lang') as $key => $value) {

                    $data['id_loai'] = $id_loai;
                    $data['ten'] = $d->clear(addslashes($_POST['ten'][$key]));
                    $data['hinh_anh'] = $hinh_anh;
                    $data['noi_dung'] = $d->clear(addslashes($_POST['noi_dung'][$key]));
                    $data['alias'] = $d->clear(addslashes($_POST['alias'][$key]));
                    if ($d->checkLink($data['alias'], $id) == 0) {
                        $data['alias'] .= "-" . rand(10, 999);
                    }
                    $data['title'] = $d->clear(addslashes($_POST['title'][$key]));
                    $data['keyword'] = $d->clear(addslashes($_POST['keyword'][$key]));
                    $data['des'] = addslashes($_POST['des'][$key]);
                    $data['ngay_dang'] = time();
                    $data['cap_nhat'] = time();
                    $data['hien_thi'] = $hien_thi;
                    $data['so_thu_tu'] = $so_thu_tu;
                    $data['id_code']    =   $id_code;
                    $data['lang']       =   $value['code'];
                    $d->reset();
                    $d->setTable('#_album');
                    $d->insert($data);
                }
                $d->redirect("index.php?p=gallery&a=man" . $link_option);
            } else {
                $d->alert("Thêm dữ liệu bị lỗi!");
                $d->redirect("Thêm dữ liệu bị lỗi", "index.php?p=gallery&a=man" . $link_option);
            }
        }
    } else {
        $d->redirect("index.php?p=gallery&a=man&loaitin=" . @$_GET['loaitin']);
    }
}

function xoadulieu($id_module)
{
    global $link_option;
    global $d;
    if ($d->checkPermission_dele($id_module) == 1) {
        if (isset($_GET['id'])) {
            $id =  addslashes($_GET['id']);
            $hinhanh = $d->o_fet("select * from #_album where id_code = '" . $id . "'");
            @unlink('../uploads/images/' . $hinhanh[0]['hinh_anh']);
            @unlink('../uploads/images/thumb/' . $hinhanh[0]['hinh_anh']);
            $d->reset();
            $d->setTable('#_album');
            $d->setWhere('id_code', $id);
            if ($d->delete()) {
                $d->o_que("delete from cf_parent where id = $id ");
                $hinhanh_ct = $d->o_fet("select * from #_album_hinhanh where id_album = '" . $id . "'");
                foreach ($hinhanh_ct as $key => $value) {
                    if ($value['hinh_anh'] != '') {
                        @unlink('../uploads/images/' . $value['hinh_anh']);
                        @unlink('../uploads/images/thumb/' . $value['hinh_anh']);
                    }
                }
                $d->o_que("delete from #_album_hinhanh where id_album = $id ");
                $d->redirect("index.php?p=gallery&a=man$link_option" . $link_option);
            } else {
                $d->alert("Xóa dữ liệu bị lỗi!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=gallery&a=man" . $link_option);
            }
        } else {
            $d->alert("Không nhận được dữ liệu!");
            $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=gallery&a=man$link_option" . $link_option);
        }
    } else {
        $d->redirect("index.php?p=gallery&a=man&page=" . @$_REQUEST['page'] . "$link_option" . $link_option);
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
            //lay danh sách idsp theo chuoi
            $hinhanh = $d->o_fet("select * from #_album where id_code in ($chuoi) and lang ='" . LANG . "'");
            if ($d->o_que("delete from #_album where id_code in ($chuoi)")) {
                $d->o_que("delete from cf_parent where id in ($chuoi) ");
                $hinhanh_ct = $d->o_fet("select * from #_album_hinhanh where id_album in ($chuoi) ");
                foreach ($hinhanh_ct as $key => $value) {
                    if ($value['hinh_anh'] != '') {
                        @unlink('../uploads/images/' . $value['hinh_anh']);
                        @unlink('../uploads/images/thumb/' . $value['hinh_anh']);
                    }
                }
                $d->o_que("delete from #_album_hinhanh where id_album in ($chuoi) ");
                //xoa hình ảnh
                foreach ($hinhanh as $ha) {
                    @unlink('../uploads/images/' . $ha['hinh_anh']);
                }
                $d->redirect("index.php?p=gallery&a=man&page=" . @$_REQUEST['page'] . "&loaitin=" . @$_GET['loaitin']);
            } else {
                $d->alert("Không nhận được dữ liệu!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=gallery&a=man" . $link_option);
            }
        } else $d->redirect("index.php?p=gallery&a=man" . $link_option);
    } else {
        $d->redirect("index.php?p=gallery&a=man" . $link_option);
    }
}

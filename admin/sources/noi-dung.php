<?php
if (!defined('_source')) die("Error");
$a = (isset($_REQUEST['a'])) ? addslashes($_REQUEST['a']) : "";
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
    global $d, $items, $paging, $loai, $soluong;
    //$loai = $d->array_category(0,'',$_GET['loaitin'],2);
    $loai = $d->array_category(0, '', '', 2);
    if ($_REQUEST['a'] == 'man') {
        $items = $d->o_fet("select * from #_content where lang ='" . LANG . "'  order by so_thu_tu asc, id desc");
    } else {
        if (isset($_REQUEST['id'])) {
            @$id = addslashes($_REQUEST['id']);
            $items = $d->o_fet("select * from #_content where id_code =  '" . $id . "' and lang = '" . LANG . "'");
            //$loai = $d->array_category(0,'',$items[0]['id_loai'],2);
            $loai = $d->array_category(0, '', $items[0]['id_loai'], 2);
        }
    }
}

function luudulieu($id_module)
{
    global $d;
    if ($d->checkPermission_edit($id_module) == 1) {
        $id = (isset($_REQUEST['id'])) ? addslashes($_REQUEST['id']) : "";
        $file_name = $d->fns_Rand_digit(0, 9, 12);
        if ($id != '') {
            $alias0      = bodautv($_POST['ten'][0]);
            //xóa hinh_anh cũ upload hình mới
            $hinh_anh = addslashes($_POST['hinh_anh']);

            $id_loai    =   addslashes($_POST['id_loai']);
            $so_thu_tu  =   $_POST['so_thu_tu'] != '' ? $_POST['so_thu_tu'] : 0;
            $hien_thi   =   isset($_POST['hien_thi']) ? 1 : 0;

            $data0['ten']   =   addslashes($_POST['ten'][0]);
            $d->reset();
            $d->setTable('cf_parent');
            $d->setWhere('id', $id);
            // var_dump($_POST['nofollow'][0]);
            // var_dump($_POST['nofollow'][1]);
            // die();
            if ($d->update($data0)) {
                foreach (get_json('lang') as $key => $value) {
                    $data['id_loai']    =   $id_loai;
                    $data['hinh_anh']   =   $hinh_anh;
                    $data['ten']            =   $d->clear(addslashes($_POST['ten'][$key]));
                    $data['noi_dung']       =   $d->clear(addslashes($_POST['noi_dung'][$key]));
                    $data['link']           =   $d->clear(addslashes($_POST['link'][$key]));
                    $data['chucvu']           =   $d->clear(addslashes($_POST['chucvu'][$key]));
                    $data['video']          =   addslashes($_POST['video']);
                    $data['ma_video']       =   addslashes($_POST['ma_video']);
                    $data['hien_thi']       =   $hien_thi;
                    $data['so_thu_tu']      =   $so_thu_tu;
                    $data['nofollow']       =   isset($_POST['nofollow'][$key]) ? 1 : 0;
                    $data['target']         =  isset($_POST['target'][$key]) ? 1 : 0;
                    $data['heading']       =   addslashes($_POST['heading']);

                    if ($_POST['id_row'][$key] == '') {
                        $data['id_code'] = $d->clear(addslashes($id));
                        $data['lang']  =   $value['code'];
                        $d->reset();
                        $d->setTable('#_content');
                        $d->insert($data);
                    } else {
                        $d->reset();
                        $d->setTable('#_content');
                        $d->setWhere('id', $_POST['id_row'][$key]);
                        $d->update($data);
                    }
                }
                
                $d->redirect("index.php?p=noi-dung&a=man&parent=" . $_GET['parent']);
            } else {
                $d->alert("Cập nhật dữ liệu bị lỗi!");
                $d->redirect("Cập nhật dữ liệu bị lỗi", "index.php?p=noi-dung&a=man&parent=" . $_GET['parent']);
            }
        } else {

            $alias0         =   bodautv($_POST['ten'][0]);
            $hinh_anh       =   addslashes($_POST['hinh_anh']);
            $id_loai        =   addslashes($_POST['id_loai']);
            $so_thu_tu      =   $_POST['so_thu_tu'] != '' ? $_POST['so_thu_tu'] : 0;
            $hien_thi       =   isset($_POST['hien_thi']) ? 1 : 0;

            $data0['ten']   =   addslashes($_POST['ten'][0]);
            $d->reset();
            $d->setTable('cf_parent');
            if ($id_code = $d->insert($data0)) {
                foreach (get_json('lang') as $key => $value) {
                    $data['id_loai']    =   $id_loai;
                    $data['hinh_anh']   =   $hinh_anh;
                    $data['ten']        =   $d->clear(addslashes($_POST['ten'][$key]));
                    $data['noi_dung']   =   $d->clear(addslashes($_POST['noi_dung'][$key]));
                    $data['link']       =   $d->clear(addslashes($_POST['link'][$key]));
                    $data['chucvu']       =   $d->clear(addslashes($_POST['chucvu'][$key]));
                    $data['video']          =   addslashes($_POST['video']);
                    $data['ma_video']   =   addslashes($_POST['ma_video']);
                    $data['hien_thi']   =   $hien_thi;
                    $data['id_code']    =   $id_code;
                    $data['lang']       =   $value['code'];
                    $data['so_thu_tu']  =   $so_thu_tu;
                    $data['nofollow']       =   isset($_POST['nofollow'][$key]) ? 1 : 0;
                    $data['target']         =   isset($_POST['target'][$key]) ? 1 : 0;
                    $data['heading']       =   addslashes($_POST['heading']);
                    $d->reset();
                    $d->setTable('#_content');
                    $d->insert($data);
                }
                $d->redirect("index.php?p=noi-dung&a=man&parent=" . $_GET['parent']);
            } else {
                $d->alert("Thêm dữ liệu bị lỗi!");
                $d->redirect("Thêm dữ liệu bị lỗi", "index.php?p=noi-dung&a=man&parent=" . $id_loai);
            }
        }
    } else {
        $d->redirect("index.php?p=noi-dung&a=man&parent=" . $id_loai);
    }
}

function xoadulieu($id_module)
{
    global $d;
    if ($d->checkPermission_dele($id_module) == 1) {
        if (isset($_GET['id'])) {
            $id =  addslashes($_GET['id']);
            $d->reset();
            $d->setTable('#_content');
            $d->setWhere('id_code', $id);
            if ($d->delete()) {
                $d->o_que("delete from cf_parent where id = $id ");
                $d->redirect("index.php?p=noi-dung&a=man&parent=" . @$_GET['parent']);
            } else {
                $d->alert("Xóa dữ liệu bị lỗi!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=noi-dung&a=man&parent=" . @$_GET['parent']);
            }
        } else {
            $d->alert("Không nhận được dữ liệu!");
            $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=noi-dung&a=man&parent=" . @$_GET['parent']);
        }
    } else {
        $d->redirect("index.php?p=noi-dung&a=man&parent=" . @$_GET['parent']);
    }
}

function xoadulieu_mang($id_module)
{
    global $d;
    if ($d->checkPermission_dele($id_module) == 1) {
        if (isset($_POST['chk_child'])) {
            $chuoi = "";
            foreach ($_POST['chk_child'] as $val) {
                $chuoi .= $val . ',';
            }
            $chuoi = trim($chuoi, ',');
            if ($d->o_que("delete from #_content where id_code in ($chuoi)")) {
                $d->o_que("delete from cf_parent where id in ($chuoi) ");
                $d->redirect("index.php?p=noi-dung&a=man&parent=" . @$_GET['parent']);
            } else {
                $d->alert("Không nhận được dữ liệu!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=noi-dung&a=man&parent=" . @$_GET['parent']);
            }
        } else $d->redirect("index.php?p=noi-dung&a=man&parent=" . @$_GET['parent']);
    } else {
        $d->redirect("index.php?p=noi-dung&a=man&parent=" . @$_GET['parent']);
    }
}

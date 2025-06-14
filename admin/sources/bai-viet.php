<?php
if (!defined('_source')) die("Error");
$a = (isset($_REQUEST['a'])) ? addslashes($_REQUEST['a']) : "";
$link_option = '';
if (isset($_GET['search']) && $_GET['search'] !== '') {
    $link_option .= '&search=' . addslashes($_GET['search']);
}
if (isset($_GET['key']) && $_GET['key'] !== '') {
    $link_option .= '&key=' . addslashes($_GET['key']);
}
if (isset($_GET['page']) && $_GET['page'] !== '') {
    $link_option .= '&page=' . addslashes($_GET['page']);
}
$row_setting = $d->simple_fetch("select setting from #_module where id = 2 ");
$setting = $row_setting['setting'];
$arrr_setting = json_decode($setting, true);
switch ($a) {
    case "man":
        showdulieu();
        $template = ($_REQUEST['p'] ?? '') . "/hienthi";
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
    $loai = $d->array_category(0, '', '', 2);
    $loai .= $d->array_category(0, '', '', 17);
    $loai .= $d->array_category(0, '', '', 18);
    if ($_REQUEST['a'] == 'man') {
        if (isset($_GET['search']) and $_GET['key'] != ''  and $_GET['search'] != '') {
            if ($_GET['search'] == 'loai') {
                $id_code = $_GET['key'];
                $list_id = $id_code . $d->getIdsub($id_code);
                $where_search = " and id_loai in ($list_id)";
                $loai = $d->array_category(0, '', $id_code, 2);
                $loai .= $d->array_category(0, '', $id_code, 17);
                $loai .= $d->array_category(0, '', $id_code, 18);
            } else {
                $col    =   addslashes($_GET['search']);
                $value  =   addslashes($_GET['key']);
                $where_search = " and $col like '%" . $value . "%' ";
            }
        }
        $limit = 10;
        $items = $d->o_fet("select * from #_tintuc where lang ='" . LANG . "' $where_search order by so_thu_tu asc, cap_nhat desc, id desc limit 0, $limit");
        $total_records = $d->num_rows("select * from #_tintuc where lang ='" . LANG . "' $where_search order by so_thu_tu asc, cap_nhat desc, id desc");
        $total_page = ceil($total_records / $limit);
    } else {
        if (isset($_REQUEST['id'])) {
            @$id = addslashes($_REQUEST['id']);
            $items = $d->o_fet("select * from #_tintuc where id_code =  '" . $id . "' and lang = '" . LANG . "'");
            //$loai = $d->array_category(0,'',$items[0]['id_loai'],2);
            $loai = $d->array_category(0, '', $items[0]['id_loai'], 2);
            $loai .= $d->array_category(0, '', $items[0]['id_loai'], 17);
            $loai .= $d->array_category(0, '', $items[0]['id_loai'], 18);
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
            $hinh_anh   =   addslashes($_POST['hinh_anh']);
            $id_loai    =   addslashes($_POST['id_loai']);
            $so_thu_tu  =   $_POST['so_thu_tu'] != '' ? $_POST['so_thu_tu'] : 0;
            $hien_thi   =   isset($_POST['hien_thi']) ? 1 : 0;

            $data0['ten']   =   addslashes($_POST['ten'][0]);
            $d->reset();
            $d->setTable('cf_parent');
            $d->setWhere('id', $id);
            if ($d->update($data0)) {
                //upload hình album
                $arr_img = isset($_POST['album']) ? $_POST['album'] : [];
                $d->o_que("delete from #_tintuc_hinhanh where id_tintuc = $id");
                // var_dump($arr_img);
                // die();
                if (is_array($arr_img) && count($arr_img) > 0) {
                    for ($i = 0; $i < count($arr_img); $i++) {
                        unset($data_img);
                        $data_img['id_tintuc'] = $id;
                        $data_img['hinh_anh'] = $arr_img[$i];
                        $data_img['stt'] = $_POST['album_stt'][$i] ?? 0;
                        // var_dump($data_img);
                        // die();
                        $d->reset();
                        $d->setTable('#_tintuc_hinhanh');
                        $d->insert($data_img);
                    }
                }
                // End upload hình album


                foreach (get_json('lang') as $key => $value) {
                    $data['id_loai']    =   $id_loai;
                    $data['hinh_anh']   =   $hinh_anh;
                    $data['ten']        =   $d->clear(addslashes($_POST['ten'][$key] ?? ''));
                    $data['slug']            = addslashes($_POST['slug'][$key] ?? '');
                    $data['alias']          = addslashes($_POST['alias'][$key] ?? '');
                    if ($d->checkLink($data['alias'], $_POST['id_row'][$key] ?? '') == 0) {
                        $data['alias'] .= "-" . rand(0, 9);
                    }
                    $data['mo_ta']      =   $d->clear(addslashes($_POST['mo_ta'][$key] ?? ''));
                    $data['noi_dung']   =   $d->clear(addslashes($_POST['noi_dung'][$key] ?? ''));
                    $data['nofollow']       =   isset($_POST['nofollow']) ? 1 : 0;
                    $data['noindex']        =   isset($_POST['noindex']) ? 1 : 0;
                    $data['title']      = $d->clear(addslashes($_POST['title'][$key] ?? ''));
                    $data['keyword']    = $d->clear(addslashes($_POST['keyword'][$key] ?? ''));
                    $data['des']        = addslashes($_POST['des'][$key] ?? '');
                    $data['seo_head']        = addslashes($_POST['seo_head'][$key] ?? '');
                    $data['seo_body']        = addslashes($_POST['seo_body'][$key] ?? '');
                    $data['tags_hienthi'] = addslashes($_POST['tags_hienthi'][$key] ?? '');
                    $data['sanpham_kem']    = isset($_POST['sanpham_kem']) && is_array($_POST['sanpham_kem']) ? ',' . implode(',', $_POST['sanpham_kem']) . ',' : '';
                    //xu ly tags
                    $tags = addslashes($_POST['tags_hienthi'][$key] ?? '');
                    $tg2 = explode(',', $tags);
                    $id_tag = "";
                    foreach ($tg2 as $value_tags) {
                        $kiemtra_tags = $d->o_fet("select ten, id from #_tags where ten = '" . trim($value_tags) . "' and lang='" . $value['code'] . "'");
                        if (count($kiemtra_tags ?? []) == 0  && trim($value_tags) <> '') {
                            $dataInsert = array(
                                'id' => '',
                                'hien_thi' => '1',
                                'ten'   => trim($value_tags),
                                'alias' => bodautv($value_tags),
                                'lang'  => $value['code'],
                            );
                            $d->setTable('#_tags');
                            if ($idTags = $d->insert($dataInsert)) {
                                $id_tag  .= $idTags . ",";
                            }
                        } else {
                            $id_tag  .= @$kiemtra_tags[0]['id'] . ",";
                        }
                    }
                    $data['tags']       =   trim($id_tag, ",");
                    //end tags
                    $data['cap_nhat']   =   time();
                    $data['hien_thi']   =   $hien_thi;
                    $data['so_thu_tu']  = $so_thu_tu;

                    if (($_POST['id_row'][$key] ?? '') == '') {
                        $data['id_code'] = $d->clear(addslashes($id));
                        $data['lang']  =   $value['code'];
                        $d->reset();
                        $d->setTable('#_tintuc');
                        $d->insert($data);
                    } else {
                        $d->reset();
                        $d->setTable('#_tintuc');
                        $d->setWhere('id', $_POST['id_row'][$key]);
                        $d->update($data);
                    }
                }
                // Cập nhật sitemap sau khi thêm/sửa bài viết
                update_sitemap();
                $d->redirect("index.php?p=bai-viet&a=man" . $link_option);
            } else {
                $d->alert("Cập nhật dữ liệu bị lỗi!");
                $d->redirect("Cập nhật dữ liệu bị lỗi", "index.php?p=bai-viet&a=man" . $link_option);
            }
        } else {
            $alias0      = addslashes($_POST['alias'][0]);
            if ($d->checkLink($alias0) == 0) {
                $alias0 .= "-" . rand(0, 9);
            }
            $hinh_anh       =   addslashes($_POST['hinh_anh']);
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
                        $data_img['id_tintuc'] = $id_code;
                        $data_img['hinh_anh'] = $arr_img[$i];
                        $data_img['stt'] = $_POST['album_stt'][$i] ?? 0;
                        $d->reset();
                        $d->setTable('#_tintuc_hinhanh');
                        $d->insert($data_img);
                    }
                }
                // End upload hình album
                foreach (get_json('lang') as $key => $value) {
                    $data['id_loai']    =   $id_loai;
                    $data['hinh_anh']   =   $hinh_anh;
                    $data['ten']        =   $d->clear(addslashes($_POST['ten'][$key] ?? ''));
                    $data['slug']            = addslashes($_POST['slug'][$key] ?? '');
                    $data['alias']          = addslashes($_POST['alias'][$key] ?? '');
                    if ($d->checkLink($data['alias']) == 0) {
                        $data['alias'] .= "-" . rand(0, 9);
                    }
                    $data['mo_ta']      =   $d->clear(addslashes($_POST['mo_ta'][$key] ?? ''));
                    $data['noi_dung']   =   $d->clear(addslashes($_POST['noi_dung'][$key] ?? ''));

                    $data['title']      = $d->clear(addslashes($_POST['title'][$key] ?? ''));
                    $data['keyword']    = $d->clear(addslashes($_POST['keyword'][$key] ?? ''));
                    $data['des']        = addslashes($_POST['des'][$key] ?? '');
                    $data['seo_head']        = addslashes($_POST['seo_head'][$key] ?? '');
                    $data['seo_body']        = addslashes($_POST['seo_body'][$key] ?? '');
                    $data['tags_hienthi'] = addslashes($_POST['tags_hienthi'][$key] ?? '');
                    //xu ly tags
                    $tags = addslashes($_POST['tags_hienthi'][$key] ?? '');
                    $tg2 = explode(',', $tags);
                    $id_tag = "";
                    foreach ($tg2 as $value_tags) {
                        $kiemtra_tags = $d->o_fet("select ten, id from #_tags where ten = '" . trim($value_tags) . "' and lang='" . $value['code'] . "'");
                        if (count($kiemtra_tags ?? []) == 0  && trim($value_tags) <> '') {
                            $dataInsert = array(
                                'id' => '',
                                'hien_thi' => '1',
                                'ten'   => trim($value_tags),
                                'alias' => bodautv($value_tags),
                                'lang'  => $value['code'],
                            );
                            $d->setTable('#_tags');
                            if ($idTags = $d->insert($dataInsert)) {
                                $id_tag  .= $idTags . ",";
                            }
                        } else {
                            $id_tag  .= @$kiemtra_tags[0]['id'] . ",";
                        }
                    }
                    $data['tags']       =   trim($id_tag, ",");
                    //end tags
                    $data['ngay_dang']  =   time();
                    $data['cap_nhat']   =   time();
                    $data['hien_thi']   =   $hien_thi;
                    $data['nofollow']       =   isset($_POST['nofollow']) ? 1 : 0;
                    $data['noindex']        =   isset($_POST['noindex']) ? 1 : 0;
                    $data['id_code']    =   $id_code;
                    $data['id_user']    =   $_SESSION['id_user'];
                    $data['lang']       =   $value['code'];
                    $data['so_thu_tu']  = $so_thu_tu;
                    $data['sanpham_kem']    = isset($_POST['sanpham_kem']) && is_array($_POST['sanpham_kem']) ? ',' . implode(',', $_POST['sanpham_kem']) . ',' : '';
                    $d->reset();
                    $d->setTable('#_tintuc');
                    $d->insert($data);
                }
                // Cập nhật sitemap sau khi thêm/sửa bài viết
                update_sitemap();
                $d->redirect("index.php?p=bai-viet&a=man" . $link_option);
            } else {
                $d->alert("Thêm dữ liệu bị lỗi!");
                $d->redirect("Thêm dữ liệu bị lỗi", "index.php?p=bai-viet&a=man" . $link_option);
            }
        }
    } else {
        $d->redirect("index.php?p=bai-viet&a=man" . $link_option);
    }
}

function xoadulieu($id_module)
{
    global $d;
    global $link_option;
    if ($d->checkPermission_dele($id_module) == 1) {
        if (isset($_GET['id'])) {
            $id =  addslashes($_GET['id']);
            $hinhanh = $d->o_fet("select * from #_tintuc where id_code = '" . $id . "'");
            if (!empty($hinhanh[0]['hinh_anh'])) {
                @unlink('../uploads/images/' . $hinhanh[0]['hinh_anh']);
                @unlink('../uploads/images/thumb/' . $hinhanh[0]['hinh_anh']);
            }
            $d->reset();
            $d->setTable('#_tintuc');
            $d->setWhere('id_code', $id);
            if ($d->delete()) {
                $d->o_que("delete from cf_parent where id = $id ");
                // Cập nhật sitemap sau khi xóa bài viết
                update_sitemap();
                $d->redirect("index.php?p=bai-viet&a=man" . $link_option);
            } else {
                $d->alert("Xóa dữ liệu bị lỗi!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=bai-viet&a=man" . $link_option);
            }
        } else {
            $d->alert("Không nhận được dữ liệu!");
            $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=bai-viet&a=man" . $link_option);
        }
    } else {
        $d->redirect("index.php?p=bai-viet&a=man" . $link_option);
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
            $hinhanh = $d->o_fet("select * from #_tintuc where id_code in ($chuoi) and lang ='" . LANG . "'");
            if ($d->o_que("delete from #_tintuc where id_code in ($chuoi)")) {
                $d->o_que("delete from cf_parent where id in ($chuoi) ");
                //xoa hình ảnh
                foreach ($hinhanh as $ha) {
                    @unlink('../uploads/images/' . $ha['hinh_anh']);
                    @unlink('../uploads/images/thumb/' . $ha['hinh_anh']);
                }
                // Cập nhật sitemap sau khi xóa nhiều bài viết
                update_sitemap();
                $d->redirect("index.php?p=bai-viet&a=man" . $link_option);
            } else {
                $d->alert("Không nhận được dữ liệu!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=bai-viet&a=man" . $link_option);
            }
        } else $d->redirect("index.php?p=bai-viet&a=man" . $link_option);
    } else {
        $d->redirect("index.php?p=bai-viet&a=man" . $link_option);
    }
}

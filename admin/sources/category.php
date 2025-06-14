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
    case "delete_image":
        xoadulieu_image($id_module);
        break;
    case "delete_all":
        xoadulieu_mang($id_module);
        break;
    default:
        $template = "index";
}

function showdulieu()
{
    global $d, $items, $paging, $loai, $limit, $loaibv, $totalPages, $module;
    $module = $d->o_fet("select * from #_module where hide = 1 order by stt asc,id desc");
    if ($_REQUEST['a'] == 'man') {
        $loaibv = $d->array_category(0, '', '', 0);
        if (isset($_GET['search']) and $_GET['key'] != '') {
            $col    =   addslashes($_GET['search']);
            $value  =   addslashes($_GET['key']);
            $items = $d->o_fet("select * from #_category where $col like '%" . $value . "%' and lang ='" . LANG . "' order by so_thu_tu asc, id desc");
        } else {
            $items = $d->o_fet("select * from #_category where id_loai = 0 and lang ='" . LANG . "' order by so_thu_tu asc, id desc");
        }
    } else {
        if (isset($_REQUEST['id'])) {
            @$id = addslashes($_REQUEST['id']);
            $items = $d->o_fet("select * from cf_code where id =  '" . $id . "'");
        }
        $loaibv = $d->array_category(0, '', $items[0]['id_loai'], 0, $items[0]['id']);
        //$soluong = $loai = $d->o_fet("select * from #_category");
    }
}

function luudulieu($id_module)
{
    global $d;
    if ($d->checkPermission_edit($id_module) == 1) {
        $id = (isset($_REQUEST['id'])) ? addslashes($_REQUEST['id']) : "";
        if ($id != '') {
            //tạo tên hinh đại diện
            $alias0      = addslashes($_POST['alias'][0]);
            if ($d->checkLink($alias0, $id) == 0) {
                $alias0 .= "-" . rand(0, 9);
            }
            //xóa icon cũ upload hình mới
            $icon = addslashes($_POST['icon']);
            //xóa hinh_anh cũ upload hình mới
            $hinh_anh = addslashes($_POST['hinh_anh']);
            //xóa banner cũ upload hình mới
            $banner = addslashes($_POST['banner']);

            $id_loai    =   addslashes($_POST['id_loai']);
            $module     =   addslashes($_POST['module']);
            $so_thu_tu  =   $_POST['so_thu_tu'] != '' ? $_POST['so_thu_tu'] : 0;
            $hien_thi   =   isset($_POST['hien_thi']) ? 1 : 0;
            //cập nhật dữ liệu cho db_code
            $data0['ten']       =   addslashes($_POST['ten'][0]);
            if ($hinh_anh != '') {
                $data0['hinh_anh']  =   $hinh_anh;
            }
            if ($icon != '') {
                $data0['icon']  =   $icon;
            }
            $data0['id_loai']   =   $id_loai;
            $data0['module']    =   $module;
            $data0['so_thu_tu'] =   $so_thu_tu;
            $data0['hien_thi']  =   $hien_thi;
            $d->reset();
            $d->setTable('cf_code');
            $d->setWhere('id', $id);
            if ($d->update($data0)) {
                foreach (get_json('lang') as $key => $value) {

                    if ($id_loai == 0) {
                        $data['parent'] = 0;
                    } else {
                        $row_parent     =   $d->simple_fetch("select * from #_category where id_code=" . (int)$id_loai . "");
                        if ($row_parent['parent'] == 0) {
                            $data['parent'] = $row_parent['id_code'];
                        } else {
                            $data['parent'] = $row_parent['parent'];
                        }
                    }
                    $data['ten']            = addslashes($_POST['ten'][$key]);
                    $data['slug']            = addslashes($_POST['slug'][$key]);
                    $data['url']          = addslashes($_POST['url'][$key]);
                    $data['alias']          = addslashes($_POST['alias'][$key]);
                    if ($d->checkLink($data['alias'], $_POST['id_row'][$key]) == 0) {
                        $data['alias'] .= "-" . rand(0, 9);
                    }
                    $data['id_loai']        =    $id_loai;
                    $data['hinh_anh']       =   $hinh_anh;
                    $data['icon']       =   $icon;
                    if ($banner != '') {
                        $data['banner']     =   $banner;
                    }
                    $data['mo_ta']          =   addslashes($_POST['mo_ta'][$key]);
                    $data['noi_dung']       =   addslashes($_POST['noi_dung'][$key]);
                    $data['so_thu_tu']      =   $so_thu_tu;
                    $data['hien_thi']       =   $hien_thi;
                    $data['home']       =   isset($_POST['home']) ? 1 : 0;
                    $data['nofollow']       =   isset($_POST['nofollow']) ? 1 : 0;
                    $data['noindex']        =   isset($_POST['noindex']) ? 1 : 0;
                    $data['module']         =   $module;
                    $data['title']          =   addslashes($_POST['title'][$key]);
                    $data['keyword']        =   addslashes($_POST['keyword'][$key]);
                    $data['des']            =   addslashes($_POST['des'][$key]);
                    $data['seo_head']        = addslashes($_POST['seo_head'][$key]);
                    $data['seo_body']        = addslashes($_POST['seo_body'][$key]);
                    $data['cap_nhat']       =   time();
                    if (isset($_POST['qua_tang']) && is_array($_POST['qua_tang'] ?? []) > 0) {
                        $data['qua_tang']       = ',' . implode(',', $_POST['qua_tang']) . ',';
                    }

                    if ($_POST['id_row'][$key] == '') {
                        $data['id_code'] = $d->clear(addslashes($id));
                        $data['lang']  =   $value['code'];
                        $d->reset();
                        $d->setTable('#_category');
                        $d->insert($data);
                    } else {
                        $d->reset();
                        $d->setTable('#_category');
                        $d->setWhere('id', $_POST['id_row'][$key]);
                        $d->update($data);
                    }
                }
                // Cập nhật sitemap sau khi thêm/sửa danh mục
                update_sitemap();
                $d->redirect("index.php?p=category&a=man&page=" . @$_REQUEST['page'] . "");
            }
        } else {
            $alias0      = addslashes($_POST['alias'][0]);
            if ($d->checkLink($alias0) == 0) {
                $alias0 .= "-" . rand(0, 9);
            }
            $hinh_anh   = addslashes($_POST['hinh_anh']);
            $icon   = addslashes($_POST['icon']);
            $banner     = addslashes($_POST['banner']);
            $id_loai    =   addslashes($_POST['id_loai']);
            $module     =   addslashes($_POST['module']);
            $so_thu_tu  =   $_POST['so_thu_tu'] != '' ? $_POST['so_thu_tu'] : 0;
            $hien_thi   =   isset($_POST['hien_thi']) ? 1 : 0;
            //Thêm dữ liệu vào db_code
            $data0['ten']       =   addslashes($_POST['ten'][0]);
            //$data0['hinh_anh']  =   $hinh_anh;
            $data0['id_loai']   =   $id_loai;
            $data0['module']    =   $module;
            $data0['so_thu_tu'] =   $so_thu_tu;
            $data0['hien_thi']  =   $hien_thi;
            $d->reset();
            $d->setTable('cf_code');
            if ($id_code = $d->insert($data0)) {

                foreach (get_json('lang') as $key => $value) {
                    //lấy danh mục cha cao nhất
                    if ($id_loai == 0) {
                        $data['parent'] = 0;
                    } else {
                        $row_parent     =   $d->simple_fetch("select * from #_category where id_code=" . (int)$id_loai . "");
                        if ($row_parent['parent'] == 0) {
                            $data['parent'] = $row_parent['id_code'];
                        } else {
                            $data['parent'] = $row_parent['parent'];
                        }
                    }

                    $data['ten']            = addslashes($_POST['ten'][$key]);
                    $data['slug']            = addslashes($_POST['slug'][$key]);
                    $data['url']          = addslashes($_POST['url'][$key]);
                    $data['alias']          = addslashes($_POST['alias'][$key]);
                    if ($d->checkLink($data['alias']) == 0) {
                        $data['alias'] .= "-" . rand(0, 9);
                    }
                    $data['id_loai']        =    $id_loai;
                    $data['hinh_anh']       =   $hinh_anh;
                    $data['icon']       =   $icon;
                    $data['banner']         =   $banner;
                    $data['mo_ta']          =   addslashes($_POST['mo_ta'][$key]);
                    $data['noi_dung']       =   addslashes($_POST['noi_dung'][$key]);
                    $data['so_thu_tu']      =   $so_thu_tu;
                    $data['hien_thi']       =   $hien_thi;
                    $data['home']       =   isset($_POST['home']) ? 1 : 0;
                    $data['nofollow']       =   isset($_POST['nofollow']) ? 1 : 0;
                    $data['noindex']        =   isset($_POST['noindex']) ? 1 : 0;
                    $data['module']         =   $module;
                    $data['title']          =   addslashes($_POST['title'][$key]);
                    $data['keyword']        =   addslashes($_POST['keyword'][$key]);
                    $data['des']            =   addslashes($_POST['des'][$key]);
                    $data['seo_head']        = addslashes($_POST['seo_head'][$key]);
                    $data['seo_body']        = addslashes($_POST['seo_body'][$key]);
                    if (isset($_POST['qua_tang']) && is_array($_POST['qua_tang'] ?? []) > 0) {
                        $data['qua_tang']       = ',' . implode(',', $_POST['qua_tang']) . ',';
                    }
                    $data['cap_nhat']       =   time();
                    $data['id_code']        =   $id_code;
                    $data['lang']           =   $value['code'];

                    $d->reset();
                    $d->setTable('#_category');
                    $d->insert($data);
                }
                // Cập nhật sitemap sau khi thêm/sửa danh mục
                update_sitemap();
                $d->redirect("index.php?p=category&a=man");
            }
        }
    } else {
        $d->redirect("index.php?p=category&a=man");
    }
}

function xoadulieu_image($id_module)
{
    global $d;
    if ($d->checkPermission_edit($id_module) == 1) {
        if (isset($_GET['id'])) {
            $id = addslashes($_GET['id']);
            $type = isset($_GET['type']) ? addslashes($_GET['type']) : '';
            
            // Get the current record to find the image to delete
            $record = $d->simple_fetch("select * from #_category where id_code = '" . $id . "'");
            
            if ($record) {
                $image_field = '';
                $image_path = '';
                
                // Determine which image field to clear based on type
                switch ($type) {
                    case 'icon':
                        $image_field = 'icon';
                        $image_path = $record['icon'];
                        break;
                    case 'banner':
                        $image_field = 'banner';
                        $image_path = $record['banner'];
                        break;
                    default:
                        $image_field = 'hinh_anh';
                        $image_path = $record['hinh_anh'];
                        break;
                }
                
                // Delete the physical image file
                if ($image_path != '') {
                    @unlink('../uploads/images/' . $image_path);
                    @unlink('../uploads/images/thumb/' . $image_path);
                }
                
                // Clear the image field in database
                $update_data = array($image_field => '');
                $d->reset();
                $d->setTable('#_category');
                $d->setWhere('id_code', $id);
                $d->update($update_data);
                
                // Also update cf_code table if needed
                $d->reset();
                $d->setTable('cf_code');
                $d->setWhere('id', $id);
                $d->update($update_data);
            }
            
            $d->redirect("index.php?p=category&a=edit&id=" . $id);
        } else {
            $d->redirect("index.php?p=category&a=man");
        }
    } else {
        $d->redirect("index.php?p=category&a=man");
    }
}

function xoadulieu($id_module)
{
    global $d;
    if ($d->checkPermission_dele($id_module) == 1) {
        if (isset($_GET['id'])) {
            $id =  addslashes($_GET['id']);
            $hinhanh = $d->simple_fetch("select * from #_category where id_code = '" . $id . "'");

            if ($hinhanh['icon'] != '') {
                @unlink('../uploads/images/' . $hinhanh['icon']);
            }
            if ($hinhanh['hinh_anh'] != '') {
                @unlink('../uploads/images/' . $hinhanh['hinh_anh']);
            }
            if ($hinhanh['banner'] != '') {
                @unlink('../uploads/images/' . $hinhanh['banner']);
            }
            $d->reset();
            $d->setTable('#_category');
            $d->setWhere('id_code', $id);
            if ($d->delete()) {
                $d->o_que("delete from cf_code where id = " . $id . "");
                //xóa danh mục con
                $list_sub = $d->o_fet("select id_code from #_category where id_loai = " . $id);
                if (is_array($list_sub) && count($list_sub ?? []) > 0) {
                    $list_sub = implode(',', array_column($list_sub, 'id_code'));
                    $d->o_que("delete from #_category where id_code in ($list_sub)");
                }
                // Cập nhật sitemap sau khi xóa danh mục
                update_sitemap();
                $d->redirect("index.php?p=category&a=man&page=" . @$_REQUEST['page'] . "");
            } else {
                $d->alert("Xóa dữ liệu bị lỗi!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=category&a=man&page=" . @$_REQUEST['page'] . "");
            }
        } else $d->alert("Không nhận được dữ liệu!");
    } else {
        $d->redirect("index.php?p=category&a=man&page=" . @$_REQUEST['page'] . "");
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
            //lay danh sách idsp theo chuoi
            $hinhanh = $d->o_fet("select * from #_category where id_code in ($chuoi)");
            if ($d->o_que("delete from #_category where id_code in ($chuoi)")) {
                $d->o_que("delete from cf_code where id in ($chuoi)");
                //xoa hình ảnh
                foreach ($hinhanh as $ha) {
                    //xóa danh mục con
                    $list_sub = trim($d->getIdsub($ha['id_code']), ',');
                    if ($list_sub != '') {
                        $d->o_que("delete from cf_code where id in ($list_sub)");
                        $d->o_que("delete from #_category where id_code in ($list_sub)");
                    }
                    if ($ha['icon'] != '') {
                        @unlink('../uploads/images/' . $ha['icon']);
                    }
                    if ($ha['hinh_anh'] != '') {
                        @unlink('../uploads/images/' . $ha['hinh_anh']);
                    }
                    if ($ha['banner'] != '') {
                        @unlink('../uploads/images/' . $ha['banner']);
                    }
                }
                // Cập nhật sitemap sau khi xóa danh mục
                update_sitemap();
                $d->redirect("index.php?p=category&a=man&page=" . @$_REQUEST['page'] . "");
            } else $d->alert("Xóa dữ liệu bị lỗi!");
        } else $d->redirect("index.php?p=category&a=man&page=" . @$_REQUEST['page'] . "");
    } else {
        $d->redirect("index.php?p=category&a=man&page=" . @$_REQUEST['page'] . "");
    }
}

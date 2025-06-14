<?php
define('_lib', '../lib/');
include _lib . "config.php";
include_once _lib . "class.php";
$d = new func_index($config);
$do = $_REQUEST['do'];

if ($do == 'checkbox') {
    $trangthai = addslashes($_POST['trangthai']);
    $bang = addslashes($_POST['bang']);
    $cot = addslashes($_POST['cot']);
    $id = addslashes($_POST['id']);
    if ($bang == '#_module_admin' || $bang == '#_thanhvien' || $bang == '#_flash_sale' || $bang == '#_binhluan') {
        if ($d->o_que("update " . $bang . " set " . $cot . " = " . $trangthai . " where id = " . $id)) {
            echo json_encode([
                'text' => 'Cập nhật thành công',
                'status' => 'success'
            ]);
        } else {
            echo json_encode([
                'text' => 'Đã sảy ra lỗi!',
                'status' => 'error'
            ]);
        }
    } else {
        if ($d->o_que("update " . $bang . " set " . $cot . " = " . $trangthai . " where id_code = " . $id)) {
            echo json_encode([
                'text' => 'Cập nhật thành công',
                'status' => 'success'
            ]);
        } else {
            echo json_encode([
                'text' => 'Đã sảy ra lỗi!',
                'status' => 'error'
            ]);
        }
    }
} elseif ($do == 'xoaimg') {
    $bang = addslashes($_POST['bang']);
    $cot = addslashes($_POST['cot']);
    $id = addslashes($_POST['id']);
    $folder = addslashes($_POST['folder']);
    //echo "select ".$cot." from #".$bang." where id_code = '".$id."'";
    $hinh_anh = $d->simple_fetch("select " . $cot . " from #" . $bang . " where id_code = '" . $id . "'");
    if ($folder == '') {
        // @unlink('../../img_data/images/' . $hinh_anh[$cot]);
        // @unlink('../../img_data/images/largethumb/' . $hinh_anh[$cot]);
        // @unlink('../../img_data/images/smallthumb/' . $hinh_anh[$cot]);
        // @unlink('../../img_data/images/thumb/' . $hinh_anh[$cot]);
        if ($d->o_que("update #" . $bang . " set " . $cot . " = '' where id_code = " . $id)) {
            echo '1';
        } else {
            echo '0';
        }
    } else {
        @unlink('../../uploads/images/' . $folder . '/' . $hinh_anh[$cot]);
        echo '1';
    }
}

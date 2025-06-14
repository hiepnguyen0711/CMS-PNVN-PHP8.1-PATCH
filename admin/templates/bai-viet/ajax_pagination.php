<?php
if (!isset($_SESSION)) {
    session_start();
}
define('_lib', '../../lib/');
@include _lib . "config.php";
@include_once _lib . "class.php";
@include_once _lib . "function.php";
$d = new func_index($config);
$id_module = 2; // lấy từ bảng db_module
$current_page =  $_POST['page'];
$where_search = addslashes($_POST['where']);
$total_page = (int)$_POST['totalPages'];
$limit = (int)$_POST['limit'];
if ($current_page > $total_page) {
    $current_page = $total_page;
} else if ($current_page < 1) {
    $current_page = 1;
}
$start = ($current_page - 1) * $limit;

//Thông số tìm kiếm 
$link_search = addslashes($_POST['search']);
//echo "select * from #_tintuc where lang ='".LANG."' $where_search order by so_thu_tu asc, cap_nhat desc, id desc limit $start, $limit";
$items = $d->o_fet("select * from #_tintuc where lang ='" . LANG . "' $where_search order by so_thu_tu asc, cap_nhat desc, id desc limit $start, $limit");
foreach ($items as $key => $value) { ?>
    <tr>
        <td class="text-center">
            <?php if ($d->checkPermission_dele($id_module) == 1) { ?>
                <input class="chk_box" type="checkbox" name="chk_child[]" value="<?= $value['id_code'] ?>">
            <?php } ?>
        </td>
        <td class="text-center">
            <?php if ($d->checkPermission_edit($id_module) == 1) { ?>
                <input type="number" value="<?= $value['so_thu_tu'] ?>" class="a_stt" data-table="#_tintuc" data-col="so_thu_tu" data-id="<?= $value['id_code'] ?>" />
            <?php } else { ?>
                <span class="label label-primary"><?= $value['so_thu_tu'] ?></span>
            <?php } ?>
        </td>
        <td>
            <?php
            $query = $d->simple_fetch("select * from #_category where id_code={$value['id_loai']} and lang = '" . LANG . "'");
            echo @$query['ten']
            ?>
        </td>
        <td style="text-align:left">
            <a href="index.php?p=bai-viet&a=edit&id=<?= $value['id_code'] ?><?= $link_search ?>&page=<?= $current_page ?>"><?= $value['ten'] ?></a>
        </td>
        <td class="text-center">
            <?= ($value['hinh_anh'] <> '') ? "<img src='" . URLPATH . "img_data/images/" . $value['hinh_anh'] . "' style='height: 50px;' >" : ""; ?>
        </td>
        <td class="text-right"><?= date('d-m-Y h:i:s', $value['ngay_dang']) ?></td>
        <td class="text-center">
            <input class="chk_box" <?php if ($d->checkPermission_edit($id_module) == 0) { ?>disabled<?php } ?> type="checkbox" onclick="on_check(this,'#_tintuc','noi_bat','<?= $value['id_code'] ?>')" <?php if ($value['noi_bat'] == 1) echo 'checked="checked"'; ?>>
        </td>
        <td class="text-center">
            <input class="chk_box" <?php if ($d->checkPermission_edit($id_module) == 0) { ?>disabled<?php } ?> type="checkbox" onclick="on_check(this,'#_tintuc','hien_thi','<?= $value['id_code'] ?>')" <?php if ($value['hien_thi'] == 1) echo 'checked="checked"'; ?>>
        </td>
        <td class="text-left">
            <?php if ($value['nofollow'] == 1) { ?>
                <span class="text-danger"><i style="font-size: 12px;" class="fa fa-circle-thin" aria-hidden="true"></i> No-follow</span>
            <?php } else { ?>
                <span class="text-success"><i style="font-size: 12px;" class="fa fa-circle" aria-hidden="true"></i> Do-follow</span>
            <?php } ?><br>
            <?php if ($value['noindex'] == 1) { ?>
                <span class="text-danger"><i style="font-size: 12px;" class="fa fa-circle-thin" aria-hidden="true"></i> Noindex</span>
            <?php } else { ?>
                <span class="text-success"><i style="font-size: 12px;" class="fa fa-circle" aria-hidden="true"></i> Index</span>
            <?php } ?>
        </td>
        <td class="text-center">
            <a style="padding: 3px 5px 5px;font-size: 11px;" href="index.php?p=bai-viet&a=edit&id=<?= $value['id_code'] ?><?= $link_search ?>&page=<?= $current_page ?>" class="btn btn-sm btn-warning" title="Sửa"><i class="glyphicon glyphicon-edit"></i></a>
            <?php if ($d->checkPermission_dele($id_module) == 1) { ?>
                <a style="padding: 3px 5px 5px;font-size: 11px;" href="index.php?p=bai-viet&a=delete&id=<?= $value['id_code'] ?><?= $link_search ?>&page=<?= $current_page ?>" onClick="if(!confirm('Xác nhận xóa?')) return false;" class="bnt btn-sm btn-danger" title="Xóa"><i class="glyphicon glyphicon-remove"></i></a>
            <?php } ?>
        </td>
    </tr>
<?php } ?>
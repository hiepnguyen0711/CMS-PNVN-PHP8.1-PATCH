<?php
if(!isset($_SESSION))
{
    session_start();
}
define('_lib','../../lib/');
@include _lib."config.php";
@include_once _lib."class.php";
@include_once _lib."function.php";
$d = new func_index($config);
$id_module = 1; // lấy từ bảng db_module
$current_page =  $_POST['page'];
$where_search = addslashes($_POST['where']);
$total_page = (int)$_POST['totalPages'];
$limit=(int)$_POST['limit'];
if ($current_page > $total_page){
    $current_page = $total_page;
}
else if ($current_page < 1){
    $current_page = 1;
}
$start = ($current_page - 1) * $limit;

//Thông số tìm kiếm 
$link_search = addslashes($_POST['search']);
$items = $d->o_fet("select * from #_files where lang ='".LANG."' $where_search order by so_thu_tu asc, id desc limit $start, $limit");
foreach ($items as $key => $value) {
    if($value['loai_file'] == 'pdf' || $value['loai_file'] == 'xlsx' || $value['loai_file'] == 'xls'|| $value['loai_file'] == 'doc' || $value['loai_file'] == 'docx'){
        $html = '<iframe class="iframe" src="http://docs.google.com/gview?url='.URLPATH.'uploads/files/'.$value['file'].'&embedded=true" style="height: 250px;width: 500px;" frameborder="0"></iframe>';
    }elseif($value['loai_file']=='mp4'){
        $html='<video class="iframe" style="height: 250px;width: 500px;" controls><source src="'.URLPATH.'uploads/files/'.$value['file'].'" type="video/mp4">Trình duyệt của bạn không hỗ trợ HTML5.</video>';
    }elseif($value['loai_file']=='mp3'){
        $html='<audio class="iframe" controls><source src="'.URLPATH.'uploads/files/'.$value['file'].'" type="audio/mp3">Trình duyệt của bạn không hỗ trợ HTML5</audio>';
    }
    ?>
    <tr>
        <td class="text-center">
            <?php if($d->checkPermission_dele($id_module)==1){ ?>
            <input class="chk_box" type="checkbox" name="chk_child[]" value="<?=$value['id_code']?>">
            <?php }?>
        </td>
        <td class="text-center">
            <?php if($d->checkPermission_edit($id_module)==1){ ?>
            <input type="number" value="<?=$value['so_thu_tu']?>" class="a_stt" data-table="#_tintuc" data-col="so_thu_tu" data-id="<?=$value['id_code']?>" />
            <?php }else{?>
            <span class="label label-primary"><?=$value['so_thu_tu']?></span>
            <?php }?>
        </td>
        <td>
            <?php 
            if($value['id_loai']>0){
                $query = $d->simple_fetch("select * from #_category where id_code={$value['id_loai']} and lang = '".LANG."'");	
                echo $query['ten'] ;
            }
            ?>
        </td>
        <td class="text-center"><img style=" height: 50px" src="img/<?=$value['loai_file']?>.png" /></td>
        <td style="text-align:left">
            <a href="index.php?p=upload-file&a=edit&id=<?=$value['id_code']?><?=$link_search?>"><?=$value['ten']?></a>
        </td>
        <td  class="text-left">
            <a target="_blank" href="<?=URLPATH?>uploads/files/<?=$value['file']?>"><?=URLPATH?> uploads/files/<?=$value['file']?> </a>
        </td>
        <td  class="text-center">
            <button type="button" class="btn btn-xs btn-info" onclick="get_html_file('<?=$value['id']?>')" >Xem mã HTML</button>
            <input type="hidden"  value="" />
            <span style="display: none;" class="html_<?=$value['id']?>" ><?=$html?></span>
        </td>
        <td  class="text-center">
            <input class="chk_box" <?php if($d->checkPermission_edit($id_module)==0){ ?>disabled<?php }?> type="checkbox" onclick="on_check(this,'#_tintuc','hien_thi','<?=$value['id_code']?>')" <?php if($value['hien_thi'] == 1) echo 'checked="checked"'; ?>>
        </td>
        <td class="text-center">
            <a style="padding: 3px 5px 5px;font-size: 11px;" href="index.php?p=upload-file&a=edit&id=<?=$value['id_code']?><?=$link_search?>" class="btn btn-sm btn-warning" title="Sửa"><i class="glyphicon glyphicon-edit"></i></a>
            <?php if($d->checkPermission_dele($id_module)==1){ ?>
            <a style="padding: 3px 5px 5px;font-size: 11px;" href="index.php?p=upload-file&a=delete&id=<?=$value['id_code']?><?=$link_search?>" onClick="if(!confirm('Xác nhận xóa?')) return false;" class="bnt btn-sm btn-danger" title="Xóa"><i class="glyphicon glyphicon-remove"></i></a>
            <?php }?>
        </td>
    </tr>
<?php }?>

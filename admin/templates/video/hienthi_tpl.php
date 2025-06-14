<?php if(isset($_GET['search'])){
    $link_search = '&search='.$_GET['search'].'&key='.$_GET['key'];
}else{
    $link_search ='';
} ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        VIDEO
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=urladmin?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="#">Quản trị danh mục</a></li>
        <li class="active">Video</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="btn-group">
                    <select id="action" name="action" onclick="form_submit(this)" class="form-control">
                        <option selected="">Tác vụ</option>
                        <option value="delete">Xóa</option>
                    </select>
                </div>
                <div class="btn-group">
                    <input type="text" value="<?=$_GET['search']!='loai'?$_GET['key']:''?>" id="key-search" class=" form-control" placeholder="Nhập nội dung cần tìm" />
                </div>
                <div class="btn-group">
                    <select id="search-input" class="form-control" data-p="<?=$_GET['p']?>">
                        <option value="">Tìm theo...</option>
                        <option <?=$_GET['search']=="ten"?'selected':''?> value="ten">Tên video</option>
                        <option <?=$_GET['search']=="ma_video"?'selected':''?> value="ma_video">Mã video</option>
                    </select>
                </div>
                <div class="btn-group">
                    <select id="search-cate" class="form-control" data-p="<?=$_GET['p']?>">
                        <option value="">Tìm theo danh mục</option>
                        <?=$loai?>
                    </select>
                </div>
                <div class="btn-group">
                    <a href="index.php?p=<?=$_GET['p']?>&a=<?=$_GET['a']?>" class="btn btn-default"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                </div>
                <?php if($d->checkPermission_edit($id_module)==1){ ?>
                <div class="pull-right">
                    <a href="index.php?p=<?=$_GET['p']?>&a=add" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-plus"></i> Thêm mới</a>
                </div>
                <?php }?>
                <div class="clearfix"></div>
            </div>  
            <form id="form" method="post" action="index.php?p=video&a=delete_all" role="form">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-primary table-hover">
                            <thead>
                                <tr>
                                    <th style="width:50px" class="text-center"><input class="chk_box checkall" type="checkbox" name="chk" value="0"  id="check_all"></th>
                                    <th style="width:70px"  class="text-center">STT</th>
                                    <th>Danh mục</th>
                                    <th>Tên Video</th>
                                    <th>Hình ảnh</th>
                                    <th>ID video</th>
                                    <th class="text-center" style="width:70px">Hiển thị</th>
                                    <th class="text-center" style="width:100px">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody  id="data-ajax">
                                <?php 
                                $count=count($items); 
                                for($i=0; $i<$count; $i++){ ?>
                                <tr>
                                    <td class="text-center">
                                        <?php if($d->checkPermission_dele($id_module)==1){ ?>
                                        <input class="chk_box" type="checkbox" name="chk_child[]" value="<?=$items[$i]['id_code']?>">
                                        <?php }?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($d->checkPermission_edit($id_module)==1){ ?>
                                        <input type="number" value="<?=$items[$i]['so_thu_tu']?>" class="a_stt" data-table="#_video" data-col="so_thu_tu" data-id="<?=$items[$i]['id_code']?>" />
                                        <?php }else{?>
                                        <span class="label label-primary"><?=$items[$i]['so_thu_tu']?></span>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php 
                                            if($items[$i]['id_loai']>0){
                                                $query = $d->simple_fetch("select * from #_category where id_code={$items[$i]['id_loai']} and lang = '".LANG."'");	
                                                echo $str.$query['ten'] ;
                                            }
                                            ?>
                                    </td>
                                    <td style="text-align:left">
                                        <a href="index.php?p=video&a=edit&id=<?=$items[$i]['id_code']?><?=$link_search?>"><?=$items[$i]['ten']?></a>
                                    </td>
                                    <td  class="text-center">
                                        <?=($items[$i]['hinh_anh'] <> '')?"<img src='".URLPATH."img_data/images/".$items[$i]['hinh_anh']."' style='height: 50px;' >":""; ?>
                                    </td>
                                    <td  class="text-center"><?=$items[$i]['ma_video'] ?></td>
                                    <td  class="text-center">
                                        <input class="chk_box" <?php if($d->checkPermission_edit($id_module)==0){ ?>disabled<?php }?> type="checkbox" onclick="on_check(this,'#_tintuc','hien_thi','<?=$items[$i]['id_code']?>')" <?php if($items[$i]['hien_thi'] == 1) echo 'checked="checked"'; ?>>
                                    </td>
                                    <td class="text-center">
                                        <a style="padding: 3px 5px 5px;font-size: 11px;" href="index.php?p=video&a=edit&id=<?=$items[$i]['id_code']?><?=$link_search?>" class="btn btn-sm btn-warning" title="Sửa"><i class="glyphicon glyphicon-edit"></i></a>
                                        <?php if($d->checkPermission_dele($id_module)==1){ ?>
                                        <a style="padding: 3px 5px 5px;font-size: 11px;" href="index.php?p=video&a=delete&id=<?=$items[$i]['id_code']?><?=$link_search?>" onClick="if(!confirm('Xác nhận xóa?')) return false;" class="bnt btn-sm btn-danger" title="Xóa"><i class="glyphicon glyphicon-remove"></i></a>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($total_page>1){ ?>
                    <div class="text-center">
                        <ul id="pagination-ajax" class="pagination-sm" style="margin: 0;"></ul>
                    </div>
                    <?php }?>
                </div>
            </form>
        </div>
        
    </section>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        var where = "<?=$where_search?>";
        $('#pagination-ajax').twbsPagination({
        totalPages: <?=$total_page?>,
        visiblePages: 5,
        <?php if(isset($_GET['page'])){ ?>
        startPage:<?=$_GET['page']?>,
        <?php } ?>
        prev: '<span aria-hidden="true">&laquo;</span>',
        next: '<span aria-hidden="true">&raquo;</span>',
        onPageClick: function (event, page) {
            $.ajax({
                url: "templates/<?=$_GET['p']?>/ajax_pagination.php",
                type:'POST',
                data: {page: page,totalPages:'<?=$total_page?>', where: where, limit:'<?=$limit?>',search:'<?=$link_search?>'},
                success: function(data){
                    //console.log(data);
                    $('#data-ajax').html(data);
                }
            })
        }
    });
    });
</script>
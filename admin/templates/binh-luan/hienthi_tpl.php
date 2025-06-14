<?php
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $d->o_que("delete from #_binhluan where id = $id ");
    $d->redirect("index.php?p=binh-luan&a=man");
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bình luận - đánh giá
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=urladmin?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="#">Quản trị khách hàng</a></li>
        <li class="active">Bình luận - đánh giá</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <table class="table table-bordered table-striped table-primary table-hover" id="dataTable1">
                    <thead>
                        <tr>
                            <th style="width: 70px">STT</th>
                            <th>Dịch vụ</th>
                            <th>Thông tin</th>
                            <th>Nội dung</th>
                            <th>Ngày gửi</th>
                             <th>Hiển thị</th>
                            <th style="width: 120px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $key => $value) {
                            $row_sp = $d->simple_fetch("select ten, alias, id_loai from #_sanpham where id_code=".$value['id_sanpham']." and lang = 'vi' ");
                            //$row_laoisp = $d->simple_fetch("select ten from #_category where id_code=".$row_sp['id_loai']." and lang = 'vi' ");
                        ?>
                        <tr>
                            <td class="text-center"><?=$key+1?></td>
                            <td>
                                <br><a href="<?=URLPATH?>vi/<?=$row_sp['alias']?>.html" target="_blank"><?=$row_sp['ten']?></a>
                            </td>
                            <td>
                                <?=$value['ho_ten']?><br>
                                Email: <b><?=$value['email']?></b> -  Điện thoại: <b><?=$value['dien_thoai']?></b>
                            </td>
                            <td>
                                <span style="color: #f39c12;">
                                    <?php for($i=0;$i<$value['danh_gia'];$i++){ ?>
                                    <i class="fa fa-star"></i>
                                    <?php } ?>
                                </span>
                                <br>
                                <?=  catchuoi($value['noi_dung'],150)?>
                            </td>
                            <td><?=$value['ngay_hoi']?></td>
                            <!--td class="text-center">
                                <?php if($value['trang_thai']==0){ ?>
                                <label class="label label-warning">Chưa xem</label>
                                <?php }else{?>
                                 <label class="label label-success">Đã xem</label>
                                <?php }?>
                            </td-->
                            <td class="text-center"><input class="chk_box" type="checkbox" onclick="on_check(this,'#_binhluan','trang_thai','<?=$value['id']?>')" <?php if($value['trang_thai'] == 1) echo 'checked="checked"'; ?>></td>
                            <td class="text-center">
                                <a data-toggle="modal" onclick="load_ajax(<?=$value['id']?>)" data-target="#myModal" class="btn btn-xs btn-info" href="#"  title="Sửa">Chi tiết</a>
                                <?php if($d->checkPermission_dele($id_module)==1){ ?>
                                <a href="index.php?p=<?=$_GET['p'] ?? ''?>&a=<?=$_GET['a'] ?? ''?>&delete=<?=$value['id']?>" onClick="if(!confirm('Xác nhận xóa?')) return false;" class="btn btn-xs btn-danger" title="Xóa">Xóa</a>
                                <?php }?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<link rel="stylesheet" href="templates/plugin/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- DataTables -->
<script src="public/plugin/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="public/plugin/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $('#dataTable1').DataTable({
        'autoWidth'   : false,
        'searching'   : true,
        'lengthChange': true,
        "iDisplayLength": 25
    });
</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" id="body-lienhe">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script>
    function load_ajax(id){
        $.ajax({
            url : "sources/ajax.php",
            type : "post",
            dataType:"text",
            data : {
                 do : 'get_binhluan',
                 id :   id
            },
            success : function (result){
                $('#body-lienhe').html(result);
            }
        });
    }
</script>
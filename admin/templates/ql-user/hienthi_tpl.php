<?php 
$row_per = $d -> o_fet("select * from #_permission");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Quản lý user
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=urladmin?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="#">Cấu hình website</a></li>
        <li class="active">Quản lý user</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border" style="padding-left: 15px;padding-right: 15px;">
                <div class="row m-5">
                    <div class="btn-group col-sm-2 p5">
                        <input id="column0_search" type="text" class="form-control" placeholder="id"/>
                    </div>
                    <div class="btn-group col-sm-2 p5">
                        <input id="column1_search" type="text" class="form-control" placeholder="Họ tên"/>
                    </div>
                    <div class="btn-group col-sm-2 p5">
                        <input id="column2_search" type="text" class="form-control" placeholder="Tên đăng nhập"/>
                    </div>
                    <div class="btn-group col-sm-3 p5">
                        <select class="form-control" id="column3_search">
                            <option value="">Loại tài khoản</option>
                            <?php foreach ($row_per as $key => $value) {?>
                            <option value="<?=$value['name']?>"><?=$value['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-2 p5 col-sm-offset-1 text-right">
                        <?php if($d->checkPermission_edit($id_module)==1){ ?>
                        <a href="index.php?p=ql-user&a=add" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Thêm mới</a>
                        <?php }?>
                    </div>
                </div>
                
                
            </div>
            <div class="box-body" style="padding-top: 0;">
                <form id="form" method="post" action="index.php?p=ql-user&a=delete_all" role="form">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-primary" id="dataTable">
                            <thead>
                                <tr>
                                    <th style="width:50px" class="text-center">ID</th>
                                    <th class="text-center">Họ tên</th>
                                    <th class="text-center">Tài khoản</th>
                                    <th class="text-center">Quyền hạn</th>
                                    <th class="text-center">Hiển thị</th>
                                    <th  style="width:150px" class="text-center">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count=count($items); for($i=0; $i<$count; $i++){ 
                                $row = $d -> simple_fetch("select * from #_permission where id =".$items[$i]['quyen_han']);    
                                ?>
                                <tr>
                                    <td class="text-center"><?=$items[$i]['id']?></td>
                                    <td><?=$items[$i]['ho_ten']?></td>
                                    <td><?=$items[$i]['tai_khoan']?></td>
                                    <td class="text-center">
                                        <span class="label label-info"><?=$row['name']?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php if($items[$i]['hien_thi'] == 1){ ?>
                                        <a href="index.php?p=ql-user&a=man&b=hien_thi&TT=0&id=<?=$items[$i]['id']?>&page=<?=@$_GET['page']?>" class="label label-success">Hoạt động</a>
                                        <?php }else{ ?>
                                        <a href="index.php?p=ql-user&a=man&b=hien_thi&TT=1&id=<?=$items[$i]['id']?>&page=<?=@$_GET['page']?>" class="label label-danger">Khóa</a>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="index.php?p=ql-user&a=edit&id=<?=$items[$i]['id']?>" class="label label-warning"><i class="fa fa-edit"></i> Chi tiết</a>
                                        <?php if($d->checkPermission_dele($id_module)==1){ ?>
                                        <a href="index.php?p=ql-user&a=delete&id=<?=$items[$i]['id']?>" onclick="if(!confirm('Xác nhận xóa?')) return false;" class="label label-danger"><i class="fa fa-edit"></i> Xóa</a>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination">
                        <?php echo @$paging['paging']?>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<!-- DataTables -->
<link rel="stylesheet" href="public/plugin/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- DataTables -->
<script src="public/plugin/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="public/plugin/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $(function () {
        var table = $('#dataTable').DataTable({
            'autoWidth'   : false,
            'lengthChange': false,
        });
        $('#column0_search').on( 'keyup', function () {
            table.columns(0).search( this.value ).draw();
        } );
        $('#column1_search').on( 'keyup', function () {
            table.columns(1).search( this.value ).draw();
        });
        $('#column2_search').on( 'keyup', function () {
            table.columns(2).search( this.value ).draw();
        });
        $('#column3_search').on( 'change', function () {
            table.columns(3).search( this.value ).draw();
        });
    })
function thaydoi_quyen(obj,id){
	var va = $(obj).val();
	if(id != 'admin'){
            $.ajax({
                url: "./sources/aj_quyen.php",
                type:'POST',
                data:"va="+va+"&id="+id,
                success: function(data){
                        if(data == 1) alert("Cập nhật quyền thành công");
                        else alert("Lỗi cập nhật");
                }
            })
	}else alert("Quyền bị giới hạn");
}
</script>
<style>
    .dataTables_filter{
        display: none;
    }
</style>
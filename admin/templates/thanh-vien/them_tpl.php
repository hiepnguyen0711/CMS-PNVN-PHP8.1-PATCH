<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thành viên <small>[<?php if(isset($_GET['id'])) echo "chi tiết "; else echo "Thêm mới" ?>]</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?=urladmin?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
          <li><a href="#">Quản lý khách hàng</a></li>
          <li class="active">Thành viên</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <form name="frm" method="post" class=" form-horizontal" action="index.php?p=<?=$_GET['p']?>&a=save&id=<?=@$_REQUEST['id']?><?=$link_option?>" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mã Thành viên:</label>
                            <div class="col-sm-9">
                                <input type="text" disabled class="form-control" name="ho_ten" value="<?=$items['ma_thanhvien']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Họ tên:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Nhập họ tên thành viên" name="ho_ten" value="<?=$items['ho_ten']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Nhập email" name="email" value="<?=$items['email']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Điện thoại:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Nhập số điện thoại" name="dien_thoai" value="<?=$items['dien_thoai']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Địa chỉ:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Nhập địa chỉ" name="dia_chi" value="<?=$items['dia_chi']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mật khẩu mới:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Nhập mật khẩu mới" name="mat_khau" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <button type="button" class="btn btn-default"><span class="fa fa-mail-reply "></span> Quay lại</button>
                                <?php if($d->checkPermission_edit($id_module)==1){ ?>
                                <button type="submit" name="capnhat" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-save"></span> Cập nhật</button>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
        <div class="box box-primary">
            
        </div>
    </section>
</div>
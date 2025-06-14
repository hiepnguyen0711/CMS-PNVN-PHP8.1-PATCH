<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Phương Thức Vận Chuyển <small>[<?php if(isset($_GET['id'])) echo "chi tiết "; else echo "Thêm mới" ?>]</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?=urladmin?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
          <li><a href="#">Quản lý bán hàng</a></li>
          <li class="active">Phương Thức Vận Chuyển</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <form name="frm" method="post" class=" form-horizontal" action="index.php?p=<?=$_GET['p']?>&a=save&id=<?=@$_REQUEST['id']?><?=$link_option?>" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tên:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="ten" value="<?=$items['ten']?>">
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Giá tiền:</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" placeholder="Nhập giá tiền" name="gia" value="<?=$items['gia']?>">
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <a href="<?= urladmin."index.php?p=phuong-thuc-van-chuyen&a=man" ?>" class="btn btn-default"><span class="fa fa-mail-reply "></span> Quay lại</a>
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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Flash Sale <small>[<?php if(isset($_GET['id'])) echo "chi tiết "; else echo "Thêm mới" ?>]</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?=urladmin?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
          <li><a href="#">Quản lý bán hàng</a></li>
          <li class="active">Flash Sale</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <form name="frm" method="post" class=" form-horizontal" action="index.php?p=<?=$_GET['p']?>&a=save&id=<?=@$_REQUEST['id']?><?=$link_option?>" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tên chương trình:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="ten" value="<?=$items['ten']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Thời gian áp dụng:</label>
                            <div class="col-sm-4">
                                <input type="datetime-local" class="form-control" value="<?=$items['tu_ngay']?>" name="tu_ngay" >
                            </div>
                            <label class="col-sm-1 control-label"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></label>
                            <div class="col-sm-4">
                                <input type="datetime-local" class="form-control" value="<?=$items['den_ngay']?>" name="den_ngay" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-9 col-sm-offset-3">
                                <input name="hien_thi" <?php if(isset($items['hien_thi'])) { if($items['hien_thi']==1) echo 'checked="checked"';} else echo'checked="checked"'; ?> type="checkbox"> Hiển thị
                            </label>
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

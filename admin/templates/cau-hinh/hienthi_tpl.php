<?php
$items = $d->o_fet("select * from #_cauhinh where id = 1 order by id desc");
include "sources/editor.php";
if(isset($_POST['capnhat'])){
    $data['chu_ky_mail']    =   addslashes($_POST['chu_ky_mail']);
    $data['timezones_id']   =   addslashes($_POST['timezones']);
    $data['timezones']      =   $d->getDataId('timezones',$data['timezones_id'],'name')['name'];
    $data['currency']       =   addslashes($_POST['currency']);
    $d->reset();
    $d->setTable('#_cauhinh');
    $d->setWhere('id',1);
    if($d->update($data)){
        $d->redirect("index.php?p=cau-hinh&a=man");
    }
}   
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
            Cấu hình hệ thống
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=urladmin?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="#">Dữ liệu</a></li>
        <li class="active">Cấu hình hệ thống</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <form method="POST" action="" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Múi giờ (mặc định)</label>
                        <div class="col-sm-6">
                             <select class="form-control select2" name="timezones">
                                <?php foreach ($d->getData('timezones','*') as $key => $value) {?>
                                 <option <?= $items[0]['timezones_id'] == $value['id']?'selected':'' ?> value="<?=$value['id']?>"><?=$value['name']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Đơn vị tiền tệ (mặc định)</label>
                        <div class="col-sm-6">
                             <select class="form-control select2" name="currency">
                                <?php foreach ($d->getData('country','*') as $key => $value) {?>
                                <option <?= $items[0]['currency'] == $value['currency_code']?'selected':'' ?> value="<?=$value['currency_code']?>">(<?=$value['currency_code']?>) <?=$value['currency_name']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Chữ ký email</label>
                        <div class="col-sm-10">
                             <textarea class="form-control" name="chu_ky_mail"  id="chu_ky_mail" rows="3"><?php echo $items[0]['chu_ky_mail']?></textarea>
                            <?php $ckeditor->replace('chu_ky_mail'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit" name="capnhat">Cập nhật</button>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </section>
</div>
<link rel="stylesheet" href="public/plugin/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- DataTables -->
<script src="public/plugin/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="public/plugin/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $('#dataTable1').DataTable({
        'autoWidth'   : false,
        'searching'   : true,
        'lengthChange': true,
        "pageLength": 25
    });
    $('#dataTable2').DataTable({
        'autoWidth'   : false,
        'searching'   : true,
        'lengthChange': true,
        "pageLength": 25
    });
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cộng tác viên <small>[<?php if(isset($_GET['id'])) echo "chi tiết "; else echo "Thêm mới" ?>]</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?=urladmin?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
          <li><a href="#">Quản lý khách hàng</a></li>
          <li class="active">Cộng tác viên</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            
                <div class="box-body">
                    <div class="col-sm-5">
                        <form name="frm" method="post" class=" form-horizontal" action="index.php?p=<?=$_GET['p']?>&a=save&id=<?=@$_REQUEST['id']?><?=$link_option?>" enctype="multipart/form-data">
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
                        </form>
                    </div>
                    <?php 
                    if(isset($_POST['them_sp'])){
                        $arr_sp = $_POST['sp'];
                        if(count($arr_sp)>0){
                            for($i=0;$i<count($arr_sp);$i++){
                                $id_sp = $arr_sp[$i];
                                if($id_sp!=''){
                                    $num_row = $d->num_rows("select * from #_sanpham_ctv where id_sp =".$id_sp." and id_thanhvien = ".(int)$_GET['id']." ");
                                    if($num_row==0){
                                        $row_sanpham = $d->simple_fetch("SELECT * FROM `#_sanpham` WHERE id_code = ".$id_sp.""); 
                                        $data['id_sp']          = $id_sp;
                                        $data['id_thanhvien']   = (int)$_GET['id'];
                                        $data['gia_goc']        = $row_sanpham['gia0'];
                                        $data['token']          = MD5($items['ma_thanhvien'].$id_sp.time());
                                        $d->reset();
                                        $d->setTable('#_sanpham_ctv');
                                        $d->insert($data);
                                    }
                                }
                            }
                            $d->redirect("index.php?p=".$_GET['p']."&a=".$_GET['a']."&id=".$_GET['id']); 
                        }
                    }
                    $sanpham = $d->o_fet("select * from #_sanpham where lang ='".LANG."' and ( loai_sp = 0 or loai_sp = 2)  order by ten asc "); 
                    $sanpham_ctv = $d->o_fet("select * from #_sanpham_ctv where id_thanhvien = ".(int)$_GET['id']." order by id asc "); 
                    ?>
                    <div class="col-sm-7">
                        <?php if($d->checkPermission_edit($id_module)==1){ ?>
                        <form method="POST" action="" class="row" >
                            <div class="form-group col-sm-10">
                                <select class="form-control select2" multiple="" name="sp[]">
                                    <?php foreach ($sanpham as $key => $value) {?>
                                    <option value="<?=$value['id_code']?>"><?=$value['ten']?></option>
                                     <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <button class="btn btn-primary btn-block" type="submit" name="them_sp">Thêm cho CTV</button>
                            </div>
                        </form>
                        <?php } ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="dataTable1">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Hình ảnh</th>
                                        <th>Giá gốc</th>
                                        <th>Giá bán</th>
                                        <th>Đã bán</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($sanpham_ctv as $key => $value) {
                                    $row = $d->simple_fetch("select * from #_sanpham where id_code = ".$value['id_sp']."  and lang ='".LANG."' ");    
                                    $row_tong_ban = $d->simple_fetch("SELECT SUM(so_luong) as soluong FROM `db_dathang_chitiet` WHERE id_sp=".$value['id_sp']." AND id_ctv = ".$_GET['id']." GROUP BY id_sp"); 
                                    ?>
                                    <tr>
                                        <td class="text-center"><?=$key+1?></td>
                                        <td><?=$row['ten']?></td>
                                        <td class="text-center"><img style="height: 50px;" src="../img_data/images/<?=$row['hinh_anh']?>"  /></td>
                                        <td style="width: 100px;">
                                            <input style="width: 100px;padding: 5px;" type="number" value="0" class="a_stt2 a_stt0" data-table="#_sanpham_ctv" data-col="gia_goc" data-id="<?=$value['id']?>" /><br>
                                            <span class="num_<?=$value['id']?>" style="display: block;padding-top: 5px;text-align: center;font-weight: 600;color: #dd4b39;">Giá: <?=  numberformat($value['gia_goc'])?><sup>đ</sup></span>
                                        </td>
                                        <td><?=  numberformat($value['gia'])?></td>
                                        <td class="text-center">
                                            <?=  numberformat($row_tong_ban['soluong'])?> Sản phẩm
                                        </td>
                                    </tr>                        
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
        <?php 
        $col = "db_dathang.ma_dh, db_dathang.ngay_dathang, db_dathang.trangthai_xuly, db_dathang.trangthai_thanhtoan, db_dathang.ngay_capnhat, SUM(db_dathang_chitiet.so_luong*db_dathang_chitiet.gia_goc) as tong_goc, SUM(db_dathang_chitiet.so_luong*db_dathang_chitiet.gia_ban) as tong_ban";
        $table = " db_dathang JOIN db_dathang_chitiet ON db_dathang.id = db_dathang_chitiet.id_dh";
        $where = "id_ctv =".(int)$_GET['id']." ";
        $donhang =  $d -> o_fet("select ".$col." from ".$table." where ".$where." GROUP BY id_dh ORDER BY db_dathang.id DESC ");
        ?>
        <div class="row">
            <div class="col-sm-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Đơn hàng của CTV</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered" id="datatables2">
                            <thead>
                                <tr>
                                    <th style="width: 30px;">STT</th>
                                    <th>Mã ĐH</th>
                                    <th>Đặt hàng</th>
                                    <th>Trạng thái</th>
                                    <th>Thanh toán</th>
                                    <th>Tổng tiền</th>
                                    <th>Lợi nhuận</th>
                                    <th>Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $tong = $tongcho = $tongloinhuan = $tonghuy =  0;
                                foreach ($donhang as $key => $value) {
                                    //$row_tong = $d -> simple_fetch("SELECT SUM(so_luong) as so_luong, SUM(so_luong*gia_ban) as tongtien FROM `db_dathang_chitiet` where id_dh =".$value['id']."  GROUP BY ma_dh "); 
                                if($value['trangthai_xuly'] < 3){
                                    $tongcho = $tongcho+($value['tong_ban'] - $value['tong_goc']);
                                }elseif($value['trangthai_xuly'] == 3){
                                    $tongloinhuan = $tongloinhuan+($value['tong_ban'] - $value['tong_goc']);
                                }else{
                                    $tonghuy = $tonghuy+($value['tong_ban'] - $value['tong_goc']);
                                }
                                $tong = $tong + ($value['tong_ban'] - $value['tong_goc']);
                                ?>
                                <tr>
                                    <td class="text-center"><?=$key+1?></td>
                                    <td><?=$value['ma_dh']?></td>
                                    <td><?=substr($value['ngay_dathang'],0,10)?></td>
                                    <td  style=" text-align: center">
                                        <?php if($value['trangthai_xuly']==0){ ?>
                                        <label style="font-size: 13px;padding: 5px 10px 7px;" class=" label label-default">Đang xủ lý</label> 
                                        <?php }elseif ($value['trangthai_xuly']==1) {?>
                                         <label style="font-size: 13px;padding: 5px 10px 7px;" class="label label-warning">Đang xủ lý</label> 
                                        <?php }elseif ($value['trangthai_xuly']==2) {?>
                                        <label style="font-size: 13px;padding: 5px 10px 7px;" class="label label-info">Đang giao</label> 
                                        <?php }elseif ($value['trangthai_xuly']==3) {?>
                                         <label style="font-size: 13px;padding: 5px 10px 7px;" class="label label-success">Đã giao</label> 
                                        <?php }elseif ($value['trangthai_xuly']==4) {?>
                                          <label style="font-size: 13px;padding: 5px 10px 7px;" class="label label-danger">Trả hàng</label> 
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if ($value['trangthai_xuly']==3) { ?>
                                        <?=substr($value['ngay_capnhat'],0,10)?>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        Giá gốc: <?=  numberformat($value['tong_goc'])?><sup>đ</sup><br>
                                        Giá bán: <b><?=  numberformat($value['tong_ban'])?><sup>đ</sup></b>
                                    </td>
                                    <td>
                                        <?=  numberformat($value['tong_ban'] - $value['tong_goc'])?><sup>đ</sup>
                                    </td>
                                    <td  style=" text-align: center"><a href="javascript:void(0)" style="font-size: 13px;padding: 5px 10px 7px;" data-fancybox data-src="#view_donhang2" onclick="view_donhang2('<?=$value['ma_dh']?>')" class="label label-primary">Chi tiết</a></td>
                                </tr>  
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-right">Tổng:</th>
                                    <th><?=  numberformat($tong)?><sup>đ</sup></th>
                                    <th class="text-right">Chờ xử lý:</th>
                                    <th><?=  numberformat($tongcho)?><sup>đ</sup></th>
                                    <th class="text-right">Hủy:</th>
                                    <th><?=  numberformat($tonghuy)?><sup>đ</sup></th>
                                    <th class="text-right">Chiết khấu: </th>
                                    <th><?=  numberformat($tongloinhuan)?><sup>đ</sup></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div style="display: none;width: 700px; max-width: 80%;line-height: 18px;" id="view_donhang2" >
    
                </div>

                <script>

                    function view_donhang2(ma_dh){
                        $.ajax({
                            url : "sources/ajax.php",
                            type : "post",
                            dataType:"text",
                            data : {
                                 do         : 'view_donhang_ctv',
                                 ma_dh : ma_dh,
                                 id_ctv: '<?=(int)$_GET['id']?>'
                            },
                            success : function (result){
                                $('#view_donhang2').html(result);

                            }
                        });
                    }
                </script>
            </div>
            <div class="col-sm-4">
                <?php 
                if(isset($_POST['capnhat_thanhtoan'])){
                    $data['id_ctv']             = (int)$_GET['id'];
                    $data['du_no_dau']          =   (int)$_POST['du_no_dau'];
                    $data['thanh_toan']         =   (int)$_POST['thanh_toan'];
                    $data['du_no_cuoi']         =   $data['du_no_dau'] - $data['thanh_toan'];
                    $data['ma_hoadon']          =   $d->clear(addslashes($_POST['ma_hoadon']));
                    $data['ngay_thanhtoan']     =   $d->clear(addslashes($_POST['ngay_thanhtoan']));
                    $data['ngay_tao']           =   date('Y-m-d', time());
                    $d->reset();
                    $d->setTable('#_thanhtoan_ctv');
                    if($d->insert($data)){
                        $d->redirect("index.php?p=".$_GET['p']."&a=".$_GET['a']."&id=".$_GET['id']);
                    }
                      
                }
                ?>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Lịch sử thanh toán</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <?php 
                        $row_thanhtoan = $d->simple_fetch("SELECT SUM(thanh_toan) as thanhtoan FROM `#_thanhtoan_ctv` WHERE id_ctv = ".(int)$_GET['id']." GROUP BY id_ctv ");
                        $dathanhtoan = $row_thanhtoan['thanhtoan'];
                        $tien_con = $tongloinhuan - $dathanhtoan;
                        ?>
                        <p>Đã thanh toán: <b><?= numberformat($dathanhtoan)?><sup>đ</sup></b></p>
                        <p>Chờ thanht toán: <b><?=  numberformat($tien_con )?><sup>đ</sup></b></p>
                        <hr>
                        <?php if($tien_con>0){ ?>
                        <form method="POST" action="" class=" form-horizontal">
                            <input type="hidden" name="sotien_con" value="<?=$tien_con?>" />
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Thanh toán:</label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="du_no_dau" value="<?=$tien_con?>" />
                                    <input type="number" max="<?=$tien_con?>" class="form-control" id="gia0" placeholder="Nhập số tiền thanh toán" name="thanh_toan" value="<?=$tien_con?>">
                                    <span class="text-gia0" style="color: red;display: block;margin-top: 5px;font-weight: 600;"><?php if(isset($_GET['id'])){ echo 'Số tiền: '.numberformat($tien_con).'<sup>đ</sup>';} ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Ngày thanh toán:</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" placeholder="Ngày thanht toán" name="ngay_thanhtoan" value="<?=$items['ngay_thanhtoan']!='0000-00-00'?date('Y-m-d', time()):$items['ngay_thanhtoan']?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Mã hóa đơn:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Nhập mã hóa đơn nếu có" name="ma_hoadon" value="<?=$items['ma_hoadon']?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Ghi chú</label>
                                <div class="col-sm-9">
                                    <textarea class=" form-control" rows="3" name="ghi_chu" placeholder="Nhập ghi chú thanh toán"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <?php if($d->checkPermission_edit($id_module)==1){ ?>
                                    <button onClick="if(!confirm('Xác nhận thanh toán?')) return false;" type="submit" name="capnhat_thanhtoan" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-save"></span> Cập nhật thanh toán</button>
                                    <?php }?>
                                </div>
                            </div>
                        </form>
                        <?php } ?>
                        <?php $thanhtoan = $d->o_fet("select * from #_thanhtoan_ctv where id_ctv = ".(int)$_GET['id']." order by id desc");  ?>
                        <table class="table table-striped table-bordered" id="dataTable2">
                            <thead>
                                <tr>
                                    <th class=" text-center">STT</th>
                                    <th class=" text-center">Ngày thanh toán</th>
                                    <th class=" text-center">Số tiền</th>
                                    <th class=" text-center">Mã hóa đơn</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($thanhtoan as $key => $value) {?>
                                <tr>
                                    <td class=" text-center"><?=$key+1?></td>
                                    <td class=" text-center"><?=$value['ngay_thanhtoan']?></td>
                                    <td class="text-right"><?=  numberformat($value['thanh_toan'])?><sup>đ</sup></td>
                                    <td class="text-center"><?=$value['ma_hoadon']?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<link rel="stylesheet" href="templates/plugin/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- DataTables -->
<script src="public/plugin/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="public/plugin/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $('#datatables2').DataTable({
        'autoWidth'   : false,
        'searching'   : true,
        'lengthChange': true
    });
    function formatNumber(nStr, decSeperate, groupSeperate) {
        nStr += '';
        x = nStr.split(decSeperate);
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + groupSeperate + '$2');
        }
        return x1 + x2;
    };
    $('.a_stt0').keyup(function(){
        var data =$(this).attr('data-id');
        var num = $(this).val();
        $('.num_'+data).html('Giá: '+formatNumber(num,',','.')+'<sup>đ</sup>');
    });
    $('#dataTable1').DataTable({
        'autoWidth'   : false,
        'searching'   : true,
        'lengthChange': true,
        "iDisplayLength": 5,
         lengthMenu: [
            [5, 10, 15, -1],
            [5, 10, 15, 'All'],
        ]
    });
    $('#dataTable2').DataTable({
        'autoWidth'   : false,
        'searching'   : true,
        'lengthChange': true,
        "iDisplayLength": 5,
         lengthMenu: [
            [5, 10, 15, -1],
            [5, 10, 15, 'All'],
        ]
    });
    $('#gia').keyup(function(){
        var num = $(this).val();
        $('.text-gia').html('Phí cho thuê: '+formatNumber(num,',','.')+'<sup>đ</sup>');
    });
    $('#gia0').keyup(function(){
        var num = $(this).val();
        $('.text-gia0').html('Số tiền: '+formatNumber(num,',','.')+'<sup>đ</sup>');
    });
</script>
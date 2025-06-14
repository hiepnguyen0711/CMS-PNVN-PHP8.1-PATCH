<?php

//$thang_ht =date('Y-m',time());
if(isset($_GET['tungay']) and $_GET['tungay']!=''){
    $ngay_batdau    = $_GET['tungay'];
    $ngay_ketthuc   = $_GET['denngay'];
}else{
    $ngay_batdau    = date('Y-m').'-01';
    $ngay_ketthuc   = date('Y-m-d');
}
$where_ngay = "BETWEEN '".$ngay_batdau."' AND '".$ngay_ketthuc."' ";
$type = '';
if(isset($_GET['type'])){
   $type =  $_GET['type'];
}
$ngay = $ngay_batdau;
if($type==''){
    $arr_time = array($ngay_batdau);
    while ($ngay < $ngay_ketthuc){
        $ngay = date('Y-m-d',strtotime('+1 day' ,strtotime($ngay)));
        if($ngay<=$ngay_ketthuc){
            array_push($arr_time, $ngay);
        }
    }
}
if($type=='1'){
    $arr_time = array(substr($ngay_batdau,0,7));
    while ($ngay < $ngay_ketthuc){
        $ngay = date('Y-m',strtotime('+31 day' ,strtotime($ngay)));
        if($ngay<=$ngay_ketthuc){
            array_push($arr_time, $ngay);
        }
    }
}


$tex_ngay='Từ '.date('d/m/Y',  strtotime($ngay_batdau)).' đến '.date('d/m/Y',  strtotime($ngay_ketthuc)) ;
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    table tr td, table tr th{
        font-family: 'Oswald', sans-serif;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          Thống kê doanh thu - <span style="font-family: 'Oswald', sans-serif;color: red;font-size: 16px;"><?=$tex_ngay?></span>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=urladmin?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="#">Quản trị khách hàng</a></li>
        <li class="active">Đơn hàng</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <form method="GET" action="">
                    <input type="hidden" name="p" value="<?=$_GET['p']?>" />
                    <input type="hidden" name="a" value="<?=$_GET['a']?>" />
                    <div class="row">
                        <div class="col-sm-3 col-sm-offset-1 form-group">
                            <label>Loại thống kê</label>
                            <select name="type" class=" form-control" >
                                <option <?=$type==''?'selected':''?> value="">Thống kê theo ngày</option>
                                <option <?=$type=='1'?'selected':''?> value="1">Thống kê theo Tháng</option>
                            </select>
                        </div>
                        <div class="col-sm-3 form-group">
                            <label>Từ ngày</label>
                            <input type="date" value="<?=$ngay_batdau?>" name="tungay" class=" form-control" />
                        </div>
                        <div class="col-sm-3 form-group">
                            <label>Đến ngày</label>
                            <input type="date" value="<?=$ngay_ketthuc?>" name="denngay" class=" form-control" />
                        </div>
                        <div class="col-sm-2 form-group">
                            <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Xem báo cáo</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Doanh số bán hàng</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped table-primary table-hover" id="dataTable1">
                            <thead>
                                <tr>
                                    <th style="width: 100px">Ngày</th>
                                    <th>Tổng đơn</th>
                                    <th>số lượng SP</th>
                                    <th>Tổng tiền</th>
                                    <th>Đã thu tiền</th>
                                    <th>Chưa thu tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($type==''){
                                $giatri_dathu = $giatri= $chuoi = '';
                                $doanhthungay = $d->o_fet("SELECT ngay_dathang, COUNT(id) as tong_don FROM `db_dathang` WHERE ngay_dathang $where_ngay GROUP BY ngay_dathang ORDER BY ngay_dathang ASC");
                                $tong_don = $tongsl = $tong_tien = $tongcho = $tongthanhtoan = 0;
                                foreach ($doanhthungay as $key => $value) {
                                    $tong_sp = $d->simple_fetch("SELECT SUM(so_luong) as tong_sl, SUM(db_dathang_chitiet.gia_ban*db_dathang_chitiet.so_luong) as tong_tien FROM `db_dathang_chitiet` JOIN db_dathang ON db_dathang_chitiet.id_dh = db_dathang.id WHERE db_dathang.ngay_dathang ='".$value['ngay_dathang']."'");
                                    $tong_thu = $d->simple_fetch("SELECT SUM(db_dathang_chitiet.gia_ban*db_dathang_chitiet.so_luong) as tong_thanhtoan FROM `db_dathang_chitiet` JOIN db_dathang ON db_dathang_chitiet.id_dh = db_dathang.id WHERE db_dathang.ngay_dathang ='".$value['ngay_dathang']."' and db_dathang.trangthai_thanhtoan = 1");
                                    $tong_chua_tt = $d->simple_fetch("SELECT SUM(db_dathang_chitiet.gia_ban*db_dathang_chitiet.so_luong) as tong_chuathanhtoan FROM `db_dathang_chitiet` JOIN db_dathang ON db_dathang_chitiet.id_dh = db_dathang.id WHERE db_dathang.ngay_dathang ='".$value['ngay_dathang']."' and db_dathang.trangthai_thanhtoan = 0");

                                    $tong_don = $tong_don + $value['tong_don'];
                                    $tongsl = $tongsl+$tong_sp['tong_sl'];
                                    $tong_tien = $tong_tien+$tong_sp['tong_tien'];
                                    $tongcho = $tongcho+$tong_chua_tt['tong_chuathanhtoan'];
                                    $tongthanhtoan = $tongthanhtoan+$tong_thu['tong_thanhtoan'];
                                    $giatri .=$tong_sp['tong_tien'].', ';
                                    $giatri_dathu .=$tong_thu['tong_thanhtoan'].', ';
                                    $chuoi .="'".date('d/m/Y',strtotime($value['ngay_dathang']))."', ";
                                ?>
                                <tr>
                                    <td class="text-center"><b><?=date('d/m/Y',strtotime($value['ngay_dathang']))?></b></td>
                                    <td class="text-right"><?=  numberformat($value['tong_don'])?></td>
                                    <td class="text-right"><?=  numberformat($tong_sp['tong_sl'])?></td>
                                    <td class="text-right"><?=  numberformat($tong_sp['tong_tien'])?><sup>đ</sup></td>
                                    <td class="text-right"><?=  numberformat($tong_thu['tong_thanhtoan'])?><sup>đ</sup></td>
                                    <td class="text-right"><?=  numberformat($tong_chua_tt['tong_chuathanhtoan'])?><sup>đ</sup></td>
                                </tr>
                                <?php } ?>
                                <?php }else{?>
                                <?php 
                                $tong_don = $tongsl = $tong_tien = $tongcho = $tongthanhtoan = 0;
                                $giatri_dathu = $giatri= $chuoi = '';
                                for($i=0;$i<count($arr_time);$i++){
                                $thang  =     $arr_time[$i];
                                $doanhthungay = $d->o_fet("SELECT ngay_dathang, COUNT(id) as tong_don FROM `db_dathang` WHERE ngay_dathang like '".$thang."%' GROUP BY ngay_dathang ORDER BY ngay_dathang ASC");
                                if(count($doanhthungay)>0){
                                    $tong_don0 = $tongsl0 = $tong_tien0 = $tongcho0 = $tongthanhtoan0 = 0;
                                    foreach ($doanhthungay as $key => $value) {
                                        $tong_sp = $d->simple_fetch("SELECT SUM(so_luong) as tong_sl, SUM(db_dathang_chitiet.gia_ban*db_dathang_chitiet.so_luong) as tong_tien FROM `db_dathang_chitiet` JOIN db_dathang ON db_dathang_chitiet.id_dh = db_dathang.id WHERE db_dathang.ngay_dathang ='".$value['ngay_dathang']."'");
                                        $tong_thu = $d->simple_fetch("SELECT SUM(db_dathang_chitiet.gia_ban*db_dathang_chitiet.so_luong) as tong_thanhtoan FROM `db_dathang_chitiet` JOIN db_dathang ON db_dathang_chitiet.id_dh = db_dathang.id WHERE db_dathang.ngay_dathang ='".$value['ngay_dathang']."' and db_dathang.trangthai_thanhtoan = 1");
                                        $tong_chua_tt = $d->simple_fetch("SELECT SUM(db_dathang_chitiet.gia_ban*db_dathang_chitiet.so_luong) as tong_chuathanhtoan FROM `db_dathang_chitiet` JOIN db_dathang ON db_dathang_chitiet.id_dh = db_dathang.id WHERE db_dathang.ngay_dathang ='".$value['ngay_dathang']."' and db_dathang.trangthai_thanhtoan = 0");

                                        $tong_don0          =   $tong_don0+$value['tong_don'];
                                        $tongsl0            =   $tongsl0+ $tong_sp['tong_sl'];
                                        $tong_tien0         =   $tong_tien0+$tong_sp['tong_tien'];
                                        $tongcho0            =   $tongcho0+ $tong_chua_tt['tong_chuathanhtoan'];
                                        $tongthanhtoan0     =   $tongthanhtoan0+$tong_thu['tong_thanhtoan'];


                                    }
                                    $tong_don       =   $tong_don + $tong_don0;
                                    $tongsl         =   $tongsl+$tongsl0;
                                    $tong_tien      =   $tong_tien+$tong_tien0;
                                    $tongcho        =   $tongcho+$tongcho0;
                                    $tongthanhtoan  =   $tongthanhtoan+$tongthanhtoan0;
                                }else{
                                    $tong_don0          =   0;
                                    $tongsl0            =   0;
                                    $tong_tien0         =   0;
                                    $tongcho0            =  0;
                                    $tongthanhtoan0     =  0;
                                }
                                $giatri .=$tong_tien0.', ';
                                $giatri_dathu .=$tongthanhtoan0.', ';
                                $chuoi.="'".date('m/Y',strtotime($thang))."', ";
                                ?>
                                <tr>
                                    <td class="text-center"><b><?=date('m/Y',strtotime($thang))?></b></td>
                                    <td class="text-right"><?=  numberformat($tong_don0)?></td>
                                    <td class="text-right"><?=  numberformat($tongsl0)?></td>
                                    <td class="text-right"><?=  numberformat($tong_tien0)?><sup>đ</sup></td>
                                    <td class="text-right"><?=  numberformat($tongthanhtoan0)?><sup>đ</sup></td>
                                    <td class="text-right"><?=  numberformat($tongcho0)?><sup>đ</sup></td>
                                </tr>
                                <?php } ?>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-right">Tổng:</th>
                                    <th class="text-right" style="color: red;font-size: 14px;"><?=  numberformat($tong_don)?></th>
                                    <th class="text-right" style="color: red;font-size: 14px;"><?=  numberformat($tongsl)?></th>
                                    <th class="text-right" style="color: red;font-size: 14px;"><?=  numberformat($tong_tien)?><sup>đ</sup></th>
                                    <th class="text-right" style="color: red;font-size: 14px;"><?=  numberformat($tongthanhtoan)?><sup>đ</sup></th>
                                    <th class="text-right" style="color: red;font-size: 14px;"><?=  numberformat($tongcho)?><sup>đ</sup></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Doanh số của CTV</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <?php  $row_ctv = $d->o_fet("select id, ma_thanhvien from #_thanhvien where loai=1 order by id desc"); ?>
                        <table class="table table-bordered table-striped table-primary table-hover" id="dataTable2">
                            <thead>
                                <tr>
                                    <th style="width: 100px">MÃ CTV</th>
                                    <th>Số lượng SP</th>
                                    <th>Doanh thu</th>
                                    <th>Chiết khấu</th>
                                    <th>Đã thanh toán</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $tongsl = $tong_tien = $tong_ck = $tongthanhtoan =0;
                                foreach ($row_ctv as $key => $value) {
                                $thongke = $d->simple_fetch("SELECT SUM(so_luong) as tong_sl, SUM(db_dathang_chitiet.gia_ban*db_dathang_chitiet.so_luong) as tong_tien, SUM((db_dathang_chitiet.gia_ban-db_dathang_chitiet.gia_goc)*db_dathang_chitiet.so_luong) as chiet_khau FROM `db_dathang_chitiet` JOIN db_dathang ON db_dathang_chitiet.id_dh = db_dathang.id WHERE db_dathang_chitiet.id_ctv =".(int)$value['id']." and db_dathang.ngay_dathang $where_ngay and db_dathang.trangthai_thanhtoan = 1");    
                                $thanhtoan = $d->simple_fetch("SELECT SUM(thanh_toan) as da_thanhtoan FROM `db_thanhtoan_ctv` WHERE id_ctv = ".(int)$value['id']." and ngay_thanhtoan $where_ngay ");

                                $tongsl = $tongsl+$thongke['tong_sl'];
                                $tong_tien = $tong_tien+$thongke['tong_tien'];
                                $tong_ck = $tong_ck+$thongke['chiet_khau'];
                                $tongthanhtoan = $tongthanhtoan+$thanhtoan['da_thanhtoan'];
                                ?>
                                <tr>
                                    <td><?=$value['ma_thanhvien']?></td>
                                    <td class="text-right"><?=  numberformat($thongke['tong_sl'])?></td>
                                    <td class="text-right"><?=  numberformat($thongke['tong_tien'])?><sup>đ</sup></td>
                                    <td class="text-right"><?=  numberformat($thongke['chiet_khau'])?><sup>đ</sup></td>
                                    <td class="text-right"><?=  numberformat($thanhtoan['da_thanhtoan'])?><sup>đ</sup></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-right">Tổng:</th>
                                    <th class="text-right" style="color: red;font-size: 14px;"><?=  numberformat($tongsl)?></th>
                                    <th class="text-right" style="color: red;font-size: 14px;"><?=  numberformat($tong_tien)?><sup>đ</sup></th>
                                    <th class="text-right" style="color: red;font-size: 14px;"><?=  numberformat($tong_ck)?><sup>đ</sup></th>
                                    <th class="text-right" style="color: red;font-size: 14px;"><?=  numberformat($tongthanhtoan)?><sup>đ</sup></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                
                <h3 class="box-title">Biểu đồ doanh thu</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <canvas id="myChart" width="500" height="200"></canvas>
            </div>
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.js"></script>
<script>
    const ctx = document.getElementById('myChart');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?=  trim($chuoi,', ')?>],
            datasets: [
                {
                    label: 'Tổng doanh thu',
                    data: [<?=  trim($giatri)?>],
                    backgroundColor: [
                        'rgb(51 122 183)',
                    ]
                }
            ],
            
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<link rel="stylesheet" href="templates/plugin/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- DataTables -->
<script src="public/plugin/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="public/plugin/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    
    $('#dataTable1').DataTable({
        'autoWidth'   : false,
        'searching'   : true,
        'lengthChange': true,
        "iDisplayLength": 10
    });
    $('#dataTable2').DataTable({
        'autoWidth'   : false,
        'searching'   : true,
        'lengthChange': true,
        "iDisplayLength": 10
    });
</script>
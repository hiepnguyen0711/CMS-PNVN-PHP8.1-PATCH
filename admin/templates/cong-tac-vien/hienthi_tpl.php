<?php
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Quản lý cộng tác viên
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
                
                <table class="table table-bordered table-striped table-primary table-hover" id="dataTable1">
                    <thead>
                        <tr>
                            <th style="width:100px" rowspan="2">Mã</th>
                            <th rowspan="2">Họ tên</th>
                            <th rowspan="2">Liên hệ</th>
                            <th colspan="4">Doanh số bán hàng</th>
                            <th rowspan="2" style="width: 100px">Trạng thái</th>
                            <th rowspan="2" style="width: 120px">Thao tác</th>
                        </tr>
                        <tr>
                            <th>Đang chờ</th>
                            <th>Đã hủy</th>
                            <th>Hoàn thành</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $tongcho0 = $tongloinhuan0 = $tonghuy0 = $tong0 = 0;
                        foreach ($items as $key => $value) {
                            $tong_cho = $d->simple_fetch("SELECT SUM((db_dathang_chitiet.gia_ban-db_dathang_chitiet.gia_goc)*db_dathang_chitiet.so_luong) as tong FROM `db_dathang_chitiet` JOIN db_dathang on db_dathang_chitiet.id_dh = db_dathang.id WHERE db_dathang.trangthai_xuly < 3 AND db_dathang_chitiet.id_ctv = ".$value['id']." GROUP BY db_dathang_chitiet.id_ctv");
                            $tong_loinhuan = $d->simple_fetch("SELECT SUM((db_dathang_chitiet.gia_ban-db_dathang_chitiet.gia_goc)*db_dathang_chitiet.so_luong) as tong FROM `db_dathang_chitiet` JOIN db_dathang on db_dathang_chitiet.id_dh = db_dathang.id WHERE db_dathang.trangthai_xuly = 3 AND db_dathang_chitiet.id_ctv = ".$value['id']." GROUP BY db_dathang_chitiet.id_ctv");
                            $tong_huy = $d->simple_fetch("SELECT SUM((db_dathang_chitiet.gia_ban-db_dathang_chitiet.gia_goc)*db_dathang_chitiet.so_luong) as tong FROM `db_dathang_chitiet` JOIN db_dathang on db_dathang_chitiet.id_dh = db_dathang.id WHERE db_dathang.trangthai_xuly = 4 AND db_dathang_chitiet.id_ctv = ".$value['id']." GROUP BY db_dathang_chitiet.id_ctv");
                            $tongcho0 = $tongcho0 +$tong_cho['tong'];
                            $tongloinhuan0 = $tongloinhuan0+ $tong_loinhuan['tong'];
                            $tonghuy0 = $tonghuy0 +$tong_huy['tong'];
                            $tong0 = $tong0+($tongcho0+$tongloinhuan0+$tonghuy0);
                        ?>
                        <tr>
                            <td><?=$value['ma_thanhvien']?></td>
                            <td><?=$value['ho_ten']?></td>
                            <td >
                                <?=$value['dien_thoai']?><br>
                                <?=$value['email']?>
                                
                            </td>
                            <td class="text-right" style="font-weight: 600;">
                                <?= numberformat($tong_cho['tong'])?><sup>đ</sup>
                            </td>
                            <td class="text-right" style="font-weight: 600;">
                                <?= numberformat($tong_huy['tong'])?><sup>đ</sup>
                            </td>
                            <td class="text-right" style="font-weight: 600;">
                                 <?= numberformat($tong_loinhuan['tong'])?><sup>đ</sup>
                            </td>
                            <td class="text-right" style="font-weight: 600;">
                                <?= numberformat($tong_cho['tong']+$tong_huy['tong']+$tong_loinhuan['tong'])?><sup>đ</sup>
                            </td>
                            <td class="text-center">
                                <input class="chk_box" <?php if($d->checkPermission_edit($id_module)==0){ ?>disabled<?php }?> type="checkbox" onclick="on_check(this,'#_thanhvien','trang_thai','<?=$value['id']?>')" <?php if($value['trang_thai'] == 1) echo 'checked="checked"'; ?>>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-xs btn-info" href="index.php?p=<?=$_GET['p']?>&a=edit&id=<?=$value['id']?>"  title="Sửa">Chi tiết</a>
                                <?php if($d->checkPermission_dele($id_module)==1){ ?>
                                <a href="index.php?p=<?=$_GET['p']?>&a=delete&id=<?=$value['id']?>" onClick="if(!confirm('Xác nhận xóa?')) return false;" class="btn btn-xs btn-danger" title="Xóa">Xóa</a>
                                <?php }?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">Tổng:</th>
                            <th class="text-right text-danger text-bold">
                                <?=  numberformat($tongcho0)?> <sup>đ</sup>
                            </th>
                            <th class="text-right text-danger text-bold">
                                <?=  numberformat($tonghuy0)?> <sup>đ</sup>
                            </th>
                            <th class="text-right text-danger text-bold">
                                <?=  numberformat($tongloinhuan0)?> <sup>đ</sup>
                            </th>
                            <th class="text-right text-danger text-bold">
                                <?=  numberformat($tong0)?> <sup>đ</sup>
                            </th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
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
        "iDisplayLength": 10
    });
</script>
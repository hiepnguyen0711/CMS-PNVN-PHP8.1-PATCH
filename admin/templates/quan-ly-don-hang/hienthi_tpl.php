<?php
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Quản lý đơn hàng
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= urladmin ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="#">Quản trị khách hàng</a></li>
            <li class="active">Đơn hàng</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">

                <table class="table table-bordered table-striped table-primary table-hover" id="dataTable1">
                    <thead>
                        <tr>
                            <th style="width: 70px">Mã ĐH</th>
                            <th>Thông tin khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Ngày đặt hàng</th>
                            <th>Thanh toán</th>
                            <th>Xử lý</th>
                            <th style="width: 120px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $tongcho = $tonghuy = $tongthu = 0;
                        $chietkhau = $d->simple_fetch("SELECT SUM((gia_ban-gia_goc)*so_luong) as chieckhau FROM `db_dathang_chitiet` WHERE id_ctv>0");
                        foreach ($items as $key => $value) {
                            $tongtien = $d->simple_fetch("SELECT sum(gia_ban*so_luong) as tongtien FROM `db_dathang_chitiet` where id_dh = " . $value['id'] . " ");
                            if ($value['trangthai_xuly'] < 3) {
                                $tongcho = $tongcho + $tongtien['tongtien'];
                            } elseif ($value['trangthai_xuly'] == 3) {
                                $tongthu = $tongthu + $tongtien['tongtien'];
                            } else {
                                $tonghuy = $tonghuy + $tongtien['tongtien'];
                            }
                        ?>
                            <tr>
                                <td><?= $value['ma_dh'] ?></td>
                                <td>
                                    <strong><?= $value['ho_ten'] ?></strong><br>
                                    <span> <i class="fa fa-phone" aria-hidden="true"></i> <?= $value['dien_thoai'] ?></span>
                                    <?php if ($value['email'] != '') { ?>
                                        - <i class="fa fa-envelope" aria-hidden="true"></i> <span> <?= $value['email'] ?></span>
                                    <?php } ?>
                                    <br>
                                    <span><i class="fa fa-map-marker" aria-hidden="true"></i> <?= $value['dia_chi'] ?></span>
                                </td>
                                <td class="text-right" style="color: red;font-weight: 600;font-size: 15px;">
                                    <?= numberformat($tongtien['tongtien']) ?>
                                </td>
                                <td class="text-center"><?= $value['ngay_dathang'] ?></td>
                                <td>
                                    <?= $value['thanh_toan'] ?><br>
                                    <?php if ($value['trangthai_thanhtoan'] == 0) { ?>
                                        <label class="label label-danger">Chưa thanh toán</label>
                                    <?php } else { ?>
                                        <label class="label label-success">Đã thanh toán</label>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($value['trangthai_xuly'] == 0) { ?>
                                        <label style="font-size: 13px;padding: 5px 15px 7px;" class="label label-danger">Đơn hàng mới</label>
                                    <?php } elseif ($value['trangthai_xuly'] == 1) { ?>
                                        <label style="font-size: 13px;padding: 5px 15px 7px;" class="label label-warning">Đang xử lý</label>
                                    <?php } elseif ($value['trangthai_xuly'] == 2) { ?>
                                        <label style="font-size: 13px;padding: 5px 15px 7px;" class="label label-info">Đang giao</label>
                                    <?php } elseif ($value['trangthai_xuly'] == 3) { ?>
                                        <label style="font-size: 13px;padding: 5px 15px 7px;" class="label label-success">Đã hoàn thành</label>
                                    <?php } elseif ($value['trangthai_xuly'] == 4) { ?>
                                        <label style="font-size: 13px;padding: 5px 15px 7px;" class="label label-info">Trả hàng</label>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-xs btn-info" href="index.php?p=<?= $_GET['p'] ?>&a=edit&id=<?= $value['id'] ?>" title="Sửa">Chi tiết</a>
                                    <?php if ($d->checkPermission_dele($id_module) == 1) { ?>
                                        <a href="index.php?p=<?= $_GET['p'] ?>&a=delete&id=<?= $value['id'] ?>" onClick="if(!confirm('Xác nhận xóa?')) return false;" class="btn btn-xs btn-danger" title="Xóa">Xóa</a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="7">Tổng: <span style="color: red;float: right;">$<?= numberformat($tongcho + $tonghuy + $tongthu) ?></span></th>
                            <?php /* <th>Đã thu: <span style="color: red;float: right;"><?= numberformat($tongthu) ?><sup>đ</sup></span></th>
                            <th>Đang xử lý: <span style="color: red;float: right;"><?= numberformat($tongcho) ?><sup>đ</sup></span></th>
                            <th>Đã hủy: <span style="color: red;float: right;"><?= numberformat($tonghuy) ?><sup>đ</sup></span></th> */ ?>
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
        'autoWidth': false,
        'searching': true,
        'lengthChange': true,
        "iDisplayLength": 25
    });
</script>
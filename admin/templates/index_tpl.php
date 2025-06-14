<?php
$count_sp = $d->num_rows("select * from #_sanpham");
$count_baiviet = $d->num_rows("select * from #_tintuc");
$count_donhang = $d->num_rows("select * from #_dathang");
$count_khachhang = $d->num_rows("select * from #_dathang GROUP BY dien_thoai");
// $donhangmoi = $d->o_fet("select * from #_dathang where trangthai_xuly = 0 order by id desc");
$lienhemoi = $d->o_fet("select * from #_lienhe where trang_thai = 0 and loai_lienhe = 0 order by id desc");
$khieunaimoi = $d->o_fet("select * from #_lienhe where trang_thai = 0 and loai_lienhe = 1 order by id desc");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= $count_donhang ?></h3>
                        <p>Đơn hàng</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Xem chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= $count_sp ?></h3>
                        <p>Sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars "></i>
                    </div>
                    <a href="#" class="small-box-footer">Xem chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>44</h3>
                        <p>Khách hàng</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">Xem chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?= $count_baiviet ?></h3>
                        <p>Bài viết</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">Xem chi tiết<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

        <div class="row">
            <!-- đơn khiếu nại -->
            <div class="col-lg-6 col-xs-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">ĐƠN KHIẾU NẠI</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th class="text-center">STT</th>
                                        <th>Tên khách hàng</th>
                                        <th>Mã vận đơn</th>
                                        <th>nội dung</th>
                                        <th>Ngày gửi</th>
                                        <th class="text-center">Xem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($khieunaimoi as $key => $value) { ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td><?= $value['ho_ten'] ?></td>
                                            <td><?= $value['ma_van_don'] ?></td>
                                            <td><?= $value['tieu_de'] != '' ? '<b>' . $value['tieu_de'] . ' </b> ' : '' ?><?= catchuoi($value['noi_dung'], 150) ?></td>
                                            <td class=""><?= $value['ngay_hoi'] ?></td>
                                            <td class="text-center">
                                                <a data-toggle="modal" onclick="load_ajax(<?= $value['id'] ?>)" data-target="#myModal" class="btn btn-xs btn-info" href="#" title="Sửa">Chi tiết</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="index.php?p=lien-he&a=man" class="btn btn-sm btn-default btn-flat pull-right">Xem tất cả liên hệ</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
            <!-- đơn khiếu nại end -->
            <?php if (get_json('cart', 'display')) { ?>
                <div class="col-lg-6 col-xs-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Đơn đặt hàng mới</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>   
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th>Mã đơn hàng</th>
                                            <th>Tên khách hàng</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Chi tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($donhangmoi as $key => $value) {

                                        ?>
                                            <tr>
                                                <td><a href="index.php?p=quan-ly-don-hang&a=edit&id=<?= $value['id'] ?>"><?= $value['ma_dh'] ?></a></td>
                                                <td><?= $value['ho_ten'] ?></td>
                                                <td><span class="label label-success">Đơn hàng mới</span></td>
                                                <td>
                                                    <?= $value['ngay_dathang'] ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="index.php?p=quan-ly-don-hang&a=edit&id=<?= $value['id'] ?>" class="label label-primary"><i class="glyphicon glyphicon-edit"></i> Chi tiết</a>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <a href="index.php?p=quan-ly-don-hang&a=man" class="btn btn-sm btn-default btn-flat pull-right">Xem tất cả đơn hàng</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                </div>
            <?php } ?>
            <div class="col-lg-6 col-xs-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Khách hàng Đặt lịch/Liên hệ</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th class="text-center">STT</th>
                                        <th>Tên khách hàng</th>
                                        <th>nội dung</th>
                                        <th>Ngày gửi</th>
                                        <th class="text-center">Xem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lienhemoi as $key => $value) { ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td><?= $value['ho_ten'] ?></td>
                                            <td><?= $value['tieu_de'] != '' ? '<b>' . $value['tieu_de'] . ' </b> ' : '' ?><?= catchuoi($value['noi_dung'], 150) ?></td>
                                            <td class=""><?= $value['ngay_hoi'] ?></td>
                                            <td class="text-center">
                                                <a data-toggle="modal" onclick="load_ajax(<?= $value['id'] ?>)" data-target="#myModal" class="btn btn-xs btn-info" href="#" title="Sửa">Chi tiết</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="index.php?p=lien-he&a=man" class="btn btn-sm btn-default btn-flat pull-right">Xem tất cả liên hệ</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<link rel="stylesheet" href="public/plugin/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- DataTables -->
<script src="public/plugin/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="public/plugin/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $('.dataTable').DataTable({
        'autoWidth': false,
        'searching': false,
        'lengthChange': false
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
    function load_ajax(id) {
        $.ajax({
            url: "sources/ajax.php",
            type: "post",
            dataType: "text",
            data: {
                do: 'get_lienhe',
                id: id
            },
            success: function(result) {
                $('#body-lienhe').html(result);
            }
        });
    }
</script>
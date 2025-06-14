<?php
if (isset($_POST['capnhat'])) {
    foreach (get_json('lang') as $key => $value) {
        $code = $value['code'];
        $data_text[$code] = $_POST['ten'][$key];
    }
    $str =  json_encode($data_text, JSON_UNESCAPED_UNICODE);
    $data['text'] = $str;
    $d->reset();
    if (isset($_GET['id'])) {
        $d->setTable('#_text');
        $d->setWhere('id', $_GET['id']);
        $d->update($data);
    } else {
        $d->setTable('#_text');
        $d->insert($data);
    }
    $d->redirect("index.php?p=" . $_GET['p'] . "&a=man");
}
if (isset($_GET['delete']) and $_GET['delete'] != '') {
    $id = (int)$_GET['delete'];
    $d->o_que("delete from #_text where id = $id ");
    $d->redirect("index.php?p=" . $_GET['p'] . "&a=man");
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Text
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= urladmin ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="#">Quản trị giao diện</a></li>
            <li class="active">Text</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <form method="POST" action="">
                    <table class="table table-bordered table-striped table-primary table-hover" id="dataTable1">
                        <thead>
                            <tr>
                                <th style="width: 70px">ID</th>
                                <?php foreach (get_json('lang') as $key => $value) { ?>
                                    <th><?= $value['name'] ?></th>
                                <?php } ?>
                                <th style="width: 150px">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $key0 => $item) { ?>
                                <tr>
                                    <td class="text-center"><?= $item['id'] ?></td>
                                    <?php foreach (get_json('lang') as $key => $value) {
                                        $arr_lang = json_decode($item['text'], true);

                                    ?>
                                        <td><?= $arr_lang[$value['code']] ?></td>
                                    <?php } ?>
                                    <td class="text-center">
                                        <a href="index.php?p=<?= $_GET['p'] ?>&a=man&id=<?= $item['id'] ?>" class="label label-warning" title="Sửa" style="margin-right: 5px;">
                                            <i class="glyphicon glyphicon-edit"></i> Sửa
                                        </a>
                                        <?php if (($d->checkPermission_dele($id_module) == 1) && (get_json('dev', 'display') == true)) { ?>
                                            <a href="index.php?p=<?= $_GET['p'] ?>&a=man&delete=<?= $item['id'] ?>" onClick="if(!confirm('Xác nhận xóa?')) return false;" class="label label-danger" title="Xóa"><i class="glyphicon glyphicon-remove"></i> Xóa</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <?php if (isset($_GET['id'])) {
                                $row = $d->simple_fetch("select * from #_text where id = " . (int)$_GET['id'] . " ");
                                $arr_lang_edit = json_decode($row['text'], true);
                            } ?>
                            <tr>
                                <th>Thêm mới</th>
                                <?php foreach (get_json('lang') as $key => $value) { ?>
                                    <th>
                                        <input style="width: 100%;font-weight: 400;" type="text" class="form-control" value="<?= $arr_lang_edit[$value['code']] ?>" name="ten[]" placeholder="Nội dung <?= $value['name'] ?>" />
                                    </th>
                                <?php } ?>
                                <th><button class="btn btn-primary btn-block" type="submit" name="capnhat">Cập nhật</button></th>
                            </tr>
                        </tfoot>
                    </table>
                </form>
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
<?php

$nav = $d->o_fet("select * from #_module_admin where parent = '0' and hien_thi = 1  order by so_thu_tu ASC");
$donhangmoi = $d->o_fet("select * from #_dathang where trangthai_xuly = 0 order by id desc");
$lienhemoi = $d->o_fet("select * from #_lienhe where trang_thai = 0 order by id desc");
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php if ($user_login['hinh_anh'] != '') { ?>
                    <img src="../img_data/images/<?= $user_login['hinh_anh'] ?>" class="img-circle" alt="User Image">
                <?php } else { ?>
                    <img src="img/icon-user.png" class="img-circle" alt="User Image">
                <?php } ?>
            </div>
            <div class="pull-left info">
                <p><?= $_SESSION['name'] ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <?php
            foreach ($nav as $key => $value) {
                $item0 = $d->o_fet("select * from #_module_admin where parent = '" . $value['id'] . "' and hien_thi = 1 order by so_thu_tu ASC");
                $list_id        =   ',';
                $list_alias     =   ',';
                foreach ($item0 as $key2 => $value2) {
                    $list_id    .=  $value2['id'] . ',';
                    $list_alias .=  $value2['alias'] . ',';
                }
            ?>
                <?php if ($d->checkPermission($_SESSION['id_user'], trim($list_id, ',')) == 1) { ?>
                    <li class="treeview <?php if (strlen(strstr($list_alias, $_GET['p'])) > 0) { ?> active<?php } ?>">
                        <a href="#">
                            <i class="fa <?= $value['alias'] ?>"></i>
                            <span><?= $value['name'] ?></span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            <?php if ($value['id'] == '43' and (count($donhangmoi) + count($lienhemoi)) > 0) { ?>
                                <span class="pull-right-container">
                                    <small class="label pull-right bg-red"><?= count($donhangmoi) + count($lienhemoi) ?></small>
                                </span>
                            <?php } ?>
                        </a>
                        <ul class="treeview-menu" <?php if (strlen(strstr($list_alias, $_GET['p'])) > 0) { ?> style="display: block" <?php } ?>>
                            <?php foreach ($item0 as $key2 => $value2) { ?>
                                <?php if ($d->checkPermission($_SESSION['id_user'], $value2['id']) == 1) { ?>
                                    <li <?php if ($_GET['p'] == $value2['alias']) { ?>class="active" <?php } ?>>
                                        <a href="index.php?p=<?= $value2['alias'] ?>&a=man"><i class="fa fa-circle-o"></i> <?= $value2['name'] ?>
                                            <?php if ($value2['id'] == '43' and count($donhangmoi) > 0) { ?>
                                                <span class="pull-right-container">
                                                    <small class="label pull-right bg-red"><?= count($donhangmoi) ?></small>
                                                </span>
                                            <?php } ?>
                                            <?php if ($value2['id'] == '33' and count($lienhemoi) > 0) { ?>
                                                <span class="pull-right-container">
                                                    <small class="label pull-right bg-red"><?= count($lienhemoi) ?></small>
                                                </span>
                                            <?php } ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
            <?php } ?>
            <li <?php if ($_GET['p'] == 'thongtin-user') { ?>class="active" <?php } ?>>
                <a href="?p=thongtin-user&a=man">
                    <i class="fa fa-user"></i> <span>Thông tin đăng nhập</span>
                </a>
            </li>
            <?php if (get_json('dev', 'display')) { ?>
                <li <?php if ($_GET['p'] == 'module') { ?>class="active" <?php } ?>>
                    <a href="?p=module&a=man">
                        <i class="fa fa-user"></i> <span>Dev mode</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
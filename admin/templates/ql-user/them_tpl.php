<?php

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Quản lý user <small>[ <?= $_GET['a'] == 'add' ? 'Thêm mới' : 'Sửa' ?> ]</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= urladmin ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="#">Cấu hình website</a></li>
            <li class="active">Quản lý user</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <form name="frm" method="post" class=" form-horizontal" action="index.php?p=ql-user&a=save&id=<?= @$_REQUEST['id'] ?>&page=<?= @$_REQUEST['page'] ?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Hình ảnh:</label>
                                <div class="col-sm-9 form-group m0 hinh_anh">
                                    <span class="box-img2">
                                        <?php if (isset($_GET['id']) and $row['hinh_anh'] != '') { ?>
                                            <img src="../img_data/images/<?php echo $row['hinh_anh'] ?>" id="review_hinh_anh" alt="NO PHOTO" />
                                            <button class="btn btn-xs btn-danger" type="button" onclick="xoa_img('_tintuc','hinh_anh', '<?= $_GET['id'] ?>','')"><i class="fa fa-trash"></i></button>
                                        <?php } else { ?>
                                            <img src="img/no-image.png" style="max-width: 100%;max-height: 100%;object-fit: contain;" id="review_hinh_anh" alt="NO PHOTO" />
                                        <?php } ?>
                                        <input type="hidden" value="<?= $row['hinh_anh'] ?>" name="hinh_anh" id="hinh_anh" class=" form-control">
                                        <a href="filemanager/dialog.php?type=1&field_id=hinh_anh&relative_url=1&multiple=0" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn hình ảnh</a>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Họ tên:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="ho_ten" value="<?php echo @$items[0]['ho_ten'] ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="email" value="<?php echo @$items[0]['email'] ?>" />
                                </div>
                            </div>
                            <?php
                            if ($_SESSION['quyen'] < 4) {
                                $quyenhan = $d->o_fet("select * from #_permission where id < " . $_SESSION['quyen'] . " order by id desc");
                            } else {
                                $quyenhan = $d->o_fet("select * from #_permission order by id desc");
                            }

                            ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Giới thiệu bản thân:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="noi_dung" id="noi_dung" rows="3"><?= $items[0]['noi_dung'] ?></textarea>
                                </div>
                                <script>
                                    CKEDITOR.replace('noi_dung', {
                                        filebrowserBrowseUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                        filebrowserUploadUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                        filebrowserImageBrowseUrl: 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='
                                    });
                                </script>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Loại tài khoản:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="quyen_han" name="quyen_han">
                                        <?php foreach ($quyenhan as $key => $value) { ?>
                                            <option <?= $items[0]['quyen_han'] == $value['id'] ? 'selected' : '' ?> value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tên đăng nhập:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="tai_khoan" value="<?php echo @$items[0]['tai_khoan'] ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Mật khẩu:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="password" name="password" id="password" value="<?php echo @$items[0]['password'] ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nhập lại mật khẩu:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="password" name="cfpassword" id="cfpassword" value="<?php echo @$items[0]['cfpassword'] ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tác vụ:</label>
                                <div class="col-sm-9">
                                    <div class="checkbox icheck" style="margin-left: 20px;">
                                        <label>
                                            <input name="hien_thi" <?php if (isset($items[0]['hien_thi'])) {
                                                                        if (@$items[0]['hien_thi'] == 1) echo 'checked="checked"';
                                                                    } else echo 'checked="checked"'; ?> type="checkbox"> Hiển thị
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3">
                                <button type="submit" name="capnhat" class="btn btn-primary" onclick="return kiemtra()"><span class="glyphicon glyphicon-floppy-save"></span> Cập nhật</button>
                                </div>
                            </div>
                        </div>
                        <?php
                        $permission_group = $d->o_fet("select * from #_module_admin where parent = 0 order by id ASC");
                        ?>
                        <div class="col-sm-6">
                            <div>
                                <div class="row m-5">
                                    <?php foreach ($permission_group as $key => $value) {
                                        $permission = $d->o_fet("select * from #_module_admin where parent = " . $value['id'] . " order by id ASC");
                                        if (count($permission) == 0) {
                                            $permission = $d->o_fet("select * from #_module_admin where id = " . $value['id'] . " order by id ASC");
                                        }
                                    ?>
                                        <div class="col-sm-12 p5 col-text">
                                            <h3 style="font-size: 14px;text-transform: uppercase;font-weight: 600;margin-top: 0px;margin-bottom: 5px;"><?= $value['name'] . '--' . $value['id'] ?></h3>
                                            <div class="box-per">
                                                <div class="row m-5">
                                                    <?php foreach ($permission as $key2 => $value2) {
                                                                                                $permission_usrt = [];
                                        if (isset($_GET['id'])) {
                                            $permission_usrt = $d->simple_fetch("select * from #_user_permission_group where id_user = " . $_GET['id'] . " and id_permission = " . $value2['id'] . " ");
                                        }
                                                                                                $permission_usrt2 = [];
                                        if ($_SESSION['quyen'] < 4) {
                                            $permission_usrt2 = $d->simple_fetch("select * from #_user_permission_group where id_user = " . $_SESSION['id_user'] . " and id_permission = " . $value2['id'] . " ");
                                        }
                                                    ?>
                                                        <?php if (count($permission_usrt2 ?? []) > 0 or $_SESSION['quyen'] == 4) { ?>
                                                            <div class="col-sm-6 p5">
                                                                <div class="item-per">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input <?= count($permission_usrt ?? []) > 0 ? 'checked' : '' ?> value="<?= $value2['id'] ?>" name="permission[]" type="checkbox"> <?= $value2['name'] ?>
                                                                        </label>
                                                                    </div>
                                                                    <div class="list-action">
                                                                        <?php if (strlen(strstr($permission_usrt2['action'], '1')) > 0 or $_SESSION['quyen'] == 4) { ?>
                                                                            <label>
                                                                                <input <?php if (strlen(strstr($permission_usrt['action'], '1')) > 0) {
                                                                                            echo "checked";
                                                                                        } ?> name="action_<?= $value2['id'] ?>[]" value="1" type="checkbox"> <span>Xem</span>
                                                                            </label>
                                                                        <?php } ?>
                                                                        <?php if (strlen(strstr($permission_usrt2['action'], '2')) > 0 or $_SESSION['quyen'] == 4) { ?>
                                                                            <label>
                                                                                <input <?php if (strlen(strstr($permission_usrt['action'], '2')) > 0) {
                                                                                            echo "checked";
                                                                                        } ?> name="action_<?= $value2['id'] ?>[]" value="2" type="checkbox"> <span>Sửa</span>
                                                                            </label>
                                                                        <?php } ?>
                                                                        <?php if (strlen(strstr($permission_usrt2['action'], '3')) > 0 or $_SESSION['quyen'] == 4) { ?>
                                                                            <label>
                                                                                <input <?php if (strlen(strstr($permission_usrt['action'], '3')) > 0) {
                                                                                            echo "checked";
                                                                                        } ?> name="action_<?= $value2['id'] ?>[]" value="3" type="checkbox"> <span>Xóa</span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>

                                            </div>

                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js"></script>
<script type="text/javascript">
    $('#quyen_han').change(function() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        if ($(this).val() === '4') {
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = true;
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
            }
        }
    })
    $(function() {
        $('.col-text').matchHeight();
    });

    function kiemtra() {
        const password = $('#password').val();
        const idtv = <?= $_REQUEST['id'] ? $_REQUEST['id'] : 0; ?>;
        if (password != '') {
            const regex = /^(?=.*\d)(?=.*[a-z])(?=.*[!@#$%^&*])(?=.*[A-Z]).{8,20}$/;
            const re_password = $('#cfpassword').val();

            if (regex.test(password) == false) {
                $(".err").text("Mật khẩu chưa đúng định dạng");
                $("#password").focus();
                return false;
            } else if (re_password == '') {
                $(".err").text("Nhập lại mật khẩu không được để trống");
                $("#cfpassword").focus();
                return false;
            } else if (password != re_password) {
                $(".err").text("Mật khẩu nhập lại không đúng");
                $("#cfpassword").focus();
                return false;
            } else {
                return true;
            }
        } else {
            if (idtv == 0) {
                $(".err").text("Mật khẩu không được để trống");
                $("#password").focus();
                return false;
            } else {
                return true;

            }
        }
    }
</script>
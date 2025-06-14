<?php
if (isset($_POST['capnhat'])) {

    //$data['tai_khoan'] = $d->clean(addslashes($_POST['tai_khoan']));

    //$data['user_hash'] = sha1($data['tai_khoan']);

    $data['ho_ten'] = addslashes($_POST['ho_ten']);

    $data['noi_dung'] = addslashes($_POST['noi_dung']);

    $data['hinh_anh'] = addslashes($_POST['hinh_anh']);

    if (!empty($_POST['password']) && !empty($_POST['old-password']) && !empty($_POST['cfpassword'])) {

        $current_pass = $d->simple_fetch("select pass_hash from #_user where id = " . $_SESSION['id_user'] . " ")['pass_hash'];

        $old_password = sha1($d->clean(addslashes($_POST['old-password'])));

        $password     = sha1($d->clean(addslashes($_POST['password'])));

        $re_password  = sha1($d->clean(addslashes($_POST['cfpassword'])));

        if ($old_password != $current_pass) {

            $err = 'Mật khẩu cũ chưa đúng';
        } else if ($password != $re_password) {

            $err = 'Mật khẩu nhập lại chưa đúng';
        } else {

            $data['pass_hash'] =  $password;

            $d->setTable('#_user');

            $d->setWhere('id', $_SESSION['id_user']);

            if ($d->update($data)) {

                $d->alert('Cập nhật thành công.Vui lòng đăng nhập lại!');

                session_destroy();

                $d->redirect("login.php");

                exit();
            }
        }
    } else {
        $d->setTable('#_user');
        $d->setWhere('id', $_SESSION['id_user']);
        if ($d->update($data)) {
            $d->alert('Cập nhật thành công.');
            $d->redirect($current_page);
        }
    }
}

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thông tin user <small>[ <?= $_GET['a'] == 'add' ? 'Thêm mới' : 'Sửa' ?> ]</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= urladmin ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="#">Thông tin user</a></li>
            <li class="active">Quản lý user</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <form method="post" class=" form-horizontal" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Hình ảnh:</label>
                                <div class="col-sm-9 form-group m0 hinh_anh">
                                    <span class="box-img2">
                                        <?php if ($items[0]['hinh_anh'] != '') { ?>
                                            <img src="../img_data/images/<?php echo $items[0]['hinh_anh'] ?>" id="review_hinh_anh" alt="NO PHOTO" />
                                            <button class="btn btn-xs btn-danger" type="button" onclick="xoa_img('_user','hinh_anh', '<?= $_GET['id'] ?>','')"><i class="fa fa-trash"></i></button>
                                        <?php } else { ?>
                                            <img src="img/no-image.png" style="max-width: 100%;max-height: 100%;object-fit: contain;" id="review_hinh_anh" alt="NO PHOTO" />
                                        <?php } ?>
                                        <input type="hidden" value="<?= $items[0]['hinh_anh'] ?>" name="hinh_anh" id="hinh_anh" class=" form-control">
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
                                <p class="text-center">
                                    <font class='err' style="color: red"><?= @$err ?></font>
                                </p>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tên đăng nhập:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="tai_khoan" value="<?php echo @$items[0]['tai_khoan'] ?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Mật khẩu cũ:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="password" name="old-password" id="old-password" value="" />
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
                                    <p class="txt_notePassword">Mật khẩu từ 8 ký tự bắt buộc phải có chữ thường, chữ HOA, số, ký tự đặc biệt. Ví dụ: Phuong24!#</p>
                                    <button type="submit" name="capnhat" class="btn btn-primary" onclick="return check_update_password()"><span class="glyphicon glyphicon-floppy-save"></span> Cập nhật</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    function check_update_password() {

        const password = $('#password').val();

        if (password != '') {

            const regex = /^(?=.*\d)(?=.*[a-z])(?=.*[!@#$%^&*])(?=.*[A-Z]).{8,20}$/;

            const old_password = $('#old-password').val();

            const re_password = $('#cfpassword').val();

            if (old_password == '') {

                $(".err").text("Chưa nhập mật khẩu cũ");

                $('#old-password').focus();

                return false;

            } else if (regex.test(password) == false) {

                $(".err").text("Mật khẩu mới chưa đúng định dạng");

                $("#password").focus();

                return false;

            } else if (re_password == '') {

                $(".err").text("Chưa nhập lại mật khẩu");

                $('#cfpassword').focus();

                return false;

            } else if (password != re_password) {

                $(".err").text("Mật khẩu nhập lại không đúng");

                $('#cfpassword').focus();

                return false;
            } else {

                return true;
            }

        } else {
            return true;
        }
    }
</script>
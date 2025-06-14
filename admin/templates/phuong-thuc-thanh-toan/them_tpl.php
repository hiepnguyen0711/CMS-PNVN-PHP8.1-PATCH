<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Phương Thức Thanh Toán <small>[<?php if (isset($_GET['id'])) echo "chi tiết ";
                                            else echo "Thêm mới" ?>]</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= urladmin ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="#">Quản lý bán hàng</a></li>
            <li class="active">Phương Thức Thanh Toán</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <form name="frm" method="post" class=" form-horizontal" action="index.php?p=<?= $_GET['p'] ?>&a=save&id=<?= @$_REQUEST['id'] ?><?= $link_option ?>" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tên:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="ten" value="<?= $items['ten'] ?>">
                            </div>
                        </div>
                        <div class="form-group m0 hinh_anh">
                            <label class="col-sm-3 control-label">Hình ảnh:</label>
                            <div class="col-sm-9">
                                <span class="box-img2">
                                    <?php if (isset($_GET['id']) and $items['hinh_anh'] != '') { ?>
                                        <img src="../img_data/images/<?php echo $items['hinh_anh'] ?>" id="review_hinh_anh" alt="NO PHOTO" />
                                        <button class="btn btn-xs btn-danger" type="button" onclick="xoa_img('_phuong_thuc_thanh_toan','hinh_anh', '<?= $_GET['id'] ?>','')"><i class="fa fa-trash"></i></button>
                                    <?php } else { ?>
                                        <img src="img/no-image.png" style="max-width: 100%;max-height: 100%;object-fit: contain;" id="review_hinh_anh" alt="NO PHOTO" />
                                    <?php } ?>
                                    <input type="hidden" value="<?= $items['hinh_anh'] ?>" name="hinh_anh" id="hinh_anh" class="form-control img-preview-hidden" data-target="#review_hinh_anh">
                                    <a href="filemanager/dialog.php?type=1&field_id=hinh_anh&relative_url=1&multiple=0" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn hình ảnh</a>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nội dung <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="noi_dung" id="noi_dung_<?= $value['code'] ?>" rows="3"><?= $items['noi_dung'] ?></textarea>
                            </div>
                            <script>
                                CKEDITOR.replace('noi_dung_<?= $value['code'] ?>', {
                                    filebrowserBrowseUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                    filebrowserUploadUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                    filebrowserImageBrowseUrl: 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='
                                });
                            </script>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <a href="<?= urladmin . "index.php?p=phuong-thuc-thanh-toan&a=man" ?>" class="btn btn-default"><span class="fa fa-mail-reply "></span> Quay lại</a>
                                <?php if ($d->checkPermission_edit($id_module) == 1) { ?>
                                    <button type="submit" name="capnhat" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-save"></span> Cập nhật</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div class="box box-primary">

        </div>
    </section>
</div>


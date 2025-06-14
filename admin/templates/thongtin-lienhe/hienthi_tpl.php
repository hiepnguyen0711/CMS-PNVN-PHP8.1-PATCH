<?php
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thông tin website - Liên hệ
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= urladmin ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="#">Quản trị giao diện</a></li>
            <li class="active">Thông tin website - Liên hệ</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <form name="frm" method="post" class=" form-horizontal" action="index.php?p=<?= $_GET['p'] ?>&a=save&id=<?= @$_REQUEST['id'] ?>" enctype="multipart/form-data">
                <div class="box-body">
                    <?php if (count(get_json('lang')) > 1) { ?>
                        <ul id="myTabs" class="nav nav-tabs" role="tablist">
                            <?php foreach (get_json('lang') as $key => $value) { ?>
                                <li role="presentation" <?php if ($key == 0) { ?>class="active" <?php } ?>>
                                    <a href="#<?= $value['code'] ?>" id="home-tab" role="tab" data-toggle="tab" aria-controls="<?= $value['code'] ?>" aria-expanded="true"><?= $value['name'] ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                    <div id="myTabContent" class="tab-content">
                        <?php foreach (get_json('lang') as $key => $value) {
                            $row = $d->simple_fetch("select * from #_thongtin where lang = '" . $value['code'] . "' ");
                        ?>
                            <div role="tabpanel" class="tab-pane fade <?php if ($key == 0) { ?> active in<?php } ?>" id="<?= $value['code'] ?>" aria-labelledby="<?= $value['code'] ?>">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3 class="box-title">Thông tin website</h3>
                                        <div class="form-group text-center">
                                            <div class="col-sm-6">
                                                <img src="../img_data/images/<?= $row['favicon'] ?>" id="review_favicon_<?= $value['code'] ?>" style="height: 100px; max-width: 100%; object-fit: contain;" />
                                                <input type="hidden" name="favicon[]" value="<?= $row['favicon'] ?>" id="favicon_<?= $value['code'] ?>">
                                                <a class="box-uploadimg iframe-btn" style="display: block;" href="filemanager/dialog.php?type=1&field_id=favicon_<?= $value['code'] ?>&relative_url=1&multiple=0">
                                                    <span><i class="fa fa-upload" aria-hidden="true"></i> Favicon</span>
                                                </a>
                                            </div>
                                            <div class="col-sm-6">
                                                <img src="../img_data/images/<?= $row['icon_share'] ?>" id="review_icon_share_<?= $value['code'] ?>" style="height: 100px;max-width: 100%;object-fit: contain;" />
                                                <input type="hidden" name="icon_share[]" value="<?= $row['icon_share'] ?>" id="icon_share_<?= $value['code'] ?>">
                                                <a class="box-uploadimg iframe-btn" href="filemanager/dialog.php?type=1&field_id=icon_share_<?= $value['code'] ?>&relative_url=1&multiple=0" style="display: block;">
                                                    <span><i class="fa fa-upload" aria-hidden="true"></i> Logo</span>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- hình quảng cáo share -->
                                        <div class="form-group text-center">
                                            <div class="col-sm-12">
                                                <img src="../img_data/images/<?= $row['banner_share'] ?>" id="review_banner_share_<?= $value['code'] ?>" style="height: 100px;max-width: 100%;object-fit: contain;" />
                                                <input type="hidden" name="banner_share[]" value="<?= $row['banner_share'] ?>" id="banner_share_<?= $value['code'] ?>">
                                                <a class="box-uploadimg iframe-btn" href="filemanager/dialog.php?type=1&field_id=banner_share_<?= $value['code'] ?>&relative_url=1&multiple=0" style="display: block;">
                                                    <span><i class="fa fa-upload" aria-hidden="true"></i> Banner Share</span>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- hình quảng cáo share end -->

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Địa chỉ website:</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Nhập địa chỉ website" name="website[]" class="form-control" value="<?= $row['website'] ?>">
                                            </div>
                                        </div>
                                        <div class=" form-group">
                                            <label class="col-sm-2 control-label">Copyright:</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Nhập copyright" name="coppy_right[]" class="form-control" value="<?= $row['coppy_right'] ?>">
                                            </div>
                                        </div>
                                        <h3 class="box-title">Thông tin doanh nghiệp</h3>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tên công ty:</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Nhập tên công ty" name="company[]" class="form-control" value="<?= $row['company'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Địa chỉ:</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Nhập địa chỉ công ty" name="address[]" class="form-control" value="<?= $row['address'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Hotline:</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Nhập hotline" name="hotline[]" class="form-control" value="<?= $row['hotline'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Giờ làm việc:</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Giờ làm việc" name="giolamviec[]" class="form-control" value="<?= $row['giolamviec'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" style="padding-top: 0px;">Số điện thoại khác:</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Nhập số điện thoại" name="dien_thoai[]" class="form-control" value="<?= $row['dien_thoai'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Email:</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Nhập email" name="email[]" class="form-control" value="<?= $row['email'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Bản đồ:</label>
                                            <div class="col-sm-10">
                                                <textarea name="map[]" class="form-control" rows="3"><?= $row['map'] ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <h3 class="box-title">Mạng xã hội</h3>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Lazada:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập link Lazada" name="lazada[]" class="form-control" value="<?= $row['lazada'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Shopee:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập link Shopee" name="shopee[]" class="form-control" value="<?= $row['shopee'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tiktok:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập link tiktok" name="tiktok[]" class="form-control" value="<?= $row['tiktok'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">zalo:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập số zalo" name="zalo[]" class="form-control" value="<?= $row['zalo'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">zalo (qr code):</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập qr code của zalo bạn, để dùng trên đt" name="zalo_qr[]" class="form-control" value="<?= $row['zalo_qr'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Messenger:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập id messenger" name="messenger[]" class="form-control" value="<?= $row['messenger'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Skype:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập id skype" name="skype[]" class="form-control" value="<?= $row['skype'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Facebook:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập đường dẫn trang cá nhân facebook" name="facebook[]" class="form-control" value="<?= $row['facebook'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Twitter:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập đường dẫn trang cá nhân Twitter" name="twitter[]" class="form-control" value="<?= $row['twitter'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">LinkedIn:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập đường dẫn trang cá nhân LinkedIn" name="linkedin[]" class="form-control" value="<?= $row['linkedin'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Youtube:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập đường dẫn kênh Youtube" name="youtube[]" class="form-control" value="<?= $row['youtube'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Pinterest:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập đường dẫn trang cá nhân Pinterest" name="pinterest[]" class="form-control" value="<?= $row['pinterest'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Instagram:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập đường dẫn trang cá nhân Instagram" name="instagram[]" class="form-control" value="<?= $row['instagram'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Telegram:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập đường dẫn kết nối Telegram" name="telegram[]" class="form-control" value="<?= $row['telegram'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Whats App:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập QR COde Mobile" name="whatsapp[]" class="form-control" value="<?= $row['whatsapp'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Reddit:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập link reddit của bạn" name="reddit[]" class="form-control" value="<?= $row['reddit'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Discord:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập link Discord của bạn ở đây" name="discord[]" class="form-control" value="<?= $row['discord'] ?>">
                                            </div>
                                        </div>
                                        <h3 class="box-title">Recaptcha</h3>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Site key:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập site key" name="site_key[]" class="form-control" value="<?= $row['site_key'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Secret key:</label>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nhập secret key" name="secret_key[]" class="form-control" value="<?= $row['secret_key'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($d->checkPermission_edit($id_module) == 1) { ?>
                        <div class="form-group">
                            <div class=" text-center">
                                <button type="submit" name="capnhat" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span> Cập nhật</button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </form>
        </div>
    </section>
</div>
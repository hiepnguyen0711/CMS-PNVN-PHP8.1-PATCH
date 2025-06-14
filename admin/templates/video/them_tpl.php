<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Video <small>[<?php if (isset($_GET['id'])) echo "Sửa ";
                            else echo "Thêm mới" ?>]</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= urladmin ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="#">Quản trị danh mục</a></li>
            <li class="active">Video</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <form name="frm" method="post" class=" form-horizontal" action="index.php?p=<?= $_GET['p'] ?>&a=save&id=<?= @$_REQUEST['id'] ?>&page=<?= @$_REQUEST['page'] ?>&loaitin=<?= @$_GET['loaitin'] ?>" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-9">
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
                                    if (isset($_GET['id'])) {
                                        $row = $d->simple_fetch("select * from #_video where id_code = " . (int)$_GET['id'] . " and lang = '" . $value['code'] . "' ");
                                    }
                                ?>
                                    <?php if (isset($_GET['id'])) { ?>
                                        <input type="hidden" name="id_row[]" value="<?= $row['id'] ?>" />
                                    <?php } ?>
                                    <div role="tabpanel" class="tab-pane fade <?php if ($key == 0) { ?> active in<?php } ?>" id="<?= $value['code'] ?>" aria-labelledby="<?= $value['code'] ?>">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tên video (<?= $value['code'] ?>):</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" placeholder="Nhập tên video" OnkeyUp="addText(this,'#alias_<?= $value['code'] ?>','#title_<?= $value['code'] ?>')" name="ten[]" value="<?= $row['ten'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Đường dẫn (<?= $value['code'] ?>):</label>
                                            <div class="col-sm-5">
                                                <input type="text" placeholder="Nhập đường dẫn" class="form-control" name="alias[]" id="alias_<?= $value['code'] ?>" value="<?= $row['alias'] ?>" OnkeyUp="addText(this,'#alias')">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Nội dung (<?= $value['code'] ?>):</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="noi_dung[]" id="noi_dung_<?= $value['code'] ?>" rows="3"><?= $row['noi_dung'] ?></textarea>
                                                <script>
                                                    CKEDITOR.replace('noi_dung_<?= $value['code'] ?>', {
                                                        filebrowserBrowseUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                        filebrowserUploadUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                        filebrowserImageBrowseUrl: 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <hr>
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <button type="button" class="btn btn-default"><span class="fa fa-mail-reply "></span> Quay lại</button>
                                        <?php if ($d->checkPermission_edit($id_module) == 1) { ?>
                                            <button type="submit" name="capnhat" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-save"></span> Cập nhật</button>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <h3 class="box-title">Thông tin chung</h3>
                            <div class="form-group m0 hinh_anh">
                                <label>Hình ảnh:</label>
                                <span class="box-img2">
                                    <?php if (isset($_GET['id']) and $row['hinh_anh'] != '') { ?>
                                        <img src="../img_data/images/<?php echo $row['hinh_anh'] ?>" id="review_hinh_anh" alt="NO PHOTO" />
                                        <button class="btn btn-xs btn-danger" type="button" onclick="xoa_img('_video','hinh_anh', '<?= $_GET['id'] ?>','')"><i class="fa fa-trash"></i></button>
                                    <?php } else { ?>
                                        <img src="img/no-image.png" style="max-width: 100%;max-height: 100%;object-fit: contain;" id="review_hinh_anh" alt="NO PHOTO" />
                                    <?php } ?>
                                    <input type="hidden" value="<?= $row['hinh_anh'] ?>" name="hinh_anh" id="hinh_anh" class=" form-control img-preview-hidden" data-target="#review_hinh_anh">
                                    <a href="filemanager/dialog.php?type=1&field_id=hinh_anh&relative_url=1&multiple=0" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn hình ảnh</a>
                                </span>
                            </div>
                            <div class="form-group m0 hinh_anh">
                                <label>Video:</label>
                                <span class="box-img2">
                                    <?php if (isset($_GET['id']) and $row['video'] != '') { ?>
                                        <video controls style="width: 100%;height: 100%;">
                                            <source src="../img_data/images/<?= $row['video'] ?>" type="video/mp4">
                                        </video>
                                        <button class="btn btn-xs btn-danger" type="button" onclick="xoa_img('_video','video', '<?= $_GET['id'] ?>','')"><i class="fa fa-trash"></i></button>
                                    <?php } else { ?>
                                    <?php } ?>
                                    <input type="hidden" value="<?= $row['video'] ?>" name="video" id="video" class=" form-control">
                                    <a href="filemanager/dialog.php?type=3&field_id=video&relative_url=1&multiple=0" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn video</a>
                                </span>
                            </div>

                            <div class="form-group m0">
                                <label>Danh mục:</label>
                                <select name="id_loai" class="form-control select2">
                                    <option value="0">Chọn làm mục cha</option>
                                    <?= $loai ?>
                                </select>
                            </div>
                            <iframe style="width: 100%;margin-bottom: 10px;" id="if_video" height="200" src="https://www.youtube.com/embed/<?php if (isset($_GET['id'])) {
                                                                                                                                                echo $row['ma_video'];
                                                                                                                                            } ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <div class="form-group m0">
                                <label>Mã Video: <span style="font-weight: 400;color: red;font-style: italic;font-size: 14px;">https://www.youtube.com/watch?v={Mã video}</span></label>
                                <input type="text" placeholder="Nhập mã video" class="form-control" onchange="$('#if_video').attr('src', 'https://www.youtube.com/embed/'+$(this).val())" name="ma_video" value="<?= $row['ma_video'] ?>">
                            </div>
                            <div class="form-group m0">
                                <label>Số thứ tự:</label>
                                <input type="number" placeholder="Nhập số thứ tự" class="form-control" name="so_thu_tu" id="so_thu_tu" value="<?= $row['so_thu_tu'] ?>">
                            </div>
                            <div class="form-group m0">
                                <div class="">
                                    <label>
                                        <input name="hien_thi" <?php if (isset($items[0]['hien_thi'])) {
                                                                    if (@$items[0]['hien_thi'] == 1) echo 'checked="checked"';
                                                                } else echo 'checked="checked"'; ?> type="checkbox"> Hiển thị
                                    </label>
                                </div>
                            </div>
                            <h3 class="box-title">Cấu hình SEO</h3>
                            <?php if (count(get_json('lang')) > 1) { ?>
                                <ul id="myTabs" class="nav nav-tabs" role="tablist">
                                    <?php foreach (get_json('lang') as $key => $value) { ?>
                                        <li role="presentation" <?php if ($key == 0) { ?>class="active" <?php } ?>>
                                            <a href="#seo_<?= $value['code'] ?>" id="home-tab" role="tab" data-toggle="tab" aria-controls="seo_<?= $value['code'] ?>" aria-expanded="true"><?= $value['name'] ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                            <div id="myTabContent" class="tab-content">
                                <?php foreach (get_json('lang') as $key => $value) {
                                    if (isset($_GET['id'])) {
                                        $row = $d->simple_fetch("select * from #_video where id_code = " . (int)$_GET['id'] . " and lang = '" . $value['code'] . "' ");
                                    }
                                ?>
                                    <div role="tabpanel" class="tab-pane fade <?php if ($key == 0) { ?> active in<?php } ?>" id="seo_<?= $value['code'] ?>" aria-labelledby="seo_<?= $value['code'] ?>">
                                        <div class="form-group m0">
                                            <label>Title (<?= $value['code'] ?>):</label>
                                            <input type="text" placeholder="Nhập title" id="title_<?= $value['code'] ?>" class="form-control" name="title[]" id="title_<?= $value['code'] ?>" value="<?php echo $row['title'] ?>">
                                        </div>
                                        <div class="form-group m0">
                                            <label>Keyword (<?= $value['code'] ?>):</label>
                                            <textarea placeholder="Nhập từ khóa" class="form-control" rows="3" name="keyword[]"><?= $row['keyword'] ?></textarea>
                                        </div>
                                        <div class="form-group m0">
                                            <label>Description (<?= $value['code'] ?>):</label>
                                            <textarea placeholder="Nhập Description" class="form-control" rows="3" name="des[]"><?= $row['des'] ?></textarea>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
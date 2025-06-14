<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            DANH MỤC <small>[<?php if (isset($_GET['id'])) echo "Sửa ";
                                else echo "Thêm mới" ?>]</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= urladmin ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="#">Quản trị danh mục</a></li>
            <li class="active">Danh mục</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <form name="frm" method="post" class=" form-horizontal" action="index.php?p=<?= $_REQUEST['p'] ?>&a=save&id=<?= @$_REQUEST['id'] ?>&page=<?= @$_REQUEST['page'] ?>&loaitin=<?= @$_GET['loaitin'] ?><?php if (isset($_GET['template'])) { ?>&template=<?= @$_GET['template'] ?><?php } ?>" enctype="multipart/form-data">
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
                                        $row = $d->simple_fetch("select * from #_category where id_code = " . (int)$_GET['id'] . " and lang = '" . $value['code'] . "' ");
                                    }
                                ?>
                                    <?php if (isset($_GET['id'])) { ?>
                                        <input type="hidden" name="id_row[]" value="<?= $row['id'] ?>" />
                                    <?php } ?>
                                    <div role="tabpanel" class="tab-pane fade <?php if ($key == 0) { ?> active in<?php } ?>" id="<?= $value['code'] ?>" aria-labelledby="<?= $value['code'] ?>">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tên Danh mục <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-8">
                                                <input type="text" require class="form-control" placeholder="Nhập tên danh mục" <?php if (!isset($_GET['id'])) { ?>OnkeyUp="addText(this,'#alias_<?= $value['code'] ?>','#title_<?= $value['code'] ?>')" <?php } else { ?>OnkeyUp="addText(this,'','#title_<?= $value['code'] ?>')" <?php } ?> id="ten_<?= $value['code'] ?>" name="ten[]" value="<?php echo $row['ten'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Đường dẫn <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?> :</label>
                                            <div class="col-sm-3" style="position: relative;">
                                                <input type="text" placeholder="" class="form-control" name="slug[]" id="slug_<?= $value['code'] ?>" value="<?php echo $row['slug'] ?>" OnkeyUp="addText(this,'#slug_<?= $value['code'] ?>')">
                                                <span style="position: absolute;right: -5px;top: 7px;color: #8b8989;font-size: 20px;">/</span>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text" placeholder="Nhập đường dẫn" class="form-control" name="alias[]" id="alias_<?= $value['code'] ?>" value="<?php echo $row['alias'] ?>" OnkeyUp="addText(this,'#alias_<?= $value['code'] ?>')">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Đường dẫn khác <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="Nhập url" id="url_<?= $value['code'] ?>" name="url[]" value="<?php echo $row['url'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Mô tả <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="mo_ta[]" id="mo_ta_<?= $value['code'] ?>" rows="3"><?php echo $row['mo_ta'] ?></textarea>

                                            </div>
                                        </div>
                                        <script>
                                            CKEDITOR.replace('mo_ta_<?= $value['code'] ?>', {
                                                filebrowserBrowseUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                filebrowserUploadUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                filebrowserImageBrowseUrl: 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='
                                            });
                                        </script>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Nội dung <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="noi_dung[]" id="noi_dung<?= $value['code'] ?>" rows="3"><?php echo $row['noi_dung'] ?></textarea>

                                            </div>
                                        </div>
                                        <script>
                                            CKEDITOR.replace('noi_dung<?= $value['code'] ?>', {
                                                filebrowserBrowseUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                filebrowserUploadUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                filebrowserImageBrowseUrl: 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='
                                            });
                                        </script>
                                        <h3 class="box-title" style="margin-top: 20px;">Cấu hình SEO</h3>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Title <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Nhập title" id="title_<?= $value['code'] ?>" class="form-control" name="title[]" id="title_<?= $value['code'] ?>" value="<?php echo $row['title'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Keyword <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-10">
                                                <textarea placeholder="Nhập từ khóa" class="form-control" rows="3" name="keyword[]"><?= $row['keyword'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Description <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-10">
                                                <textarea placeholder="Nhập Description" class="form-control" rows="3" name="des[]"><?= $row['des'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">HTML header<br><span style="color: #ff4b49;font-weight: 400;"><?= htmlentities('<head>...</head>') ?></span> </label>
                                            <div class="col-sm-10">
                                                <textarea id="code2" placeholder="HTML - javascript chèn trước thẻ </head>" class="form-control" rows="3" name="seo_head[]"><?= $row['seo_head'] ?></textarea>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">HTML footer <br><span style="color: #ff4b49;font-weight: 400;"><?= htmlentities('<body>...</body>') ?></span> </label>
                                            <div class="col-sm-10">
                                                <textarea placeholder="HTML - javascript chèn trước thẻ </body>" id="code" class="form-control" rows="3" name="seo_body[]"><?= $row['seo_body'] ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
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
                        <div class="col-md-3">
                            <h3 class="box-title">Thông tin chung</h3>
                            <div class="row">

                                <div class="form-group m0 icon">
                                    <label>Icon:</label>
                                    <span class="box-img2">
                                        <?php if (isset($_GET['id']) and $row['icon'] != '') { ?>
                                            <img src="../img_data/images/<?php echo $row['icon'] ?>" id="review_icon" alt="NO PHOTO" />
                                            <button class="btn btn-xs btn-danger" type="button" onclick="xoa_img('_category','icon', '<?= $_GET['id'] ?>','')"><i class="fa fa-trash"></i></button>
                                        <?php } else { ?>
                                            <img src="img/no-image.png" style="max-width: 100%;max-height: 100%;object-fit: contain;" id="review_icon" alt="NO PHOTO" />
                                        <?php } ?>
                                        <input type="hidden" value="<?= $row['icon'] ?>" name="icon" id="icon" class="form-control img-preview-hidden" data-target="#review_icon">
                                        <a href="filemanager/dialog.php?type=1&field_id=icon&relative_url=1&multiple=0" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn icon</a>
                                    </span>
                                </div>

                                <div class="form-group m0 hinh_anh">
                                    <label>Hình ảnh:</label>
                                    <span class="box-img2">
                                        <?php if (isset($_GET['id']) and $row['hinh_anh'] != '') { ?>
                                            <img src="../img_data/images/<?php echo $row['hinh_anh'] ?>" id="review_hinh_anh" alt="NO PHOTO" />
                                            <button class="btn btn-xs btn-danger" type="button" onclick="xoa_img('_category','hinh_anh', '<?= $_GET['id'] ?>','')"><i class="fa fa-trash"></i></button>
                                        <?php } else { ?>
                                            <img src="img/no-image.png" style="max-width: 100%;max-height: 100%;object-fit: contain;" id="review_hinh_anh" alt="NO PHOTO" />
                                        <?php } ?>
                                        <input type="hidden" value="<?= $row['hinh_anh'] ?>" name="hinh_anh" id="hinh_anh" class="form-control img-preview-hidden" data-target="#review_hinh_anh">
                                        <a href="filemanager/dialog.php?type=1&field_id=hinh_anh&relative_url=1&multiple=0" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn hình ảnh</a>
                                    </span>
                                </div>
                                <div class="form-group m0 banner">
                                    <label>Banner:</label>
                                    <span class="box-img2">
                                        <?php if (isset($_GET['id']) and $row['banner'] != '') { ?>
                                            <img src="../img_data/images/<?php echo $row['banner'] ?>" id="review_banner" alt="NO PHOTO" />
                                            <button class="btn btn-xs btn-danger" type="button" onclick="xoa_img('_category','banner', '<?= $_GET['id'] ?>','')"><i class="fa fa-trash"></i></button>
                                        <?php } else { ?>
                                            <img src="img/no-image.png" style="max-width: 100%;max-height: 100%;object-fit: contain;" id="review_banner" alt="NO PHOTO" />
                                        <?php } ?>
                                        <input type="hidden" value="<?= $row['banner'] ?>" name="banner" id="banner" class="form-control img-preview-hidden" data-target="#review_banner">
                                        <a href="filemanager/dialog.php?type=1&field_id=banner&relative_url=1&multiple=0" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn hình ảnh</a>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group m0">
                                <label>Danh mục:</label>
                                <select name="id_loai" class="form-control select2">
                                    <option value="0">Chọn làm mục cha</option>
                                    <?= $loaibv ?>
                                </select>
                            </div>
                            <div class="form-group m0">
                                <label>Module:</label>
                                <select name="module" class="form-control">
                                    <?php if (count($module) > 0) {
                                        foreach ($module as $item) { ?>
                                            <option value="<?php echo $item['id'] ?>" <?php if ($item['id'] == $items[0]['module']) echo "selected"; ?>><?php echo $item['title'] ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                            <?php /* <div class="form-group m0">
                                <?php
                                $row_tangkem = $d->o_fet("select * from #_sanpham where lang ='" . LANG . "'  and id_loai=27 order by so_thu_tu asc, cap_nhat desc, id desc");
                                ?>
                                <label>Quà tặng kèm: </label>
                                <select class=" form-control select2" multiple name="qua_tang[]">
                                    <option value="">Chọn quà tặng kèm</option>
                                    <?php foreach ($row_tangkem as $key => $value) { ?>
                                        <option <?php if (strlen(strstr($row['qua_tang'], ',' . $value['id_code'] . ',')) > 0) {
                                                    echo "selected";
                                                } ?> value="<?= $value['id_code'] ?>"><?= $value['ten'] ?></option>
                                    <?php } ?>
                                </select>
                            </div> */ ?>
                            <div class="form-group m0">
                                <label>Số thứ tự:</label>
                                <input type="number" placeholder="Nhập số thứ tự" class="form-control" name="so_thu_tu" id="so_thu_tu" value="<?php echo $row['so_thu_tu'] ?>">
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
                            <div class="form-group m0">
                                <div class="">
                                    <label class="checkbox-inline">
                                        <input name="nofollow" <?php if ($row['nofollow'] == 1) echo 'checked="checked"'; ?> type="checkbox"> Nofollow
                                    </label>
                                    <label class="checkbox-inline">
                                        <input name="noindex" <?php if ($row['noindex'] == 1) echo 'checked="checked"'; ?> type="checkbox"> Noindex
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
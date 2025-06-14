<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Bài viết <small>[<?php if (isset($_GET['id'])) echo "Sửa ";
                                else echo "Thêm mới" ?>]</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= urladmin ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="#">Quản trị danh mục</a></li>
            <li class="active">Bài viết</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <form name="frm" method="post" class=" form-horizontal" action="index.php?p=<?= $_GET['p'] ?>&a=save&id=<?= @$_REQUEST['id'] ?><?= $link_option ?>" enctype="multipart/form-data">
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
                                        $row = $d->simple_fetch("select * from #_hotrotructuyen where id_code = " . (int)$_GET['id'] . " and lang = '" . $value['code'] . "' ");
                                    }
                                ?>
                                    <?php if (isset($_GET['id'])) { ?>
                                        <input type="hidden" name="id_row[]" value="<?= $row['id'] ?>" />
                                    <?php } ?>
                                    <div role="tabpanel" class="tab-pane fade <?php if ($key == 0) { ?> active in<?php } ?>" id="<?= $value['code'] ?>" aria-labelledby="<?= $value['code'] ?>">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tên bài viết <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="Nhập tên bài viết" <?php if (!isset($_GET['id'])) { ?>OnkeyUp="addText(this,'#alias_<?= $value['code'] ?>','#title_<?= $value['code'] ?>')" <?php } else { ?>OnkeyUp="addText(this,'','#title_<?= $value['code'] ?>')" <?php } ?> name="ten[]" value="<?= $row['ten'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Email <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="Nhập email" name="email" value="<?= $row['email'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Điện thoại <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="Nhập số điện thoại" name="dienthoai" value="<?= $row['dienthoai'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Messenger <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="Messenger" name="mess" value="<?= $row['mess'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Zalo <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="Nhập số Zalo" name="zalo" value="<?= $row['zalo'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Skype <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="Nhập số điện Skype" name="skype" value="<?= $row['skype'] ?>">
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
                                        <button class="btn btn-xs btn-danger" type="button" onclick="xoa_img('_sanpham','hinh_anh', '<?= $_GET['id'] ?>','')"><i class="fa fa-trash"></i></button>
                                    <?php } else { ?>
                                        <img src="img/no-image.png" style="max-width: 100%;max-height: 100%;object-fit: contain;" id="review_hinh_anh" alt="NO PHOTO" />
                                    <?php } ?>
                                    <input type="hidden" value="<?= $row['hinh_anh'] ?>" name="hinh_anh" id="hinh_anh" class="form-control img-preview-hidden" data-target="#review_hinh_anh">
                                    <a href="filemanager/dialog.php?type=1&field_id=hinh_anh&relative_url=1&multiple=0" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn hình ảnh</a>
                                </span>
                            </div>

                            <?php if (get_json('posts', 'video') == 1) { ?>
                                <iframe style="width: 100%;margin-bottom: 10px;" id="if_video" height="200" src="https://www.youtube.com/embed/<?php if (isset($_GET['id'])) {
                                                                                                                                                } ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <div class="form-group m0">
                                    <label>Mã Video: <span style="font-weight: 400;color: red;font-style: italic;font-size: 14px;">https://www.youtube.com/watch?v={Mã video}</span></label>
                                    <input type="text" placeholder="Nhập mã video" class="form-control" onchange="$('#if_video').attr('src', 'https://www.youtube.com/embed/'+$(this).val())" name="ma_video" value="<?= $row['video'] ?>">
                                </div>
                            <?php } ?>
                            <?php if (get_json('posts', 'file') == 1) { ?>
                                <?php if (isset($_GET['id'])) {
                                    if ($row['file'] != '') {
                                        $link = URLPATH . 'uploads/files/' . $row['file'];
                                    } elseif ($row['link_khac'] != '') {
                                        $link =  $row['link_khac'];
                                    } else {
                                        $link = '';
                                    }
                                ?>
                                    <?php if ($link != '') { ?>
                                        <div class="form-group m0 hinh_anh">
                                            <iframe class="iframe" src="http://docs.google.com/gview?url=<?= $link ?>&embedded=true" style="height: 200px;width: 100%;" frameborder="0"></iframe>
                                        </div>
                                <?php }
                                } ?>
                                <div class="form-group m0">
                                    <label>Upload file:</label>
                                    <input type="file" name="file_download" class="form-control">
                                </div>
                                <div class="form-group m0">
                                    <label>Đường dẫn file khác:</label>
                                    <div class="row m-5">
                                        <div class="col-sm-9 p5">
                                            <input type="text" placeholder="Nhập đường dẫn file" class="form-control" name="link_khac" value="<?= $row['link_khac'] ?>">
                                        </div>
                                        <div class="col-sm-3 p5">
                                            <select class=" form-control" name="loai_file">
                                                <option <?= $row['loai_file'] == 'pdf' ? 'selected' : '' ?> value="pdf">PDF</option>
                                                <option <?= $row['loai_file'] == 'docx' ? 'selected' : '' ?> value="docx">WORD</option>
                                                <option <?= $row['loai_file'] == 'xlsx' ? 'selected' : '' ?> value="xlsx">EXCEL</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php $sanpham_kem =  $d->o_fet("SELECT * FROM `db_sanpham` WHERE hien_thi = 1 and lang = 'vi'"); ?>
                            <?php /* <div class="form-group m0">
                                <label>Sản phẩm đính kèm:</label>
                                <select class=" form-control select2" multiple name="sanpham_kem[]">
                                    <?php foreach ($sanpham_kem as $key => $value) {?>
                                    <option <?php if (strlen(strstr($row['sanpham_kem'], ','.$value['id_code'].',')) > 0) {echo "selected";}?> value="<?=$value['id_code']?>"><?=$value['ten']?></option>
                                    <?php } ?>
                                </select>
                            </div> */ ?>
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
                            <?php /* <div class="form-group m0">
                                <div class="checkbox">
                                    <label class="checkbox-inline">
                                        <input name="nofollow" <?php if ($row['nofollow'] == 1) echo 'checked="checked"'; ?> type="checkbox"> Nofollow
                                    </label>
                                    <label class="checkbox-inline">
                                        <input name="noindex" <?php if ($row['noindex'] == 1) echo 'checked="checked"'; ?> type="checkbox"> Noindex
                                    </label>
                                </div>
                            </div> */ ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<script>
    function trim(string, char) {
        if (!char) char = ' '; //space by default
        char = char.replace(/([()[{*+.$^\\|?])/g, '\\$1'); //escape char parameter if needed for regex syntax.
        var regex_1 = new RegExp("^" + char + "+", "g");
        var regex_2 = new RegExp(char + "+$", "g");
        return string.replace(regex_1, '').replace(regex_2, '');
    }

    function chen_tags(tags, lang, _this) {
        if (_this.hasClass('active')) {
            var input = $('#tags_' + lang).val();
            var txt = input.replace(tags, '');
            var txt2 = txt.replace(',,', ',');
            txt2.trim();
            $('#tags_' + lang).val(trim(txt2, ', '));
            _this.removeClass('active');
        } else {
            var input = $('#tags_' + lang).val();
            if (input === '') {
                var txt = tags;
            } else {
                txt = input + ', ' + tags;
            }
            $('#tags_' + lang).val(txt);
            _this.addClass('active');
        }

    }
</script>
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
                                        $row = $d->simple_fetch("select * from #_tintuc where id_code = " . (int)$_GET['id'] . " and lang = '" . $value['code'] . "' ");
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
                                            <label class="col-sm-2 control-label">Đường dẫn <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-3" style="position: relative;">
                                                <input type="text" placeholder="" class="form-control" name="slug[]" id="slug_<?= $value['code'] ?>" value="<?php echo $row['slug'] ?>" OnkeyUp="addText(this,'#slug_<?= $value['code'] ?>')">
                                                <span style="position: absolute;right: -5px;top: 7px;color: #8b8989;font-size: 20px;">/</span>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text" placeholder="Nhập đường dẫn" class="form-control" name="alias[]" id="alias_<?= $value['code'] ?>" value="<?= $row['alias'] ?>" OnkeyUp="addText(this,'#alias_<?= $value['code'] ?>')">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Mô tả <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="mo_ta[]" rows="3"><?= $row['mo_ta'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Nội dung <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="noi_dung[]" id="noi_dung_<?= $value['code'] ?>" rows="3"><?= $row['noi_dung'] ?></textarea>

                                            </div>
                                            <script>
                                                CKEDITOR.replace('noi_dung_<?= $value['code'] ?>', {
                                                    filebrowserBrowseUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                    filebrowserUploadUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                    filebrowserImageBrowseUrl: 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='
                                                });
                                            </script>
                                        </div>
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
                                        <div class="form-group m0">
                                            <label class="col-sm-2 control-label">Tags (<?= $value['code'] ?>):</label>
                                            <div class="col-sm-10">
                                                <input id="tags_<?= $value['code'] ?>" type="text" placeholder="tags 1, tags 2, ..." class="form-control" name="tags_hienthi[]" value="<?php echo $row['tags_hienthi'] ?>">
                                            </div>
                                        </div>
                                        <?php $row_tags = $d->o_fet("select ten, id from #_tags where lang='" . $value['code'] . "'"); ?>
                                        <div class="form-group m0 list-tags">
                                            <label class="col-sm-2 control-label">Danh sách tags: </label>
                                            <div class="col-sm-10">
                                                <?php foreach ($row_tags as $key2 => $value_tang) {
                                                    $dem = $d->num_rows("select * from #_tintuc where tags_hienthi like '%" . $value_tang['ten'] . "%' $where_lang ");
                                                ?>
                                                    <a href="javascript:void(0)" class="" onclick="chen_tags('<?= $value_tang['ten'] ?>','<?= $value['code'] ?>',$(this))"><?= $value_tang['ten'] ?> (<?= $dem ?>)</a>
                                                <?php } ?>
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
                                    <?php if (isset($_GET['id']) and $items[0]['hinh_anh'] != '') { ?>
                                        <img src="../img_data/images/<?php echo $items[0]['hinh_anh'] ?>" id="review_hinh_anh" alt="NO PHOTO" />
                                        <button class="btn btn-xs btn-danger" type="button" onclick="xoa_img('_tintuc','hinh_anh', '<?= $_GET['id'] ?>','')"><i class="fa fa-trash"></i></button>
                                    <?php } else { ?>
                                        <img src="img/no-image.png" style="max-width: 100%;max-height: 100%;object-fit: contain;" id="review_hinh_anh" alt="NO PHOTO" />
                                    <?php } ?>
                                    <input type="hidden" value="<?= $items[0]['hinh_anh'] ?>" name="hinh_anh" id="hinh_anh" class="form-control img-preview-hidden" data-target="#review_hinh_anh">
                                    <a href="filemanager/dialog.php?type=1&field_id=hinh_anh&relative_url=1&multiple=0" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn hình ảnh</a>
                                </span>
                            </div>

                            <!-- Album hình start -->
                            <?php
                            // Lấy thông tin album ảnh

                            ?>
                            <div id="album_anh">
                                <label>Album ảnh:</label>
                                <div class="container-slide" id="container-slide-images" style="max-height: 890px;overflow: auto;">

                                    <?php
                                    $slide_hinh_anh = [];
                                    if ($_GET['id']) {
                                        $slide_hinh_anh  = $d->o_fet("select * from #_tintuc_hinhanh where id_tintuc = {$_GET['id']} order by stt asc, id desc");
                                    }
                                    ?>
                                    <?php foreach ($slide_hinh_anh as $key => $item) { ?>

                                        <div class="images-slide-item" id="slide-item-<?= $key ?>">
                                            <div class="img-container">
                                                <img id="album_preview_<?= $key ?>" src="<?= URLPATH . "img_data/images/" . $item['hinh_anh'] ?>" alt="<?= $item['hinh_anh'] ?>">
                                                <a href="filemanager/dialog.php?type=1&field_id=album_<?= $key ?>&relative_url=1&multiple=0" class="iframe-btn">
                                                    Đổi hình
                                                </a>
                                                <a href="javascript:deleteElement('#slide-item-<?= $key ?>');" class="delete">x</a>
                                                <input type="number" class="form-control number-input" name="album_stt[]" value="<?= $item['stt'] ?>">
                                            </div>
                                            <input class="img-preview-hidden" type="hidden" id="album_<?= $key ?>" name="album[]" data-target="#album_preview_<?= $key ?>" value="<?= $item['hinh_anh'] ?>">
                                        </div>

                                    <?php } ?>

                                </div>
                                <input type="hidden" id="album" class="form-control filemanager-input-multiple-images" data-el-container="#container-slide-images" data-prefix="album" />
                                <a href="filemanager/dialog.php?type=1&field_id=album&relative_url=1&multiple=1" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn hình ảnh</a>

                            </div>
                            <!-- Album hình end -->

                            <div class="form-group m0">
                                <label>Danh mục:</label>
                                <select name="id_loai" class="form-control select2">
                                    <option value="0">Chọn làm mục cha</option>
                                    <?= $loai ?>
                                </select>
                            </div>
                            <?php if (get_json('posts', 'video') == 1) { ?>
                                <iframe style="width: 100%;margin-bottom: 10px;" id="if_video" height="200" src="https://www.youtube.com/embed/<?php if (isset($_GET['id'])) {
                                                                                                                                                    echo $row['video'];
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
                            <?php /* $sanpham_kem =  $d->o_fet("SELECT * FROM `db_sanpham` WHERE hien_thi = 1 and lang = 'vi'"); ?>
                            <div class="form-group m0">
                                <label>Sản phẩm đính kèm:</label>
                                <select class=" form-control select2" multiple name="sanpham_kem[]">
                                    <?php foreach ($sanpham_kem as $key => $value) { ?>
                                        <option <?php if (strlen(strstr($row['sanpham_kem'], ',' . $value['id_code'] . ',')) > 0) {
                                                    echo "selected";
                                                } ?> value="<?= $value['id_code'] ?>"><?= $value['ten'] ?></option>
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
                            <div class="form-group m0">
                                <div class="checkbox">
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


<!-- Abum hình start -->
<script>
    $(document).ready(function() {
        updateSlide();
    });

    var totalLenghtImages = Number("<?= count($slide_hinh_anh) ?>");

    function updateSlide() {
        $("input.filemanager-input-multiple-images").unbind("change"); // reset event

        $("input.filemanager-input-multiple-images").change(function() {

            try {
                var value = JSON.parse($(this).val());
            } catch (error) {
                var value = JSON.parse("[\"" + $(this).val() + "\"]");
            }

            var elContainer = $(this).data("el-container");
            var prefix = $(this).data("prefix");

            var result_html = "";
            for (let index = 0; index < value.length; index++) {
                const element = value[index];
                result_html += get_single_slide_item(totalLenghtImages + index, element, Number(totalLenghtImages + index + 1), prefix);
            }
            totalLenghtImages += value.length;
            $(elContainer).append(result_html);

            jqueryUpdate();

        });
    }

    function get_single_slide_item(index, value, stt, idName) {
        var str_html = '\
        <div class="images-slide-item" id="slide-item-' + index + '">\
            <div class="img-container">\
                <img id="' + idName + '_preview_' + index + '" src="<?= URLPATH . "img_data/images/" ?>' + value + '" alt="' + value + '">\
                <a href="filemanager/dialog.php?type=1&field_id=' + idName + '_' + index + '&relative_url=1&multiple=0" class="iframe-btn">\
                    Đổi hình\
                </a>\
                <a href="javascript:deleteElement(\'#slide-item-' + index + '\');" class="delete">x</a>\
                <input type="number" class="form-control number-input" name="' + idName + '_stt[]" value="' + stt + '">\
            </div>\
            <input class="img-preview-hidden" type="hidden" id="' + idName + '_' + index + '" name="' + idName + '[]" data-target="#' + idName + '_preview_' + index + '" value="' + value + '">\
        </div>\
            ';
        return str_html;
    }
</script>
<!-- Album hình end -->
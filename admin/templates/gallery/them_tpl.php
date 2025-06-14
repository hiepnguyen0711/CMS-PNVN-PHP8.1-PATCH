<?php
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ALBUM ẢNH <small>[<?php if (isset($_GET['id'])) echo "Sửa ";
                                else echo "Thêm mới" ?>]</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= urladmin ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="#">Quản trị danh mục</a></li>
            <li class="active">Album Ảnh</li>
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
                                        $row = $d->simple_fetch("select * from #_album where id_code = " . (int)$_GET['id'] . " and lang = '" . $value['code'] . "' ");
                                    }
                                ?>
                                    <?php if (isset($_GET['id'])) { ?>
                                        <input type="hidden" name="id_row[]" value="<?= $row['id'] ?>" />
                                    <?php } ?>
                                    <div role="tabpanel" class="tab-pane fade in <?php if ($key == 0) { ?> active <?php } ?>" id="<?= $value['code'] ?>" aria-labelledby="<?= $value['code'] ?>">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tên album (<?= $value['code'] ?>):</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" placeholder="Nhập tên album" OnkeyUp="addText(this,'#alias_<?= $value['code'] ?>','#title_<?= $value['code'] ?>')" name="ten[]" value="<?= $row['ten'] ?>">
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
                            <!--h3 class="box-title">Thông tin chung</h3-->
                            <ul id="myTabs" class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#thongtinsp" role="tab" data-toggle="tab" aria-controls="thongtinsp" aria-expanded="true">Thông tin</a>
                                </li>
                                <li role="presentation">
                                    <a href="#album_anh" role="tab" data-toggle="tab" aria-controls="album_anh" aria-expanded="true">Album hình</a>
                                </li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="thongtinsp" aria-labelledby="thongtinsp">
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
                                    <!--div class="form-group m0">
                                        <div class="checkbox">
                                            <label>
                                                <input name="resize" checked type="checkbox"> Resize hình ảnh
                                            </label>
                                        </div>
                                    </div-->
                                    <div class="form-group m0">
                                        <label>Danh mục:</label>
                                        <select name="id_loai" class="form-control select2">
                                            <option value="0">Chọn danh mục</option>
                                            <?= $loai ?>
                                        </select>
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
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="album_anh">

                                    <div class="container-slide" id="container-slide-images" style="max-height: 890px;overflow: auto;">

                                        <?php
                                        $slide_hinh_anh = [];
                                        if ($_GET['id']) {
                                            $slide_hinh_anh  = $d->o_fet("select * from #_album_hinhanh where id_album = {$_GET['id']} order by stt asc, id desc");
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
                                                    <input type="number" class="form-control number-input" name="album_slide_stt[]" value="<?= $item['stt'] ?>">
                                                </div>
                                                <input class="img-preview-hidden" type="hidden" id="album_<?= $key ?>" name="album[]" data-target="#album_preview_<?= $key ?>" value="<?= $item['hinh_anh'] ?>">
                                            </div>

                                        <?php } ?>

                                    </div>

                                    <input type="hidden" id="album" class="form-control filemanager-input-multiple-images" data-el-container="#container-slide-images" data-prefix="album" />
                                    <a href="filemanager/dialog.php?type=1&field_id=album&relative_url=1&multiple=1" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn hình ảnh</a>

                                </div>
                            </div>

                            <h3 class="box-title" style="margin-top: 20px;">Cấu hình SEO</h3>
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
                                        $row = $d->simple_fetch("select * from #_album where id_code = " . (int)$_GET['id'] . " and lang = '" . $value['code'] . "' ");
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
<script>
    function formatNumber(nStr, decSeperate, groupSeperate) {
        nStr += '';
        x = nStr.split(decSeperate);
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + groupSeperate + '$2');
        }
        return x1 + x2;
    };

    function xoa_hinh_sp(id) {
        if (!confirm('Xác nhận xóa?')) return false;
        $.ajax({
            url: "./sources/ajax.php",
            type: 'POST',
            data: "id=" + id + "&do=xoa_anh_sp",
            success: function() {
                $("#album_" + id).remove();
            }
        })
    }
    $('#gia').keyup(function() {
        var num = $(this).val();
        $('.text-gia').html(formatNumber(num, ',', '.'));
    });
    $('#khuyen_mai').keyup(function() {
        var num = $(this).val();
        $('.text-km').html(formatNumber(num, ',', '.'));
    })
</script>

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
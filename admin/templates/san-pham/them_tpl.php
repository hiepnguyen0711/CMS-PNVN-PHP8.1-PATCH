<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            SẢN PHẨM <small>[<?php if (isset($_GET['id'])) echo "Sửa ";
                                else echo "Thêm mới" ?>]</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= urladmin ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="#">Quản trị danh mục</a></li>
            <li class="active">Sản phẩm</li>
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
                                        $row = $d->simple_fetch("select * from #_sanpham where id_code = " . (int)$_GET['id'] . " and lang = '" . $value['code'] . "' ");
                                    }
                                ?>
                                    <?php if (isset($_GET['id'])) { ?>
                                        <input type="hidden" name="id_row[]" value="<?= $row['id'] ?>" />
                                    <?php } ?>
                                    <div role="tabpanel" class="tab-pane fade in <?php if ($key == 0) { ?> active <?php } ?>" id="<?= $value['code'] ?>" aria-labelledby="<?= $value['code'] ?>">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tên sản phẩm <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="Nhập tên sản phẩm" <?php if (!isset($_GET['id'])) { ?>OnkeyUp="addText(this,'#alias_<?= $value['code'] ?>','#title_<?= $value['code'] ?>')" <?php } else { ?>OnkeyUp="addText(this,'','#title_<?= $value['code'] ?>')" <?php } ?> name="ten[]" value="<?= $row['ten'] ?>">
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
                                        <!-- thương hiệu start -->
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Thương hiệu <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" placeholder="PhươngNamVina" name="brand[]" id="brand_<?= $value['code'] ?>" value="<?= $row['brand'] ?>" />
                                            </div>

                                        </div>
                                        <!-- thương hiệu end -->





                                        <?php if (get_json('product', 'don_vi_tinh') == 1) { ?>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Đơn vị tính <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                                <div class="col-sm-5">
                                                    <input type="text" placeholder="Nhập đơn vị tính" class="form-control" name="dvt[]" id="dvt_<?= $value['code'] ?>" value="<?= $row['dvt'] ?>">
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Mô tả <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="mo_ta[]" id="mo_ta_<?= $value['code'] ?>" rows="3"><?= $row['mo_ta'] ?></textarea>
                                            </div>
                                            <script>
                                                CKEDITOR.replace('mo_ta_<?= $value['code'] ?>', {
                                                    filebrowserBrowseUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                    filebrowserUploadUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                    filebrowserImageBrowseUrl: 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='
                                                });
                                            </script>
                                        </div>
                                        <?php if (get_json('product', 'thong_so') == 1) { ?>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Thông số kỹ thuật <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                                <div class="col-sm-10">
                                                    <?php
                                                    $strjson = $row['thong_so_kt'];
                                                    if ($strjson != '[]' and $strjson != '') {
                                                        $strjson = json_decode($strjson, true);
                                                        $addinfor = "";
                                                        foreach ($strjson as $items2) {
                                                            $item = explode('%%%', $items2);
                                                            $addinfor .= "<div class=\"info-product\">Tên: <input type=\"text\" name=\"nameinfo_" . $value['code'] . "[]\" value=\"" . $item[0] . "\" size=\"50\" /> : Chi tiết: <input type=\"text\" name=\"detailinfo_" . $value['code'] . "[]\" value=\"" . $item[1] . "\" size=\"80\" /> | <strong class=\"delinfo\"> Xoá </strong></div>";
                                                        }
                                                    } else {
                                                        $addinfor = '';
                                                    }
                                                    ?>
                                                    <fieldset style="border: 1px solid #ccc;box-shadow: 1px 1px 10px 1px #7b787869;border-radius: 0px;padding: 15px 15px 0px 15px;">
                                                        <p><strong style="font-size: 14px;">VD:</strong> => Tên:
                                                            <input style="padding-left: 5px;padding-right: 5px;border: 1px solid  #d2d6de;height: 30px;" type="text" readonly="true" value="Hãng sản xuất" /> : Chi tiết:
                                                            <input style="padding-left: 5px;padding-right: 5px;border: 1px solid  #d2d6de;height: 30px;" readonly="true" type="text" value="Samsung" />
                                                        </p>
                                                        <p><strong style="font-size: 14px;">Thêm thông số sản phẩm click => <span id="add_<?= $value['code'] ?>" style="color:red;cursor: pointer;">Thêm</span></strong></p>

                                                        <div id="addinfo_<?= $value['code'] ?>">
                                                            <?= $addinfor ?>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <script>
                                                var i = 1;
                                                $('span#add_<?= $value['code'] ?>').click(function() {
                                                    i++;
                                                    $('div#addinfo_<?= $value['code'] ?>').append('<div class=\"info-product\">Tên: <input style=\"padding-left: 5px;padding-right: 5px;border: 1px solid  #d2d6de;\" type=\"text\" name=\"nameinfo_<?= $value['code'] ?>[]\" size=\"45\" /> : Chi tiết: <input style=\"padding-left: 5px;padding-right: 5px;border: 1px solid  #d2d6de;\" type=\"text\" name=\"detailinfo_<?= $value['code'] ?>[]\" size=\"45\" /> | <strong class=\"delinfo\"> Xoá </strong></div>');
                                                });
                                                $(document).on('click', '#addinfo_<?= $value['code'] ?> .delinfo', function() {
                                                    $(this).parent().remove();
                                                });
                                            </script>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Nội dung sản phẩm <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="noi_dung[]" id="noi_dung_<?= $value['code'] ?>" rows="5"><?= $row['noi_dung'] ?></textarea>

                                            </div>
                                            <script>
                                                CKEDITOR.replace('noi_dung_<?= $value['code'] ?>', {
                                                    filebrowserBrowseUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                    filebrowserUploadUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                    filebrowserImageBrowseUrl: 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='
                                                });
                                            </script>
                                        </div>
                                        <?php /* <div class="form-group">
                                            <label class="col-sm-2 control-label">Hướng dẫn mua hàng <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="noi_dung_1[]" id="noi_dung_1<?= $value['code'] ?>" rows="3"><?= $row['noi_dung_1'] ?></textarea>

                                            </div>
                                            <script>
                                                CKEDITOR.replace('noi_dung_1<?= $value['code'] ?>', {
                                                    filebrowserBrowseUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                    filebrowserUploadUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                    filebrowserImageBrowseUrl: 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='
                                                });
                                            </script>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Vận chuyển - bảo hành <?php if (count(get_json('lang')) > 1) { ?>(<?= $value['code'] ?>)<?php } ?>:</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="noi_dung_2[]" id="noi_dung_2<?= $value['code'] ?>" rows="3"><?= $row['noi_dung_2'] ?></textarea>

                                            </div>
                                            <script>
                                                CKEDITOR.replace('noi_dung_2<?= $value['code'] ?>', {
                                                    filebrowserBrowseUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                    filebrowserUploadUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                                                    filebrowserImageBrowseUrl: 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='
                                                });
                                            </script>
                                        </div> */ ?>
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
                                <?php if (get_json('product', 'thuoctinh')) { ?>
                                    <li role="presentation">
                                        <a href="#tuychon" role="tab" data-toggle="tab" aria-controls="tuychon" aria-expanded="true">Thuộc tính</a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="thongtinsp" aria-labelledby="thongtinsp">
                                    <div class="form-group m0 hinh_anh">
                                        <label>Hình ảnh:</label>
                                        <span class="box-img2">
                                            <?php if (isset($_GET['id']) and $items[0]['hinh_anh'] != '') { ?>
                                                <img src="../img_data/images/<?php echo $items[0]['hinh_anh'] ?>" id="review_hinh_anh" alt="NO PHOTO" />
                                                <button class="btn btn-xs btn-danger" type="button" onclick="xoa_img('_sanpham','hinh_anh', '<?= $_GET['id'] ?>','')"><i class="fa fa-trash"></i></button>
                                            <?php } else { ?>
                                                <img src="img/no-image.png" style="max-width: 100%;max-height: 100%;object-fit: contain;" id="review_hinh_anh" alt="NO PHOTO" />
                                            <?php } ?>
                                            <input type="hidden" value="<?= $items[0]['hinh_anh'] ?>" name="hinh_anh" id="hinh_anh" class="form-control img-preview-hidden" data-target="#review_hinh_anh">
                                            <a href="filemanager/dialog.php?type=1&field_id=hinh_anh&relative_url=1&multiple=0" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn hình ảnh</a>
                                        </span>
                                    </div>
                                    <div class="form-group m0">
                                        <label>Danh mục:</label>
                                        <select name="id_loai" class="form-control select2">
                                            <option value="0">Chọn danh mục</option>
                                            <?= $loai ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Tình trạng:</label>
                                        <div class="col-sm-10">
                                            <input type="radio" name="tinhtrang" id="ft_long" value="1" <?php if ($row['tinhtrang'] == 1) echo 'checked'; ?> />
                                            <label for="ft_long">Còn hàng</label>
                                            <input type="radio" name="tinhtrang" id="ft_bot" value="0" <?php if ($row['tinhtrang'] == 0) echo 'checked'; ?> />
                                            <label for="ft_bot">Đặt trước</label>

                                        </div>
                                    </div>
                                    <?php if (get_json('product', 'video') == 1) { ?>
                                        <iframe style="width: 100%;margin-bottom: 10px;" id="if_video" height="200" src="https://www.youtube.com/embed/<?php if (isset($_GET['id'])) {
                                                                                                                                                            echo $row['video'];
                                                                                                                                                        } ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        <div class="form-group m0">
                                            <label>Mã Video: <span style="font-weight: 400;color: red;font-style: italic;font-size: 14px;">https://www.youtube.com/watch?v={Mã video}</span></label>
                                            <input type="text" placeholder="Nhập mã video" class="form-control" onchange="$('#if_video').attr('src', 'https://www.youtube.com/embed/'+$(this).val())" name="ma_video" value="<?= $row['video'] ?>">
                                        </div>
                                    <?php } ?>
                                    <?php if (get_json('product', 'file') == 1) { ?>
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
                                    <?php if (get_json('product', 'ma_sp') == 1) { ?>
                                        <div class="form-group m0">
                                            <label>Mã sản phẩm:</label>
                                            <input type="text" placeholder="Nhập mã sản phẩm" class="form-control" name="ma_sp" id="ma_sp" value="<?= $row['id_code'] ?>">
                                        </div>
                                    <?php } ?>
                                    <?php if (get_json('product', 'gia') == 1) { ?>
                                        <div class="form-group m0">
                                            <label>Giá: </label>
                                            <div class="input-group">
                                                <input type="text" placeholder="Nhập giá gốc" class="form-control formatprice" name="gia" id="gia" value="<?= $row['gia'] ?>">
                                                <span class="input-group-addon" id="basic-addon2">USD</span>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if (get_json('product', 'khuyen_mai') == 1) { ?>
                                        <div class="form-group m0">
                                            <label>Khuyến mãi: </label>
                                            <div class="input-group">
                                                <input type="text" placeholder="Nhập giá khuyến mãi" class="form-control formatprice" name="khuyen_mai" id="khuyen_mai" value="<?= $row['khuyen_mai'] ?>">
                                                <span class="input-group-addon" id="basic-addon2">USD</span>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="form-group m0">
                                        <label>Số thứ tự:</label>
                                        <input type="number" placeholder="Nhập số thứ tự" class="form-control " name="so_thu_tu" id="so_thu_tu" value="<?= $row['so_thu_tu'] ?>">
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
                                <div role="tabpanel" class="tab-pane fade" id="album_anh">

                                    <div class="container-slide" id="container-slide-images" style="max-height: 890px;overflow: auto;">

                                        <?php
                                        $slide_hinh_anh = [];
                                        if ($_GET['id']) {
                                            $slide_hinh_anh  = $d->o_fet("select * from #_sanpham_hinhanh where id_sp = {$_GET['id']} and id_chitiet = 0 and hinh_anh != '[' and hinh_anh != '' order by stt asc, id desc");
                                        }
                                        ?>
                                        <?php foreach ($slide_hinh_anh as $key => $item) { ?>

                                            <div class="images-slide-item" id="slide-item-<?= $key ?>">
                                                <div class="img-container">
                                                    <img id="hinh_anh_slide_preview_<?= $key ?>" src="<?= URLPATH . "img_data/images/" . $item['hinh_anh'] ?>" alt="<?= $item['hinh_anh'] ?>">
                                                    <a href="filemanager/dialog.php?type=1&field_id=hinh_anh_slide_<?= $key ?>&relative_url=1&multiple=0" class="iframe-btn">
                                                        Đổi hình
                                                    </a>
                                                    <a href="javascript:deleteElement('#slide-item-<?= $key ?>');" class="delete">x</a>
                                                    <input type="number" class="form-control number-input" name="hinh_anh_slide_stt[]" value="<?= $item['stt'] ?>">
                                                </div>
                                                <input class="img-preview-hidden" type="hidden" id="hinh_anh_slide_<?= $key ?>" name="hinh_anh_slide[]" data-target="#hinh_anh_slide_preview_<?= $key ?>" value="<?= $item['hinh_anh'] ?>">
                                            </div>

                                        <?php } ?>

                                    </div>

                                    <input type="hidden" id="hinh_anh_slide" class="form-control filemanager-input-multiple-images" data-el-container="#container-slide-images" data-prefix="hinh_anh_slide" />
                                    <a href="filemanager/dialog.php?type=1&field_id=hinh_anh_slide&relative_url=1&multiple=1" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn hình ảnh</a>

                                </div>
                                <?php $row_thuoctinh = $d->o_fet("select * from #_sanpham_thuoctinh order by id ASC");

                                ?>
                                <div role="tabpanel" class="tab-pane fade" id="tuychon" aria-labelledby="tuychon">

                                    <div class="form-group m0">
                                        <label>Chọn thuộc tính sản phẩm:</label>
                                        <select class="form-control" id="tuychon_thongso">
                                            <option value="">Chọn thuộc tính sản phẩm</option>
                                            <?php foreach ($row_thuoctinh as $key => $value) { ?>
                                                <option value="<?= $value['id'] ?>"><?= $value['ten'] ?></option>
                                            <?php } ?>
                                            <option value="0">Thêm thuộc tính mới</option>
                                        </select>
                                    </div>
                                    <!--div class="form-group m0">
                                        <label>Thêm thuộc tính khác:</label>
                                        <select class="form-control" name="thuoc_tinh2" id="thuoctinh2">
                                            <option value="0">Chọn thuộc tính khác</option>
                                            <?php foreach ($row_thuoctinh as $key => $value) { ?>
                                            <option <?= $row['thuoc_tinh2'] == $value['id'] ? 'selected' : '' ?> value="<?= $value['id'] ?>"><?= $value['ten'] ?></option>                                     
                                            <?php } ?>
                                        </select>
                                    </div-->

                                    <div id="add_thuoctinh" style="display: none;border: 1px solid #3c8dbc;position: relative;padding: 10px;margin-top: 25px;padding-top: 30px;">
                                        <span style="position: absolute;background-color: #fff;top: -9px;padding: 0px 10px;font-weight: 600;">Thêm thuộc tính</span>
                                        <div class="form-group m0">
                                            <input type="text" placeholder="Nhập tên thuộc tính" id="ten_thuoctinh" class="form-control">
                                        </div>
                                        <div class="form-group m0">
                                            <label>Thông số thuộc tính:</label>
                                            <select class="form-control select2" multiple id="cauhinh_thuoctinh">
                                                <option value="1">Có mã màu</option>
                                                <option value="2">Có hình ảnh</option>
                                                <option value="3">Có giá</option>
                                                <option value="4">Có mã sp</option>
                                                <option value="5">Có số lượng</option>
                                            </select>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-primary btn-sm" type="button" onclick="themthuoctinh()">Thêm thuộc tính mới</button>
                                        </div>
                                    </div>
                                    <div class="list_thuoctinh">
                                        <?php if (isset($_GET['id'])) {
                                            $thuoctinh_chitiet = $d->o_fet("SELECT * FROM `db_sanpham_chitiet` WHERE id_sp = " . (int)$_GET['id'] . " and id_loai = 0 GROUP BY id_thuoctinh ");
                                            foreach ($thuoctinh_chitiet as $key => $item_tt) {
                                                $thuoctinh = $d->simple_fetch("select * from #_sanpham_thuoctinh where id = '" . $item_tt['id_thuoctinh'] . "' ");
                                                $thuoctinhs = $d->o_fet("select * from #_sanpham_chitiet where id_sp = " . (int)$_GET['id'] . " and id_thuoctinh = " . $thuoctinh['id'] . " ");
                                        ?>
                                                <div class="box-thuoctinh" id="thuoctinh_<?= $thuoctinh['id'] ?>">
                                                    <span class="name-thuoctinh"><?= $thuoctinh['ten'] ?></span>
                                                    <button class="btn btn-primary btn-add-tt btn-sm" type="button" onclick="add_thuoctinh(<?= $thuoctinh['id'] ?>)">Thêm <?= $thuoctinh['ten'] ?></button>
                                                    <input type="hidden" name="id_thuoctinh[]" value="<?= $thuoctinh['id'] ?>" />
                                                    <div id="thuoctinh_<?= $thuoctinh['id'] ?>">
                                                        <?php foreach ($thuoctinhs as $key_stt => $value_item) {
                                                            $stt = time() . $key_stt;
                                                        ?>
                                                            <div class="item-thuoctinh" id="item-thuoctinh_<?= $value_item['id'] ?>">
                                                                <input type="hidden" name="id_thuoctinh_ct_<?= $thuoctinh['id'] ?>[]" value="<?= $value_item['id'] ?>" />
                                                                <input type="hidden" name="stt_<?= $thuoctinh['id'] ?>[]" value="<?= $stt ?>" />
                                                                <?php if ($row['thuoc_tinh2'] == 0) { ?>
                                                                    <!-- <p>Số lượng còn: <b><?= numberformat($value_item['so_luong']) ?></b></p> -->
                                                                <?php } ?>
                                                                <div class="row m-10">
                                                                    <div class="form-group col-sm-4 m0 p10">
                                                                        <input type="text" class="form-control" placeholder="Tên" name="ten_<?= $thuoctinh['id'] ?>[]" value="<?= $value_item['ten'] ?>">
                                                                    </div>
                                                                    <?php if ($thuoctinh['mo_ta'] == 1) { ?>
                                                                        <div class="form-group col-sm-4 m0 p10">
                                                                            <input type="color" placeholder="Mô tả" class="form-control" name="mo_ta_<?= $thuoctinh['id'] ?>[]" value="<?= $value_item['mo_ta'] ?>">
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($thuoctinh['ma'] == 1) { ?>
                                                                        <div class="form-group col-sm-4 m0 p10">
                                                                            <input type="text" class="form-control" placeholder="Mã sản phẩm" name="ma_<?= $thuoctinh['id'] ?>[]" value="<?= $value_item['ma'] ?>">
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($thuoctinh['gia'] == 1) { ?>
                                                                        <div class="form-group col-sm-4 m0 p10">
                                                                            <input type="number" class="form-control" placeholder="Giá" name="gia_<?= $thuoctinh['id'] ?>[]" value="<?= $value_item['gia'] ?>">
                                                                        </div>
                                                                        <?php /*
                                                                        <div class="form-group col-sm-4 m0 p10">
                                                                            <input type="number" class="form-control" placeholder="Khuyến mãi" name="khuyen_mai_<?= $thuoctinh['id'] ?>[]" value="<?= $value_item['khuyen_mai'] ?>">
                                                                        </div> */ ?>
                                                                    <?php } ?>
                                                                    <?php if ($thuoctinh['so_luong'] == 1 and $row['thuoc_tinh2'] == 0) { ?>
                                                                        <div class="form-group col-sm-4 m0 p10">
                                                                            <input type="number" class="form-control" placeholder="Số lượng" name="so_luong_<?= $thuoctinh['id'] ?>[]" value="0">
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                                <?php if ($thuoctinh['hinh_anh'] == 1) { ?>
                                                                    <div class="form-group m0 hinh_anh">
                                                                        <span class="box-img2">
                                                                            <?php if ($value_item['hinh_anh'] != '') { ?>
                                                                                <img src="../img_data/images/<?php echo $value_item['hinh_anh'] ?>" id="review_hinh_anh_<?= $stt ?>" alt="NO PHOTO" />
                                                                                <button class="btn btn-xs btn-danger" type="button" onclick="xoa_img_thuoc_tinh('<?= $value_item['id'] ?>', <?= $stt ?>)"><i class="fa fa-trash"></i></button>
                                                                            <?php } else { ?>
                                                                                <img src="img/no-image.png" style="max-width: 100%;max-height: 100%;object-fit: contain;" id="review_hinh_anh_<?= $stt ?>" alt="NO PHOTO" />
                                                                            <?php } ?>
                                                                            <input type="hidden" value="<?= $value_item['hinh_anh'] ?>" name="hinh_anh_<?= $thuoctinh['id'] ?>[]" id="hinh_anh_<?= $stt ?>" class=" form-control img-preview-hidden" data-target="#review_hinh_anh_<?= $stt ?>">
                                                                            <a href="filemanager/dialog.php?type=1&field_id=hinh_anh_<?= $stt ?>&relative_url=1&multiple=0" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn hình ảnh cho <?= $thuoctinh['ten'] ?> <?= $value_item['ten'] ?> </a>
                                                                        </span>
                                                                    </div>
                                                                    <div class="form-group m0">
                                                                        <div class="row m-10" id="list_album_<?= $stt ?>">
                                                                            <?php
                                                                            $row_album_thuoctinh = $d->simple_fetch("select * from #_sanpham_hinhanh where id_sp = " . (int)$_GET['id'] . " and id_chitiet= " . $value_item['id'] . " order by stt ASC");
                                                                            if (!empty($row_album_thuoctinh)) {
                                                                                $album_anh_mau = json_decode($row_album_thuoctinh['hinh_anh'], true);

                                                                                // print_r($array);
                                                                            ?>

                                                                                <?php if (count($album_anh_mau) > 0) {
                                                                                    foreach ($album_anh_mau as $key0 => $value0) { ?>
                                                                                        <div class="col-sm-3 p10 album2_<?= $row_album_thuoctinh['id'] ?>_tt" id="album2_<?= $row_album_thuoctinh['id'] ?>">
                                                                                            <div class="item-album">

                                                                                                <img src="../img_data/images/<?= $value0 ?>" />

                                                                                                <button onclick="xoa_hinh_sp2(<?= $row_album_thuoctinh['id'] ?>, <?= $row_album_thuoctinh['id'] ?>)" class="btn btn-delete-album" type="button"><i class="fa fa-trash"></i></button>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php }
                                                                                } else {
                                                                                    ?>
                                                                                    <div class="col-sm-3 p10" id="album2_<?= $row_album_thuoctinh['id'] ?>">
                                                                                        <div class="item-album">
                                                                                            <img src="../img_data/images/<?= $row_album_thuoctinh['hinh_anh'] ?>" />
                                                                                            <button onclick="xoa_hinh_sp2(<?= $row_album_thuoctinh['id'] ?>)" class="btn btn-delete-album" type="button"><i class="fa fa-trash"></i></button>
                                                                                        </div>
                                                                                    </div>
                                                                            <?php }
                                                                            } ?>


                                                                        </div>

                                                                        <input type="hidden" value="album_tt_<?= $thuoctinh['id'] ?>_<?= $stt ?>_<?= $row_album_thuoctinh['id'] ?>[]" class="form-control" />

                                                                        <input type="hidden" value='<?= $row_album_thuoctinh['hinh_anh'] ?>' data_view="<?= $stt ?>" name="album_tt_<?= $thuoctinh['id'] ?>_<?= $stt ?>[]" id="album_tt_<?= $thuoctinh['id'] ?>_<?= $stt ?>" data_thuoctinh="<?= $thuoctinh['id'] ?>" class="form-control album2_<?= $row_album_thuoctinh['id'] ?>" />
                                                                        <a href="filemanager/dialog.php?type=1&field_id=album_tt_<?= $thuoctinh['id'] ?>_<?= $stt ?>&relative_url=1&multiple=1" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn nhiều hình cho <?= $thuoctinh['ten'] ?> <?= $value_item['ten'] ?></a>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if ($row['thuoc_tinh2'] > 0) {
                                                                    $row_thuoctinh_sub = $d->simple_fetch("select * from #_sanpham_thuoctinh where id = '" . $row['thuoc_tinh2'] . "' ");
                                                                    $thuoctinhs_sub = $d->o_fet("select * from #_sanpham_chitiet where id_sp = " . (int)$_GET['id'] . " and id_loai = " . $value_item['id'] . " ");
                                                                ?>
                                                                    <div class="box-thuoctinh">
                                                                        <span class="name-thuoctinh"><?= $row_thuoctinh_sub['ten'] ?> của <?= $row_thuoctinh['ten'] ?> <?= $row_thuoctinh_sub['ten'] ?></span>
                                                                        <button style="right: 50px;" class="btn btn-primary btn-add-tt btn-sm" type="button" onclick="add_thuoctinh_sub(<?= $thuoctinh['id'] ?>,<?= $row_thuoctinh_sub['id'] ?>,<?= $stt ?>)">Thêm <?= $row_thuoctinh_sub['ten'] ?></button>
                                                                        <button class="btn btn-danger btn-add-tt btn-sm" type="button" onclick=" $(this).parent().remove();">Xóa</button>
                                                                        <div id="thuoctinh_sub_<?= $stt ?>">
                                                                            <?php foreach ($thuoctinhs_sub as $key_stt_sub => $value_item_sub) { ?>
                                                                                <div class="item-thuoctinh" id="item-thuoctinh_<?= $value_item['id'] ?>">
                                                                                    <input type="hidden" name="id_thuoctinh_ct_sub_<?= $thuoctinh['id'] ?>_<?= $stt ?>[]" value="<?= $value_item_sub['id'] ?>" />
                                                                                    <p>Số lượng còn: <b><?= numberformat($value_item_sub['so_luong']) ?></b></p>
                                                                                    <div class="row m-10">
                                                                                        <div class="form-group col-sm-4 m0 p10">
                                                                                            <input type="text" class="form-control" placeholder="Tên" name="ten_<?= $thuoctinh['id'] ?>_<?= $stt ?>[]" value="<?= $value_item_sub['ten'] ?>">
                                                                                        </div>
                                                                                        <?php if ($row_thuoctinh_sub['mo_ta'] == 1) { ?>
                                                                                            <div class="form-group col-sm-4 m0 p10">
                                                                                                <input type="color" placeholder="Mô tả" class="form-control" name="mo_ta_<?= $thuoctinh['id'] ?>_<?= $stt ?>[]" value="<?= $value_item_sub['mo_ta'] ?>">
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                        <?php if ($row_thuoctinh_sub['ma'] == 1) { ?>
                                                                                            <div class="form-group col-sm-4 m0 p10">
                                                                                                <input type="text" class="form-control" placeholder="Mã sản phẩm" name="ma_<?= $thuoctinh['id'] ?>_<?= $stt ?>[]" value="<?= $value_item_sub['ma'] ?>">
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                        <?php if ($row_thuoctinh_sub['gia'] == 1) { ?>
                                                                                            <div class="form-group col-sm-4 m0 p10">
                                                                                                <input type="number" class="form-control" placeholder="Giá" name="gia_<?= $thuoctinh['id'] ?>_<?= $stt ?>[]" value="<?= $value_item_sub['gia'] ?>">
                                                                                            </div>
                                                                                            <div class="form-group col-sm-4 m0 p10">
                                                                                                <input type="number" class="form-control" placeholder="Khuyến mãi" name="khuyen_mai_<?= $thuoctinh['id'] ?>_<?= $stt ?>[]" value="<?= $value_item_sub['gia'] ?>">
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                        <?php if ($row_thuoctinh_sub['so_luong'] == 1) { ?>
                                                                                            <div class="form-group col-sm-4 m0 p10">
                                                                                                <input type="number" class="form-control" placeholder="Số lượng" name="so_luong_<?= $thuoctinh['id'] ?>_<?= $stt ?>[]" value="0">
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="text-center">
                                                                    <button style="margin-bottom: 10px;" class="btn btn-danger btn-xs" onclick="xoa_thuoctinh(<?= $value_item['id'] ?>)" type="button">Xóa <?= $thuoctinh['ten'] ?> <?= $value_item['ten'] ?></button>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                        <?php }
                                        } ?>
                                    </div>
                                    <script>
                                        function add_thuoctinh_sub(id_thuoctinh, id_sub, stt) {
                                            $.ajax({
                                                url: "./sources/ajax.php",
                                                type: 'POST',
                                                data: "id=" + id_thuoctinh + "&stt=" + stt + "&id_sub=" + id_sub + "&do=add_thuoctinh_item_sub",
                                                success: function(data) {
                                                    $('#thuoctinh_sub_' + stt).append(data);
                                                }
                                            });
                                            i++;
                                        }
                                        $('#tuychon_thongso').change(function() {
                                            var id_thuoctinh = $(this).val();
                                            //alert(id_thuoctinh);
                                            if (id_thuoctinh === '0') {
                                                $('#add_thuoctinh').show();
                                            } else {
                                                if (id_thuoctinh !== '') {
                                                    $.ajax({
                                                        url: "./sources/ajax.php",
                                                        type: 'POST',
                                                        data: "id=" + id_thuoctinh + "&do=get_thuoctinh",
                                                        success: function(data) {
                                                            $('.list_thuoctinh').append(data);
                                                        }
                                                    });
                                                }
                                                $('#add_thuoctinh').hide();
                                            }
                                        })
                                        <?php if (isset($stt)) { ?>
                                            var i = <?= $stt + 1 ?>;
                                        <?php } else { ?>
                                            var i = 0;
                                        <?php } ?>

                                        function add_thuoctinh(id) {
                                            $.ajax({
                                                url: "./sources/ajax.php",
                                                type: 'POST',
                                                data: "id=" + id + "&stt=" + i + "&sub=" + $('#thuoctinh2').val() + "&do=add_thuoctinh_item",
                                                success: function(data) {
                                                    $('#thuoctinh_' + id).append(data);
                                                }
                                            });
                                            i++;
                                        }

                                        function themthuoctinh() {
                                            var ten_thuoctinh = $('#ten_thuoctinh').val();
                                            var cauhinh_thuoctinh = $('#cauhinh_thuoctinh').val();
                                            if (ten_thuoctinh !== '') {
                                                $.ajax({
                                                    url: "./sources/ajax.php",
                                                    type: 'POST',
                                                    data: "ten=" + ten_thuoctinh + "&cauhinh=" + cauhinh_thuoctinh + "&do=add_thuoctinh",
                                                    success: function(data) {
                                                        if (data !== '0') {
                                                            $('#tuychon_thongso').html(data);
                                                            $('#ten_thuoctinh').val('')
                                                            $("#cauhinh_thuoctinh").select2({
                                                                placeholder: "Select a State",
                                                                allowClear: true
                                                            });
                                                            $('#add_thuoctinh').hide();
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    </script>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-default"><span class="fa fa-mail-reply "></span> Quay lại</button>
                                    <?php if ($d->checkPermission_edit($id_module) == 1) { ?>
                                        <button type="submit" name="capnhat" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-save"></span> Cập nhật</button>
                                    <?php } ?>

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

    function xoa_thuoctinh(id) {
        if (!confirm('Xác nhận xóa?')) return false;
        $.ajax({
            url: "./sources/ajax.php",
            type: 'POST',
            data: "id=" + id + "&do=xoa_thuoctinh",
            success: function() {
                $("#item-thuoctinh_" + id).remove();
            }
        })
    }

    function xoa_hinh_sp2(id, stt) {
        if (!confirm('Xác nhận xóa?')) return false;
        $.ajax({
            url: "./sources/ajax.php",
            type: 'POST',
            data: "id=" + id + "&do=xoa_anh_sp",
            success: function() {
                $("#album2_" + id).remove();
                $(".album2_" + id + "_tt").remove();
                $(".album2_" + id).val('');
            }
        })
    }

    function xoa_img_thuoc_tinh(id, stt) {
        if (!confirm('Xác nhận xóa?')) return false;
        $.ajax({
            url: "./sources/ajax.php",
            type: 'POST',
            data: "id=" + id + "&do=xoa_img_thuoc_tinh",
            success: function() {
                // $("#item-thuoctinh_" + id).remove();
                $("#review_hinh_anh_" + stt).attr("src", "img/no-image.png");
                $("#hinh_anh_" + stt).val('');
            }
        })
    }

    $('#gia_flash_sale').keyup(function() {
        var num = $(this).val();
        $('.text-sale').html(formatNumber(num, ',', '.'));
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


<!-- sản phẩm đi cùng  -->

<script>
    $(document).ready(function() {
        $(".ha-sp-di-cung-multiple").select2({});
    });
</script>
<!-- sản phẩm đi cùng end -->
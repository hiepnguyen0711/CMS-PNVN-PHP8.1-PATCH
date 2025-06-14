
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Upload File <small>[<?php if(isset($_GET['id'])) echo "Sửa "; else echo "Thêm mới" ?>]</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?=urladmin?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
          <li><a href="#">Quản trị danh mục</a></li>
          <li class="active">Upload File</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <form name="frm" method="post" class=" form-horizontal" action="index.php?p=<?=$_GET['p']?>&a=save&id=<?=@$_REQUEST['id']?>&page=<?=@$_REQUEST['page']?>&loaitin=<?=@$_GET['loaitin']?>" enctype="multipart/form-data">
                <div class="box-body">
                     <div class="row">
                        <div class="col-md-9">
                            <?php if(count(get_json('lang'))>1){ ?>
                            <ul id="myTabs" class="nav nav-tabs" role="tablist">
                                <?php foreach (get_json('lang') as $key => $value) {?>
                                <li role="presentation" <?php if($key==0){?>class="active" <?php } ?>>
                                    <a href="#<?=$value['code']?>" id="home-tab" role="tab" data-toggle="tab" aria-controls="<?=$value['code']?>" aria-expanded="true"><?=$value['name']?></a>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php }?>
                            <div id="myTabContent" class="tab-content">
                                <?php foreach (get_json('lang') as $key => $value) {
                                if(isset($_GET['id'])){
                                    $row = $d->simple_fetch("select * from #_files where id_code = ".(int)$_GET['id']." and lang = '".$value['code']."' ");
                                }      
                                ?>
                                <?php if(isset($_GET['id'])){ ?>
                                <input type="hidden" name="id_row[]" value="<?=$row['id']?>" />
                                <?php }?>
                                <div role="tabpanel" class="tab-pane fade <?php if($key==0){?> active in<?php }?>" id="<?=$value['code']?>" aria-labelledby="<?=$value['code']?>">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Tên file (<?=$value['code']?>):</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" placeholder="Nhập tên file" OnkeyUp="addText(this,'#alias_<?=$value['code']?>','#title_<?=$value['code']?>')" name="ten[]" value="<?= $row['ten']?>" >
                                            <input type="hidden" placeholder="Nhập đường dẫn" class="form-control" name="alias[]" id="alias_<?=$value['code']?>" value="<?= $row['alias']?>"   OnkeyUp="addText(this,'#alias')" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Mô tả (<?=$value['code']?>):</label>
                                        <div class="col-sm-10">
                                           <textarea class="form-control" name="mo_ta[]"  id="mo_ta_<?=$value['code']?>" rows="3"><?= $row['mo_ta']?></textarea>
											<script>
												CKEDITOR.replace( 'noi_dung_<?=$value['code']?>' ,{
													filebrowserBrowseUrl : 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
													filebrowserUploadUrl : 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
													filebrowserImageBrowseUrl : 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='
												});
											</script>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>
                                <hr>
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <button type="button" class="btn btn-default"><span class="fa fa-mail-reply "></span> Quay lại</button>
                                        <?php if($d->checkPermission_edit($id_module)==1){ ?>
                                        <button type="submit" name="capnhat" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-save"></span> Cập nhật</button>
                                        <?php }?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <h3 class="box-title">Thông tin chung</h3>
                            <?php if(isset($_GET['id'])){ 
                                if($row['file'] != ''){
                                    $link = URLPATH.'uploads/files/'.$row['file'];
                                }else{
                                    $link =  $row['link_khac'];
                                }
                                if($row['loai_file'] == 'pdf' || $row['loai_file'] == 'xlsx' || $row['loai_file'] == 'xls'|| $row['loai_file'] == 'doc' || $row['loai_file'] == 'docx'){
                                    $html = '<iframe class="iframe" src="http://docs.google.com/gview?url='.$link.'&embedded=true" style="height: 200px;width: 100%;" frameborder="0"></iframe>';
                                }elseif($row['loai_file']=='mp4'){
                                    $html='<video class="iframe" style="height: 200px;width: 100%;" controls><source src="'.$link.'" type="video/mp4">Trình duyệt của bạn không hỗ trợ HTML5.</video>';
                                }elseif($row['loai_file']=='mp3'){
                                    $html='<audio class="iframe" controls><source src="'.$link.'" type="audio/mp3">Trình duyệt của bạn không hỗ trợ HTML5</audio>';
                                }  
                            ?>
                            <div class="form-group m0 hinh_anh" >
                                <?= $html?>
                            </div>
                            <?php }?>
                            <div class="form-group m0">
                                <label>Upload file:</label>
                                <input type="file" name="file" class="form-control" >
                            </div>
                            <div class="form-group m0">
                                <label>Đường dẫn file khác:</label>
                                <div class="row m-5">
                                    <div class="col-sm-9 p5">
                                        <input type="text" placeholder="Nhập đường dẫn file" class="form-control" name="link_khac" value="<?= $row['link_khac']?>">
                                    </div> 
                                    <div class="col-sm-3 p5">
                                        <select class=" form-control" name="loai_file">
                                            <option <?=$row['loai_file']=='pdf'?'selected':''?> value="pdf">PDF</option>
                                            <option <?=$row['loai_file']=='docx'?'selected':''?> value="docx">WORD</option>
                                            <option <?=$row['loai_file']=='xlsx'?'selected':''?> value="xlsx">EXCEL</option>
                                            <option <?=$row['loai_file']=='mp4'?'selected':''?> value="mp4">Video</option>
                                            <option <?=$row['loai_file']=='mp3'?'selected':''?> value="mp3">Âm thanh</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                             <div class="form-group m0">
                                <label>Danh mục:</label>
                                <select name="id_loai" class="form-control select2">
                                    <option value="0">Chọn làm mục cha</option>
                                    <?=$loai?>
                                </select>
                            </div>
                            <div class="form-group m0">
                                <label>Số thứ tự:</label>
                                <input type="number" placeholder="Nhập số thứ tự" class="form-control" name="so_thu_tu" id="so_thu_tu" value="<?= $row['so_thu_tu']?>">
                            </div>
                            <div class="form-group m0">
                                <div class="">
                                    <label>
                                        <input name="hien_thi" <?php if(isset($items[0]['hien_thi'])) { if(@$items[0]['hien_thi']==1) echo 'checked="checked"';} else echo'checked="checked"'; ?> type="checkbox"> Hiển thị
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

<?php if(isset($_GET['search'])){
    $link_search = '&search='.$_GET['search'].'&key='.$_GET['key'];
}else{
    $link_search ='';
} ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Upload File
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
            <div class="box-header with-border">
                <div class="btn-group">
                    <select id="action" name="action" onclick="form_submit(this)" class="form-control">
                        <option selected="">Tác vụ</option>
                        <option value="delete">Xóa</option>
                    </select>
                </div>
                <div class="btn-group">
                    <input type="text" value="<?=$_GET['search']!='loai'?$_GET['key']:''?>" id="key-search" class=" form-control" placeholder="Nhập nội dung cần tìm" />
                </div>
                <div class="btn-group">
                    <select id="search-input" class="form-control" data-p="<?=$_GET['p']?>">
                        <option value="">Tìm theo...</option>
                        <option <?=$_GET['search']=="ten"?'selected':''?> value="ten">Tên file</option>
                        <option <?=$_GET['search']=="id_code"?'selected':''?> value="id_code">ID</option>
                    </select>
                </div>
                <div class="btn-group">
                    <select id="search-cate" class="form-control" data-p="<?=$_GET['p']?>">
                        <option value="">Tìm theo danh mục</option>
                        <?=$loai?>
                    </select>
                </div>
                <?php if($d->checkPermission_edit($id_module)==1){ ?>
                <div class="pull-right">
                    <a href="index.php?p=<?=$_GET['p']?>&a=add" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-plus"></i> Thêm mới</a>
                </div>
                <?php }?>
                <div class="clearfix"></div>
            </div>  
            <form id="form" method="post" action="index.php?p=upload-file&a=delete_all" role="form">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-primary table-hover">
                            <thead>
                                <tr>
                                    <th style="width:50px" class="text-center"><input class="chk_box checkall" type="checkbox" name="chk" value="0"  id="check_all"></th>
                                    <th style="width:70px"  class="text-center">STT</th>
                                    <th>Danh mục</th>
                                    <th>Loại file</th>
                                    <th>Tên file</th>
                                    <th>Đường dẫn</th>
                                    <th>Tạo mã HTML</th>
                                    <th class="text-center" style="width:70px">Hiển thị</th>
                                    <th class="text-center" style="width:100px">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody id="data-ajax">
                                <?php 
                                $count=count($items); 
                                for($i=0; $i<$count; $i++){ 
                                    if($items[$i]['loai_file'] == 'pdf' || $items[$i]['loai_file'] == 'xlsx' || $items[$i]['loai_file'] == 'xls'|| $items[$i]['loai_file'] == 'doc' || $items[$i]['loai_file'] == 'docx'){
                                        $html = '<iframe class="iframe" src="http://docs.google.com/gview?url='.URLPATH.'uploads/files/'.$items[$i]['file'].'&embedded=true" style="height: 250px;width: 500px;" frameborder="0"></iframe>';
                                    }elseif($items[$i]['loai_file']=='mp4'){
                                        $html='<video class="iframe" style="height: 250px;width: 500px;" controls><source src="'.URLPATH.'uploads/files/'.$items[$i]['file'].'" type="video/mp4">Trình duyệt của bạn không hỗ trợ HTML5.</video>';
                                    }elseif($items[$i]['loai_file']=='mp3'){
                                        $html='<audio class="iframe" controls><source src="'.URLPATH.'uploads/files/'.$items[$i]['file'].'" type="audio/mp3">Trình duyệt của bạn không hỗ trợ HTML5</audio>';
                                    }
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <?php if($d->checkPermission_dele($id_module)==1){ ?>
                                        <input class="chk_box" type="checkbox" name="chk_child[]" value="<?=$items[$i]['id_code']?>">
                                        <?php }?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($d->checkPermission_edit($id_module)==1){ ?>
                                        <input type="number" value="<?=$items[$i]['so_thu_tu']?>" class="a_stt" data-table="#_tintuc" data-col="so_thu_tu" data-id="<?=$items[$i]['id_code']?>" />
                                        <?php }else{?>
                                        <span class="label label-primary"><?=$items[$i]['so_thu_tu']?></span>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php 
                                        if($items[$i]['id_loai']>0){
                                            $query = $d->simple_fetch("select * from #_category where id_code={$items[$i]['id_loai']} and lang = '".LANG."'");		
                                            echo $str.$query['ten'];
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><img style=" height: 50px" src="img/<?=$items[$i]['loai_file']?>.png" /></td>
                                    <td style="text-align:left">
                                        <a href="index.php?p=upload-file&a=edit&id=<?=$items[$i]['id_code']?><?=$link_search?>"><?=$items[$i]['ten']?></a>
                                    </td>
                                    <td  class="text-left">
                                        <a target="_blank" href="<?=URLPATH?>uploads/files/<?=$items[$i]['file']?>"><?=URLPATH?> uploads/files/<?=$items[$i]['file']?> </a>
                                    </td>
                                    <td  class="text-center">
                                        <button type="button" class="btn btn-xs btn-info" onclick="get_html_file('<?=$items[$i]['id']?>')" >Xem mã HTML</button>
                                        <input type="hidden"  value="" />
                                        <span style="display: none;" class="html_<?=$items[$i]['id']?>" ><?=$html?></span>
                                    </td>
                                    <td  class="text-center">
                                        <input class="chk_box" <?php if($d->checkPermission_edit($id_module)==0){ ?>disabled<?php }?> type="checkbox" onclick="on_check(this,'#_tintuc','hien_thi','<?=$items[$i]['id_code']?>')" <?php if($items[$i]['hien_thi'] == 1) echo 'checked="checked"'; ?>>
                                    </td>
                                    <td class="text-center">
                                        <a style="padding: 3px 5px 5px;font-size: 11px;" href="index.php?p=upload-file&a=edit&id=<?=$items[$i]['id_code']?><?=$link_search?>" class="btn btn-sm btn-warning" title="Sửa"><i class="glyphicon glyphicon-edit"></i></a>
                                        <?php if($d->checkPermission_dele($id_module)==1){ ?>
                                        <a style="padding: 3px 5px 5px;font-size: 11px;" href="index.php?p=upload-file&a=delete&id=<?=$items[$i]['id_code']?><?=$link_search?>" onClick="if(!confirm('Xác nhận xóa?')) return false;" class="bnt btn-sm btn-danger" title="Xóa"><i class="glyphicon glyphicon-remove"></i></a>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($total_page>1){ ?>
                    <div class="text-center">
                        <ul id="pagination-ajax" class="pagination-sm" style="margin: 0;"></ul>
                    </div>
                    <?php }?>
                </div>
            </form>
        </div>
    </section>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Mã HTML</h4>
            </div>
            <div class="modal-body">
                <div class=" form-group">
                    <div class="row m-5">
                        <div class="col-sm-2 p5 text-right"><label style="padding-top: 10px;">Chiều rộng</label></div>
                        <div class="col-sm-3 p5">
                            <input class="form-control" type="text" id="dai" value="500px" />
                        </div>
                        <div class="col-sm-2 p5 text-right"><label style="padding-top: 10px;">Chiều cao</label></div>
                        <div class="col-sm-3 p5">
                            <input class="form-control" type="text" id="cao" value="250px" />
                        </div>
                        <div class="col-sm-2 p5">
                            <button class="btn btn-primary btn-block" onclick="chen_kichthuoc()">Áp dụng</button>
                        </div>
                    </div>
                </div>
                <textarea class="form-control" placeholder="" rows="5" id="copyTarget"></textarea>
                <div id="body_html" style="padding-top: 20px;text-align: center;">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="copyButton">Sao chép</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        var where = "<?=$where_search?>";
        $('#pagination-ajax').twbsPagination({
        totalPages: <?=$total_page?>,
        visiblePages: 5,
        <?php if(isset($_GET['page'])){ ?>
        startPage:<?=$_GET['page']?>,
        <?php } ?>
        prev: '<span aria-hidden="true">&laquo;</span>',
        next: '<span aria-hidden="true">&raquo;</span>',
        onPageClick: function (event, page) {
            $.ajax({
                url: "templates/<?=$_GET['p']?>/ajax_pagination.php",
                type:'POST',
                data: {page: page,totalPages:'<?=$total_page?>', where: where, limit:'<?=$limit?>',search:'<?=$link_search?>'},
                success: function(data){
                    //console.log(data);
                    $('#data-ajax').html(data);
                }
            })
        }
    });
    });
</script>
<script>
    document.getElementById("copyButton").addEventListener("click", function() {
        document.getElementById("copyTarget").select();
        copyToClipboard2(document.getElementById("copyTarget"));
        $.notify("Đã coppy", "success");
    });

    function copyToClipboard2(elem) {
	  // create hidden text element, if it doesn't already exist
        var targetId = "_hiddenCopyText_";
        var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
        var origSelectionStart, origSelectionEnd;
        if (isInput) {
            // can just use the original source element for the selection and copy
            target = elem;
            origSelectionStart = elem.selectionStart;
            origSelectionEnd = elem.selectionEnd;
        } else {
            // must use a temporary form element for the selection and copy
            target = document.getElementById(targetId);
            if (!target) {
                var target = document.createElement("textarea");
                target.style.position = "absolute";
                target.style.left = "-9999px";
                target.style.top = "0";
                target.id = targetId;
                document.body.appendChild(target);
            }
            target.textContent = elem.textContent;
        }
        // select the content
        var currentFocus = document.activeElement;
        target.focus();
        target.setSelectionRange(0, target.value.length);

        // copy the selection
        var succeed;
        try {
              succeed = document.execCommand("copy");
        } catch(e) {
            succeed = false;
        }
        // restore original focus
        if (currentFocus && typeof currentFocus.focus === "function") {
            currentFocus.focus();
        }

        if (isInput) {
            // restore prior selection
            elem.setSelectionRange(origSelectionStart, origSelectionEnd);
        } else {
            // clear temporary content
            target.textContent = "";
        }
        return succeed;
    }
    function get_html_file(id){
        var html = $('.html_'+id).html();
        $('#copyTarget').val(html);
        $('#body_html').html(html);
        $('#myModal').modal('show');
    }
    function chen_kichthuoc(){
        var dai = $('#dai').val();
        var cao = $('#cao').val();
        //var text  = 'height: '+dai+';width: '+cao+';';
         $('#body_html .iframe').css({'height':cao,'width':dai});
         var html = $('#body_html').html();
         $('#copyTarget').val(html);
    }
</script>

<?php 

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	if($_SESSION['quyen'] == 2) $d->location("index.php?p=ql-user&a=man");
	$permission = $d->o_fet("select * from #_permission_group where id_loai=0");
	$user_id = $items[0]['id'];
	$permission_group = $d->o_fet("select * from #_user_permission_group where id_user = '".$user_id."'");
	$array_check = array();
	if(!empty($permission_group)){
		foreach ($permission_group as $key => $value) {
			array_push($array_check, $value['id_permission']);
		}
	}

?>
<?php @include "sources/editor.php" ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Quản lý user <small>Thêm mới</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=urladmin?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="#">Cấu hình website</a></li>
        <li class="active">Quản lý user</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <form name="frm" method="post"  class=" form-horizontal" action="index.php?p=ql-user&a=save&id=<?=@$_REQUEST['id']?>&page=<?=@$_REQUEST['page']?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Loại tài khoản:</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="quyen_han">
                                <option <?php if(@$items[0]['quyen_han'] == 2) echo "selected='selected'";?> value="2">Quản trị viên</option>
                                <option <?php if(@$items[0]['quyen_han'] == 1) echo "selected='selected'";?> value="1">Administrator</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tên tài khoản:</label>
                        <div class="col-sm-5">
                            <input class="form-control"	 type="text" name="tai_khoan" value="<?php echo @$items[0]['tai_khoan']?>"  />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Mật khẩu:</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="password" name="password" id="password" value="<?php echo @$items[0]['password']?>"  />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nhập lại mật khẩu:</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="password" name="cfpassword" id="cfpassword" value="<?php echo @$items[0]['cfpassword']?>"  />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tác vụ:</label>
                        <div class="col-sm-5">
                            <div class="checkbox icheck">
                                <label>
                                    <input name="hien_thi" <?php if(isset($items[0]['hien_thi'])) { if(@$items[0]['hien_thi']==1) echo 'checked="checked"';} else echo'checked="checked"'; ?> type="checkbox"> Hiển thị
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-2">
                            <button type="submit" name="capnhat" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span> Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>


<style type="text/css">
	.td_right label{ margin-right: 10px; }
	.text-bottom{ vertical-align: text-bottom; }
	.it-child{ margin-left: 10px; }
	.it-child .chkbox{ width: 18px; height: 18px; }
</style>
<script type="text/javascript">
	function kiemtra(){
		var pw = $("#password").val();
		var cfpw = $("#cfpassword").val();
		if(pw != cfpw){
			alert('Mật khẩu không giống nhau');
			$("#cfpassword").focus();
			return false;
		}
		return true;
	}

	jQuery(document).ready(function($) {
		// $('.parent-check').change(function() {
		//     var id = $(this).attr('data-check');
		//     if (this.checked) {
		//         $(this).siblings('.it-child').children(':checkbox').attr('checked','checked');
		//     } else {
		//         $(this).siblings('.it-child').children(':checkbox').removeAttr("checked");
		//     }
		// });
	});
</script>

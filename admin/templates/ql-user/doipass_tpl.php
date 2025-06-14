<?php @include "sources/editor.php" ?>
<ol class="breadcrumb">
  <li><a href="."><i class="glyphicon glyphicon-home"></i> Trang chủ</a></li>
   <li class="active"><a href="index.php">User</a></li>
  <li class="active"><a href="index.php?p=ql-user&a=man">Quản lý user</a></li>
  <li class="active"><a href="#">Thông tin user</a></li>
</ol>
<div class="col-xs-12">
<form name="frm" method="post" action="index.php?p=ql-user&a=savepass&id=<?=@$_REQUEST['id']?>&page=<?=@$_REQUEST['page']?>" enctype="multipart/form-data">
<table class="table table-bordered table-hover them_dt" style="border:none">
	<tbody>
		<tr>
			<td class="td_left">
				Tên tài khoản:
			</td>
			<td class="td_right">
				 <input class="input width400 form-control" readonly="readonly" type="text" name="id" value="<?php echo @$_SESSION["user_admin"]?>"  />
			</td>
		</tr>
		<tr>
			<td class="td_left">
				Họ tên:
			</td>
			<td class="td_right">
				<input class="input width400 form-control" type="text" name="ho_ten" value="<?php echo @$items[0]['ho_ten']?>"  />
			</td>
		</tr>
		<tr>
			<td class="td_left">
				Mật khẩu:
			</td>
			<td class="td_right">
				<input class="input width400 form-control" type="password" name="password" id="password" value=""  />
			</td>
		</tr>
		<tr>
			<td class="td_left">
				Nhập lại mật khẩu:
			</td>
			<td class="td_right">
				<input class="input width400 form-control" type="password" name="cfpassword" id="cfpassword" value=""  />
			</td>
		</tr>
		<tr>
			<td class="td_left" style="text-align:right">
				<input type="submit" onclick="return kiemtra()" value="Lưu" class="btn btn-primary" />
			</td>
			<td class="td_right">
				<input type="button" value="Thoát" onclick="javascript:window.location='index.php?p=ql-user&a=man'" class="btn btn-primary" />
			</td>
		</tr>
	</tbody>
</table>
</form>
</div>
<script type="text/javascript">
	function kiemtra(){

		var pw = $("#password").val();
		var cfpw = $("#cfpassword").val();
		if(pw == ''){
			$("#password").focus();
			return false;
		}else{
			if(pw != cfpw){
				$("#cfpassword").focus();
				return false;
			}else return true;
		}
	}
</script>
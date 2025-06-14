<?php
if (isset($_POST['add_cate'])) {
	if (!isset($_GET['id_loai'])) {
		$file_name = bodautv(addslashes($_POST['ten'][0]));
		$hinh_anh =  $_POST['hinh_anh'];
		$so_thu_tu      =   $_POST['so_thu_tu'] != '' ? $_POST['so_thu_tu'] : 0;
		$hien_thi       =   1;

		$data0['ten']       =   addslashes($_POST['ten'][0]);
		$data0['type']      =  1;
		$d->reset();
		$d->setTable('cf_parent');
		if ($id_code = $d->insert($data0)) {
			foreach (get_json('lang') as $key => $value) {
				$data_cate['ten']       =   $d->clear(addslashes($_POST['ten'][$key]));
				$data_cate['noi_dung']  =   $d->clear(addslashes($_POST['noi_dung'][$key]));
				$data_cate['link']      =   $d->clear(addslashes($_POST['link'][$key]));
				$data_cate['mo_ta']      =   $d->clear(addslashes($_POST['mo_ta'][$key]));
				$data_cate['tieu_de']      =   $d->clear(addslashes($_POST['tieu_de'][$key]));
				$data_cate['hinh_anh']  =   $hinh_anh;
				$data_cate['hien_thi']       =   $hien_thi;
				$data_cate['id_code']        =   $id_code;
				$data_cate['lang']           =   $value['code'];
				$data_cate['nofollow']       =   isset($_POST['nofollow']) ? 1 : 0;
				$data_cate['target']         =   isset($_POST['target']) ? 1 : 0;
				$data_cate['heading']       =   addslashes($_POST['heading']);
				$d->reset();
				$d->setTable('#_category_noidung');
				$d->insert($data_cate);
			}
			$d->redirect("index.php?p=" . $_GET['p'] . "&a=man");
		}
	} else {
		$id = (int)$_GET['id_loai'];
		$file_name = bodautv(addslashes($_POST['ten'][0]));
		$hinh_anh =  $_POST['hinh_anh'];
		$data0['ten']       =   addslashes($_POST['ten'][0]);
		$d->reset();
		$d->setTable('cf_parent');
		$d->setWhere('id', $id);
		if ($d->update($data0)) {
			foreach (get_json('lang') as $key => $value) {
				$data_cate['ten']       =   $d->clear(addslashes($_POST['ten'][$key]));
				$data_cate['noi_dung']  =   $d->clear(addslashes($_POST['noi_dung'][$key]));
				$data_cate['link']      =   $d->clear(addslashes($_POST['link'][$key]));
				$data_cate['mo_ta']      =   $d->clear(addslashes($_POST['mo_ta'][$key]));
				$data_cate['tieu_de']      =   $d->clear(addslashes($_POST['tieu_de'][$key]));
				if ($hinh_anh != '') {
					$data_cate['hinh_anh']  =   $hinh_anh;
				}
				$data_cate['nofollow']       =   isset($_POST['nofollow']) ? 1 : 0;
				$data_cate['target']         =   isset($_POST['target']) ? 1 : 0;
				$data_cate['heading']       =   addslashes($_POST['heading']);

				if ($_POST['id_row'][$key] == '') {
					$data_cate['id_code'] = $d->clear(addslashes($id));
					$data_cate['lang']  =   $value['code'];
					$d->reset();
					$d->setTable('#_category_noidung');
					$d->insert($data_cate);
				} else {
					$d->reset();
					$d->setTable('#_category_noidung');
					$d->setWhere('id', $_POST['id_row'][$key]);
					$d->update($data_cate);
				}
			}
			$d->redirect("index.php?p=" . $_GET['p'] . "&a=man&id_loai=" . $_GET['id_loai']);
		}
	}
}
if (isset($_GET['delete']) and $_GET['delete'] != '') {
	if ($d->checkPermission_dele($id_module) == 1) {
		$id =  (int)$_GET['delete'];
		$sub_content = $d->o_fet("select * from #_content where id_loai = '" . $id . "'");
		if (count($sub_content) > 0) {
			foreach ($sub_content as $key => $value) {
				$d->o_que("delete from cf_parent where id = " . $value['id_code'] . " ");
			}
			$d->o_que("delete from #_content where id_loai = " . $id . " ");
		}
		$d->reset();
		$d->setTable('#_category_noidung');
		$d->setWhere('id_code', $id);
		if ($d->delete()) {
			$d->o_que("delete from cf_parent where id = $id ");
			$d->redirect("index.php?p=" . $_GET['p'] . "&a=man");
		} else {
			$d->alert("Xóa dữ liệu bị lỗi!");
			$d->redirect("index.php?p=" . $_GET['p'] . "&a=man");
		}
	} else {
		$d->redirect("index.php?p=" . $_GET['p'] . "&a=man");
	}
}
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Nội dung
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?= urladmin ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
			<li><a href="#">Quản trị giao diện</a></li>
			<li class="active">Nội dung</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-sm-8">
				<div class="box box-primary">
					<div class="box-header with-border ">
						<h3 class="box-title pull-left">Trang chủ</h3>
						<a class="btn btn-danger pull-right" href="<?= urladmin ?>index.php?p=noi-dung&a=man">Thêm mới</a>
						<div class=" clearfix"></div>
					</div>
					<?php $danhmuc_home = $d->o_fet("select * from #_category_noidung where lang='" . LANG . "' order by id ASC"); ?>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-primary">
							<thead>
								<tr>
									<th class="text-center" style="width: 200px;">STT</th>
									<th class="text-center">Tiêu đề</th>
									<th class="text-center">Hình ảnh</th>
									<th class="text-center" style="width: 100px;">Hiển thị</th>
									<th class="text-center" style="width: 150px;">#</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($danhmuc_home as $key => $value) {

									$hinhanh = $d->o_fet("select * from #_content where id_loai=" . $value['id_code'] . " and lang ='" . LANG . "' order by so_thu_tu ASC, id ASC");
								?>
									<?php
									if (!empty($value['tieu_de'])) {
									?>
										<!-- item tiêu đề start -->
										<tr class=" " style="background: #3c8dbccc; color: #F9F7F7">
											<td colspan="5" class="" style="font-size: 2rem; font-weight: bold"><?= $value['tieu_de'] ?></td>
										</tr>
										<!-- item tiêu đề end -->
									<?php } ?>
									<tr>
										<td class="text-center">
											<?php if (count($hinhanh) > 0) { ?>
												<button type="button" class="btn btn-xs btn-success" onclick="$('.noi_dun_<?= $value['id'] ?>').slideToggle();">
													<i class="fa fa-long-arrow-down"></i> Chi tiết (<?= count($hinhanh) ?>)
												</button>
											<?php } ?>
											<a href="index.php?p=noi-dung&a=add&parent=<?= $value['id_code'] ?>" class="btn btn-xs btn-primary">Thêm nội dung</a>
										</td>
										<td><?= $value['ten'] ?></td>
										<td class="text-center">
											<?php if ($value['hinh_anh'] != '') { ?>
												<img src="../img_data/images/<?= $value['hinh_anh'] ?>" style="max-width:50px; max-height: 50px;">
											<?php } ?>
										</td>
										<td class="text-center">
											<label class="switch">
												<input <?php if ($d->checkPermission_edit($id_module) == 0) { ?> disabled <?php } ?> class="chk_box vh-checkbox" type="checkbox" onclick="on_check(this,'#_category_noidung','hien_thi','<?= $value['id_code'] ?>')" <?php if ($value['hien_thi'] == 1) echo 'checked="checked"'; ?>>
												<span class="slider"></span>
											</label>
										</td>
										<td class="text-center">
											<a href="index.php?p=<?= $_GET['p'] ?>&a=man&id_loai=<?= $value['id_code'] ?>" class="label label-warning" title="Sửa" style="margin-right: 5px;">
												<i class="glyphicon glyphicon-edit"></i> Sửa
											</a>
											<?php if ($d->checkPermission_dele($id_module) == 1 && get_json('dev', 'display')) { ?>
												<a href="index.php?p=<?= $_GET['p'] ?>&a=man&delete=<?= $value['id_code'] ?>" onClick="if(!confirm('Xác nhận xóa?')) return false;" class="label label-danger" title="Xóa"><i class="glyphicon glyphicon-remove"></i> Xóa</a>
											<?php } ?>
										</td>
									</tr>
									<?php foreach ($hinhanh as $key2 => $value2) { ?>
										<tr <?= $_GET['parent'] == $value['id_code'] ? '' : 'style="display: none"' ?> class="noi_dun_<?= $value['id'] ?>">
											<td class="text-center">
												<?php if ($d->checkPermission_edit($id_module) == 1) { ?>
													<input type="number" value="<?= $value2['so_thu_tu'] ?>" class="a_stt" data-table="#_content" data-col="so_thu_tu" data-id="<?= $value2['id_code'] ?>" />
												<?php } else { ?>
													<span class=" label label-primary"><?= $value2['so_thu_tu'] ?></span>
												<?php } ?>
											</td>
											<td><?= $value2['ten'] ?></td>
											<td class="text-center">
												<?php if ($value2['hinh_anh'] != '') { ?>
													<img src="../img_data/images/<?= $value2['hinh_anh'] ?>" style="height:50px">
												<?php } ?>
											</td>
											<td class="text-center">

												<label class="switch">
													<input class="chk_box vh-checkbox" <?php if ($d->checkPermission_edit($id_module) == 0) { ?> disabled <?php } ?> type="checkbox" onclick="on_check(this,'#_content','hien_thi','<?= $value2['id_code'] ?>')" <?php if ($value2['hien_thi'] == 1) echo 'checked="checked"'; ?>>
													<span class="slider"></span>
												</label>
											</td>
											<td class="text-center">
												<a href="index.php?p=<?= $_GET['p'] ?>&a=edit&id=<?= $value2['id_code'] ?>&parent=<?= $value['id_code'] ?>" class="label label-warning" title="Sửa"><i class="glyphicon glyphicon-edit"></i> Sửa</a>
												<?php if ($d->checkPermission_dele($id_module) == 1) { ?>
													<a href="index.php?p=<?= $_GET['p'] ?>&a=delete&id=<?= $value2['id_code'] ?>&parent=<?= $value['id_code'] ?>" onClick="if(!confirm('Xác nhận xóa?')) return false;" class="label label-danger" title="Xóa"><i class="glyphicon glyphicon-remove"></i> Xóa</a>
												<?php } ?>
											</td>
										</tr>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>


			</div>
			<div class="col-sm-4">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title pull-left">Danh mục</h3>
					</div>
					<div class="box-body">

						<form method="POST" action="" enctype="multipart/form-data">
							<div class="form-group m0 hinh_anh">
								<label>Hình ảnh:</label>
								<span class="box-img2">
									<?php if (isset($_GET['id_loai']) and  $_GET['id_loai'] != '') {
										$row0 = $d->simple_fetch("select * from #_category_noidung where id_code = " . (int)$_GET['id_loai'] . " and lang = '" . LANG . "' ");
									?>
										<img onerror="this.src='img/no-image.png';" src="../img_data/images/<?php echo $row0['hinh_anh'] ?>" id="review_hinh_anh" alt="NO PHOTO" />
										<button class="btn btn-xs btn-danger" type="button" onclick="xoa_img('_category_noidung','hinh_anh', '<?= $_GET['id_loai'] ?>','')"><i class="fa fa-trash"></i></button>
									<?php } else { ?>
										<img src="img/no-image.png" style="max-width: 100%;max-height: 100%;object-fit: contain;" id="review_hinh_anh" alt="NO PHOTO" />
									<?php } ?>
									<input type="hidden" value="<?= $row0['hinh_anh'] ?>" name="hinh_anh" id="hinh_anh" class=" form-control img-preview-hidden" data-target="#review_hinh_anh">
									<a href="filemanager/dialog.php?type=1&field_id=hinh_anh&relative_url=1&multiple=0" class="btn btn-upload2 iframe-btn"> <i class="fa fa-upload" aria-hidden="true"></i>Chọn hình ảnh</a>
								</span>
							</div>
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
									if (isset($_GET['id_loai'])) {
										$row = $d->simple_fetch("select * from #_category_noidung where id_code = " . (int)$_GET['id_loai'] . " and lang = '" . $value['code'] . "' ");
									}
								?>
									<div role="tabpanel" class="tab-pane fade in <?php if ($key == 0) { ?> active <?php } ?>" id="seo_<?= $value['code'] ?>" aria-labelledby="seo_<?= $value['code'] ?>">
										<div class="form-group">
											<label>Tên</label>
											<div class="row m-5">
												<div class="col-sm-8 p5">
													<input type="text" value="<?= $row['ten'] ?>" placeholder="Nhập danh mục mới" name="ten[]" class="form-control" />
												</div>
												<div class="col-sm-4 p5">
													<select class=" form-control" name="heading">
														<option <?= $row['heading'] == 'div' ? 'selected' : '' ?> value="div">Bình thường (DIV)</option>
														<option <?= $row['heading'] == 'h1' ? 'selected' : '' ?> value="h1">Heading 1</option>
														<option <?= $row['heading'] == 'h2' ? 'selected' : '' ?> value="h2">Heading 2</option>
														<option <?= $row['heading'] == 'h3' ? 'selected' : '' ?> value="h3">Heading 3</option>
														<option <?= $row['heading'] == 'h4' ? 'selected' : '' ?> value="h4">Heading 4</option>
														<option <?= $row['heading'] == 'h5' ? 'selected' : '' ?> value="h5">Heading 5</option>
													</select>
												</div>
											</div>

											<?php if (isset($_GET['id_loai'])) { ?>
												<input type="hidden" name="id_row[]" value="<?= $row['id'] ?>" />
											<?php } ?>
										</div>
										<div class="form-group">
											<label>Liên kết</label>
											<input type="text" value="<?= $row['link'] ?>" placeholder="Liên kết" name="link[]" class="form-control" />
											<div class="checkbox">
												<label class="checkbox-inline">
													<input name="nofollow" <?php if ($row['nofollow'] == 1) echo 'checked="checked"'; ?> type="checkbox"> Nofollow
												</label>
												<label class="checkbox-inline">
													<input name="target" <?php if ($row['target'] == 1) echo 'checked="checked"'; ?> type="checkbox"> Mở cửa số mới (_blank)
												</label>
											</div>
										</div>
										<div class="form-group">
											<label>Tieu đề (nếu có)</label>
											<textarea class="form-control" placeholder="Nhập Tieu đề (nếu có)" rows="5" name="tieu_de[]"><?= $row['tieu_de'] ?></textarea>
										</div>
										<div class="form-group">
											<label>Mô tả</label>
											<textarea class="form-control" placeholder="Nhập mô tả" rows="5" name="mo_ta[]"><?= $row['mo_ta'] ?></textarea>
										</div>
										<div class="form-group">
											<label>Nội dung</label>
											<textarea class="form-control" placeholder="Nhập nội dung" rows="5" id="noi_dung_<?= $value['code'] ?>" name="noi_dung[]"><?= $row['noi_dung'] ?></textarea>
											<script>
												CKEDITOR.replace('noi_dung_<?= $value['code'] ?>', {
													filebrowserBrowseUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
													filebrowserUploadUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
													filebrowserImageBrowseUrl: 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='
												});
											</script>
										</div>
									</div>
								<?php } ?>
							</div>

							<?php if (isset($_GET['id']) and  $_GET['id'] != '') { ?>
								<a class="btn btn-warning" href="index.php?p=noi-dung&a=man">Quay lại</a>
							<?php } ?>
							<button class="btn btn-primary pull-right" type="submit" name="add_cate"> <?php if ($_GET['id_loai']) echo 'Cập nhật';
																										else echo "Thêm mới"; ?></button>
							<div></div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
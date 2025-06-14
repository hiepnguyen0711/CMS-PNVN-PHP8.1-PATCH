<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Mã khuyến mãi <small>[<?php if(isset($_GET['id'])) echo "chi tiết "; else echo "Thêm mới" ?>]</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?=urladmin?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
          <li><a href="#">Quản lý bán hàng</a></li>
          <li class="active">Mã khuyến mãi</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <form name="frm" method="post" class=" form-horizontal" action="index.php?p=<?=$_GET['p']?>&a=save&id=<?=@$_REQUEST['id']?><?=$link_option?>" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tên chương trình:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="ten" value="<?=$items['ten']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mã khuyến mãi:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Nhập mã khuyến mãi" name="ma" value="<?=$items['ma']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Giá trị giảm:</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" placeholder="Nhập giá trị" name="gia_tri" value="<?=$items['gia_tri']?>">
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control" name="don_vi">
                                    <option value="1">%</option>
                                    <option value="0">vnđ</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Loại khuyến mãi:</label>
                            <div class="col-sm-9">
                                 <select class="form-control" name="loai">
                                    <option value="0">Giảm trên tổng đơn</option>
                                    <option value="1">Giảm phí vận chuyển</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Điều kiến áp dụng:</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" placeholder="Nhập điều kiện áp dụng" name="dieu_kien" value="<?=$items['dieu_kien']?>">
                                <span style="display: block;margin-top: 5px;font-size: 13px;color: #dd1212;font-style: italic;">Nhập giá trị đơn hàng có thể áp dụng khuyến mãi, nhập 0 nếu áp dụng cho tất cả đơn hàng</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Thời gian áp dụng:</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" value="<?=$items['tu_ngay']?>" name="tu_ngay" >
                            </div>
                            <label class="col-sm-1 control-label"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" value="<?=$items['den_ngay']?>" name="den_ngay" >
                            </div>
                        </div>
                        <?php $thanhvien= $d->o_fet("select * from #_thanhvien where loai=0 order by id desc"); ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Thành viên áp dụng:</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" multiple="" name="id_thanhvien[]">
                                    <option value="">Chọn thành viên</option>
                                    <?php foreach ($thanhvien as $key => $value) {?>
                                    <option value="<?=$value['id']?>"><?=$value['ho_ten']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Giới hạn:</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="gioi_han" value="<?=$items['gioi_han']?>">
                                <span style="display: block;margin-top: 5px;font-size: 13px;color: #dd1212;font-style: italic;">Nhập số lượt sử dụng mã khuyến mãi, nhập 0 nếu không giới hạn</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <button type="button" class="btn btn-default"><span class="fa fa-mail-reply "></span> Quay lại</button>
                                <?php if($d->checkPermission_edit($id_module)==1){ ?>
                                <button type="submit" name="capnhat" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-save"></span> Cập nhật</button>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
        <div class="box box-primary">
            
        </div>
    </section>
</div>
<?php
$items = $d->o_fet("select * from #_module_admin where parent = '0'  order by so_thu_tu ASC");
if(isset($_GET['delete'])){
    $row = $d->o_fet("select * from #_module_admin where id = ".(int)$_GET['delete']." ");
    if($row['parent']==0){
        $d->o_que("delete from #_module_admin where id = ".(int)$_GET['delete']."");
    }else{
        $rows = $d->o_fet("select * from #_module_admin where parent = ".(int)$_GET['delete']." ");
        $d->o_que("delete from #_module_admin where id = ".(int)$_GET['delete']." ");
        foreach ($rows as $key => $value) {
            $d->o_que("delete from #_module_admin where id = ".$value['id']." ");
        }
    }
    $d->redirect("index.php?p=".$_GET['p']."&a=man");
}
if(isset($_POST['themmoi'])){
    $data['parent'] = $d->clear(addslashes($_POST['parent']));
    $data['name'] = $d->clear(addslashes($_POST['name']));
    $data['alias'] = $d->clear(addslashes($_POST['alias']));
    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $d->setTable('#_module_admin');
        $d->setWhere('id',$id);
        $d->update($data);
    }else{
        $data['hien_thi'] = 1;
        $d->setTable('#_module_admin');
        if($d->insert($data)){
            if($data['parent']>0){
                $dir = "templates/".$data['alias'];
                if(!file_exists($dir)){
                    mkdir($dir, 0700);
                    //$fh         =   fopen($dir.'/hienthi_tpl.php','w');
                    //$fh2        =   fopen($dir.'/them_tpl.php','w');
                    //$fh3        =   fopen('sources/'.$data['alias'].'.php','w');
                }
            }
            
        }
    }
    $d->redirect("index.php?p=".$_GET['p']."&a=man");
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard 
        <small>Module</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Module</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
         <div class="row">
            <div class="col-lg-8 col-xs-12">
                <div class="box box-info">
                    
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Danh mục</th>
                                        <th>Tên</th>
                                        <th>File</th>
                                        <th style="width: 100px">Số TT</th>
                                        <th style="width: 100px">Trạng thái</th>
                                        <th style="width: 150px">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $key => $value) {
                                    $item0 = $d->o_fet("select * from #_module_admin where parent = '".$value['id']."' order by so_thu_tu ASC");    
                                    ?>
                                    <tr>
                                        <td><b><?=$value['name']?></b></td>
                                        <td></td>
                                        <td><?=$value['alias']?></td>
                                        <td class="text-center"><input type="number" value="<?=$value['so_thu_tu']?>" class="a_stt" data-table="#_module_admin" data-col="so_thu_tu" data-id="<?=$value['id']?>" /></td>
                                        <td class="text-center"><input class="chk_box" type="checkbox" onclick="on_check(this,'#_module_admin','hien_thi','<?=$value['id']?>')" <?php if($value['hien_thi'] == 1) echo 'checked="checked"'; ?>></td>
                                        <td class="text-center">
                                            <a  href="index.php?p=<?=$_GET['p']?>&a=<?=$_GET['a']?>&id=<?=$value['id']?>" class="btn btn-xs btn-warning" title="Sửa"><i class="glyphicon glyphicon-edit"></i> Sửa</a>
                                            <a  href="index.php?p=<?=$_GET['p']?>&a=<?=$_GET['a']?>&delete=<?=$value['id']?>" onClick="if(!confirm('Xác nhận xóa?')) return false;" class="btn btn-xs btn-danger" title="Xóa"><i class="glyphicon glyphicon-remove"></i> Xóa</a>
                                        </td>
                                    </tr>
                                    <?php foreach ($item0 as $key2 => $item) {?>
                                    <tr>
                                        <td><b>--</b></td>
                                        <td><?=$item['name']?></td>
                                        <td><?=$item['alias']?></td>
                                        <td class="text-center"><input type="number" value="<?=$item['so_thu_tu']?>" class="a_stt" data-table="#_module_admin" data-col="so_thu_tu" data-id="<?=$item['id']?>" /></td>
                                        <td class="text-center"><input class="chk_box" type="checkbox" onclick="on_check(this,'#_module_admin','hien_thi','<?=$item['id']?>')" <?php if($item['hien_thi'] == 1) echo 'checked="checked"'; ?>></td>
                                        <td class="text-center">
                                            <a  href="index.php?p=<?=$_GET['p']?>&a=<?=$_GET['a']?>&id=<?=$item['id']?>" class="btn btn-xs btn-warning" title="Sửa"><i class="glyphicon glyphicon-edit"></i> Sửa</a>
                                            <a  href="index.php?p=<?=$_GET['p']?>&a=<?=$_GET['a']?>&delete=<?=$item['id']?>" onClick="if(!confirm('Xác nhận xóa?')) return false;" class="btn btn-xs btn-danger" title="Xóa"><i class="glyphicon glyphicon-remove"></i> Xóa</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php } ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-lg-4 col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thêm mới</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php
                        if(isset($_GET['id'])){
                            $row_item = $d->o_fet("select * from #_module_admin where id = ".(int)$_GET['id']." ");
                        }
                        ?>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label>Danh mục</label>
                                <select class="form-control" name="parent">
                                    <option value="0">Danh mục chính</option>
                                    <?php foreach ($items as $key => $value) {?>
                                    <option <?=$row_item[0]['parent']==$value['id']?'selected':''?> value="<?=$value['id']?>"><?=$value['name']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tên</label>
                                <input type="text" name="name" value="<?=$row_item[0]['name']?>" class="form-control"  />
                            </div>
                            <div class="form-group">
                                <label>File xử lý</label>
                                <input type="text" name="alias"  value="<?=$row_item[0]['alias']?>" class="form-control"  />
                            </div>
                            <div class="">
                                <?php if(isset($_GET['id'])){ ?>
                                <a href="index.php?p=<?=$_GET['p']?>&a=<?=$_GET['a']?>" class="pull-left btn btn-warning">Thêm mới</a>
                                <?php }?>
                                <button class=" pull-right btn btn-primary" name="themmoi">Cập nhật</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
         </div>
    </section>
</div>

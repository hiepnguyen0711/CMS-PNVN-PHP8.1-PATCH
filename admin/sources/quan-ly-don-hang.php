<?php
if(!defined('_source')) die("Error");
$a = (isset($_REQUEST['a'])) ? addslashes($_REQUEST['a']) : "";
switch($a){
	case "man":
		showdulieu();
		$template = ($_REQUEST['p'] ?? '')."/hienthi";
		break;
	case "add":
		showdulieu();
		$template = ($_REQUEST['p'] ?? '')."/them";
		break;
	case "edit":
		showdulieu();
		$template = ($_REQUEST['p'] ?? '')."/them";
		break;
	case "save":
		luudulieu($id_module);
		break;
	case "delete":
		xoadulieu($id_module);
		break;
	case "delete_all":
		xoadulieu_mang($id_module);
		break;
	default:
		$template = "index";
}
function showdulieu(){
	global $d, $items, $paging, $loai, $soluong;
	//$loai = $d->array_category(0,'',$_GET['loaitin'],2);
        $loai = $d->array_category(0,'','',2);
	if($_REQUEST['a'] == 'man'){
            $items = $d->o_fet("select * from #_dathang order by trangthai_xuly ASC, id desc");
	}else{
            if(isset($_REQUEST['id'])){
                $id = addslashes($_REQUEST['id'] ?? '');
                $items = $d->o_fet("select * from #_dathang where id =  '".$id."' ");
            }
	}
}
function xoadulieu($id_module){
    global $d;
    if($d->checkPermission_dele($id_module)==1){
        if(isset($_GET['id'])){
            $id =  addslashes($_GET['id']);
            $d->reset();
            $d->setTable('#_dathang');
            $d->setWhere('id',$id);
            if($d->delete()){
                $d->o_que("delete from db_dathang_chitiet where id_dh = $id ");
                $d->redirect("index.php?p=quan-ly-don-hang&a=man");
            }else{
                $d->alert("Xóa dữ liệu bị lỗi!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=quan-ly-don-hang&a=man");
            }
        }else {
            $d->alert("Không nhận được dữ liệu!");
            $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=&a=man");
        }
    }else{
        $d->redirect("index.php?p=quan-ly-don-hang&a=man");
    }
	
}

function xoadulieu_mang($id_module){
    global $d;
    global $link_option;
    if($d->checkPermission_dele($id_module)==1){
        if(isset($_POST['chk_child'])){
            $chuoi = "";
            foreach ($_POST['chk_child'] as $val) {
                $chuoi .=$val.',';
            }
            $chuoi = trim($chuoi,',');
            if($d->o_que("delete from #_dathang where id in ($chuoi)")){
                $d->o_que("delete from db_dathang_chitiet where id_dh in ($chuoi) ");
                $d->redirect("index.php?p=quan-ly-don-hang&a=man");
            }
            else{
                $d->alert("Không nhận được dữ liệu!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=quan-ly-don-hang&a=man");
            } 
        }else $d->redirect("index.php?p=quan-ly-don-hang&a=man");
    }else{
        $d->redirect("index.php?p=quan-ly-don-hang&a=man");
    }
}
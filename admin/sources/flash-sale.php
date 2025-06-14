<?php
if(!defined('_source')) die("Error");
$a = (isset($_REQUEST['a'])) ? addslashes($_REQUEST['a']) : "";
switch($a){
	case "man":
		showdulieu();
		$template = @$_REQUEST['p']."/hienthi";
		break;
	case "add":
		showdulieu();
		$template = @$_REQUEST['p']."/them";
		break;
	case "edit":
		showdulieu();
		$template = @$_REQUEST['p']."/them";
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
            $items = $d->o_fet("select * from #_flash_sale order by id desc");
	}else{
            if(isset($_REQUEST['id'])){
                @$id = addslashes($_REQUEST['id']);
                $items = $d->simple_fetch("select * from #_flash_sale where id =  '".$id."' ");
            }
	}
}

function luudulieu($id_module){
    
    global $d;
    global $link_option;
    global $arrr_setting;
    
    if($d->checkPermission_edit($id_module)==1){
	$id = (isset($_REQUEST['id'])) ? addslashes($_REQUEST['id']) : "";
	$file_name=$d->fns_Rand_digit(0,9,12);
	if($id != '')
	{
            $data['ten']         = $d->clear(addslashes($_POST['ten']));
            $data['tu_ngay']     = $d->clear(addslashes($_POST['tu_ngay']));
            $data['den_ngay']        = $d->clear(addslashes($_POST['den_ngay']));
            $data['hien_thi']   = isset($_POST['hien_thi'])?'1':'0';
            $d->reset();
            $d->setTable('#_flash_sale');
            $d->setWhere('id', $id );
            if($d->update($data)){
                $d->redirect("index.php?p=flash-sale&a=man".$link_option);    
            }else{
                $d->alert("Cập nhật dữ liệu bị lỗi!");
                $d->redirect("Cập nhật dữ liệu bị lỗi", "index.php?p=flash-sale&a=man".$link_option);
            }
	}else{
            $data['ten']         = $d->clear(addslashes($_POST['ten']));
            $data['tu_ngay']     = $d->clear(addslashes($_POST['tu_ngay']));
            $data['den_ngay']        = $d->clear(addslashes($_POST['den_ngay']));
            $data['hien_thi']   = isset($_POST['hien_thi'])?'1':'0';
            $d->reset();
            $d->setTable('#_flash_sale');
            if($d->insert($data)){
                $d->redirect("index.php?p=flash-sale&a=man".$link_option);   
            }
	}
    }else{
        $d->redirect("index.php?p=flash-sale&a=man&loaitin=".@$_GET['loaitin']);
    }
}
function xoadulieu($id_module){
    global $d;
    if($d->checkPermission_dele($id_module)==1){
        if(isset($_GET['id'])){
            $id =  addslashes($_GET['id']);
            $d->reset();
            $d->setTable('#_flash_sale');
            $d->setWhere('id',$id);
            if($d->delete()){
                $d->redirect("index.php?p=flash-sale&a=man");
            }else{
                $d->alert("Xóa dữ liệu bị lỗi!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=flash-sale&a=man");
            }
        }else {
            $d->alert("Không nhận được dữ liệu!");
            $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=&a=man");
        }
    }else{
        $d->redirect("index.php?p=flash-sale&a=man");
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
            if($d->o_que("delete from #_flash_sale where id in ($chuoi)")){
                $d->redirect("index.php?p=flash-sale&a=man");
            }
            else{
                $d->alert("Không nhận được dữ liệu!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=flash-sale&a=man");
            } 
        }else $d->redirect("index.php?p=flash-sale&a=man");
    }else{
        $d->redirect("index.php?p=flash-sale&a=man");
    }
}
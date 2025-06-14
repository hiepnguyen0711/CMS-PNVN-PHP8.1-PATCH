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
            $items = $d->o_fet("select * from #_phuong_thuc_van_chuyen order by id desc");
	}else{
            if(isset($_REQUEST['id'])){
                @$id = addslashes($_REQUEST['id']);
                $items = $d->simple_fetch("select * from #_phuong_thuc_van_chuyen where id =  '".$id."' ");
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
            $data['gia']          = $d->clear(addslashes($_POST['gia']));
            $data['ngay_tao']     = time();
           
            $d->reset();
            $d->setTable('#_phuong_thuc_van_chuyen');
            $d->setWhere('id', $id );
            if($d->update($data)){
                $d->redirect("index.php?p=phuong-thuc-van-chuyen&a=man".$link_option);    
            }else{
                $d->alert("Cập nhật dữ liệu bị lỗi!");
                $d->redirect("Cập nhật dữ liệu bị lỗi", "index.php?p=phuong-thuc-van-chuyen&a=man".$link_option);
            }
	}else{
            $data['ten']         = $d->clear(addslashes($_POST['ten']));
            $data['gia']          = $d->clear(addslashes($_POST['gia']));
            $data['ngay_tao']     = time();
            
            $d->reset();
            $d->setTable('#_phuong_thuc_van_chuyen');
            if($d->insert($data)){
                $d->redirect("index.php?p=phuong-thuc-van-chuyen&a=man".$link_option);   
            }
	}
    }else{
        $d->redirect("index.php?p=phuong-thuc-van-chuyen&a=man&loaitin=".@$_GET['loaitin']);
    }
}
function xoadulieu($id_module){
    global $d;
    if($d->checkPermission_dele($id_module)==1){
        if(isset($_GET['id'])){
            $id =  addslashes($_GET['id']);
            $d->reset();
            $d->setTable('#_phuong_thuc_van_chuyen');
            $d->setWhere('id',$id);
            if($d->delete()){
                $d->redirect("index.php?p=phuong-thuc-van-chuyen&a=man");
            }else{
                $d->alert("Xóa dữ liệu bị lỗi!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=phuong-thuc-van-chuyen&a=man");
            }
        }else {
            $d->alert("Không nhận được dữ liệu!");
            $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=&a=man");
        }
    }else{
        $d->redirect("index.php?p=phuong-thuc-van-chuyen&a=man");
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
            if($d->o_que("delete from #_phuong_thuc_van_chuyen where id in ($chuoi)")){
                $d->redirect("index.php?p=phuong-thuc-van-chuyen&a=man");
            }
            else{
                $d->alert("Không nhận được dữ liệu!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=phuong-thuc-van-chuyen&a=man");
            } 
        }else $d->redirect("index.php?p=phuong-thuc-van-chuyen&a=man");
    }else{
        $d->redirect("index.php?p=phuong-thuc-van-chuyen&a=man");
    }
}
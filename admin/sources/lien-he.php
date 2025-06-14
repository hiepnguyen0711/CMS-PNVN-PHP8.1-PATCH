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
            $items = $d->o_fet("select * from #_lienhe order by trang_thai ASC, id desc");
	}else{
            if(isset($_REQUEST['id'])){
                @$id = addslashes($_REQUEST['id']);
                $items = $d->o_fet("select * from #_lienhe where id =  '".$id."' ");
            }
	}
}
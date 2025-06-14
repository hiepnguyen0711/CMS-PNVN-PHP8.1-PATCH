<?php
if(!defined('_source')) die("Error");
$a = (isset($_REQUEST['a'])) ? addslashes($_REQUEST['a']) : "";
$link_option ='';
if(isset($_GET['search'])){
    $link_option.='&search='.addslashes($_GET['search']);
}
if(isset($_GET['key'])){
    $link_option.='&key='.addslashes($_GET['key']);
}
if(isset($_GET['page'])){
    $link_option.='&page='.addslashes($_GET['page']);
}
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
	global $d, $items, $loai,  $total_page, $limit, $total_records, $where_search;
	//$loai = $d->array_category(0,'',$_GET['loaitin'],2);
        $loai = $d->array_category(0,'','',8);
	if($_REQUEST['a'] == 'man'){
            if(isset($_GET['search']) and $_GET['key']!=''  and $_GET['search']!=''){
                if($_GET['search']=='loai'){
                    $id_code=$_GET['key'];
                    $list_id = $id_code.$d->getIdsub($id_code);
                    $where_search = " and id_loai in ($list_id)";
                    $loai = $d->array_category(0,'',$id_code,7);
                }else{
                    $col    =   addslashes($_GET['search']);
                    $value  =   addslashes($_GET['key']);
                    $where_search = " and $col like '%".$value."%' ";
                }
            }
            $limit = 20;
            $items = $d->o_fet("select * from #_files where lang ='".LANG."' $where_search order by so_thu_tu asc, id desc limit 0, $limit");
            $total_records = $d->num_rows("select id from #_files where lang ='".LANG."' $where_search order by so_thu_tu asc, id desc" );
            $total_page = ceil($total_records / $limit);
	}else{
            if(isset($_REQUEST['id'])){
                @$id = addslashes($_REQUEST['id']);
                $items = $d->o_fet("select * from #_files where id_code =  '".$id."' and lang = '".LANG."'");
                //$loai = $d->array_category(0,'',$items[0]['id_loai'],2);
                $loai = $d->array_category(0,'',$items[0]['id_loai'],8);
            }
	}
}

function luudulieu($id_module){
    global $d;
    global $link_option;
    if($d->checkPermission_edit($id_module)==1){
	$id = (isset($_REQUEST['id'])) ? addslashes($_REQUEST['id']) : "";
	$file_name=$d->fns_Rand_digit(0,9,12);
	if($id != '')
	{
            $file_name = bodautv(addslashes($_POST['ten'][0]));
            //xóa hinh_anh cũ upload hình mới
            if($file = Uploadfile("file", 'file', '../uploads/files/',$file_name)){
                $hinhanh = $d->o_fet("select file from #_files where id_code = '".$id."'");
                @unlink('../uploads/images/'.$hinhanh[0]['file']);
                $file_name = $file;
            }else{
                $file_name='';
            }
            
            $id_loai    =   addslashes($_POST['id_loai']);
            $so_thu_tu  =   $_POST['so_thu_tu'] !='' ? $_POST['so_thu_tu'] : 0;
            $hien_thi   =   isset($_POST['hien_thi']) ? 1 : 0;
            
            $data0['ten']   =   addslashes($_POST['ten'][0]);
            $d->reset();
            $d->setTable('cf_parent');
            $d->setWhere('id',$id);
            if($d->update($data0)) {
                foreach (get_json('lang') as $key => $value) {
                    $data['id_loai']    =   $id_loai;
                    if($file_name!=''){
                        $data['file']   =   $file_name;
                        //lấy loại file 
                        $arr_file = explode('.', $file_name);
                        $data['loai_file']  = $arr_file[1];
                    }
                    $data['ten']        =   $d->clear(addslashes($_POST['ten'][$key]));
                    $data['mo_ta']      =   $d->clear(addslashes($_POST['mo_ta'][$key]));
                    $data['link_khac']  =   $d->clear(addslashes($_POST['link_khac']));
                    if($_POST['link_khac']!=''){
                        $data['loai_file']  = addslashes($_POST['loai_file']);
                    }
                    $data['hien_thi']   =   $hien_thi;
                    $data['so_thu_tu']  = $so_thu_tu;
                    $d->reset();
                    $d->setTable('#_files');
                    $d->setWhere('id', $_POST['id_row'][$key]);
                    $d->update($data);
                }
                 $d->redirect("index.php?p=upload-file&a=man".$link_option);
            }else{
                $d->alert("Cập nhật dữ liệu bị lỗi!");
                $d->redirect("Cập nhật dữ liệu bị lỗi", "index.php?p=upload-file&a=man".$link_option);
            }
	}
	else
	{
            $file_name = bodautv(addslashes($_POST['ten'][0]));
            if($file = Uploadfile("file", 'file', '../uploads/files/',$file_name)){
               $file_name = $file;
            }else{
                $file_name='';
            }
            $id_loai        =   addslashes($_POST['id_loai']);
            $so_thu_tu      =   $_POST['so_thu_tu'] !='' ? $_POST['so_thu_tu'] : 0;
            $hien_thi       =   isset($_POST['hien_thi']) ? 1 : 0;
            
            $data0['ten']   =   addslashes($_POST['ten'][0]);
            $d->reset();
            $d->setTable('cf_parent');
            if($id_code = $d->insert($data0)) {
                foreach (get_json('lang') as $key => $value) {
                    $data['id_loai']    =   $id_loai;
                    if($file_name!=''){
                        $data['file']       =   $file_name;
                        //lấy loại file 
                        $arr_file = explode('.', $file_name);
                        $data['loai_file']  = $arr_file[1];
                    }else{
                        $data['file']       =   '';
                         $data['loai_file'] =   '';
                    }
                    $data['ten']        =   $d->clear(addslashes($_POST['ten'][$key]));
                    $data['mo_ta']   =   $d->clear(addslashes($_POST['mo_ta'][$key]));
                    $data['link_khac']      = $d->clear(addslashes($_POST['link_khac']));
                    if($_POST['link_khac']!=''){
                        $data['loai_file']  = addslashes($_POST['loai_file']);
                    }
                    $data['hien_thi']   =   $hien_thi;
                    $data['id_code']    =   $id_code;
                    $data['lang']       =   $value['code'];
                    $data['so_thu_tu']  = $so_thu_tu;
                    $d->reset();
                    $d->setTable('#_files');
                    $d->insert($data);
                }
                $d->redirect("index.php?p=upload-file&a=man".$link_option);
            }else{
                $d->alert("Thêm dữ liệu bị lỗi!");
                $d->redirect("Thêm dữ liệu bị lỗi", "index.php?p=upload-file&a=man".$link_option);
            }
	}
    }else{
        $d->redirect("index.php?p=upload-file&a=man&loaitin=".@$_GET['loaitin']);
    }
}

function xoadulieu($id_module){
    global $link_option;
    global $d;
    if($d->checkPermission_dele($id_module)==1){
        if(isset($_GET['id'])){
            $id =  addslashes($_GET['id']);
            $hinhanh = $d->o_fet("select * from #_files where id_code = '".$id."'");
            //@unlink('../uploads/images/'.$hinhanh[0]['hinh_anh']);
            $d->reset();
            $d->setTable('#_files');
            $d->setWhere('id_code',$id);
            if($d->delete()){
                $d->o_que("delete from cf_parent where id = $id ");
                $d->redirect("index.php?p=upload-file&a=man&page=".@$_REQUEST['page']."&loaitin=".@$_GET['loaitin']);
            }else{
                $d->alert("Xóa dữ liệu bị lỗi!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=upload-file&a=man".$link_option);
            }
        }else {
            $d->alert("Không nhận được dữ liệu!");
            $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=upload-file&a=man".$link_option);
        }
    }else{
        $d->redirect("index.php?p=upload-file&a=man".$link_option);
    }
	
}

function xoadulieu_mang($id_module){
    global $d;
    if($d->checkPermission_dele($id_module)==1){
        if(isset($_POST['chk_child'])){
            $chuoi = "";
            foreach ($_POST['chk_child'] as $val) {
                    $chuoi .=$val.',';
            }
            $chuoi = trim($chuoi,',');
            //lay danh sách idsp theo chuoi
            $hinhanh = $d->o_fet("select * from #_files where id_code in ($chuoi) and lang ='".LANG."'");
            if($d->o_que("delete from #_files where id_code in ($chuoi)")){
                 $d->o_que("delete from cf_parent where id in ($chuoi) ");
                //xoa hình ảnh
                foreach ($hinhanh as $ha) {
                    //@unlink('../uploads/images/'.$ha['hinh_anh']);
                }
                $d->redirect("index.php?p=upload-file&a=man&page=".@$_REQUEST['page']."&loaitin=".@$_GET['loaitin']);
            }
            else{
                $d->alert("Không nhận được dữ liệu!");
                $d->redirect("Xóa dữ liệu bị lỗi", "index.php?p=upload-file&a=man".$link_option);
            } 
        }else $d->redirect("index.php?p=upload-file&a=man".$link_option);
    }else{
        $d->redirect("index.php?p=upload-file&a=man".$link_option);
    }
	
	
}
?>
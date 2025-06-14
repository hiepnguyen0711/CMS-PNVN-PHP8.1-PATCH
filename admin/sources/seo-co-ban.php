<?php
if(!defined('_source')) die("Error");
$a = (isset($_REQUEST['a'])) ? addslashes($_REQUEST['a']) : "";

switch($a){
	case "man":
		showdulieu();
		$template = @$_REQUEST['p']."/them";
		break;
	case "save":
		luudulieu();
		break;
	default:
		$template = "index";
}
function showdulieu(){
    global $d, $item, $robots;
    if(isset($_REQUEST['p'])){
        $item = $d->o_fet("select * from #_seo where id=1 ");	
        $robots ='';
	$file = fopen("../robots.txt", "r") or exit("Không mở được file!");
	while(!feof($file))
	{
            $robots .= fgets($file);
	}
	fclose($file);
    }
}

function luudulieu(){
	global $d;
        foreach (get_json('lang') as $key => $value) {
            $row = $d->simple_fetch("select * from #_seo where lang = '".$value['code']."' ");
            $data['title']          =   addslashes($_POST['title'][$key]);
            $data['keyword']        =   addslashes($_POST['keyword'][$key]);
            $data['des']   =   addslashes($_POST['des'][$key]);
            $data['lang']           =   $value['code'];
            if(count($row)>0){
                $d->reset();
                $d->setTable('#_seo');
                $d->setWhere('id', $row['id']);
                $d->update($data);
            }else{
                $d->reset();
                $d->setTable('#_seo');
                $d->insert($data);
            }
        }
	echo $d->redirect("index.php?p=seo-co-ban&a=man");
	
}
?>
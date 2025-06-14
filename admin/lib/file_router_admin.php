<?php
	$p = (isset($_REQUEST['p'])) ? addslashes($_REQUEST['p']) : "";
        $row_module = $d->simple_fetch("select * from #_module_admin where alias='$p'");
        $id_module = $row_module['id'] ?? 0;
	if($p == ''){
		$source = "";
		$template = "index";
	}else if($p=='out'){
            session_destroy();
			if (isset($_COOKIE['key_ad']) and $_COOKIE['key_ad'] != '0') {
				
				setcookie('key_ad', '', time() - 3600, '/', NULL, NULL, TRUE);
			}
            $d->redirect("login.php");
	}
	else{
            $source = $p;
	}
	if(!empty($p) and $d->checkPermission($_SESSION['id_user'] ?? 0,$id_module)==0 and $p!='thongtin-user'){
            $d->redirect("index.php");
	}
        //echo $source;
	if($source!="") @include "sources/".$source.".php";
?>
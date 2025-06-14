<?php
if(!defined('_source')) die("Error");
$a = (isset($_REQUEST['a'])) ? addslashes($_REQUEST['a']) : "";
switch($a){
	case "man":
		$template = @$_REQUEST['p']."/hienthi";
		break;
	case "add":
		$template = @$_REQUEST['p']."/them";
		break;
	case "edit":
		$template = @$_REQUEST['p']."/them";
		break;
	case "save":
		break;
	case "delete":
		break;
	case "delete_all":
		break;
	default:
		$template = "index";
}

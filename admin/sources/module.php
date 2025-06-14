<?php
if(!defined('_source')) die("Error");
$a = (isset($_REQUEST['a'])) ? addslashes($_REQUEST['a']) : "";
switch($a){
    case "man":
        $template = @$_REQUEST['p']."/hienthi";
        break;
    default:
        $template = "index";
}
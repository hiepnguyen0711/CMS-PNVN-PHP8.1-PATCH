<?php

if(!defined('_source')) die("Error");
$a = (isset($_REQUEST['a'])) ? addslashes($_REQUEST['a']) : "";
switch($a){
    case "man":
        showdulieu();
        $template = @$_REQUEST['p']."/hienthi";
    break;
    default:
    $template = "index";
}
function showdulieu(){
    global $d, $items;
    $items = $d->o_fet("select * from #_user where id =  ".$_SESSION['id_user']." ");
}



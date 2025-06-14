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
        
    }
}

function luudulieu(){
    global $d;
    
}
?>
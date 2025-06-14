<?php
if (!defined('_source')) die("Error");
$a = (isset($_REQUEST['a'])) ? addslashes($_REQUEST['a']) : "";
switch ($a) {
    case "man":
        showdulieu();
        $template = @$_REQUEST['p'] . "/hienthi";
        break;
    default:
        $template = "index";
}
function showdulieu()
{
    global $d, $items;
    $items = $d->o_fet("select * from #_text order by id ASC");
    // for theo ngôn ngữ

    // foreach ($items as $value) {
    //     foreach ($value as $v) {
    //         $arr = json_decode($v, true);
    //         foreach ($arr as $v2) {
    //             $arr2 = array();
    //             $arr2['hu'] = addslashes($v2 . " (hu)");
    //             $arr2['us'] = addslashes($v2 . " (us)");
    //             $arr2 = json_encode($arr2, JSON_UNESCAPED_UNICODE);
    //             $data['text'] = $arr2;
    //             // dd($arr2);
    //             $d->reset();
    //             $d->setTable('#_text');
    //             $d->setWhere('id', $value['id']);
    //             $d->update($data);
    //         }
    //     }
    // }
}

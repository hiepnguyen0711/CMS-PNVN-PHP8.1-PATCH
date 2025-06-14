<?php
if (!defined('_source')) die("Error");
$a = (isset($_REQUEST['a'])) ? addslashes($_REQUEST['a']) : "";
switch ($a) {
    case "man":
        showdulieu();
        $template = @$_REQUEST['p'] . "/hienthi";
        break;
    case "add":
        showdulieu();
        $template = @$_REQUEST['p'] . "/them";
        break;
    case "edit":
        showdulieu($id_module);
        $template = @$_REQUEST['p'] . "/them";
        break;
    case "save":
        luudulieu();
        break;
    case "delete":
        xoadulieu();
        break;
    case "delete_all":
        xoadulieu_mang();
        break;
    default:
        $template = "index";
}
function showdulieu()
{
    global $d, $items;
    $items = $d->o_fet("select * from #_thongtin where id =  1 ");
}
function luudulieu()
{
    global $d;
    $id = 1;
    $file_name = $d->fns_Rand_digit(0, 9, 12);
    if ($d->checkPermission_edit($id_module) == 1) {

        foreach (get_json('lang') as $key => $value) {
            $row = $d->simple_fetch("select * from #_thongtin where lang = '" . $value['code'] . "' ");
            $data['favicon']    =   addslashes($_POST['favicon'][$key]);
            $data['icon_share'] =   addslashes($_POST['icon_share'][$key]);
            $data['banner_share'] =   addslashes($_POST['banner_share'][$key]);
            $data['company']    =   $d->clear(addslashes($_POST['company'][$key]));
            $data['hotline']    =   $d->clear(addslashes($_POST['hotline'][$key]));
            $data['giolamviec']    =   $d->clear(addslashes($_POST['giolamviec'][$key]));
            $data['address']    =   $d->clear(addslashes($_POST['address'][$key]));
            $data['website']    =   $d->clear(addslashes($_POST['website'][$key]));
            $data['twitter']    =   $d->clear(addslashes($_POST['twitter'][$key]));
            $data['facebook']   =   $d->clear(addslashes($_POST['facebook'][$key]));
            $data['linkedin']   =   $d->clear(addslashes($_POST['linkedin'][$key]));
            $data['dien_thoai'] =   $d->clear(addslashes($_POST['dien_thoai'][$key]));
            $data['zalo']       =   $d->clear(addslashes($_POST['zalo'][$key]));
            $data['lazada']       =   $d->clear(addslashes($_POST['lazada'][$key]));
            $data['shopee']       =   $d->clear(addslashes($_POST['shopee'][$key]));
            $data['tiktok']       =   $d->clear(addslashes($_POST['tiktok'][$key]));
            $data['email']      =   $d->clear(addslashes($_POST['email'][$key]));
            $data['coppy_right'] =  $d->clear(addslashes($_POST['coppy_right'][$key]));
            $data['map']        =   check_shell(addslashes($_POST['map'][$key]));
            $data['messenger']  =   $d->clear(addslashes($_POST['messenger'][$key]));
            $data['youtube']    =   $d->clear(addslashes($_POST['youtube'][$key]));
            $data['pinterest']  =   $d->clear(addslashes($_POST['pinterest'][$key]));
            $data['instagram']  =   $d->clear(addslashes($_POST['instagram'][$key]));
            $data['skype']      =   $d->clear(addslashes($_POST['skype'][$key]));
            $data['whatsapp']   =   $d->clear(addslashes($_POST['whatsapp'][$key]));
            $data['telegram']   =   $d->clear(addslashes($_POST['telegram'][$key]));
            $data['site_key']   =   $d->clear(addslashes($_POST['site_key'][$key]));
            $data['secret_key']   =   $d->clear(addslashes($_POST['secret_key'][$key]));
            $data['zalo_qr']       =   $d->clear(addslashes($_POST['zalo_qr'][$key]));
            $data['reddit']       =   $d->clear(addslashes($_POST['reddit'][$key]));
            $data['discord']       =   $d->clear(addslashes($_POST['discord'][$key]));
            $data['lang']           =   $value['code'];
            if (count($row) > 0) {
                $d->reset();
                $d->setTable('#_thongtin');
                $d->setWhere('id', $row['id']);
                $d->update($data);
            } else {
                $d->reset();
                $d->setTable('#_thongtin');
                $d->insert($data);
            }
        }
        $d->redirect("index.php?p=" . $_GET['p'] . "&a=man");
    } else {
        $d->redirect("index.php?p=" . $_GET['p'] . "&a=man");
    }
}

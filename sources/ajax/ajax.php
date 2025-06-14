<?php
include "ajax-config.php";

$do = validate_content($_POST['do']);
if ($do == 'change_so_luong') {
    $id_code_sp = (int)$_POST['id'];
    $so_luong = (int)$_POST['sl'];
    $_SESSION['cart'][$id_code_sp]['so_luong'] = $so_luong;
} elseif ($do == 'xoa_sp_gh') {
    $id_code_sp = (int)$_POST['id'];
    unset($_SESSION['cart'][$id_code_sp]);
} elseif ($do == 'get_img_product') {
    $id_tt = (int)$_POST['id'];
    $thuoctinh = $d->simple_fetch("select * from #_sanpham_chitiet where id = '" . $id_tt . "' ");
} elseif ($do == 'get_gia_product') {
    $id_tt = (int)$_POST['id'];
    $thuoctinh = $d->simple_fetch("select * from #_sanpham_chitiet where id = '" . $id_tt . "' ");
    echo '<span>' . numberformat($thuoctinh['gia']) . '<sup>đ</sup></span>';
} elseif ($do == 'get_total_page') {
    if ($_POST['chuyenmuc'] != '') {
        $id_loai        =   trim(validate_content($_POST['chuyenmuc']), ',');
        $arr_loai = explode(',', $id_loai);
        $str_id_loai = '';
        for ($i = 0; $i < count($arr_loai); $i++) {
            $str_id_loai .= $arr_loai[$i] . $d->getIdsub($arr_loai[$i]) . ',';
        }
        if (trim($str_id_loai, ',') != '') {
            $where_loai = " and db_sanpham.id_loai in (" . trim($str_id_loai, ',') . ") ";
        } else {
            $where_loai = '';
        }
    } else {
        $where_loai = '';
    }
    $count_sp = $d->num_rows("SELECT db_sanpham.* FROM `db_sanpham` JOIN db_sanpham_chitiet ON db_sanpham.id_code = db_sanpham_chitiet.id_sp WHERE  db_sanpham.hien_thi =1 $where_loai $where_thuoctinh " . _where_lang . " GROUP BY db_sanpham.id_code order by db_sanpham.so_thu_tu ASC, db_sanpham_chitiet.id DESC");
    $limit = 20; //get_json('product', 'paging');
    echo $total_page = ceil($count_sp / $limit);
} elseif ($do == 'get_huyen') {
    $code_tinh = addslashes($_POST['code_tinh']);
    echo '<option value="" >Chọn Quận / Huyện</option>';
    foreach ($d->getHuyen($code_tinh, 'code, ten') as $key => $value) {
        echo '<option value="' . $value['code'] . '" >' . $value['ten'] . '</option>';
    }
} elseif ($do == 'get_xa') {
    $code_huyen = addslashes($_POST['code_huyen']);
    echo '<option value="" >Chọn phường/xã</option>';
    foreach ($d->getXa($code_huyen, 'code,ten') as $key => $value) {
        echo '<option value="' . $value['code'] . '" >' . $value['ten'] . '</option>';
    }
} elseif ($do == 'delete_cart') {
    $id_cart = addslashes($_POST['id_cart']);
    unset($_SESSION['cart'][$id_cart]);
} elseif ($do == 'update_giasp') {
    $id_sp = (int)$_POST['id'];
    $gia = (int)$_POST['gia'];
    if ($gia > 0) {
        if ($d->o_que("update #_sanpham_ctv set gia= '$gia' where id = $id_sp ")) {
            echo number_format($gia) . '<sup>đ</sup>';
        } else {
            echo 0;
        }
    }
} elseif ($do == 'get_linkshare') {
    $id_sp = (int)$_POST['id'];
    $sp_share =  $d->simple_fetch("select * from #_sanpham_ctv where id = " . $id_sp . " ");
    $sp = $d->simple_fetch("select * from #_sanpham where id_code = " . $sp_share['id_sp'] . " ");
    $url_share = URLPATH . $sp['alias'] . '.html?token_share=' . $sp_share['token'];
?>
    <div class="btn-group chiase-link">
        <input class="btn form-control input-linl" id="link_share2" value="<?= $url_share ?>" />
        <button class="btn btn-coppylink" id="btn-coppylink" onclick="coppylink2()" onmouseout="outFunc()">
            <span class="tooltiptext" id="myTooltip">Copy to clipboard</span>
            <?= $d->getTxt(79) ?>
        </button>
    </div>
    <div class="link_chiase">
        <!-- Facebook Share Button -->
        <a class="button_share share facebook" href="http://www.facebook.com/sharer/sharer.php?u=<?= $url_share ?>"><i class="fab fa-facebook-f"></i> Facebook</a>
        <!-- Twitter Share Button -->
        <a class="button_share share twitter" href="https://twitter.com/intent/tweet?text=<?= $sp['ten'] ?>&url=<?= $url_share ?>"><i class="fab fa-twitter"></i> Tweet</a>
        <!-- Stumbleupon Share Button -->
        <a class="button_share share stumbleupon" href="http://www.stumbleupon.com/submit?url=<?= $url_share ?>&title=<?= $sp['ten'] ?>"><i class="fab fa-stumbleupon"></i> Stumble</a>
        <!-- Pinterest Share Button -->
        <a class="button_share share pinterest" href="http://pinterest.com/pin/create/button/?url=<?= $url_share ?>&description=<?= $sp['ten'] ?>&media=<?= URLPATH ?>img_data/images/<?= $sp['hinh_anh'] ?>"><i class="fab fa-pinterest"></i> Pin it</a>
        <!-- LinkedIn Share Button -->
        <a class="button_share share linkedin" href="http://www.linkedin.com/shareArticle?mini=true&url=<?= $url_share ?>&title=<?= $sp['ten'] ?>&source=<?= $url_share ?>"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
        <!-- Buffer Share Button -->
        <a class="button_share share buffer" href="https://buffer.com/add?text=<?= $sp['ten'] ?>&url=<?= $url_share ?>"><i class="fab fa-buffer"></i> Buffer</a>
    </div>
    <button type="button" data-fancybox-close="" class="fancybox-button fancybox-close-small" title="Close"><svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
            <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
        </svg></button>
<?php } ?>
<?php
include "ajax-config.php";
$do = validate_content($_POST['do']);
$soluong = (isset($_POST['quantity']) && $_POST['quantity'] > 0) ? htmlspecialchars($_POST['quantity']) : 1;
$id_sp = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$code = (isset($_POST['code'])) ? htmlspecialchars($_POST['code']) : '';
$color = (isset($_POST['color'])) ? htmlspecialchars($_POST['color']) : '';
$size = (isset($_POST['size'])) ? htmlspecialchars($_POST['size']) : '';
$left_eye_select = (isset($_POST['left_eye_select'])) ? htmlspecialchars($_POST['left_eye_select']) : '';
$right_eye_select = (isset($_POST['right_eye_select'])) ? htmlspecialchars($_POST['right_eye_select']) : '';
$shippingCost = (isset($_POST['shipping_cost'])) ? floatval($_POST['shipping_cost']) : 0;

if ($do == 'addcartnow') {
    $d->addtocart($soluong, $id_sp, $color, $size, $left_eye_select, $right_eye_select);
    $sl_load = count($_SESSION['cart']);
    unset($num_cart);
    for ($i = 0; $i < count($_SESSION['cart']); $i++) {
        $num_cart = $num_cart + $_SESSION['cart'][$i]['soluong'];
    }

    echo $num_cart;
} else if ($do == 'update-cart') {
    if (isset($_SESSION['cart'])) {
        $max = count($_SESSION['cart']);
        for ($i = 0; $i < $max; $i++) {
            if ($code == $_SESSION['cart'][$i]['code']) {
                if ($soluong) $_SESSION['cart'][$i]['soluong'] = $soluong;
                break;
            }
        }
    }

    $proinfo = $d->simple_fetch("select * from #_sanpham where id_code={$id_sp} ");

    if ($proinfo['khuyen_mai']) {
        $gia = format_gia($proinfo['khuyen_mai'] * $soluong, "<sup>đ</sup>");
    } else {
        $gia = format_gia($proinfo['gia'] * $soluong, "<sup>đ</sup>");
    }

    // Tính tổng tiền sản phẩm không bao gồm phí vận chuyển
    $totalProductPrice = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $qty = 0;
        foreach ($_SESSION['cart'] as $key => $value) {
            $product = $d->simple_fetch("select * from #_sanpham where id_code={$value['productid']}");
            $price = ($product['khuyen_mai'] != 0) ? $product['khuyen_mai'] : $product['gia'];
            $totalProductPrice += $price * $value['soluong'];
            $qty += $value['soluong'];
        }
    }

    // Tính tổng tiền bao gồm phí vận chuyển
    $tongtien = $totalProductPrice + $shippingCost;

    // Định dạng lại giá tiền cho phản hồi
    $tongtienText = number_format($tongtien) ;
    $data = array(
        'gia' => $gia,
        'tongtien' => $tongtienText,
        'soluongsp' => $qty,
        'totalProductPrice' => $totalProductPrice
    );
    echo json_encode($data);
}

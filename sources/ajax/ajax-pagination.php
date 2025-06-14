<?php
include "ajax-config.php";
$do = validate_content($_POST['do']);

if ($do == 'pagination_tintuc') {
    $current_page   =   addslashes($_POST['page']);
    $id_loai        =   addslashes($_POST['chuyenmuc']);
    $total_page     =   addslashes($_POST['totalPages']);
    $limit          =   addslashes($_POST['limit']);
    if ($current_page > $total_page) {
        $current_page = $total_page;
    } else if ($current_page < 1) {
        $current_page = 1;
    }
    $start = ($current_page - 1) * $limit;
    // dd($_SESSION['lang']);
    $tintuc    =   $d->o_fet("select * from #_tintuc where id_loai in ($id_loai) and hien_thi = 1 and lang = '" . $_SESSION['lang'] . "' order by so_thu_tu ASC, id DESC limit $start,$limit ");
    // dd($tintuc);
    foreach ($tintuc as $key => $v) {

?>
        <!-- tin tuc item -->
        <div class="col">
            <?php include '../module/sca-new-item-horizontal.php'; ?>
        </div>

    <?php } ?>
<?php
} elseif ($do == 'pagination_sanpham') {
    $id_loai   =   addslashes($_POST['chuyenmuc']);
    $current_page   =   addslashes($_POST['page']);
    $total_page     =   addslashes($_POST['totalPages']);
    $limit          =   addslashes($_POST['limit']);
    $sale   =   addslashes($_POST['sale']);
    if ($current_page > $total_page) {
        $current_page = $total_page;
    } else if ($current_page < 1) {
        $current_page = 1;
    }
    $start = ($current_page - 1) * $limit;
    if ($sale == 0) {
        $sanpham = $d->o_fet("select * from #_sanpham where id_loai in ($id_loai) and hien_thi = 1 " . $where_lang . " order by so_thu_tu ASC, id DESC limit $start,$limit ");
    } else {
        $sanpham = $d->o_fet("select * from #_sanpham where id_loai in ($id_loai) and hien_thi = 1 and khuyen_mai != 0 " . $where_lang . " order by so_thu_tu ASC, id DESC limit $start,$limit ");
    }
?>
    <?php foreach ($sanpham as $key => $v) { ?>


        <div class="col">
            <?php include '../module/nb-product-item.php'; ?>
        </div>

    <?php } ?>

<?php } elseif ($do == 'pagination_sanpham_new') {
    $id_loai   =   $_POST['chuyenmuc'];
    $current_page   =   $_POST['page'];
    $total_page     =   $_POST['totalPages'];
    $limit          =   $_POST['limit'];
    if ($current_page > $total_page) {
        $current_page = $total_page;
    } else if ($current_page < 1) {
        $current_page = 1;
    }
    $start = ($current_page - 1) * $limit;

    $sanpham = $d->o_fet("select * from #_sanpham where hien_thi = 1 " . $where_lang . " order by ngay_dang desc, cap_nhat DESC limit $start,$limit ");
?>
    <?php foreach ($sanpham as $key => $v) { ?>
        <div class="col">
            <?php include "../module/ak-product-item.php"; ?>
        </div>
    <?php } ?>

<?php } elseif ($do == 'pagination_sanpham2') {
    $id_loai   =   $_POST['chuyenmuc'];
    $current_page   =   $_POST['page'];
    $total_page     =   $_POST['totalPages'];
    $limit          =   $_POST['limit'];
    $sale   =   $_POST['sale'];
    if ($current_page > $total_page) {
        $current_page = $total_page;
    } else if ($current_page < 1) {
        $current_page = 1;
    }
    $start = ($current_page - 1) * $limit;
    if ($sale == 0) {
        $sanpham = $d->o_fet("select * from #_sanpham where brand in ($id_loai) and hien_thi = 1 " . $where_lang . " order by so_thu_tu ASC, id DESC limit $start,$limit ");
    } else {
        $sanpham = $d->o_fet("select * from #_sanpham where brand in ($id_loai) and hien_thi = 1 and khuyen_mai != 0 " . $where_lang . " order by so_thu_tu ASC, id DESC limit $start,$limit ");
    }
?>
    <?php foreach ($sanpham as $key => $v) { ?>


        <div class="col">
            <?php include '../module/nb-product-item.php'; ?>
        </div>

    <?php } ?>


<?php } ?>

<!-- Intersection Observer Lazy Load Ảnh -->
<script>
    $(document).ready(function() {
        // Lazy load ảnh
        const imagesToLazyLoad = document.querySelectorAll('img[data-src]');

        const options = {
            root: null, // Không theo dõi một phần cụ thể nào, tức là cả viewport
            rootMargin: '0px', // Điều kiện rìa không cần điều chỉnh
            threshold: 0, // Ngưỡng sự xuất hiện của ảnh, 0.1 có nghĩa là 10% hiện trong viewport
        };

        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const lazyImage = entry.target;
                    lazyImage.src = lazyImage.dataset.src;
                    // lazyImage.removeAttribute('data-src');
                    imageObserver.unobserve(lazyImage);

                    // Thêm lớp CSS "animate" để kích hoạt hiệu ứng
                    lazyImage.classList.add('animate');
                }
            });
        }, options);

        imagesToLazyLoad.forEach((image) => {
            imageObserver.observe(image);
        });

        // 
    });
</script>
<div class="zc-page-content" data-aos="fade-in" data-aos-duration="2000" data-aos-delay="0">
    <h1><?= $d->gettxt(140) ?> <span class="title-main-color"><?= $d->gettxt(133) ?></span></h1>
    <div class="zc-page-content-text">
        <?= $row['noi_dung'] ?>
    </div>
</div>



<script>
    $(document).ready(function() {

        // Lấy tất cả img trong .news-details
        const images = $('.zc-page-content-text img');
        images.each(function() {
            // Lấy đường dẫn hình ảnh
            let src = $(this).attr('src');

            // Tạo thẻ <a>
            let a = $('<a>');
            a.attr('data-fancybox', 'images');
            a.attr('href', src);

            // Chuyển img thành con của thẻ <a>
            $(this).wrap(a);
        });


    });
</script>
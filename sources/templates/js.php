<?php
?>
<script src="templates/js/bootstrap.bundle.min.js"></script>
<script src="templates/js/jquery.matchHeight-min.js"></script>
<!-- <script type="text/javascript" src="assets/js/nice-select.js"></script> -->
<link rel="stylesheet" href="templates/css/jquery.fancybox.min.css" />
<!-- <script type="text/javascript" src="templates/module/slick/js/slick.js"></script> -->
<!-- <script type="text/javascript" src="templates/module/owlcarousel/owl.carousel.min.js"></script> -->
<script src="templates/module/sweetalert/sweetalert2.min.js"></script>
<!-- <script type="text/javascript" src="templates/js/jssor.js"></script>
<script type="text/javascript" src="templates/js/jssor.slider.js"></script>
<script type="text/javascript" src="templates/js/js_jssor_slider.js"></script> -->
<script type="text/javascript" src="templates/js/cart.js"></script>
<script src="templates/module/swiper/swiper.min.js"></script>
<script src="templates/js/jquery.fancybox.min.js"></script>
<!-- <script src="fontawesome-free-6.3.0-web/js/all.js"></script> -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<!-- câu chuyện swiper start -->


<!-- Initialize Swiper -->
<script>
  var swiperxxx = new Swiper(".cau-chuyen-nnv-swiper", {
    slidesPerView: 3,
    loop: false,
    spaceBetween: 10,
    speed: 2000,
    direction: "vertical",
    // autoplay:true,
    centeredSlides: true,
    // pagination: {
    //   el: ".swiper-pagination",
    //   clickable: true,
    // },
    breakpoints: {
      640: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
      768: {
        slidesPerView: 3,
        spaceBetween: 40,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 50,
      },
    },
  });


  var swiperxxxmain = new Swiper(".cau-chuyen-nnv-swiper-main", {
    loop: false,
    spaceBetween: 10,
    autoplay: true,
    speed: 2000,
    thumbs: {
      swiper: swiperxxx,
    },
    breakpoints: {
      1024: {
        direction: "vertical",
      },
    },
  });
</script>
<!-- câu chuyện swiper end -->


<!-- khách hàng number Swiper -->
<script>
  var sca_swiper_customer_number = new Swiper(".sca-customer-number-swiper", {
    direction: "horizontal",
    slidesPerView: 3,
    spaceBetween: 10,
    centeredSlides: true,
    freeMode: true,
    watchSlidesProgress: true,
    breakpoints: {
      1024: {
        slidesPerView: 3,
        spaceBetween: 10,
        direction: "vertical",
      },
    },
  });
</script>
<!-- Initialize Swiper -->
<script>
  var sca_swiper_customer_list = new Swiper(".sca-swiper-customer-item-list", {
    // navigation: {
    //   nextEl: ".swiper-button-next",
    //   prevEl: ".swiper-button-prev",
    // },
    thumbs: {
      swiper: sca_swiper_customer_number,
    },
    freeMode: true,
    speed: 2000,
    autoplay: {
      // delay: 0,
    }
  });
</script>

<!-- tin tức Swiper -->
<script>
  var sca_swiper_news = new Swiper(".sca-news-index-swiper", {
    slidesPerView: 1,
    spaceBetween: 10,
    navigation: {
      nextEl: ".sca-news-box-content-top-subitem-next",
      prevEl: ".sca-news-box-content-top-subitem-prev",
    },
    speed: 2000,
    autoplay: true,
    loop: true,
    breakpoints: {
      640: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
    },
  });
</script>







<!-- slider trang chủ -->
<script>
  var swiper_slider = new Swiper(".hq-swiper-slider", {
    autoplay: true,
    speed: 1500,
    // effect: "fade",
    loop: true,

    navigation: {
      nextEl: ".nb-slider-navigation-next",
      prevEl: ".nb-slider-navigation-prev",
    },
    // navigation: {
    //   nextEl: ".swiper-button-next",
    //   prevEl: ".swiper-button-prev",
    // },
  });
</script>






<script>
  $(document).ready(function() {
    // Lấy tất cả img trong .sanpham-details
    const imagesvh = $('.vanhiep-content img');
    imagesvh.each(function() {
      // Lấy đường dẫn hình ảnh
      let src = $(this).attr('src');
      // Tạo thẻ <a>
      let a = $('<a>');
      a.attr('data-fancybox', 'images');
      a.attr('href', src);

      // Chuyển img thành con của thẻ <a>
      $(this).wrap(a);

    });
    // Lấy tất cả img trong .sanpham-details
    const images = $('.vs-product-detail-content-box-text img');

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


    // Lấy tất cả img trong .sanpham-details
    const imagesc = $('.vs-product-detail-content-card img');

    imagesc.each(function() {
      // Lấy đường dẫn hình ảnh
      let src = $(this).attr('src');

      // Tạo thẻ <a>
      let a = $('<a>');
      a.attr('data-fancybox', 'images');
      a.attr('href', src);

      // Chuyển img thành con của thẻ <a>
      $(this).wrap(a);

    });


    // Lấy tất cả img trong .tintuc-details
    const images_t = $('.tin-tuc-detail section img');

    images_t.each(function() {
      // Lấy đường dẫn hình ảnh
      let src = $(this).attr('src');

      // Tạo thẻ <a>
      let a = $('<a>');
      a.attr('data-fancybox', 'images');
      a.attr('href', src);

      // Chuyển img thành con của thẻ <a>
      $(this).wrap(a);

    });


  })
</script>






<!-- AOS -->
<script>
  AOS.init();
</script>
<!-- AOS END -->

<!-- Intersection Observer Lazy Load Ảnh -->
<script>
  $(document).ready(function() {

    // sửa lazy load ảnh
    const imagesToLazyLoad = document.querySelectorAll('img[data-src]');
    imagesToLazyLoad.forEach((element) => {
      const dataSrc = element.getAttribute('data-src');
      if (dataSrc != "") {
        element.setAttribute('src', '<?= URLPATH . "/img_data/no-image.png" ?>');
      }
    });

    // sửa lazy load ảnh end

    const options = {
      root: null, // Không theo dõi một phần cụ thể nào, tức là cả viewport
      rootMargin: '100px', // Điều kiện rìa không cần điều chỉnh
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




<!-- Backtotop -->
<script>
  $(document).ready(function() {
    // $('body').append('<div id="toTop"><i class="fa-solid fa-chevron-up"></i></div> ');
    // $(window).scroll(function() {
    //   if ($(this).scrollTop() > 100) {
    //     $('#toTop').fadeIn();
    //   } else {
    //     $('#toTop').fadeOut();
    //   }
    // });
    // $('#toTop').click(function() {
    //   $("html, body").animate({
    //     scrollTop: 0
    //   }, 600);
    //   return false;
    // });
  });
</script>


<script>
  $(function() {
    $('.col-text').matchHeight();
  });
</script>




<!-- Contact -->
<script>
  <?php if (isset($thongbao_tt) and $thongbao_tt != "") { ?>
    Swal.fire({
      title: '<?= $thongbao_tt ?>',
      text: '<?= $thongbao_content ?>',
      icon: '<?= $thongbao_icon ?>',
      button: false,
      timer: 2000
    }).then((value) => {
      window.location = "<?= $thongbao_url ?>";
    });
  <?php } ?>
</script>


<!-- Product detail -->

<script>
  function goBack() {
    window.history.back();
  }
</script>

<!-- Script Index -->

<?php if ($com == '') { ?>






  <!-- 
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const tabButtons = document.querySelectorAll(".nav-link");
      const tabContents = document.querySelectorAll(".tab-pane");
      let activeIndex = null; // Lưu trạng thái active index

      tabButtons.forEach((button, index) => {
        button.addEventListener("mouseenter", () => {
          removeActiveClasses();
          button.classList.add("active");
          tabContents[index].classList.add("show", "active");
          activeIndex = index; // Lưu index khi hover
        });

        button.addEventListener("mouseleave", () => {
          // Chỉ bỏ lớp active khỏi button, không bỏ khỏi tab-content
          button.classList.remove("active");
        });
      });



      function removeActiveClasses() {
        tabButtons.forEach(button => {
          button.classList.remove("active");
        });

        tabContents.forEach(content => {
          content.classList.remove("show", "active");
        });
      }
    });
  </script> -->




<?php } ?>
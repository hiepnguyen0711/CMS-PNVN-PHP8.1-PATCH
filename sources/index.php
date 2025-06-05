<!-- số chạy -->
<!-- <script>
    var isAlreadyRun = false;
    $(window).scroll(function() {
        var bottom_of_window = $(window).scrollTop() + $(window).height();
        var bottom_of_object = $('.sca-impressive-number-content-subitem-title').position().top;

        if (bottom_of_object - bottom_of_window < 50) {
            if (!isAlreadyRun) {
                $('.sochay').each(function() {
                    var number = $(this).text().replace(/\./g, '');
                    $(this).prop('Counter', 0).animate({
                        Counter: number
                    }, {
                        duration: 3000,
                        easing: 'swing',
                        step: function(now) {
                            $(this).text(Math.ceil(now));
                        },
                        complete: function() {
                            var formattedNumber = parseInt($(this).text()).toLocaleString('en');
                            $(this).text(formattedNumber);
                        }
                    });
                });
            }
            isAlreadyRun = true;
        }

    });
</script> -->
<!-- chữ chạy start -->
<!-- 
<script src="https://unpkg.com/typeit@8.7.1/dist/index.umd.js"></script>

<script>
    var noi_dung = $("#noiDung").data('nd');
    new TypeIt('#myText', {
        speed: 50,
        hideCursor: true,
        afterComplete: function(instances) {
            instances.destroy();
            new TypeIt('#noiDung', {
                strings: noi_dung,
                speed: 30,
                hideCursor: true,
                afterComplete: function(instance) {
                    instance.destroy();
                }
            }).go();
        }
    }).go();
</script> -->
<!-- chữ chạy end -->
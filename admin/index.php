<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION["user_hash"])) {
    header("location: login.php");
    exit;
}

// Define constants for directories
define('_template', '/templates/');
define('_source', '/sources/');
define('_lib', '/lib/');

// Include necessary files
require_once "lib/config.php";
require_once "lib/function.php";
require_once "lib/class.php";

// Initialize database connection
global $d;
$d = new func_index();
$d->servername = $config['database']['servername'];
$d->username = $config['database']['username'];
$d->password = $config['database']['password'];
$d->database = $config['database']['database'];
$d->refix = $config['database']['refix'];
$d->connect();

// Set timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');


// Include the router and fetch logo
@include "lib/file_router_admin.php";
$logo = $d->showthongtin('logo');

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Administrator</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="img/icon.png" rel="shortcut icon" type="image/x-icon" />
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="public/plugin/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="public/plugin/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="public/plugin/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="public/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="public/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="public/css/vanhiep_admin.css">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <!-- jQuery 3 -->
    <script src="public/plugin/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="public/js/notify.min.js"></script>
    <script src="js/jquery.twbsPagination.js"></script>
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    <script src="public/js/jquery.fancybox.min.js"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">
        <?php @include('templates/header_tpl.php'); ?>
        <?php @include('templates/sidebar_tpl.php'); ?>
        <?php @include "templates/" . $template . "_tpl.php"; ?>
        <?php @include('templates/footer_tpl.php'); ?>
        <?php //@include('templates/sidebar_right_tpl.php'); 
        ?>
        <?php $d->disconnect() ?>
    </div>

    <!-- Bootstrap 3.3.7 -->
    <script src="public/plugin/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="public/plugin/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="public/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="public/js/demo.js"></script>
    <!-- Select2 -->
    <link rel="stylesheet" href="public/plugin/select2/css/select2.min.css">
    <script src="public/plugin/select2/js/select2.min.js"></script>
    <script src="public/plugin/select2/js/select2.multi-checkboxes.js"></script>
    <link rel="stylesheet" href="public/css/jquery.fancybox.min.css">
    <script rel="stylesheet" src="public/js/jquery.priceformat.js"></script>


    <script src="js/admin.js"></script>
    <!-- Audio element to play the sound -->
    <audio controls id="checkbox-sound" hidden>
        <source src="public/files/clickar.mp3" type="audio/mpeg">
    </audio>
    <audio controls id="checkbox-sound-disable" hidden>
        <source src="public/files/pop.mp3" type="audio/mpeg">
    </audio>
    <script>
        $(document).ready(function() {
            jqueryUpdate();
            $('.vh-checkbox').on('change', function() {
                if ($(this).is(':checked')) {
                    var audioElement = $('#checkbox-sound')[0];
                    audioElement.currentTime = 0; // Reset audio to start
                    audioElement.play();
                    return false;
                } else {
                    var audioElement = $('#checkbox-sound-disable')[0];
                    audioElement.currentTime = 0; // Reset audio to start
                    audioElement.play();
                    return false;
                }
            });

        });

        function jqueryUpdate() {
            $('.iframe-btn').fancybox({
                'type': 'iframe',
                'autoScale': false,
                width: 800,
                iframe: {
                    preload: false // fixes issue with iframe and IE
                }
            });
            // $('.select2-multiple').select2MultiCheckboxes({
            //     placeholder: "Choose your field",
            //     width: "auto"
            // })
            // $('.select2-multiple2').select2MultiCheckboxes({
            //     templateSelection: function(selected, total) {
            //         return "Selected " + selected.length + " of " + total + ' your field';
            //     }
            // })


            $(".a_stt").unbind('blur');
            $(".a_stt").on("blur", function() {
                var table = $(this).attr("data-table");
                var col = $(this).attr("data-col");
                var id = $(this).attr("data-id");
                var val = $(this).val();
                $.ajax({
                    url: "./sources/ajax.php",
                    type: "POST",
                    data: {
                        table: table,
                        col: col,
                        val: val,
                        id: id,
                        do: "update_stt"
                    },
                    dataType: "json",
                    success: function(data) {
                        $.notify(data.text, data.status);
                    },
                });
            });
        }

        $(".img-preview-hidden").change(function() {
            var field = $(this);
            var elTarget = field.data("target");
            var imagesURL = "<?= URLPATH ?>img_data/images/" + field.val();
            $(elTarget).attr("src", imagesURL);
        });

        function responsive_filemanager_callback(field_id) {
            var field = $("#" + field_id);
            $(field).trigger("change");
        }

        function deleteElement(element, messages = "Bạn có muốn thực hiện hành động xóa?") {
            if (confirm(messages)) {
                $(element).remove(element);
            }
        }
    </script>
    <script>
        $('.formatprice').priceFormat({
            limit: 13,
            prefix: '',
            centsLimit: 0
        });
    </script>

    <style>
        .fancybox-slide--iframe .fancybox-content {
            width: 800px;
            height: 600px;
            max-width: 80%;
            max-height: 80%;
            margin: 0;
        }
    </style>

</body>

</html>
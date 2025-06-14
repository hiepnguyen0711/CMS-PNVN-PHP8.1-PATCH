<?php
$user_login = $d->simple_fetch("select * from #_user where id = ".$_SESSION['id_user']." ");
?>
<header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="img/logo.png" />  </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="img/logo.png" /> Web admin </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </a>
        <a style="display: inline-block;padding: 15px 15px;color: #fff;" target="_blank" href="<?=URLPATH?>"><i class="fa fa-external-link"></i> Xem website</a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?php if($user_login['hinh_anh']!=''){ ?>
                     <img src="../img_data/images/<?=$user_login['hinh_anh']?>" class="user-image" alt="User Image">
                    <?php }else{?>
                     <img src="img/icon-user.png" class="user-image" alt="User Image">
                    <?php }?>
                    <span class="hidden-xs"><?=$_SESSION['name']?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php if($user_login['hinh_anh']!=''){ ?>
                             <img src="../img_data/images/<?=$user_login['hinh_anh']?>" class="img-circle" alt="User Image">
                            <?php }else{?>
                             <img src="img/icon-user.png" class="img-circle" alt="User Image">
                            <?php }?>
                           
                            <p>
                                <?=$_SESSION['name']?>
                                <small></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="index.php?p=thongtin-user&a=man" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="index.php?p=out" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
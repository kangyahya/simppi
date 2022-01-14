<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$getPengaturan = getData('pengaturan_aplikasi');
$pengaturan = null;
if ($getPengaturan) {
    $pengaturan = $getPengaturan[0];
}

$classText = "";
$avatarType = "default";
$showFullSidebar = 1;
if($pengaturan !== null) {
	$avatarType = strtolower($pengaturan->color_theme);
	if($pengaturan->show_full_sidebar == 0) {
		$showFullSidebar = 1;
		$classText = "class='sidebar-mini'";
	} else {
		$showFullSidebar = 0;
		$classText = "";
	}
}

$userPictureSrc = (getUser('picture') != '') ? getUser('picture') : "assets/img/avatar/avatar-$avatarType.png";
?>
<body <?php echo $classText; ?>>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li>
						<a href="#" onclick="showSidebar(<?= $showFullSidebar ?>)" data-toggle="sidebar" class="nav-link nav-link-lg text-white">
							<i class="fas fa-bars"></i>
						</a>
                    </li>
                </ul>
            </form>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown">
					<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="<?php echo base_url($userPictureSrc); ?>"
                             class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block">
							<?php echo getUser('nama_lengkap'); ?>
							<span class="font-weight-bold font-italic">(<?php echo str_replace("_", " ", getUser('level')); ?>)</span>
						</div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="<?php echo base_url('user/profile'); ?>" class="dropdown-item has-icon">
                            <i class="far fa-user"></i>
							<span> Profil</span>
                        </a>
                        <a href="<?php echo base_url('user/change-password'); ?>" class="dropdown-item has-icon">
                            <i class="fas fa-cog"></i>
							<span>Ubah Password</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" onclick="showConfirmLogout()" class="dropdown-item has-icon text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

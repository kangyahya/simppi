<?php
defined('BASEPATH') or exit('No direct script access allowed');
$uri1 = $this->uri->segment(1);
$uri2 = $this->uri->segment(2);

$pembayaran_penjualan_submenu = [
    //'bank',
	'keterangan', 'jenis-bayar', 'daftar-bayar', 'uang-masuk',
    'pembayaran-piutang'
];
$pembayaran_penjualan = "";
if (in_array($uri1, $pembayaran_penjualan_submenu)) {
    $pembayaran_penjualan = "active ";
}

$getPengaturan = getData('pengaturan_aplikasi');
$pengaturan = null;
if ($getPengaturan) {
    $pengaturan = $getPengaturan[0];
}
$appName = "Codepos App";
if ($pengaturan !== null) {
    $appName = $pengaturan->app_name;
}
$bank_dan_rekening_koran = "";
if($uri1 == "bank" || $uri1 == "rekening-koran") {
	$bank_dan_rekening_koran = "active ";
}
?>
<div class="main-sidebar sidebar-style-2">
	<aside id="sidebar-wrapper">
		<div class="sidebar-brand border-bottom border-primary">
			<a class="text-primary" href="<?= base_url('dashboard'); ?>"><?php echo $appName; ?></a>
		</div>
		<div class="sidebar-brand sidebar-brand-sm">
			<a href="<?= base_url('dashboard'); ?>">
                <?php
                $splittedAppName = explode(" ", $appName);
                $shortAppName = $splittedAppName[0][0] . $splittedAppName[1][0];
                echo $shortAppName;
                ?>
			</a>
		</div>
		<ul class="sidebar-menu">
			<li class="dropdown <?= $uri1 == '' || $uri1 == 'dashboard' ? 'active' : ''; ?>">
				<a href="<?= base_url('dashboard'); ?>" class="nav-link">
					<i class="fas fa-fire"></i><span>Dashboard</span>
				</a>
			</li>
            <?php if (showOnlyTo("1")): ?>
				<li class="dropdown <?= $uri1 == 'user' ? 'active' : ''; ?>">
					<a href="<?= base_url('user'); ?>" class="nav-link">
						<i class="fas fa-user-alt"></i><span>Pengguna</span>
					</a>
				</li>
            <?php endif; ?>
            <?php if (showOnlyTo("1")): ?>
				<li class="dropdown <?= $uri1 == 'utility' ? 'active' : ''; ?>">
					<a href="<?= base_url('utility'); ?>" class="nav-link">
						<i class="fas fa-database"></i><span>Backup &amp; Restore Data</span>
					</a>
				</li>
            <?php endif; ?>
            <?php if (showOnlyTo("1")): ?>
				<li class="dropdown <?= ($uri1 == 'profil-perusahaan' || $uri1 == 'pengaturan-aplikasi' || $uri1 == 'pengaturan') ? 'active' : '' ?>">
					<a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-cogs"></i> <span>Pengaturan</span>
					</a>
					<ul class="dropdown-menu">
						<li class="<?= ($uri1 == 'profil-perusahaan') ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('profil-perusahaan'); ?>">Profil Perusahaan</a>
						</li>
						<li class="<?= ($uri1 == 'pengaturan-aplikasi') ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('pengaturan-aplikasi'); ?>">Pengaturan Aplikasi</a>
						</li>
					</ul>
				</li>
            <?php endif; ?>
            <?php if (showOnlyTo("2")): ?>
				<li class="dropdown <?= $uri1 == 'user' && $uri2 == 'profile' ? 'active' : ''; ?>">
					<a href="<?= base_url('user/profile'); ?>" class="nav-link">
						<i class="fas fa-user-alt"></i><span>Profile</span>
					</a>
				</li>
				<li class="dropdown <?= $uri1 == 'user' && $uri2 == 'kta' ? 'active' : ''; ?>">
					<a href="<?= base_url('user/kta'); ?>" class="nav-link">
						<i class="fas fa-credit-card"></i><span>KTA</span>
					</a>
				</li>
            <?php endif; ?>
		</ul>
		<div class="mt-0 mb-4 p-3 hide-sidebar-mini">
			<a href="#" onclick="showConfirmLogout()" class="btn btn-danger text-white btn-lg btn-block btn-icon-split">
				<i class="fas fa-power-off"></i> <span>Logout</span>
			</a>
		</div>
	</aside>
</div>

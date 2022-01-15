<?php
$userPictureSrc = (getUser('picture') != '') ? getUser('picture') : 'assets/img/avatar/avatar-default.png';
?>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Kartu Tanda Anggota</h1>
			<div class="section-header-breadcrumb">
				<div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
				<div class="breadcrumb-item">KTA</div>
			</div>
		</div>
		<div class="section-body">
			<h2 class="section-title">KTA Pengguna</h2>
			<p class="section-lead">
				Halaman KTA.
			</p>

			<div class="row mt-sm-4">
				<div class="col-12 col-md-12 col-lg-5">
					<div class="card card-primary">
						<div class="card-header">
							<h4 class="card-title">Preview KTA</h4>
						</div>
						<div class="card-body text-center">
							<img alt="user-picture" src="<?php echo base_url($userPictureSrc); ?>" class="rounded-circle profile-widget-picture img-fluid" style="max-width: 160px;">
							<br><br>
							<h5><?php echo $user->nama_lengkap; ?></h5>
							<h6 class="badge badge-primary text-uppercase"><?php echo getUserLevel($user->level); ?></h6>
                            <a href="<?php echo site_url("user/cetak_kta");?>">Cetak KTA</a>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
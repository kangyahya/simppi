<?php
$userPictureSrc = (getUser('picture') != '') ? getUser('picture') : 'assets/img/avatar/avatar-default.png';
?>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Pengguna</h1>
			<div class="section-header-breadcrumb">
				<div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
				<div class="breadcrumb-item">Profile</div>
			</div>
		</div>
		<div class="section-body">
			<h2 class="section-title">Profil Pengguna</h2>
			<p class="section-lead">
				Halaman profil pengguna.
			</p>

			<div class="row mt-sm-4">
				<div class="col-12 col-md-12 col-lg-5">
					<div class="card card-primary">
						<div class="card-header">
							<h4 class="card-title">Profil Pengguna</h4>
						</div>
						<div class="card-body text-center">
							<img alt="user-picture" src="<?php echo base_url($userPictureSrc); ?>" class="rounded-circle profile-widget-picture img-fluid" style="max-width: 160px;">
							<br><br>
							<h5><?php echo $user->nama_lengkap; ?></h5>
							<h6 class="badge badge-primary text-uppercase"><?php echo getUserLevel($user->level); ?></h6>
						</div>
						<div class="card-footer text-center pt-0">
							<button type="button" data-toggle="modal" data-target="#form-upload-modal" class="btn btn-light btn-icon icon-left">
								<i class="fa fa-camera"></i>
								<span>Ubah Foto</span>
							</button>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-12 col-lg-7">
					<div class="card card-primary">
						<form method="post" class="needs-validation" action="<?php echo base_url('user/profile') ?>">
							<div class="card-header">
								<h4>Edit Profile</h4>
							</div>
							<div class="card-body">
								<div class="form-group row">
									<label for="" class="col-sm-3 col-form-label">Nama Lengkap</label>
									<div class="col-sm-9">
										<input type="text" required name="nama_lengkap" value="<?php echo $user->nama_lengkap; ?>" class="form-control" placeholder="Nama Lengkap" autocomplete="off">
                                        <?php echo form_error('nama_lengkap'); ?>
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-3 col-form-label">Username</label>
									<div class="col-sm-9">
										<input type="text" required name="username" value="<?php echo $user->username; ?>" class="form-control" placeholder="Username" autocomplete="off">
                                        <?php echo form_error('username'); ?>
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-3 col-form-label">E-mail</label>
									<div class="col-sm-9">
										<input type="text" required name="email" value="<?php echo $user->email; ?>" class="form-control" placeholder="Alamat email" autocomplete="off">
                                        <?php echo form_error('email'); ?>
									</div>
								</div>
								<?php if (showOnlyTo("1")): ?>
								<div class="form-group row">
									<label for="" class="col-sm-3 col-form-label">Jenis Pengguna</label>
									<div class="col-sm-9">
										<select name="level" id="inputSelect" required class="form-control">
											<option disabled>-- Pilih Level Pengguna --</option>
                                            <?php foreach ($user_levels as $key => $val): ?>
												<option <?= ($user->level == $key) ? 'selected' : 'disabled'; ?> value="<?php echo $key; ?>"><?php echo ucwords(strtolower(str_replace("_", " ", $val))); ?></option>
                                            <?php endforeach; ?>
										</select>
                                        <?php echo form_error('level'); ?>
									</div>
								</div>
								<?php endif; ?>
								<?php if(showOnlyTo("2")): ?>
									<input type="hidden" value="<?=$user->level?>" name="level">
								<div class="form-group row">
									<label for="" class="col-sm-3 col-form-label">Tempat, Tanggal Lahir</label>
									<div class="col-sm-9">
										<input type="text" required name="tempat_tanggal_lahir" value="<?php echo $biodata->tempat_tanggal_lahir; ?>" class="form-control" placeholder="Tempat, Tanggal Lahir" autocomplete="off">
                                        <?php echo form_error('tempat_tanggal_lahir'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-3 col-form-label">Golongan Darah</label>
									<div class="col-sm-9">
										<input type="text" required name="golongan_darah" value="<?php echo $biodata->golongan_darah; ?>" class="form-control" placeholder="Golongan Darah" autocomplete="off">
                                        <?php echo form_error('golongan_darah'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-3 col-form-label">Agama</label>
									<div class="col-sm-9">
										<select name="agama" id="inputSelect" required class="form-control">
											<option disabled>-- Pilih Agama --</option>
                                            <?php foreach ($agama as $key => $val): ?>
												<option <?= ($biodata->agama == $key) ? 'selected' : ''; ?> value="<?php echo $key; ?>"><?php echo ucwords(strtolower($val)); ?></option>
                                            <?php endforeach; ?>
										</select>
                                        <?php echo form_error('agama'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-3 col-form-label">Jenis Kelamin</label>
									<div class="col-sm-9">
										<input type="text" required name="jenis_kelamin" value="<?php echo $biodata->jenis_kelamin; ?>" class="form-control" placeholder="Jenis Kelamin" autocomplete="off">
                                        <?php echo form_error('jenis_kelamin'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-3 col-form-label">Alamat Rumah</label>
									<div class="col-sm-9">
										<textarea name="alamat_rumah" class="form-control z-depth-1" rows="3"><?=$biodata->alamat_rumah; ?></textarea>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-3 col-form-label">Asal Sekolah</label>
									<div class="col-sm-9">
										<input type="text" required name="asal_sekolah" value="<?php echo $biodata->asal_sekolah; ?>" class="form-control" placeholder="Asal Sekolah" autocomplete="off">
                                        <?php echo form_error('asal_sekolah'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-3 col-form-label">Tingkat</label>
									<div class="col-sm-9">
										<input type="text" required name="tingkat_paskibraka" value="<?php echo $biodata->tingkat_paskibraka; ?>" class="form-control" placeholder="Tingkat Paskibraka" autocomplete="off">
                                        <?php echo form_error('tingkat_paskibraka'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-3 col-form-label">No. Hp</label>
									<div class="col-sm-9">
										<input type="text" required name="no_hp" value="<?php echo $biodata->no_hp; ?>" class="form-control" placeholder="Nomor Handphone" autocomplete="off">
                                        <?php echo form_error('no_hp'); ?>
									</div>
								</div>
								<?php endif; ?>
								<div class="form-group row">
									<div class="col-sm-12 text-right">
										<button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="form-upload-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="<?php echo base_url('user/change-picture'); ?>" id="form-logo" method="POST" enctype="multipart/form-data">
				<div class="modal-header">
					<h5 class="modal-title">Form Ubah Foto</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body pb-0">
					<label for="inputFile">Pilih Foto</label>
					<input type="file" accept="image/*" name="picture" id="inputFile" class="form-control" required>
					<?php
						if(isset($_GET['errmsg']) && $_GET['errmsg'] !== '') {
							$errorMessage = str_replace("-", " ", $_GET['errmsg']);
							echo "<small class='form-text text-danger'>$errorMessage</small>";
						}
					?>
					<div class="alert alert-light mt-2 mb-0">
						<b>Perhatian</b>
						<ul class="pl-3 mb-0">
							<li>Format foto yang didukung : <i><b>JPG, PNG, JPEG</b></i></li>
							<li>Ukuran foto maskimal <b>2048 Kb (2 MB)</b></li>
							<li>Reolusi foto maksimal <b>512x512</b> pixel</li>
						</ul>
					</div>
				</div>
				<div class="modal-footer bg-whitesmoke br">
					<button type="submit" name="upload" class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>
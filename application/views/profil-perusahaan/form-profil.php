<?php
$uri2 = $this->uri->segment(2);
$readonlyAttribute = "readonly";

if ($uri2 !== '' && $uri2 === "edit") {
	$readonlyAttribute = "";
}
?>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Profil Perusahaan</h1>
            <?php echo showBreadCrumb(); ?>
		</div>

		<div class="section-body">
			<h2 class="section-title">Profil Perusahaan</h2>
			<p class="section-lead">
				Silahkan isi form di bawah untuk mengubah profil perusahaan.
			</p>

			<form action="<?php echo base_url('profil-perusahaan/edit'); ?>" method="post">
				<div class="row">
					<div class="col-12 col-md-8 col-lg-8">
						<div class="card card-primary">
							<div class="card-header">
								<h4>Data Perusahaan</h4>
							</div>
							<div class="card-body">
								<div class="form-group row">
									<label for="inputOldPassword" class="col-sm-3 col-form-label">Nama Perusahaan</label>
									<div class="col-sm-8">
										<input type="text" required <?php echo $readonlyAttribute; ?> name="nama_perusahaan" value="<?php echo ($profil !== '') ? $profil->nama_perusahaan : ''; ?>" class="form-control" placeholder="Nama Perusahaan" autocomplete="off">
                                        <?php echo form_error('nama_perusahaan'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputNewPassword" class="col-sm-3 col-form-label">No. Telpon</label>
									<div class="col-sm-8">
										<input type="text" required <?php echo $readonlyAttribute; ?> name="telpon" value="<?php echo ($profil !== '') ? $profil->telpon : ''; ?>" class="form-control" maxlength="30" placeholder="No. Telpon" autocomplete="off">
                                        <?php echo form_error('telpon'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-3 col-form-label">E-mail</label>
									<div class="col-sm-8">
										<input type="email" required <?php echo $readonlyAttribute; ?> name="email" value="<?php echo ($profil !== '') ? $profil->email : ''; ?>" class="form-control" id="inputEmail3" placeholder="Ketikan ulang password baru" autocomplete="off">
                                        <?php echo form_error('email'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputNewPassword" class="col-sm-3 col-form-label">Fax</label>
									<div class="col-sm-8">
										<input type="text" <?php echo $readonlyAttribute; ?> name="fax" value="<?php echo ($profil !== '') ? $profil->fax : ''; ?>" class="form-control" maxlength="30" placeholder="Fax (Kosongkan jika tidak ada)" autocomplete="off">
                                        <?php echo form_error('fax'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputNewPassword" class="col-sm-3 col-form-label">Website</label>
									<div class="col-sm-8">
										<input type="text" required <?php echo $readonlyAttribute; ?> name="website" value="<?php echo ($profil !== '') ? $profil->website : ''; ?>" class="form-control" maxlength="30" placeholder="Website" autocomplete="off">
                                        <?php echo form_error('website'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputNewPassword" class="col-sm-3 col-form-label">Alamat</label>
									<div class="col-sm-8">
										<textarea name="alamat" required <?php echo $readonlyAttribute; ?> id="" cols="30" rows="10" class="form-control"><?php echo ($profil !== '') ? $profil->alamat : ''; ?></textarea>
                                        <?php echo form_error('website'); ?>
									</div>
								</div>
								<div class="col-sm-8 offset-3">
									<?php if ($uri2 !== '' && $uri2 === "edit") : ?>
										<button name="update" class="btn btn-primary mr-1" type="submit">Simpan Perubahan</button>
										<a href="<?php echo base_url('pengaturan'); ?>" class="btn btn-light">Kembali</a>
									<?php else: ?>
										<a href="<?php echo base_url('profil-perusahaan/edit'); ?>" class="btn btn-primary">Edit Data</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-4 col-lg-4">
						<div class="card card-primary">
							<div class="card-header">
								<h4>Logo Perusahaan</h4>
							</div>
							<div class="card-body text-center">
								<p class="mb-5">
									<img src="<?php echo ($profil !== '') ? base_url($profil->logo) : base_url('assets/img/stisla.svg'); ?>" alt="" class="img img-fluid" style="width: 220px;">
								</p>
								<button class="btn btn-primary btn-lg btn-block" type="button" data-toggle="modal" data-target="#form-upload-modal">
									Ubah Logo
								</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="form-upload-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="<?php echo base_url('profil-perusahaan/upload'); ?>" id="form-logo" method="POST" enctype="multipart/form-data">
				<div class="modal-header">
					<h5 class="modal-title">Form Upload</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body pb-0">
					<label for="inputFile">Pilih Foto</label>
					<input type="file" accept="image/*" name="logo" id="inputFile" class="form-control" required>
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
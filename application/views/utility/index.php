<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Backup &amp; Restore Data</h1>
            <?php echo showBreadCrumb(); ?>
		</div>

		<div class="section-body">
			<h2 class="section-title">Backup &amp; Restore Data</h2>
			<p class="section-lead">
				Backup dan Restore database aplikasi.
			</p>

			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card card-primary">
						<div class="card-header border-bottom border-secondary">
							<h4 class="card-heading">Backup Database &amp; File Upload</h4>
						</div>
						<div class="card-body">
							<div class="alert alert-light alert-has-icon">
								<div class="alert-icon">
									<i class="fa fa-info-circle"></i>
								</div>
								<div class="alert-body">
									<div class="alert-title">Informasi</div>
									<p class="m-0 p-0">
										Lakukan backup database secara berkala untuk membuat cadangan database yang bisa direstore kapan saja ketika dibutuhkan.
										Silakan klik tombol <b>"Backup Database"</b> untuk memulai proses backup data.
										Setelah proses backup selesai, silakan simpan di lokasi yang aman.
									</p>
								</div>
							</div>
							<form action="<?php echo base_url('utility/create-backup') ?>" method="POST">
								<button type="submit" name="backup" class="btn btn-lg btn-icon icon-left btn-primary">
									<i class="fa fa-cloud-upload-alt"></i>
									<span>Backup Database</span>
								</button>
								<button type="button" id="backup-file-upload" class="btn btn-lg btn-icon icon-left btn-light"
                                        onclick="
                                            event.preventDefault();
                                            document.getElementById('form-backup-file-upload').submit();
                                    ">
									<i class="fa fa-cloud-upload-alt"></i>
									<span>Backup File Upload</span>
								</button>
							</form>
                            <form action="<?php echo base_url('utility/create-backup-file') ?>" method="POST" id="form-backup-file-upload">
                                <input type="hidden" name="backup-file" value="true">
							</form>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card" id="form-backup">
						<div class="card-header border-bottom border-secondary">
							<h4 class="card-heading">Restore Database</h4>
						</div>
						<div class="card-body">
							<div class="alert alert-light alert-has-icon">
								<div class="alert-icon">
									<i class="fa fa-info-circle"></i>
								</div>
								<div class="alert-body">
									<div class="alert-title">Informasi</div>
									<p class="m-0 p-0">
										Silakan pilih file database lalu klik tombol <b>"Restore"</b> untuk melakukan restore database dari hasil backup yang telah dibuat sebelumnya.
										Jika belum ada file database hasil backup, silakan lakukan backup terlebih dahulu melalui menu <b>"Backup Database"</b> di atas.
									</p>
								</div>
							</div>
							<div class="alert alert-danger alert-has-icon">
								<div class="alert-icon">
									<i class="fa fa-exclamation-triangle"></i>
								</div>
								<div class="alert-body">
									<div class="alert-title">Peringatan!</div>
									<p class="m-0 p-0">
										Berhati - hatilah ketika merestore database karena <b><u>data yang ada akan diganti dengan data yang baru</u></b>.
										Pastikan bahwa file database yang akan digunakan untuk merestore adalah
										<b>"benar - benar"</b> file backup database yang telah dibuat sebelumnya sehingga sistem dapat berjalan dengan normal dan tidak mengalami error.
									</p>
								</div>
							</div>
							<hr>
							<form action="<?php echo base_url('utility/restore-db') ?>" method="POST" class="w-100 row" enctype="multipart/form-data">
								<div class="col-sm-12 col-lg-12 col-md-12">
									<h4 class="h4">Form Restore Database</h4>
								</div>
								<div class="col-sm-12 col-lg-4 col-md-4">
									<div class="form-group">
										<label class="col-form-label">File Backup Database</label>
										<input type="file" name="backup_file" class="form-control" required accept="application/sql">
                                        <?php
                                        if (isset($_GET['errmsg'], $_GET['error']) && $_GET['errmsg'] !== '') {
                                            $errorMessage = str_replace("-", " ", $_GET['errmsg']);
                                            echo "<small class='form-text text-danger'>$errorMessage</small>";
                                        }
                                        ?>
									</div>
								</div>
								<div class="col-sm-12 col-lg-4 col-md-4">
									<div class="form-group">
										<label class="col-form-label">
											Password <small data-toggle="tooltip" title="Ini mencegah agar seseorang tidak dapat melakukan perubahan pada database aplikasi selain Super Admin"><i>(Mengapa meminta password?)</i></small>
										</label>
										<input type="password" name="password" class="form-control" required placeholder="Masukkan password ">
									</div>
								</div>
								<div class="col-sm-12 col-lg-4 col-md-4">
									<div class="form-group">
										<label for="" class="w-100">&nbsp;</label>
										<button type="submit" name="restore" class="btn btn-lg btn-icon icon-left btn-primary">
											<i class="fa fa-history"></i>
											<span>Restore</span>
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
</section>
</div>
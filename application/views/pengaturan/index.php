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
			<h1>Pengaturan</h1>
            <?php echo showBreadCrumb(); ?>
		</div>

		<div class="section-body">
			<h2 class="section-title">Pengaturan Aplikasi</h2>
			<p class="section-lead">
				Silahkan isi form di bawah untuk mengubah pengaturan aplikasi.
			</p>

			<div class="row">
				<div class="col-12 col-md-8 col-lg-8">
					<div class="card card-primary">
						<div class="card-header">
							<h4>Pengaturan Aplikasi</h4>
						</div>
						<div class="card-body">
							<form id="form-setting" action="<?php echo base_url('pengaturan-aplikasi'); ?>" method="post">
								<div class="form-group row">
									<label for="inputOldPassword" class="col-sm-3 col-form-label">Nama Aplikasi</label>
									<div class="col-sm-8">
										<div class="input-group">
											<input type="text" required name="app_name" value="<?php echo ($pengaturan !== '') ? $pengaturan->app_name : ''; ?>" class="form-control" placeholder="Nama Aplikasi" autocomplete="off">
											<div class="input-group-append">
												<button name="update" class="btn btn-icon icon-left btn-primary" type="submit">
													<i class="fa fa-check"></i>
													<span>Simpan Perubahan</span>
												</button>
											</div>
										</div>
                                        <?php echo form_error('app_name'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputNewPassword" class="col-sm-3 col-form-label">Warna Latar</label>
									<div class="col-sm-8">
										<div class="row gutters-xs">
											<div class="col-auto">
												<label class="colorinput">
													<input name="color_theme" onclick="changeColorTheme(this)" type="checkbox" value="DEFAULT" <?php echo ($pengaturan !== '' && $pengaturan->color_theme == 'DEFAULT') ? 'checked' : ''; ?> class="colorinput-input"/>
													<span class="colorinput-color bg-primary"></span>
												</label>
											</div>
											<div class="col-auto">
												<label class="colorinput">
													<input name="color_theme" onclick="changeColorTheme(this)" type="checkbox" value="RED" <?php echo ($pengaturan !== '' && $pengaturan->color_theme == 'RED') ? 'checked' : ''; ?> class="colorinput-input"/>
													<span class="colorinput-color bg-danger"></span>
												</label>
											</div>
											<div class="col-auto">
												<label class="colorinput">
													<input name="color_theme" onclick="changeColorTheme(this)" type="checkbox" value="ORANGE" <?php echo ($pengaturan !== '' && $pengaturan->color_theme == 'ORANGE') ? 'checked' : ''; ?> class="colorinput-input"/>
													<span class="colorinput-color bg-warning"></span>
												</label>
											</div>
											<div class="col-auto">
												<label class="colorinput">
													<input name="color_theme" onclick="changeColorTheme(this)" type="checkbox" value="BLUE" <?php echo ($pengaturan !== '' && $pengaturan->color_theme == 'BLUE') ? 'checked' : ''; ?> class="colorinput-input"/>
													<span style="background-color: #1269db !important;" class="colorinput-color bg-info"></span>
												</label>
											</div>
											<div class="col-auto">
												<label class="colorinput">
													<input name="color_theme" onclick="changeColorTheme(this)" type="checkbox" value="GREEN" <?php echo ($pengaturan !== '' && $pengaturan->color_theme == 'GREEN') ? 'checked' : ''; ?> class="colorinput-input"/>
													<span class="colorinput-color bg-success"></span>
												</label>
											</div>
										</div>
                                        <?php echo form_error('color_theme'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-3 col-form-label">Tampilkan Full Menu</label>
									<div class="col-sm-8">
										<label class="custom-switch mt-2">
											<input type="checkbox" name="status_show" <?php echo ($pengaturan !== '' && $pengaturan->show_full_sidebar === '1') ? "checked" : ''; ?> class="custom-switch-input" id="status-show">
											<input type="hidden" id="show_full_sidebar" name="show_full_sidebar" value="<?php echo ($pengaturan !== '') ? $pengaturan->show_full_sidebar : 0; ?>" class="custom-switch-input">
											<span class="custom-switch-indicator"></span>
											<span id="status_show_text" class="custom-switch-description">
												<?php echo ($pengaturan !== '' && $pengaturan->show_full_sidebar === '1') ? "YA" : "TIDAK"; ?>
											</span>
										</label>
                                        <?php echo form_error('show_full_sidebar'); ?>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
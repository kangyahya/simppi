<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Manajemen Pengguna</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">Ubah Password</h2>
            <p class="section-lead">
                Silahkan isi form di bawah untuk mengubah password.
            </p>

            <form action="<?php echo base_url('user/change-password/'); ?>" method="post">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-8">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputOldPassword" class="col-sm-4 col-form-label">Password Lama</label>
                                    <div class="col-sm-8">
                                        <input type="password" required name="old_password" class="form-control" placeholder="Password Lama" autocomplete="off">
                                        <?php echo form_error('old_password'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputNewPassword" class="col-sm-4 col-form-label">Password Baru</label>
                                    <div class="col-sm-8">
                                        <input type="password" required name="new_password" class="form-control" maxlength="30" placeholder="Password Baru" autocomplete="off">
                                        <?php echo form_error('new_password'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Konfirmasi Password</label>
                                    <div class="col-sm-8">
                                        <input type="password" required name="confirm_password" class="form-control" id="inputEmail3" placeholder="Ketikan ulang password baru" autocomplete="off">
                                        <?php echo form_error('confirm_password'); ?>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button name="update" class="btn btn-primary mr-1" type="submit">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
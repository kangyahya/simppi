<?php
defined('BASEPATH') or exit('No direct script access allowed');
$getPengaturan = getData('pengaturan_aplikasi');
$pengaturan = null;
if ($getPengaturan) {
    $pengaturan = $getPengaturan[0];
}
$appName = "Codepos App";
if ($pengaturan !== null) {
    $appName = $pengaturan->app_name;
}
?>
		<form id="delete" method="POST">
			<input type="hidden" name="data_type">
			<input type="hidden" name="data_id">
			<input type="hidden" name="_method" value="DELETE">
		</form>
		<form id="form-logout" method="POST" action="<?= base_url('logout'); ?>">
			<input type="hidden" name="logout" value="TRUE">
			<input type="hidden" name="_method" value="DELETE">
		</form>
		<footer class="main-footer">
			<div class="footer-left">
				Copyright &copy; <?php echo date("Y"); ?>
				<div class="bullet"></div>
				<a href="<?php echo base_url(); ?>"><?php echo $appName; ?></a>
			</div>
			<div class="footer-right">

			</div>
		</footer>
	</div>
</div>
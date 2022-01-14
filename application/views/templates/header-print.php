<?php
$profil = getData('profil_perusahaan');
if($profil) {
	$profil = $profil[0];
}
?>
<div id="header">
	<div class="logo">
        <?php if ($profil !== '' && $profil->logo !== ''): ?>
			<img src="<?php echo $profil->logo; ?>" alt="">
        <?php else: ?>
			<img src="<?php echo 'assets/img/logo.png'; ?>" alt="">
        <?php endif; ?>
	</div>
	<div class="kop-text">
		<h2><?php echo ($profil !== '') ? strtoupper($profil->nama_perusahaan) : "PT. CODEPOS INDONESIA"; ?></h2>
		<p>
			No. Telpon : <?php echo ($profil !== '') ? $profil->telpon : "021 - XXXX - XXX"; ?>
			Fax. <?php echo ($profil !== '') ? $profil->fax : "-"; ?> <br>
            <?php echo ($profil !== '') ? $profil->website : "www.our-webiste.com"; ?> -- E-mail : <?php echo ($profil !== '') ? $profil->email : "admin@mail.com"; ?> <br>
            <?php echo ($profil !== '') ? $profil->alamat : "Jl. Raya XX No. 123-456"; ?>
		</p>
	</div>
</div>

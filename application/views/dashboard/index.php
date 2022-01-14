<?php
defined('BASEPATH') or exit('No direct script access allowed');
//Nota supplier
$grandTotalHpp = 0;
$grandTotalReturSupplier = 0;
$grandTotalPembayaranSupplier = 0;

//Penjualan
$grandTotalPenjualan = 0;
$grandTotalReturPenjualan = 0;
$grandTotalPembayaranPenjualan = 0;
?>
<style>
    table tr td, table tr th {
        padding: .5rem !important;
        height: auto !important;
    }

    .filter-selection {
        width: 16rem !important;
        border-radius: 5px !important;
        padding: 4px 8px !important;
        height: auto !important;
        margin-left: 30px !important;
    }
</style>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Dashboard</h1>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="wizard-steps mb-4">
					<div class="wizard-step wizard-step-active">
						<div class="wizard-step-icon">
							<span class="bigger-text"><?php echo $total_pelanggan; ?></span>
						</div>
						<div class="wizard-step-label">Anggota</div>
					</div>
					<div class="wizard-step wizard-step-active">
						<div class="wizard-step-icon">
							<span class="bigger-text"><?php echo $total_pelanggan; ?></span>
						</div>
						<div class="wizard-step-label">Anggota</div>
					</div>
				</div>
			</div>
		</div>
		<div class="section-body">
			<div class="row">
				<div class="col-lg-12 col-12">
					<div class="card card-primary" id="nota-supplier">
						<div class="card-header">
							<h3 class="text-uppercase text-primary" style="width: auto !important;">Anggota</h3>
							<select onchange="filterNotaSupplier(this)" class="form-control form-control-sm filter-selection">
								<option value="" selected>ALL</option>
                                <?php foreach ($supplier as $sup): ?>
									<option <?php echo (isset($supplier_params) && $supplier_params == $sup->id_supplier) ? "selected" : ""; ?> value="<?php echo $sup->id_supplier; ?>"><?php echo strtoupper($sup->nama_supplier); ?></option>
                                <?php endforeach; ?>
							</select>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>
</div>

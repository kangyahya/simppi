<?php
defined('BASEPATH') or exit('No direct script access allowed');
$uri1 = $this->uri->segment(1);
$uri2 = $this->uri->segment(2);
?>
<!-- General JS Scripts -->
<script type="text/javascript">const BASE_URL = "<?php echo base_url();?>";</script>
<script src="<?php echo base_url(); ?>assets/modules/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/popper.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/tooltip.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/stisla.js"></script>

<!-- JS Libraies -->
<?php
if ($this->uri->segment(2) == "" || $this->uri->segment(2) == "index") { ?>
	<script src="<?php echo base_url(); ?>assets/modules/jquery.sparkline.min.js"></script>
	<!-- <script src="<?php echo base_url(); ?>assets/modules/chart.min.js"></script> -->
	<script src="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.js"></script>
	<script src="<?php echo base_url(); ?>assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
    <?php
} ?>

<!-- Page Specific JS File -->
<?php
if ($this->uri->segment(1) == "daftar-bayar") { ?>
	<script type='text/javascript'>
        $('table tbody tr  td').on('click', function () {
            $("#modal-show-part").modal("show");
            $("#id_bayar").val($(this).closest('tr').children()[0].textContent);
            $("#tanggal").val($(this).closest('tr').children()[1].textContent);
            $("#nama_pelanggan").val($(this).closest('tr').children()[2].textContent);
            $("#bank").val($(this).closest('tr').children()[3].textContent);
            $("#jenis_bayar").val($(this).closest('tr').children()[4].textContent);
            $("#jumlah").val($(this).closest('tr').children()[5].textContent);
        });
	</script>
    <?php
} elseif ($this->uri->segment(1) == "nota-supplier" && $this->uri->segment(2) == "status") { ?>
	<script type='text/javascript'>
        function updateToYes(id, link) {
            $.ajax(
                {
                    type: 'post',
                    url: link,
                    data: {id: id},
                    success: function () {
                        window.location.href = '<?=site_url("nota-supplier/status")?>'
                    }
                }
            )
        }
	</script>
<?php } ?>
<script src="<?php echo base_url(); ?>assets/modules/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/page/modules-sweetalert.js"></script>
<!-- Template JS File -->
<script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/datatables/Responsive-2.2.1/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/datatables/Responsive-2.2.1/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>

<?php if ($uri1 == "pembayaran-piutang" && ($uri2 == "create" || $uri2 == "edit")): ?>
	<script src="<?php echo base_url(); ?>assets/js/pembayaran-piutang.js"></script>
<?php elseif ($uri1 == "pembayaran-hutang" && ($uri2 == "create" || $uri2 == "edit")): ?>
	<script src="<?php echo base_url(); ?>assets/js/pembayaran-hutang.js"></script>
<?php elseif ($uri1 == "pelanggan" && $uri2 == "piutang"): ?>
	<script src="<?php echo base_url(); ?>assets/js/piutang-pelanggan.js"></script>
<?php elseif ($uri1 == "supplier" && $uri2 == "hutang"): ?>
	<script src="<?php echo base_url(); ?>assets/js/hutang-supplier.js"></script>
<?php elseif ($uri1 == "pengaturan-aplikasi" || $uri1 == "pengaturan"): ?>
	<script src="<?php echo base_url(); ?>assets/js/setting.js"></script>
<?php elseif ($uri1 == "rekening-koran" && ($uri2 == "create" || $uri2 == "edit")): ?>
	<script src="<?php echo base_url(); ?>assets/js/rekening-koran.js"></script>
<?php elseif ($uri1 == "bank"): ?>
	<script src="<?php echo base_url(); ?>assets/js/bank.js"></script>
<?php endif; ?>

<script>
    $(document).ready(function () {
        <?php if($uri1 == "dashboard"): ?>
        $(".table").dataTable({
            responsive: true,
            searching: false,
            paging: false,
            info: false,
            order: false

        });
        <?php endif; ?>
        //Datatables
		loadDataTable();

        <?php if(($uri1 == "pelanggan" || $uri1 == "supplier"  || $uri1 == "sales") && $uri2 == ""): ?>
        $("#mytable").dataTable({
            responsive: true,
			autoWidth: true,
            processing: true,
            serverSide: true,
            ajax: {"url": "<?php echo $uri1; ?>/get-<?php echo $uri1; ?>", "type": "POST"},
            columns: [
                {
                    "data": "id_<?php echo $uri1; ?>",
                    "orderable": false
                },
                {"data": "nama_<?php echo $uri1; ?>"},
                {"data": "alamat"},
                {"data": "kota"},
                {"data": "kontak"},
                {
                    "data": "action",
                    "orderable": false,
                    "className": "text-center"
                }
            ],
        });
        <?php elseif($uri1 == "user" && $uri2 == ""): ?>
        $("#mytable").dataTable({
            responsive: true,
            processing: true,
            serverSide: true,
			autoWidth: true,
            ajax: {"url": "user/get-pengguna", "type": "POST"},
            columnDefs: [{
                "targets": -2,
                "data": "user_level",
				"render": function (data, type, meta, full) {
					const badgeType= meta[5];
					const levelText = meta[4].replace("_", " ");
                    return `<span class="badge badge-${badgeType}">${levelText}</span>`
				}
            },
				{
                "targets": -1,
                "data": "id_pengguna",
				"render": function (data, type, meta, full) {
                    const idPengguna = meta[0];
                    <?php if(showOnlyTo("1")): ?>
						const editBtn = `<a href="<?php echo base_url('user/edit/'); ?>${idPengguna}" class="btn btn-light"><i class="fa fa-edit"></i></a>`;
						const deleteBtn = ` <a href="#" class="btn btn-light" onclick="showConfirmDelete('user', ${idPengguna})"><i class="fa fa-trash-alt"></i></a>`;
						return editBtn + deleteBtn;
					<?php else: ?>
						return 'No action';
					<?php endif; ?>
				}
            }
			],
        });
        <?php endif; ?>
    });

    <?php if(($uri1 == "pengaturan" || ($uri1 == "user" && $uri2 == "profile")) && isset($_GET['show_modal']) && $_GET['show_modal'] == 'true'): ?>
    $("#form-upload-modal").modal('show');
    <?php endif; ?>
</script>
<?php if (isset($_SESSION['message']) && $_SESSION['message'] != ''): ?>
	<script>
        swal({
            title: '<?php echo ucfirst($_SESSION['message']['type']); ?>',
            text: '<?php echo $_SESSION['message']['text']; ?>',
            icon: '<?php echo $_SESSION['message']['type']; ?>',
            timer: 2000
        });
	</script>
<?php endif;
$_SESSION['message'] = ''; ?>
</body>
</html>

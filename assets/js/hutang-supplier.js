const showDetails = (dataType, idSupplier) => {
    const titleElement = document.querySelector(".modal-title");
    titleElement.textContent = `Detail ${capital(dataType.toString())} Supplier`;
    const actionURL = `${BASE_URL}/supplier/get-detail/${dataType}/${idSupplier}`;
    $.get(actionURL, function (response) {
        const jsonReponse = JSON.parse(response);
        if (jsonReponse.status === 'success') {
            const tableHeader = document.getElementById("table-header");
            const tableBody = document.getElementById("table-body");
            const tableFooter = document.getElementById("table-footer");

            let rowHeader = ``;
            let rowBody = ``;
            let rowFooter = ``;

            if (dataType === 'hutang' || dataType === 'hutang-lama') {
                let grandTotal = 0;
                let grandTotalHpp = 0;
                let grandTotalBayar = 0;
                rowHeader = `<tr>
										<th>No.</th>
										<th>No. Nota</th>
										<th>Tanggal</th>
										<th>Supplier</th>
										<th>Total</th>
										<th>Total Hpp</th>
										<th>Bayar</th>
										<th>Lunas</th>
									</tr>`;
                jsonReponse.data.forEach((val, index) => {
                    const bayar = val.bayar !== null ? val.bayar : "0";
                    grandTotal += parseInt(val.total);
                    grandTotalHpp += parseInt(val.total_hpp);
                    grandTotalBayar += parseInt(bayar);

                    rowBody += `<tr>
									   	  <td>${index + 1}</td>
									   	  <td>${val.no_nota}</td>
									   	  <td>${tanggalIndonesia(val.tanggal)}</td>
									   	  <td>${val.nama_supplier}</td>
									   	  <td class="format-uang">${toRupiah(val.total)}</td>
										  <td class="format-uang">${toRupiah(val.total_hpp)}</td>
									   	  <td class="format-uang">${toRupiah(bayar)}</td>
									   	  <td>${val.is_lunas}</td>
									   <tr>`;
                });

                rowFooter = `<tr>
                                <th colspan="4" class="text-center font-weight-bold">GRAND TOTAL</th>
                                <th class="format-uang">${toRupiah(grandTotal.toString())}</th>
                                <th class="format-uang">${toRupiah(grandTotalHpp.toString())}</th>
                                <th class="format-uang">${toRupiah(grandTotalBayar.toString())}</th>
                                <th></th>
                            </tr>`;
            } else if (dataType === 'transfer' || dataType === "lain-lain") {
                let grandTotalJumlah = 0;
                rowHeader = `<tr>
										<th>No.</th>
										<th>ID Transfer</th>
										<th>Tanggal</th>
										<th>Supplier</th>
										<th>Bank</th>
										<th>Jenis Bayar</th>
										<th>Keterangan</th>
										<th>Jumlah</th>
									</tr>`;
                jsonReponse.data.forEach((val, index) => {
                    const jumlah = (dataType === 'lain-lain') ? val.potongan_lain_lain : val.jumlah;
                    grandTotalJumlah += parseInt(jumlah);
                    rowBody += `<tr>
									   	  <td>${index + 1}</td>
									   	  <td>${val.kode_pembayaran}</td>
									   	  <td>${tanggalIndonesia(val.tanggal)}</td>
									   	  <td>${val.nama_supplier}</td>
									   	  <td>${val.nama_bank}</td>
									   	  <td>${val.nama_jenis_bayar}</td>
									   	  <td>${val.nama_keterangan}</td>
										  <td class="format-uang">
                                             ${(dataType === 'transfer') ? toRupiah(jumlah) : jumlah}
                                          </td>
									   <tr>`;
                });

                rowFooter = `<tr>
                                <th colspan="7" class="text-center font-weight-bold">GRAND TOTAL</th>
                                <th class="format-uang">${toRupiah(grandTotalJumlah.toString())}</th>
                            </tr>`;
            } else if (dataType === 'retur') {
                let grandTotal = 0;
                let grandTotalPotong = 0;

                rowHeader = `<tr>
										<th>No.</th>
										<th>No. Retur</th>
										<th>Tanggal</th>
										<th>Supplier</th>
										<th>Total</th>
										<th>Potong</th>
										<th>Sudah Potong</th>
									</tr>`;
                jsonReponse.data.forEach((val, index) => {
                    grandTotal += parseInt(val.total);

                    let totalPotong = "0";
                    if (val.total_potong !== null) {
                        totalPotong = val.total_potong;
                        grandTotalPotong += parseInt(val.total_potong);
                    }

                    rowBody += `<tr>
									   	  <td>${index + 1}</td>
									   	  <td>${val.no_retur}</td>
									   	  <td>${tanggalIndonesia(val.tanggal)}</td>
									   	  <td>${val.nama_supplier}</td>
									   	  <td class="format-uang">${toRupiah(val.total)}</td>
									   	  <td class="format-uang">${toRupiah(totalPotong)}</td>
									   	  <td class="text-center">${val.is_lunas}</td>
									   <tr>`;
                });

                rowFooter = `<tr>
                                <th class="text-center font-weight-bold" colspan="4">GRAND TOTAL</th>
                                <th class="format-uang">${toRupiah(grandTotal.toString())}</th>
                                <th class="format-uang">${toRupiah(grandTotalPotong.toString())}</th>
                                <th></th>
                            </tr>`;
            }

            tableHeader.innerHTML = rowHeader;
            tableBody.innerHTML = rowBody;
            tableFooter.innerHTML = rowFooter;
        } else {
            swal({
                title: 'Warning',
                text: `${jsonReponse.message}`,
                icon: 'warning',
                timer: 2000
            });
        }
    });
    $("#detail-modal").modal('show');
};
const capital = (str) => {
    return str.replace(/\w\S*/g,
        function (txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });
}

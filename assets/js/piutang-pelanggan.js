const showDetails = (dataType, idPelanggan) => {
    const titleElement = document.querySelector(".modal-title");
    titleElement.textContent = `Detail ${dataType.toString()} Pelanggan`;
    const actionURL = `${BASE_URL}/pelanggan/get-detail/${dataType}/${idPelanggan}`;
    $.get(actionURL, function (response) {
        const jsonReponse = JSON.parse(response);

        if (jsonReponse.status === 'success') {
            const tableHeader = document.getElementById("table-header");
            const tableBody = document.getElementById("table-body");
            const tableFooter = document.getElementById("table-footer");

            let rowHeader = ``;
            let rowBody = ``;
            let rowFooter = ``;

            //PIUTANG
            if (dataType === 'piutang' || dataType === 'piutang-lama') {
                let grandTotal = 0;
                let grandTotalBayar = 0;
                rowHeader = `<tr>
										<th>No.</th>
										<th>No. Nota</th>
										<th>Tanggal</th>
										<th>Pelanggan</th>
										<th>Total</th>
										<th>Bayar</th>
										<th class="text-center">Lunas</th>
									</tr>`;
                jsonReponse.data.forEach((val, index) => {
                    const bayar = (val.bayar !== null) ? val.bayar : "0";
                    grandTotal += parseInt(val.total);
                    grandTotalBayar += parseInt(bayar);
                    rowBody += `<tr>
									   	  <td>${index + 1}</td>
									   	  <td>${val.no_nota}</td>
									   	  <td>${tanggalIndonesia(val.tanggal)}</td>
									   	  <td>${val.nama_pelanggan}</td>
									   	  <td class="format-uang">${toRupiah(val.total)}</td>
									   	  <td class="format-uang">${toRupiah(bayar)}</td>
									   	  <td class="text-center">${val.is_lunas}</td>
									   <tr>`;
                });
                rowFooter = `<tr>
                                <th class="text-center font-weight-bold" colspan="4">GRAND TOTAL</th>
                                <th class="format-uang">${toRupiah(grandTotal.toString())}</th>
                                <th class="format-uang">${toRupiah(grandTotalBayar.toString())}</th>
                                <th></th>
                            </tr>`;
            //BAYAR || LAIN-LAIN
            } else if (dataType === 'bayar' || dataType === 'lain-lain') {
                let grandTotalJumlah = 0;
                rowHeader = `<tr>
										<th>No.</th>
										<th>ID Pembayaran</th>
										<th>Tanggal</th>
										<th>Pelanggan</th>
										<th>Bank</th>
										<th>Jenis Bayar</th>
										<th>Keterangan</th>
										<th>Jumlah</th>
									</tr>`;
                jsonReponse.data.forEach((val, index) => {
                    let jumlah = (dataType === 'bayar') ? val.jumlah : val.potongan_lain_lain;
                    grandTotalJumlah += parseInt(jumlah);
                    if(parseInt(jumlah) !== 0) {
                        rowBody += `<tr>
                                              <td>${index + 1}</td>
                                              <td>${val.kode_pembayaran}</td>
                                              <td>${tanggalIndonesia(val.tanggal)}</td>
                                              <td>${val.nama_pelanggan}</td>
                                              <td>${val.nama_bank}</td>
                                              <td>${val.nama_jenis_bayar}</td>
                                              <td>${val.nama_keterangan}</td>
                                              <td class="format-uang">
                                                 ${(dataType=== 'bayar') ? toRupiah(jumlah) : jumlah}
                                              </td>
                                           <tr>`;
                    }
                });

                rowFooter = `<tr>
                                <th class="text-center font-weight-bold" colspan="7">GRAND TOTAL</th>
                                <th class="format-uang">${toRupiah(grandTotalJumlah.toString())}</th>
                            </tr>`;
            //RETUR
            } else if (dataType === 'retur') {
                let grandTotal = 0;
                let grandTotalPotong = 0;
                rowHeader = `<tr>
										<th>No.</th>
										<th>No. Retur</th>
										<th>Tanggal</th>
										<th>Pelanggan</th>
										<th>Total</th>
										<th>Potong</th>
										<th>Sudah Potong</th>
									</tr>`;
                jsonReponse.data.forEach((val, index) => {
                    grandTotal += parseInt(val.total);

                    let totalPotong = "0";
                    if(val.total_potong !== null) {
                        totalPotong = val.total_potong;
                        grandTotalPotong += parseInt(val.total_potong);
                    }

                    rowBody += `<tr>
									   	  <td>${index + 1}</td>
									   	  <td>${val.no_retur}</td>
									   	  <td>${tanggalIndonesia(val.tanggal)}</td>
									   	  <td>${val.nama_pelanggan}</td>
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
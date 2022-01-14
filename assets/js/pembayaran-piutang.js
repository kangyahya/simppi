let notaPelangganItem = '';
let returPelangganItem = '';

function loadSelect2() {
    $('.select2').select2({
        theme: 'bootstrap4',
    });
}

loadSelect2();

const listItem = document.getElementById("list-item");
let btnRemoveItemShow = false;
let dataIndex = 2;

const removeLastItem = () => {
    const listItemChildren = listItem.children.length;
    if (listItemChildren > 1) {
        listItem.removeChild(listItem.lastElementChild);
    }

    if (listItemChildren <= 2) {
        btnRemoveItemShow = false;
        document.getElementById("btn-remove-item").remove();
    }
    dataIndex--;
    hitungTotal();
}

function hitungTotal() {
    hitungTotalBayar();
    hitungTotalNota();
    hitungTotalPotongRetur();
    hitungTotalRetur();
};

const getTotal = (element, dataType, index) => {
    if (checkPelanggan()) {
        swal({
            title: 'Informasi',
            text: 'Silahkan pilih pelanggan terlebih dahulu!',
            icon: 'warning',
            timer: 2000
        });
    } else {
        const dataNumber = element.value;
        const inputSisaNota = document.querySelector(`.total_${dataType}_${index}`);
        if(dataNumber !== '') {
            const actionURL = `${BASE_URL}/${dataType}-penjualan/get-total/${dataNumber}`;
            $.get(actionURL, (response) => {
                const jsonResponse = JSON.parse(response);
                if (jsonResponse.status === 'success') {
                    if (dataType === 'nota') {
                        const inputTanggalNota = document.querySelector(`.tanggal_${dataType}_${index}`);
                        inputTanggalNota.value = jsonResponse.data.tanggal;
                    }
                    inputSisaNota.value = toRupiah(jsonResponse.data.total);
                    hitungTotal();
                } else {
                    swal({
                        title: 'Warning',
                        text: 'Data tidak ditemukan.',
                        icon: 'warning',
                        timer: 2000
                    });
                }
            });
        } else {
            inputSisaNota.value = 0;
            if(dataType === 'retur') {
                document.querySelector(`.potong_retur_${index}`).value = 0;
            }
        }
        hitungTotalPotongRetur();
        hitungTotalRetur();
    }
};

const getSummary = (element, dataType, index) => {
    const dataNumber = element.value;
    const actionURL = `${BASE_URL}/${dataType}-supplier/get-total/${dataNumber}`;
    $.get(actionURL, function (response) {
        const jsonResponse = JSON.parse(response);
        if (jsonResponse.status === 'success') {
            const inputSisaNota = document.querySelector(`.total_${dataType}_${index}`);
            inputSisaNota.value = toRupiah(jsonResponse.data.total);
            hitungTotal();
        } else {
            swal({
                title: 'Warning',
                text: 'Data tidak ditemukan.',
                icon: 'warning',
                timer: 2000
            });
        }
    });
};

//Menghitung total nominal pembayaran
const hitungTotalBayar = () => {
    let totalBayar = 0;
    const inputNominalBayar = document.querySelectorAll(".nominal-bayar");
    inputNominalBayar.forEach(item => {
        let value = 0;
        if (item.value !== '') {
            value = item.value.split(",").join("");
        }
        const nominal = parseFloat(value);
        totalBayar += nominal;
    });

    document.getElementById("total-bayar").textContent = toRupiah(totalBayar.toString());
    hitungSisa();
};

//Menghitung total Nota yang dipilih
const hitungTotalNota = () => {
    let nominalTotalNota = 0;
    const totalPerNota = document.querySelectorAll(".total-per-nota");
    totalPerNota.forEach(item => {
        let itemTotalNota = 0;
        if (item.value !== '') {
            itemTotalNota = item.value.split(",").join("");
        }
        const nominal = parseFloat(parseFloat(itemTotalNota));
        nominalTotalNota += nominal;
    });
    const totalNota = document.getElementById("total-nota");

    totalNota.textContent = toRupiah(nominalTotalNota.toString());
};

//Menghitung total nominal retur
const hitungTotalPotongRetur = () => {
    let nominalTotalPotongRetur = 0;
    const inputNominalPotongRetur = document.querySelectorAll(".nominal-potong-retur");
    inputNominalPotongRetur.forEach(item => {
        let value = 0;
        if (item.value !== '') {
            value = item.value.split(",").join("");
        }
        const nominal = parseFloat(value);
        nominalTotalPotongRetur += nominal;
    });

    const totalPotongRetur = document.getElementById("total-potong-retur");
    totalPotongRetur.textContent = toRupiah(nominalTotalPotongRetur.toString());

    hitungSisa();
};

//Menghitung total retur yang dipilih
const hitungTotalRetur = () => {
    let totalRetur = 0;
    const totalPerRetur = document.querySelectorAll(".total-per-retur");
    totalPerRetur.forEach(item => {
        let itemTotalRetur = 0;
        if (item.value !== '') {
            itemTotalRetur = item.value.split(",").join("");
        }
        const nominal = parseFloat(parseFloat(itemTotalRetur));
        totalRetur += nominal;
    });
    document.getElementById("total-retur").textContent = toRupiah(totalRetur.toString());
}

const showNotaByPelanggan = (element) => {
    const idPelanggan = element.value;
    if (idPelanggan !== '' && typeof idPelanggan !== 'undefined') {
        const notaPenjualanURL = `${BASE_URL}/pelanggan/get-nota-penjualan/${idPelanggan}`;
        const returPenjualanURL = `${BASE_URL}/pelanggan/get-retur-penjualan/${idPelanggan}`;
        $.get(notaPenjualanURL, (response) => {
            const data = JSON.parse(response);
            if (data !== '') {
                $(".list-nota-penjualan > option").remove();
                let itemOptions = `<option value="" selected>-- Pilih Nota --</option>`;
                $.each(data, function (index, val) {
                    const newOption = `<option value="${val.no_nota}">${val.no_nota}</option>`;
                    itemOptions += newOption;
                });
                notaPelangganItem = itemOptions;
                $(".list-nota-penjualan").append(itemOptions);
            }
        });
        $.get(returPenjualanURL, (response) => {
            const data = JSON.parse(response);
            if (data !== '') {
                $(".list-retur-penjualan > option").remove();
                let itemOptions = `<option value="" selected>-- Pilih Retur --</option>`;
                $.each(data, function (index, val) {
                    const newOption = `<option value="${val.no_retur}">${val.no_retur}</option>`;
                    itemOptions += newOption;
                });
                returPelangganItem = itemOptions;
                $(".list-retur-penjualan").append(itemOptions);
            }
        });
    }
}

const checkPelanggan = () => {
    const selectPelanggan = document.querySelector("#id_pelanggan");
    return (selectPelanggan.value === '' || selectPelanggan.value === '-- Pilih Pelanggan --')
}

const addRow = (isEdit = false) => {
    if (checkPelanggan()) {
        swal({
            title: 'Informasi',
            text: 'Silahkan pilih pelanggan terlebih dahulu!',
            icon: 'warning',
            timer: 2000
        });
    } else {
        if (isEdit === true) {
            const tableForm = document.getElementById("table-form");
            dataIndex = tableForm.tBodies[0].rows.length + 1;
            const selectPelangganElmt = document.getElementById("id_pelanggan");
            showNotaByPelanggan(selectPelangganElmt);
        }

        let selectNotaPenjualan = `<select class="form-control list-nota-penjualan select2" name="no_nota[]" onchange="getTotal(this, 'nota', ${dataIndex})">`;
        selectNotaPenjualan += notaPelangganItem;
        selectNotaPenjualan += `</select>`;

        let selectReturPenjualan = `<select class="form-control list-retur-penjualan select2" name="no_retur[]"  onchange="getTotal(this, 'retur', ${dataIndex})">`;
        selectReturPenjualan += returPelangganItem;
        selectReturPenjualan += `</select>`;

        let inputTanggal = `<input type="date" name="tanggal_nota[]" readonly class="form-control tanggal_nota_${dataIndex}" autocomplete="off"/>`;
        let inputBayarNota = `<input type="text" onkeyup="hitungTotalBayar()" name="bayar[]" class="form-control form-money nominal-bayar bayar_${dataIndex}" autocomplete="off"/>`;
        let inputTotalNota = `<input type="text" name="total_nota[]" class="form-control form-money total-per-nota total_nota_${dataIndex}" readonly  autocomplete="off"/>`;
        let inputPotongRetur = `<input type="text" onkeyup="hitungTotalPotongRetur()" name="potong_retur[]" class="form-control form-money nominal-potong-retur potong_retur_${dataIndex}"  autocomplete="off"/>`;
        let inputTotalRetur = `<input type="text" name="total_retur[]" class="form-control form-money total-per-retur total_retur_${dataIndex}" readonly  autocomplete="off"/>`;
        const rowItem = document.createElement(`tr`);
        rowItem.setAttribute(`data-index`, dataIndex);
        let dataItem = `
					<td>${selectNotaPenjualan}</td>
					<td>${inputTanggal}</td>
					<td>${inputBayarNota}</td>
					<td>${inputTotalNota}</td>
					<td>${selectReturPenjualan}</td>
					<td>${inputPotongRetur}</td>
					<td>${inputTotalRetur}</td>`;

        if (isEdit === true) {
            rowItem.setAttribute("id", `row-${dataIndex}`);
            rowItem.classList.add("rows");
            dataItem = `
                    <td class="text-center">
                        <small class="badge badge-danger" style="padding: .25em .4em;">
                            <a href="#" onclick="removeItem(${dataIndex})" class="text-white">
                                <i class="fa fa-times"></i>
                            </a>
                        </small>
                    </td>
					<td>${selectNotaPenjualan}</td>
					<td>${inputTanggal}</td>
					<td>${inputBayarNota}</td>
					<td>${inputTotalNota}</td>
					<td>${selectReturPenjualan}</td>
					<td>${inputPotongRetur}</td>
					<td>${inputTotalRetur}</td>`;
        }
        rowItem.innerHTML += dataItem;

        listItem.appendChild(rowItem);
        hitungTotal();
        hitungSisa();

        if (listItem.children.length > 1 && btnRemoveItemShow === false) {
            btnRemoveItemShow = true;
            const actionButton = document.getElementById("action-button");
            actionButton.innerHTML += `<button onclick="removeLastItem()" id="btn-remove-item" class="btn btn-danger btn-sm" type="button">Hapus 1 baris terakhir</button>`;
        }
        dataIndex++;
        loadSelect2();
    }
}

const inputJumlah = document.getElementById("jumlah");
const inputSisa = document.getElementById("sisa");
inputJumlah.addEventListener('keyup', () => {
    inputSisa.style.fontStyle = "italic";
    inputSisa.value = inputJumlah.value;
    hitungSisa();
});

const hitungSisa = () => {
    const totalBayar = document.getElementById("total-bayar");
    const potonganLainLain = document.getElementById("potongan-lainnya");
    const jumlah = rupiahToInt(inputJumlah.value);
    const nominalTotalBayar = rupiahToInt(totalBayar.textContent);
    const nominalPotonganLainLain = rupiahToInt(potonganLainLain.value);

    let sisa = parseInt(jumlah) - parseInt(nominalTotalBayar) - parseInt(nominalPotonganLainLain);
    const btnSubmit = document.getElementById("btn-submit");
    if (sisa === 0) {
        if (btnSubmit.hasAttribute('disabled')) {
            btnSubmit.removeAttribute('disabled');
        }
    } else {
        btnSubmit.setAttribute("disabled", "disabled");
    }
    inputSisa.value = toRupiah(sisa.toString());
}

const rupiahToInt = (str) => {
    if (str === '') {
        return 0;
    }

    return parseInt(str.toString().split(",").join(""));
}

const potonganLainLain = document.getElementById("potongan-lainnya");
potonganLainLain.addEventListener("keyup", hitungSisa);

const removeItem = (index) => {
    if (index !== '') {
        document.getElementById(`row-${index}`).remove();
    }
    hitungTotal();
}
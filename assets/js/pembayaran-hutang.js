let notaSupplierItem = '', returSupplierItem = '';

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
    if (checkSupplier()) {
        swal({
            title: 'Informasi',
            text: 'Silahkan pilih supplier terlebih dahulu!',
            icon: 'warning',
            timer: 2000
        });
    } else {
        const dataNumber = element.value;
        const actionURL = `${BASE_URL}/${dataType}-supplier/get-total/${dataNumber}`;
        $.get(actionURL, function (response) {
            const jsonResponse = JSON.parse(response);
            if (jsonResponse.status === 'success') {
                const inputSisaNota = document.querySelector(`.total_${dataType}_${index}`);
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
    }
};

//Menghitung total nominal pembayaran
const hitungTotalBayar = () => {
    let totalBayar = 0;
    const inputNominalBayar = document.querySelectorAll(".nominal-bayar");
    inputNominalBayar.forEach(item => {
        let nominal = 0;
        if (item.value !== '') {
            const value = item.value.split(",").join("");
            nominal = parseFloat(value);
        }
        totalBayar += nominal;
    });

    document.getElementById("total-bayar").innerText = toRupiah(totalBayar.toString());
    hitungSisa();
};

//Menghitung total Nota yang dipilih
const hitungTotalNota = () => {
    let totalNota = 0;
    const totalPerNota = document.querySelectorAll(".total-per-nota");
    totalPerNota.forEach(item => {
        let itemTotalNota = 0;
        if (item.value !== '') {
            itemTotalNota = item.value.split(",").join("");
        }
        const nominal = parseFloat(parseFloat(itemTotalNota));
        totalNota += nominal;
    });
    document.getElementById("total-nota").innerText = toRupiah(totalNota.toString());
};

//Menghitung total nominal retur
const hitungTotalPotongRetur = () => {
    let totalPotongRetur = 0;
    const inputNominalPotongRetur = document.querySelectorAll(".nominal-potong-retur");
    inputNominalPotongRetur.forEach(item => {
        let nominal = 0;
        if (item.value !== '') {
            nominal = item.value.split(",").join("");
            nominal = parseFloat(nominal);
        }
        totalPotongRetur += nominal;
    });

    document.getElementById("total-potong-retur").innerText = toRupiah(totalPotongRetur.toString());
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
    document.getElementById("total-retur").innerText = toRupiah(totalRetur.toString());
}

const showNotaBySupplier = (element) => {
    const id_supplier = element.value;
    if (id_supplier !== '' && typeof id_supplier !== 'undefined') {
        const notaSupplierURL = `${BASE_URL}supplier/get-nota-supplier/${id_supplier}`;
        const returSupplierURL = `${BASE_URL}supplier/get-retur-supplier/${id_supplier}`;
        $.get(notaSupplierURL, (response) => {
            const data = JSON.parse(response);
            if (data !== '') {
                $(".list-nota > option").remove();
                let newOption = `<option value="" selected>-- Pilih Nota --</option>`;
                $.each(data, function (index, val) {
                    newOption += `<option value="${val.no_nota}">${val.no_nota}</option>`;
                });
                notaSupplierItem = newOption;
                $(".list-nota").append(newOption);
            }
        });
        $.get(returSupplierURL, (response) => {
            const data = JSON.parse(response);
            if (data !== '') {
                $(".list-retur > option").remove();
                let newOption = `<option value="" selected>-- Pilih Retur --</option>`;
                $.each(data, function (index, val) {
                    newOption += `<option value="${val.no_retur}">${val.no_retur}</option>`;
                });
                returSupplierItem = newOption;
                $(".list-retur").append(newOption);
            }
        });
    }
};

const checkSupplier = () => {
    const selectSupplier = document.querySelector("#id_supplier");
    return (selectSupplier.value === '' || selectSupplier.value === '-- Pilih Supplier --')
}

const addRow = (isEdit = false) => {
    if (checkSupplier()) {
        swal({
            title: 'Informasi',
            text: 'Silahkan pilih supplier terlebih dahulu!',
            icon: 'warning',
            timer: 2000
        });
    } else {
        if (isEdit === true) {
            const tableForm = document.getElementById("table-form");
            dataIndex = document.querySelectorAll("#list-item > tr").length + 1;
            const selectSupplierElmt = document.getElementById("id_supplier");
            showNotaBySupplier(selectSupplierElmt);
        }

        let selectNotaSupplier = `<select class="form-control list-nota select2" name="no_nota[]" onchange="getTotal(this, 'nota', ${dataIndex})">`;
        selectNotaSupplier += notaSupplierItem;
        selectNotaSupplier += `</select>`;

        let selectReturSupplier = `<select class="form-control list-retur select2" name="no_retur[]"  onchange="getTotal(this, 'retur', ${dataIndex})">`;
        selectReturSupplier += returSupplierItem;
        selectReturSupplier += `</select>`;

        let inputTanggal = `<input type="date" name="tanggal_nota[]" class="form-control tanggal_nota_${dataIndex}" autocomplete="off"/>`;
        let inputBayarNota = `<input type="text" onkeyup="hitungTotalBayar()" name="bayar[]" class="form-control form-money nominal-bayar bayar_${dataIndex}" autocomplete="off"/>`;
        let inputTotalNota = `<input type="text" name="total_nota[]" class="form-control form-money total-per-nota total_nota_${dataIndex}" readonly  autocomplete="off"/>`;
        let inputPotongRetur = `<input type="text" onkeyup="hitungTotalPotongRetur()" name="potong_retur[]" class="form-control form-money nominal-potong-retur potong_retur_${dataIndex}"  autocomplete="off"/>`;
        let inputTotalRetur = `<input type="text" name="total_retur[]" class="form-control form-money total-per-retur total_retur_${dataIndex}" readonly  autocomplete="off"/>`;
        const rowItem = document.createElement(`tr`);
        rowItem.setAttribute(`data-index`, dataIndex);
        let dataItem = `
				<td>${selectNotaSupplier}</td>
				<td>${inputTanggal}</td>
				<td>${inputBayarNota}</td>
				<td>${inputTotalNota}</td>
				<td>${selectReturSupplier}</td>
				<td>${inputPotongRetur}</td>
				<td>${inputTotalRetur}</td>`;
        if (isEdit === true) {
            rowItem.setAttribute("id", `row-${dataIndex}`);
            rowItem.classList.add("rows");
            dataItem = `
                    <td class="text-center">
                        <small class="badge badge-danger" style="padding: .25em .4em;" data-toggle="tooltip" title="Hapus">
                            <a href="#" onclick="removeItem(${dataIndex})" class="text-white">
                                <i class="fa fa-times"></i>
                            </a>
                        </small>
                    </td>
					<td>${selectNotaSupplier}</td>
					<td>${inputTanggal}</td>
					<td>${inputBayarNota}</td>
					<td>${inputTotalNota}</td>
					<td>${selectReturSupplier}</td>
					<td>${inputPotongRetur}</td>
					<td>${inputTotalRetur}</td>`;
        }
        rowItem.innerHTML += dataItem;

        listItem.appendChild(rowItem);

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
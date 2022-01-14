/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$(".select2").select2();
$("a[data-toggle=tooltip]").tooltip();

function formatRupiah(element) {
    const nominal = $(element).val();
    const numberString = nominal.replace(/[^.\d]/g, '').toString();
    const split = numberString.split('.');
    const sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

    if (ribuan) {
        const separator = sisa ? ',' : '';
        rupiah += separator + ribuan.join(',');
    }

    ribuan = split[1] !== undefined ? rupiah + '.' + split[1] : rupiah;
    $(element).css({
        'font-style': 'italic'
    });
    $(element).val(ribuan);
}

function toRupiah(nominal) {
    let numberString = nominal.replace(/[^.\d]/g, '').toString();
    const split = numberString.split('.');
    const sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

    if (ribuan) {
        const separator = sisa ? ',' : '';
        rupiah += separator + ribuan.join(',');
    }

    return split[1] !== undefined ? rupiah + '.' + split[1] : rupiah;

}

//Read input File
function readURL(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById("target-img").setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

const showConfirmDelete = (dataType, dataId) => {
    if (dataType !== '' && dataId !== '') {
        swal({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin akan menghapus data ini?',
            icon: 'warning',
            buttons: {
                cancel: {
                    text: "Batalkan",
                    value: null,
                    visible: true,
                    className: "btn-secondary",
                    closeModal: true,
                },
                confirm: {
                    text: "Ya, Hapus!",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: true
                }
            }
        }).then((value) => {
            if (value) {
                const form = document.getElementById("delete");
                const actionURL = `${BASE_URL}/${dataType}/delete/${dataId}`;

                const type = document.querySelector("input[name=data_type]");
                const id = document.querySelector("input[name=data_id]");

                type.value = dataType;
                id.value = dataId;
                form.setAttribute('action', actionURL);
                form.submit();
            }
        });

    }
}
const showConfirmLogout = () => {

    swal({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin akan keluar dari aplikasi ini?',
        icon: 'warning',
        buttons: {
            cancel: {
                text: "Batalkan",
                value: null,
                visible: true,
                className: "btn-secondary",
                closeModal: true,
            },
            confirm: {
                text: "Ya, Keluar Sekarang!",
                value: true,
                visible: true,
                className: "btn-danger",
                closeModal: true
            }
        }
    }).then((value) => {
        if (value) {
            document.getElementById("form-logout").submit();
        }
    });
}

$('.pop').on('click', function () {
    $('.imagepreview').attr('src', $(this).data('url'));
    $('#imagemodal').modal('show');
});

const loadDataTable = () => {
    $("#data-table").dataTable({
        responsive: true,
        autoWidth: true
    });
}

const showSidebar = (val) => {
    const URL = `${BASE_URL}/pengaturan-aplikasi/change-sidebar-appearance`;
    $.post(URL, {status: val});
}

const tanggalIndonesia = (tgl) => {
    return tgl.toString().split("-").reverse().join("-");
}


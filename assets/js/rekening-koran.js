$(function () {
    const myURL = `${BASE_URL}rekening-koran/get-kode-pembayaran`;
    $("#kode-pembayaran").autocomplete({
        minLength: 1,
        maxLength:10,
        source: myURL
    });
});
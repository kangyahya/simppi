const buttonUpdate = document.querySelector("button[name=update]");
const statusShow = document.getElementById("status-show");
const colorInput = document.querySelectorAll(".colorinput-input");

statusShow.addEventListener('click',  () => {
    const showFullSidebar = document.getElementById("show_full_sidebar");
    const statusShowText = document.getElementById("status_show_text");

    if (parseInt(showFullSidebar.value) === 0) {
        showFullSidebar.value = 1;
        statusShowText.innerText = "TIDAK";
        buttonUpdate.click();
    } else {
        showFullSidebar.value = 0;
        statusShowText.innerText = "YA";
        buttonUpdate.click();
    }
});

const changeColorTheme = (element) => {
    colorInput.forEach((el) =>{
        if(el.hasAttribute('checked')) {
            el.removeAttribute('checked');
        }
    });
    element.setAttribute('checked', 'checked');
    buttonUpdate.click();
}
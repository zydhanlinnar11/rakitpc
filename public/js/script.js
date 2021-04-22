function setNavButtonClickability() {
    document.getElementById("nav-button-simulasi").onclick = () =>
        window.open("/simulasi", "_self");

    document.getElementById("nav-button-admin").onclick = () =>
        window.open("/admin", "_self");
}

setNavButtonClickability();

const ajax = new XMLHttpRequest();

function closeAlert() {
    const alert = document.getElementById("alert");

    alert.style.position = "fixed";
    alert.style.visibility = "hidden";
    alert.classList.remove(`alert-success`);
    alert.classList.remove(`alert-danger`);
}

function showAlert(type = new String(), message = new String()) {
    const alert = document.getElementById(`alert`);
    const alertMessage = document.getElementById(`alert-message`);
    const alertCloseBtn = document.getElementById(`alert-close-btn`);

    alert.classList.add(`alert-${type}`);
    alert.style.visibility = "visible";
    alert.style.position = "relative";
    alertMessage.innerText = message;
    alertCloseBtn.onclick = closeAlert;
}

ajax.onreadystatechange = () => {
    if (ajax.readyState == ajax.DONE) {
        showAlert(
            ajax.status == 200 ? "success" : "danger",
            JSON.parse(ajax.response).message
        );
    }
};

function tambahKategori() {
    const nama = document.getElementById("nama").value;
    const faClass = document.getElementById("fa-class").value;

    ajax.open("POST", "/api/admin/tambah-kategori", true);

    closeAlert();
    ajax.setRequestHeader("Content-Type", "application/json");
    ajax.send(JSON.stringify({ nama, faClass }));
}

function editKategori() {
    const nama = document.getElementById("nama").value;
    const faClass = document.getElementById("fa-class").value;
    const idKategori = document.getElementById("id_kategori").value;

    ajax.open("PATCH", "/api/admin/edit-kategori", true);

    closeAlert();
    ajax.setRequestHeader("Content-Type", "application/json");
    ajax.send(JSON.stringify({ nama, faClass, idKategori }));
}

function hitungHarga(selectForm) {
    const hargaBarang =
        selectForm.options[selectForm.options.selectedIndex].dataset.harga;
    // console.log(selectForm.id);
    console.log();
    document.getElementById(
        `${selectForm.id}-harga`
    ).value = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(hargaBarang);
}

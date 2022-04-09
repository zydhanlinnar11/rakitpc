function setNavButtonClickability() {
    document.getElementById("nav-button-simulasi").onclick = () =>
        window.open("/simulasi", "_self");

    document.getElementById("nav-button-home").onclick = () =>
        window.open("/", "_self");
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
        // console.log(ajax.response);
        showAlert(
            ajax.status == 200 ? "success" : "danger",
            JSON.parse(ajax.response).message
        );
    }
};

function tambahKategori(token) {
    const nama = document.getElementById("nama").value;
    const faClass = document.getElementById("fa-class").value;

    ajax.open("POST", "/api/admin/tambah-kategori", true);

    closeAlert();
    ajax.setRequestHeader("Content-Type", "application/json");
    ajax.setRequestHeader("Authorization", `Bearer ${token}`);
    ajax.send(JSON.stringify({ nama, faClass }));
}

function tambahBrand(token) {
    const nama = document.getElementById("nama").value;
    const deskripsi = document.getElementById("deskripsi").value;
    const urlLogo = document.getElementById("url_logo").value;

    ajax.open("POST", "/api/admin/tambah-brand", true);

    closeAlert();
    ajax.setRequestHeader("Content-Type", "application/json");
    ajax.setRequestHeader("Authorization", `Bearer ${token}`);
    ajax.send(JSON.stringify({ nama, deskripsi, urlLogo }));
}

function editKategori(token) {
    const nama = document.getElementById("nama").value;
    const faClass = document.getElementById("fa-class").value;
    const idKategori = document.getElementById("id_kategori").value;

    ajax.open("PATCH", "/api/admin/edit-kategori", true);

    closeAlert();
    ajax.setRequestHeader("Content-Type", "application/json");
    ajax.setRequestHeader("Authorization", `Bearer ${token}`);
    ajax.send(JSON.stringify({ nama, faClass, idKategori }));
}

function tambahSubkategori(token) {
    const nama = document.getElementById("nama").value;
    const idKategori = document.getElementById("kategori").value;
    const deskripsi = document.getElementById("deskripsi").value;

    console.log(idKategori);

    ajax.open("POST", "/api/admin/tambah-subkategori", true);

    closeAlert();
    ajax.setRequestHeader("Content-Type", "application/json");
    ajax.setRequestHeader("Authorization", `Bearer ${token}`);
    ajax.send(JSON.stringify({ nama, idKategori, deskripsi }));
}

function tambahSocket(token) {
    const nama = document.getElementById("nama").value;
    const idBrand = document.getElementById("brand").value;

    ajax.open("POST", "/api/admin/tambah-socket", true);

    closeAlert();
    ajax.setRequestHeader("Content-Type", "application/json");
    ajax.setRequestHeader("Authorization", `Bearer ${token}`);
    ajax.send(JSON.stringify({ nama, idBrand }));
}

function tambahItem(token) {
    const nama = document.getElementById("nama").value;
    const berat = document.getElementById("berat").value;
    const harga = document.getElementById("harga").value;
    const URLGambar = document.getElementById("url-gambar").value;
    const kategori = document.getElementById("kategori").value;
    const brand = document.getElementById("brand").value;
    const subkategori = document.getElementById("subkategori").value;
    const stok = document.getElementById("stok").value;
    const deskripsi = document.getElementById("deskripsi").value;
    const socket = document.getElementById("socket").value;
    const obj = {
        nama,
        berat,
        harga,
        URLGambar,
        kategori,
        socket,
        stok,
        brand,
        subkategori,
        deskripsi,
    };

    ajax.open("POST", "/api/admin/tambah-produk", true);

    closeAlert();
    ajax.setRequestHeader("Content-Type", "application/json");
    ajax.setRequestHeader("Authorization", `Bearer ${token}`);
    ajax.send(JSON.stringify(obj));
}

function editItem(token) {
    const id = document.getElementById("id").value;
    const nama = document.getElementById("nama").value;
    const berat = document.getElementById("berat").value;
    const harga = document.getElementById("harga").value;
    const URLGambar = document.getElementById("url-gambar").value;
    const kategori = document.getElementById("kategori").value;
    const brand = document.getElementById("brand").value;
    const subkategori = document.getElementById("subkategori").value;
    const stok = document.getElementById("stok").value;
    const deskripsi = document.getElementById("deskripsi").value;
    const socket = document.getElementById("socket").value;
    const obj = {
        id,
        nama,
        berat,
        harga,
        URLGambar,
        kategori,
        socket,
        stok,
        brand,
        subkategori,
        deskripsi,
    };

    ajax.open("PATCH", "/api/admin/edit-produk", true);

    closeAlert();
    ajax.setRequestHeader("Content-Type", "application/json");
    ajax.setRequestHeader("Authorization", `Bearer ${token}`);
    ajax.send(JSON.stringify(obj));
}

function hitungHarga(selectForm) {
    const hargaBarang =
        selectForm.options[selectForm.options.selectedIndex].dataset.harga;
    // console.log(selectForm.id);
    // console.log();
    document.getElementById(
        `${selectForm.id}-harga`
    ).value = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(hargaBarang);
}

function onchangeKategori() {
    const kategoriSelect = document.getElementById("kategori");
    const subkategoriSelect = document.getElementById("subkategori");
    const socketSelect = document.getElementById("socket");
    const subkategoriSelectElements = subkategoriSelect.length;
    if (
        kategoriSelect.value == socketSelect.dataset.motherboardCategoryId ||
        kategoriSelect.value == socketSelect.dataset.processorCategoryId
    )
        socketSelect.disabled = false;
    else {
        socketSelect.disabled = true;
        socketSelect.value = "";
    }

    for (let i = subkategoriSelectElements; i > 0; i--)
        subkategoriSelect.remove(i);

    fetch(`/api/subkategori?id_kategori=${kategoriSelect.value}`)
        .then((res) => res.json())
        .then((subcategories) =>
            subcategories.forEach((subcategory) => {
                const option = document.createElement("option");
                option.text = subcategory.nama;
                option.value = subcategory.id;
                subkategoriSelect.add(option);
            })
        );
}

function getToken(callback, csrf_token) {
    const xhrForToken = new XMLHttpRequest();
    xhrForToken.onreadystatechange = () => {
        if (
            xhrForToken.responseURL == "http://rakitpc.zydhan.com/login" ||
            xhrForToken.responseURL == "https://rakitpc.zydhan.com/login" ||
            xhrForToken.responseURL == "/login"
        )
            window.open(xhrForToken.responseURL, "_self");
        if (
            xhrForToken.readyState == xhrForToken.DONE &&
            typeof callback == "function"
        )
            callback(JSON.parse(xhrForToken.response).token);
    };
    xhrForToken.open("POST", "/user/tokens/create", true);
    xhrForToken.setRequestHeader("X-CSRF-TOKEN", csrf_token);
    xhrForToken.send();
}

function openSidebar(sideBlock, sideBar) {
    sideBlock.style.display = "flex";
    setTimeout(() => {
        sideBlock.style.background = "rgba(0, 0, 0, 0.3)";
        sideBar.style.transform = "translateX(0)";
    }, 100);
}

function closeSidebar(sideBlock, sideBar) {
    sideBlock.style.background = "rgba(0, 0, 0, 0.0)";
    sideBar.style.transform = "translateX(100%)";
    setTimeout(() => {
        sideBlock.style.display = "none";
    }, 300);
}

function openCloseNavbar() {
    const sideBlock = document.getElementById("side-bar-block");
    const sideBar = document.getElementById("side-bar");
    const isOpen = sideBlock.style.display == "flex";
    if (!isOpen) openSidebar(sideBlock, sideBar);
    else closeSidebar(sideBlock, sideBar);
}

function onClickShadow(event = new MouseEvent()) {
    const sideBlock = document.getElementById("side-bar-block");
    if (event.screenX <= sideBlock.clientWidth - 320) openCloseNavbar();
}

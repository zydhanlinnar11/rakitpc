function setNavButtonClickability() {
    document.getElementById("nav-button-simulasi").onclick = () =>
        window.open("/simulasi", "_self");
}

setNavButtonClickability();

function setQRCode(id) {
    let req = new XMLHttpRequest();
    req.open("POST", "/contract/getQRCode");
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.send(`id=${id}`);
    req.onreadystatechange = function () {

        if (this.status === 200 && this.readyState === 4) {
            document.getElementById("main").hidden = false;
            let QRCode = this.responseText;
            document.getElementById('QRCode').innerHTML = QRCode;
            prepareDownloadSVG(id);
        } else if (this.readyState === 4) {
            alert("Le contrat spécifié n'existe pas / plus");
            window.location.href = "/";
        }
    }
}

function onLoad() {
    setQRCode(getTarget('/view/'));
}

function toggleModal() {
    let m = document.getElementById("modal");
    if (m.classList.contains("show")) {
        m.classList.remove("show");
        m.setAttribute("style", "display: none;");
    } else {
        m.classList.add("show");
        m.setAttribute("style", "display: block;");
    }
}

function prepareDownloadSVG(id) {
    let el = document.getElementById("QRCode").outerHTML;
    var url = URL.createObjectURL(new Blob([el], { type: "image/svg+xml;charset=utf-8" }));
    document.getElementById("dlsvg").href = url;
    document.getElementById("dlsvg").download = id + ".svg";
}

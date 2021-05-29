function setQRCode(id) {
    let req = new XMLHttpRequest();
    req.open("POST", "/contract/getQRCode");
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.send(`id=${id}`);
    req.onreadystatechange = function () {

        if (this.status === 200 && this.readyState === 4) {

            let QRCode = this.responseText;
            document.getElementById('QRCode').innerHTML = QRCode;
        }
    }
}

function onLoad() {

    setQRCode(getTarget('/viewcontrat/'));
}

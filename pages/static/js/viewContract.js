let Redirect = true;
let tmp = "";

function enableRedirect() {
    Redirect = true;
}

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
        }
    }
}

function dispContrat(contrat) {
    document.getElementById('start').value = getDate(contrat.start);
    document.getElementById('end').value = getDate(contrat.end);
    if (Object.hasOwnProperty.call(contrat, 'vID')) {
        document.getElementById('contrat_vID').parentNode.classList.remove('d-none');
        document.getElementById('contrat_vID').value = contrat.vID;
    }
    if (Object.hasOwnProperty.call(contrat, 'countryCode')) {
        document.getElementById('countryCode').parentNode.classList.remove('d-none');
        document.getElementById('countryCode').value = contrat.countryCode;
    }
    if (Object.hasOwnProperty.call(contrat, 'category')) {
        document.getElementById('category').parentNode.classList.remove('d-none');
        document.getElementById('category').value = contrat.category;
    }
    if (Object.hasOwnProperty.call(contrat, 'manufacturer')) {
        document.getElementById('manufacturer').parentNode.classList.remove('d-none');
        document.getElementById('manufacturer').value = contrat.manufacturer;
    }
    if (Object.hasOwnProperty.call(contrat, 'terVal')) {
        document.getElementById('terValList').classList.remove('d-none');
        document.getElementById('terValList').innerHTML = "<h5>Validité territoriale</h5>";
        let container = document.createElement('div');
        container.className = "row g-3";
        for (const key in contrat.terVal) {
            if (Object.hasOwnProperty.call(contrat.terVal, key)) {
                const val = contrat.terVal[key];
                let valContainer = document.createElement('div');
                valContainer.className = "col-sm-1";
                valContainer.innerHTML = `
<div class="form-check">
    <input class="form-check-input" type="checkbox" checked="${val}" readonly disabled>
    <label class="form-check-label">${key}</label>
</div>
                `;
                container.appendChild(valContainer);
            }
        }
        document.getElementById('terValList').appendChild(container);
    }
}

function fillOptionContracts() {
    let req = new XMLHttpRequest();
    req.open("POST", "/contract/getList");
    req.send();
    req.onreadystatechange = function () {

        if (this.status === 200 && this.readyState === 4) {
            let contracts = JSON.parse(this.responseText);
            let contractNode = document.getElementById("contratList");
            contracts.forEach(contract => {
                let option = document.createElement("option");
                option.value = contract.id;
                option.innerText = `${contract.manufacturer} (${contract.vID})`;
                contractNode.appendChild(option);
            });
        }
    }
}

function querryUser(id) {
    let req = new XMLHttpRequest();
    req.open("POST", "/users/get");
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.send(`id=${id}`);
    req.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            let user = JSON.parse(this.responseText);
            document.getElementById('owner').classList.remove('d-none');
            document.getElementById('owner_name').value = user.name
        }
    }
}

function querryAssurane(id) {
    let req = new XMLHttpRequest();
    req.open("POST", "/assurance/get");
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.send(`id=${id}`);
    req.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            let assurance = JSON.parse(this.responseText);
            document.getElementById('assurance').classList.remove('d-none');
            document.getElementById('assurance_name').value = assurance.name
        }
    }
}


function querryContrat(id, more = true) {
    let req = new XMLHttpRequest();
    req.open("POST", "/contract/get");
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.send(`id=${id}`);
    req.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            let contrat = JSON.parse(this.responseText);
            setQRCode(id);
            dispContrat(contrat);
            if (more) {
                querryUser(contrat.owners[0]);
                querryAssurane(contrat.insurance);
                document.getElementById("edit").hidden = false;
                tmp = id;
            }
        } else if (this.readyState === 4) {
            if (Redirect) {
                alert("Le contrat spécifié n'existe pas / plus");
                window.location.href = "/";
            }
        }
    }
}

function edit() {
    window.location.href = "/editcontrat/" + tmp;
}

function onLoad() {
    let id = getTarget('/view/');
    if (id) {
        setQRCode(id);
        querryContrat(id);
    }

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

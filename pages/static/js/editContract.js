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
        document.getElementById('terValContainer').classList.remove('d-none');
        let container = document.createElement('div');
        container.className = "row g-3";
        for (const key in contrat.terVal) {
            if (Object.hasOwnProperty.call(contrat.terVal, key)) {
                const val = contrat.terVal[key];
                let valContainer = document.getElementById(key);
                valContainer.checked = val;
            }
        }
        document.getElementById('terValList').appendChild(container);
    }
}

function sendDate(formNode) {
    if (formNode.checkValidity()) {
        let form = new FormData(formNode);
        let req = new XMLHttpRequest();
        form.append('id', document.getElementById('contratList').value)
        req.open("POST", "/contract/set");
        req.send(form);
        req.onreadystatechange = function () {

            if (this.status === 200 && this.readyState === 4) {
                let contrat = JSON.parse(this.responseText);
                // window.location.href = `editcontrat/${contrat.id}`
            }
        }
    }
}

function sendTerVal(formNode) {
    if (formNode.checkValidity()) {
        let form = new FormData(formNode);
        let req = new XMLHttpRequest();
        form.append('id', document.getElementById('contratList').value)
        req.open("POST", "/contract/setTerVal");
        req.send(form);
        req.onreadystatechange = function () {

            if (this.status === 200 && this.readyState === 4) {
                let contrat = JSON.parse(this.responseText);
                // window.location.href = `editcontrat/${contrat.id}`
            }
        }
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

function querryContrat(id) {
    let req = new XMLHttpRequest();
    req.open("POST", "/contract/get");
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.send(`id=${id}`);
    req.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            let contrat = JSON.parse(this.responseText);
            showListTerVal()
            dispContrat(contrat);
        } else if (this.readyState === 4) {
        }
    }
}

function showListTerVal() {
    let container = document.getElementById("terValList");
    container.innerHTML = "<h5>Validité territoriale</h5>";
    let valList = ['A', 'B', 'BG', 'CY', 'CZ', 'D', 'DK', 'E', 'EST', 'F', 'FIN', 'GB', 'GR', 'H', 'HR', 'I', 'IRL', 'IS', 'L', 'LT', 'LV', 'M', 'N', 'NL', 'P', 'PL', 'RO', 'S', 'SK', 'SLO', 'CH', 'AL', 'AND', 'AZ', 'BIH', 'BY', 'IL', 'IR', 'MA', 'MD', 'MK', 'MNE', 'RUS', 'SRB', 'TN', 'TR', 'UA'];
    valList.forEach(val => {
        let valContainer = document.createElement('div');
        valContainer.className = "col-sm-1 form-check";
        valContainer.innerHTML = `
        <input class="form-check-input" type="checkbox" value="1" name="${val}" id="${val}">
        <label class="form-check-label" for="${val}">${val}</label>
        `;
        container.appendChild(valContainer);
    });
}

function onLoad() {
    let id = getTarget('/editcontrat/');
    fillOptionContracts();
    querryContrat(id);
}

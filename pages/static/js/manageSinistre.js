function fillOptionContracts() {
    let req = new XMLHttpRequest();
    req.open("POST", "/contract/getList");
    req.send();
    req.onreadystatechange = function() {

        if (this.status === 200 && this.readyState === 4) {
            let contracts = JSON.parse(this.responseText);
            let contractNode = document.getElementById("contrat");
            contracts.forEach(contract => {
                let option = document.createElement("option");
                option.value = contract.id;
                option.innerText = `${contract.manufacturer} (${contract.vID})`;
                contractNode.appendChild(option);
            });
        }
    }
}

function onLoad() {
    fillOptionContracts();
}

function fillOptionContracts() {
    let req = new XMLHttpRequest();
    req.open("POST", "/contract/getList");
    req.send();
    req.onreadystatechange = function () {

        if (this.status === 200 && this.readyState === 4) {
            let contracts = JSON.parse(this.responseText);
            let contractNode = document.getElementById("contrat_sinistre");
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
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    fillOptionContracts();
}

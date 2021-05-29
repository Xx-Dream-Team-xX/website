function fillOptionContracts() {
    let req = new XMLHttpRequest();
    req.open("POST", "/users/list");
    req.send();
    req.onreadystatechange = function () {

        if (this.status === 200 && this.readyState === 4) {
            let user = JSON.parse(this.responseText);
            let userNode = document.getElementById("user");
            user.forEach(user => {
                let option = document.createElement("option");
                option.value = user.id;
                option.innerText = `${user.name} (${user.id})`;
                userNode.appendChild(option);
            });
        }
    }
}

function showListTerVal() {
    let container = document.getElementById("terValList");
    let valList = ['A', 'B', 'BG', 'CY', 'CZ', 'D', 'DK', 'E', 'EST', 'F', 'FIN', 'GB', 'GR', 'H', 'HR', 'I', 'IRL', 'IS', 'L', 'LT', 'LV', 'M', 'N', 'NL', 'P', 'PL', 'RO', 'S', 'SK', 'SLO', 'CH', 'AL', 'AND', 'AZ', 'BIH', 'BY', 'IL', 'IR', 'MA', 'MD', 'MK', 'MNE', 'RUS', 'SRB', 'TN', 'TR', 'UA'];
    valList.forEach(val => {
        let valContainer = document.createElement('div');
        valContainer.className = "col-sm-1 form-check";
        valContainer.innerHTML = `
        <input class="form-check-input" type="checkbox" value="1" name="terVal[${val}]" id="${val}">
        <label class="form-check-label" for="${val}">${val}</label>
        `;
        container.appendChild(valContainer);
    });
}

function checkImmat() {
    let regex = /[A-HJ-NP-TV-Z]{2}[\s-]{0,1}[0-9]{3}[\s-]{0,1}[A-HJ-NP-TV-Z]{2}|[0-9]{2,4}[\s-]{0,1}[A-Z]{1,3}[\s-]{0,1}[0-9]{2}/gm;
    var myString = document.getElementById('vID').value;
    var isPlateOK = regex.test(myString);
    let ImmatNode = document.getElementById('ImmatHelpBlock');
    if (!isPlateOK) {
        ImmatNode.innerText = 'Invalid ID plate'
    } else {
        ImmatNode.innerText = ''
    }
}

function sendContrat(formNode) {
    if (formNode.checkValidity()) {
        let form = new FormData(formNode);
        let req = new XMLHttpRequest();
        req.open("POST", "/contract/add");
        req.send(form);
        req.onreadystatechange = function () {

            if (this.status === 200 && this.readyState === 4) {
                let contrat = JSON.parse(this.responseText);
                window.location.href = `view/${contrat.id}`
            }
        }
    }

}

function onLoad() {
    fillOptionContracts();
    showListTerVal();

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
}

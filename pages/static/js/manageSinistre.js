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

function addInjured(button) {
    let injuredForm = document.createElement('div');
    injuredForm.className = "row g-3 border border-1 rounded p-3 mt-3";
    injuredForm.innerHTML = `
    <form name="injuredForm" action="javascript:;" onsubmit="sendInjured(this);" accept-charset="utf-8">
        <div class="row g-3">
            <div class="col-sm-6">
                <label for="lastname" class="form-label">Nom</label>
                <input type="text" class="form-control" value="" name="lastname" id="lastname" required>
            </div>
            <div class="col-sm-6">
                <label for="firstname" class="form-label">Prénom</label>
                <input type="text" class="form-control" value="" name="firstname" id="firstname" required>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-sm-6">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control" name="inputAddress" id="inputAddress" placeholder="Address.." required>
            </div>
            <div class="col-sm-6">
                <label for="inputVille" class="form-label">Ville</label>
                <input type="text" class="form-control" name="inputVille" id="inputVille" placeholder="Pau.." required>
            </div>
            <div class="col-sm-6">
                <label for="zipcode" class="form-label">Code Postal</label>
                <input type="number" class="form-control" name="zipcode" id="zipcode" required>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-sm-6">
                <label for="profession" class="form-label">Profession</label>
                <input type="text" class="form-control" name="profession" id="profession" required>
            </div>
            <div class="col-sm-6">
                <label for="phone" class="form-label">Téléphone</label>
                <input type="phone" class="form-control" name="phone" id="phone" required>
            </div>
        </div>
        <div class="row g-3 pt-3">
            <div class="form-check">
                <input class="form-check-input" type="hidden" value="0" name="belt" id="belt">
                <input class="form-check-input" type="checkbox" value="1" name="belt" id="belt">
                <label class="form-check-label" for="belt">Ceinture</label>
            </div>
        </div>
        <div class="row g-3 pt-3">
            <label for="injuries" class="form-label">
                <h5>Blessures</h5>
            </label>
            <textarea id="injuries" name="injuries" type="text" placeholder="Liste des blessures" aria-describedby="button-addon2" class="form-control rounded border bg-light" required></textarea>
        </div>
        <input type="submit" style="display:none" name="submitButton">
    </form>
    <button type="submit" class="btn btn-primary" name="removeInjured" onclick="removeInjured(this)">Supprimé</button>`;
    let parent = button.parentNode
    parent.insertBefore(injuredForm, button);
    console.log(button.parentNode);
}

function removeInjured(button) {
    button.parentNode.remove();
}

function showcompletesinistre() {
    document.getElementById('sinistre').parentNode.remove();
    document.getElementById('injureds').classList.remove('d-none');
}

var sinistre = null;

sinistre = {
    "contract": "12432534588",
    "user": "60aec6503bc74",
    "user_profession": "esclave",
    "driver_profession": "portier",
    "driver_relationship": "married",
    "driver_user_same_residance": true,
    "driver_is_usual": true,
    "driver_is_employeeof_user": true,
    "driver_disp_reason": "work",
    "circumstances": "i don't know",
    "proces_verbal": false,
    "police_report": false,
    "main_courante": false,
    "usual_parking_location": "chez moi",
    "id": "60aedbf5356a2",
    "injureds": []
}

function sendSinistre(formNode) {
    if (formNode.checkValidity()) {
        let form = new FormData(formNode);
        form.set('contract', document.getElementById('contrat_sinistre').value);
        let req = new XMLHttpRequest();
        req.open("POST", "/sinistre/add");
        req.send(form);
        req.onreadystatechange = function () {

            if (this.status === 200 && this.readyState === 4) {
                sinistre = JSON.parse(this.responseText);
                showcompletesinistre();
                document.getElementById('constat').classList.remove('d-none');
                document.getElementById('injureds').classList.remove('d-none');
            }
        }
    }

}

function sendConstat(formNode) {

    if (formNode.checkValidity()) {
        let form = new FormData(formNode);
        form.append('A_driver_address', `${form.get('A_inputAddress')}, ${form.get('A_inputVille')}`);
        form.append('id', sinistre.id);
        form.delete('A_inputAddress');
        form.delete('A_inputVille');
        form.append('B_driver_address', `${form.get('B_inputAddress')}, ${form.get('B_inputVille')}`);
        form.append('id', sinistre.id);
        form.delete('B_inputAddress');
        form.delete('B_inputVille');

        form.append('id', sinistre.id);
        let req = new XMLHttpRequest();
        req.open("POST", "/sinistre/addConstat");
        req.send(form);
        req.onreadystatechange = function () {
            if (this.status === 200 && this.readyState === 4) {

            } else {
            }
        }
    }

}

function showConstat(button) {
    document.getElementById('constatContainer').classList.remove('d-none');
    button.classList.add('d-none');

}

function hideConstat(button) {
    document.getElementById('constatContainer').classList.add('d-none');
    document.getElementById('showConstat').classList.remove('d-none');

}

function sendInjured(formNode) {
    let form = new FormData(formNode);
    for (var key of form.keys()) {
        console.log(`${key}, ${form.get(key)}`);
    }
    form.append('address', `${form.get('inputAddress')}, ${form.get('inputVille')}`);
    form.append('id', sinistre.id);
    form.delete('inputAddress');
    form.delete('inputVille');

    form.set('contract', document.getElementById('contrat_sinistre').value);
    let req = new XMLHttpRequest();
    req.open("POST", "/sinistre/addInjured");
    req.send(form);
    req.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            console.log('sent');
        }
    }
}

function sendInjureds(button) {

    let forms = document.getElementsByName('injuredForm');
    console.log(forms.length);
    for (var i = 0; i < forms.length; i++) {
        let formNode = forms.item(i);
        formNode.addEventListener('submit', function (event) {
            if (!formNode.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            } else {
                formNode.classList.add('was-validated')
                formNode.submitButton.click();
            }

            formNode.classList.add('was-validated')
        }, false)
        if (formNode.checkValidity()) {
            formNode.classList.add('was-validated')
            formNode.submitButton.click();
            break;
        }
    }

}

function togglePoliceStation(checkbox) {
    if (checkbox.checked) {
        let field = document.createElement('div');
        field.innerHTML = `
        <div class="form-check">
            <label for="police_station" class="form-label">Brigade ou commissariat</label>
            <input type="text" class="form-control" name="police_station" id="police_station" required>
            <div class="invalid-feedback">
                Veuillez entrer le nom de la brigade ou commisariat.
            </div>
        </div>
        `
        checkbox.parentNode.parentNode.appendChild(field);
    } else {
        document.getElementById("police_station").parentNode.remove();
    }
}

function toggleGarage(checkbox) {
    if (checkbox.checked) {
        let field = document.createElement('div');
        field.className = "row g-3 p-3 pt-1";
        field.id = 'garage_fields';
        field.innerHTML = `
        <div class="col-sm">
            <label for="driver_profession" class="form-label">Nom</label>
            <input type="text" class="form-control" name="driver_profession" id="driver_profession" required>
            <div class="invalid-feedback">
                Veuillez entrer le nom du garage.
            </div>
        </div>
        <div class="col-sm">
            <label for="garage_phone" class="form-label">Téléphone</label>
            <input type="phone" class="form-control" name="garage_phone" id="garage_phone" required>
            <div class="invalid-feedback">
                Veuillez entrer le numéro de téléphone du garage.
            </div>
        </div>
        <div class="col-sm">
            <label for="garage_email" class="form-label">e-mail</label>
            <input type="email" class="form-control" name="garage_email" id="garage_email" required>
            <div class="invalid-feedback">
                Veuillez entrer l'e-mail du garage.
            </div>
        </div>
        `
        checkbox.parentNode.appendChild(field);
    } else {
        document.getElementById("garage_fields").remove();
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

function parseURLParams() {
    let url = window.location.href;
    var queryStart = url.indexOf("?") + 1,
        queryEnd = url.indexOf("#") + 1 || url.length + 1,
        query = url.slice(queryStart, queryEnd - 1),
        pairs = query.replace(/\+/g, " ").split("&"),
        parms = {}, i, n, v, nv;

    if (query === url || query === "") return;

    for (i = 0; i < pairs.length; i++) {
        nv = pairs[i].split("=", 2);
        n = decodeURIComponent(nv[0]);
        v = decodeURIComponent(nv[1]);

        if (!parms.hasOwnProperty(n)) parms[n] = [];
        parms[n].push(nv.length === 2 ? v : null);
    }
    return parms;
}

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

function selectGivenSinistre() {
    let params = parseURLParams();
    if (params !== undefined && Object.hasOwnProperty.call(params, 'id')) {
        let sinistreListNode = document.getElementById("sinistre_list");
        for (i = 0; i < sinistreListNode.length; i++) {
            if (sinistreListNode.options[i].value == params.id[0]) {
                sinistreListNode.selectedIndex = `${i}`;
                updateSinistre(sinistreListNode)
            }
        }
    }
}

function fillOptionSinistreList() {
    let req = new XMLHttpRequest();
    req.open("POST", "/sinistre/getList");
    req.send();
    req.onreadystatechange = function () {

        if (this.status === 200 && this.readyState === 4) {

            let sinistres = JSON.parse(this.responseText);
            let sinistreListNode = document.getElementById("sinistre_list");
            sinistres.forEach(sinistre => {
                let option = document.createElement("option");
                option.value = sinistre.id;
                let date = new Date(sinistre.date * 1000);
                option.innerText = `Contrat N°${sinistre.contract} (${date.getDate()}/${date.getMonth()}/${date.getFullYear()})`;
                sinistreListNode.appendChild(option);
            });
            selectGivenSinistre();
        }
    }
}


function updateSinistre(select) {
    let req = new XMLHttpRequest();
    req.open("POST", "/sinistre/get");
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.send(`id=${select.value}`);
    req.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            let sinistre = JSON.parse(this.responseText);
            displaySinistre(sinistre)
        }
    }
}

function displayContrat(contratID) {
    let req = new XMLHttpRequest();
    req.open("POST", "/contract/get");
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.send(`id=${contratID}`);
    req.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            let contrat = JSON.parse(this.responseText);
            let start = new Date(contrat.start * 1000);
            document.getElementById('contrat_start').innerText = `${start.getDate()}/${start.getMonth()}/${start.getFullYear()}`;
            let end = new Date(contrat.end * 1000);
            document.getElementById('contrat_end').innerText = `${end.getDate()}/${end.getMonth()}/${end.getFullYear()}`;
            document.getElementById('contrat_vID').innerText = contrat.vID;
            document.getElementById('contrat_manufacturer').innerText = contrat.manufacturer;
        }
    }
}

function displaySinistre(sinistreData) {
    displayContrat(sinistreData.contract);
    document.getElementById('driver_profession').innerText = sinistreData.driver_profession;
    switch (sinistreData.driver_relationship) {
        case 'married':
            sinistreData.driver_relationship = "Marié"
            break;
        case 'celib':
            sinistreData.driver_relationship = "Célibataire"
            break;
        case 'other':
            sinistreData.driver_relationship = "Autre"
            break;
        default:
            break;
    }
    document.getElementById('driver_relationship').innerText = sinistreData.driver_relationship;
    document.getElementById('driver_disp_reason').innerText = sinistreData.driver_disp_reason;
    document.getElementById('driver_user_same_residance').checked = sinistreData.driver_user_same_residance;
    document.getElementById('driver_is_usual').checked = sinistreData.driver_is_usual;
    document.getElementById('driver_is_employeeof_user').checked = sinistreData.driver_is_employeeof_user;
    let date = new Date(sinistreData.date * 1000);
    document.getElementById('incident_date').innerText = `${date.getDate()}/${date.getMonth()}/${date.getFullYear()}`;
    document.getElementById('circumstances').innerText = sinistreData.circumstances;
    document.getElementById('proces_verbal').checked = sinistreData.proces_verbal;
    document.getElementById('police_report').checked = sinistreData.police_report;
    document.getElementById('main_courante').checked = sinistreData.main_courante;
    if (sinistreData.main_courante) {
        document.getElementById('police_stationContainer').classList.remove('d-none');
        document.getElementById('police_station').innerText = sinistreData.police_station
    }
    document.getElementById('usual_parking_location').innerText = sinistreData.usual_parking_location;
    if (Object.hasOwnProperty.call(sinistreData, 'garage_name')) {
        document.getElementById('garage_container').classList.remove('d-none');
        document.getElementById('garage_name').innerText = sinistreData.garage_name;
        document.getElementById('garage_phone').innerText = sinistreData.garage_phone;
        document.getElementById('garage_email').innerText = sinistreData.garage_email;
    }
    document.getElementById('other_damage').innerText = sinistreData.other_damage;
    if (Object.hasOwnProperty.call(sinistreData, 'constat')) {
        document.getElementById('constat_container').classList.remove('d-none');
        let dateConstat = new Date(sinistreData.constat.date * 1000);
        document.getElementById('constat_date').innerText = `${dateConstat.getDate()}/${dateConstat.getMonth()}/${dateConstat.getFullYear()}`;
        document.getElementById('location').innerText = sinistreData.constat.location;
        document.getElementById('witnesses').innerText = sinistreData.constat.witnesses;
        document.getElementById('injured').checked = sinistreData.constat.injured;
        document.getElementById('other_vehicle_involved').checked = sinistreData.constat.other_vehicle_involved;
        document.getElementById('other_object_involved').checked = sinistreData.constat.other_object_involved;
        document.getElementById('A_contract').innerText = sinistreData.constat.A_contract;
        document.getElementById('A_driver_lastname').innerText = sinistreData.constat.A_driver_lastname;
        document.getElementById('A_driver_firstname').innerText = sinistreData.constat.A_driver_firstname;
        dateConstat = new Date(sinistreData.constat.A_driver_birthdate * 1000);
        document.getElementById('A_driver_birthdate').innerText = `${dateConstat.getDate()}/${dateConstat.getMonth()}/${dateConstat.getFullYear()}`;
        document.getElementById('A_driver_address').innerText = sinistreData.constat.A_driver_address;
        document.getElementById('A_driver_country').innerText = sinistreData.constat.A_driver_country;
        document.getElementById('A_driver_phone').innerText = sinistreData.constat.A_driver_phone;
        document.getElementById('A_dirver_email').innerText = sinistreData.constat.A_dirver_email;
        document.getElementById('A_driver_liscence_id').innerText = sinistreData.constat.A_driver_liscence_id;
        document.getElementById('A_driver_liscence_cat').innerText = sinistreData.constat.A_driver_liscence_cat;
        document.getElementById('A_driver_liscence_expire').innerText = sinistreData.constat.A_driver_liscence_expire;
        document.getElementById('A_vehicle_initial_impact').innerText = sinistreData.constat.A_vehicle_initial_impact;
        document.getElementById('A_vehicle_damage').innerText = sinistreData.constat.A_vehicle_damage;
        document.getElementById('A_observation').innerText = sinistreData.constat.A_observation;
        document.getElementById('A_stationing').checked = sinistreData.constat.A_stationing;
        document.getElementById('A_leaving_parking_spot').checked = sinistreData.constat.A_leaving_parking_spot;
        document.getElementById('A_entering_parking_spot').checked = sinistreData.constat.A_entering_parking_spot;
        document.getElementById('A_entering_place').checked = sinistreData.constat.A_entering_place;
        document.getElementById('A_leaving_place').checked = sinistreData.constat.A_leaving_place;
        document.getElementById('A_round_point').checked = sinistreData.constat.A_round_point;
        document.getElementById('A_rear_damage_on_road').checked = sinistreData.constat.A_rear_damage_on_road;
        document.getElementById('A_oposite_road_line').checked = sinistreData.constat.A_oposite_road_line;
        document.getElementById('A_line_change').checked = sinistreData.constat.A_line_change;
        document.getElementById('A_overtake').checked = sinistreData.constat.A_overtake;
        document.getElementById('A_right_turn').checked = sinistreData.constat.A_right_turn;
        document.getElementById('A_left_turn').checked = sinistreData.constat.A_left_turn;
        document.getElementById('A_driving_backward').checked = sinistreData.constat.A_driving_backward;
        document.getElementById('A_past_line').checked = sinistreData.constat.A_past_line;
        document.getElementById('A_from_right').checked = sinistreData.constat.A_from_right;
        document.getElementById('A_skip_priority').checked = sinistreData.constat.A_skip_priority;

        document.getElementById('B_contract').innerText = sinistreData.constat.B_contract;
        document.getElementById('B_driver_lastname').innerText = sinistreData.constat.B_driver_lastname;
        document.getElementById('B_driver_firstname').innerText = sinistreData.constat.B_driver_firstname;
        dateConstat = new Date(sinistreData.constat.B_driver_birthdate * 1000);
        document.getElementById('B_driver_birthdate').innerText = `${dateConstat.getDate()}/${dateConstat.getMonth()}/${dateConstat.getFullYear()}`;
        document.getElementById('B_driver_address').innerText = sinistreData.constat.B_driver_address;
        document.getElementById('B_driver_country').innerText = sinistreData.constat.B_driver_country;
        document.getElementById('B_driver_phone').innerText = sinistreData.constat.B_driver_phone;
        document.getElementById('B_dirver_email').innerText = sinistreData.constat.B_dirver_email;
        document.getElementById('B_driver_liscence_id').innerText = sinistreData.constat.B_driver_liscence_id;
        document.getElementById('B_driver_liscence_cat').innerText = sinistreData.constat.B_driver_liscence_cat;
        document.getElementById('B_driver_liscence_expire').innerText = sinistreData.constat.B_driver_liscence_expire;
        document.getElementById('B_vehicle_initial_impact').innerText = sinistreData.constat.B_vehicle_initial_impact;
        document.getElementById('B_vehicle_damage').innerText = sinistreData.constat.B_vehicle_damage;
        document.getElementById('B_observation').innerText = sinistreData.constat.B_observation;
        document.getElementById('B_stationing').checked = sinistreData.constat.B_stationing;
        document.getElementById('B_leaving_parking_spot').checked = sinistreData.constat.B_leaving_parking_spot;
        document.getElementById('B_entering_parking_spot').checked = sinistreData.constat.B_entering_parking_spot;
        document.getElementById('B_entering_place').checked = sinistreData.constat.B_entering_place;
        document.getElementById('B_leaving_place').checked = sinistreData.constat.B_leaving_place;
        document.getElementById('B_round_point').checked = sinistreData.constat.B_round_point;
        document.getElementById('B_rear_damage_on_road').checked = sinistreData.constat.B_rear_damage_on_road;
        document.getElementById('B_oposite_road_line').checked = sinistreData.constat.B_oposite_road_line;
        document.getElementById('B_line_change').checked = sinistreData.constat.B_line_change;
        document.getElementById('B_overtake').checked = sinistreData.constat.B_overtake;
        document.getElementById('B_right_turn').checked = sinistreData.constat.B_right_turn;
        document.getElementById('B_left_turn').checked = sinistreData.constat.B_left_turn;
        document.getElementById('B_driving_backward').checked = sinistreData.constat.B_driving_backward;
        document.getElementById('B_past_line').checked = sinistreData.constat.B_past_line;
        document.getElementById('B_from_right').checked = sinistreData.constat.B_from_right;
        document.getElementById('B_skip_priority').checked = sinistreData.constat.B_skip_priority;
    }

}

function addInjured(button) {
    let injuredForm = document.createElement('div');
    injuredForm.className = "row g-3 border border-1 rounded p-3 mt-3";
    injuredForm.innerHTML = `
<form name = "injuredForm" action = "javascript:;" onsubmit = "sendInjured(this);" accept - charset="utf-8">
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
                window.location.pathname(`viewsinistre?id=${sinistre.id}`)
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
    form.append('address', `${form.get('inputAddress')}, ${form.get('inputVille')}`);
    form.append('id', sinistre.id);
    form.delete('inputAddress');
    form.delete('inputVille');

    form.set('contract', sinistre.contract);
    let req = new XMLHttpRequest();
    req.open("POST", "/sinistre/addInjured");
    req.send(form);
    req.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            console.log('sent');
            document.getElementById('injureds').remove();
        }
    }
}

function sendInjureds(button) {

    let forms = document.getElementsByName('injuredForm');
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


function onLoadSinistreList() {
    fillOptionSinistreList();
}

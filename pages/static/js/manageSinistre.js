function fillOptionContracts() {
    let req = new XMLHttpRequest();
    req.open("POST", "/contract/getList");
    req.send();
    req.onreadystatechange = function() {

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
    <form action="" method="POST" accept-charset="utf-8">
        <div class="row g-3">
            <div class="col-sm-6">
                <label for="lastname" class="form-label">Nom</label>
                <input type="text" class="form-control" value="" name="lastname" id="lastname">
            </div>
            <div class="col-sm-6">
                <label for="firstname" class="form-label">Prénom</label>
                <input type="text" class="form-control" value="" name="firstname" id="firstname">
            </div>
        </div>
        <div class="row g-3">
            <div class="col-sm-6">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="Address..">
            </div>
            <div class="col-sm-6">
                <label for="inputVille" class="form-label">Ville</label>
                <input type="text" class="form-control" id="inputVille" placeholder="Pau..">
            </div>
            <div class="col-sm-6">
                <label for="inputCP" class="form-label">Code Postal</label>
                <input type="number" class="form-control" id="inputCodePostal">
            </div>
        </div>
        <div class="row g-3">
            <div class="col-sm-6">
                <label for="profession" class="form-label">Profession</label>
                <input type="text" class="form-control" name="profession" id="profession">
            </div>
        </div>
        <div class="row g-3 pt-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" name="belt" id="belt">
                <label class="form-check-label" for="belt">Ceinture</label>
            </div>
        </div>
        <div class="row g-3 pt-3">
            <label for="injuries" class="form-label">
                <h5>Blessures</h5>
            </label>
            <textarea id="injuries" name="injuries" type="text" placeholder="Liste des blessures" aria-describedby="button-addon2" class="form-control rounded border bg-light"></textarea>
        </div>
    </form>
    <button type="submit" class="btn btn-primary" name="removeInjured" onclick="removeInjured(this)">Supprimé</button>`;
    let parent = button.parentNode
    parent.insertBefore(injuredForm,button);
    console.log(button.parentNode);
}

function removeInjured(button) {
    button.parentNode.remove();
}

function showcompletesinistre(sinistreData) {
    document.getElementById('sinistre').parentNode.remove();
}

function sendSinistre(formNode) {
    sinistre = {
        "contract": "12432534588",
        "user": "60aec6503bc74",
        "date": false,
        "driver_profession": "sgfds",
        "driver_relationship": "married",
        "driver_user_same_residance": false,
        "driver_is_usual": false,
        "driver_is_employeeof_user": false,
        "driver_disp_reason": "sfds",
        "circumstances": "sfgdsfg",
        "proces_verbal": false,
        "police_report": false,
        "main_courante": false,
        "usual_parking_location": "sdfg",
        "other_damage": "sfdg",
        "id": "60afccacf2102",
        "injureds": []
    }

    showcompletesinistre(sinistre);
    // let form = new FormData(formNode);
    // for (var key of form.keys()) {
    //         console.log(`${key}, ${form.get(key)}`);
    // }
    // form.set('contract',document.getElementById('contrat_sinistre').value);
    // let req = new XMLHttpRequest();
    // req.open("POST", "/sinistre/add");
    // req.send(form);
    // req.onreadystatechange = function() {

    //     if (this.status === 200 && this.readyState === 4) {
    //         sinistre = JSON.parse(this.responseText);
    //         showcompletesinistre(sinistre);
    //     }
    // }

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
        field.className = "row g-3 p-3 pt-1" ;
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

function fillOptionContracts() {
    let req = new XMLHttpRequest();
    req.open("POST", "/declaration/getList");
    req.send();
    req.onreadystatechange = function () {

        if (this.status === 200 && this.readyState === 4) {
            let delcarations = JSON.parse(this.responseText);
            let declarationNode = document.getElementById("contrat_sinistre");
            delcarations.forEach(declaration => {
                let option = document.createElement("option");
                option.value = declaration.id;
                option.innerText = `${declaration.manufacturer} (${declaration.contract})`;
                declarationNode.appendChild(option);
            });
        }
    }
}

function toggle_phys(select, sexeNode) {
    if (select.value == "1") {
        document.getElementById(sexeNode).innerHTML = `
    <select class="form-select" aria-label="user" name="old_sex" id="old_sex" required>
        <option disabled selected>Sexe</option>
        <option value="1">Homme</option>
        <option value="0">Femme</option>
    </select>
        `;
    } else {
        document.getElementById(sexeNode).innerHTML = "";
    }
}

function toggle_cert(checkbox) {
    if (checkbox.checked) {
        document.getElementById('formule').innerHTML = `
        <div class="col-sm-6 mt-0">
            <p class="h6 mt-0 text-dark">Numéro de formule</p>
            <input type="text" pattern="[0-9]{11}" class="form-control p-1" name="ima_cert_id" id="ima_cert_id">
        </div>`;
    } else {
        document.getElementById('formule').innerHTML = `
        <p class="h6 mt-0 text-dark"> Motif d’absence de certificat d’immatriculation :</p>
        <textarea id="ima_missing_cert_desc" name="ima_missing_cert_desc" type="text" aria-describedby="button-addon2" class="form-control rounded border bg-light" required></textarea>`;
    }
}

function toggle_VHU(checkbox) {
    if (checkbox.checked) {
        document.getElementById('VHU').innerHTML = `
        <input type="text" placeholder="VHU" pattern="[0-9]*" class="form-control" name="VHU_id" id="VHU_id" required>`;
    } else {
        document.getElementById('VHU').innerHTML = ``;
    }
}

function sendDeclaration(formData) {
    if (formNode.checkValidity()) {
        let form = new FormData(formNode);
        form.set('contract', document.getElementById('contrat_sinistre').value);
        let files = document.getElementById("files").files;
        form.append("file", files[0], files[0].length);
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

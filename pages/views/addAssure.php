<?php include(get_path('partials','head.php'));?> 
<head>
    <title>Ajouter Assures</title>
    <script src="/static/js/manageDates.js" charset="utf-8"></script>
    <script src="/static/js/manageForms.js" charset="utf-8"></script>
</head>
<html>
    <body>
        <?php include(get_path('partials','navbar.php'));?> 
        <!-- MAIN (FORM) -->
        <div class="container-xl main">
            <div style="padding: 30px"></div>
            <h1 id="subtitle">Ajouter un assuré</h1>
            <table class="table" style="visibility: hidden" id="table">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mot de pass</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="nom"></td>
                        <td id="pen"></td>
                        <td id="log"></td>
                        <td id="mdp"></td>
                    </tr>
                </tbody>
            </table>
            <form method="POST" accept-charset="utf-8" id="form">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="inputSurname" class="form-label">Nom</label>
                        <input type="text" class="form-control"  value="" name="Surname" id="inputSurname" placeholder="François.." onkeyup="check(this, 'name', 'Format du nom incorrect')">
                    </div>
                    <div class="col-sm-6">
                        <label for="inputName" class="form-label">Prénom</label>
                        <input type="text" class="form-control"  value="" name="Name" id="inputName" placeholder="Dupont.." onkeyup="check(this, 'name', 'Format du prénom incorrect')">
                    </div>
                    <div class="col-sm-6">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control"  value="" name="Email" id="inputEmail" placeholder="francois@example.com" onkeyup="check(this, 'email', 'Adresse mail incorrecte')">
                    </div>
                    <div class="col-sm-6"<>
                        <label for="inputTelNumber" class="form-label">Numéro Téléphone (avec indicatif)</label>
                        <input type="number" class="form-control"  value="" name="telephoneNumber" id="inputTelNumber" onkeyup="check(this, 'phone', 'Format du numéro de téléphone incorrect.')">
                    </div>
                </div>
                <div style="padding: 8px"></div>
                <div class="col-sm-6">
                    <label for="inputBirthdate">Date de naissance</label>
                    <input type="date" name="birthdate" id="inputBirthdate" class="form-control" onclick="addMaxDate(this)">
                </div>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="inputAddress" class="form-label">Adresse (Rue, Ville)</label>
                        <input type="text" class="form-control" id="inputAddress" name="Address" placeholder="Address.." onkeyup="check(this, 'street', 'Adresse incorrecte')">
                    </div>
                    <div class="col-sm-6">
                        <label for="inputCodePostal" class="form-label">Code Postal</label>
                        <input type="number" class="form-control" id="inputCodePostal" name="CodePostal" onkeyup="check(this, 'zip', 'Mauvais code postal')">
                    </div>
                </div>
                <div id='errors' class='form-text is-invalid'></div>
                <div class="row g-3">
                    <div class="col-sm-6" style="margin-top: 30px">
                        <button disabled="true" onclick="addAssures()" type="button" class="btn btn-primary" name="signin" id="addbutton">Créer un compte</button>
                        <a type="submit" href="/gestionnaire" class="btn btn-primary" role="button" name="cancel">Annuler</a>
                    </div>
                </div>
            </form>
        </div>
        <!-- MAIN (FORM) -->
        <?php include(get_path('partials','footer.php'));?> 
    </body>
</html>

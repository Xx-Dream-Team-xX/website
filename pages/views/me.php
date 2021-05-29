<!DOCTYPE html>
<html>

<head>
    <?php include(get_path('partials','head.php'));?>
    <title>Mon compte</title>
    <script src="/static/js/manageDates.js" charset="utf-8"></script>
    <script src="/static/js/HeyThatsMe.js" charset="utf-8"></script>
    <script src="/static/js/me.js" charset="utf-8"></script>
</head>

<body onload="onLoad()">
    <?php include(get_path('partials','navbar.php'));?>
    <!-- MAIN (FORM) -->
    <div class="container-xl main">
        <div style="padding: 30px"></div>

        <form method="POST" accept-charset="utf-8" id="security">
            <h2 id="subtitle">Sécurité</h2>

            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="email" class="form-label">Adresse mail</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="mail">
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="password" class="form-label">Mot de passe actuel</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password">
                        <div class="input-group-text hover-overlay" style="cursor: pointer;" onclick="showPass('password')">
                            Afficher</div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="new_password" class="form-label">Nouveau mot de passe</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="new_password">
                        <div class="input-group-text hover-overlay" style="cursor: pointer;" onclick="showPass('new_password')">
                            Afficher</div>
                    </div>
                </div>
            </div>

            <div id='error' class='form-text is-invalid text-danger'></div>

            <div class="row g-3">
                <div class="col-sm-6" style="margin-top: 30px">
                    <a href="javascript:changeAccountData()" class="btn btn-primary" role="button">Mettre à jour</a>
                    <a href="javascript:logout()" class="btn btn-primary bg-danger" role="button">Déconnexion</a>

                </div>
            </div>

        </form>
        <div style="padding: 30px"></div>

        <?php if(getPermissions() === User::ASSURE) {?>

        <form method="POST" accept-charset="utf-8" id="details">

            <h2 id="subtitle">Informations personnelles</h2>

            <div class="row g-3 p-1">
                <div class="col-sm-6">
                    <label for="inputSurname" class="form-label">Nom</label>
                    <input type="text" class="form-control" value="" id="last_name" onkeyup="check(this, 'name', 'Format du nom incorrect')">
                </div>
                <div class="col-sm-6">
                    <label for="inputName" class="form-label">Prénom</label>
                    <input type="text" class="form-control" value="" id="first_name" placeholder="Dupont.." onkeyup="check(this, 'name', 'Format du prénom incorrect')">
                </div>

                <div class="col-sm-6">
                    <label for="inputTelNumber" class="form-label">Numéro Téléphone</label>
                    <input type="number" class="form-control" value="" id="phone" onkeyup="check(this, 'phone', 'Format du numéro de téléphone incorrect.')">
                </div>
    
                <div class="col-sm-6">
                    <label for="inputBirthdate" class="form-label">Date de naissance</label>
                    <input type="date" id="birth" class="form-control" onclick="addMaxDate(this)">
                </div>
            </div>
            
            <div class="row g-3 p-1">
                <div class="col-sm-6">
                    <label for="inputAddress" class="form-label">Adresse</label>
                    <input type="text" class="form-control" id="address" placeholder="Address.."
                        onkeyup="check(this, 'street', 'Adresse incorrecte')">
                </div>
                <div class="col-sm-6">
                    <label for="inputCodePostal" class="form-label">Code Postal</label>
                    <input type="number" class="form-control" id="zip_code" onkeyup="check(this, 'zip', 'Mauvais code postal')">
                </div>
            </div>
            <div style="padding: 30px"></div>
            <p class="p-3 mb-2 text-white bg-warning small">Veuillez attacher des pièces justificatives concernant le changement de vos coordonnées. Un gestionnaire de votre assurance prendra en charge votre demande et vous serez averti à la fin du processsus de vérification.</p>

            <div class="col">
                <label class="form-label" for="justification">Justifier les changements d'informations</label>
                <textarea type="file" class="form-control" id="justification" placeholder="(Optionnel mais Recommandé : soyez brefs et clairs, cela accélérera le processus de vérification)"></textarea>
            </div>

            <div class="row p-1">
                <div class="col-sm-6">
                    <label class="form-label" for="files">Choisir des justificatifs</label>
                    <input type="file" class="form-control" id="files" multiple>
                </div>
            </div>

            <div id='errors' class='form-text is-invalid text-danger'></div>

            
            <div class="row g-3">
                <div class="col-sm-6" style="margin-top: 30px">
                    <button onclick="submitVerification()" type="button" class="btn btn-primary" id="addbutton">Mettre à jour</button>
                </div>
            </div>
        </form>
        <?php }?>
        
    </div>

    <div style="padding: 30px"></div>

    <!-- MAIN (FORM) -->
    <?php include(get_path('partials','footer.php'));?>
</body>

</html>
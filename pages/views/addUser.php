<?php
    onlyFor(User::ADMIN);
?>

<!DOCTYPE html>
<html>
<head>
    <?php include(get_path('partials','head.php'));?>
    <title>Création de comptes</title>
    <script src="/static/js/manageDates.js" charset="utf-8"></script>
    <script src="/static/js/addUser.js" charset="utf-8"></script>
</head>
<body>
    <?php include(get_path('partials','navbar.php'));?>
    <!-- MAIN (FORM) -->
    <div class="container-xl main">
        <div style="padding: 10px"></div>
        <h1 id="subtitle">Créer un nouvel utilisateur privilégié</h1>

        <div id="results" hidden>
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="input-group">
                        <input onkeyup="document.getElementById('error').hidden = true;" type="text" class="form-control" id="new_mail" readonly>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="input-group">
                        <input onkeyup="document.getElementById('error').hidden = true;" type="password" class="form-control" id="new_password" readonly>
                        <div class="input-group-text hover-overlay" style="cursor: pointer;" onclick="showPass()">
                            Afficher</div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-sm-6" style="margin-top: 30px">
                    <a href="/admin" class="btn btn-primary" role="button">Fermer</a>
                </div>
            </div>
        </div>


        <form method="POST" accept-charset="utf-8" id="form">
            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="last_name" class="form-label">Nom</label>
                    <input onkeyup="document.getElementById('error').hidden = true;" type="text" class="form-control" id="last_name">
                </div>
                <div class="col-sm-6">
                    <label for="first_name" class="form-label">Prénom</label>
                    <input onkeyup="document.getElementById('error').hidden = true;" type="text" class="form-control" id="first_name">
                </div>
                <div class="col-sm-6">
                    <label for="email" class="form-label">Email</label>
                    <input onkeyup="document.getElementById('error').hidden = true;" type="email" class="form-control" id="mail">
                </div>
                <div class="col-sm-6">
                    <label for="phone" class="form-label">Numéro Téléphone (avec indicatif)</label>
                    <input onkeyup="document.getElementById('error').hidden = true;" type="number" class="form-control" id="phone">
                </div>
            </div>
            <div style="padding: 8px"></div>

            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="type">Choisir un type d'utilisateur</label>
                    <select class="form-control" id="type" onchange="updateType()">
                        <option value="2">Force de l'ordre</option>
                        <option value="3">Gestionnaire</option>
                    </select>
                </div>
                <div class="col-sm-6" hidden id="assurances">
                    <label for="assurance">Choisir une assurance</label>
                    <select class="form-control" id="assurance">

                    </select>
                </div>
            </div>

            <div id='error' class='form-text is-invalid text-danger' hidden>Veuillez vérifier les formats</div>

            <div class="row g-3">
                <div class="col-sm-6 mb-3" style="margin-top: 30px">
                    <button onclick="create()" type="button" class="btn btn-success" name="signin"
                        id="addbutton">Créer un compte</button>
                    <a href="/admin" class="btn btn-secondary" role="button">Annuler</a>
                </div>
            </div>
        </form>

    </div>
    <!-- MAIN (FORM) -->
    <?php include(get_path('partials','footer.php'));?>
</body>

</html>

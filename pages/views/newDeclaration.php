<?php onlyFor(User::ASSURE); ?>

<!DOCTYPE html>
<html>

    <head>
        <?php include get_path('partials', 'head.php'); ?>
        <script charset="utf-8" src="/static/js/HeyThatsMe.js"></script>
        <script charset="utf-8" src="/static/js/manageDates.js"></script>
        <script charset="utf-8" src="/static/js/newDeclaration.js"></script>
        <title>Déclaration de vente</title>
    </head>

    <body onload="onLoad()">
        <?php include get_path('partials', 'navbar.php'); ?>
        <!-- MAIN (FORM) -->
        <div class="container-xl main" id="main">
            <div class="row m-3 mt-0 center-block order border-2 rounded p-3 shadow">
                <form class="needs-validation" id="sinistre" action="javascript:;" onsubmit="return(sendDeclaration(this));" accept-charset="utf-8" novalidate>
                    <div class="row pb-3 g-3">
                        <div class="col-sm-12">
                            <label for="contrat" class="form-label">
                                <h4>Déclaration</h4>
                            </label>
                            <select class="form-select" aria-label="contrat" name="contract" id="contrat_sinistre" onchange="updateSinistre(this)" required>
                                <option value="" hidden selected>Selectionner un Contrat</option>
                            </select>
                        </div>
                    </div>
                    <div class="row pb-3 g-3">
                        <h5>Le véhicule</h5>
                        <div class="row g-3">
                            <div class="col-sm-9">
                                <p class="h6 mb-0 py-1 text-dark">Numéro d’identification du véhicule (VIN)</p>
                                <input type="text" pattern="[A-HJ-NPR-Z0-9]{17}" class="form-control p-1" placeholder="VFXXXXXXXXXXXXXXX" name="vUUID" id="vUUID" required>
                                <div class="invalid-feedback">
                                    VIN invalide.
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <p class="h6 mb-0 py-1 text-dark">Date de 1re immatriculation du véhicule</p>
                                <input type="date" class="form-control p-1" name="imaDate" id="imaDate" required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">Marque</p>
                                <input type="text" class="form-control p-1" name="manufacturer" id="manufacturer" required>
                            </div>
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">Type, variante, versio</p>
                                <input type="text" class="form-control p-1" name="car_var" id="car_var" required>
                            </div>
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">Genre national</p>
                                <input type="text" class="form-control p-1" name="car_country_var" id="car_country_var" required>
                            </div>
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">Dénomination commerciale</p>
                                <input type="text" class="form-control p-1" name="car_com_name" id="car_com_name" required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">Kilométrage</p>
                                <input type="number" class="form-control p-1" name="killometrage" id="killometrage" required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" value="0" name="ima_cert" id="ima_cert">
                                <input class="form-check-input" checked="true" type="checkbox" value="1" name="ima_cert" onchange="toggle_cert(this.checked)" id="ima_cert">
                                <label class="form-check-label" for="ima_cert">Présence du certificat d’immatriculation</label>
                            </div>
                            <div class="row border border-1 rounded g-3">
                                <div class="row p-3 g-3 mt-0" id="formule">
                                    <div class="col-sm-6 mt-0">
                                        <p class="h6 mt-0 text-dark">Numéro de formule</p>
                                        <input type="text" pattern="[0-9]{11}" placeholder="12345678901" class="form-control p-1" name="ima_cert_id" id="ima_cert_id" required>
                                        <div class="invalid-feedback">
                                            Numéro de formule invalide Doit contenir 11 chiffres.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5>Ancien propriétaire</h5>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <select class="form-select" aria-label="user" name="old_physical" id="old_physical" onchange="toggle_phys(this,'old_sexe_container')" required>
                                    <option value="1" selected>Personne physique</option>
                                    <option value="0">Personne morale</option>
                                </select>
                            </div>
                            <div class="col-sm-6" id="old_sexe_container">
                                <select class="form-select" aria-label="user" name="old_sex" id="old_sex" required>
                                    <option value="" disabled selected>Sexe</option>
                                    <option value="1">Homme</option>
                                    <option value="0">Femme</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-9">
                                <p class="h6 mb-0 py-1 text-dark">Je soussigné(e)</p>
                                <input type="text" class="form-control p-1" placeholder="NOM, NOM D’USAGE le cas échéant et PRÉNOM ou RAISON SOCIALE" name="old_lastname" id="old_lastname" required>
                            </div>
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">N° SIRET (optionel)</p>
                                <input type="text" pattern="[0-9]{14}" class="form-control p-1" name="old_lastname" id="old_lastname">
                                <div class="invalid-feedback">
                                    Doit faire 14 chiffres.
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="A_inputAddress" class="form-label">Adresse</label>
                                <input type="text" class="form-control" name="A_inputAddress" id="A_inputAddress" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="A_inputVille" class="form-label">Ville</label>
                                <input type="text" class="form-control" name="A_inputVille" id="A_inputVille" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="old_zip_code" class="form-label">Code Postal</label>
                                <input type="text" pattern="(?:0[1-9]|[13-8][0-9]|2[ab1-9]|9[0-5])(?:[0-9]{3})?|9[78][1-9](?:[0-9]{2})?" class="form-control" name="old_zip_code" id="old_zip_code" required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="for_destruction" class="form-label">Certifie</label>
                                <select class="form-select" aria-label="user" name="for_destruction" id="for_destruction" required>

                                    <option value="1">Céder</option>
                                    <option value="0">Céder pour destruction</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-0 g-3">
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" value="0" name="old_agree_1" id="old_agree_1">
                                <input class="form-check-input" type="checkbox" value="1" name="old_agree_1" id="old_agree_1">
                                <label class="form-check-label" for="old_agree_1">Avoir remis au nouveau propriétaire un certificat établi depuis moins de quinze jours par le ministre de l’Intérieur, attestant à sa date
                                    d’édition de la situation administrative du véhicule</label>
                            </div>
                        </div>
                        <div class="row mt-0 g-3">
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" value="0" name="old_agree_2" id="old_agree_2">
                                <input class="form-check-input" type="checkbox" value="1" name="old_agree_2" id="old_agree_2">
                                <label class="form-check-label" for="old_agree_2">Que ce véhicule n’a pas subi de transformation notable susceptible de modifier les indications du certificat de conformité ou de l’actuel
                                    certificat d’immatriculation</label>
                            </div>
                        </div>
                        <div class="row mt-0 g-3">
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="hidden" value="0" name="old_agree_destruction" id="old_agree_destruction">
                                    <input class="form-check-input" type="checkbox" value="1" name="old_agree_destruction" onchange="toggle_VHU(this.checked)" id="old_agree_destruction">
                                    <label class="form-check-label" for="old_agree_destruction">Que ce véhicule est cédé pour destruction à un professionnel de la destruction des véhicules hors d’usage (VHU)</label>
                                </div>
                            </div>
                            <div class="col-sm-3" id="VHU">
                            </div>
                        </div>
                        <h5>Nouveau propriétaire</h5>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <select class="form-select" aria-label="user" name="new_physical" id="new_physical" onchange="toggle_phys(this,'new_sexe_container')" required>
                                    <option value="1" selected>Personne physique</option>
                                    <option value="0">Personne morale</option>
                                </select>
                            </div>
                            <div class="col-sm-6" id="new_sexe_container">
                                <select class="form-select" aria-label="user" name="new_sex" id="new_sex" required>
                                    <option value="" disabled selected>Sexe</option>
                                    <option value="1">Homme</option>
                                    <option value="0">Femme</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-9">
                                <p class="h6 mb-0 py-1 text-dark">Je soussigné(e)</p>
                                <input type="text" class="form-control p-1" placeholder="NOM, NOM D’USAGE le cas échéant et PRÉNOM ou RAISON SOCIALE" name="new_lastname" id="new_lastname" required>
                            </div>
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">N° SIRET (optionel)</p>
                                <input type="text" pattern="[0-9]{14}" class="form-control p-1" name="new_SIRET" id="new_SIRET">
                                <div class="invalid-feedback">
                                    Doit faire 14 chiffres.
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">Date de naissance</p>
                                <input type="date" class="form-control p-1" name="birthdate" id="birthdate" required>
                            </div>
                            <div class="col-sm-9">
                                <p class="h6 mb-0 py-1 text-dark">Lieu de naissance</p>
                                <input type="text" class="form-control p-1" name="birth_place" id="birth_place" required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="A_inputAddress" class="form-label">Adresse</label>
                                <input type="text" class="form-control" name="B_inputAddress" id="B_inputAddress" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="A_inputVille" class="form-label">Ville</label>
                                <input type="text" class="form-control" name="B_inputVille" id="B_inputVille" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="old_zip_code" class="form-label">Code Postal</label>
                                <input type="text" pattern="(?:0[1-9]|[13-8][0-9]|2[ab1-9]|9[0-5])(?:[0-9]{3})?|9[78][1-9](?:[0-9]{2})?" class="form-control" name="new_zip_code" id="new_zip_code" required>
                            </div>
                        </div>
                        <div class="row mb-0 g-3">
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" value="0" name="new_agree_date" id="new_agree_date">
                                <input class="form-check-input" type="checkbox" value="1" name="new_agree_date" id="new_agree_date">
                                <label class="form-check-label" for="new_agree_date">Acquérir le véhicule désigné ci-dessus aux dates et heures indiquées par l’ancien propriétaire</label>
                            </div>
                        </div>
                        <div class="row mt-0 g-3">
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" value="0" name="new_agree_vState" id="new_agree_vState">
                                <input class="form-check-input" type="checkbox" value="1" name="new_agree_vState" id="new_agree_vState">
                                <label class="form-check-label" for="new_agree_vState">Avoir été informé de la situation administrative du véhicule.</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-1 pt-3">
                        <button type="submit" class="btn btn-success" id="addInjured" name="addInjured">Valider</button>
                    </div>
                </form>
            </div>

        </div>
        <!-- MAIN  -->
        <?php include get_path('partials', 'footer.php'); ?>
    </body>

</html>

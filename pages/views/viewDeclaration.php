<?php onlyForMin(User::ASSURE); ?>

<!DOCTYPE html>
<html>

    <head>
        <?php include get_path('partials', 'head.php'); ?>
        <script charset="utf-8" src="/static/js/HeyThatsMe.js"></script>
        <script charset="utf-8" src="/static/js/targetNavigation.js"></script>
        <script charset="utf-8" src="/static/js/manageDates.js"></script>
        <script charset="utf-8" src="/static/js/viewDeclaration.js"></script>
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
                            <select class="form-select" aria-label="contrat" name="contract" id="contrat_sinistre" onchange="querryDeclaration(this.value)" required>
                                <option hidden selected>Selectionner une Déclaration</option>
                            </select>
                        </div>
                    </div>
                    <div class="row pb-3 g-3">
                        <h5>Le véhicule</h5>
                        <div class="row g-3">
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">Numéro d’immatriculation</p>
                                <input type="text" class="form-control p-1" placeholder="AA123BB" name="vID" id="vID" disabled required>
                            </div>
                            <div class="col-sm-9">
                                <p class="h6 mb-0 py-1 text-dark">Numéro d’identification du véhicule (VIN)</p>
                                <input type="text" class="form-control p-1" placeholder="VFXXXXXXXXXXXXXXX" name="vUUID" id="vUUID" disabled required>
                            </div>
                            <div class="col-sm-6">
                                <p class="h6 mb-0 py-1 text-dark">Date de 1re immatriculation du véhicule</p>
                                <input type="date" class="form-control p-1" name="imaDate" id="imaDate" disabled required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">Marque</p>
                                <input type="text" class="form-control p-1" name="manufacturer" id="manufacturer" disabled required>
                            </div>
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">Type, variante, versio</p>
                                <input type="text" class="form-control p-1" name="car_var" id="car_var" disabled required>
                            </div>
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">Genre national</p>
                                <input type="text" class="form-control p-1" name="car_country_var" id="car_country_var" disabled required>
                            </div>
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">Dénomination commerciale</p>
                                <input type="text" class="form-control p-1" name="car_com_name" id="car_com_name" disabled required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">Kilométrage</p>
                                <input type="number" class="form-control p-1" name="killometrage" id="killometrage" disabled required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="ima_cert" id="ima_cert" disabled disabled>
                                <label class="form-check-label" for="ima_cert">Présence du certificat d’immatriculation</label>
                            </div>
                            <div class="row border border-1 rounded g-3">
                                <div class="row p-3 g-3 mt-0">
                                    <div class="col-sm-6 mt-0">
                                        <p class="h6 mt-0 text-dark">Numéro de formule</p>
                                        <input type="text" pattern="[0-9]{11}" class="form-control p-1" name="ima_cert_id" id="ima_cert_id" disabled>
                                    </div>
                                </div>
                                <div class="row p-3 g-3 mt-0">
                                    <p class="h6 mt-0 text-dark"> Motif d’absence de certificat d’immatriculation :</p>
                                    <textarea id="ima_missing_cert_desc" name="ima_missing_cert_desc" type="text" aria-describedby="button-addon2" class="form-control rounded border bg-light" disabled required></textarea>
                                </div>
                            </div>
                        </div>
                        <h5>Ancien propriétaire</h5>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <p class="h6 mb-0 py-1 text-dark">Personne physique</p>
                                <input type="text" class="form-control p-1" name="old_physical" id="old_physical" disabled required>
                            </div>
                            <div class="col-sm-6">
                                <p class="h6 mb-0 py-1 text-dark">Sexe</p>
                                <input type="text" class="form-control p-1" name="old_sex" id="old_sex" disabled required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-9">
                                <p class="h6 mb-0 py-1 text-dark">Je soussigné(e)</p>
                                <input type="text" class="form-control p-1" placeholder="NOM, NOM D’USAGE le cas échéant et PRÉNOM ou RAISON SOCIALE" name="old_lastname" id="old_lastname" disabled required>
                            </div>
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">N° SIRET (optionel)</p>
                                <input type="text" pattern="[0-9]{14}" class="form-control p-1" name="old_lastname" id="old_lastname" disabled required>
                                <div class="invalid-feedback">
                                    Doit faire 14 chiffres.
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-12">
                                <label for="A_inputAddress" class="form-label">Adresse</label>
                                <input type="text" class="form-control" name="old_address" id="old_address" disabled required>
                            </div>
                            <div class="col-sm-6">
                                <label for="old_zip_code" class="form-label">Code Postal</label>
                                <input type="text" pattern="(?:0[1-9]|[13-8][0-9]|2[ab1-9]|9[0-5])(?:[0-9]{3})?|9[78][1-9](?:[0-9]{2})?" class="form-control" name="old_zip_code" id="old_zip_code" disabled required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="for_destruction" id="for_destruction" disabled required>
                            </div>
                        </div>
                        <div class="row mb-0 g-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="old_agree_1" id="old_agree_1" disabled>
                                <label class="form-check-label" for="old_agree_1">Avoir remis au nouveau propriétaire un certificat établi depuis moins de quinze jours par le ministre de l’Intérieur, attestant à sa date
                                    d’édition de la situation administrative du véhicule</label>
                            </div>
                        </div>
                        <div class="row mt-0 g-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="old_agree_2" id="old_agree_2" disabled>
                                <label class="form-check-label" for="old_agree_2">Que ce véhicule n’a pas subi de transformation notable susceptible de modifier les indications du certificat de conformité ou de l’actuel
                                    certificat d’immatriculation</label>
                            </div>
                        </div>
                        <div class="row mt-0 g-3">
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="old_agree_destruction" id="old_agree_destruction" disabled>
                                    <label class="form-check-label" for="old_agree_destruction">Que ce véhicule est cédé pour destruction à un professionnel de la destruction des véhicules hors d’usage (VHU)</label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" placeholder="VHU" pattern="[0-9]*" class="form-control" name="VHU_id" id="VHU_id" disabled required>
                            </div>
                        </div>
                        <h5>Nouveau propriétaire</h5>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <p class="h6 mb-0 py-1 text-dark">Type de personne</p>
                                <input type="text" class="form-control p-1" name="new_physical" id="new_physical" disabled required>
                            </div>
                            <div class="col-sm-6">
                                <p class="h6 mb-0 py-1 text-dark">Sexe</p>
                                <input type="text" class="form-control p-1" name="new_sex" id="new_sex" disabled required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-9">
                                <p class="h6 mb-0 py-1 text-dark">Je soussigné(e)</p>
                                <input type="text" class="form-control p-1" placeholder="NOM, NOM D’USAGE le cas échéant et PRÉNOM ou RAISON SOCIALE" name="new_lastname" id="new_lastname" disabled required>
                            </div>
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">N° SIRET (optionel)</p>
                                <input type="text" pattern="[0-9]{14}" class="form-control p-1" name="new_SIRET" id="new_SIRET" disabled required>
                                <div class="invalid-feedback">
                                    Doit faire 14 chiffres.
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <p class="h6 mb-0 py-1 text-dark">Date de naissance</p>
                                <input type="date" class="form-control p-1" name="birthdate" id="birthdate" disabled required>
                            </div>
                            <div class="col-sm-9">
                                <p class="h6 mb-0 py-1 text-dark">Lieu de naissance</p>
                                <input type="text" class="form-control p-1" name="birth_place" id="birth_place" disabled required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-12">
                                <label for="A_inputAddress" class="form-label">Adresse</label>
                                <input type="text" class="form-control" name="new_address" id="new_address" disabled required>
                            </div>
                            <div class="col-sm-6">
                                <label for="old_zip_code" class="form-label">Code Postal</label>
                                <input type="text" class="form-control" name="new_zip_code" id="new_zip_code" disabled required>
                            </div>
                        </div>
                        <div class="row mb-0 g-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="new_agree_date" id="new_agree_date" disabled>
                                <label class="form-check-label" for="new_agree_date">Acquérir le véhicule désigné ci-dessus aux dates et heures indiquées par l’ancien propriétaire</label>
                            </div>
                        </div>
                        <div class="row mt-0 g-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="new_agree_vState" id="new_agree_vState" disabled>
                                <label class="form-check-label" for="new_agree_vState">Avoir été informé de la situation administrative du véhicule.</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <!-- MAIN  -->
        <?php include get_path('partials', 'footer.php'); ?>
    </body>

</html>

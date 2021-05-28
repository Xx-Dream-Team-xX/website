<?php include get_path('partials', 'head.php'); ?>
<!DOCTYPE html>
<html>

    <head>
        <script charset="utf-8" src="/static/js/HeyThatsMe.js"></script>
        <script charset="utf-8" src="/static/js/manageSinistre.js"></script>
        <title>Sinistres</title>
    </head>

    <body onload="onLoadSinistreList()">
        <?php include get_path('partials', 'navbar.php'); ?>
        <!-- MAIN (FORM) -->
        <div class="container-xl main" id="main">
            <div class="row m-3 mt-0 center-block order border-2 rounded p-3 shadow" id=sinistreMainContainer>
                <label for="contrat" class="form-label">
                    <h4>Sinistre</h4>
                </label>
                <select class="form-select" aria-label="contrat" name="contrat" id="sinistre_list" onchange="updateSinistre(this)" required>
                    <option hidden selected>Selectionner un Sinistre</option>
                </select>
                <h4 class="pt-3 pb-0 mb-0">Contract</h4>
                <div class="row g-3 border border-1 rounded p-3 pt-0">
                    <h5>Validité</h5>
                    <div class="row border border-1 rounded pb-3 g-3">
                        <div class="col-sm-6">
                            <p class="h6 mb-0 py-1 text-dark">Debut : <span class="h6" id="contrat_start"></span></p>
                        </div>
                        <div class="col-sm-6">
                            <p class="h6 mb-0 py-1 text-dark">Fin : <span class="h6" id="contrat_end"></span></p>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <p class="h5 mb-0 py-1 text-dark">Immatriculation : <span class="h6" id="contrat_vID"></span></p>
                        </div>
                        <div class="col-sm-6">
                            <p class="h5 mb-0 py-1 text-dark">Marque : <span class="h6" id="contrat_manufacturer"></span></p>
                        </div>
                    </div>
                </div>
                <h4 class="pt-3 pb-0 mb-0">Conducteur</h4>
                <div class="row g-3 border border-1 rounded p-3 pt-0">
                    <div class="row g-3 pb-3">
                        <div class="col-sm-6">
                            <p class="h5 mb-0 py-1 text-dark">Profession : <span class="h6" id="driver_profession"></span></p>
                        </div>
                        <div class="col-sm-6">
                            <p class="h5 mb-0 py-1 text-dark">Relation : <span class="h6" id="driver_relationship"></span></p>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <p class="h5 mb-0 py-1 text-dark">Motif de déplcament : <span class="h6" id="driver_disp_reason"></span></p>
                    </div>
                    <div class="row g-1 pt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="driver_user_same_residance" id="driver_user_same_residance" readonly disabled>
                            <label class="form-check-label" for="driver_user_same_residance">Même residance que le
                                propriétaire du contrat</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="driver_is_usual" id="driver_is_usual" readonly disabled>
                            <label class="form-check-label" for="driver_is_usual">Conducteur habituel du
                                véhicule</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="driver_is_employeeof_user" id="driver_is_employeeof_user" readonly disabled>
                            <label class="form-check-label" for="driver_is_employeeof_user">Employer du propriétaire
                                du contrat</label>
                        </div>
                    </div>
                </div>
                <h4 class="pt-3 pb-0 mb-0">Circonstances</h4>
                <div class="row g-3 border border-1 rounded p-3 pt-0 pb-3">
                    <div class="row g-3">
                        <p class="h5 mb-0 py-1 text-dark">Date : <span class="h6" id="driver_disp_reason"></span></p>
                    </div>
                    <div class="row g-3 ">
                        <p class="h5 mb-0 py-1 text-dark">Description :</p>
                        <p class="h6 mb-0 py-1 border border-1 rounded bg-light text-dark" id="circumstances">
                            <br>
                        </p>
                    </div>
                </div>
                <h4 class="pt-3 pb-0 mb-0">Procédures juridiques</h4>
                <div class="row g-3 border border-1 rounded p-3 pt-0">
                    <div class="row g-1 pt-3">
                        <div class="form-check">
                            <input class="form-check-input text-dark" type="checkbox" value="1" name="proces_verbal" id="proces_verbal" readonly disabled>
                            <label class="form-check-label text-dark" for="proces_verbal">Procès-verbal</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="police_report" id="police_report" readonly disabled>
                            <label class="form-check-label" for="police_report">Rapport de police</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="main_courante" id="main_courante" readonly disabled>
                            <label class="form-check-label" for="main_courante">Main-courante</label>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <p class="h6 mb-0 py-1 text-dark">Brigade ou commissariat : <span class="h6" id="driver_disp_reason"></span></p>
                    </div>
                </div>
                <h4 class="pt-3 pb-0 mb-0">Véhicle</h4>
                <div class="row g-3 border border-1 rounded p-3 pt-0">
                    <div class="row g-3">
                        <p class="h5 mb-0 py-1 text-dark">Lieu habituel de stationement : <span class="h6" id="usual_parking_location"></span></p>
                    </div>
                    <div class="row g-3" id="garage_container">
                        <h5 class="pt-0 pb-0 mb-0">Garage</h5>
                        <div class="row border border-1 rounded pb-3 g-3">
                            <div class="col-sm-6">
                                <p class="h6 mb-0 py-1 text-dark">Nom : <span class="h6" id="garage_name"></span></p>
                            </div>
                            <div class="col-sm-6">
                                <p class="h6 mb-0 py-1 text-dark">Téléphone : <span class="h6" id="garage_phone"></span></p>
                            </div>
                            <div class="col-sm-6">
                                <p class="h6 mb-0 py-1 text-dark">E-mail : <span class="h6" id="garage_email"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="pt-3 pb-0 mb-0">Autres dégâts matériels</h4>
                <div class="row g-3 ">
                    <p class="h6 mb-0 py-1 border border-1 rounded bg-light text-dark" id="circumstances">
                        <br>
                    </p>
                </div>
                <h4 class="pt-3 pb-0 mb-0">Constat</h4>
                <div class="row g-3 border border-1 rounded p-3 pt-0">
                    <div class="row g-3 ">
                        <p class="h6 mb-0 py-1 text-dark">Date : <span class="h6" id="garage_email"></span></p>
                    </div>
                    <div class="row g-3 ">
                        <p class="h6 mb-0 py-1 text-dark">Emplacement de l'incident : <span class="h6" id="location"></span></p>
                    </div>
                    <h5 class="pt-3 pb-0 mb-0">Temoins</h5>
                    <div class="row g-3 ">
                        <p class="h6 mb-0 py-1 border border-1 rounded bg-light text-dark" id="witnesses">
                            <br>
                        </p>
                    </div>
                </div>
            </div>
            <!-- MAIN  -->
            <?php include get_path('partials', 'footer.php'); ?>
    </body>

</html>

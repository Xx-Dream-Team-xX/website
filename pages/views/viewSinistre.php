<!DOCTYPE html>
<html>

    <head>
        <?php include get_path('partials', 'head.php'); ?>
        <script charset="utf-8" src="/static/js/HeyThatsMe.js"></script>
        <script charset="utf-8" src="/static/js/manageSinistre.js"></script>
        <title>Sinistres</title>
    </head>

    <body onload="onLoadSinistreList()">
        <?php include get_path('partials', 'navbar.php'); ?>
        <!-- MAIN (FORM) -->
        <div class="container-xl main" id="main">
            <div class="row m-3 mt-0 center-block order border-2 rounded p-3 shadow">
                <label for="contrat" class="form-label">
                    <h4>Sinistre</h4>
                </label>
                <select class="form-select" aria-label="contrat" name="id" id="contratList" onchange="updateSinistre(this)" required>
                    <option hidden selected>Selectionner un Sinistre</option>
                </select>
                <div class="row g-3 d-none" id="sinistreMainContainer">
                    <h4 class="pt-3 pb-0 mb-0">Contrat</h4>
                    <div class="row g-3 border border-1 rounded p-3 pt-0">
                        <h5>Validité</h5>
                        <div class="row border border-1 rounded pb-3 g-3">
                            <div class="col-sm-6">
                                <p class="h6 mb-0 py-1 text-dark">Debut : <span class="h6 text-dark" id="contrat_start"></span></p>
                            </div>
                            <div class="col-sm-6">
                                <p class="h6 mb-0 py-1 text-dark">Fin : <span class="h6 text-dark" id="contrat_end"></span></p>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <p class="h5 mb-0 py-1 text-dark">Immatriculation : <span class="h6 text-dark" id="contrat_vID"></span></p>
                            </div>
                            <div class="col-sm-6">
                                <p class="h5 mb-0 py-1 text-dark">Marque : <span class="h6 text-dark" id="contrat_manufacturer"></span></p>
                            </div>
                        </div>
                    </div>
                    <h4 class="pt-3 pb-0 mb-0">Conducteur</h4>
                    <div class="row g-3 border border-1 rounded p-3 pt-0">
                        <div class="row g-3 pb-3">
                            <div class="col-sm-6">
                                <p class="h5 mb-0 py-1 text-dark">Profession : <span class="h6 text-dark" id="driver_profession"></span></p>
                            </div>
                            <div class="col-sm-6">
                                <p class="h5 mb-0 py-1 text-dark">Relation : <span class="h6 text-dark" id="driver_relationship"></span></p>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <p class="h5 mb-0 py-1 text-dark">Motif de déplacement : <span class="h6 text-dark" id="driver_disp_reason"></span></p>
                        </div>
                        <div class="row g-1 pt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="driver_user_same_residance" id="driver_user_same_residance" readonly disabled>
                                <label class="form-check-label" for="driver_user_same_residance">Même residence que le
                                    propriétaire du contrat</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="driver_is_usual" id="driver_is_usual" readonly disabled>
                                <label class="form-check-label" for="driver_is_usual">Conducteur habituel du
                                    véhicule</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="driver_is_employeeof_user" id="driver_is_employeeof_user" readonly disabled>
                                <label class="form-check-label" for="driver_is_employeeof_user">Employé du propriétaire
                                    du contrat</label>
                            </div>
                        </div>
                    </div>
                    <h4 class="pt-3 pb-0 mb-0">Circonstances</h4>
                    <div class="row g-3 border border-1 rounded p-3 pt-0 pb-3">
                        <div class="row g-3">
                            <p class="h5 mb-0 py-1 text-dark">Date : <span class="h6 text-dark" id="incident_date"></span></p>
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
                        <div class="row g-3 pb-3 d-none" id="police_stationContainer">
                            <p class="h6 mb-0 py-1 text-dark">Brigade ou commissariat : <span class="h6 text-dark" id="police_station"></span></p>
                        </div>
                    </div>
                    <h4 class="pt-3 pb-0 mb-0">Véhicle</h4>
                    <div class="row g-3 border border-1 rounded p-3 pt-0">
                        <div class="row g-3">
                            <p class="h5 mb-0 py-1 text-dark">Lieu habituel de stationnement : <span class="h6 text-dark" id="usual_parking_location"></span></p>
                        </div>
                        <div class="row g-3 d-none" id="garage_container">
                            <h5 class="pt-0 pb-0 mb-0">Garage</h5>
                            <div class="row border border-1 rounded pb-3 g-3">
                                <div class="col-sm-6">
                                    <p class="h6 mb-0 py-1 text-dark">Nom : <span class="h6 text-dark" id="garage_name"></span></p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="h6 mb-0 py-1 text-dark">Téléphone : <span class="h6 text-dark" id="garage_phone"></span></p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="h6 mb-0 py-1 text-dark">E-mail : <span class="h6 text-dark" id="garage_email"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="pt-3 pb-0 mb-0">Autres dégâts matériels</h4>
                    <div class="row g-3 ">
                        <p class="h6 mb-0 py-1 border border-1 rounded bg-light text-dark" id="other_damage">
                            <br>
                        </p>
                    </div>
                    <h6>Justificatifs fournis</h6>
                    <ul id="documents">
                        <!-- html pour l'affichage -->
                    </ul>
                    <div class="row mt-2 d-none" id="injured_container">
                        <h4 class="pt-3 pb-0 mb-0">Blessés</h4>
                        <div class="row g-3 border border-1 rounded p-3 pt-0" id="injured_list">
                        </div>
                    </div>
                    <div class="row mt-2 d-none" id="constat_container">
                        <h4 class="pt-3 pb-0 mb-0">Constat</h4>
                        <div class="row g-3 border border-1 rounded p-3 pt-0">
                            <div class="row g-3 ">
                                <p class="h6 mb-0 py-1 text-dark">Date : <span class="h6 text-dark" id="constat_date"></span></p>
                            </div>
                            <div class="row g-3 ">
                                <p class="h6 mb-0 py-1 text-dark">Emplacement de l'incident : <span class="h6 text-dark" id="location"></span></p>
                            </div>
                            <h5 class="pt-3 pb-0 mb-0">Témoins</h5>
                            <div class="row g-3 ">
                                <p class="h6 mb-0 py-1 border border-1 rounded bg-light text-dark" id="witnesses">
                                    <br>
                                </p>
                            </div>
                            <div class="row g-1 pt-3">
                                <div class="form-check">
                                    <input class="form-check-input text-dark" type="checkbox" value="1" name="injured" id="injured" readonly disabled>
                                    <label class="form-check-label text-dark" for="injured">Blessés</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="other_vehicle_involved" id="other_vehicle_involved" readonly disabled>
                                    <label class="form-check-label" for="other_vehicle_involved">Autres
                                        véhicules</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="other_object_involved" id="other_object_involved" readonly disabled>
                                    <label class="form-check-label" for="other_object_involved">Autres Objets</label>
                                </div>
                            </div>
                            <h4 class="pt-1 pb-0 mb-0">Véhicle A</h4>
                            <div class="row g-3 border border-1 rounded p-3 pt-0">
                                <div class="row g-3">
                                    <p class="h6 mb-0 py-1 text-dark">N° de contrat : <span class="h6 text-dark" id="A_contract"></span></p>
                                </div>
                                <h4 class="pt-1 pb-0 mb-0">Conducteur</h4>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Nom : <span class="h6 text-dark" id="A_driver_lastname"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Prénom : <span class="h6 text-dark" id="A_driver_firstname"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Date de naissance : <span class="h6 text-dark" id="A_driver_birthdate"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Adresse : <span class="h6 text-dark" id="A_driver_address"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Pays : <span class="h6 text-dark" id="A_driver_country"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Téléphone : <span class="h6 text-dark" id="A_driver_phone"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">E-mail : <span class="h6 text-dark" id="A_dirver_email"></span></p>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">N° Permis de conduire : <span class="h6 text-dark" id="A_driver_liscence_id"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Catégorie du permis : <span class="h6 text-dark" id="A_driver_liscence_cat"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Fin de validité du permis : <span class="h6 text-dark" id="A_driver_liscence_expire"></span></p>
                                    </div>
                                </div>
                                <h4 class="pt-1 pb-0 mb-0">Véhicule</h4>
                                <div class="row g-3">
                                    <p class="h6 mb-0 py-1 text-dark">Impact initial sur le véhicule : <span class="h6 text-dark" id="A_vehicle_initial_impact"></span></p>
                                </div>
                                <div class="row g-3 ">
                                    <h5 class="pb-0 mb-0">Dommages sur le véhicule</h5>
                                    <p class="h6 mb-0 py-1 border border-1 rounded bg-light text-dark" id="A_vehicle_damage">
                                        <br>
                                    </p>
                                </div>
                                <div class="row g-3 ">
                                    <h4 class="pb-0 mb-0">Observations supplementaires</h4>
                                    <p class="h6 mb-0 py-1 border border-1 rounded bg-light text-dark" id="A_observation">
                                        <br>
                                    </p>
                                </div>
                                <div class="row g-1 pt-3">
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_stationing" id="A_stationing" readonly disabled>
                                            <label class="form-check-label" for="A_stationing">En stationnement / à
                                                l'arrêt</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_leaving_parking_spot" id="A_leaving_parking_spot" readonly disabled>
                                            <label class="form-check-label" for="A_leaving_parking_spot">Quittait un
                                                stationnement</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_entering_parking_spot" id="A_entering_parking_spot" readonly disabled>
                                            <label class="form-check-label" for="A_entering_parking_spot">Prenait un
                                                stationement</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_entering_place" id="A_entering_place" readonly disabled>
                                            <label class="form-check-label" for="A_entering_place">Entrait dans un
                                                parking, lieu privé, chemin de terre</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_leaving_place" id="A_leaving_place" readonly disabled>
                                            <label class="form-check-label" for="A_leaving_place">Sortait d'un parking,
                                                lieu privé, chemin de terre</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_round_point" id="A_round_point" readonly disabled>
                                            <label class="form-check-label" for="A_round_point">S'engageait sur un
                                                giratoire</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_rear_damage_on_road" id="A_rear_damage_on_road" readonly disabled>
                                            <label class="form-check-label" for="A_rear_damage_on_road">Heurtait à
                                                l'arrière en roulant dans le même sens et sur la même file</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_oposite_road_line" id="A_oposite_road_line" readonly disabled>
                                            <label class="form-check-label" for="A_oposite_road_line">Roulait dans le
                                                même sens et sur une file différente</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_line_change" id="A_line_change" readonly disabled>
                                            <label class="form-check-label" for="A_line_change">Changeait de
                                                file</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_overtake" id="A_overtake" readonly disabled>
                                            <label class="form-check-label" for="A_overtake">Doublait</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_right_turn" id="A_right_turn" readonly disabled>
                                            <label class="form-check-label" for="A_right_turn">Virait à droite</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_left_turn" id="A_left_turn" readonly disabled>
                                            <label class="form-check-label" for="A_left_turn">Virait à gauche</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_driving_backward" id="A_driving_backward" readonly disabled>
                                            <label class="form-check-label" for="A_driving_backward">Reculait</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_past_line" id="A_past_line" readonly disabled>
                                            <label class="form-check-label" for="A_past_line">Empiétait sur une voie
                                                réservée à la circulation en sens inverse</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_from_right" id="A_from_right" readonly disabled>
                                            <label class="form-check-label" for="A_from_right">Venait de droite</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="A_skip_priority" id="A_skip_priority" readonly disabled>
                                            <label class="form-check-label" for="A_from_right">N'a pas respecté la
                                                priorité ou un feu rouge</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="pt-1 pb-0 mb-0">Véhicle B</h4>
                            <div class="row g-3 border border-1 rounded p-3 pt-0">
                                <div class="row g-3">
                                    <p class="h6 mb-0 py-1 text-dark">N° de contrat : <span class="h6 text-dark" id="B_contract"></span></p>
                                </div>
                                <h4 class="pt-1 pb-0 mb-0">Conducteur</h4>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Nom : <span class="h6 text-dark" id="B_driver_lastname"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Prénom : <span class="h6 text-dark" id="B_driver_firstname"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Date de naissance : <span class="h6 text-dark" id="B_driver_birthdate"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Adresse : <span class="h6 text-dark" id="B_driver_address"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Pays : <span class="h6 text-dark" id="B_driver_country"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Téléphone : <span class="h6 text-dark" id="B_driver_phone"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">E-mail : <span class="h6 text-dark" id="B_dirver_email"></span></p>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">N° Permis de conduire : <span class="h6 text-dark" id="B_driver_liscence_id"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Catégorie du permis : <span class="h6 text-dark" id="B_driver_liscence_cat"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="h6 mb-0 py-1 text-dark">Fin de validité du permis : <span class="h6 text-dark" id="B_driver_liscence_expire"></span></p>
                                    </div>
                                </div>
                                <h4 class="pt-1 pb-0 mb-0">Véhicule</h4>
                                <div class="row g-3">
                                    <p class="h6 mb-0 py-1 text-dark">Impact initial sur le véhicule : <span class="h6 text-dark" id="B_vehicle_initial_impact"></span></p>
                                </div>
                                <div class="row g-3 ">
                                    <h5 class="pb-0 mb-0">Dommages sur le véhicule</h5>
                                    <p class="h6 mb-0 py-1 border border-1 rounded bg-light text-dark" id="B_vehicle_damage">
                                        <br>
                                    </p>
                                </div>
                                <div class="row g-3 ">
                                    <h4 class="pb-0 mb-0">Observations supplémentaires</h4>
                                    <p class="h6 mb-0 py-1 border border-1 rounded bg-light text-dark" id="B_observation">
                                        <br>
                                    </p>
                                </div>
                                <div class="row g-1 pt-3">
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_stationing" id="B_stationing" readonly disabled>
                                            <label class="form-check-label" for="B_stationing">En stationnement / à
                                                l'arrêt</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_leaving_parking_spot" id="B_leaving_parking_spot" readonly disabled>
                                            <label class="form-check-label" for="B_leaving_parking_spot">Quittait un
                                                stationnement</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_entering_parking_spot" id="B_entering_parking_spot" readonly disabled>
                                            <label class="form-check-label" for="B_entering_parking_spot">Prenait un
                                                stationnement</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_entering_place" id="B_entering_place" readonly disabled>
                                            <label class="form-check-label" for="B_entering_place">Entrait dans un
                                                parking, lieu privé, chemin de terre</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_leaving_place" id="B_leaving_place" readonly disabled>
                                            <label class="form-check-label" for="B_leaving_place">Sortait d'un parking,
                                                lieu privé, chemin de terre</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_round_point" id="B_round_point" readonly disabled>
                                            <label class="form-check-label" for="B_round_point">S'engageait sur un
                                                giratoire</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_rear_damage_on_road" id="B_rear_damage_on_road" readonly disabled>
                                            <label class="form-check-label" for="B_rear_damage_on_road">Heurtait à
                                                l'arrière en roulant dans le même sens et sur la même file</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_oposite_road_line" id="B_oposite_road_line" readonly disabled>
                                            <label class="form-check-label" for="B_oposite_road_line">Roulait dans le
                                                même sens et sur une file différente</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_line_change" id="B_line_change" readonly disabled>
                                            <label class="form-check-label" for="B_line_change">Changeait de
                                                file</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_overtake" id="B_overtake" readonly disabled>
                                            <label class="form-check-label" for="B_overtake">Doublait</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_right_turn" id="B_right_turn" readonly disabled>
                                            <label class="form-check-label" for="B_right_turn">Virait à droite</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_left_turn" id="B_left_turn" readonly disabled>
                                            <label class="form-check-label" for="B_left_turn">Virait à gauche</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_driving_backward" id="B_driving_backward" readonly disabled>
                                            <label class="form-check-label" for="B_driving_backward">Reculait</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_past_line" id="B_past_line" readonly disabled>
                                            <label class="form-check-label" for="B_past_line">Empiétait sur une voie
                                                réservée à la circulation en sens inverse</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_from_right" id="B_from_right" readonly disabled>
                                            <label class="form-check-label" for="B_from_right">Venait de droite</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="B_skip_priority" id="B_skip_priority" readonly disabled>
                                            <label class="form-check-label" for="B_from_right">N'a pas respecté la
                                                priorité ou un feu rouge</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MAIN  -->
        <?php include get_path('partials', 'footer.php'); ?>
    </body>

</html>

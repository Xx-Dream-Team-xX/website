<?php onlyFor(User::ASSURE); ?>

<!DOCTYPE html>
<html>

    <head>
        <?php include get_path('partials', 'head.php'); ?>
        <script charset="utf-8" src="/static/js/HeyThatsMe.js"></script>
        <script charset="utf-8" src="/static/js/manageSinistre.js"></script>
        <title>Déclarer un sinistre</title>
    </head>

    <body onload="onLoad()">
        <?php include get_path('partials', 'navbar.php'); ?>
        <!-- MAIN (FORM) -->
        <div class="container-xl main ">
            <div class="row m-0 mt-0 center-block order border-2 rounded p-3 shadow">
                <h1>Sinistre</h1>
                <form class="needs-validation" id="sinistre" action="javascript:;" onsubmit="sendSinistre(this);" accept-charset="utf-8" novalidate>
                    <div class="row g-3 border border-1 rounded p-3 mt-3">
                        <label for="contrat" class="form-label">
                            <h4>Contrat</h4>
                        </label>
                        <select class="form-select" aria-label="contrat" name="contrat" id="contrat_sinistre" required>
                            <option hidden selected>Sélectionner un contrat</option>
                        </select>
                    </div>
                    <div class="row g-3 border border-1 rounded p-3 mt-3">
                        <h4>Conducteur</h4>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="driver_profession" class="form-label">Profession</label>
                                <input type="text" class="form-control" name="driver_profession" id="driver_profession" required>
                                <div class="invalid-feedback">
                                    Veuillez spécifier une profession.
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="driver_relationship" class="form-label">Relation</label>
                                <select class="form-select" aria-label="driver relationship" name="driver_relationship" id="driver_relationship" required>
                                    <option value="celib">Célibataire</option>
                                    <option value="married">Marié</option>
                                    <option value="other">Autre</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-1 pt-3">
                            <label for="driver_disp_reason" class="form-label">Motif de déplcament</label>
                            <input type="text" class="form-control" name="driver_disp_reason" id="driver_disp_reason" required>
                            <div class="invalid-feedback">
                                Veuillez entrer un motif de déplacement.
                            </div>
                        </div>
                        <div class="row g-1 pt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" value="0" name="driver_user_same_residance" id="driver_user_same_residance">
                                <input class="form-check-input" type="checkbox" value="1" name="driver_user_same_residance" id="driver_user_same_residance">
                                <label class="form-check-label" for="driver_user_same_residance">Même résidence que le
                                    propriétaire du contrat</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" value="0" name="driver_is_usual" id="driver_is_usual">
                                <input class="form-check-input" type="checkbox" value="1" name="driver_is_usual" id="driver_is_usual">
                                <label class="form-check-label" for="driver_is_usual">Conducteur habituel du
                                    véhicule</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" value="0" name="driver_is_employeeof_user" id="driver_is_employeeof_user">
                                <input class="form-check-input" type="checkbox" value="1" name="driver_is_employeeof_user" id="driver_is_employeeof_user">
                                <label class="form-check-label" for="driver_is_employeeof_user">Employé du propriétaire
                                    du contrat</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 border border-1 rounded p-3 mt-3">
                        <h4>Circonstances de l'accident</h4>
                        <div class="row g-1 pt-3">
                            <label for="date" class="form-label">Date de l'accident</label>
                            <input type="date" class="form-control" name="date" id="date" required>
                            <div class="invalid-feedback">
                                Veuillez specifier une date.
                            </div>
                        </div>
                        <div class="row g-1 pt-3">
                            <label for="circumstances" class="form-label">Description</label>
                            <textarea id="circumstances" name="circumstances" type="text" placeholder="" aria-describedby="button-addon2" class="form-control rounded border bg-light" required></textarea>
                            <div class="invalid-feedback">
                                Veuillez remplir les circonstances.
                            </div>
                        </div>

                    </div>
                    <div class="row g-3 border border-1 rounded p-3 mt-3">
                        <h4>Procédures juridiques</h4>
                        <div class="row g-1 pt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" value="0" name="proces_verbal" id="proces_verbal">
                                <input class="form-check-input" type="checkbox" value="1" name="proces_verbal" id="proces_verbal">
                                <label class="form-check-label" for="proces_verbal">Procès-verbal</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" value="0" name="police_report" id="police_report">
                                <input class="form-check-input" type="checkbox" value="1" name="police_report" id="police_report">
                                <label class="form-check-label" for="police_report">Rapport de police</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" value="0" name="main_courante" id="main_courante">
                                <input class="form-check-input" type="checkbox" value="1" name="main_courante" id="main_courante" onchange="togglePoliceStation(this);">
                                <label class="form-check-label" for="main_courante">Main-courante</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 border border-1 rounded p-3 mt-3">
                        <h4>Véhicule</h4>
                        <div class="row g-1 pt-3">
                            <label for="usual_parking_location" class="form-label">Lieu habituel de stationement</label>
                            <input type="text" class="form-control" name="usual_parking_location" id="usual_parking_location" required>
                            <div class="invalid-feedback">
                                Veuillez entrer le lieu habituel de garage du stationement.
                            </div>
                        </div>
                        <div class="row g-3 p-3 pt-1">
                            <h5>Garage</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="police_report" onchange="toggleGarage(this)">
                                <label class="form-check-label" for="police_report">Véhicule envoyé dans un garage</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 border border-1 rounded p-3 mt-3">
                        <h4>Autres dégâts matériels</h4>
                        <textarea id="other_damage" name="other_damage" type="text" placeholder="Description des dégâts" aria-describedby="button-addon2" class="form-control rounded border bg-light"></textarea>
                    </div>
                    <div class="row g-3 border border-1 rounded p-3 mt-3">
                        <div class="col-sm-6">
                            <label class="form-label" for="files">Choisir des photos (optionnel)</label>
                            <input type="file" class="form-control" id="files" multiple>
                        </div>
                    </div>
                    <div class="row g-3 pt-1 p-3 mt-3">
                        <button type="submit" class="btn btn-success" id="submitSinistre" name="submitSinistre">Valider</button>
                    </div>
                </form>
            </div>
            <div class="row m-3 mt-0 order border-2 rounded p-3 shadow d-none" id="injureds">
                <h2>Blessés</h2>
                <div class="row g-3 pt-1 p-3 mt-3">
                    <button type="submit" class="btn btn-success" id="addInjured" name="addInjured" onclick="addInjured(this)">Ajouter un blessé</button>
                    <button type="submit" class="btn btn-success" id="addInjured" name="addInjured" onclick="sendInjureds(this)">Valider</button>
                </div>
            </div>
            <div class="row m-3 mt-0 order border-2 rounded p-3 shadow d-none" id="constat">
                <h1>Constat</h1>
                <div class="row g-3 border border-1 rounded p-3 mt-3 d-none" id="constatContainer">
                    <form class="needs-validation" accept-charset="utf-8" novalidate action="javascript:;" onsubmit="sendConstat(this);" accept-charset="utf-8">
                        <div class="row g-3 pt-3">
                            <label for="date" class="form-label">
                                <h5>Date de l'incident</h5>
                            </label>
                            <input class="form-control" type="date" value="" name="date" id="date" required>
                        </div>
                        <div class="row g-3 pt-3">
                            <label for="date" class="form-label">
                                <h5>Emplacement de l'incident</h5>
                            </label>
                            <input class="form-control" type="text" value="" name="location" id="location" required>
                        </div>
                        <div class="row g-3 pt-3">
                            <label for="date" class="form-label">
                                <h5>Témoins</h5>
                            </label>
                            <textarea id="witnesses" name="witnesses" type="text" placeholder="Liste des blessures" aria-describedby="button-addon2" class="form-control rounded border bg-light"></textarea>
                        </div>
                        <div class="row g-3 pt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" value="0" name="injured" id="injured">
                                <input class="form-check-input" type="checkbox" value="1" name="injured" id="injured">
                                <label class="form-check-label" for="injured">Blessés</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" value="0" name="other_vehicle_involved" id="other_vehicle_involved">
                                <input class="form-check-input" type="checkbox" value="1" name="other_vehicle_involved" id="other_vehicle_involved">
                                <label class="form-check-label" for="other_vehicle_involved">Autres véhicules</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" value="0" name="other_object_involved" id="other_object_involved">
                                <input class="form-check-input" type="checkbox" value="1" name="other_object_involved" id="other_object_involved">
                                <label class="form-check-label" for="other_object_involved">Autres Objets</label>
                            </div>
                        </div>
                        <div class="row g-3 border border-1 rounded p-3 mt-3">
                            <h4>Véhicule A</h4>
                            <div class="row g-3">
                                <label for="A_contract" class="form-label">
                                    <h5>N° de contrat</h5>
                                </label>
                                <input class="form-control" type="text" value="" name="A_contract" id="A_contract" required>
                            </div>

                            <div class="row g-3 pt-3">
                                <h5>Conducteur</h5>
                                <div class="col-sm-6">
                                    <label for="A_driver_lastname" class="form-label">Nom</label>
                                    <input type="text" class="form-control" name="A_driver_lastname" id="A_driver_lastname" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="A_driver_firstname" class="form-label">Prénom</label>
                                    <input type="text" class="form-control" name="A_driver_firstname" id="A_driver_firstname" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="A_driver_birthdate" class="form-label">Date de naissance</label>
                                    <input type="date" class="form-control" name="A_driver_birthdate" id="A_driver_birthdate" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="A_inputAddress" class="form-label">Adresse</label>
                                    <input type="text" class="form-control" name="A_inputAddress" id="A_inputAddress" placeholder="Address.." required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="A_inputVille" class="form-label">Ville</label>
                                    <input type="text" class="form-control" name="A_inputVille" id="A_inputVille" placeholder="Ville" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="A_driver_zipcode" class="form-label">Code Postal</label>
                                    <input type="text" pattern="/(?:0[1-9]|[13-8][0-9]|2[ab1-9]|9[0-5])(?:[0-9]{3})?|9[78][1-9](?:[0-9]{2})?/" class="form-control" name="A_driver_zipcode" id="A_driver_zipcode" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="A_driver_country" class="form-label">Pays</label>
                                    <input type="text" class="form-control" name="A_driver_country" value="FR" id="A_driver_country" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="A_driver_phone" class="form-label">Téléphone</label>
                                    <input type="phone" class="form-control" name="A_driver_phone" id="A_driver_phone" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="A_dirver_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="A_dirver_email" id="A_dirver_email" required>
                                </div>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="A_driver_liscence_id" class="form-label">N° Permis de
                                            conduire</label>
                                        <input type="text" class="form-control" name="A_driver_liscence_id" id="A_driver_liscence_id" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="A_driver_liscence_cat" class="form-label">Catégorie du
                                            permis</label>
                                        <select class="form-select" aria-label="user" name="A_driver_liscence_cat" id="A_driver_liscence_cat" required>
                                            <option hidden selected>Sélectionner une categorie</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                            <option value="F">F</option>
                                            <option value="G">G</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="A_driver_liscence_expire" class="form-label">Fin de validité du
                                            permis</label>
                                        <input type="date" class="form-control" name="A_driver_liscence_expire" id="A_driver_liscence_expire" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3  pt-3">
                                <label for="date" class="form-label">
                                    <h5>Véhicule</h5>
                                </label>
                                <div class="row g-1">
                                    <label for="A_vehicle_initial_impact" class="form-label">Impact initial
                                        sur le véhicule</label>
                                    <input type="text" class="form-control" name="A_vehicle_initial_impact" id="A_vehicle_initial_impact" required>
                                </div>
                                <div class="row g-1">
                                    <label for="A_vehicle_damage" class="form-label">Dommages sur le
                                        véhicule</label>
                                    <textarea id="A_vehicle_damage" name="A_vehicle_damage" type="text" aria-describedby="button-addon2" class="form-control rounded border bg-light" required></textarea>
                                </div>
                            </div>
                            <div class="row g-3">
                                <label for="A_observation" class="form-label">
                                    <h5>Observations supplémentaires</h5>
                                </label>
                                <textarea id="A_observation" name="A_observation" type="text" aria-describedby="button-addon2" class="form-control rounded border bg-light"></textarea>
                            </div>
                            <div class="row g-1 pt-3">
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_stationing" id="A_stationing">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_stationing" id="A_stationing">
                                        <label class="form-check-label" for="A_stationing">En stationnement / à l'arrêt</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_leaving_parking_spot" id="A_leaving_parking_spot">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_leaving_parking_spot" id="A_leaving_parking_spot">
                                        <label class="form-check-label" for="A_leaving_parking_spot">Quittait un stationnement</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_entering_parking_spot" id="A_entering_parking_spot">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_entering_parking_spot" id="A_entering_parking_spot">
                                        <label class="form-check-label" for="A_entering_parking_spot">Prenait un stationnement</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_entering_place" id="A_entering_place">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_entering_place" id="A_entering_place">
                                        <label class="form-check-label" for="A_entering_place">Entrait dans un parking, lieu privé, chemin de terre</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_leaving_place" id="A_leaving_place">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_leaving_place" id="A_leaving_place">
                                        <label class="form-check-label" for="A_leaving_place">Sortait d'un parking, lieu privé, chemin de terre</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_round_point" id="A_round_point">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_round_point" id="A_round_point">
                                        <label class="form-check-label" for="A_round_point">S'engageait sur un giratoire</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_rear_damage_on_road" id="A_rear_damage_on_road">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_rear_damage_on_road" id="A_rear_damage_on_road">
                                        <label class="form-check-label" for="A_rear_damage_on_road">Heurtait à l'arrière en roulant dans le même sens et sur la même file</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_oposite_road_line" id="A_oposite_road_line">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_oposite_road_line" id="A_oposite_road_line">
                                        <label class="form-check-label" for="A_oposite_road_line">Roulait dans le même sens et sur une file différente</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_line_change" id="A_line_change">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_line_change" id="A_line_change">
                                        <label class="form-check-label" for="A_line_change">Changeait de file</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_overtake" id="A_overtake">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_overtake" id="A_overtake">
                                        <label class="form-check-label" for="A_overtake">Doublait</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_right_turn" id="A_right_turn">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_right_turn" id="A_right_turn">
                                        <label class="form-check-label" for="A_right_turn">Virait à droite</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_left_turn" id="A_left_turn">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_left_turn" id="A_left_turn">
                                        <label class="form-check-label" for="A_left_turn">Virait à gauche</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_driving_backward" id="A_driving_backward">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_driving_backward" id="A_driving_backward">
                                        <label class="form-check-label" for="A_driving_backward">Reculait</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_past_line" id="A_past_line">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_past_line" id="A_past_line">
                                        <label class="form-check-label" for="A_past_line">Empiétait sur une voie réservée à la circulation en sens inverse</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_from_right" id="A_from_right">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_from_right" id="A_from_right">
                                        <label class="form-check-label" for="A_from_right">Venait de droite</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="A_skip_priority" id="A_skip_priority">
                                        <input class="form-check-input" type="checkbox" value="1" name="A_skip_priority" id="A_skip_priority">
                                        <label class="form-check-label" for="A_from_right">N'a pas respecté la priorité ou un feu rouge</label>
                                    </div>
                                </div>
                            </div>
                            <h4>Véhicle B</h4>
                            <div class="row g-3">
                                <label for="B_contract" class="form-label">
                                    <h5>N° de contrat</h5>
                                </label>
                                <input class="form-control" type="text" value="" name="B_contract" id="B_contract">
                            </div>

                            <div class="row g-3 pt-3">
                                <h5>Conducteur</h5>
                                <div class="col-sm-6">
                                    <label for="B_driver_lastname" class="form-label">Nom</label>
                                    <input type="text" class="form-control" name="B_driver_lastname" id="B_driver_lastname" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="B_driver_firstname" class="form-label">Prénom</label>
                                    <input type="text" class="form-control" name="B_driver_firstname" id="B_driver_firstname" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="B_driver_birthdate" class="form-label">Date de naissance</label>
                                    <input type="date" class="form-control" name="B_driver_birthdate" id="B_driver_birthdate" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="B_inputAddress" class="form-label">Adresse</label>
                                    <input type="text" class="form-control" name="B_inputAddress" id="B_inputAddress" placeholder="Adresse.." required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="B_inputVille" class="form-label">Ville</label>
                                    <input type="text" class="form-control" name="B_inputVille" id="B_inputVille" placeholder="Ville.." required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="B_driver_zipcode" class="form-label">Code Postal</label>
                                    <input type="text" pattern="/(?:0[1-9]|[13-8][0-9]|2[ab1-9]|9[0-5])(?:[0-9]{3})?|9[78][1-9](?:[0-9]{2})?/" class="form-control" name="B_driver_zipcode" id="B_driver_zipcode" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="B_driver_country" class="form-label">Pays</label>
                                    <input type="text" class="form-control" name="B_driver_country" value="FR" id="B_driver_country" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="B_driver_phone" class="form-label">Téléphone</label>
                                    <input type="phone" class="form-control" name="B_driver_phone" id="B_driver_phone" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="B_dirver_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="B_dirver_email" id="B_dirver_email" required>
                                </div>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="B_driver_liscence_id" class="form-label">N° Permis de
                                            conduire</label>
                                        <input type="text" class="form-control" name="B_driver_liscence_id" id="B_driver_liscence_id" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="B_driver_liscence_cat" class="form-label">Catégorie du
                                            permis</label>
                                        <select class="form-select" aria-label="user" name="B_driver_liscence_cat" id="B_driver_liscence_cat" required>
                                            <option hidden selected>Sélectionner une categorie</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                            <option value="F">F</option>
                                            <option value="G">G</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="B_driver_liscence_expire" class="form-label">Fin de validité du
                                            permis</label>
                                        <input type="date" class="form-control" name="B_driver_liscence_expire" id="B_driver_liscence_expire" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3  pt-3">
                                <label for="date" class="form-label">
                                    <h5>Véhicule</h5>
                                </label>
                                <div class="row g-1">
                                    <label for="B_vehicle_initial_impact" class="form-label">Impact initial
                                        sur le véhicule</label>
                                    <input type="text" class="form-control" name="B_vehicle_initial_impact" id="B_vehicle_initial_impact" required>
                                </div>
                                <div class="row g-1">
                                    <label for="B_vehicle_damage" class="form-label">Dommages sur le
                                        véhicule</label>
                                    <textarea id="B_vehicle_damage" name="B_vehicle_damage" type="text" aria-describedby="button-addon2" class="form-control rounded border bg-light" required></textarea>
                                </div>
                            </div>
                            <div class="row g-3">
                                <label for="B_observation" class="form-label">
                                    <h5>Observations supplémentaires</h5>
                                </label>
                                <textarea id="B_observation" name="B_observation" type="text" aria-describedby="button-addon2" class="form-control rounded border bg-light"></textarea>
                            </div>
                            <div class="row g-1 pt-3">
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_stationing" id="B_stationing">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_stationing" id="B_stationing">
                                        <label class="form-check-label" for="B_stationing">En stationnement / à l'arrêt</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_leaving_parking_spot" id="B_leaving_parking_spot">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_leaving_parking_spot" id="B_leaving_parking_spot">
                                        <label class="form-check-label" for="B_leaving_parking_spot">Quittait un stationement</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_entering_parking_spot" id="B_entering_parking_spot">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_entering_parking_spot" id="B_entering_parking_spot">
                                        <label class="form-check-label" for="B_entering_parking_spot">Prenait un stationement</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_entering_place" id="B_entering_place">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_entering_place" id="B_entering_place">
                                        <label class="form-check-label" for="B_entering_place">Entrait dans un parking, lieu privé, chemin de terre</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_leaving_place" id="B_leaving_place">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_leaving_place" id="B_leaving_place">
                                        <label class="form-check-label" for="B_leaving_place">Sortait d'un parking, lieu privé, chemin de terre</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_round_point" id="B_round_point">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_round_point" id="B_round_point">
                                        <label class="form-check-label" for="B_round_point">S'engageait sur un giratoire</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_rear_damage_on_road" id="B_rear_damage_on_road">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_rear_damage_on_road" id="B_rear_damage_on_road">
                                        <label class="form-check-label" for="B_rear_damage_on_road">Heurtait à l'arrière en roulant dans le même sens et sur la même file</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_oposite_road_line" id="B_oposite_road_line">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_oposite_road_line" id="B_oposite_road_line">
                                        <label class="form-check-label" for="B_oposite_road_line">Roulait dans le même sens et sur une file différente</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_line_change" id="B_line_change">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_line_change" id="B_line_change">
                                        <label class="form-check-label" for="B_line_change">Changeait de file</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_overtake" id="B_overtake">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_overtake" id="B_overtake">
                                        <label class="form-check-label" for="B_overtake">Doublait</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_right_turn" id="B_right_turn">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_right_turn" id="B_right_turn">
                                        <label class="form-check-label" for="B_right_turn">Virait à droite</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_left_turn" id="B_left_turn">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_left_turn" id="B_left_turn">
                                        <label class="form-check-label" for="B_left_turn">Virait à gauche</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_driving_backward" id="B_driving_backward">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_driving_backward" id="B_driving_backward">
                                        <label class="form-check-label" for="B_driving_backward">Reculait</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_past_line" id="B_past_line">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_past_line" id="B_past_line">
                                        <label class="form-check-label" for="B_past_line">Empiétait sur une voie réservée à la circulation en sens inverse</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_from_right" id="B_from_right">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_from_right" id="B_from_right">
                                        <label class="form-check-label" for="B_from_right">Venait de droite</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" value="0" name="B_skip_priority" id="B_skip_priority">
                                        <input class="form-check-input" type="checkbox" value="1" name="B_skip_priority" id="B_skip_priority">
                                        <label class="form-check-label" for="B_from_right">N'a pas respecté la priorité ou un feu rouge</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row g-1 pt-3">
                            <button type="submit" class="btn btn-success" id="addInjured" name="addInjured">Valider</button>
                        </div>
                    </form>
                    <button type="submit" class="btn btn-success" id="addInjured" name="addInjured" onclick="hideConstat(this)">Supprimer</button>
                </div>
                <div class="row g-1 pt-3">
                    <button type="submit" class="btn btn-success" id="showConstat" name="showConstat" onclick="showConstat(this)">Ajouter un constat</button>
                </div>
            </div>

        </div>
        <!-- MAIN  -->
        <?php include get_path('partials', 'footer.php'); ?>
    </body>

</html>

<?php include get_path('partials', 'head.php'); ?>
<!DOCTYPE html>
<html>

    <head>
        <script charset="utf-8" src="/static/js/HeyThatsMe.js"></script>
        <script charset="utf-8" src="/static/js/manageSinistre.js"></script>
        <title>Chat</title>
    </head>

    <body onload="onLoad()">
        <?php include get_path('partials', 'navbar.php'); ?>
        <!-- MAIN (FORM) -->
        <div class="container-xl main">
            <div class="m-3 mt-0 order border-2 rounded p-3 shadow">
                <h1>Sinistre</h1>
                <form action="" method="POST" accept-charset="utf-8">
                    <div class="row g-3 border border-1 rounded p-3 mt-3">
                        <label for="contrat" class="form-label">
                            <h4>Contrat</h4>
                        </label>
                        <select class="form-select" aria-label="contrat" name="contrat" id="contrat">
                            <option selected disabled>Selectionner un contrat</option>
                        </select>
                    </div>
                    <div class="row g-3 border border-1 rounded p-3 mt-3">
                        <h4>Conducteur</h4>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="driver_profession" class="form-label">Profession</label>
                                <input type="text" class="form-control" name="driver_profession" id="driver_profession">
                            </div>
                            <div class="col-sm-6">
                                <label for="driver_relationship" class="form-label">Relation</label>
                                <select class="form-select" aria-label="driver relationship" name="driver_relationship" id="driver_relationship">
                                    <option value="married">marié</option>
                                    <option value="celib">célibataire</option>
                                    <option value="other">autre</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-1 pt-3">
                            <label for="driver_disp_reason" class="form-label">Motif de déplcament</label>
                            <input type="text" class="form-control" name="driver_disp_reason" id="driver_disp_reason">
                        </div>
                        <div class="row g-1 pt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="driver_user_same_residance" id="driver_user_same_residance">
                                <label class="form-check-label" for="driver_user_same_residance">Même residance que le
                                    propriétaire du contrat</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="driver_is_usual" id="driver_is_usual">
                                <label class="form-check-label" for="driver_is_usual">Conducteur habituel du
                                    véhicule</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="driver_is_employeeof_user" id="driver_is_employeeof_user">
                                <label class="form-check-label" for="driver_is_employeeof_user">Employer du propriétaire
                                    du contrat</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 border border-1 rounded p-3 mt-3">
                        <h4>Circonstances de l'accident</h4>
                        <div class="row g-1 pt-3">
                            <label for="date" class="form-label">Date de l'accident</label>
                            <input type="date" class="form-control" name="date" id="date">
                        </div>
                        <div class="row g-1 pt-3">
                            <label for="circumstances" class="form-label">Description</label>
                            <textarea id="circumstances" name="circumstances" type="text" placeholder="" aria-describedby="button-addon2" class="form-control rounded border bg-light"></textarea>
                        </div>

                    </div>
                    <div class="row g-3 border border-1 rounded p-3 mt-3">
                        <h4>Procédures juridiques</h4>
                        <div class="row g-1 pt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="proces_verbal" id="proces_verbal">
                                <label class="form-check-label" for="proces_verbal">Procès-verbal</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="police_report" id="police_report">
                                <label class="form-check-label" for="police_report">Rapport de police</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="main_courante" id="main_courante">
                                <label class="form-check-label" for="main_courante">Main-courante</label>
                            </div>
                            <div class="form-check">
                                <label for="police_station" class="form-label">Brigade ou commissariat</label>
                                <input type="text" class="form-control" name="police_station" id="police_station">
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 border border-1 rounded p-3 mt-3">
                        <h4>Véhicle</h4>
                        <div class="row g-1 pt-3">
                            <label for="usual_parking_location" class="form-label">Lieu habituel de garage</label>
                            <input type="text" class="form-control" name="usual_parking_location" id="usual_parking_location">
                        </div>
                        <div class="row g-3 p-3 pt-1">
                            <h5>Garage</h5>
                            <div class="col-sm">
                                <label for="driver_profession" class="form-label">Nom</label>
                                <input type="text" class="form-control" name="driver_profession" id="driver_profession">
                            </div>
                            <div class="col-sm">
                                <label for="garage_phone" class="form-label">Téléphone</label>
                                <input type="phone" class="form-control" name="garage_phone" id="garage_phone">
                            </div>
                            <div class="col-sm">
                                <label for="garage_phone" class="form-label">e-mail</label>
                                <input type="email" class="form-control" name="garage_phone" id="garage_phone">
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 border border-1 rounded p-3 mt-3">
                        <h4>Autres dégâts matériels</h4>
                        <textarea id="other_damage" name="other_damage" type="text" placeholder="Desciption des dégâts" aria-describedby="button-addon2" class="form-control rounded border bg-light"></textarea>
                    </div>
                </form>
                <div class="row g-3 border border-1 rounded p-3 mt-3">
                    <h4>Blessés</h4>

                    <div class="row g-3 border border-1 rounded p-3 mt-3">
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
                    </div>

                    <button type="submit" class="btn btn-primary" id="addInjured" name="addInjured" onclick="addInjured()">Ajouter un blessé</button>
                </div>
            </div>
            <div class="m-3 mt-0 order border-2 rounded p-3 shadow">
                <h1>Constat</h1>
                <div class="row g-3 border border-1 rounded p-3 mt-3">
                    <form action="" method="POST" accept-charset="utf-8">
                        <div class="row g-3 pt-3">
                            <label for="date" class="form-label">
                                <h5>Date de l'incident</h5>
                            </label>
                            <input class="form-control" type="date" value="" name="date" id="date">
                        </div>
                        <div class="row g-3 pt-3">
                            <label for="date" class="form-label">
                                <h5>Emplacement de l'incident</h5>
                            </label>
                            <input class="form-control" type="text" value="" name="location" id="location">
                        </div>
                        <div class="row g-3 pt-3">
                            <label for="date" class="form-label">
                                <h5>Temoins</h5>
                            </label>
                            <textarea id="injuries" name="injuries" type="text" placeholder="Liste des blessures" aria-describedby="button-addon2" class="form-control rounded border bg-light"></textarea>
                        </div>
                        <div class="row g-3 pt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="injured" id="injured">
                                <label class="form-check-label" for="injured">Blessés</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="other_vehicle_involved" id="other_vehicle_involved">
                                <label class="form-check-label" for="other_vehicle_involved">Autres véhicules</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="other_vehicle_involved" id="other_vehicle_involved">
                                <label class="form-check-label" for="other_vehicle_involved">Autres Objets</label>
                            </div>
                        </div>
                    </form>
                    <div class="row g-3 border border-1 rounded p-3 mt-3">
                        <h4>Véhicles</h4>
                        <div class="row g-3 border border-1 rounded p-3 mt-3">
                            <form action="" method="POST" accept-charset="utf-8">
                                <div class="row g-3">
                                    <label for="contract" class="form-label">
                                        <h5>N° de contrat</h5>
                                    </label>
                                    <input class="form-control" type="text" value="" name="contract" id="contract">
                                </div>

                                <div class="row g-3 pt-3">
                                    <h5>Conducteur</h5>
                                    <div class="col-sm-6">
                                        <label for="driver_lastname" class="form-label">Nom</label>
                                        <input type="text" class="form-control" name="driver_lastname" id="driver_lastname">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="driver_firstname" class="form-label">Prénom</label>
                                        <input type="text" class="form-control" name="driver_firstname" id="driver_firstname">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="driver_birthdate" class="form-label">Date de naissance</label>
                                        <input type="date" class="form-control" name="driver_birthdate" id="driver_birthdate">
                                    </div>
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
                                    <div class="col-sm-6">
                                        <label for="driver_country" class="form-label">Pays</label>
                                        <input type="text" class="form-control" name="driver_country" value="FR" id="driver_country">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="driver_phone" class="form-label">Téléphone</label>
                                        <input type="phone" class="form-control" name="driver_phone" id="driver_phone">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="dirver_email" class="form-label">e-mail</label>
                                        <input type="email" class="form-control" name="dirver_email" id="dirver_email">
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label for="driver_liscence_id" class="form-label">N° Permit de
                                                conduire</label>
                                            <input type="email" class="form-control" name="driver_liscence_id" id="driver_liscence_id">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="driver_liscence_cat" class="form-label">Category du
                                                permis</label>
                                            <input type="email" class="form-control" name="driver_liscence_cat" id="driver_liscence_cat">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="driver_liscence_expire" class="form-label">Fin de validité du
                                                permis</label>
                                            <input type="date" class="form-control" name="driver_liscence_expire" id="driver_liscence_expire">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3  pt-3">
                                    <label for="date" class="form-label">
                                        <h5>Véhicule</h5>
                                    </label>
                                    <div class="row g-1">
                                        <label for="vehicle_initial_impact" class="form-label">Impact initial
                                            sur le véhicule</label>
                                        <input type="text" class="form-control" name="vehicle_initial_impact" id="vehicle_initial_impact">
                                    </div>
                                    <div class="row g-1">
                                        <label for="vehicle_damage" class="form-label">Domages sur le
                                            véhicule</label>
                                        <textarea id="vehicle_damage" name="vehicle_damage" type="text" aria-describedby="button-addon2" class="form-control rounded border bg-light"></textarea>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <label for="observation" class="form-label">
                                        <h5>Observations supplementaires</h5>
                                    </label>
                                    <textarea id="observation" name="observation" type="text" aria-describedby="button-addon2" class="form-control rounded border bg-light"></textarea>
                                </div>
                                <div class="row g-1 pt-3">
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="stationing" id="stationing">
                                            <label class="form-check-label" for="stationing">En stastionnement / à l'arrêt</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="leaving_parking_spot" id="leaving_parking_spot">
                                            <label class="form-check-label" for="leaving_parking_spot">Quittait un stationement</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="entering_parking_spot" id="entering_parking_spot">
                                            <label class="form-check-label" for="entering_parking_spot">Prenait un stationement</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="entering_place" id="entering_place">
                                            <label class="form-check-label" for="entering_place">Entrait dans un parking, lieu privé, chemin de terre</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="leaving_place" id="leaving_place">
                                            <label class="form-check-label" for="leaving_place">Sortait d'un parking, lieu privé, chemin de terre</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="round_point" id="round_point">
                                            <label class="form-check-label" for="round_point">S'engageait sur un giratoire</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="rear_damage_on_road" id="rear_damage_on_road">
                                            <label class="form-check-label" for="rear_damage_on_road">Heurtait à l'arrière en roulant dans le même sens et sur la même file</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="oposite_road_line" id="oposite_road_line">
                                            <label class="form-check-label" for="oposite_road_line">Roulait dans le même sans et sur une file différente</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="line_change" id="line_change">
                                            <label class="form-check-label" for="line_change">Changeait de file</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="overtake" id="overtake">
                                            <label class="form-check-label" for="overtake">Doublait</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="right_turn" id="right_turn">
                                            <label class="form-check-label" for="right_turn">Virait à droite</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="left_turn" id="left_turn">
                                            <label class="form-check-label" for="left_turn">Virait à gauche</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="driving_backward" id="driving_backward">
                                            <label class="form-check-label" for="driving_backward">Reculait</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="past_line" id="past_line">
                                            <label class="form-check-label" for="past_line">Empiétait sur une voie réservée à la circulation en sens inverse</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="entering_place" id="entering_place">
                                            <label class="form-check-label" for="entering_place">Blessés</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="other_vehicle_involved" id="other_vehicle_involved">
                                            <label class="form-check-label" for="other_vehicle_involved">Autres véhicules</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="other_vehicle_involved" id="other_vehicle_involved">
                                            <label class="form-check-label" for="other_vehicle_involved">Autres Objets</label>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <button type="submit" class="btn btn-primary" id="addInjured" name="addInjured" onclick="addInjured()">Ajouter un véhicle</button>
                    </div>
                    <button type="submit" class="btn btn-primary" id="addInjured" name="addInjured" onclick="addInjured()">Ajouter un constat</button>
                </div>

            </div>

        </div>
        <!-- MAIN  -->
        <?php include get_path('partials', 'footer.php'); ?>
    </body>

</html>

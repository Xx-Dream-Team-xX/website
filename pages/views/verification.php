<!DOCTYPE html>
<html>

<head>
    <?php include(get_path('partials','head.php'));?>
    <title>Mon compte</title>
    <script src="/static/js/manageDates.js" charset="utf-8"></script>
    <script src="/static/js/parseUsers.js" charset="utf-8"></script>
    <script src="/static/js/HeyThatsMe.js" charset="utf-8"></script>
    <script src="/static/js/manageVerifications.js" charset="utf-8"></script>
    <script src="/static/js/targetNavigation.js" charset="utf-8"></script>
</head>

<body onload="updateMe(getData)">
    <?php include(get_path('partials','navbar.php'));?>
    <!-- MAIN (FORM) -->
    <div class="container-xl main">
        <div style="padding: 30px"></div>

        <div class="modal fade" id="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl d-flex justify-content-center" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalTitle">Changement d'informations personnelles</h5>
                        <button type="button" class="close btn btn-success" onclick="toggleModal()">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="show_current">
                            <h6>Informations actuelles</h6>

                            <div class="row g-3 p-1">
                                <div class="col-sm-6">
                                    <label for="inputSurname" class="form-label">Nom</label>
                                    <input disabled type="text" class="form-control" value="" id="current_last_name">
                                </div>
                                <div class="col-sm-6">
                                    <label for="inputName" class="form-label">Prénom</label>
                                    <input disabled type="text" class="form-control" value="" id="current_first_name">
                                </div>

                                <div class="col-sm-6">
                                    <label for="inputTelNumber" class="form-label">Numéro Téléphone</label>
                                    <input disabled type="number" class="form-control" value="" id="current_phone">
                                </div>
                    
                                <div class="col-sm-6">
                                    <label for="inputBirthdate" class="form-label">Date de naissance</label>
                                    <input disabled type="date" id="current_birth" class="form-control">
                                </div>
                            </div>
                            
                            <div class="row g-3 p-1">
                                <div class="col-sm-6">
                                    <label for="inputAddress" class="form-label">Adresse</label>
                                    <input disabled type="text" class="form-control" id="current_address">
                                </div>
                                <div class="col-sm-6">
                                    <label for="inputCodePostal" class="form-label">Code Postal</label>
                                    <input disabled type="number" class="form-control" id="current_zip_code">
                                </div>
                            </div>
                            <hr/>

                        </div>


                        <h6>Changements demandés</h6>
                        <div class="row g-3 p-1">
                            <div class="col-sm-6">
                                <label for="inputSurname" class="form-label">Nom</label>
                                <input disabled type="text" class="form-control" value="" id="last_name">
                            </div>
                            <div class="col-sm-6">
                                <label for="inputName" class="form-label">Prénom</label>
                                <input disabled type="text" class="form-control" value="" id="first_name">
                            </div>

                            <div class="col-sm-6">
                                <label for="inputTelNumber" class="form-label">Numéro Téléphone</label>
                                <input disabled type="number" class="form-control" value="" id="phone">
                            </div>
                
                            <div class="col-sm-6">
                                <label for="inputBirthdate" class="form-label">Date de naissance</label>
                                <input disabled type="date" id="birth" class="form-control">
                            </div>
                        </div>
                        
                        <div class="row g-3 p-1">
                            <div class="col-sm-6">
                                <label for="inputAddress" class="form-label">Adresse</label>
                                <input disabled type="text" class="form-control" id="address">
                            </div>
                            <div class="col-sm-6">
                                <label for="inputCodePostal" class="form-label">Code Postal</label>
                                <input disabled type="number" class="form-control" id="zip_code">
                            </div>
                        </div>

                        <hr/>

                        <div class="col">
                            <label class="form-label" for="justification">Commentaire du client</label>
                            <textarea class="form-control" id="justification" disabled></textarea>
                        </div>

                        <hr/>

                        <h6 id="ModalTitle">Justificatifs fournis</h6>

                        <ul id="documents">
                        </ul>

                        <div id="commentaires" hidden>
                            <div style="padding: 30px"></div>
                            <p class="p-3 mb-2 text-white bg-warning small">Attention: les fichiers tiers mis en ligne par les utilisateurs n'ont pas été scannés, ne vous ne mettez pas en danger.</p>

                            <div class="col">
                                <label class="form-label" for="com">Ajouter un commentaire</label>
                                <textarea class="form-control" id="com" placeholder="Une communication avec le client est primordial, remplir ce champs permettra à votre client de connaître le raisonnement derrière votre décision"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer" id="choix" hidden>
                        <button type="button" class="btn btn-danger" onclick="reject()">Refuser</button>
                        <button type="button" class="btn btn-success" onclick="accept()">Valider</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-3 d-flex justify-content-between">
            <div class="col-sm-8">
                <div class="table-responsive table-dark">
                    <div id="tables">
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div style="padding: 30px"></div>

    <!-- MAIN (FORM) -->
    <?php include(get_path('partials','footer.php'));?>
</body>

</html>
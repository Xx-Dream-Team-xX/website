<?php include get_path('partials', 'head.php'); ?>
<!DOCTYPE html>
<html>

    <head>
        <script charset="utf-8" src="/static/js/HeyThatsMe.js"></script>
        <script charset="utf-8" src="/static/js/targetNavigation.js"></script>
        <script charset="utf-8" src="/static/js/manageDates.js"></script>
        <script charset="utf-8" src="/static/js/viewContract.js"></script>
        <title>Sinistres</title>
    </head>

    <body onload="onLoad()">
        <?php include get_path('partials', 'navbar.php'); ?>
        <!-- MAIN (FORM) -->
        <div class="container-xl main" id="main">
            <div class="row m-3 mt-0 center-block order border-2 rounded p-3 shadow">
                <?php if (User::ASSURE == getPermissions() || User::GESTIONNAIRE == getPermissions()) { ?>
                <div class="row g-3 p-3 mb-3">
                    <select class="form-select" aria-label="contrat" name="contrat" id="contratList" onchange="querryContrat(this.value)" required>
                        <option hidden selected>Selectionner un Sinistre</option>
                    </select>
                    <script>
                        fillOptionContracts()
                    </script>
                </div>
                <?php }?>
                <div class="row pb-3 g-3">
                    <h5>Validité</h5>
                    <div class="col-sm-6">
                        <p class="h6 mb-0 py-1 text-dark">Debut</p>
                        <input class="form-control p-1" id="start" disabled>
                    </div>
                    <div class="col-sm-6">
                        <p class="h6 mb-0 py-1 text-dark">Fin</p>
                        <input class="form-control  p-1" id="end" disabled>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6 d-none">
                        <p class="h5 mb-0 py-1 text-dark">Immatriculation</p>
                        <input class="form-control  p-1" id="contrat_vID" disabled>
                    </div>
                    <div class="col-sm-6 d-none">
                        <p class="h5 mb-0 py-1 text-dark">Category</p>
                        <input class="form-control  p-1" id="category" disabled>

                    </div>
                    <div class="col-sm-6 d-none">
                        <p class="h5 mb-0 py-1 text-dark">Pays</p>
                        <input class="form-control  p-1" id="countryCode" disabled>
                    </div>
                    <div class="col-sm-6 d-none">
                        <p class="h5 mb-0 py-1 text-dark">Marque</p>
                        <input class="form-control  p-1" id="manufacturer" disabled>

                    </div>
                </div>
                <div class="row g-3 d-none" id="terValList">
                    <h5>Validité territoriale</h5>
                </div>

                <button class="btn btn-success m-2 mt-3 p-2" onclick="toggleModal()">Voir mon Code QR</button>

                <div class="modal fade" id="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-xl d-flex justify-content-center" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="ModalTitle">Votre contrat, à portée de main</h6>
                                <button type="button" class="close btn btn-success" onclick="toggleModal()">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3" id="terValList">
                                    <div class="d-flex justify-content-center" id="QRCode">
                                        <div class="spinner-border text-align-center text-primary" style="width: 3rem; height: 3rem;" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer" id="choix">
                                <a type="button" class="btn btn-primary" id="dlsvg">Télécharger</a>
                                <a type="button" class="btn btn-success" onclick="toggleModal()">Fermer</a>
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

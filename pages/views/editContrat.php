<?php onlyFor(User::GESTIONNAIRE);?>
<!DOCTYPE html>
<html>

    <head>
        <?php include get_path('partials', 'head.php'); ?>
        <script charset="utf-8" src="/static/js/HeyThatsMe.js"></script>
        <script charset="utf-8" src="/static/js/targetNavigation.js"></script>
        <script charset="utf-8" src="/static/js/manageDates.js"></script>
        <script charset="utf-8" src="/static/js/editContract.js"></script>
        <title>Contrats</title>
    </head>

    <body onload="onLoad()">
        <?php include get_path('partials', 'navbar.php'); ?>
        <!-- MAIN (FORM) -->
        <div class="container-xl main" id="main">
            <div class="row m-3 mt-0 center-block order border-2 rounded p-3 shadow">
                <div class="row g-3 p-3 mb-3">
                    <select class="form-select" aria-label="contrat" name="contrat" id="contratList" onchange="querryContrat(this.value)" required>
                        <option hidden selected>Selectionner un Contrat à mettre à jour</option>
                    </select>
                </div>
                <form class="needs-validation" id="sinistre" action="javascript:;" onsubmit="return(sendDate(this));" accept-charset="utf-8" novalidate>
                    <div class="row pb-3 g-3">
                        <h5>Validité</h5>

                        <div class="col-sm-6">
                            <p class="h6 mb-0 py-1 text-dark">Debut</p>
                            <input type="date" class="form-control p-1" name="start" id="start">
                        </div>
                        <div class="col-sm-6">
                            <p class="h6 mb-0 py-1 text-dark">Fin</p>
                            <input type="date" class="form-control  p-1" name="end" id="end">
                        </div>
                        <p class="text-small text-grey" id="info"></p>
                        <button type="submit" class="btn btn-success" id="submitDate" name="submitDate">Valider</button>
                    </div>
                    <div class="row pb-3 g-3">
                    </div>
                </form>
                <div class="row g-3">
                    <div class="col-sm-6 d-none">
                        <p class="h5 mb-0 py-1 text-dark">Immatriculation</p>
                        <input class="form-control  p-1" id="contrat_vID" disabled>
                    </div>
                    <div class="col-sm-6 d-none">
                        <p class="h5 mb-0 py-1 text-dark">Catégorie</p>
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
                <form class="needs-validation" id="sinistre" action="javascript:;" onsubmit="return(sendTerVal(this));" accept-charset="utf-8" novalidate>
                    <div class="row g-3 d-none" id="terValContainer">
                        <div class="row g-3" id="terValList">
                            <h5>Validité territoriale</h5>
                        </div>
                        <div class="row g-3">
                            <p class="text-small text-dark" id="info2"></p>
                            <button type="submit" class="btn btn-success" id="submitTerVal" name="submitTerVal">Valider</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- MAIN  -->
        <?php include get_path('partials', 'footer.php'); ?>
    </body>

</html>

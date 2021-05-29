<?php include get_path('partials', 'head.php'); ?>
<!DOCTYPE html>
<html>

    <head>
        <script charset="utf-8" src="/static/js/HeyThatsMe.js"></script>
        <script charset="utf-8" src="/static/js/manageDates.js"></script>
        <script charset="utf-8" src="/static/js/addContrat.js"></script>
        <title>Sinistres</title>
    </head>

    <body onload="onLoad()">
        <?php include get_path('partials', 'navbar.php'); ?>
        <!-- MAIN (FORM) -->
        <div class="container-xl main" id="main">
            <div class="row m-3 mt-0 center-block order border-2 rounded p-3 shadow">
                <form class="needs-validation" id="sinistre" action="javascript:;" onsubmit="sendContrat(this);" accept-charset="utf-8" novalidate>
                    <div class="row g-3 p-3 mt-3">
                        <label for="contrat" class="form-label">
                            <h4>Contrat</h4>
                        </label>
                        <select class="form-select" aria-label="user" name="owner" id="user" required>
                            <option hidden selected>Sélectionner un assuré</option>
                        </select>
                    </div>
                    <div class="row pb-3 g-3">
                        <div class="row pb-3 g-3">
                            <p class="h6 mb-0 py-1 text-dark">N° de contrat</p>
                            <input type="text" class="form-control p-1" name="id" id="id">
                        </div>
                        <h5>Validité</h5>
                        <div class="col-sm-6">
                            <p class="h6 mb-0 py-1 text-dark">Debut</p>
                            <input type="date" class="form-control p-1" name="start" id="start">
                        </div>
                        <div class="col-sm-6">
                            <p class="h6 mb-0 py-1 text-dark">Fin</p>
                            <input type="date" class="form-control  p-1" name="end" id="end">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <p class="h5 mb-0 py-1 text-dark">Immatriculation</p>
                            <input class="form-control  p-1" name="vID" id="vID">
                        </div>
                        <div class="col-sm-6  ">
                            <p class="h5 mb-0 py-1 text-dark">Category</p>
                            <select class="form-select" aria-label="user" name="category" id="category" required>
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
                        <div class="col-sm-6  ">
                            <p class="h5 mb-0 py-1 text-dark">Pays</p>
                            <input class="form-control  p-1" name="countryCode" id="countryCode">
                        </div>
                        <div class="col-sm-6  ">
                            <p class="h5 mb-0 py-1 text-dark">Marque</p>
                            <input type="text" class="form-control  p-1" name="manufacturer" id="manufacturer">

                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <h5>Validité territoriale</h5>
                    </div>
                    <div class="row g-1 pt-3" id="terValList">
                    </div>
                    <div class="row g-3 pt-1 p-3 mt-3">
                        <button type="submit" class="btn btn-success" id="submitContrat" name="submitContrat">Valider</button>
                    </div>
                </form>
            </div>

        </div>
        <!-- MAIN  -->
        <?php include get_path('partials', 'footer.php'); ?>
    </body>

</html>

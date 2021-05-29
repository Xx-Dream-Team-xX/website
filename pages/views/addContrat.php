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
        <div class="container-xl main" id="main" hidden>
            <div class="row m-3 mt-0 center-block order border-2 rounded p-3 shadow">
                <form action="">
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
                </form>
            </div>

        </div>
        <!-- MAIN  -->
        <?php include get_path('partials', 'footer.php'); ?>
    </body>

</html>

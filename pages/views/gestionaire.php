<?php include(get_path('partials','head.php'));?> 
<html>
    <script charset="utf-8" src="/static/js/manageGestionTable.js"></script>
    <body onload="getData()">
        <?php include(get_path('partials','navbar.php'));?> 
        <!-- MAIN (FORM) -->
        <div class="container-xl main">
            <div class="container-xl p-5 main">
                <div class="row mt-3 d-flex justify-content-between">
                    <div class="col-4">
                        <div class="table-responsive table-dark">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Mail</th>
                                    </tr>
                                </thead>
                                <tbody id="users">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-end flex-column">
                        <a class="btn btn-primary" href="/assures" role="button">Add Assurer</a>
                    </div>  
                </div>
            </div>
        </div>
        <!-- MAIN (FORM) -->
        <?php include(get_path('partials','footer.php'));?> 
    </body>
</html>


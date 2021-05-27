<?php include(get_path('partials','head.php'));?> 
<html>
    <script charset="utf-8" src="/static/js/manageGestionTable.js"></script>
    <body onload="getData()">
        <?php include(get_path('partials','navbar.php'));?> 
        <!-- MAIN (FORM) -->
        <div class="container-xl main">
            <div class="container-xl p-5 main">
                <div class="table-responsive table-dark">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Birthday</th>
                                <th scope="col">Declarations</th>
                                <th scope="col">Contracts</th>
                                <th scope="col">Sinisters</th>
                            </tr>
                        </thead>
                        <tbody id="users">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- MAIN (FORM) -->
        <?php include(get_path('partials','footer.php'));?> 
    </body>
</html>


<?php onlyForMin(User::ASSURE);?>
<!DOCTYPE html>
<html>
    <head>
        <?php include(get_path('partials', 'head.php')); ?>
        <title>Contract</title>
    </head>
    <body onload="updateMe(onLoad);">
        <?php include(get_path('partials', 'navbar.php')); ?>
        <script charset="utf-8" src="/static/js/HeyThatsMe.js"></script>
        <script src="/static/js/contact.js"></script>
        <!-- MAIN (FORM) -->
        <div class="main">
            <div class="container px-4 py-5" id="custom-cards">
                <h2 class="pb-2 border-bottom">Contacts</h2>

                <div class="row row-cols-1 row-cols-xl-3 align-items-stretch g-4 py-5">
                    <div class="col grow grow-1">
                        <div onclick="window.location.href = '/messages'" class="card card-cover mouse-cursor h-100 overflow-hidden text-white bg-dark rounded-5 shadow-lg" style="background-image: url('https://images.unsplash.com/photo-1521931961826-fe48677230a5?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8bWVzc2FnZXxlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&w=1000&q=80');">
                            <div class="d-flex flex-column h-100 p-2 pb-3 text-white text-shadow-1">
                                <h2 class="name pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Messagerie interne</h2>
                            </div>
                        </div>
                        <div onclick="window.location.href = '/messages'" class="darkener darken-25 mouse-cursor "></div>
                    </div>

                    <div class="col grow grow-1">
                        <div onclick="window.location.href = '/tickets'" class="card card-cover h-100 mouse-cursor overflow-hidden text-white bg-dark rounded-5 shadow-lg" style="background-image: url('https://i.dailymail.co.uk/i/pix/2017/11/29/00/46C8F1B300000578-0-image-a-7_1511916460644.jpg');">
                            <div class="d-flex flex-column h-100 p-2 pb-3 text-white text-shadow-1">
                                <h2 class="name pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Support technique : Ouvrir un ticket GLPI</h2>
                            </div>
                        </div>
                        <div  onclick="window.location.href = '/tickets'" class="darkener darken-50 mouse-cursor"></div>
                    </div>

                    <div class="col grow grow-1">
                        <div onclick="window.location.href = '/gestionnaire'" class="card card-cover h-100 mouse-cursor overflow-hidden text-white bg-dark rounded-5 shadow-lg" style="background-image: url('https://mining.com.au/wp-content/uploads/2021/02/stock-price-scaled.jpg');">
                            <div class="d-flex flex-column h-100 p-2 pb-3 text-white text-shadow-1">
                                <h2 class="name pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Vos correspondants</h2>
                            </div>
                        </div>
                        <div  onclick="window.location.href = '/gestionnaire'" class="darkener darken-50 mouse-cursor"></div>
                    </div>
                </div>

                <div class="col">
                        <table class="table table-striped" id="a_info" hidden>
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Votre assurance</th>
                                    <th scope="col">T??l??phone</th>
                                </tr>
                            </thead>
                            <tbody id='table'>
                            </tbody>
                        </table>
                    </div>
            </div>

        </div>
        <!-- MAIN  -->
        <?php include(get_path('partials', 'footer.php')); ?>
    </body>
    </html>


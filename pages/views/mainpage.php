<html>
    <head>
        <?php include(get_path("partials", "head.php")); ?>
        <script src="/static/js/manageLogin.js" charset="utf-8"></script>
    </head>
    <body>
        <!-- NAVBAR -->
        <?php include(get_path("partials", "navbar.php")); ?>
        <!-- MAIN (SLIDER) -->
        <div class="main">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 1"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <!--<div class="vignette" style="background-image: url('/static/images/qr-car.png')" ></div> <--can't figure out the problem->-->
                        <div class="vignette" style="background-image: url('https://pageloot.com/wp-content/uploads/2019/05/qr-codes-on-vehicles.jpg')" ></div>
                        <div class="carousel-caption">
                            <h5>Bienvenue</h5>
                            <p>Des images intéressantes peuvent être mises ici</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <!--<div class="vignette" style="background-image: url('/static/images/server.png')" ></div>-->
                        <div class="vignette" style="background-image: url('https://images.pond5.com/cloud-computing-datacenter-server-room-087560728_prevstill.jpeg')" ></div>
                        <div class="carousel-caption">
                            <h5>Hosted on Our High Performence Servers</h5>
                            <p>By using our platform get access to powerful free real estate. (for free)</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <!-- FOOTER-->
        <?php include(get_path("partials", "footer.php")); ?>
    </body>
    </html>


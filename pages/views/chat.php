<?php include(get_path('partials', 'head.php')); ?>
<!DOCTYPE html>
<html>
    <head>
        <script charset="utf-8" src="/static/js/HeyThatsMe.js"></script>
        <script charset="utf-8" src="/static/js/parseUsers.js"></script>
        <script charset="utf-8" src="/static/js/manageMessages.js"></script>
        <title>Chat</title>
    </head>
    <body onload="onLoad()">
        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalTitle">Modal title</h5>
                        <button type="button" class="close" onclick="toggleModal()">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="toggleModal()">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- NAVBAR -->
        <?php include(get_path('partials', 'navbar.php')); ?>
        <!-- MAIN (FORM) -->
        <div class="container-xl main">
            <div class="row rounded-lg overflow-hidden shadow">
                <!-- Users box-->
                <div class="col-5 px-0">
                    <div class="bg-white">
                        <div class="bg-gray px-4 py-2 bg-light">
                            <p class="h5 mb-0 py-1 text-dark">Messagerie <a href="#new" onclick="toggleModal()">+</a></p>
                        </div>

                        <div class="messages-box">
                            <div class="list-group rounded-0" id="recent">
                                <!-- Generated -->
                                <!-- Generated -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Chat Box-->
                <div class="col-7 px-0">
                    <div class="px-4 py-5 chat-box bg-white" id="messages">
                        <!-- Generated -->
                        <!-- Generated -->
                    </div>

                    <!-- Typing area -->
                    <form action="javascript:()=>{}" class="bg-light">
                        <div class="input-group d-inline-flex justify-content-between align-items-center p-1">
                            <button id="button-files" type="submit" class="btn btn-link"><i class="bi bi-file-earmark-plus"></i></button>
                            <input type="files" hidden multiple>
                            <textarea id="content" type="text" placeholder="Écrire un message" aria-describedby="button-addon2" class="form-control rounded-0 border-0 bg-light"></textarea>
                            <button id="button-send" type="submit" class="btn btn-link" onclick="prepareMessage()"> <i class="bi bi-cursor"></i></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- MAIN  -->
        <?php include(get_path('partials', 'footer.php')); ?>
    </body>
    </html>


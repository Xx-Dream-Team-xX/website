<?php onlyFor(User::ADMIN);?>

<!DOCTYPE html>
<html>

<head>
    <?php include(get_path('partials','head.php'));?>
    <title>Mon compte</title>
    <script src="/static/js/assurances.js" charset="utf-8"></script>
</head>

<body onload="onLoad()">
    <?php include(get_path('partials','navbar.php'));?>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col">Logo</th>
                <th scope="col">Nom</th>
                <th scope="col">Téléphone</th>
                <th scope="col">ID</th>
            </tr>
        </thead>
        <tbody id='table'>
        </tbody>
    </table>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl d-flex justify-content-center" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalTitle">Ajouter une assurance</h5>
                    <button type="button" class="close btn btn-success" onclick="toggleModal()">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="p-5">
                    <div class="row g-3 p-1">
                        <div class="col-sm-6">
                            <label class="form-label">Nom de l'assurance</label>
                            <input type="text" class="form-control" id="name" onkeyup="check(this, 'name', 'Format du nom incorrect')">
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Téléphone</label>
                            <input type="number" class="form-control" value="" id="phone" onkeyup="check(this, 'phone', 'Format du numéro de téléphone incorrect.')">
                        </div>
                    </div>

                    <div class="row p-1 mb-1">
                        <div class="col-sm-12">
                            <label class="form-label" for="files">Choisir un logo</label>
                            <input type="file" class="form-control" id="files" required>
                        </div>
                    </div>
                </div>
                

                <div id='error' class='form-text is-invalid text-danger'></div>

    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="toggleModal()">Annuler</button>
                    <button type="button" class="btn btn-success" onclick="send()">Créer</button>
                </div>
            </div>
        </div>
    </div>

    <?php include(get_path('partials','footer.php'));?>
</body>

</html>
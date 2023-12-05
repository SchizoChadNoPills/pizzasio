<form action="/Step/save" method="POST">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <?= !isset($step) ? 'Nouvelle étape' : 'Edition de ' . $step['name']; ?>
                </h2>
                <?php if (isset($step)) { ?>
                    <div class="card-toolbar">
                        <a href="/Step/delete?id=<?= $step['id']; ?>" class="btn btn-sm btn-danger swal2-confirm" data-bs-toggle="tooltip" data-bs-title="Supprimer l\'étape" text-swal2="Voulez-vous vraiment supprimé l\'étape <?= $step['name']; ?>"><i class="fa-solid fa-user-slash"></i></a>
                    </div>
                <?php } ?>
            </div>
            <div class="card-body">
                <?php
                if (isset($step)) { 
                    $isAdmin = true;
                    ?>
                    <input type="hidden" name="id" value="<?= $step['id']; ?>">
                <?php
                }
                ?>
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Nom</label>
                    <div class="col-sm-10">
                        <input id="name" type="text" name="name" class="form-control" value="<?= isset($step) ? $step['name'] : ''; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="order" class="col-sm-2 col-form-label">Ordre</label>
                    <div class="col-sm-10">
                        <input id="order" type="text" name="order" class="form-control" value="<?= isset($step) ? $step['order'] : ''; ?>">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" value="<?= isset($step) ? "update" : "insert"; ?>" name="type" class="btn btn-primary">Valider</btn>
            </div>
        </div>
    </div>
</form>
<form action="/Step/save" method="POST">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <?= !isset($ing) ? 'Nouvelle étape' : 'Edition de ' . $ing['name']; ?>
                </h2>
                <?php if (isset($ing)) { ?>
                    <div class="card-toolbar">
                        <a href="/Step/delete?id=<?= $ing['id']; ?>" class="btn btn-sm btn-danger swal2-confirm" data-bs-toggle="tooltip" data-bs-title="Supprimer l\'étape" text-swal2="Voulez-vous vraiment supprimé l\'étape <?= $ing['name']; ?>"><i class="fa-solid fa-user-slash"></i></a>
                    </div>
                <?php } ?>
            </div>
            <div class="card-body">
                <?php
                if (isset($ing)) { 
                    $isAdmin = true;
                    ?>
                    <input type="hidden" name="id" value="<?= $ing['id']; ?>">
                <?php
                }
                ?>
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Nom</label>
                    <div class="col-sm-10">
                        <input id="name" type="text" name="name" class="form-control" value="<?= isset($ing) ? $ing['name'] : ''; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="order" class="col-sm-2 col-form-label">Ordre</label>
                    <div class="col-sm-10">
                        <input id="order" type="text" name="order" class="form-control" value="<?= isset($ing) ? $ing['order'] : ''; ?>">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" value="<?= isset($ing) ? "update" : "insert"; ?>" name="type" class="btn btn-primary">Valider</btn>
            </div>
        </div>
    </div>
</form>
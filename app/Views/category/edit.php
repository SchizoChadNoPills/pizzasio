<form action="/Category/save" method="POST">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <?= !isset($ing) ? 'Nouvelle catégorie' : 'Edition de ' . $ing['name']; ?>
                </h2>
                <?php if (isset($ing)) { ?>
                    <div class="card-toolbar">
                        <a href="/Category/delete?id=<?= $ing['id']; ?>" class="btn btn-sm btn-danger swal2-confirm" data-bs-toggle="tooltip" data-bs-title="Supprimer la catégorie" text-swal2="Voulez-vous vraiment supprimé la catégorie <?= $ing['name']; ?>"><i class="fa-solid fa-user-slash"></i></a>
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
                        <input id="name" type="text" name="name" class="form-control"8 value="<?= isset($ing) ? $ing['name'] : ''; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="icon" class="col-sm-2 col-form-label">Icone</label>
                    <div class="col-sm-10">
                        <input id="icon" type="text" name="icon" class="form-control" value="<?= isset($ing) ? $ing['icon'] : ''; ?>">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" value="<?= isset($ing) ? "update" : "insert"; ?>" name="type" class="btn btn-primary">Valider</btn>
            </div>
        </div>
    </div>
</form>
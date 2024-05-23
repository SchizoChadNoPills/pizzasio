<form action="/Category/save" method="POST">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <?= !isset($category) ? 'Nouvelle catégorie' : 'Edition de ' . $category['name']; ?>
                </h2>
                <?php if (isset($category)) { ?>
                    <div class="card-toolbar">
                        <a href="/Category/delete?id=<?= $category['id']; ?>" class="btn btn-sm btn-danger swal2-confirm" data-bs-toggle="tooltip" data-bs-title="Supprimer la catégorie" text-swal2="Voulez-vous vraiment supprimé la catégorie <?= $category['name']; ?>"><i class="fa-solid fa-user-slash"></i></a>
                    </div>
                <?php } ?>
            </div>
            <div class="card-body">
                <?php
                if (isset($category)) {
                    $isAdmin = true;
                    ?>
                    <input type="hidden" name="id" value="<?= $category['id']; ?>">
                    <?php
                }
                ?>
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Nom</label>
                    <div class="col-sm-10">
                        <input id="name" type="text" name="name" class="form-control" value="<?= isset($category) ? $category['name'] : ''; ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="category" class="col-sm-2 col-form-label">Etape</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="id_step">
                            <?php
                            foreach ($step as $s) {
                                ?>
                                <option value="<?= $s['order']; ?>" <?= (isset($category) && $category['id_step'] == $s['order']) ? 'selected' : ''; ?>><?= $s['name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" value="<?= isset($category) ? "update" : "insert"; ?>" name="type" class="btn btn-primary">Valider</button>
            </div>
        </div>
    </div>
</form>

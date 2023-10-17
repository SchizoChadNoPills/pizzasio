<form action="/Ingredient/save" method="POST">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <?= !isset($ing) ? 'Nouvel ingredient' : 'Edition de ' . $ing['name']; ?>
                </h2>
                <?php if (isset($ing)) { ?>
                    <div class="card-toolbar">
                        <a href="/Ingredient/delete?id=<?= $ing['id']; ?>" class="btn btn-sm btn-danger swal2-confirm" data-bs-toggle="tooltip" data-bs-title="Supprimer l'ingrédient" text-swal2="Voulez-vous vraiment supprimé l'ingrédient <?= $ing['name']; ?>"><i class="fa-solid fa-user-slash"></i></a>
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
                    <label for="stock" class="col-sm-2 col-form-label">Stock</label>
                    <div class="col-sm-10">
                        <input id="stock" type="text" name="stock" class="form-control" value="<?= isset($ing) ? $ing['stock'] : ''; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="price" class="col-sm-2 col-form-label">Prix</label>
                    <div class="col-sm-10">
                        <input id="price" type="price" name="price" class="form-control" value="<?= isset($ing) ? $ing['price'] : ''; ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="price" class="col-sm-2 col-form-label">Catégorie</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="id_category">
                            <?php
                            foreach ($categ as $c) {
                                ?>
                                <option value="<?= $c['id'];?>"<?= (isset($ing) && $ing['id_category'] == $c['id']) ? 'selected' : ''; ?> ><?= $c['name']; ?></option>
                            }<?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="bio" class="col-sm-2 col-form-label">Bio ?</label>
                    <div class="form-check form-switch form-check-custom form-check-solid col-sm-10">
                        <input class="form-check-input" name="bio" type="checkbox" value="" id="bio" <?= (isset($ing) && $ing['bio'] == true) ? "checked" : ""; ?> />
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="vegan" class="col-sm-2 col-form-label">Vegan ?</label>
                    <div class="form-check form-switch form-check-custom form-check-solid col-sm-10">
                        <input class="form-check-input" name="vegan" type="checkbox" value="" id="vegan" <?= (isset($ing) && $ing['vegan'] == true) ? "checked" : ""; ?> />
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" value="<?= isset($ing) ? "update" : "insert"; ?>" name="type" class="btn btn-primary">Valider</btn>
            </div>
        </div>
    </div>
</form>
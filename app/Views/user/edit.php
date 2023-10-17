<form action="/Users/save" method="POST">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <?= !isset($u) ? 'Nouvel utilisateur' : 'Edition de ' . $u['username']; ?>
                </h2>
                <?php if (isset($u)) { ?>
                    <div class="card-toolbar">
                        <a href="/Users/delete?id=<?= $u['id']; ?>" class="btn btn-sm btn-danger swal2-confirm" data-bs-toggle="tooltip" data-bs-title="Supprimer l'utilisateur" text-swal2="Voulez-vous vraiment supprimé le compte <?= $u['username']; ?>"><i class="fa-solid fa-user-slash"></i></a>
                    </div>
                <?php } ?>
            </div>
            <div class="card-body">
                <?php
                if (isset($u)) { ?>
                    <input type="hidden" name="id" value="<?= $u['id']; ?>">
                <?php
                }
                ?>
                <div class="row mb-3">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input id="username" type="text" name="username" class="form-control<?= isset($u) ? '-plaintext' : ''; ?>" value="<?= isset($u) ? $u['username'] : ''; ?>" <?= isset($u) ? 'readonly' : ''; ?> required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input id="email" type="text" name="email" class="form-control<?= isset($u) ? '-plaintext' : ''; ?>" value="<?= isset($u) ? $u['email'] : ''; ?>" <?= isset($u) ? 'readonly' : ''; ?> required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-sm-2 col-form-label">Mot de passe</label>
                    <div class="col-sm-10">
                        <input id="password" type="password" name="password" class="form-control"<?= isset($u) ? '':'required' ; ?>>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="admin" class="col-sm-2 col-form-label">Admin ?</label>
                    <div class="form-check form-switch form-check-custom form-check-solid col-sm-10">
                        <input class="form-check-input" name="admin" type="checkbox" value="" id="admin" <?= (isset($u) && $u['admin'] == true) ? "checked" : ""; ?> />
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="active" class="col-sm-2 col-form-label">Actif ?</label>
                    <div class="form-check form-switch form-check-custom form-check-solid col-sm-10">
                        <input class="form-check-input" name="active" type="checkbox" value="" id="active" <?= (isset($u) && $u['active'] == true) ? "checked" : ""; ?> />
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" value="<?= isset($u) ? "update" : "insert"; ?>" name="type" class="btn btn-primary">Valider</btn>
            </div>
        </div>
    </div>
</form>
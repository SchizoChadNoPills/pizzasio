<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Listes des utilisateurs</h2>
            <div class="card-toolbar">
                <a href="<?= site_url('/Users/edit/new'); ?>" class="btn btn-primary">Nouvel utilisateur</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover" id="allUserTable">
                <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th>ID</th>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Actif</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var dataTable = $('#allUserTable').DataTable({
            "language": {
                "url": '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
            },
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "ajax": {
                "url": "<?= site_url('/Users/SearchUser'); ?>",
                "type": "POST"
            },
            "columns": [{
                "data": "id"
            },
                {
                    "data": "username"
                },
                {
                    "data": "email"
                },
                {
                    "data": "admin",
                    "render": function(data) {
                        return (data === "1" ? 'Oui' : 'Non');
                    }
                },
                {
                    "data": "active",
                    "render": function(data) {
                        return (data === "1" ? 'Oui' : 'Non');
                    }
                },
                {
                    "data": 'id',
                    "sortable": false,
                    "render": function(data, type, row) {
                        return `<a href="<?= site_url('/Users/edit/'); ?>${row.id}"><i class="fa-solid fa-pencil me-4"></i>Éditer</a>`;
                    }

                },
            ],
            "columnDefs": [{
                "searchable": false,
                "targets": [3, 4, 5] // Désactiver la recherche pour les colonnes non pertinentes
            }],
            "order": [
                [0, "asc"]
            ]
        });
    });
</script>

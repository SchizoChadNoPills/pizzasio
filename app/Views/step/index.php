<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Listes des étapes</h2>
            <div class="card-toolbar">
                <a href="/Step/edit/new" class="btn btn-primary">Nouvelle étape</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover" id="allStepTable">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>ID</th>
                        <th>Nom d'étape</th>
                        <th>Ordre</th>
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

        var dataTable = $('#allStepTable').DataTable({

            "language": {

                "url": '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',

            },

            "responsive": true,

            "processing": true,

            "serverSide": true,

            "pageLength": 50,

            "ajax": {

                "url": "/Step/SearchStep",

                "type": "POST"

            },

            "columns": [

                {

                    "data": "id"

                },

                {

                    "data": "name"

                },

                {

                    "data": "order"

                },

                {

                    "data": 'id',

                    "sortable": false,

                    "render": function(data, type, row) {

                        return `<a href="/Step/edit/${row.id}"><i class="fa-solid fa-pencil me-4"></i>Éditer</a>`;
                    }
                },

            ],

            "columnDefs": [{

                    "searchable": false,

                } // Désactiver la recherche pour les colonnes non pertinentes

            ],

            "order": [

                [0, "asc"]
            ]
        });
    });
</script>
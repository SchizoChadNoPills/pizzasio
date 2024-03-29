<div class="container">
    <div class="card">
        <div class="card-header">

            <h2 class="card-title">Liste des pizzas</h2>
            <div class="card-toolbar">

                <a href="<?= site_url('/Pizza/edit/new'); ?>" class="btn btn-primary">Nouvelle pizza</a>
            </div>
        </div>
        <div class="card-body">
            <table id="allPizzaTable" class="table table-hover ">
                <thead>
                <tr class="text-start text-gray400 fw-blod fs-7 text-uppercase gs-0">
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Active</th>
                    <th>Prix</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="modalPizza">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <p>Long modal body text goes here.</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).on('click', '.view', function(e){
        var id = $(this).data('id');
        $.ajax({
            url: "<?= site_url('/Pizza/AjaxPizzaContent'); ?>",
            type: "GET",
            data: {
                idPizza: id
            },
            success: function(data) {
                console.log(data);
                var modal = new bootstrap.Modal(document.getElementById('modalPizza'));
                $(".modal-title").html(data.pizza.name);
                var content = "<h5>Pâte</h5>";
                content += "<ul><li>"+ data.pate.name +"</li></ul>";
                content += "<h5>Base</h5>"
                content += "<ul><li>"+ data.base.name +"</li></ul>";
                content += "<h5>Ingrédients</h5>";
                content += "<ul>";
                data.ingredients.forEach((ing) => {
                    content += "<li>" + ing.name + "</li>";
                });
                content += "</ul>";
                $(".modal-body").html(content);
                modal.toggle();
            },
            error: function(hxr, status, error) {
                console.log(error);
            }
        })
    })

    $(document).ready(function() {
        var dataTable = $('#allPizzaTable').DataTable({
            "language": {
                "url": '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
            },
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "ajax": {
                "url": "<?= site_url('/Pizza/SearchPizza'); ?>",
                "type": "POST"
            },
            "columns": [{
                "data": "id"
            },
                {
                    "data": "name"
                },
                {
                    "data": "active",
                    "render": function(data) {
                        return (data === "1" ? 'Oui' : 'Non');
                    }
                },
                {
                    "data": 'price'
                },
                {
                    "data": 'id',
                    "sortable": false,
                    "render": function(data, type, row) {
                        return `<i class="fa-solid fa-eye me-4 view" data-id="${row.id}"></i>`;
                    }
                },
                {
                    "data": 'id',
                    "sortable": false,
                    "render": function(data, type, row) {
                        return `<a href="<?= site_url('/Pizza/edit/'); ?>${row.id}"><i class="fa-solid fa-pencil me-4"></i>Éditer</a>`;
                    }
                },

            ],


            "order": [
                [0, "asc"]

            ]

        });

    });
</script>

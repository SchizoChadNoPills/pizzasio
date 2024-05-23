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
                <tr class="text-start text-gray400 fw-bold fs-7 text-uppercase gs-0">
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Url Image</th>
                    <th>Active</th>
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
    $(document).ready(function() {
        var dataTable = $('#allPizzaTable').DataTable({
            "language": {
                "url": '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
            },
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "ajax": {
                "url": "<?= site_url('/Pizza/SearchPizza'); ?>",
                "type": "POST",
                "data": function(d) {
                    d.csrf_token_name = '<?= csrf_hash(); ?>';
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "price" },
                {
                    "data": 'img_url',
                    "render": function(data, type, row) {
                        return `<a href="${row.img_url}" data-toggle="lightbox"><img style="width:50px; height:auto" class="img-thumbnail" src="${row.img_url}"></a>`;
                    }
                },
                {
                    "data": 'active',
                    "render": function(data, type, row) {
                        return `<input type="checkbox" class="toggle-active" data-id="${row.id}" ${data == "1" ? 'checked' : ''}>`;
                    }
                },
                {
                    "data": 'id',
                    "sortable": false,
                    "render": function(data, type, row) {
                        return `<i class="fa-solid fa-eye me-4 view" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#modalPizza"></i>`;
                    }
                },
                {
                    "data": 'id',
                    "sortable": false,
                    "render": function(data, type, row) {
                        return `<a href="<?= site_url('/Pizza/edit/'); ?>${row.id}"><i class="fa-solid fa-pencil me-4"></i>Éditer</a>`;
                    }
                }
            ],
            "order": [[0, "asc"]]
        });

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
                },
                error: function(hxr, status, error) {
                    console.log(error);
                }
            });
        });

        $(document).on('change', '.toggle-active', function() {
            var id = $(this).data('id');
            var active = $(this).is(':checked') ? '1' : '0';

            $.ajax({
                url: "<?= site_url('/Pizza/ToggleActive'); ?>",
                type: "POST",
                data: {
                    id: id,
                    active: active,
                    csrf_token_name: '<?= csrf_hash(); ?>'
                },
                success: function(response) {
                    console.log(response);
                    if (response.status === 'success') {
                        dataTable.ajax.reload();
                    } else {
                        alert('Erreur lors de la mise à jour du statut.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Erreur lors de la mise à jour du statut.');
                }
            });
        });
    });
</script>



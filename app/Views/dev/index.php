<a href="#" class="btn btn-primary" id="btn-add">Ajouter</a>
<form action="/dev/result" method="POST">
    <select class="form-select" id="categ">
        <?php foreach($categories as $cat) : ?>
            <option value="<?= $cat['id'];?>"><?= $cat['name']; ?></option>
        <?php endforeach; ?>
    </select>
    <div id="emplacement">
    </div>
    <button class="btn btn-warning" type="submit">Valider</button>
</form>
<script>
    $(document).ready(function() {
        $("#btn-add").on('click', function() {
            let id_categ = $('#categ').val();
            $.ajax({
                url: "/Dev/AjaxIngredients",
                type: "GET",
                data : {
                    idCateg: id_categ
                },
                success: function(data) {
                    let select = "<select class='form-select' name='ingredients[]'>";
                    data.forEach((ing)=> {
                        var option = "<option value='" + ing.id + "' > " + ing.name + "</option>";
                        select += option;
                    });
                    select += "</select>";
                    $('#emplacement').append(select);
                    console.log(data);
                },
                error: function(hxr, status, error) {
                    console.log(error);
                }
            });
        });
    });
</script>
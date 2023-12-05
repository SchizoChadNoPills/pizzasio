<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <?= !isset($pizza) ? "Nouvelle Pizza" : "Edition de " . $pizza['name'] ?>
            </h2>
        </div>
        <div class="card-body">
            <!--begin::Stepper-->
            <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row" id="kt_stepper_example_vertical">
                <!--begin::Aside-->
                <div class="d-flex flex-row-auto w-100 w-lg-300px">
                    <!--begin::Nav-->
                    <div class="stepper-nav flex-center">
                        <!--begin::Step-Name-->
                        <div class="stepper-item me-5 current" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">1</span>
                                </div>
                                <!--end::Icon-->

                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Choix Nom
                                    </h3>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step-Name-->
                        <?php
                        foreach ($steps as $s) :
                        ?>
                            <!--begin::Step-->
                            <div class="stepper-item me-5 current" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number"><?= $s['order'] + 1; ?></span>
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            <?= $s['name']; ?>
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step-->
                        <?php
                        endforeach;
                        ?>

                    </div>
                    <!--end::Nav-->
                </div>

                <!--begin::Content-->
                <div class="flex-row-fluid">
                    <!--begin::Form-->
                    <form class="form w-lg-500px mx-auto" novalidate="novalidate" action="/Pizza/result" method="POST">
                        <!--begin::Group-->
                        <div class="mb-5">
                            <!--begin::Step Name-->
                            <div class="flex-column current" data-kt-stepper-element="content">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label">Nom de la pizza</label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" name="name" placeholder="" value="<?= isset($pizza) ? $pizza['name'] : ''?>" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--begin::Step Name-->

                            <!--begin::Step Pate-->
                            <div class="flex-column" data-kt-stepper-element="content">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label">Pâte de la pizza</label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <select class="form-select" name="pate">
                                        <?php foreach ($pate as $pate) : ?>
                                            <option <?= (isset($pizza) && ($pizza['id_pate'] == $pate['id'])) ? 'selected' : '' ?> value="<?= $pate['id']; ?>"><?= $pate['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--begin::Step Pate-->

                            <!--begin::Step Base-->
                            <div class="flex-column" data-kt-stepper-element="content">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label">Base de la pizza</label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <select class="form-select" name="base">
                                        <?php foreach ($base as $base) : ?>
                                            <option <?= (isset($pizza) && ($pizza['id_base'] == $base['id'])) ? 'selected' : '' ?> value="<?= $base['id']; ?>"><?= $base['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--begin::Step Base-->

                            <!--begin::Step Ingredient-->
                            <div class="flex-column" data-kt-stepper-element="content">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label">Ingredients de la pizza</label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <div class="d-flex flex-row">
                                            <select class="form-select mb-4 me-4" id="categ">
                                                <?php foreach ($categories as $cat) : ?>
                                                    <option value="<?= $cat['id']; ?>"><?= $cat['name']; ?></option>

                                                <?php endforeach; ?>
                                            </select>
                                            <a href="#" class="btn btn-primary mb-4" id="btn-add">Ajouter</a>
                                    </div>
                                    <div id="emplacement">
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--begin::Step Ingredient-->


                        </div>
                        <!--end::Group-->

                        <!--begin::Actions-->
                        <div class="d-flex flex-stack">
                            <!--begin::Wrapper-->
                            <div class="me-2">
                                <button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
                                    Retour
                                </button>
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Wrapper-->
                            <div>
                                <button type="submit" class="btn btn-primary" data-kt-stepper-action="submit">
                                    <span class="indicator-label">
                                        Finir ma pizza
                                    </span>
                                    <span class="indicator-progress">
                                        Patientez... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>

                                <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                    Suivant
                                </button>
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
            </div>
            <!--end::Stepper-->
        </div>
        <div class="card-footer">

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Stepper element
        var element = document.querySelector("#kt_stepper_example_vertical");

        // Initialize Stepper
        var stepper = new KTStepper(element);

        // Handle next step
        stepper.on("kt.stepper.next", function(stepper) {
            stepper.goNext(); // go next step
        });

        // Handle previous step
        stepper.on("kt.stepper.previous", function(stepper) {
            stepper.goPrevious(); // go previous step
        });

        $("#btn-add").on('click', function() {
            var id_categ = $('#categ').val();
            console.log(id_categ);
            $.ajax({
                url: "/Pizza/AjaxIngredients",
                type: "GET",
                data: {
                    idCateg: id_categ
                },
                success: function(data) {
                    let select = "<select class='form-select mb-4' name='ingredients[]'>";
                    let button = "<a href='#' class='btn btn-primary' id='btn-add'>Supprimer</a>"
                    data.forEach((ing) => {
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
    })
</script>
<?= $this->extend('layouts/admin/base') ?>

<?= $this->section('content') ?>
<div class="wrapper wrapper-content animated fadeInRight ecommerce" id="producto_form">

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Product info</a></li>

                    <li><a class="nav-link" data-toggle="tab" href="#tab-4"> Images</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <?= $this->include('productos/partials/form_producto')?>
                            <fieldset>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Name:</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" placeholder="Product name"></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Price:</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" placeholder="$160.00"></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Description:</label>
                                    <div class="col-sm-10">
                                        <div class="summernote">
                                            <h3>Lorem Ipsum is simply</h3>
                                            dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
                                            when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
                                            when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
                                            typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
                                            <br />

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Meta Tag Title:</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" placeholder="..."></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Meta Tag Description:</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" placeholder="Sheets containing Lorem"></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Meta Tag Keywords:</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" placeholder="Lorem, Ipsum, has, been"></div>
                                </div>
                            </fieldset>

                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane">
                        <div class="panel-body">
                            <fieldset>
                                
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let producto_list = new Vue({
        el: '#producto_form',
        data() {
            return {
                producto: {
                    category_id: ''
                },
                add_image: '',
                images: [],
                categorias: [],
                atributos: [],
                get_atributos: []
            }
        },
    })
</script>
<?= $this->endSection() ?>
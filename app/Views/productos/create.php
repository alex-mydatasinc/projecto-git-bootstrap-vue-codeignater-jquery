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

                            </fieldset>

                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane">
                        <div class="panel-body">
                            <fieldset>
                            <div class="form-group">
        <label for="">Imagen</label>
        <div class="d-flex flex-row">
            <input type="text" id="file" class="form-control mr-1" placeholder="Ingrese imagen" accept="image/*" v-model="add_image">
            <button type="button" class="btn btn-primary fa-duotone fa-plus" @click="img()"></button>
        </div>
    </div>
    <div class="form-group d-flex flex-row bd-highlight mb-3 overflow-x">
        <div v-for="(image,index) in images" class="position-relative">
            <div class="bg-danger px-2 position-absolute rounded-circle text-center d-flex align-items-center" @click="images.splice(index, 1)">x</div>
            <img id="picture" class="h-5 shadow-none p-1 bg-light rounded" vfor :src="image.source">
        </div>
    </div>
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
                btn: 1,
                add_image: '',
                images: [],
                categorias: [],
                atributos: [],
                get_atributos: []
            }
        },
        mounted() {
            this.Categorias("MCO", 0);
        },
        methods: {
            store_producto() {
                var formData = new FormData($("#form_producto")[0]);
                // console.log(formData);
                // console.log(formData.get("atributo0"));
                // console.log(formData.get("atributo1"));
                this.get_atributos = [];
                for (let [name, value] of formData) {

                    // console.log(formData.get(`${name}`));
                    let unit = $('#' + name + '-unit').val()
                    console.log(unit)
                    if (unit && value) {
                        this.get_atributos.push({
                            'id': name,
                            'value_name': value + ' ' + unit
                        })
                    } else {
                        if (value) {
                            this.get_atributos.push({
                                'id': name,
                                'value_name': value
                            })
                        }
                    }
                }

                console.log(this.get_atributos)
                $.ajax({
                    type: "post",
                    url: "<?= base_url('dashboard/productos/store'); ?>",
                    data: {
                        'id': this.producto.id,
                        'producto_id': this.producto.producto_id,
                        'title': this.producto.title,
                        'price': this.producto.price,
                        'available_quantity': this.producto.available_quantity,
                        'condition': this.producto.condition,
                        'pictures': this.images,
                        'category_id': this.producto.category_id,
                        'attributes': this.get_atributos
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                    }
                });
            },
            img() {
                this.images.push({
                    'source': this.add_image
                });
                console.log(this.images);
                this.add_image = '';
            },
            Categorias(id, index) {
                // console.log(index)
                this.categorias.splice(index + 1, this.categorias.length)
                this.atributos = []
                if (id != 'MCO') {
                    this.producto.category_id = id;
                }
                console.log(this.producto.category_id)
                $.ajax({
                    type: "post",
                    url: "<?= base_url('paises/categorias') ?>",
                    data: {
                        'id': id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        if (response.groups) {
                            console.log(JSON.stringify(response.groups[0].label))
                            producto_list.atributos = response.groups[0]
                        } else {
                            producto_list.categorias.push(response)
                        }
                    }
                });
            },
            type_input(type) {
                if (type == 'string') {
                    return 'text'
                }
                if (type == 'number' || type == 'number_unit') {
                    return 'number'
                }
                if (type == 'list') {
                    return 'select'
                }
            },
            validated_campos(valiadate_campos) {
                // return true
                for (var i = 0; i < valiadate_campos.length; i++) {
                    if (valiadate_campos[i] == 'catalog_required' || valiadate_campos[i] == 'required') {
                        return true
                    } else {
                        return false
                    }
                };

            },
        },
    })
</script>
<?= $this->endSection() ?>
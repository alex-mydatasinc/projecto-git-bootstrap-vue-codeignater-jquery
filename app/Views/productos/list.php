<?= $this->extend('layouts/admin/base') ?>

<?= $this->section('content') ?>
<div class="row" id="producto_list_crud">

    <div class="col-lg-12">
        <div class="mb-3">
            <button type="button" class="btn btn-primary" @click="showModal()"><i class="fa-duotone fa-plus"></i></button> CREAR PRODUCTO
            <button  @click="btn_sincrozar()" class="btn btn-success btn-circle btn-lg mr-1 float-right d-flex align-items-center mb-2" type="button"><i class="fa fa-link"></i>
            </button>
        </div>
        <div class="ibox">
            <div class="ibox-content">

                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                    <thead>
                        <tr>

                            <th data-toggle="true">Product Name</th>
                            <th data-hide="phone">Model</th>
                            <th data-hide="phone">Model</th>
                            <th data-hide="all">Description</th>
                            <th data-hide="phone">Price</th>
                            <th data-hide="phone,tablet">Quantity</th>
                            <th data-hide="phone">Status</th>
                            <th class="text-right" data-sort-ignore="true">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(producto, indice) in productos" :key="producto.id">
                            <td>
                                {{producto.title}}
                            </td>
                            <td>
                                {{producto.condition}}
                            </td>
                            <td>
                                <img alt="image" class="rounded-circle" :src="producto.thumbnail">
                            </td>                            
                            <td>
                                It is a long established fact that a reader will be distracted by the readable
                                content of a page when looking at its layout. The point of using Lorem Ipsum is
                                that it has a more-or-less normal distribution of letters, as opposed to using
                                'Content here, content here', making it look like readable English.
                            </td>
                            <td>
                                {{producto.price}}
                            </td>
                            <td>
                                {{producto.available_quantity}}
                            </td>
                            <td>
                                <span class="label label-primary">{{producto.status}}</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <!-- <button class="btn-white btn btn-xs" >View</button> -->
                                    <button class="btn-white btn btn-xs" @click="showModal(producto)">Edit</button>
                                    <button class="btn-danger btn btn-xs" @click="delete_producto(producto.producto_id, producto.id)">Eliminar</button>
                                </div>
                            </td>
                        </tr>


                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <ul class="pagination float-right"></ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
    <?= $this->include('productos/partials/modal') ?>
</div>

<script>
    $(document).ready(function() {
        $('.carousel').carousel();
        $('#form_producto').submit(function(e) {
            e.preventDefault();
            alert('entro')
        });
        // $('.footable').footable();
    });
    let producto_list = new Vue({
        el: '#producto_list_crud',
        data() {
            return {
                productos: [],
                producto: {
                    category_id: ''
                },
                add_image: '',
                images: [],
                btn: '',
                categorias: [],
                atributos: [],
                get_atributos: []
            }
        },
        mounted() {
            this.get_productos()
        },
        methods: {
            get_productos() {
                $.ajax({
                    type: "get",
                    url: "<?= base_url('dashboard/get_productos'); ?>",
                    dataType: "json",
                    success: function(response) {
                        producto_list.productos = response;
                        console.log(response);
                    }
                });
            },
            async showModal(producto) {
                this.categorias = []
                this.categorias.splice(0, this.categorias.length)
                this.Categorias("MCO", 0);
                $('#d_producto').modal('show')
                if (producto) {
                    this.producto = producto;
                    let attributes = await JSON.parse(this.producto.attributes);
                    console.log(this.attributes)
                    this.images = []
                    await this.Categorias(this.producto.category_id, 1);
                    this.producto.category_id = this.producto.category_id;
                    await JSON.parse(this.producto.pictures).forEach(img => {
                        this.images.push({
                            'source': img.url
                        });
                    });
                    this.btn = 0;
                    await setTimeout(function() {
                        attributes.forEach(attr => {
                            var porciones = attr.value_name.split(' ');
                            $(`#${attr.id}`).val(porciones[0]);
                            $('#' + attr.id + '-unit').val(porciones[1] ?? null);

                            // console.log(`id${attr.id}  value_name` +attr.value_name)
                        });
                    }, 3000);

                } else {
                    this.btn = 1;
                    this.producto = [];
                    this.images = []
                }
            },
            btn_sincrozar: function() {
                $.ajax({
                    type: "GET",
                    url: "<?= base_url('dashboard/productos/Generar'); ?>",
                    dataType: "json",
                    success: function(response) {
                       // this.get_productos();
                       console.log(response);
                    }
                });
            },
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
            update_producto() {
                var formData = new FormData($("#form_producto")[0]);
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
                $.ajax({
                    type: "post",
                    url: "<?= base_url('dashboard/productos/update'); ?>",
                    data: {
                        'id': this.producto.id,
                        'title': this.producto.title,
                        'price': this.producto.price,
                        'producto_id': this.producto.producto_id,
                        'available_quantity': this.producto.available_quantity,
                        'condition': this.producto.condition,
                        'pictures': this.images,
                        'category_id': this.producto.category_id,
                        'attributes': this.get_atributos
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        // location.reload();
                    }
                });
            },
            delete_producto(producto_id, id) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('dashboard/productos/delete'); ?>",
                    data: {
                        'producto_id': producto_id,
                        'id': id,
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
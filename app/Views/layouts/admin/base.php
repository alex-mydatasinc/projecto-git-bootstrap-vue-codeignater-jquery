<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $this->renderSection('title') ?></title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/assets/css/animate.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>

<body>

    <div id="wrapper" id="producto_vue">

        <?= $this->include('layouts/admin/header') ?>

        <div id="page-wrapper" class="gray-bg">     
            <?= $this->include('layouts/admin/partials/nav') ?>
            <?= $this->include('layouts/admin/main') ?>
            <?= $this->include('layouts/admin/footer') ?>

        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/vue.js"></script>
    <!-- <script src="/assets/js/jquery-3.1.1.min.js"></script> -->
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>


    <!-- Custom and plugin javascript -->
    <link rel="stylesheet" href="/assets/css/custom.css">
    <script src="/assets/js/inspinia.js"></script>
    <script src="/assets/js/plugins/pace/pace.min.js"></script>
    <!-- <script type="text/javascript" src="/assets/js/producto.js"></script> -->
    <script>
        $(document).ready(function() {
            $('.carousel').carousel();
            $('#form_producto').submit(function(e) {
                e.preventDefault();
                alert('entro')
            });
            $('#logout').on('click', function (e) {
                e.preventDefault;
            });
            $('.footable').footable();
        });
        let producto_vue = new Vue({
            el: '#producto_vue',
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
            watch: {
                producto(newValue, oldValue) {
                    console.log('new value: ' + newValue + ' old value: ' + oldValue)
                    // Note: `newValue` will be equal to `oldValue` here
                    // on nested mutations as long as the object itself
                    // hasn't been replaced.
                },
            },
            mounted() {
                this.get_productos()
            },
            methods: {
                get_productos_api() {
                    $.ajax({
                        type: "get",
                        url: "<?= base_url('dashboard/productos/Generar'); ?>",
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                        }
                    });
                },
                get_productos() {
                    $.ajax({
                        type: "get",
                        url: "<?= base_url('dashboard/get_productos'); ?>",
                        dataType: "json",
                        success: function(response) {
                            producto_vue.productos = response;
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
                                producto_vue.atributos = response.groups[0]
                            } else {
                                producto_vue.categorias.push(response)
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


</body>

</html>
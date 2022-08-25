<div id="producto_vue">
    <div class="container">
        <div class="row m-4">
            <div>
                <button type="button" class="btn btn-primary" @click="showCreate()"><i class="fa-duotone fa-plus"></i></button> CREAR PRODUCTO
            </div>

            <button type="button" class="btn btn-primary" @click="get_productos_api()">Traer a BD</button>
        </div>
        <div class="row">
            <div class="col-4 mb-3" v-for="(producto, indice) in productos" :key="producto.id">
                <div class="d-flex flex-column mb-3 shadow p-3 bg-light rounded h-100">
                    <div :id="'carouselId-'+indice" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item" v-for="(img, indice) in JSON.parse(producto.pictures)" :class="(indice == 0) ? 'active':''">
                                <img class="d-block d-flex w-100" :src="img" alt="First slide" :id="'imgl-'+indice">
                            </div>
                            <div class="carousel-item" v-for="(img, index) in JSON.parse(producto.pictures)">
                                <img class="d-block w-100" :src="img" alt="First slide" :id="'img-'+(index+10)">
                            </div>
                        </div>
                        <a class="carousel-control-prev text-primary " :href="'#carouselId-'+indice" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon text-primary" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next text-primary" :href="'#carouselId-'+indice" role="button" data-slide="next">
                            <span class="carousel-control-next-icon text-primary" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <span class="text-center">{{producto.title}}</span>
                    <span class="text-center">$ {{producto.price}}</span>

                    <span>{{producto.condition}}</span>
                    <span>{{producto.city}}</span>
                    <div class="d-flex justify-content-around h-100 d-flex align-items-end">
                        <div class="row text-primary">
                            <a class="fa-solid fa-pen-to-square text-sz mx-3 btn btn-primary" href="#" role="button" @click="showEdit(producto)"></a>
                            <a class="fa-solid fa-trash-can text-sz btn btn btn-danger" href="#" role="button" @click="delete_producto(producto.producto_id)"></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="d_producto" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content w-100">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <p class="text-success">{{producto.title}}</p>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body w-100">
                    <form @submit.prevent="update_producto" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="">Titulo</label>
                                <input type="text" class="form-control" placeholder="Asignele un titulo" v-model="producto.title">
                            </div>
                            <div class="form-group col-6">
                                <label for="">Precio</label>
                                <input type="number" class="form-control" placeholder="Asignele un titulo" v-model="producto.price">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="">condicion</label>
                                <input type="text" class="form-control" placeholder="Asignele un titulo" v-model="producto.condition">
                            </div>
                            <div class="form-group col-6">
                                <label for="">Numero de productos</label>
                                <input type="number" class="form-control" placeholder="Asignele un titulo" v-model="producto.available_quantity">
                            </div>
                        </div>
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
                                <img id="picture" class="h-5 shadow-none p-1 bg-light rounded" :src="image.source">
                            </div>
                            
                        </div>
                        <h4 class="text-center">Categorias</h4>          
                        
                        <div class="d-flex flex-row bd-highlight mb-3 overflow-x">
                            <div class="form-group col-4" v-if="categorias.length > 0" v-for=" (i, index) in categorias">
                                <ul class="list-group d-flex bd-highlight overflow">
                                    <li class="list-group-item bg-success" v-for="(categoria) in categorias[index]" :key="categoria.id"  @click="Categorias(categoria.id, index)">{{categoria.name}}</li>
                                </ul>
                            </div>                            
                        </div>
                        {{producto}}
                        <div class="form-group" v-for="atributo in atributos.groups" v-if="atributos.groups">

                            <label for="" class="text-success">{{atributo.label}}</label>
                            <div class="row">
                                <div class="form-group col-4" v-for="caracteristicas in atributo.components" v-if="validated_campos(caracteristicas.attributes[0].tags)">
                                    <!-- {{caracteristicas.attributes[0].value_type}} -->
                                    <label for="">{{caracteristicas.attributes[0]['name']}}</label>
                                    <select class="form-control" v-if="type_input(caracteristicas.attributes[0]['value_type']) == 'select'">
                                        <option disabled selected value="">Ingrese {{caracteristicas.attributes[0]['name']}}</option>
                                        <option v-for="value in caracteristicas.attributes[0]['values']" :value="value.name">{{value.name}}</option>
                                        {{caracteristicas.attributes[0].units}}
                                    </select>
                                    <input :type="type_input(caracteristicas.attributes[0]['value_type'])" v-else 
                                        class="form-control" 
                                            :placeholder="'ingrese '+caracteristicas.attributes[0]['name']" 
                                                :list="'list-value'+index"
                                                    v-model="get_atributos.name">
                                                    {{get_atributos}}
                                    <!-- <datalist :id="'list-value'+index" v-if="caracteristicas.attributes[0]['values']">
                                        <option v-for="value in caracteristicas.attributes[0]['values']">{{value}}</option>
                                    </datalist> -->
                                </div>
                            </div>                           
                        
                        </div>
                        </div>
                        <button type="submit" class="btn btn-primary" v-if="btn == 0">Actualizar</button>
                        <button type="button" class="btn btn-primary" @click="store_producto()" v-if="btn == 1">Crear</button>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div> -->
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.carousel').carousel();
        // $('#file').change(function (e) { 
        //     e.preventDefault();
        //     var file = e.target.files[0];
        //     console.log(file)
        //     var reader = new FileReader();
        //     reader.onload = (e) => {
        //         document.getElementById("picture").setAttribute('src', event.target.result);
        //     };
        //     reader.readAsDataURL(file);
        // });
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
                console.log('new value: '+newValue+' old value: '+oldValue)
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
            showEdit(producto) {
                $('#d_producto').modal('show')
                this.producto = producto;
                this.btn = 0;
            },
            showCreate() {
                this.categorias.splice(0, this.categorias.length)
                this.Categorias("MCO", 0);
                $('#d_producto').modal('show')
                this.btn = 1;                
            },
            store_producto() {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('dashboard/productos/store'); ?>",
                    data: {
                        'title': this.producto.title,
                        'price': this.producto.price,
                        'available_quantity': this.producto.available_quantity,
                        'condition': this.producto.condition,
                        'pictures': this.images,
                        'category_id': this.producto.category_id,
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                    }
                });
            },
            update_producto() {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('dashboard/productos/update'); ?>",
                    data: {
                        'id': this.producto.id,
                        'title': this.producto.title,
                        'price': this.producto.price,
                        'producto_id': this.producto.producto_id,
                        'status': this.producto.status,
                        // 'start_time': this.producto.start_time,
                        'stop_time': this.producto.stop_time,
                        'condition': this.producto.condition,
                        // 'pictures': this.producto.pictures,
                        // 'thumbnail': this.producto.thumbnail,
                        // 'city': this.producto.city,
                        // 'marca': this.producto.marca,
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        location.reload();
                    }
                });
            },
            delete_producto(producto_id) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('dashboard/productos/delete'); ?>",
                    data: {
                        'producto_id': producto_id,
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                    }
                });
            },
            img() {
                this.images.push({'source': this.add_image});
                this.add_image = '';     
            },
            Categorias(id, index){
                // console.log(index)
                this.categorias.splice(index+1, this.categorias.length)
                this.atributos = []
                this.producto.category_id = id;
                console.log(this.producto.category_id)
                $.ajax({
                    type: "post",
                    url: "<?= base_url('paises/categorias')?>",
                    data: {'id': id},
                    dataType: "json",
                    success: function (response) {
                        console.log(response)                        
                        if (response.groups) {
                            producto_vue.atributos = response
                        }else{
                            producto_vue.categorias.push(response)
                        }
                    }
                });
            },
            type_input(type){
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
            validated_campos(valiadate_campos){
                // return true
                for (var i = 0; i < valiadate_campos.length; i++) {
                    if (valiadate_campos[i]  == 'catalog_required' || valiadate_campos[i]  == 'required') {
                        return true
                    }else{
                        return false
                    }
                };
                
            }
        },
    })
</script>
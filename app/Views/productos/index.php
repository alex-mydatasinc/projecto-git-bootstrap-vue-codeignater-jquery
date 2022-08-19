<div id="producto_vue">
    <div class="d-flex justify-content-between flex-row m-4">
        <button type="button" class="btn btn-primary" @click="showCreate()">Crear nuevo producto</button>
        <button type="button" class="btn btn-primary" @click="get_productos_api()">Traer a BD</button>
    </div>    
    <div class="container">
        <div class="row">
            <div class="col-4 mb-3" v-for="producto in productos" :key="producto.id"  v-if="producto.status != 'closed'">
                <div class="d-flex flex-column mb-3 shadow p-3 bg-light rounded">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active" v-for="(img, index) in JSON.parse(producto.pictures)" :key="index">
                                <img class="d-block w-100" :src="img" alt="First slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <span class="text-center">{{producto.title}}</span>
                    <span class="text-center">$ {{producto.price}}</span>

                    <span>{{producto.condition}}</span>
                    <span>{{producto.city}}</span>
                    <div class="d-flex justify-content-around">
                        <a name="" id="" class="btn btn-primary d-flex" href="#" role="button" @click="showEdit(producto)">Mostrar</a>
                        <a name="" id="" class="btn btn-danger" href="#" role="button" @click="delete_producto(producto.producto_id)">X</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="d_producto" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <p class="text-success">{{producto.title}}</p>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="update_producto">
                        <div class="form-group">
                          <label for="">Titulo</label>
                          <input type="text" class="form-control" placeholder="Asignele un titulo" v-model="producto.title">
                        </div>
                        <div class="form-group">
                          <label for="">Precio</label>
                          <input type="number" class="form-control" placeholder="Asignele un titulo" v-model="producto.price">
                        </div>
                        <div>
                            <div class="form-group">
                                <label for="">condicion</label>
                                <input type="text" class="form-control" placeholder="Asignele un titulo" v-model="producto.condition">
                            </div>
                            <div class="form-group">
                                <label for="">Numero de productos</label>
                                <input type="number" class="form-control" placeholder="Asignele un titulo" v-model="producto.available_quantity">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="button" class="btn btn-primary" @click="store_producto()">Crear</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let producto = new Vue({
        el: '#producto_vue',
        data() {
            return {
                productos: [],
                producto: [],
                images: []
            }
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
                        producto.productos = response;
                        console.log(response);
                    }
                });
            },
            showEdit(producto) {
                $('#d_producto').modal('show')
                this.producto = producto;
                // this.images = 
            },
            showCreate(){
                this.producto = [];
                $('#d_producto').modal('show')                
            },
            store_producto(){
                
                $.ajax({
                    type: "post",
                    url: "<?= base_url('dashboard/productos/store'); ?>",
                    data: {
                        'title': producto.producto.title,
                        'price': producto.producto.price,
                        'available_quantity': producto.producto.available_quantity,
                        'condition': producto.producto.condition,
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                    }
                });
            },
            update_producto(){
                $.ajax({
                    type: "post",
                    url: "<?= base_url('dashboard/productos/update'); ?>",
                    data: {
                        'id': producto.producto.id,
                        'title': producto.producto.title,
                        'price': producto.producto.price,
                        'producto_id': producto.producto.producto_id,
                        'status': producto.producto.status,
                        // 'start_time': producto.producto.start_time,
                        'stop_time': producto.producto.stop_time,
                        'condition': producto.producto.condition,
                        // 'pictures': producto.producto.pictures,
                        // 'thumbnail': producto.producto.thumbnail,
                        // 'city': producto.producto.city,
                        // 'marca': producto.producto.marca,
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response)
                        location.reload();
                    }
                });
            },
            delete_producto(producto_id){
                $.ajax({
                    type: "post",
                    url: "<?= base_url('dashboard/productos/delete');?>",
                    data: {
                        'producto_id': producto_id,
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                    }
                });
            }    
        },
    })
</script>
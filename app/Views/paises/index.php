<style>
.gap{
    column-gap: 1rem; /* 2px */
}
</style>
<div class="container" id="categoria_vue">
    <div class="row my-3">
        <ul class="list-group col-3" id="paises">
            <li class="list-group-item active">Paises</li>
            <div  v-for="pais in paises" :key="pais.name" >
                <li class="list-group-item disabled" @click="get_all_categorias(pais.id)" :class="(active_pais==pais.id) ? 'bg-primary text-white' : 'bg-light'">{{pais.name}}</li>
            </div>           
        </ul>
        <ul class="list-group col-3" id="paises">
            <li class="list-group-item active">Categorias</li>
            <li class="list-group-item disabled" v-for="categoria in categorias" :key="categoria.id" @click="get_detalle(categoria.id)" 
                :class="(active_categoria==categoria.id) ? 'bg-primary text-white' : 'bg-light'">{{categoria.name}}</li>
        </ul>
        
        <div class="col">
            <div class="d-flex flex-column justify-content-start mb-3">
                <h1 class="text-center">{{detalle.name}}</h1>
                <span class="text-center">Total categorias: {{detalle.total_items_in_this_category}}</span>
                <img :src="detalle.picture" alt="" class="w-50 p-3 h-25 mx-auto">
                <span>{{detalle.permalink}}</span>
                <span>{{detalle.date_created}}</span>
            </div>
            <ul class="list-group" id="paises">
                <li class="list-group-item active">SubCategorias</li>
                <li class="list-group-item disabled" v-for="subCategoria in detalle.children_categories" :key="subCategoria.id">{{subCategoria.name}}</li>
            </ul>
        </div>
    </div>
</div>

<script>
    let categorias = new Vue({
        el: "#categoria_vue",
        data() {
            return {
                paises: [],
                categorias: [],
                detalle:  [],
                active_pais: '',
                active_categoria: '',
            }
        },
        mounted() {
            this.get_all_paises();
        },
        methods: {
            get_all_paises(){
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url('paises'); ?>",
                    dataType: "JSON",
                    success: function (resp) {
                        console.log(resp.paises);
                        categorias.paises = resp.paises
                    }
                });
            },
            get_all_categorias(id){
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url('paises/categorias');?>",
                    data: {'id': id},
                    dataType: "JSON",
                    success: function (response) {
                        console.log(response.categorias)
                        categorias.categorias = response.categorias
                    }
                });
                categorias.active_pais= id
                console.log(id)
            },
            get_detalle(id){
                console.log(id)
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url('paises/detalle');?>",
                    data: {'id': id},
                    dataType: "JSON",
                    success: function (response) {
                        console.log(response.detalle)
                        categorias.detalle = response.detalle
                    }
                });
                categorias.active_categoria= id
            }
        },
    })
</script>
<!-- <script>
$(document).ready(function () {
    $.ajax({
        type: "get",
        url: <?php base_url()?>+"/paises",
        dataType: "json",
        success: function (resp) {
            resp.forEach(pais => {
                $('#paises').append(`<li class="list-group-item disabled">${pais.name}</li>`);
            });
            }
        }
    });
});
</script> -->
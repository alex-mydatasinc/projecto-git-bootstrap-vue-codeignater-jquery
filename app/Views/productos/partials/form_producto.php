<form id="form_producto">
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
            <img id="picture" class="h-5 shadow-none p-1 bg-light rounded" vfor :src="image.source">
        </div>
    </div>

    <h4 class="text-center">Categorias</h4>
    {{producto.category_id}}
    <div class="d-flex flex-row bd-highlight mb-3 overflow-x">
        <div class="form-group col-4" v-if="categorias.length > 0" v-for=" (i, index) in categorias">
            <ul class="list-group d-flex bd-highlight overflow">
                <li class="list-group-item bg-success" v-for="(categoria) in categorias[index]" :key="categoria.id" @click="Categorias(categoria.id, index)">{{categoria.name}}</li>
            </ul>
        </div>
    </div>
    <label for="" class="text-success">{{atributos.label}}</label>
    <div class="row">
        <div class="form-group col-4" v-for="(caracteristicas, index) in atributos.components">
            <!-- <div class="form-group col-4" v-for="(caracteristicas, index) in atributos.components" v-if="validated_campos(caracteristicas.attributes[0].tags)"> -->
            <!-- {{caracteristicas.attributes[0].value_type}} -->
            <label for="">{{caracteristicas.attributes[0]['name'] }}<span class="text-danger">{{validated_campos(caracteristicas.attributes[0]['tags']) ? '*' : ''}}</span></label>
            <select class="form-control" v-if="type_input(caracteristicas.attributes[0]['value_type']) == 'select'" :id="caracteristicas.attributes[0]['id']" :name="caracteristicas.attributes[0]['id']" :id="'atributo'+index">
                <option disabled selected value="">Ingrese {{caracteristicas.attributes[0]['name']}}</option>
                <option v-for="value in caracteristicas.attributes[0]['values']" :value="value.name">{{value.name}}</option>
                {{caracteristicas.attributes[0].units}}
            </select>
            <div class="input-group mb-3" v-else>
                <input :type="type_input(caracteristicas.attributes[0]['value_type'])" class="form-control" :placeholder="'ingrese '+caracteristicas.attributes[0]['name']" :list="'list-value'+index" :name="caracteristicas.attributes[0]['id']" :id="caracteristicas.attributes[0]['id']">
                <select class="input-group-prepend input-group-text" v-if="caracteristicas.attributes[0]['units']" :id="caracteristicas.attributes[0]['id']+'-unit'">
                    <option value="" v-for="unit in caracteristicas.attributes[0]['units']" :value="unit.id">{{unit.name}}</option>
                </select>
                <datalist :id="'list-value'+index" v-if="caracteristicas.attributes[0]['values']">
                    <option v-for="value in caracteristicas.attributes[0]['values']">{{value.name}}</option>
                </datalist>
            </div>


        </div>
    </div>
    <button type="button" class="btn btn-primary" v-if="btn == 0" @click="update_producto()">Actualizar</button>
    <button type="button" class="btn btn-primary" @click="store_producto()" v-if="btn == 1">Crear</button>
</form>
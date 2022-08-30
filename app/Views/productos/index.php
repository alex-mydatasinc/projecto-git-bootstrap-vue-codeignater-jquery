<?= $this->extend('layouts/admin/base') ?>

<?= $this->section('content') ?>
<div id="producto_vue">
    <?= $this->include('productos/partials/nav');?>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-3 " v-for="(producto, indice) in productos" :key="producto.id">
                <div class="ibox">
                    <div class="ibox-content product-box">
                        
                        <div class="">
                            <!-- Carrucel -->
                            <div :id="'carouselId-'+indice" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" role="listbox">
                                    <div class="carousel-item" v-for="(img, indice) in JSON.parse(producto.pictures)" :class="(indice == 0) ? 'active':''">
                                        <img class="d-block d-flex w-100" :src="img.url" alt="First slide" :id="'imgl-'+indice">
                                    </div>
                                    <div class="carousel-item" v-for="(img, index) in JSON.parse(producto.pictures)">
                                        <img class="d-block w-100" :src="img.url" alt="First slide" :id="'img-'+(index+10)">
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
                            <!-- Fin carrucel -->
                        </div>
                        
                        <div class="product-desc">
                            <span class="product-price">
                                ${{producto.price}}
                            </span>
                            <small class="text-muted">{{producto.condition}}</small>
                            <a href="#" class="product-name"> {{producto.title}}</a>



                            <div class="small m-t-xs">
                                Many desktop publishing packages and web page editors now.
                            </div>
                            <div class="m-t text-righ">
                                <a href="#" class="btn btn-xs btn-outline btn-primary">Info <i class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('productos/partials/modal') ?>
</div>
<?= $this->endSection() ?>
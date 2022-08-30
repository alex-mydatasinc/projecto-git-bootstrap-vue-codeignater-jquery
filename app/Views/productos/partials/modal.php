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
                 <?= $this->include('productos/partials/form_producto') ?>
             </div>
         </div>
     </div>
 </div>
<div class="container ">
    
    <ul class="list-group my-3" id="paises">
        <li class="list-group-item active">Paises</li>
        <?php foreach ($paises as $pais): ?>
                <li class="list-group-item disabled"><?= ($pais->name) ?></li>
        <?php endforeach ?>
    </ul>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
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
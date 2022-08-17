<div id="producto_vue">
    index productos
</div>

<script>
    let producto = new Vue({
        el: '#producto_vue',
        mounted() {
            this.get_productos_api()
        },
        methods: {
            get_productos_api(){
                $.ajax({
                    type: "get",
                    url: "<?= base_url('dashboard/productos/index'); ?>",
                    dataType: "json",
                    success: function (response) {
                        console.log(response)
                    }
                });
            }
        },
    })
</script>
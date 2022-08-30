<div class="container" id="login_vue">
    <div class="w-75 h-100 p-3 mx-auto align-middle rounded shadow-md bg-primary" style="height: 100%; background-color: rgba(255,0,0,0.1);">        
        <form @submit.prevent="submit_login()" class="align-middle">
            <div class="form-group">
              <label for="">Email</label>
              <input type="email" class="form-control"placeholder="Ingrese Email valido" v-model="user.email">
              <small id="emailHelpId" class="form-text text-muted">Help text</small>
            </div>
            <div class="form-group">
              <label for="">Password</label>
              <input type="password" class="form-control" placeholder="Ingrese su contraseña" v-model="user.password">
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
    </div>
</div>

<script>
    let login = new Vue({
        el: '#login_vue',
        data() {
            return {
                user: {
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
            submit_login(){
                $.ajax({
                    type: "post",
                    url: "<?= base_url(); ?>"+'/login',
                    data: this.user,
                    dataType: "json",
                    success: function (response) {
                        console.log(response)
                        if (response.state == 200) {
                            window.location.href = "<?= base_url('dashboard') ?>"
                        }
                    }
                });
            }            
        },
    })
</script>
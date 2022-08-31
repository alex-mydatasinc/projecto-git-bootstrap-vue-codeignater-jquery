<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Register</title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/assets/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/assets/css/animate.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown" id="register_vue">
        <div>
            <div>

                <h1 class="logo-name">IN+</h1>

            </div>
            <h3>Register to IN+</h3>
            <p>Create account to see it in action.</p>
            <form class="m-t" role="form" @submit.prevent="submit_register_save()">
                <div class="form-group">
                    <input type="text" v-model="user.name" class="form-control" placeholder="Name" required="">
                </div>
                <div class="form-group">
                    <input type="email" v-model="user.email" class="form-control" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <input type="password" v-model="user.password" class="form-control" placeholder="Password" required="">
                </div>
                <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Agree the terms and policy </label></div>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="login.html">Login</a>
            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/vue.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.js"></script>
    <!-- iCheck -->
    <script src="/assets/js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
        <script>
    let login = new Vue({
        el: '#register_vue',
        data() {
            return {
                user: {
                    name:'',
                    email: '',
                    password: ''
                }
            }
        },
        mounted() {
            let session = "<?= session()->get('login_in');?>"
            if (session) {
                window.location.href = "<?= base_url('dashboard/productos') ?>"
            }
        },
        methods: {
            submit_register_save(){
                $.ajax({
                    type: "post",
                    url: "auth/register",
                    data: this.user,
                    dataType: "json",
                    success: function (response) {
                        console.log(response)
                        if (response.state == 200) {
                            window.location.href = "<?= base_url('login_in') ?>"
                        }
                    }
                });
            }            
        },
    })
</script>
</body>

</html>

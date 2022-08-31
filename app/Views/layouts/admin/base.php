<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $this->renderSection('title') ?></title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/assets/css/animate.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/vue.js"></script>

</head>

<body>

    <div id="wrapper" id="producto_vue">

        <?= $this->include('layouts/admin/header') ?>

        <div id="page-wrapper" class="gray-bg">     
            <?= $this->include('layouts/admin/partials/nav') ?>
            <?= $this->include('layouts/admin/main') ?>
            <?= $this->include('layouts/admin/footer') ?>

        </div>
    </div>

    <!-- Mainly scripts -->
    
    <!-- <script src="/assets/js/jquery-3.1.1.min.js"></script> -->
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>


    <!-- Custom and plugin javascript -->
    <link rel="stylesheet" href="/assets/css/custom.css">
    <script src="/assets/js/inspinia.js"></script>
    <script src="/assets/js/plugins/pace/pace.min.js"></script>
    <!-- <script type="text/javascript" src="/assets/js/producto.js"></script> -->
    


</body>

</html>
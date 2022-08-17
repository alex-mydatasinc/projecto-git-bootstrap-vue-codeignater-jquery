<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
</head>
<body>
    
<ul class="nav justify-content-center">
    <li class="nav-item">
        <a class="nav-link active" href="<?= base_url('dashboard/productos') ?>">Productos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('pais') ?>">Categoria paises</a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled link</a>
    </li>
</ul>

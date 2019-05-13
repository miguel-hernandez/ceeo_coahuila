<?php if (!isset($titulo)) $titulo = ''; ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> COAHUILA - <?= $titulo ?> </title>

  <link rel="shortcut icon" href="<?= base_url('assets/img/logotipo1.png') ?>">

  <link rel="stylesheet" media="screen" href="<?= base_url('assets/bootstrap337/css/bootstrap.min.css') ?>" >
  <!-- <link rel="stylesheet" media="screen" href="<?= base_url('assets/sweetalert2/sweetalert2.min.css') ?>"> -->
  <link rel="stylesheet" media="screen" href="<?= base_url('assets/css/estilos-master.css') ?>">
  <link rel="stylesheet" media="screen" href="<?= base_url('assets/css/font-awesome.min.css') ?>">
  <link rel="stylesheet" media="screen" href="<?= base_url('assets/css/header.css') ?>">


  <script src="<?= base_url('assets/jquery-3.2.1.min.js') ?>"></script>
  <script src="<?= base_url('assets/jquery.validate.js') ?>"></script>
  <script src="<?= base_url('assets/bootstrap337/js/bootstrap.min.js') ?>"></script>
  <!-- <script src="<?= base_url('assets/sweetalert2/sweetalert2.min.js') ?>"></script> -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.js"></script>

  <!-- <script src="<?= base_url('assets/js/utils/messages.js') ?>"></script> -->
  <script src="<?= base_url('assets/js/utils/design.js') ?>"></script>
  <script src="<?= base_url('assets/js/utils/grid/grid.js') ?>"></script>
  <script src="<?= base_url('assets/js/utils/helpers.js') ?>"></script>

  <script type="text/javascript">
    $(document).ready(function () {
      base_url = live_url = "<?= base_url() ?>";
    });
  </script>

</head>

<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
        <a class="navbar-brand" href="#" style="display:block !important;">Nombre del proyecto</a>
      </div>
      <div class="collapse navbar-collapse navbar_master" id="myNavbar">
        <ul class="nav navbar-nav">
          <!--
          <li class="active"><a href="#">Home</a></li>
          <li><a href="#">Page 1</a></li>
          <li><a href="#">Page 2</a></li>
          <li><a href="#">Page 3</a></li>
        -->
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="<?= base_url('Login/logout') ?>"><?= $usuario ?> <i class="fa fa-sign-out"></i> </a></li>
          <!-- <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li> -->
        </ul>
      </div>
    </div>
  </nav>
  <!-- NAVBAR END -->

  <div class="modal" id="wait" data-backdrop="static">
    <center>
      <!-- <i class="fa fa-spinner" aria-hidden="true" style="font-size: 120px;"></i> -->
    </center>
  </div>

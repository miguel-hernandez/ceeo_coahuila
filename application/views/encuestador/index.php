<div class="container">

  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
      <label>Total: </label> <span id="encuestador_total"></span>
    </div><!-- .col-lg-6 -->

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
      <button id="btn_mostrar_encuesta" type="button" class="btn btn-primary btn-block">
        <i class="fa fa-eye"></i>
        Mostrar
      </button>
    </div><!-- .col-md-2 -->
    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
      <a href="<?= base_url('Encuesta/aplicar') ?>" type="button" class="btn btn-primary btn-block">
        <i class="fa fa-pencil"></i>
        Registrar
      </a>
    </div><!-- .col-md-2 -->
    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
      <button id="btn_editar_respuestas" type="button" class="btn btn-primary btn-block">
        <i class="fa fa-pencil-square-o"></i>
        Editar
      </a>
    </div><!-- .col-md-2 -->
    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
      <button id="btn_eliminar_encuesta" type="button" class="btn btn-primary btn-block">
        <i class="fa fa-trash"></i>
        Eliminar
      </a>
    </div><!-- .col-md-2 -->
  </div><!-- .row -->

  <div class="row margintop10">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div id="grid_encuestador"></div>
    </div><!-- .col-md-12  -->
  </div><!-- .row -->
</div><!-- .container -->


<script src="<?= base_url('assets/js/encuestador/encuestador.js') ?>"></script>

<div class="container">

  <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
          <label>Total: </label> <span id="encuestador_total"></span>
        </div>

      <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
        <button id="btn_visitador_mostrar" type="button" class="btn btn-primary btn-block">
            <i class="fa fa-eye"></i>
            Mostrar
        </button>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
        <a href="<?= base_url('Encuesta/aplicar') ?>" type="button" class="btn btn-primary btn-block">
          <i class="fa fa-pencil"></i>
          Registrar
        </a>
      </div>

  </div><!-- row -->

  <div class="row margintop10">
    <div class="col-xs-12">
      <div id="grid_encuestador"></div>
    </div>
  </div><!-- row -->
</div><!-- container -->


<script src="<?= base_url('assets/js/encuestador/encuestador.js') ?>"></script>

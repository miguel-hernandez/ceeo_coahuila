<!-- PREGUNTA_ABIERTA -->
<!-- PREGUNTA_OPCIONMULTIPLE -->

<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading bg-color-1 text-center">
      <h3 class="panel-title">Aplicar encuesta</h3>
    </div><!-- .panel-heading -->
    <div class="panel-body">

      <div id="div_contenedor_preguntas">


      <form action='savecuestionario' method='post' id='form_cuestionario_doc'>

      <?php foreach ($array_preguntas as $key => $pregunta) { ?>
        <div class="row margintop10">
            <div class='col-xs-12'>
              <label><?= $pregunta['npregunta'] ?>.- <?= $pregunta['pregunta'] ?></label>
            </div>
            <?php if($pregunta['idtipopregunta'] == PREGUNTA_ABIERTA){ ?>
              <div class='col-xs-12'>
                <textarea class='form-control requerido' rows='2' name="<?= $pregunta['idpregunta'] ?>"></textarea>
              </div>
            <?php } ?>
            <?php if($pregunta['idtipopregunta'] == PREGUNTA_OPCIONMULTIPLE){ ?>
              <?php foreach ($pregunta['array_complemento'] as $key => $complemento) { ?>
                <div class='col-xs-12'>
                <label class='checkbox-inline'>
                  <input class='requerido' type='checkbox' name="<?= $pregunta['idpregunta'] ?>" value='<?= $complemento['complemento'] ?>'> <?= $complemento['complemento'] ?>
                </label>
                <label id="label_<?= $pregunta['idpregunta'] ?>" class="error"></label>
                </div>
              <?php } ?>
            <?php } ?>

        </div><!-- .row -->
        <br>
      <?php } ?>

      <div class="row margintop10">
        <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'></div>
        <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2'>
          <a href="<?= base_url('Encuestador') ?>" class="btn btn-default btn-block">Regresar</a>
        </div>
        <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2'>
            <input type='submit' value='Guardar' class='btn btn-primary btn-block'>
        </div>

      </div><!-- .row -->

      </form>
      </div><!-- div_contenedor_preguntas -->

    </div><!-- .panel-body -->
  </div><!-- .panel -->

</div><!-- container -->

<script src="<?= base_url('assets/js/encuesta/aplicar.js') ?>"></script>

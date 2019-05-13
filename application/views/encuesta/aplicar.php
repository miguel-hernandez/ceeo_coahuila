<!-- PREGUNTA_ABIERTA -->
<!-- PREGUNTA_OPCIONMULTIPLE -->

<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading bg-color-1 text-center">
      <h3 class="panel-title">Aplicar encuesta</h3>
    </div><!-- .panel-heading -->
    <div class="panel-body">

      <div id="div_contenedor_preguntas">


      <form id='form_cuestionario_doc'>

      <?php $array_idpreguntas = array(); ?>

      <?php foreach ($array_preguntas as $key => $pregunta) { array_push($array_idpreguntas, $pregunta['idpregunta'].'/'.$pregunta['idtipopregunta'] ); ?>
        <div class="row margintop10">
            <div class='col-xs-12'>
              <label><?= $pregunta['npregunta'] ?>.- <?= $pregunta['pregunta'] ?></label>
            </div>
            <?php if($pregunta['idtipopregunta'] == PREGUNTA_ABIERTA){ ?>
              <div class='col-xs-12'>
                <textarea data-idpregunta="<?= $pregunta['idpregunta'] ?>" class='form-control requerido textarea_blur' rows='2' name="<?= $pregunta['idpregunta'] ?>"></textarea>
              </div>
            <?php } ?>
            <?php if($pregunta['idtipopregunta'] == PREGUNTA_OPCIONMULTIPLE){ ?>

              <?php foreach ($pregunta['array_complemento'] as $key => $complemento) { ?>
                <?php if($key == 0) { ?>
                  <input type="text" id="itxt_idpregunta_<?= $pregunta['idpregunta'] ?>" name="itxt_idpregunta_<?= $pregunta['idpregunta'] ?>" value="">
                <?php } ?>
                <div class='col-xs-12'>
                <label class='checkbox-inline'>
                  <input class='requerido checkbox_change' type='checkbox' data-idpregunta="<?= $pregunta['idpregunta'] ?>" name="<?= $pregunta['idpregunta'] ?>" value='<?= $complemento['complemento'] ?>'> <?= $complemento['complemento'] ?>
                </label>
                <label id="label_<?= $pregunta['idpregunta'] ?>" class="error"></label>
                </div>
              <?php } ?>
            <?php } ?>

        </div><!-- .row -->
        <br>
      <?php } ?>

      <?php $separado_por_comas1 = implode(",", $array_idpreguntas); ?>
      <input type="text" id="itxt_idpreguntas" value="<?= $separado_por_comas1 ?>">

      <div class="row margintop10">
        <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'></div>
        <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2'>
          <a href="<?= base_url('Encuestador') ?>" class="btn btn-default btn-block">Regresar</a>
        </div>
        <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2'>
            <button id="btn_encuesta_guardar" type='button' class='btn btn-primary btn-block'>Guardar</button>
        </div>

      </div><!-- .row -->

      </form>
      </div><!-- div_contenedor_preguntas -->

    </div><!-- .panel-body -->
  </div><!-- .panel -->

</div><!-- container -->

<script type="text/javascript">
  $(document).ready(function () {
    let str = $("#itxt_idpreguntas").val();
    array_ids = str.split(",");
    array_ids_ok = [];

    for (var i = 0; i < array_ids.length; i++) {
      let array_aux = new Object();
      let todo = array_ids[i];
      let arr_todo = todo.split("/");
      let idpregunta = arr_todo[0];
      let tipo = arr_todo[1];
      array_aux["tipo"] = tipo;
      array_aux["idpregunta"] = idpregunta;
      array_aux["valores"] = [];
      array_ids_ok.push(array_aux);
    }

  });
</script>

<script src="<?= base_url('assets/js/encuesta/aplicar.js') ?>"></script>

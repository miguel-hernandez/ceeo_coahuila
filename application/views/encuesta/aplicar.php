<!-- PREGUNTA_ABIERTA -->
<!-- PREGUNTA_OPCIONMULTIPLE -->

<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading bg-color-1 text-center">
      <h3 class="panel-title">Levantamiento de requerimiento</h3>
    </div><!-- .panel-heading -->
    <div class="panel-body">

      <div id="div_contenedor_preguntas">


      <form id='form_cuestionario_doc' enctype="multipart/form-data">

      <?php $array_idpreguntas = array(); ?>

      <?php foreach ($array_preguntas as $key => $pregunta) { array_push($array_idpreguntas, $pregunta['idpregunta'].'/'.$pregunta['idtipopregunta'] ); ?>
        <div class="row margintop10">
            <div class='col-xs-12'>
              <label><?= $pregunta['npregunta'] ?>.- <?= $pregunta['pregunta'] ?></label> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?= $pregunta['instructivo'] ?>"></i>
            </div>
            <?php if($pregunta['idtipopregunta'] == PREGUNTA_ABIERTA){ ?>
              <?php if ($pregunta['npregunta']==17){?>
                <div class='col-xs-12'>
                  <textarea data-idpregunta="<?= $pregunta['idpregunta'] ?>" class='form-control textarea_blur' rows='2' name="<?= $pregunta['idpregunta'] ?>"></textarea>
                </div>
              <?php } else {?>
              <div class='col-xs-12'>
                <textarea data-idpregunta="<?= $pregunta['idpregunta'] ?>" class='form-control requerido textarea_blur' rows='2' name="<?= $pregunta['idpregunta'] ?>"></textarea>
              </div>
            <?php } } ?>
            <?php if($pregunta['idtipopregunta'] == PREGUNTA_OPCIONMULTIPLE){ ?>

              <?php foreach ($pregunta['array_complemento'] as $key => $complemento) { ?>
                <div class='col-xs-12'>
                  <?php if($key==0)  { ?>
                  <input type="hidden" id="itxt_aplicar_idpregunta_<?= $pregunta['idpregunta'] ?>" name="itxt_aplicar_idpregunta_<?= $pregunta['idpregunta'] ?>" value="">
                <?php } ?>
                <label class='checkbox-inline'>
                  <input class='requerido checkbox_change' type='checkbox' data-idpregunta="<?= $pregunta['idpregunta'] ?>" name="<?= $pregunta['idpregunta'] ?>" value='<?= $complemento['complemento'] ?>'> <?= $complemento['complemento'] ?>
                </label>
                <label id="label_<?= $pregunta['idpregunta'] ?>" class="error"></label>
                </div>
              <?php } ?>
            <?php } ?>

            <?php if($pregunta['idtipopregunta'] == PREGUNTA_UNAOPCION){ ?>

              <?php foreach ($pregunta['array_complemento'] as $key => $complemento) { ?>
                <div class='col-xs-12'>
                  <?php if($key==0)  { ?>
                  <input type="hidden" id="itxt_aplicar_idpregunta_<?= $pregunta['idpregunta'] ?>" name="itxt_aplicar_idpregunta_<?= $pregunta['idpregunta'] ?>" value="">
                <?php } ?>
                <label class='checkbox-inline'>
                  <input class='requerido checkbox_change' type='radio' data-idpregunta="<?= $pregunta['idpregunta'] ?>" name="<?= $pregunta['idpregunta'] ?>" value='<?= $complemento['complemento'] ?>'> <?= $complemento['complemento'] ?>
                </label>
                <label id="label_<?= $pregunta['idpregunta'] ?>" class="error"></label>
                </div>
              <?php } ?>
            <?php } ?>

        </div><!-- .row -->
        <br>
      <?php } ?>

      <?php $separado_por_comas1 = implode(",", $array_idpreguntas); ?>
      <input type="hidden" id="itxt_idpreguntas" value="<?= $separado_por_comas1 ?>">

      <!-- <iframe class="img-fluid" alt="Responsive image" id="image_aplicar" name="image_aplicar" src="" ></iframe> -->
      <iframe id="image_aplicar" name="image_aplicar" src="" width="100%" height="500" style="border: none;"></iframe>
      <input type="file" id="ifile_aplicar" name="ifile_aplicar" value="" class="image">

      <div class="row margintop10">
        <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'></div>
        <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2'>
          <a href="<?= base_url('Encuestador') ?>" class="btn btn-info btn-block">Regresar</a>
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
      array_aux["valores_string"] = '';
      array_ids_ok.push(array_aux);
    }


    let array_aux_file = new Object();
    array_aux_file["tipo"] = 'archivo';
    array_aux_file["archivo"] = '';
    array_ids_ok.push(array_aux_file);

  });
</script>

<script src="<?= base_url('assets/js/encuesta/aplicar.js') ?>"></script>

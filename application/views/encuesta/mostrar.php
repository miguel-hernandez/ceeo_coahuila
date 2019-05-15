<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading bg-color-1 text-center">
      <h3 class="panel-title">Mostrar requerimiento</h3>
    </div><!-- .panel-heading -->
    <div class="panel-body">

      <?php foreach ($array_datos as $key => $dato) { ?>
        <div class="row margintop10">
            <div class='col-xs-12'>
              <label><?= $dato['npregunta'] ?>.- <?= $dato['pregunta'] ?></label>
            </div>
            <?php if($dato['idtipopregunta'] == PREGUNTA_ABIERTA){ ?>
              <div class='col-xs-12'>
                <textarea class='form-control' rows='2' readonly><?= $dato['respuesta'] ?></textarea>
              </div><!-- .col-xs-12 -->
            <?php } ?>
            <?php if($dato['idtipopregunta'] == PREGUNTA_OPCIONMULTIPLE){ ?>
              <!--  -->
              <?php foreach ($dato['array_final'] as $key => $opcion) { ?>
                <div class='col-xs-12'>
                <label class='checkbox-inline'>
                  <input disabled class='requerido' type='checkbox' <?= ( (isset($opcion['checked'])) && (strlen($opcion['checked'])>0) )?'checked':'' ?> > <?= $opcion['complemento'] ?>
                </label>
                </div>
              <?php } ?>
              <!--  -->
            <?php } ?>

        </div><!-- .row -->
        <br>
      <?php } ?>

      <div class="row margintop10">
      <?php
          $porciones = explode(".", $file_path);
          $extension = $porciones[1];

          if( ($extension == 'pdf') || $extension == 'PDF' ){ ?>
              <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'>
                <label>Archivo adjunto:</label><br>
                <iframe src="https://docs.google.com/viewer?url=<?= base_url($file_path) ?>&embedded=true" width="100%" height="500" style="border: none;"></iframe>
              </div><!-- .col-lg-8 -->
          <?php }else { ?>
            <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'>
              <label>Archivo adjunto:</label><br>
              <img src="<?= base_url($file_path) ?>" class="img-responsive">
            </div><!-- .col-lg-8 -->
          <?php } ?>
        <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'></div>
      </div><!-- .row -->


      <div class="row margintop10">
        <div class='col-xs-12 col-sm-12 col-md-10 col-lg-10'></div>
        <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2'>
          <a href="<?= base_url('Encuestador') ?>" class="btn btn-default btn-block">Regresar</a>
        </div>
      </div><!-- .row -->

    </div><!-- .panel-body -->
  </div><!-- .panel -->

</div><!-- container -->

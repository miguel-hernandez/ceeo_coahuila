<style type="text/css">
  .ocultar{
    display: none;
  }
</style>
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading bg-color-1 text-center">
      <h3 class="panel-title">Mostrar requerimiento / <?=$nombreUsuario?></h3>
    </div><!-- .panel-heading -->
    <div class="panel-body">

      <?php foreach ($array_datos as $key => $dato) {?>
        <div class="row margintop10">
          <div class='col-xs-12'>
            <label><?= $dato['npregunta'] ?>.- <?= $dato['pregunta'] ?></label> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?= $dato['instructivo'] ?>"></i>
          </div>
          <?php if($dato['idtipopregunta'] == PREGUNTA_ABIERTA){ ?>
            <div class='col-xs-12'>
              <textarea class='form-control' style="height: 120px;" rows='2' readonly><?= (isset($dato['respuesta']))?$dato['respuesta']:'' ?></textarea>
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

          <?php if($dato['idtipopregunta'] == PREGUNTA_UNAOPCION){ ?>
            <!--  -->
            <?php foreach ($dato['array_final'] as $key => $opcion) { ?>
              <div class='col-xs-12'>
                <label class='checkbox-inline'>
                  <input disabled class='requerido' type='radio' <?= ( (isset($opcion['checked'])) && (strlen($opcion['checked'])>0) )?'checked':'' ?> > <?= $opcion['complemento'] ?>
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
          <!-- <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'> -->
            <div class='col-xs-5 col-sm-5 col-md-5 col-lg-5'>
              <label>Archivo adjunto:</label><br>
              <iframe src="https://docs.google.com/viewer?url=<?= base_url($file_path) ?>&embedded=true" width="100%" height="500" style="border: none;"></iframe>
            </div><!-- .col-lg-8 -->
          <?php }else { ?>
            <!-- <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'> -->
              <div class='col-xs-5 col-sm-5 col-md-5 col-lg-5'>
                <label>Archivo adjunto:</label><br>

                <a href="<?= base_url($file_path) ?>" target="_blank"><img src="<?= base_url($file_path) ?>" class="img-responsive"></a>

              </div><!-- .col-lg-8 -->           
            <?php } ?>
            <?php if ($tipoUsuario == 'ADMINISTRADOR') { ?>
              <?php foreach ($array_observaciones as $key => $adminDatos){ ?>

                <!-- sección nueva de administrador -->
                <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <input type="number" id="idaplicar" value="<?=$idaplicar;?>" style="display: none;">
                     <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'>
                      <label>Tema</label>
                      <br>
                      <?php if ($adminDatos['tema'] == null){ ?>

                        <select id="temaSelect"  class="selectpicker">
                          <option name="tema" value="1">Administración de Personal</option>
                          <option name="tema" value="2">Participación Social</option>
                          <option name="tema" value="3">Gestión Escolar</option>
                          <option name="tema" value="4">Recursos Materiales</option>
                          <option name="tema" value="5">Planeación y Estadística</option>
                          <option name="tema" value="6">Protección Civil</option>
                          <option name="tema" value="7">Recursos Financieros</option>
                          <option name="tema" value="8">Programas Federales</option>
                          <option name="tema" value="9">Control Escolar</option>
                          <option name="tema" value="10">Cooperativas y Tiendas Escolares</option>

                        </select>
                      <?php } else { ?>
                        <select id="temaSelect"  class="selectpicker">
                          <?php switch ($adminDatos['tema']) {
                            case '1': ?>
                            <option name="tema" value="1" selected>Administración de Personal</option>
                            <option name="tema" value="2">Participación Social</option>
                            <option name="tema" value="3">Gestión Escolar</option>
                            <option name="tema" value="4">Recursos Materiales</option>
                            <option name="tema" value="5">Planeación y Estadística</option>
                            <option name="tema" value="6">Protección Civil</option>
                            <option name="tema" value="7">Recursos Financieros</option>
                            <option name="tema" value="8">Programas Federales</option>
                            <option name="tema" value="9">Control Escolar</option>
                            <option name="tema" value="10">Cooperativas y Tiendas Escolares</option>
                            <?php break;
                            case '2': ?>
                            <option name="tema" value="1">Administración de Personal</option>
                            <option name="tema" value="2" selected>Participación Social</option>
                            <option name="tema" value="3">Gestión Escolar</option>
                            <option name="tema" value="4">Recursos Materiales</option>
                            <option name="tema" value="5">Planeación y Estadística</option>
                            <option name="tema" value="6">Protección Civil</option>
                            <option name="tema" value="7">Recursos Financieros</option>
                            <option name="tema" value="8">Programas Federales</option>
                            <option name="tema" value="9">Control Escolar</option>
                            <option name="tema" value="10">Cooperativas y Tiendas Escolares</option>
                            <?php break;
                            case '3': ?>
                            <option name="tema" value="1">Administración de Personal</option>
                            <option name="tema" value="2">Participación Social</option>
                            <option name="tema" value="3" selected>Gestión Escolar</option>
                            <option name="tema" value="4">Recursos Materiales</option>
                            <option name="tema" value="5">Planeación y Estadística</option>
                            <option name="tema" value="6">Protección Civil</option>
                            <option name="tema" value="7">Recursos Financieros</option>
                            <option name="tema" value="8">Programas Federales</option>
                            <option name="tema" value="9">Control Escolar</option>
                            <option name="tema" value="10">Cooperativas y Tiendas Escolares</option>
                            <?php break;
                            case '4': ?>
                            <option name="tema" value="1">Administración de Personal</option>
                            <option name="tema" value="2">Participación Social</option>
                            <option name="tema" value="3">Gestión Escolar</option>
                            <option name="tema" value="4" selected>Recursos Materiales</option>
                            <option name="tema" value="5">Planeación y Estadística</option>
                            <option name="tema" value="6">Protección Civil</option>
                            <option name="tema" value="7">Recursos Financieros</option>
                            <option name="tema" value="8">Programas Federales</option>
                            <option name="tema" value="9">Control Escolar</option>
                            <option name="tema" value="10">Cooperativas y Tiendas Escolares</option>
                            <?php break;
                            case '5': ?>
                            <option name="tema" value="1">Administración de Personal</option>
                            <option name="tema" value="2">Participación Social</option>
                            <option name="tema" value="3">Gestión Escolar</option>
                            <option name="tema" value="4">Recursos Materiales</option>
                            <option name="tema" value="5" selected>Planeación y Estadística</option>
                            <option name="tema" value="6">Protección Civil</option>
                            <option name="tema" value="7">Recursos Financieros</option>
                            <option name="tema" value="8">Programas Federales</option>
                            <option name="tema" value="9">Control Escolar</option>
                            <option name="tema" value="10">Cooperativas y Tiendas Escolares</option>
                            <?php break;
                            case '6': ?>
                            <option name="tema" value="1">Administración de Personal</option>
                            <option name="tema" value="2">Participación Social</option>
                            <option name="tema" value="3">Gestión Escolar</option>
                            <option name="tema" value="4">Recursos Materiales</option>
                            <option name="tema" value="5">Planeación y Estadística</option>
                            <option name="tema" value="6" selected>Protección Civil</option>
                            <option name="tema" value="7">Recursos Financieros</option>
                            <option name="tema" value="8">Programas Federales</option>
                            <option name="tema" value="9">Control Escolar</option>
                            <option name="tema" value="10">Cooperativas y Tiendas Escolares</option>
                            <?php break;
                            case '7': ?>
                            <option name="tema" value="1">Administración de Personal</option>
                            <option name="tema" value="2">Participación Social</option>
                            <option name="tema" value="3">Gestión Escolar</option>
                            <option name="tema" value="4">Recursos Materiales</option>
                            <option name="tema" value="5">Planeación y Estadística</option>
                            <option name="tema" value="6">Protección Civil</option>
                            <option name="tema" value="7" selected>Recursos Financieros</option>
                            <option name="tema" value="8">Programas Federales</option>
                            <option name="tema" value="9">Control Escolar</option>
                            <option name="tema" value="10">Cooperativas y Tiendas Escolares</option>
                            <?php break;
                            case '8': ?>
                            <option name="tema" value="1">Administración de Personal</option>
                            <option name="tema" value="2">Participación Social</option>
                            <option name="tema" value="3">Gestión Escolar</option>
                            <option name="tema" value="4">Recursos Materiales</option>
                            <option name="tema" value="5">Planeación y Estadística</option>
                            <option name="tema" value="6">Protección Civil</option>
                            <option name="tema" value="7">Recursos Financieros</option>
                            <option name="tema" value="8" selected>Programas Federales</option>
                            <option name="tema" value="9">Control Escolar</option>
                            <option name="tema" value="10">Cooperativas y Tiendas Escolares</option>
                            <?php break;
                            case '9': ?>
                            <option name="tema" value="1">Administración de Personal</option>
                            <option name="tema" value="2">Participación Social</option>
                            <option name="tema" value="3">Gestión Escolar</option>
                            <option name="tema" value="4">Recursos Materiales</option>
                            <option name="tema" value="5">Planeación y Estadística</option>
                            <option name="tema" value="6">Protección Civil</option>
                            <option name="tema" value="7">Recursos Financieros</option>
                            <option name="tema" value="8">Programas Federales</option>
                            <option name="tema" value="9" selected>Control Escolar</option>
                            <option name="tema" value="10">Cooperativas y Tiendas Escolares</option>
                            <?php break;
                            case '10': ?>
                            <option name="tema" value="1">Administración de Personal</option>
                            <option name="tema" value="2">Participación Social</option>
                            <option name="tema" value="3">Gestión Escolar</option>
                            <option name="tema" value="4">Recursos Materiales</option>
                            <option name="tema" value="5">Planeación y Estadística</option>
                            <option name="tema" value="6">Protección Civil</option>
                            <option name="tema" value="7">Recursos Financieros</option>
                            <option name="tema" value="8">Programas Federales</option>
                            <option name="tema" value="9">Control Escolar</option>
                            <option name="tema" value="10" selected>Cooperativas y Tiendas Escolares</option>
                            <?php break;
                          } ?>
                        </select>
                      <?php } ?>
                    </div>
                    <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'>
                      <label>¿Quién llena el requerimiento?</label>
                      <br>
                      <?php if ($adminDatos['responsableDocumento'] == null){ ?>

                        <select id="encuestadoSelect"  class="selectpicker">
                          <option name="encuestado" value="1">El interesado</option>
                          <option name="encuestado" value="2">El director(a)</option>
                          <option name="encuestado" value="3">El padre de familia</option>
                          <option name="encuestado" value="4">El supervisor</option>
                          <option name="encuestado" value="5">Personal de la Secretría</option>
                          <option name="encuestado" value="6">Otro</option>
                          <input type="text" class="ocultar" id="encuestadoOtro">
                        </select>
                      <?php } else { ?>
                        <select id="encuestadoSelect"  class="selectpicker">
                          <?php switch ($adminDatos['responsableDocumento']) {
                            case '1': ?>
                            <option name="encuestado" value="1" selected>El interesado</option>
                            <option name="encuestado" value="2">El director(a)</option>
                            <option name="encuestado" value="3">El padre de familia</option>
                            <option name="encuestado" value="4">El supervisor</option>
                            <option name="encuestado" value="5">Personal de la Secretría</option>
                            <option name="encuestado" value="6">Otro</option> 
                            <input type="text" id="encuestadoOtro" class="ocultar" value="<?=$adminDatos['otroResponsable']?>">
                            <?php break;
                            case '2': ?>
                            <option name="encuestado" value="1">El interesado</option>
                            <option name="encuestado" value="2" selected>El director(a)</option>
                            <option name="encuestado" value="3">El padre de familia</option>
                            <option name="encuestado" value="4">El supervisor</option>
                            <option name="encuestado" value="5">Personal de la Secretría</option>
                            <option name="encuestado" value="6">Otro</option>
                            <input type="text" id="encuestadoOtro" class="ocultar" value="<?=$adminDatos['otroResponsable']?>">
                            <?php break;
                            case '3': ?>
                            <option name="encuestado" value="1">El interesado</option>
                            <option name="encuestado" value="2">El director(a)</option>
                            <option name="encuestado" value="3" selected>El padre de familia</option>
                            <option name="encuestado" value="4">El supervisor</option>
                            <option name="encuestado" value="5">Personal de la Secretría</option>
                            <option name="encuestado" value="6">Otro</option>
                            <input type="text" id="encuestadoOtro" class="ocultar" value="<?=$adminDatos['otroResponsable']?>">
                            
                            <?php break;
                            case '4': ?>
                            <option name="encuestado" value="1">El interesado</option>
                            <option name="encuestado" value="2">El director(a)</option>
                            <option name="encuestado" value="3">El padre de familia</option>
                            <option name="encuestado" value="4" selected>El supervisor</option>
                            <option name="encuestado" value="5">Personal de la Secretría</option>
                            <option name="encuestado" value="6">Otro</option>
                            <input type="text" id="encuestadoOtro" class="ocultar" value="<?=$adminDatos['otroResponsable']?>">
                            <?php break;
                            case '5': ?>
                            <option name="encuestado" value="1">El interesado</option>
                            <option name="encuestado" value="2">El director(a)</option>
                            <option name="encuestado" value="3">El padre de familia</option>
                            <option name="encuestado" value="4">El supervisor</option>
                            <option name="encuestado" value="5" selected>Personal de la Secretría</option>
                            <option name="encuestado" value="6">Otro</option>
                            <input type="text" id="encuestadoOtro" class="ocultar" value="<?=$adminDatos['otroResponsable']?>">
                            <?php break;
                            case '6': ?>
                            <option name="encuestado" value="1">El interesado</option>
                            <option name="encuestado" value="2">El director(a)</option>
                            <option name="encuestado" value="3">El padre de familia</option>
                            <option name="encuestado" value="4">El supervisor</option>
                            <option name="encuestado" value="5">Personal de la Secretría</option>
                            <option name="encuestado" value="6" selected>Otro</option>
                            <input type="text" id="encuestadoOtro" value="<?=$adminDatos['otroResponsable']?>">
                            <?php break;

                          } ?>
                        </select>
                      <?php } ?>
                    </div>
                    <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'>
                      <label>Acción de mejora</label>
                      <br>
                      <?php if ($adminDatos['tema'] == null){ ?>

                        <select id="accionSelect"  class="selectpicker">
                          <option name="accion" value="1">Conservar</option>
                          <option name="accion" value="2">Eliminar</option>
                          <option name="accion" value="3">Fusionar</option>
                          <option name="accion" value="4">Automatizar</option>
                          <option name="accion" value="5">Compactar</option>
                        </select>
                      <?php } else { ?>
                        <select id="accionSelect"  class="selectpicker">
                          <?php switch ($adminDatos['tema']) {
                            case '1': ?>
                            <option name="accion" value="1" selected>Conservar</option>  
                            <option name="accion" value="2">Eliminar</option>
                            <option name="accion" value="3">Fusionar</option>
                            <option name="accion" value="4">Automatizar</option> 
                            <option name="accion" value="5">Compactar</option>  
                            <?php break;
                            case '2': ?>
                            <option name="accion" value="1">Conservar</option>
                            <option name="accion" value="2" selected>Eliminar</option>
                            <option name="accion" value="3">Fusionar</option>
                            <option name="accion" value="4">Automatizar</option>
                            <option name="accion" value="5">Compactar</option>
                            <?php break;
                            case '3': ?>
                            <option name="accion" value="1">Conservar</option>
                            <option name="accion" value="2">Eliminar</option>
                            <option name="accion" value="3" selected>Fusionar</option>
                            <option name="accion" value="4">Automatizar</option>
                            <option name="accion" value="5">Compactar</option>
                            <?php break;
                            case '4': ?>
                            <option name="accion" value="1">Conservar</option>  
                            <option name="accion" value="2">Eliminar</option>
                            <option name="accion" value="3">Fusionar</option>
                            <option name="accion" value="4" selected>Automatizar</option>
                            <option name="accion" value="5">Compactar</option>
                            <?php break;
                            case '5': ?>
                            <option name="accion" value="1">Conservar</option>  
                            <option name="accion" value="2">Eliminar</option>
                            <option name="accion" value="3">Fusionar</option>
                            <option name="accion" value="4">Automatizar</option>
                            <option name="accion" value="5" selected>Compactar</option>
                            <?php break;
                          } ?>
                        </select>
                      <?php } ?>
                    </div>
                    
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                      <br>
                    <label>Especificar Acción</label>
                    <textarea type="text" id="especificacionAccion" style="height: 100px;" class="form-control textarea_blur"><?=$adminDatos['especificarMejora']?></textarea>
                    <label>Justificación de la Acción de Mejora</label>
                    <textarea type="text" id="justificacionAccion" style="height: 100px;"  class="form-control textarea_blur"><?=$adminDatos['justificarMejora']?></textarea>
                    <label>Notas adicionales</label>
                    <textarea type="text" id="notasAdicionales" style="height: 100px;"  class="form-control textarea_blur"><?=$adminDatos['notasAdicionales']?></textarea>
                    <br>
                  </div>
                    <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'>
                      <a id="guardarNotas" class="btn btn-info btn-block">Guardar</a>
                    </div>
                  </div>
                </div> 
                <!-- sección nueva de administrador -->
              <?php } ?>
            <?php } ?>
            <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'></div>
          </div><!-- .row -->


          <div class="row margintop10">
            <div class='col-xs-12 col-sm-12 col-md-10 col-lg-10'></div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2'>
              <?php   if ($tipoUsuario == 'ADMINISTRADOR' ) { ?>

                <a href="<?= base_url('Administrador') ?>" class="btn btn-info btn-block">Regresar</a>
              <?php } else {?>
                <a href="<?= base_url('Encuestador') ?>" class="btn btn-info btn-block">Regresar</a>
              <?php } ?>
            </div>
          </div><!-- .row -->

        </div><!-- .panel-body -->
      </div><!-- .panel -->

    </div><!-- container -->

    <script type="text/javascript">

      $('#encuestadoSelect').change(function() {
        encuestado = $('#encuestadoSelect').val();
        console.log(encuestado);
         if (encuestado == 6) {
        $('#encuestadoOtro').removeClass('ocultar');
        }else{
         $('#encuestadoOtro').addClass('ocultar'); 
        }

      });

      $('#guardarNotas').click(function () {
        accion = $('#accionSelect').val();
        encuestado = $('#encuestadoSelect').val();
        especificacion = $('#especificacionAccion').val();
        justificacion = $('#justificacionAccion').val();
        notas = $('#notasAdicionales').val();
        idaplicar = $('#idaplicar').val();
        encuestadoOtro = null;
        tema = $('#temaSelect').val();

        if (encuestado == 6) {
        $('#encuestadoOtro').removeClass('ocultar');
        encuestadoOtro = $('#encuestadoOtro').val();
        }

        console.log(encuestadoOtro);

        var ruta = base_url+"Administrador/guardarNotas";
        $.ajax({
          url: ruta,
          type: 'POST',
          data: {accion:accion, especificacion:especificacion, justificacion:justificacion,notas:notas, encuestado:encuestado, encuestadoOtro:encuestadoOtro, tema:tema, idaplicar:idaplicar},
          success : function(data) {
           bootbox.alert('Se guardaron correctamente las observaciones', function(){
            window.location.href = base_url+"encuesta/"+idaplicar;
          });
         }
       });


      });
    </script>
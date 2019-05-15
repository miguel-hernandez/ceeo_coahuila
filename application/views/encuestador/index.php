<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <label>Favor de registrar los formatos indispensables y obligatorios</label>
    </div><!-- .col-lg-12 -->
  </div><!-- .row -->

  <div class="row margintop10">
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
  <!-- <hr> -->
  <div class="row margintop10">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div id="grid_encuestador"></div>
    </div><!-- .col-md-12  -->
  </div><!-- .row -->
</div><!-- .container -->

<div id="exampleModal_ver_evidencia" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header  bgcolor-2">
        <h5 class="modal-title color-6" id="exampleModalLongTitle">Archivo evidencia</h5>
        <button type="button" class="close color-6" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe id="iframe_cont" src="" width="100%" height="100%"></iframe>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
 function ver_ev(id_aplica){

   var ruta = base_url+"Encuesta/get_arch_evidencia";
   $.ajax({
     async: true,
     url: ruta,
     method: 'POST',
     data: {"id_aplica":id_aplica},
     beforeSend: function( xhr ) {
       $("#wait").modal("show");
     }
   })
   .done(function( data ) {
     // console.log(data);
     $("#wait").modal("hide");

     $("#iframe_cont").empty();
     // $("#iframe_cont").append(data.result);
     $("#iframe_cont").prop("src", data.result);

      $("#exampleModal_ver_evidencia").modal("show");

   })
   .fail(function(jqXHR, textStatus, errorThrown) {
     // console.error("Error in read()"); console.table(e);
     $("#wait").modal("hide"); Helpers.error_ajax(jqXHR, textStatus, errorThrown);
   });

  };
</script>

<script src="<?= base_url('assets/js/encuestador/encuestador.js') ?>"></script>

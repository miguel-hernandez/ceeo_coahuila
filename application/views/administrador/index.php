<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<center><h2>Sistema de seguimiento CEEO</h2></center>

			<div id="tabla_usuario">
				<?php foreach ($subsecretaria as $key => $value) { ?>

					<!-- Acordeón -->
					<?php if ($value['idsubsecretaria'] == 1 ): ?>
						<div class="accordion bg-success" id="accordionExample">
					<?php endif ?>
					<?php if ($value['idsubsecretaria'] == 2 ): ?>
						<div class="accordion bg-warning" id="accordionExample">
					<?php endif ?>
					<?php if ($value['idsubsecretaria'] == 3 ): ?>
						<div class="accordion bg-info" id="accordionExample">
					<?php endif ?>
						<div class="card">
							<div class="card-header" id="headingOne">
								<h5 class="mb-0">
									<button class="btn btn-link" onclick="traerUsuarios(<?=  $value['idsubsecretaria']?>)" type="button" data-toggle="collapse" data-target="#collapse<?= $value['idsubsecretaria']?>" aria-expanded="true" aria-controls="collapse<?= $value['idsubsecretaria']?>">
											<p><?= $value['subsecretaria']?></p>										
									</button>
								</h5>
							</div>

							<div id="collapse<?= $value['idsubsecretaria']?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
								<div id="card<?=$value['idsubsecretaria']?>" class="card-body">
									
								</div>
							</div>
						</div>
					</div>
					<!-- fin Acordeón -->

				<?php } ?>
			</div>

			<div id="exampleModal_ver_evidencia" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header  bgcolor-2">
        <button type="button" class="close color-6" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <center>
        <h4 class="modal-title color-6" id="exampleModalLongTitle">Archivo evidencia</h4>
        <h5>Nombre del documento: <label id="n_formato"></label></h5>
      </center>

      </div>
      <div class="modal-body">
        <iframe id="iframe_cont" src="" width="100%" height="500px"></iframe>
      </div>
    </div>
  </div>
</div>


		</div>
	</div><!-- row -->
</div><!-- container-fluid -->

<script type="text/javascript">
	function traerUsuarios(id) {
		$.ajax({
			url: 'Administrador/getUsuario',
			type: 'POST',
			data: {id: id},
			success : function(data) {
				$('#card'+id).html(data);
			}
		});		
	}

	function traerArchivos(id) {
		$.ajax({
			url: 'Administrador/getArchivos',
			type: 'POST',
			data: {id: id},
			success : function(data) {
				$('#archivos'+id).html(data);
			}
		});		
	}

	function mostrar_encuesta(idaplicar, usuario) {
		 let form = document.createElement("form");

    form.name="form_mostrar";
    form.method = "POST";
    form.target = "_parent";
    form.action = base_url+"encuesta/"+idaplicar;
    document.body.appendChild(form);
    form.submit();
	}

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
     $("#wait").modal("hide");

     $("#iframe_cont").empty();
     $("#iframe_cont").append(data.result);
     $("#iframe_cont").prop("src", data.result);
     $("#n_formato").empty();
     $("#n_formato").html(data.nombre);


      $("#exampleModal_ver_evidencia").modal("show");

   })
   .fail(function(jqXHR, textStatus, errorThrown) {
     console.error("Error in read()"); console.table(e);
     $("#wait").modal("hide"); Helpers.error_ajax(jqXHR, textStatus, errorThrown);
   });

  };

  function eliminar_ev(idaplicar,iduser) {
  	ruta = base_url+'Administrador/eliminar_req';
  	$.ajax({
  		url: ruta,
  		type: 'POST',
  		dataType: 'json',
  		data: {id: idaplicar},
  		 beforeSend: function( xhr ) {
       $("#wait").modal("show");
     }
  	})
  	.done(function(data) {
  		if (data) {
  		alert('El requerimiento se ha eliminado exitosamente');
  		traerArchivos(iduser);
  		// console.log($('#p' + iduser).text());
  		}else{
  		alert('Error al eliminar');
  		}

  		 $("#wait").modal("hide");
  	})
  	 .fail(function(jqXHR, textStatus, errorThrown) {
     console.error("Error in read()"); console.table(e);
     $("#wait").modal("hide"); Helpers.error_ajax(jqXHR, textStatus, errorThrown);
   });  	
  }

  function editar_ev(idaplicar) {
  	 let form = document.createElement("form");

    form.name="form_editar";
    form.method = "POST";
    form.target = "_parent";

    form.action = base_url+"encuesta/edith/"+idaplicar;
    document.body.appendChild(form);
    form.submit();

    

  }
</script>
<!-- <script src="<?= base_url('assets/js/administrador/administrador.js') ?>"></script> -->
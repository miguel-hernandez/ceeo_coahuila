<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12">
      <center><h2>Sistema de seguimiento CEEO</h2></center>
      
      <?php foreach ($tabla as $key => $value) { 
      	$archivo = substr($value['archivos'],16);
	  ?>
      <!-- inicio acordeon -->
      <div id="accordion">
  		<div class="card">
  		  <div class="card-header" id="headingOne">
  		    <h5 class="mb-0">
  		      <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?=$value['idusuario']?>" aria-expanded="true" aria-controls="collapse<?=$value['idusuario']?>">
  		        <p><?= $value['usuario']; ?> <b> Total: <?= $value['total']; ?> </b></p>
  		      </button>
  		    </h5>
  		  </div>
		
		  <div id="collapse<?=$value['idusuario']?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
		  	<div class="card-body">
		      <table class="table">
		      	<thead>
		      		<tr>
		      			<th scope="col">Usuario</th>
		      			<th scope="col">Documento</th>
						<th scope="col">Fecha de creación</th>
					</tr>
		      	</thead>
		      	<tbody>
		      		<tr>
		      			<td><?= $value['username'] ?></td>
		      			<td><?= $archivo?></td>
		      			<td><?= $value['fcreacion']?></td>
		      		</tr>
		      	</tbody>
		      </table>
		    </div>
		  </div>
		 </div>
		</div>
  		<?php } ?>
      <!-- fin acordeon -->
    </div>
  </div><!-- row -->
</div><!-- container-fluid -->

<script type="text/javascript" src="">
	
	$('#myCollapsible').collapse({
  toggle: false
})

</script> 
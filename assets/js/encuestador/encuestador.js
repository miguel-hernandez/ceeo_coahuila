/* jshint esversion: 6 */
$(function() {
  Encuesta.listar();
});

$("#btn_mostrar_encuesta").click(function(e){
  e.preventDefault();
  let arr_row = obj_grid.get_row_selected();
  if(arr_row.length==0 || arr_row[0]['id'] == undefined){
    Helpers.alert("Seleccione un registro", "error");
  }else{
    let idaplicar = arr_row[0]['id'];
    Encuesta.mostrar(idaplicar);
  }
});

$("#btn_eliminar_encuesta").click(function(e){
  e.preventDefault();
  let arr_row = obj_grid.get_row_selected();
  if(arr_row.length==0 || arr_row[0]['id'] == undefined){
    Helpers.alert("Seleccione un registro", "error");
  }else{
    let idaplicar = arr_row[0]['id'];
    bootbox.confirm({
        message: "<b>¿Está seguro de querer eliminar el requerimiento seleccionado?</b>",
        size: 'small',
        buttons: {
            confirm: {
                label: 'Si',
                className: 'btn-primary'
            },
            cancel: {
                label: 'No',
                className: 'btn-default'
            }
        },
        callback: function (result) {
          if(result){
            Encuesta.eliminar(idaplicar);
          }else{
            // Helpers.alert("nada...");
          }
        }
    });
  }
});


$("#btn_imprimir_encuesta").click(function(e){
  e.preventDefault();
  Encuesta.imprimir();
});


let Encuesta = {

  listar : () => {
    var ruta = base_url+"Encuesta/get_xidusuario";
    $.ajax({
      async: true,
      url: ruta,
      method: 'POST',
      data: {},
      beforeSend: function( xhr ) {
        $("#wait").modal("show");
      }
    })
    .done(function( data ) {
      $("#wait").modal("hide");

      $("#encuestador_total").empty();
      $("#encuestador_total").append(data.total);

      var arr_datos = data.result;
      var arr_columnas = data.array_columnas;
      obj_grid = new Grid(
        "grid_encuestador", // el id del div HTML
        arr_columnas, // El array de columnas, serán los encabezados
        arr_datos // E array de los datos para llenar el grid, los índices deben corresponder a los nombres de las columnas
      );
      obj_grid.load();
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      // console.error("Error in read()"); console.table(e);
      $("#wait").modal("hide"); Helpers.error_ajax(jqXHR, textStatus, errorThrown);
    });
  },

  mostrar : (idaplicar) => {
    let form = document.createElement("form");
    /* let element1 = document.createElement("input"); */
    form.name="form_mostrar";
    form.method = "POST";
    form.target = "_parent";
    /*
    element1.type="hidden";
    element1.value = idaplicar;
    element1.name="idaplicar";
    form.appendChild(element1);
    */
    form.action = base_url+"encuesta/"+idaplicar;
    document.body.appendChild(form);
    form.submit();
  },

  imprimir : () => {
    let form = document.createElement("form");
    /* let element1 = document.createElement("input"); */
    form.name="form_mostrar";
    form.method = "POST";
    form.target = "_blank";
    form.action = base_url+"reporte/area/";
    document.body.appendChild(form);
    form.submit();
  },


  eliminar : (idaplicar) => {
    var ruta = base_url+"Encuesta/eliminar";
    $.ajax({
      async: true,
      url: ruta,
      method: 'POST',
      data: { 'idaplicar':idaplicar },
      beforeSend: function( xhr ) {
        $("#wait").modal("show");
      }
    })
    .done(function( data ) {
      $("#wait").modal("hide");
      if(data.result){
        Helpers.alert("Registro eliminado correctamente", "success");
        Encuesta.listar();
      }else{
      Helpers.alert("Ocurrió un error, reintente por favor.", "error");
      }

    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      $("#wait").modal("hide"); Helpers.error_ajax(jqXHR, textStatus, errorThrown);
    });
  },

  editar : (idaplicar) =>{
    let form = document.createElement("form");

    form.name="form_editar";
    form.method = "POST";
    form.target = "_parent";

    form.action = base_url+"encuesta/edith/"+idaplicar;
    document.body.appendChild(form);
    form.submit();

    // var ruta = base_url+"Encuesta/editar";
    // $.ajax({
    //   async: true,
    //   url: ruta,
    //   method: 'POST',
    //   data: {"id_aplicar":$row_g[0]['id']},
    //   beforeSend: function( xhr ) {
    //     $("#wait").modal("show");
    //   }
    // })
    // .done(function( data ) {
    //   $("#wait").modal("hide");
    //   // location.href = base_url+"Encuesta/editar";
    //   $(".container").empty();
    //   $(".container").append(data.str_view_edit);
    //
    // })
    // .fail(function(jqXHR, textStatus, errorThrown) {
    //   // console.error("Error in read()"); console.table(e);
    //   $("#wait").modal("hide"); Helpers.error_ajax(jqXHR, textStatus, errorThrown);
    // });
  }

};


$("#btn_editar_respuestas").click(function(e){
  e.preventDefault();
  $row_g = obj_grid.get_row_selected();
  // console.log($row_g['length']);
  // window.location.href = base_url+"Encuesta/editar";
if ($row_g['length']!=0) {
  let idaplicar = $row_g[0]['id'];
  Encuesta.editar(idaplicar);
}
else {
  Helpers.alert("Seleccione una encuesta a editar.", "error");
}


});

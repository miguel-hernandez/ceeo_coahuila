/* jshint esversion: 6 */

$(function() {
  Encuesta.listar();
});



$("#modal_encuestador_btn_cerrar").click(function(e){
  e.preventDefault();
  $("#radio_director_visitador").prop('checked', false);
  $("#radio_docente_visitador").prop('checked', false);
  $("#div_contenedor_preguntas").empty();
  $("#modal_visitador").modal("hide");
  obj_visitador.read();
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
  }


};


$("#btn_editar_respuestas").click(function(e){
  e.preventDefault();
  $row_g = obj_grid.get_row_selected();
  // console.log($row_g[0]['id']);
  // window.location.href = base_url+"Encuesta/editar";

  var ruta = base_url+"Encuesta/editar";
  $.ajax({
    async: true,
    url: ruta,
    method: 'POST',
    data: {"id_aplicar":$row_g[0]['id']},
    beforeSend: function( xhr ) {
      $("#wait").modal("show");
    }
  })
  .done(function( data ) {
    $("#wait").modal("hide");
    // location.href = base_url+"Encuesta/editar";
    $(".container").empty();
    $(".container").append(data.str_view_edit);

  })
  .fail(function(jqXHR, textStatus, errorThrown) {
    // console.error("Error in read()"); console.table(e);
    $("#wait").modal("hide"); Helpers.error_ajax(jqXHR, textStatus, errorThrown);
  });

});

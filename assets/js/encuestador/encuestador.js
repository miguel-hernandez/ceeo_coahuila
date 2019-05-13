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
    .fail(function(e) {
      console.error("Error in read()"); console.table(e);
    });
  }


};

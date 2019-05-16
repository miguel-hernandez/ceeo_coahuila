function Grid(iddiv,columnas,arr_datos){
  that_grid = this;

  that_grid.iddiv = iddiv;
  that_grid.columns = columnas;
  that_grid.arr_datos = arr_datos;

  that_grid.arr_row_selected = [];

  this.load = function(){
    var html="";
    that_grid.init();

    html += "<div class='table-responsive'>";
    html += "<table id='' class='table table-condensed table-hover  table-bordered'>";

    /***************** thead ********************/
    html += "<thead class='table_head'>";
    html += "<tr>";
    var objeto_columnas = that_grid.columns;
    for (var item in objeto_columnas) {
      if (objeto_columnas.hasOwnProperty(item)) { // hasOwnProperty() devuelve un booleano indicando si el objeto tiene EL item especificada.
        var tipo = objeto_columnas[item]["type"];
        var label = objeto_columnas[item]["header"];
        var width = objeto_columnas[item]["width"];
        if(tipo=="hidden"){
          html += "<th id='"+item+"' hidden>";
          html += "<center>"+label+"</center>";
          html += "</th>";
        }
        else{
          html += "<th id='"+item+"' width='"+width+"%'>";
          html += "<center>"+label+"</center>";
          html += "</th>";
        }
      }
    }// for objeto_columnas

    html += "</tr>";
    html += "</thead>";
    /***************** TBODY ********************/
    html += "<tbody>";

    if(that_grid.arr_datos.length > 0){
      for (var i = 0; i<that_grid.arr_datos.length; i++) {
        html += "<tr>";
        if (objeto_columnas.hasOwnProperty(item)) {
          for (var item in objeto_columnas) {
            switch (objeto_columnas[item]["type"]) {
              case "button":
                  html += "<td id='"+item+"' data='"+that_grid.arr_datos[i][item]+"'>";
                  html += "<button id='btn_mostrar_encuesta' onclick='ver_ev("+that_grid.arr_datos[i][item]+")' type='button' class='btn btn-primary btn-block'> <i class='fa fa-eye'></i>";
                  html += "</button>";
                  html += "</td>";
                break;
              case "hidden":
                  html += "<td id='"+item+"' data='"+that_grid.arr_datos[i][item]+"' hidden>";
                  html += that_grid.arr_datos[i][item];
                  html += "</td>";
                break;
              case "text":
                  html += "<td id='"+item+"' data='"+that_grid.arr_datos[i][item]+"'>";
                  html += that_grid.arr_datos[i][item];
                  html += "</td>";
                break;
              default:

            }

          }// end for columns
        }
        html += "</tr>";
      }
    }
    else{
      html += "<tr>";
      html += "<td colspan='"+that_grid.columns.length+"'>No hay datos para mostrar</td>";
      html += "</tr>";
    }

    html += "</tbody>";

    html += "</table>";
    html += "</div>";

    that_grid.finish(html);

  }// load()

  this.finish = function(str_html){
    $("#"+that_grid.iddiv).empty();
    $("#"+that_grid.iddiv).append(str_html);
  }// finish()

  this.get_row_selected = function(){
    return that_grid.arr_row_selected;
  }// get_row_selected()

  $(document).on("click", "#"+that_grid.iddiv+" tbody tr", function(e) {
    that_grid.init();
    // $(this).css( {"background-color": "#CEF6CE", "font-size": "16px"} );
    $(this).css( {"background-color": "#D0EDF2", "font-size": "15px"} );

    var arr_aux = [];
    $(this).children("td").each(function (){
      arr_aux[this.id] = $(this).attr('data');
    });

    that_grid.arr_row_selected[0] = arr_aux;
  });

  this.init  = function(){
    $("#"+that_grid.iddiv+ " tbody tr").each(function () {
      $(this).css( {"background-color": "white", "font-size": "14px"} );
    });
  }// init()

}// Grid

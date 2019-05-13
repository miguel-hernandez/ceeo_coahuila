$("#btn_encuesta_guardar").click(function(e){
  e.preventDefault();
  if(!Aplicar.validar()){
      Helpers.alert("Atienda los errores indicados", "error");
  }else{
    let array_ok = Aplicar.arma_envio();
    Aplicar.guardar(array_ok);
  }
});




  let Aplicar = {

    validar : () => {
      $('.requerido').each(function(i, elem){
        switch (elem.type) {
          case "textarea":
            $(elem).css({'border':'1px solid rgb(169, 169, 169)'});
          break;
          case "checkbox":
            $('#label_'+elem.name).html('');
          break;
        }
      });

      let error = 0;
      let arr_respuestas = [];
      let array_preguntas = [];
      $('.requerido').each(function(i, elem){

          switch (elem.type) {
            case "textarea":
            if($(elem).val() == ''){
              $(elem).css({'border':'1px solid red'});
              error++;
            }
            break;
            case "checkbox":
              let idpregunta = $(elem).data('idpregunta');

                if(array_preguntas.includes(idpregunta)){
                  // console.log("if includes");
                }else{
                  array_preguntas.push(idpregunta);
                  // console.log("else includes");
                  if(!$("input[name="+elem.name+"]:checked").val()) {
                      $('#label_'+elem.name).html('seleccione <br />');
                      error++;
                  }
                }

            break;
          }
        });

        if(error > 0){
          return false;
        }else{
          return true;
        }
    },

    arma_envio : (array_ok) => {
      let arr_datos = [];

      $('.requerido').each(function(i, elem){

        switch (elem.type) {
          case "textarea":
            let arr_datos_aux = new Object();
            // $(elem).css({'border':'1px solid rgb(169, 169, 169)'});
            let idpregunta = $(elem).data('idpregunta');
            let valor = $(elem).val();

            arr_datos_aux["tipo"] = 1;
            arr_datos_aux["idpregunta"] = idpregunta;
            arr_datos_aux["valor"] = valor;

            arr_datos.push(arr_datos_aux);
          break;
          case "checkbox":
              let arr_datos_aux2 = new Object();
              let idpregunta2 = $(elem).data('idpregunta');
              let valor2 = $("input[name="+elem.name+"]:checked").val();
              if($("input[name="+elem.name+"]:checked").val()) {
                arr_datos_aux2["tipo"] = 2;
                arr_datos_aux2["idpregunta"] = idpregunta2;
                arr_datos_aux2["valor"] = valor2;
                arr_datos.push(arr_datos_aux2);
              }

          break;
        }

      });
      return arr_datos;
    },

    guardar : (array_ok) => {
      var ruta = base_url+"Encuesta/guardar";
      $.ajax({
        async: true,
        url: ruta,
        method: 'POST',
        data: {'array_datos': array_ok},
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

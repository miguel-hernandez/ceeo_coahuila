$("#div_contenedor_preguntas").on("submit", "#form_cuestionario_doc", function(event){
  // event.preventDefault();

  // PRIMERO LIMPIO EL FORMULARIO DE LOS MENSAJES DE ERROR
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
    // console.info('i: '+i);
      switch (elem.type) {
        case "textarea":
        if($(elem).val() == ''){
          $(elem).css({'border':'1px solid red'});
          error++;
        }
        /*
        else {
          arr_respuestas.push($(elem).val());
        }
        */
        break;
        case "checkbox":
        /*
          let padre_label = $(elem).parent('label');
          console.info("padre_label");
          console.info(padre_label);
          let padre_div = $(padre_label).parent('div');
          console.info("padre_div");
          console.info(padre_div);

          let hijos_label = $(padre_div).children('label');
          console.info("hijos_label");
          console.info(hijos_label);

          let hijos_checkbox = $(hijos_label).children('input');
          console.info("hijos_checkbox");
          console.info(hijos_checkbox);
          */

          let idpregunta = $(elem).data('idpregunta');
          // console.info("idpregunta: "+idpregunta);
          // array_preguntas.push(idpregunta);

          // if( (i == 0) || (i == '0')){
            // console.info("indice = cero");
            // array_preguntas.push(idpregunta);
            // if(!$("input[name="+elem.name+"]:checked").val()) {
                // $('#label_'+elem.name).html('seleccione <br />');
                // error++;
            // }
          // }else{
            // console.info("indice > cero");
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
          // }

        // array_preguntas
        // console.info( array_preguntas.includes( 'donna' ) ); // true

        /*
        // console.info("idpregunta: "+idpregunta);
        if(!$("input[name="+elem.name+"]:checked").val()) {
            $('#label_'+elem.name).html('seleccione <br />');
            error++;
        }
        else {
          // arr_respuestas.push($("input[name="+elem.name+"]:checked").val());
        }
        */
        break;
      }
    });
    // console.log(array_preguntas);
    // return false;
    if(error > 0){
      event.preventDefault();
      Helpers.alert("Atienda los errores indicados", "error");
    }else{
      alert("amonos");
      // arma_envio();
      let array_ok = arma_envio();
      Aplicar.guardar(array_ok);

    }
    /*
    else {
      // alert("se guarda");
      $("#form_cuestionario_doc").submit();
    }
    */
  });

  function arma_envio(){
    let arr_gclubes = [];

    $('.requerido').each(function(i, elem){

      switch (elem.type) {
        case "textarea":
          let arr_gclubes_aux = new Object();
          // $(elem).css({'border':'1px solid rgb(169, 169, 169)'});
          let idpregunta = $(elem).data('idpregunta');
          let valor = $(elem).val();

          arr_gclubes_aux["tipo"] = 'textarea';
          arr_gclubes_aux["idpregunta"] = idpregunta;
          arr_gclubes_aux["valor"] = valor;

          arr_gclubes.push(arr_gclubes_aux);
        break;
        case "checkbox":
            let arr_gclubes_aux2 = new Object();
            let idpregunta2 = $(elem).data('idpregunta');
            let valor2 = $("input[name="+elem.name+"]:checked").val();
            // if($("input[name="+elem.name+"]:checked").val()) {
              arr_gclubes_aux2["tipo"] = 'checkbox';
              arr_gclubes_aux2["idpregunta"] = idpregunta2;
              arr_gclubes_aux2["valor"] = valor2;
            // }
            arr_gclubes.push(arr_gclubes_aux2);
        break;
      }

    });
    return arr_gclubes;
  }


  let Aplicar = {

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


/*
  $('#div_grid_gclubes_lista tbody tr').each(function() {
    $(this).find('th').each(function(){
      let arr_gclubes_aux = new Object();
      let idexp = $(this).data("idexp");
      let idgclub = $(this).data("idgclub");
      let input_div = $(this).children("div");
      let input_label = $(input_div).children("label");
      let input_check = $(input_label).children("input");
      let estatus = ($(input_check).prop('checked'))?1:0;
      arr_gclubes_aux["idexp"] = idexp;
      arr_gclubes_aux["idgclub"] = idgclub;
      arr_gclubes_aux["estatus"] = estatus;
      if (estatus==1) {
        arr_gclubes.push(arr_gclubes_aux);
      }
    });
  });
  */

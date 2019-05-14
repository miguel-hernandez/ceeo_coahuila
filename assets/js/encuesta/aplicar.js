// $("#texto2").blur(function(){
//   $(this).hide("slow");
// });
$(document).on('blur','.textarea_blur', function(e) {
  e.preventDefault();
  e.stopImmediatePropagation(); // evita que se ejecute 2 veces el evento

  let idpregunta = $(this).data('idpregunta');
  let valor = $(this).val();

  for (var i = 0; i < array_ids_ok.length; i++) {
    if((array_ids_ok[i]['tipo'] == 1) || (array_ids_ok[i]['tipo'] == '1')){ // sólo textarea
      if(array_ids_ok[i]['idpregunta'] == idpregunta){
        array_ids_ok[i]['valores'] = valor;
      }
    }
  }

  // console.info("array_ids_ok final textarea");
  // console.info(array_ids_ok);

});


$(document).on('change','.checkbox_change',function(e) {
     e.preventDefault();
     e.stopImmediatePropagation(); // evita que se ejecute 2 veces el evento

     let idpregunta = $(this).data('idpregunta');
     idpregunta = String(idpregunta);

     let valor = $(this).val();

     // console.info("idpregunta: "+idpregunta);

     // console.info("array_ids");
     // console.info(array_ids);

     // console.info("array_ids_ok");
     // console.info(array_ids_ok);


     let index =  array_ids.indexOf(idpregunta);
     // console.info("index: "+index);


     /*
     let index_ok =  array_ids_ok.indexOf(idpregunta);
     console.info("index_ok: "+index_ok);
     */

     if($(this).is(":checked")) {
        /*
        let valor = $(this).val();
        alert("idpregunta: "+idpregunta);
        alert("valor: "+valor);
        let str_concat = idpregunta+'-'+valor;

        let actual = $("#itxt_idpregunta_"+idpregunta).val();
        let nuevo = actual+'/'+str_concat;
        $("#itxt_idpregunta_"+idpregunta).val(nuevo);
        */



        let array_aux = [];
        for (var i = 0; i < array_ids_ok.length; i++) {
          if(array_ids_ok[i]['idpregunta'] == idpregunta){
            array_aux['idpregunta'] = idpregunta;
            array_aux['valor'] = valor;

            array_ids_ok[i]['valores'].push(array_aux);


          }
        }

     }else{
       for (var i = 0; i < array_ids_ok.length; i++) {
         if(array_ids_ok[i]['idpregunta'] == idpregunta){

           for (var j = 0; j < array_ids_ok[i]['valores'].length; j++) {
             if(array_ids_ok[i]['valores'][j]['valor'] == valor){
               array_ids_ok[i]['valores'].splice(j);
             }
           }

           // array_aux['idpregunta'] = idpregunta;
           // array_aux['valor'] = valor;

           // array_ids_ok[i]['valores'].splice(array_aux);


         }
       }
     }

     // console.info("array_ids_ok final");
     // console.info(array_ids_ok);
});


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
      // console.info("Para enviar");
      // console.info(array_ids_ok);


      for (var i = 0; i < array_ids_ok.length; i++) {
          let valores = array_ids_ok[i]['valores'];
          // console.info("valores");
          // console.info(valores);
          // let valores_ok = JSON.stringify(valores);
          // array_ids_ok[i]['valores'] = valores_ok;

          if((array_ids_ok[i]['tipo'] == 2) || (array_ids_ok[i]['tipo'] == '2')){ // sólo checkbox
            let string_ok = '';
            for (var j = 0; j < valores.length; j++) {
              // console.info("valores[j]['valor']");
              // console.info(valores[j]['valor']);
              let valor = valores[j]['valor'];
              // console.info("valor: "+valor);
              string_ok = string_ok+valor+'/';
              // array_ids_ok[i]['valores'][j] = JSON.stringify(array_ids_ok[i]['valores'][j]);
              // Object.assign({}, array_ids_ok[i]['valores'][j]);
              // $.extend({}, array_ids_ok[i]['valores']);
              // var arr = array_ids_ok[i]['valores'];
              // var obj = _.extend({}, a);
              // Object.setPrototypeOf(arr, Object.prototype); // now no longer an array, still an object
              // console.log(obj);
            }
            string_ok = string_ok.substring(0, string_ok.length - 1);
            array_ids_ok[i]['valores_string'] = string_ok;
          }

          /*
          for (var j = 0; j < array_ids_ok[i]['valores'].length; j++) {
            if(array_ids_ok[i]['valores'][j]['valor'] == valor){
              array_ids_ok[i]['valores'].splice(j);
            }
          }
          */
      }
      /*
      var obj = {};
      const arrayToObject = (array_ids_ok, keyField) =>
         array.reduce((obj, item) => {
           obj[item[keyField]] = item
           // return obj
         }, {})

      console.info("obj");
      console.info(obj);


      // return false;
      array_ids_ok = JSON.stringify(array_ids_ok);
      */
      // console.info("MAS Para enviar");
      // console.info(array_ids_ok);

      var ruta = base_url+"Encuesta/guardar";
      $.ajax({
        async: true,
        url: ruta,
        method: 'POST',
        data: { 'array_datos': array_ids_ok },
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

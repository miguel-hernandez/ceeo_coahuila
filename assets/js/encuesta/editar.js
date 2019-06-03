
$('#ifile_aplicar').change(function() {
// console.log(base_url+'/assets/img/document.svg');
  var input = this;
  if (input.files && input.files[0]) {
  var file = input.files[0];
  var fileType = file.type;

  if (fileType == '') {

   $('#image_aplicar').attr('src', base_url+'/assets/img/document.svg');
}else{

  pdffile_url=URL.createObjectURL(file);

      if (fileType.search('application/vnd')==0 ) {
        $('#image_aplicar').attr('src', '');
      }
      else {
        if (fileType.search('application/msword')==0 ) {
          $('#image_aplicar').attr('src', '');
        }
        else {
          $('#image_aplicar').attr('src', pdffile_url);
        }
      }

    }
  }
});

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
            if (array_ids_ok[i]['tipo']==3) {
                  array_ids_ok[i]['valores'].splice(0);
                  array_ids_ok[i]['valores'].push(array_aux);
            }
            else {
              array_ids_ok[i]['valores'].push(array_aux);
            }

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


$("#btn_encuesta_editar").click(function(e){
  e.preventDefault();
  if(!Aplicar.validar()){
      Helpers.alert("Atienda los errores indicados", "error");
  }else{

    Aplicar.editar();
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
      $('.requerido').each(function(r, elem){
        // console.log(r);
        let idpregunta = $(elem).data('idpregunta');
          switch (elem.type) {
            case "textarea":
            if($(elem).val() == ''){
              $(elem).css({'border':'1px solid red'});
              error++;
            }
            break;
            case "checkbox":
              // let idpregunta = $(elem).data('idpregunta');

                if(array_preguntas.includes(idpregunta)){
                  // console.log("if includes");
                }else{
                  array_preguntas.push(idpregunta);
                  // console.log(elem.name);

                  if(!$("input[name="+elem.name+"]:checked").val()) {
                      $('#label_'+elem.name).html('seleccione <br />');
                      error++;
                  }
                  else {
                    if ($("input[name="+elem.name+"]:checked").val()) {
                      // let valor = $("input[name="+elem.name+"]").val();
                      var arr = $("[name="+elem.name+"]:checked").map(function(){
                          return this.value;
                        }).get();
                        let valor = arr.join('/');
                      // console.log(str);
                      let array_aux = [];
                          for (var i = 0; i < array_ids_ok.length; i++) {
                            if(array_ids_ok[i]['idpregunta'] == idpregunta){
                              array_aux['idpregunta'] = idpregunta;
                              array_aux['valor'] = valor;
                              array_ids_ok[i]['valores'].push(array_aux);
                            }
                          }
                    }

                        // console.log(idpregunta);
                        // console.log(array_ids_ok);

                  }
                }

            break;
            case "radio":
            // let idpregunta = $(elem).data('idpregunta');

              if(array_preguntas.includes(idpregunta)){
                // console.log("if includes");
              }else{
                array_preguntas.push(idpregunta);
                // console.log(elem.name);

                if(!$("input[name="+elem.name+"]:checked").val()) {
                    $('#label_'+elem.name).html('seleccione <br />');
                    error++;
                }
                else {
                  if ($("input[name="+elem.name+"]:checked").val()) {
                    // let valor = $("input[name="+elem.name+"]").val();
                    var arr = $("[name="+elem.name+"]:checked").map(function(){
                        return this.value;
                      }).get();
                      let valor = arr.join('/');
                    // console.log(str);
                    let array_aux = [];
                        for (var i = 0; i < array_ids_ok.length; i++) {
                          if(array_ids_ok[i]['idpregunta'] == idpregunta){
                            array_aux['idpregunta'] = idpregunta;
                            array_aux['valor'] = valor;
                            array_ids_ok[i]['valores'].push(array_aux);
                          }
                        }
                  }

                      // console.log(idpregunta);
                      // console.log(array_ids_ok);

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

    editar : () => {
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
            let valor = '';
            for (var j = 0; j < valores.length; j++) {
              // console.info("valores[j]['valor']");
              // console.info(valores[j]['valor']);
               valor = valores[j]['valor'];
              // console.info("valor: "+valor);
              // console.info("string_ok: "+string_ok);
              // console.info("i: "+i);
              // console.info("j: "+j);
              string_ok = string_ok+valor+'/';
            // console.info("string_ok: "+string_ok);
              // array_ids_ok[i]['valores'][j] = JSON.stringify(array_ids_ok[i]['valores'][j]);
              // Object.assign({}, array_ids_ok[i]['valores'][j]);
              // $.extend({}, array_ids_ok[i]['valores']);
              // var arr = array_ids_ok[i]['valores'];
              // var obj = _.extend({}, a);
              // Object.setPrototypeOf(arr, Object.prototype); // now no longer an array, still an object
              // console.log(obj);
            }
            string_ok = string_ok.substring(0, string_ok.length - 1);
            array_ids_ok[i]['valores_string'] = valor;
            $("#itxt_aplicar_idpregunta_"+array_ids_ok[i]['idpregunta']).val(valor);
          }

          if((array_ids_ok[i]['tipo'] == 3) || (array_ids_ok[i]['tipo'] == '3')){ // sólo checkbox
            let string_ok = '';
              let valor = valores[0]['valor'];
              string_ok = string_ok+valor+'/';
            string_ok = string_ok.substring(0, string_ok.length - 1);
            array_ids_ok[i]['valores_string'] = string_ok;
            $("#itxt_aplicar_idpregunta_"+array_ids_ok[i]['idpregunta']).val(string_ok);
          }

          /*
          for (var j = 0; j < array_ids_ok[i]['valores'].length; j++) {
            if(array_ids_ok[i]['valores'][j]['valor'] == valor){
              array_ids_ok[i]['valores'].splice(j);
            }
          }
          */
      }

      var file_data = $('.image').prop('files')[0];
      // if(file_data == undefined) {
      //   Helpers.alert("Seleccione archivo", "error");
      // }else{
        /*
        var form_data = new FormData();
        form_data.append('file', file_data);
        console.info("form_data");
        console.info(form_data);
        for (var m = 0; m < array_ids_ok.length; m++) {
          if(array_ids_ok[m]['tipo'] == 'archivo'){
            array_ids_ok[m]['archivo'] = file_data
          }
        }// for
        console.info("array_ids_ok");
        console.info(array_ids_ok);
        // return false;
        */
        // console.info(array_ids_ok);
        Aplicar.editar_ok(array_ids_ok);
      // }
      return false;





      // Aplicar.guardar_ok(array_ids_ok);
      /*
      var data=paqueteDeDatos
      if(Object.keys(data).length === 0){
        Helpers.alert("Seleccione archivo", "error");
      }else{
        Aplicar.guardar_ok(array_ids_ok, data);
      }
      */
      // console.info(data_img);

      // return false;


    },

    editar_ok : (array_ids_ok) => {
      // let array_aux = new Object();
      // array_aux["datos"] = array_ids_ok;
      // console.log(array_ids_ok);
      var form_data = new FormData($("#form_cuestionario_doc")[0]);
      var ruta = base_url+"Encuesta/editar_insert";
      $.ajax({
        // async: true,
        url: ruta,
        type: 'POST',
        dataType: 'JSON',
        cache: false,
        contentType: false,
        processData: false,

        data: form_data,
        beforeSend: function( xhr ) {
          $("#wait").modal("show");
        }
      })
      .done(function( data ) {
        // console.log(data);
        $("#wait").modal("hide");
        if (data.estatus) {
          bootbox.alert(data.respuesta, function(){
            window.location.href = base_url+"Encuestador";
        });
        }
        else {
          Helpers.alert(data.respuesta, "error");
        }

      })
      .fail(function(jqXHR, textStatus, errorThrown) {
        $("#wait").modal("hide"); Helpers.error_ajax(jqXHR, textStatus, errorThrown);
      });
    }

  };

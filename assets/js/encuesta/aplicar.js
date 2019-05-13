$("#div_contenedor_preguntas").on("submit", "#form_cuestionario_doc", function(event){
  // alert("entro");

  event.preventDefault();
  var error = 0;
  var arr_respuestas= [];
  $('.requerido').each(function(i, elem){
      switch (elem.type) {
        case "textarea":
        if($(elem).val() == ''){
          $(elem).css({'border':'1px solid red'});
          error++;
        }
        else {
          arr_respuestas.push($(elem).val());
        }
        break;
        case "checkbox":
        if(!$("input[name="+elem.name+"]:checked").val()) {
            $('#label_'+elem.name).html('seleccione <br />');
            error++;
        }
        else {
          // arr_respuestas.push($("input[name="+elem.name+"]:checked").val());
        }
        break;
      }
    });
    console.log(arr_respuestas);

    if(error > 0){
      Helpers.alert("Atienda los errores indicados", "error");
    }
    else {
      alert("se guarda");
    }
  });

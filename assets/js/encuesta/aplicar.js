$("#div_contenedor_preguntas").on("submit", "#form_cuestionario_doc", function(event){
  var error = 0;
  $('.requerido').each(function(i, elem){
      switch (elem.type) {
        case "textarea":
        if($(elem).val() == ''){
          $(elem).css({'border':'1px solid red'});
          error++;
        }
        break;
        case "checkbox":
        if(!$("input[name="+elem.name+"]:checked").val()) {
            $('#label_'+elem.name).html('seleccione <br />');
            error++;
        }
        break;
      }
    });

    if(error > 0){
      event.preventDefault();
      Helpers.alert("Atienda los errores indicados", "error");
    }
  });

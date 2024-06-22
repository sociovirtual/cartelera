jQuery(document).ready(function ($) {
    // Subir/Seleccionar Póster
    $("#upload_cartelera_poster").click(function (e) {
      e.preventDefault();
      var custom_uploader = wp.media({
        title: "Seleccionar Póster",
        button: {
          text: "Seleccionar",
        },
        multiple: false,
      });
      custom_uploader.on("select", function () {
        var attachment = custom_uploader
          .state()
          .get("selection")
          .first()
          .toJSON();
        $("#cartelera_poster").val(attachment.id);
        $("#cartelera_poster").html(
          '<img src="' +
            attachment.url +
            '" style="max-width:200px;height:auto;"/><br/><a href="#" id="remove_cartelera_poster">Eliminar</a>'
        );
      });
      custom_uploader.open();
    });
  
    // Eliminar Póster
    $(document).on("click", "#remove_cartelera_poster", function (e) {
      e.preventDefault();
      $("#cartelera_poster").val("");
      $("#cartelera_poster").html(
        '<button class="button" id="upload_cartelera_poster">Subir/Seleccionar Póster</button>'
      );
    });
  
    // Añadir/Quitar Horario
    $(".add-horario").on("click", function (e) {
      e.preventDefault();
      var index = $("#cartelera-horarios-wrapper .cartelera-horario-group").length;
      $("#cartelera-horarios-wrapper").append(
        '<div class="cartelera-horario-group">' +
          '<input type="text" name="cartelera_horarios[' +
          index +
          '][hora]" placeholder="Hora" />' +
          '<input type="text" name="cartelera_horarios[' +
          index +
          '][formato]" placeholder="Formato" />' +
          '<input type="text" name="cartelera_horarios[' +
          index +
          '][doblaje]" placeholder="Doblaje" />' +
          '<button class="button remove-horario">Eliminar</button>' +
          "</div>"
      );
    });
    $(document).on("click", ".remove-horario", function (e) {
      e.preventDefault();
      $(this).parent(".cartelera-horario-group").remove();
    });


  // Inicializar datepicker
    $('#cartelera_fecha_desde, #cartelera_fecha_hasta').datepicker({
      dateFormat: 'dd/mm/yy', // Formato de fecha
      changeMonth: true, // Permitir cambio de mes
      changeYear: true, // Permitir cambio de año
      yearRange: 'c-1:c+1' // Rango de años (1 años atrás y 1 años adelante desde el año actual)
    });
  
             // Funcionalidad para obtener la miniatura de YouTube
          $('#fetch_thumbnail').on('click', function() {
              var trailerUrl = $('#cartelera_trailer').val();
              var videoId = trailerUrl.split('v=')[1] || trailerUrl.split('youtu.be/')[1];
              if (videoId) {
                  var ampersandPosition = videoId.indexOf('&');
                  if (ampersandPosition !== -1) {
                      videoId = videoId.substring(0, ampersandPosition);
                  }
                  var thumbnailUrl = 'https://img.youtube.com/vi/' + videoId + '/hqdefault.jpg';
                  $('#cartelera_trailer_id').val(videoId);
                  $('#cartelera_trailer_thumbnail').val(thumbnailUrl);
                  $('#thumbnail_preview').attr('src', thumbnailUrl);
                  $('#thumbnail_container').show();
                  alert('Miniatura obtenida: ' + thumbnailUrl);
              } else {
                  alert('URL de YouTube no válida.');
              }
          });


  });
  
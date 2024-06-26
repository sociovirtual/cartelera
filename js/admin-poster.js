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
        $("#cartelera_poster_id").html('<img src="' + attachment.url + '" style="max-width:200px;height:auto;"/><br/><a href="#" id="remove_cartelera_poster">Eliminar</a>'
        );
      });
      custom_uploader.open();
    });
  
    // Eliminar Póster
    $(document).on("click", "#remove_cartelera_poster", function (e) {
      e.preventDefault();
      $("#cartelera_poster").val("");
      $("#cartelera_poster_id").html("");
    });
  

  });
  
jQuery(document).ready(function ($) {


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

});

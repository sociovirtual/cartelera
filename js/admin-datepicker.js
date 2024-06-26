jQuery(document).ready(function ($) {

  // Inicializar datepicker
    $('#cartelera_fecha_desde, #cartelera_fecha_hasta').datepicker({
      dateFormat: 'dd/mm/yy', // Formato de fecha
      changeMonth: true, // Permitir cambio de mes
      changeYear: true, // Permitir cambio de año
      yearRange: 'c-1:c+1' // Rango de años (1 años atrás y 1 años adelante desde el año actual)
    });
  
});

jQuery(document).ready(function ($) {
    // Funcionalidad para obtener la miniatura de YouTube
    $('#fetch_thumbnail').on('click', function() {
        var trailerUrl = $('#cartelera_trailer').val().trim();
        // alert('URL de YouTube no válida.'+trailerUrl); // log 
        if (trailerUrl) {
            var videoId = null;

            // Extraer el ID del video de diferentes formatos de URL de YouTube
            if (trailerUrl.includes('youtu.be/')) {
                videoId = trailerUrl.split('youtu.be/')[1];
                // alert('URL de YouTube no válida.'+videoId); // log
            } else if (trailerUrl.includes('v=')) {
                videoId = trailerUrl.split('v=')[1];
                // alert('URL de YouTube no válida.'+videoId); // log
            }

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
        } else {
            alert('El campo de URL está vacío.');
        }
    });
});

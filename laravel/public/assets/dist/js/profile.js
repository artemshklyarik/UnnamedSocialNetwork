$(document).ready(function() {

    $('#thumbnail img').css({
            width: '100%',
            height: '100%',
            position: 'absolute'
        });

    var thumbnail = $('#thumbnail img');

    var width = thumbnail.parent().find('#sizeX').val();
    var height = thumbnail.parent().find('#sizeY').val();
    var offsetX = thumbnail.parent().find('#offsetX').val();
    var offsetY = thumbnail.parent().find('#offsetY').val();

    renderThumbnail(width, height, offsetX, offsetY, thumbnail);
});

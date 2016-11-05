$(document).ready(function() {
    var avatar = $('img#current_avatar');
    var avatarLink   = avatar.attr('src');
    var avatarWidth  = avatar.width();
    var avatarHeigth = avatar.height();

    $('#thumbnail img').attr('src', avatarLink);
    $('#thumbnail img').css({
        width: '100%',
        height: '100%',
        position: 'absolute'
    });

    var width = $('#sizeX').val();
    var height = $('#sizeY').val();
    var offsetX = $('#offsetX').val();
    var offsetY = $('#offsetY').val();

    var thumbnail = $('#thumbnail img');

    renderThumbnail(width, height, offsetX, offsetY, thumbnail);

    var ias = avatar.imgAreaSelect({
        hide : true,
        disable : true,
        instance : true,
    });

    $('#change-thumbnail').click(function (){
        $('#change-thumbnail').hide();
        $('#submit-thumbnail').show();
        $('#cancel-thumbnail').show();

        var x1 = offsetX * avatarWidth / 100;
        var y1 = offsetY * avatarHeigth / 100;
        var x2 = (offsetX * avatarWidth / 100) + (avatarWidth * width / 100);
        var y2 = (offsetY * avatarHeigth / 100) + (avatarHeigth * height / 100);

        ias.setOptions({
            hide : false,
            disable : false,
            handles : true,
            aspectRatio : "1:1",
            show : true,
            x1 : x1,
            y1 : y1,
            x2 : x2,
            y2 : y2,
            onSelectChange: function (img, selection) {
                var offsetX,
                    offsetY,
                    width,
                    height,
                    thumbnail;

                offsetX = (selection.x1 / avatarWidth) * 100 ;
                offsetY = (selection.y1 / avatarHeigth) * 100 ;
                width   = (selection.width / avatarWidth) * 100 ;
                height  = (selection.height / avatarHeigth) * 100 ;

                $('#sizeX').val(width);
                $('#sizeY').val(height);
                $('#offsetX').val(offsetX);
                $('#offsetY').val(offsetY);

                var thumbnail = $('#thumbnail img');

                renderThumbnail(width, height, offsetX, offsetY, thumbnail);
            }
        });
    });
    $('#submit-thumbnail').click(function (){
        $('#change-thumbnail').show();
        $('#submit-thumbnail').hide();
        $('#cancel-thumbnail').hide();

        ias.setOptions({
            hide : true,
            disable : true,
            instance : true
        });

        save();
    });
    $('#cancel-thumbnail').click(function (){
        $('#change-thumbnail').show();
        $('#submit-thumbnail').hide();
        $('#cancel-thumbnail').hide();

        ias.setOptions({
            hide : true,
            disable : true,
            instance : true
        });
    });
});

function save()
{
    var sizeX = $('#sizeX').val();
    var sizeY = $('#sizeY').val();
    var offsetX = $('#offsetX').val();
    var offsetY = $('#offsetY').val();

    var url = 'edit_profile/save_thumbnail?' + 'sizeX=' + sizeX + '&sizeY=' + sizeY + '&offsetX=' + offsetX + '&offsetY=' + offsetY;

    $.ajax({
        type: "get",
        url: url
    });
}
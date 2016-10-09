$(document).ready(function(){
    // avatar fancybox
    $("#avatar").fancybox({
        autoResize : true
    });


    //answers js functionality
    var item = 10;

    var answers = $('.answer');

    if (answers.length > 10) {
        $('#show_more').show();
        for (var i = 10; i < answers.length; i++) {
            $('.answer:eq(' + i + ')').hide();
        }
    }

    $( "#show_more" ).on( "click", function() {
        for (var i = item; i < (item + 10); i++) {
            $('.answer:eq(' + i + ')').show();
        }
        item += 10;
        if (item >= answers.length) {
            $('#show_more').hide();
        }
    });
});

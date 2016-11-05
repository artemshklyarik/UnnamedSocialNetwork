$(document).ready(function() {
    var loader = $('.overlay');
    $('#datepicker').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-30y'
    });

    //profile page ajax
    $(".box-profile>a").on("click", function() {
        event.preventDefault();

        var url   = $(this).attr('href');
        var token = $('input[name="_token"]').val();
        var id    = $(this).attr('data-friend');

        $.ajax({
            type: "post",
            url: url,
            data: "requestId=" + id + "&_token=" + token,
            success: function(data){
                if (data.status) {
                    $('.callout').show();
                    $('.callout').removeClass('callout-info').addClass('callout-success');
                    $('.callout h4').html('Success');
                    $('.callout p').html('Operation carried out successfully');
                    $('.box-profile a').remove();
                } else {
                    $('.callout').removeClass('callout-info').addClass('callout-danger');
                    $('.callout h4').html('Error');
                    $('.callout p').html('Please, try again');
                }
            }
        });
    });

    //end profile page ajax

    //question more 10 items hide
    var answersBlocks = $('#questions .box');
    var currentAnswers    = 10;
    var questionsBlocks = $('#newquestions .row');
    var currentQuestions    = 5;

    if (answersBlocks.length > 10) {
        $('#showMoreAnswers').show();
        answersBlocks.slice(currentAnswers - 10, currentAnswers).show();
    } else {
        answersBlocks.show();
    }

    $("#showMoreAnswers").on( "click", function() {
        currentAnswers += 10;
        answersBlocks.slice(currentAnswers - 10, currentAnswers).show();

        if (currentAnswers >= answersBlocks.length) {
            $("#showMoreAnswers").hide();
        }
    });

    if (questionsBlocks.length > 5) {
        $('#showMoreQuestions').show();
        questionsBlocks.slice(currentQuestions - 5, currentQuestions).show();
    } else {
        questionsBlocks.show();
    }

    $("#showMoreQuestions").on( "click", function() {
        currentQuestions += 5;
        questionsBlocks.slice(currentQuestions - 5, currentQuestions).show();

        if (currentQuestions >= questionsBlocks.length) {
            $("#showMoreQuestions").hide();
        }
    });
    //end question more 10 items hide
    //remove question
    $("button.remove-question").on( "click", function() {
        var token = $('input[name="_token"]').val();
        var url   = $(this).attr('href');
        var id    = $(this).attr('data-id');
        var element = $(this).parent().parent().parent();

        $.ajax({
            type: "post",
            url: url,
            data: "requestId=" + id + "&_token=" + token,
            success: function(data){
                if (data.status == true) {
                    element.empty();
                } else {
                    console.log(element);
                    element.show();
                }
            }
        });
    });
    //end remove question

    //sidebar-thumbnail
    var width = $('#sizeX').val();
    var height = $('#sizeY').val();
    var offsetX = $('#offsetX').val();
    var offsetY = $('#offsetY').val();

    $('#sidebar-thumbnail img').css({
            width: '100%',
            height: '100%',
            position: 'absolute'
        });
    var thumbnail = $('#sidebar-thumbnail img');

    renderThumbnail(width, height, offsetX, offsetY, thumbnail);

    //end sidebar-thumbnail

    //header small thumbnail
    $('#thumbnail-header-small img').css({
                width: '100%',
                height: '100%',
                position: 'absolute'
            });
    var thumbnail = $('#thumbnail-header-small img');

    renderThumbnail(width, height, offsetX, offsetY, thumbnail);
    //end header small thumbnail

    //header big thumbnail
    $('#thumbnail-header-big img').css({
                width: '100%',
                height: '100%',
                position: 'absolute'
            });
    var thumbnail = $('#thumbnail-header-big img');

    renderThumbnail(width, height, offsetX, offsetY, thumbnail);
    //end header big thumbnail

});

function renderThumbnail(width, height, offsetX, offsetY, thumbnail)
{
    var thumbnailWidth  = thumbnail.parent().width(),
        thumbnailHeight = thumbnail.parent().height();

    var thumbnailX = thumbnailWidth / (width / 100);
    var thumbnailY = thumbnailHeight / (height / 100);

    var thumbnailOffsetX = (thumbnailX / thumbnailWidth) * thumbnailWidth * (offsetX / 100);
    var thumbnailOffsetY = (thumbnailY / thumbnailHeight) * thumbnailHeight * (offsetY / 100);

    thumbnail.css({
        width: thumbnailX + 'px',
        height: thumbnailY + 'px',
        top: '-' + thumbnailOffsetY + 'px',
        left: '-' + thumbnailOffsetX + 'px'
    });

}
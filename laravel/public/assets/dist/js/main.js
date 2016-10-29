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
});

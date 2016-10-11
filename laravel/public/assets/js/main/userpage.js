$(document).ready(function () {
    // avatar fancybox
    $("#avatar").fancybox({
        autoResize: true
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

    $("#show_more").on("click", function () {
        for (var i = item; i < (item + 10); i++) {
            $('.answer:eq(' + i + ')').show();
        }
        item += 10;
        if (item >= answers.length) {
            $('#show_more').hide();
        }
    });

    //add new fiend
    $("#addfriend").on("click", function () {
        var id = $(this).attr('data-friend-request');
        var token = $('input[name="_token"]').val();

        $.ajax({
            url: '/friends/addfriend',
            method: 'post',
            data: 'requestId=' + id + '&_token=' + token,
            dataType: "json",
            success: function (data) {
                if (data.status == 'success') {
                    $("#addfriend").parent().html('<div class="alert alert-success" role="alert">Request has been sent</div>');
                } else {
                    $("#addfriend").parent().html('<div class="alert alert-danger" role="alert">Error! Request has not sent</div>');
                }
            }
        });
    })

    //approve new fiend request
    $("#accept_request_friend").on("click", function () {
        var id = $(this).attr('data-friend-accept');
        var token = $('input[name="_token"]').val();

        $.ajax({
            url: '/friends/accept_request_friend',
            method: 'post',
            data: 'requestId=' + id + '&_token=' + token,
            dataType: "json",
            success: function (data) {
                if (data.status) {
                    $("#accept_request_friend").parent().html('<div class="alert alert-success" role="alert">Your has accept this request</div>');
                } else {
                    $("#accept_request_friend").parent().html('<div class="alert alert-danger" role="alert">Error!</div>');
                }
            }
        });
    });

    //reject new fiend request
    $("#reject_request_friend").on("click", function () {
        var id = $(this).attr('data-friend-reject');
        var token = $('input[name="_token"]').val();

        $.ajax({
            url: '/friends/reject_request_friend',
            method: 'post',
            data: 'requestId=' + id + '&_token=' + token,
            dataType: "json",
            success: function (data) {
                if (data.status) {
                    $("#reject_request_friend").parent().html('<div class="alert alert-success" role="alert">Your has request this reject</div>');
                } else {
                    $("#reject_request_friend").parent().html('<div class="alert alert-danger" role="alert">Error!</div>');
                }
            }
        });
    });

    //remove friend
    $("#removefriend").on("click", function () {
        var id = $(this).attr('data-friend-remove');
        var token = $('input[name="_token"]').val();

        $.ajax({
            url: '/friends/remove_friend',
            method: 'post',
            data: 'requestId=' + id + '&_token=' + token,
            dataType: "json",
            success: function (data) {
                if (data.status) {
                    $("#removefriend").parent().html('<div class="alert alert-success" role="alert">Friend was deleted</div>');
                } else {
                    $("#removefriend").parent().html('<div class="alert alert-danger" role="alert">Error!</div>');
                }
            }
        });
    });
});

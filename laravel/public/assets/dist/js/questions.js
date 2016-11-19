var loader = $('.overlay');
var page = 1;

$(document).ready(function() {
    $('#question-sidebar').addClass('active');
    makeRequest();


    $('#showMore').click(function() {
        loader.show();
        page++;
        makeRequest();
    });
});

function makeRequest() {
    var url = '/myquestions/ajax?page=' + page;

    $.ajax({
        type: "get",
        url: url,
        success: function(data) {
            reloadData(data.data);
        }
    });
}

function reloadData(data) {
    var renderBlock = $('#questionsTable tbody');

    data.forEach(function(item) {
        var html = '<tr>' +
                '<td><a href="user/' + item.answer_man + '">' + item.answerMan.name + ' ' + item.answerMan.second_name + '</td>' +
                '<td>' + item.question_time + '</td>';
                if (item.answered) {
                    html += '<td><span class="label label-success">Approved</span></td>';
                } else {
                    html += '<td><span class="label label-warning">Wait answer</span></td>';
                }

            html += '<td>' + item.question + '</td>';

            if (item.answered != "0") {
                html += '<td>' + item.answer + '</td>';
            } else {
                html += '<td>-</td>';
            }

            '</tr>';

        renderBlock.append(html);

    });

    if (data.length < 20) {
        $('#showMore').hide();
    } else {
        $('#showMore').show();
    }

    loader.hide();
}
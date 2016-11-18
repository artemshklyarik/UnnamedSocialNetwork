var loader = $('.overlay');
var page = 1;

$(document).ready(function() {
    $('#newsletter-sidebar').addClass('active');
    makeRequest();


    $('#showMore').click(function() {
        loader.show();
        page++;
        makeRequest();
    });
});

function makeRequest() {
    var url = '/newsletter/ajax?page=' + page;

    $.ajax({
        type: "get",
        url: url,
        success: function(data) {
            reloadData(data.data);
        }
    });
}

function reloadData(data) {
    var renderBlock = $('#newsletter');

    data.forEach(function(item) {
        html = '<li>' +
            '<i class="fa fa fa-user bg-aqua"></i>' +
            '<div class="timeline-item">' +
                '<span class="time"><i class="fa fa-clock-o"></i> ' + item.answer_time + '</span>' +
                '<h3 class="timeline-header"><a href="/user/' + item.answer_man + '">' + item.answerMan.name + ' ' + item.answerMan.second_name + '</a> answered on the question</h3>' +
                '<div class="timeline-body">' +
                    '<div class="row nm question-block">' +
                        '<div class="col-md-9 question">' + item.question + '</div>';

                    if (item.anonimous == '0') {
                        html += '<div class="col-md-3 right">from: <a href="/user/' + item.question_man + '">' + item.questionMan.name + ' ' + item.questionMan.second_name + '</a></div>';
                    } else {
                        html += '<div class="col-md-3 right">from: Anonimous</div>';
                    }

                    html += '</div>' +
                    '<div class="row nm">' +
                        '<div class="col-md-12 answer">' + item.answer + '</div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</li>';

        renderBlock.append(html);

        if (data.length < 20) {
            $('#showMore').hide();
        } else {
            $('#showMore').show();
        }

    });

    loader.hide();
}
var loader                 = $('.overlay');
var scope                  = $('#scope').val();
var page                   = 1;
var ownerId                = $('#idOwner').val();
var userId                 = $('#idUser').val();
var url                    = $('#url').val();
var showMoreFriends        = $('button#showMoreFriends');
var showMoreRequests       = $('button#showMoreRequests');
var showMoreMutualFriends  = $('button#showMoreMutualFriends');
var showMorePeople         = $('button#showMorePeople');

var isRefresh              = false; //true, false - Refresh all block after ajax
var action                 = null; //accept, remove

$(document).ready(function() {
    $('.sidebar-menu li#friends-sidebar').addClass('active');

    loader.show();

    getgeo();

    $('#countries').change(function (){
        var countryId = $(this).val();
        $('#countryId').val(countryId);
        getgeo();
    });

    makeRequest();

    $("body").on("click", "a.ajax-friends-list", function() {
        event.preventDefault();
        scope = 'action';
        isRefresh = true;
        loader.show();
        page = 1;
        userId = $(this).attr('data-friend');
        action = $(this).attr('data-action');
        makeRequest();
    });

    $("body").on("change", ".filter-block select#countries", function() {
        $('#countryId').val($(this).val());
        $('#cityId').val('null');
    });

    $("body").on("change", ".filter-block select#cities", function() {
        $('#cityId').val($(this).val());
    });

    $("body").on("change", ".filter-block select", function() {
        loader.show();
        page = 1;
        isRefresh = true;
        makeRequest();
    });

    showMoreFriends.click(function() {
        page++;
        isRefresh = false;
        loader.show();
        makeRequest();
    });

    showMoreRequests.click(function() {
        page++;
        isRefresh = false;
        loader.show();
        makeRequest();
    });
    showMorePeople.click(function() {
        page++;
        isRefresh = false;
        loader.show();
        makeRequest();
    });
    $("body").on("click", 'a[href="#friends"]', function() {
        scope = 'general';
        page = 1;
        isRefresh = true;

        makeRequest();
    });

    $("body").on("click", 'a[href="#requests"]', function() {
        scope = 'requests';
        page = 1;
        isRefresh = true;

        makeRequest();
    });

    $("body").on("click", 'a[href="#mutual"]', function() {
        scope = 'mutual';
        page = 1;
        isRefresh = true;

        makeRequest();
    });

    $("body").on("keyup", 'input[name="q"]', function() {
        page = 1;
        isRefresh = true;
        makeRequest();
    });
});

function makeRequest() {
    var tempUrl = url + '?';
    tempUrl += 'scope=' + scope + '&page=' + page;
    if (scope == 'action') {
        tempUrl += '&action=' + action;
    }

    if (ownerId != undefined) {
        tempUrl += '&ownerId=' + ownerId;
    }

    if (userId != undefined) {
        tempUrl += '&userId=' + userId;
    }

    if (scope == 'general') {
        $('#friends .filter-block select').each(function() {
            if ($(this).val() != '') {
                tempUrl += '&' + $(this).attr('id') + '=' + $(this).val();
            }

            var query = $('#name').val();
            if (query != '') {
                tempUrl += '&q=' + query;
            }
        })

    } else if (scope == 'requests') {
        $('#requests .filter-block select').each(function() {
            if ($(this).val() != '') {
                tempUrl += '&' + $(this).attr('id') + '=' + $(this).val();
            }
        })
    } else if (scope == 'mutual') {
        $('#mutual .filter-block select').each(function() {
            if ($(this).val() != '') {
                 tempUrl += '&' + $(this).attr('id') + '=' + $(this).val();
            }
        })
    } else {
        $('.sidebar-menu li#friends-sidebar').removeClass('active');

        $('#search .filter-block select').each(function() {
            var query = $('#name').val();
            if (query != '') {
                tempUrl += '&q=' + query;
            }

            var element = $(this).attr('id');

            if (element == 'countries') {
                var country = $('#countryId').val();
                tempUrl += '&countries=' + country;
                return;
            }

            if (element == 'cities') {
                var city    = $('#cityId').val();
                tempUrl += '&cities=' + city;
                return;
            }

            if ($(this).val() != '') {
                 tempUrl += '&' + $(this).attr('id') + '=' + $(this).val();
            }

        })
    }

    $.ajax({
        type: "get",
        url: tempUrl,
        success: function(data) {
            reloadData(data.friends);
        }
    });
}

function reloadData(data) {
    if (scope == 'general') {
        renderAllFriends(data);
    }
    if (scope == 'requests') {
        renderRequests(data);
    }
    if (scope == 'action') {
        userId = $('#idUser').val();
        renderAllFriends(data['all']);
        renderRequests(data['requests']);
        updateFriendsCounts(data['count']);
    }

    if (scope == 'mutual') {
        renderMutualFriends(data);
    }

    if (scope == 'search') {
        renderSearchPeople(data);
    }

    loader.hide();
}

function renderAllFriends (data) {
    var allFrindsBlock = $('#all-friends');

    if (isRefresh) {
        allFrindsBlock.html('');
    }

    data.forEach(function(item) {
        var html;

        html = '<div class="col-md-3 user" data-gender="' + item.gender + '">' +
            '<div class="box box-widget widget-user-2">' +
            '<a href="/user/' + item.id + '">';
            if (item.gender == 'male') {
                html += '<div class="widget-user-header bg-purple-active">';
            } else if (item.gender == 'female') {
                html += '<div class="widget-user-header bg-maroon">';
            } else {
                html += '<div class="widget-user-header bg-yellow">';
            }

        html += '<div class="widget-user-image">' +
            '<div id="thumbnail-friends">' +
            '<img alt="thumbnail" src="' + item.smallAvatarLink + '"/>' +
            '<input type="hidden" id="sizeX" name="sizeX" value="' + item.thumbnail.sizeX + '"/>' +
            '<input type="hidden" id="sizeY" name="sizeY" value="' + item.thumbnail.sizeY + '"/>' +
            '<input type="hidden" id="offsetX" name="offsetX" value="' + item.thumbnail.offsetX + '"/>' +
            '<input type="hidden" id="offsetY" name="offsetY" value="' + item.thumbnail.offsetY + '"/>' +
            '</div>' +

            '</div>' +
            '<h3 class="widget-user-username">' + item.name + ' ' + item.second_name + '</h3>' +
            '<h5 class="widget-user-desc">' + item.age + '</h5>' +
            '</div>' +
            '</a>' +
            '<div class="box-footer no-padding">' +
            '<ul class="nav nav-stacked">';

            if (item.geo) {
                if (item.geo.city && item.geo.country) {
                    html += '<li><a href="/search/people?city=' + item.geo.city.id + '&country=' + item.geo.country.id +'">'+ item.geo.city.name +' (' + item.geo.country.name + ')</a></li>';
                } else if (item.geo.country) {
                    html += '<li><a href="/search/people?country=' + item.geo.country.id + '">'+ item.geo.country.name + '</a></li>';
                }
            } else {
                html += '<li><a href="/search/people">Location: none</a></li>';
            }

            if (!userId) {
                html += '<a href="http://dev/friends/remove_friend" class="ajax-friends-list btn btn-danger btn-block" data-friend="' + item.id + '" data-action="remove">' +
                    '<b>Remove from friends</b>' +
                    '</a>';
            }

            html += '</ul></div></div></div>';

        allFrindsBlock.append(html);
    });

    refreshAvatars();

    if (data.length < 20) {
        showMoreFriends.hide();
    } else {
        showMoreFriends.show();
    }
}

function renderRequests (data) {
    var allFrindsBlock = $('#requests-friends');

    if (isRefresh) {
        allFrindsBlock.html('');
    }

    data.forEach(function(item) {
        var html;

        html = '<div class="col-md-3 user" data-gender="' + item.gender + '">' +
            '<div class="box box-widget widget-user-2">' +
            '<a href="/user/' + item.id + '">';
            if (item.gender == 'male') {
                html += '<div class="widget-user-header bg-purple-active">';
            } else if (item.gender == 'female') {
                html += '<div class="widget-user-header bg-maroon">';
            } else {
                html += '<div class="widget-user-header bg-yellow">';
            }

        html += '<div class="widget-user-image">' +
            '<div id="thumbnail-friends">' +
            '<img alt="thumbnail" src="' + item.smallAvatarLink + '"/>' +
            '<input type="hidden" id="sizeX" name="sizeX" value="' + item.thumbnail.sizeX + '"/>' +
            '<input type="hidden" id="sizeY" name="sizeY" value="' + item.thumbnail.sizeY + '"/>' +
            '<input type="hidden" id="offsetX" name="offsetX" value="' + item.thumbnail.offsetX + '"/>' +
            '<input type="hidden" id="offsetY" name="offsetY" value="' + item.thumbnail.offsetY + '"/>' +
            '</div>' +

            '</div>' +
            '<h3 class="widget-user-username">' + item.name + ' ' + item.second_name + '</h3>' +
            '<h5 class="widget-user-desc">' + item.age + '</h5>' +
            '</div>' +
            '</a>' +
            '<div class="box-footer no-padding">' +
            '<ul class="nav nav-stacked">';

            if (item.geo) {
                if (item.geo.city && item.geo.country) {
                    html += '<li><a href="/search/people?city=' + item.geo.city.id + '&country=' + item.geo.country.id +'">'+ item.geo.city.name +' (' + item.geo.country.name + ')</a></li>';
                } else if (item.geo.country) {
                    html += '<li><a href="/search/people?country=' + item.geo.country.id + '">'+ item.geo.country.name + '</a></li>';
                }
            } else {
                html += '<li><a href="/search/people">Location: none</a></li>';
            }

            if (!userId) {

                html += '<a href="/friends/accept_request_friend" class="ajax-friends-list btn btn-primary btn-block" data-friend="' + item.id + '" data-action="accept">' +
                    '<b>Add to friends</b>' +
                    '</a>' +
                    '<a href="/friends/remove_friend" class="ajax-friends-list btn btn-danger btn-block" data-friend="' + item.id + '" data-action="remove">' +
                    '<b>Reject</b>' +
                    '</a>';
            }

            html += '</ul></div></div></div>';

        allFrindsBlock.append(html);
    });

    refreshAvatars();

    if (data.length < 20) {
        showMoreRequests.hide();
    } else {
        showMoreRequests.show();
    }
}

function updateFriendsCounts (data) {
    var all      = data['all'];
    var requests = data['request'];

    $('a[href="#friends"] span').html(all);
    $('a[href="#requests"] span').html(requests);
    $('.sidebar-menu .pull-right-container .label').html(requests);
}

function renderMutualFriends (data) {
    var allMutualFrindsBlock = $('#mutual-friends');

    if (isRefresh) {
        allMutualFrindsBlock.html('');
    }

    data.forEach(function(item) {
        var html;

        html = '<div class="col-md-3 user" data-gender="' + item.gender + '">' +
            '<div class="box box-widget widget-user-2">' +
            '<a href="/user/' + item.id + '">';
            if (item.gender == 'male') {
                html += '<div class="widget-user-header bg-purple-active">';
            } else if (item.gender == 'female') {
                html += '<div class="widget-user-header bg-maroon">';
            } else {
                html += '<div class="widget-user-header bg-yellow">';
            }

        html += '<div class="widget-user-image">' +
            '<div id="thumbnail-friends">' +
            '<img alt="thumbnail" src="' + item.smallAvatarLink + '"/>' +
            '<input type="hidden" id="sizeX" name="sizeX" value="' + item.thumbnail.sizeX + '"/>' +
            '<input type="hidden" id="sizeY" name="sizeY" value="' + item.thumbnail.sizeY + '"/>' +
            '<input type="hidden" id="offsetX" name="offsetX" value="' + item.thumbnail.offsetX + '"/>' +
            '<input type="hidden" id="offsetY" name="offsetY" value="' + item.thumbnail.offsetY + '"/>' +
            '</div>' +

            '</div>' +
            '<h3 class="widget-user-username">' + item.name + ' ' + item.second_name + '</h3>' +
            '<h5 class="widget-user-desc">' + item.age + '</h5>' +
            '</div>' +
            '</a>' +
            '<div class="box-footer no-padding">' +
            '<ul class="nav nav-stacked">';

            if (item.geo) {
                if (item.geo.city && item.geo.country) {
                    html += '<li><a href="/search/people?city=' + item.geo.city.id + '&country=' + item.geo.country.id +'">'+ item.geo.city.name +' (' + item.geo.country.name + ')</a></li>';
                } else if (item.geo.country) {
                    html += '<li><a href="/search/people?country=' + item.geo.country.id + '">'+ item.geo.country.name + '</a></li>';
                }
            } else {
                html += '<li><a href="/search/people">Location: none</a></li>';
            }

            if (!userId) {
                html += '<a href="http://dev/friends/remove_friend" class="ajax-friends-list btn btn-danger btn-block" data-friend="' + item.id + '" data-action="remove">' +
                    '<b>Remove from friends</b>' +
                    '</a>';
            }

            if (!userId) {
                html += '<a href="http://dev/friends/remove_friend" class="ajax-friends-list btn btn-danger btn-block" data-friend="' + item.id + '" data-action="remove">' +
                    '<b>Remove from friends</b>' +
                    '</a>';
            }

            html += '</ul></div></div></div>';

        allMutualFrindsBlock.append(html);
    });

    refreshAvatars();

    if (data.length < 20) {
        showMoreMutualFriends.hide();
    } else {
        showMoreMutualFriends.show();
    }
}

function renderSearchPeople (data) {
    var allPeople = $('#all-people');

    if (isRefresh) {
        allPeople.html('');
    }

    data.forEach(function(item) {
        var html;

        html = '<div class="col-md-3 user" data-gender="' + item.gender + '">' +
            '<div class="box box-widget widget-user-2">' +
            '<a href="/user/' + item.id + '">';
            if (item.gender == 'male') {
                html += '<div class="widget-user-header bg-purple-active">';
            } else if (item.gender == 'female') {
                html += '<div class="widget-user-header bg-maroon">';
            } else {
                html += '<div class="widget-user-header bg-yellow">';
            }

        html += '<div class="widget-user-image">' +
            '<div id="thumbnail-friends">' +
            '<img alt="thumbnail" src="' + item.smallAvatarLink + '"/>' +
            '<input type="hidden" id="sizeX" name="sizeX" value="' + item.thumbnail.sizeX + '"/>' +
            '<input type="hidden" id="sizeY" name="sizeY" value="' + item.thumbnail.sizeY + '"/>' +
            '<input type="hidden" id="offsetX" name="offsetX" value="' + item.thumbnail.offsetX + '"/>' +
            '<input type="hidden" id="offsetY" name="offsetY" value="' + item.thumbnail.offsetY + '"/>' +
            '</div>' +

            '</div>' +
            '<h3 class="widget-user-username">' + item.name + ' ' + item.second_name + '</h3>' +
            '<h5 class="widget-user-desc">' + item.age + '</h5>' +
            '</div>' +
            '</a>' +
            '<div class="box-footer no-padding">' +
            '<ul class="nav nav-stacked">';

            if (item.geo) {
                if (item.geo.city && item.geo.country) {
                    html += '<li><a href="/search/people?city=' + item.geo.city.id + '&country=' + item.geo.country.id +'">'+ item.geo.city.name +' (' + item.geo.country.name + ')</a></li>';
                } else if (item.geo.country) {
                    html += '<li><a href="/search/people?country=' + item.geo.country.id + '">'+ item.geo.country.name + '</a></li>';
                }
            } else {
                html += '<li><a href="/search/people">Location: none</a></li>';
            }

            html += '</ul></div></div></div>';

        allPeople.append(html);
    });

    refreshAvatars();


    if (data.length < 20) {
        showMorePeople.hide();
    } else {
        showMorePeople.show();
    }
}

function refreshAvatars() {
    $('#thumbnail-friends img').css({
        width: '100%',
        height: '100%',
        position: 'absolute'
    });

    $('#thumbnail-friends img').each(function(i) {
        var thumbnail = $('#thumbnail-friends img').eq(i);

        var width = thumbnail.parent().find('#sizeX').val();
        var height = thumbnail.parent().find('#sizeY').val();
        var offsetX = thumbnail.parent().find('#offsetX').val();
        var offsetY = thumbnail.parent().find('#offsetY').val();

        renderThumbnail(width, height, offsetX, offsetY, thumbnail);
    });
}

function getgeo()
{
    var country = $('#countryId').val();
    var city    = $('#cityId').val();
    var url     = '/geo_ajax';

    if (country) {
        url += '?country=' + country;
    }

    $.ajax({
        type: "get",
        url: url,
        success: function(data) {
            renderSelects(data);
        }
    });
}

function renderSelects(data)
{
    var countrySelect = $('#countries');
    var citySelect    = $('#cities');
    var countryId     = $('#countryId');
    var cityId        = $('#cityId');

    countrySelect.html('');

    countrySelect.append('<option value="null">Select country</option>');
    data.countries.forEach(function(item) {
        countrySelect.append('<option value="' + item.Code + '">' + item.Name + '</option>');
    });

    citySelect.html('');

    if (data.cities != undefined && data.cities.length > 0) {
        citySelect.prop('disabled', false);
        citySelect.append('<option value="null">Select city</option>');
        data.cities.forEach(function(item) {
            citySelect.append('<option value="' + item.ID + '">' + item.Name + '</option>');
        });
    } else {
        citySelect.prop('disabled', true);
    }
    countrySelect.val(countryId.val());
    citySelect.val(cityId.val());
}
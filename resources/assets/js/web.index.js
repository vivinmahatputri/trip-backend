let base_url = process.env.MIX_APP_URL+'/api/';
// let base_url = 'http://wesata.gg/api/';

//featured
$.get(base_url+"tourism/top", function(data){
    let payload = data.payload;

    $("#loader-featured").hide();

    payload.slice(0, 4).forEach(function (featured) {
        let address = featured.location.city == 'Undefined city name' ? featured.location.province : featured.location.city+', '+featured.location.province;
        var html = '<div class="col-md-3 col-sm-6 col-xs-12">\n' +
            '                    <article class="card">\n' +
            '                        <a href="'+featured.web_url+'" class="featured-image" style="background-image: url('+featured.pictures[0].url+')">\n' +
            '                            <div class="featured-img-inner"></div>\n' +
            '                        </a>\n' +
            '                        <div class="card-details">\n' +
            '                            <h4 class="card-title"><a href="'+featured.web_url+'">'+featured.name+'</a></h4>\n' +
            '                            <div class="meta-details clearfix">\n' +
            '                                <ul class="hierarchy">\n' +
            '                                    <li class="symbol"><i class="fa fa-map-marker"></i></li>\n' +
            '                                    <li><a href="'+featured.web_province_url+'">'+address+'</a></li>\n' +
            '                                </ul>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                    </article>\n' +
            '                </div>';

        $("#featured-destinations").append(html);
    });

});

//adventure
$.get(base_url+"tourism/category/6", function(data){
    let payload = data.payload;
    let key = 0;
    $("#adventure").html("");
    payload.slice(0, 3).forEach(function (item) {
        let address = item.location.city == 'Undefined city name' ? item.location.province : item.location.city+', '+item.location.province;
        if(key === 0) {
            var html = '<div class="panel panel-default" style="background-image: url(' + item.pictures[0].url + ');">\n' +
                '                                <div id="' + item.id + '" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading' + item.id + '">\n' +
                '                                    <div class="panel-body">\n' +
                '                                        <div class="read-more">Details <i class="fa fa-arrow-right"></i></div>\n' +
                '                                        <a href="'+item.web_url+'"><div class="spacer"></div></a>\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                                <a data-toggle="collapse" data-parent="#adventure" href="#' + item.id + '" aria-expanded="true" aria-controls="' + item.id + '">\n' +
                '                                    <div class="panel-heading" role="tab" id="heading' + item.id + '">\n' +
                '                                        <div class="panel-icon">\n' +
                '                                            <i class="fa fa-map-marker"></i>\n' +
                '                                        </div>\n' +
                '                                        <h4 class="panel-title">' + item.name + '</h4>\n' +
                '                                        <ul class="hierarchy">\n' +
                '                                            <li>' + address + '</li>\n' +
                '                                        </ul>\n' +
                '                                    </div>\n' +
                '                                </a>\n' +
                '                            </div>';

        }

        else {
            var html = '<div class="panel panel-default" style="background-image: url(' + item.pictures[0].url + ');">\n' +
                '                                <div id="' + item.id + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' + item.id + '">\n' +
                '                                    <div class="panel-body">\n' +
                '                                        <div class="read-more">Details <i class="fa fa-arrow-right"></i></div>\n' +
                '                                        <a href="'+item.web_url+'"><div class="spacer"></div></a>\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                                <a data-toggle="collapse" data-parent="#adventure" href="#' + item.id + '" aria-expanded="true" aria-controls="' + item.id + '">\n' +
                '                                    <div class="panel-heading" role="tab" id="heading' + item.id + '">\n' +
                '                                        <div class="panel-icon">\n' +
                '                                            <i class="fa fa-map-marker"></i>\n' +
                '                                        </div>\n' +
                '                                        <h4 class="panel-title">' + item.name + '</h4>\n' +
                '                                        <ul class="hierarchy">\n' +
                '                                            <li>' + address + '</li>\n' +
                '                                        </ul>\n' +
                '                                    </div>\n' +
                '                                </a>\n' +
                '                            </div>';
        }

        $("#adventure").append(html);

        key++;

    });
});

//beach
$.get(base_url+"tourism/category/3", function(data){
    let payload = data.payload;
    let key = 0;
    $("#beach").html("");
    payload.slice(0, 3).forEach(function (item) {
        let address = item.location.city == 'Undefined city name' ? item.location.province : item.location.city+', '+item.location.province;
        if(key === 0) {
            var html = '<div class="panel panel-default" style="background-image: url(' + item.pictures[0].url + ');">\n' +
                '                                <div id="' + item.id + '" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading' + item.id + '">\n' +
                '                                    <div class="panel-body">\n' +
                '                                        <div class="read-more">Details <i class="fa fa-arrow-right"></i></div>\n' +
                '                                        <a href="'+item.web_url+'"><div class="spacer"></div></a>\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                                <a data-toggle="collapse" data-parent="#beach" href="#' + item.id + '" aria-expanded="true" aria-controls="' + item.id + '">\n' +
                '                                    <div class="panel-heading" role="tab" id="heading' + item.id + '">\n' +
                '                                        <div class="panel-icon">\n' +
                '                                            <i class="fa fa-map-marker"></i>\n' +
                '                                        </div>\n' +
                '                                        <h4 class="panel-title">' + item.name + '</h4>\n' +
                '                                        <ul class="hierarchy">\n' +
                '                                            <li>' + address + '</li>\n' +
                '                                        </ul>\n' +
                '                                    </div>\n' +
                '                                </a>\n' +
                '                            </div>';

        }

        else {
            var html = '<div class="panel panel-default" style="background-image: url(' + item.pictures[0].url + ');">\n' +
                '                                <div id="' + item.id + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' + item.id + '">\n' +
                '                                    <div class="panel-body">\n' +
                '                                        <div class="read-more">Details <i class="fa fa-arrow-right"></i></div>\n' +
                '                                        <a href="'+item.web_url+'"><div class="spacer"></div></a>\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                                <a data-toggle="collapse" data-parent="#beach" href="#' + item.id + '" aria-expanded="true" aria-controls="' + item.id + '">\n' +
                '                                    <div class="panel-heading" role="tab" id="heading' + item.id + '">\n' +
                '                                        <div class="panel-icon">\n' +
                '                                            <i class="fa fa-map-marker"></i>\n' +
                '                                        </div>\n' +
                '                                        <h4 class="panel-title">' + item.name + '</h4>\n' +
                '                                        <ul class="hierarchy">\n' +
                '                                            <li>' + address + '</li>\n' +
                '                                        </ul>\n' +
                '                                    </div>\n' +
                '                                </a>\n' +
                '                            </div>';
        }

        $("#beach").append(html);

        key++;

    });
});

//escape
$.get(base_url+"tourism/category/5", function(data){
    let payload = data.payload;
    let key = 0;
    $("#crowd-escape").html("");
    payload.slice(0, 3).forEach(function (item) {
        let address = item.location.city == 'Undefined city name' ? item.location.province : item.location.city+', '+item.location.province;
        if(key === 0) {
            var html = '<div class="panel panel-default" style="background-image: url(' + item.pictures[0].url + ');">\n' +
                '                                <div id="' + item.id + '" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading' + item.id + '">\n' +
                '                                    <div class="panel-body">\n' +
                '                                        <div class="read-more">Details <i class="fa fa-arrow-right"></i></div>\n' +
                '                                        <a href="'+item.web_url+'"><div class="spacer"></div></a>\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                                <a data-toggle="collapse" data-parent="#crowd-escape" href="#' + item.id + '" aria-expanded="true" aria-controls="' + item.id + '">\n' +
                '                                    <div class="panel-heading" role="tab" id="heading' + item.id + '">\n' +
                '                                        <div class="panel-icon">\n' +
                '                                            <i class="fa fa-map-marker"></i>\n' +
                '                                        </div>\n' +
                '                                        <h4 class="panel-title">' + item.name + '</h4>\n' +
                '                                        <ul class="hierarchy">\n' +
                '                                            <li>' + address + '</li>\n' +
                '                                        </ul>\n' +
                '                                    </div>\n' +
                '                                </a>\n' +
                '                            </div>';

        }

        else {
            var html = '<div class="panel panel-default" style="background-image: url(' + item.pictures[0].url + ');">\n' +
                '                                <div id="' + item.id + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' + item.id + '">\n' +
                '                                    <div class="panel-body">\n' +
                '                                        <div class="read-more">Details <i class="fa fa-arrow-right"></i></div>\n' +
                '                                        <a href="'+item.web_url+'"><div class="spacer"></div></a>\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                                <a data-toggle="collapse" data-parent="#crowd-escape" href="#' + item.id + '" aria-expanded="true" aria-controls="' + item.id + '">\n' +
                '                                    <div class="panel-heading" role="tab" id="heading' + item.id + '">\n' +
                '                                        <div class="panel-icon">\n' +
                '                                            <i class="fa fa-map-marker"></i>\n' +
                '                                        </div>\n' +
                '                                        <h4 class="panel-title">' + item.name + '</h4>\n' +
                '                                        <ul class="hierarchy">\n' +
                '                                            <li>' + address + '</li>\n' +
                '                                        </ul>\n' +
                '                                    </div>\n' +
                '                                </a>\n' +
                '                            </div>';
        }

        $("#crowd-escape").append(html);

        key++;

    });
});

//featured
$.get(base_url+"timeline/fresh?type=picture", function(data){
    let payload = data.payload.data;
    $("#submission").html("");
    console.log(payload);
    payload.slice(0, 4).forEach(function (submission) {

        let address = submission.tourism.location.city == 'Undefined city name' ? submission.tourism.location.province : submission.tourism.location.city+', '+submission.tourism.location.province;
        if(submission.type == 'picture') {
            var html = '<div class="col-md-3 col-sm-6">\n' +
                '                <article class="post">\n' +
                '                    <div class="card">\n' +
                '                        <header class="entry-header">\n' +
                '                            <a href="'+submission.tourism.web_url+'">\n' +
                '                                <div class="entry-thumbnail" style="background-image: url('+submission.submission_data.url+')">\n' +
                '                                    <img alt="" title="" src="images/blog-placeholder-vertical.png" width="600" height="800">\n' +
                '                                </div>\n' +
                '                                <h2 class="entry-title">'+submission.tourism.name+', '+address+'</h2>\n' +
                '                            </a>\n' +
                '                        </header>\n' +
                '                        <footer class="entry-meta clearfix">\n' +
                '                            <span class="byline"><i class="fa fa-user"></i> <span class="author vcard"><a class="url fn n" href="#">'+submission.user.name+'</a></span></span>\n' +
                '                            <span class="posted-on"><a href="#" rel="bookmark"><time class="entry-date published" datetime="2014-11-12T00:15:40+00:00">'+submission.date+'</time></a></span>\n' +
                '                        </footer>\n' +
                '                    </div>\n' +
                '                </article>\n' +
                '            </div>';
        }

        $("#submission").append(html);
    });

});
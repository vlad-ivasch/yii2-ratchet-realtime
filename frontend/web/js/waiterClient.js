$(document).ready(function () {


    $(".countdown").each(function () {
        var date = $(this).data("date");
        $(this).timeTo(new Date(date));
    });

    var conn = new ab.connect('ws://localhost:8080',
        function (session) {
            session.subscribe('statusChange',
                function (topic, data) {
                    if (data.status == 1) {
                        $("#order" + data.id).addClass('panel-info');
                        $("#order" + data.id).find(".panel-body").append('<br>Cooking time: ' + data.time + ' minutes');
                        $("#order" + data.id).find(".panel-body").append('<br><div id="countdown' + data.id + '"></div>');
                        $("#countdown" + data.id).timeTo(new Date(data.timeStart), function () {
                            $("#order" + data.id).addClass('panel-success');

                        });
                    } else {
                        $("#order" + data.id).find("#countdown" + data.id).timeTo('stop')
                        $("#order" + data.id).find(".countdown").timeTo('stop')
                        $("#order" + data.id).removeClass('panel-info');
                        $("#order" + data.id).addClass('panel-success');
                        $("#order" + data.id).find('.glyphicon').removeClass('glyphicon-time');
                        $("#order" + data.id).find('.glyphicon').addClass('glyphicon-ok');


                    }
                }
            )


        },
        function (code, reason, detail) {
            console.warn(code);

        },
        {
            'maxRetreis': 60,
            'retryDelay': 4000,
            'skipSubprotocolCheck': true


        })
})
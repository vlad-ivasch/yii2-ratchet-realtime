$(document).ready(function () {

    $(".countdown").each(function () {
       var date = $(this).data("date");
       $(this).timeTo(new Date(date));
    });


    var conn = new ab.connect('ws://localhost:8080',
        function (session) {
            session.subscribe('newOrder',
                function (topic, data) {
                    $(".orders").prepend('<div class="panel panel-default">' +
                        '<div class="panel-heading"><h3 class="panel-title">' +
                        '<span class="mealName">'
                        +data.meal+'</span>' +
                        '<span class="glyphicon glyphicon-time"></span>' +
                        '</h3></div' +
                        '><div class="panel-body">Table <span class="seat">'+data.seat+'</span>' +
                        '<br>' +
                        'Created by <span class="waiter">'+data.waiter+'</span><div class="cookingTimeWrapper"><hr>Cooking time<br><input type="text" name="timeCooking"> <button type="button" class="status-button btn-success" data-id='+data.id+'>Done</button>'+
                        '</div>'+
                        '</div></div>'
                    );
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
});


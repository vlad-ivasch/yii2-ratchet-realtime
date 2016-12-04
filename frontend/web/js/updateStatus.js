$(document).ready(function () {
    $("body").on('click', '.done-button', function () {
        var id = $(this).data('id');
        var __this = this;

        $.ajax({
            url: '/kitchen/yii-application/frontend/web/index.php/kitchener/done',
            type: 'post',
            data: {
                'id': id
            },
            success: function (data) {
                $(__this).parent().parent().detach();


            }
        })
    });

    $("body").on('click', '.status-button', function () {
        var id = $(this).data('id');
        var __this = this;
        var panelBody = $(this).parent().parent();
        var time = parseInt($("input[name='timeCooking']").val());
        if (!time) {
            alert('Put cooking time in minutes');
        } else {
            $.ajax({
                url: '/kitchen/yii-application/frontend/web/index.php/kitchener/change-status',
                type: 'post',
                data: {
                    'id': id,
                    'time': time
                },
                success: function (data) {
                    $(panelBody).append('<br><div id="countdown' + id + '"></div>');
                    $("#countdown" + id).timeTo(new Date(data.timeStart), function () {
                        $("#order" + id).addClass('panel-info');

                        $("#order" + id).addClass('panel-success');
                    });
                    $(panelBody).append('<br><button type="button" class="done-button btn-success" data-id=' + id + '>Done</button>');
                    $(__this).parent().detach();

                }
            })
        }


    });
})

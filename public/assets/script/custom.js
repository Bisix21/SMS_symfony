function custom_alert(e, time) {
    $(e).each(function () {
        $(e).fadeIn(1000, function () {
            setTimeout(function () {
                $(e).fadeOut(1000, function () {
                    $(e).remove()
                })
            }, time * 1000)
        })
    });
}

function custom_toast(e, time) {
    $(e).each(function () {
        $(e).addClass('show');
        setTimeout(function () {
            $(e).fadeOut(1000, function () {
                $(e).removeClass('show')
            })
        }, time * 1000)
    });
}



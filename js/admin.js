$(document).ready(function () {
    $(".qManage .qm").click(function (e) {
        var thisElement = $(this);
        $.ajax({
            type: 'get',
            url: "ajax.php",
            data: {action: thisElement.attr('id')},
            success: function (response) {
                alert(response);
                setTimeout("location.href='" + window.location.href + "'", 1000);
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    });

    $(".qManage .qmr").click(function (e) {
        $(this).parent().parent().find('.r').fadeToggle(500);
    });

    $(".replyForm").submit(function (e) {
        e.preventDefault()
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: $(this).serialize(),
            success : function (res) {
                alert(res)
                setTimeout(function () {
                    location.reload()
                },1000)
            }
        })

    })

});
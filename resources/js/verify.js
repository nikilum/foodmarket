$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

$(document).ready(function () {
    isTimerActive = false;
    $('.bottom-ref').on('click', function () {
        if (isTimerActive === true)
            return false
        $.ajax({
            url: "verify",
            method: "PATCH",
            dataType: 'json',
            contentType: 'application/json',
            success: () => {
                setTimer()
            },
            error: (msg) => {
                if(msg.responseJSON.message === "Too Many Attempts.")
                    $('.bottom-ref').text('Количество попыток истекло. Попробуйте ещё раз через час.')
            }
        })
    })

    $('#mailConfirmButton').on('click', function () {

        let user_verify = $('#inputCode').val()
        let verify_info = {
            verify_code: user_verify
        };
        if (!user_verify) {
            $('#codeError').text('Введите код');
            return false
        }

        $.ajax({
            url: 'verify',
            method: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(verify_info),
            success: (msg) => {
                if (msg.status === 'verify failed') {
                    $('#codeError').text('Введён неверный код')
                    return false
                }
                window.location.href = window.location.origin;
            },
            error: (msg) => {
                $('#codeError').text('Неизвестная ошибка. Попробуйте ещё раз')
            }
        })
    })

})


function setTimer() {
    isTimerActive = true
    let time = 61
    let timer = setInterval(function () {
        time -= 1

        $('.bottom-ref').html('Код был отправлен. Вы можете отправить его ещё раз через <span>' +
            time + '</span> секунд')

        if (time === 0) {
            isTimerActive = false
            $('.bottom-ref').text('Не пришёл код? Вы можете отправить письмо ещё раз')
            clearInterval(timer)
        }
    }, 1000)
}

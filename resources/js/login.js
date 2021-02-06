$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#submitButton').on('click', function () {

        let email = $('#inputEmail').val()
        let password = $('#inputPassword').val()

        //====================== Проверки входящих данных ======================

        /**************************
         * 1. Проверка на наличие обязательных входных данных - пароля и почты
         * 2. Проверка на правильность входных данных почты (собачка в начале, точка в конце)
         ***************************/

        let slicedMail = email.match('(.*)(@)(.*)(\\.)(.*)')
        let mailError = false;

        if (!email || !password
            || !slicedMail || slicedMail.indexOf("") !== -1) {

            if (!email) {
                $('#mailError').text('Введите почту.')
                mailError = true
            } else {
                $('#mailError').text('')
            }

            if (!password) {
                $('#passwordError').text('Введите пароль.')
            } else {
                $('#passwordError').text('')
            }

            if ((!slicedMail || slicedMail.indexOf('') !== -1) && mailError === false) {
                $('#mailError').text('Неверный формат почты.')
            } else if (mailError === false) {
                $('#mailError').text('')
            }
            return false
        }
        $('#mailError').text('')
        $('#passwordError').text('')

        //====================== Отправка запроса ======================

        let user_email = $('#inputEmail').val()
        let user_password = $('#inputPassword').val()
        let user_info = {user_email: user_email, user_password: user_password}

        console.log('sent')

        $.ajax({
            url: 'login',
            method: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(user_info),
            success: (msg) => {
                window.location.href = window.location.origin
            },
            error: (msg) => {
                console.log(msg)
            }
        })
    })
})

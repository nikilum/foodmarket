$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

$(document).ready(function () {
    isTimerActive = false
    setConstantHandlers()
    $('#inputPhone').mask('+9(999)999-99-99') //Установка маски для ввода телефона
    $('#inputPhone').on('click', function () { //Установка каретки в начало маски ввода номера
        $('#inputPhone').focus()
    })

    $('#submitButton').on('click', function () {

        //====================== Получение входящих данных ======================

        let email = $('#inputEmail').val()
        let password = $('#inputPassword').val().replace(' ', '')
        let nameSurname = $('#inputName').val() + ' ' + $('#inputSurname').val()
        let address = $('#inputAddress').val()
        let phone = $('#inputPhone').val()
        user_info = {
            user_email: email,
            user_password: password,
            user_name: nameSurname,
            user_address: address,
            user_phone: phone
        }

        //====================== Проверки входящих данных ======================

        /**************************
         * 1. Проверка на наличие обязательных входных данных - пароля и почты
         * 2. Проверка на правильность входных данных почты (собачка в начале, точка в конце)
         * 3. Проверка на длину пароля - не менее 8 символов, не более 32 символов
         ***************************/

        let mailError = false
        let passwordError = false
        let slicedMail = email.match('(.*)(@)(.*)(\\.)(.*)')

        if (!email || !password
            || !slicedMail || slicedMail.indexOf("") !== -1
            || password.length < 8 || password.length > 32) {


            if (!email && mailError === false) {
                $('#mailError').text('Введите почту.')
                mailError = true
            } else if (mailError === false)
                $('#mailError').text('')
            if (!password && passwordError === false) {
                $('#passwordError').text('Введите пароль.')
                passwordError = true
            } else if (passwordError === false)
                $('#passwordError').text('')

            if (password.length < 8 && passwordError === false) {
                $('#passwordError').text('Минимальная длина пароля: 8')
                passwordError = true
            } else if (passwordError === false)
                $('#passwordError').text('')

            if (password.length > 32 && passwordError === false) {
                $('#passwordError').text('Максимальная длина пароля: 32')
                passwordError = true
            } else if (passwordError === false)
                $('#passwordError').text('')

            if ((!slicedMail || slicedMail.indexOf('') !== -1) && mailError === false) {
                $('#mailError').text('Неверный формат почты.')
                mailError = true
            } else if (mailError === false)
                $('#mailError').text('')

            return false
        }

        $('#mailError').text('')
        $('#passwordError').text('')

        //============== Запрос на проверку почты ==============

        $.ajax({
            url: 'register',
            method: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(user_info),
            success: (msg) => {
                if (msg.status === 'email alerady exists') {
                    $('#mailError').text('Аккаунт уже существует.')
                    return false
                }
                createVerifyForm()
            },
            error: (msg) => {
                console.log(msg)
                $('.unexpected-error-box').text('Ошибка регистрации. Попробуйте ещё раз.')
            }
        })
    })

    //============== Создание нового аккаунта ==============

    $('.register-form').on('click', '#mailConfirmButton', function () {

        let user_verify = $('#inputCode').val()
        let verify_info = {
            user_email: user_info.user_email,
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
                console.log(msg)
                $('#codeError').text('Неизвестная ошибка. Попробуйте ещё раз')
            }
        })
    })
})

//============== Анимация перехода на следующий этап регистрации ==============

function createVerifyForm() {

    $('.progress-bar').css('width', '50%')
    $('.register-form').animate({opacity: '0'});
    $('.bottom-ref').text('Не пришёл код? Вы можете отправить письмо ещё раз').removeAttr('href')
    $('.register-container').animate({height: '165px', width: '450px'})
    setTimeout(() => {
        $('.register-form')
            .html('<div class="form-group">\n' +
                '<label for="inputCode">Код подтвеждения был отправлен вам на почту</label>' +
                '<input id="inputCode" type="text"' +
                'class="form-control" placeholder="ieglmxexkmshvoy8" aria-describedby="codeError">' +
                '</div>' +
                '<button class="btn btn-success" id="mailConfirmButton">Подтвердить</button>' +
                '<small id="codeError" class="error-message unexpected-error-box"></small>')
            .animate({opacity: '1'})
    }, 450)
    $('.bottom-ref').on('click', function () {
        if (isTimerActive === true)
            return false
        $.ajax({
            url: "verify",
            method: "PATCH",
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({
                user_email: user_info.user_email
            }),
            success: () => {
                setTimer()
            },
            error: (msg) => {
                if(msg.responseJSON.message === "Too Many Attempts.")
                    $('.bottom-ref').text('Количество попыток истекло. Попробуйте ещё раз через час.')
            }
        })
    })
}

function setConstantHandlers() {
    $('#inputPassword').on('input', function () {
        $("#inputPassword").val($("#inputPassword").val().replace(' ', ''))
    })
}

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


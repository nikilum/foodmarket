$(document).ready(function () {
    takeUserData()
    $('#inputPhone').mask('+9(999)999-99-99') //Установка маски для ввода телефона
    $('#inputPhone').on('click', function () { //Установка каретки в начало маски ввода номера
        $('#inputPhone').focus()
    })
})

function takeUserData() {
    $.ajax({
        url: "user",
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        contentType: "application/json",
        success: (msg) => {
            $('#inputName').val(msg.user_name.split(' ')[0])
            $('#inputSurname').val(msg.user_name.split(' ')[1])
            $('#inputAddress').val(msg.user_address)
            $('#inputPhone').val(msg.user_phone)
            setButtonHandlers()
        }
    })
}

function setButtonHandlers() {
    $('#submitButton').on('click', function () {
        let userData = {}
        userData['user_name'] = $('#inputName').val() + " " + $('#inputSurname').val()
        userData['user_address'] = $('#inputAddress').val()
        userData['user_phone'] = $('#inputPhone').val()
        $.ajax({
            url: "user",
            method: "PATCH",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify(userData),
            success: () => {
                $('#dataError').text('Данные успешно изменены')
            },
            error: () => {
                $('#dataError').text('Неизвестная ошибка. Попробуйте ещё раз')
            }
        })
    })

    $('#submitPassButton').on('click', function () {
        let oldPass = $('#inputOldPass').val()
        let newPass = $('#inputPass').val()
        if(newPass.length < 8) {
            $('#passwordError').text('Длина пароля должна быть больше 8 символов')
            return false
        }
        $.ajax({
            url: "user/password",
            method: "PATCH",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify({
                old_password: oldPass,
                new_password: newPass
            }),
            error: () => {
                $('#passwordError').text('Ошибка. Проверьте введённые данные')
            },
            success: () => {
                $('#passwordError').text('Пароль успешно изменён')
            }
        })
    })
}

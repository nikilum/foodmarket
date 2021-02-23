$(document).ready(function () {
    if(typeof getBalance === "function")
        getBalance()
    update_request = false
    takeProducts()
    takeCart()
    setConstantHandlers()
    $('#userPhone').mask('+9(999)999-99-99') //Установка маски для ввода телефона
    $('#userPhone').on('click', function () { //Установка каретки в начало маски ввода номера
        $('#userPhone').focus()
    })
})

function takeProducts() {
    $.ajax({
        url: "products",
        method: "GET",
        dataType: "json",
        contentType: "application/json",
        success: (msg) => {
            loadProducts(msg) // Загрузка продуктов в зависимости от группы пользователя
            setProductHandlers()
        }
    })
}

function loadProducts(msg) {
    if (msg.user_verify === true) {
        for (let i = 0; i < msg.data.length; i++) {
            let product = msg.data[i]
            let productCard = '<div class="card product-card">\n' +
                '<div class="img-container">' +
                '            <img src="storage/app/public/products/' + product.product_image_name + '"\n' +
                '                 class="card-img-top product-img" alt="изображение товара">\n' +
                '<button class="add-to-cart-btn fa fas fa-shopping-cart" data-id="' +
                product.product_id +
                '"></button>' +
                '<input type="number" value="1" class="product-quantity">' +
                '<div class="product-price">' +
                '<span class="product-price-text">' + product.product_price + ' <b>₽</b>' +
                '</span>' +
                '</div>' +
                '</div>' +
                '            <div class="card-body">\n' +
                '                <h5 class="card-title">' + product.product_name + '</h5>\n' +
                '                <hr class="bg-light">\n' +
                '                <div class="card-text">' + product.product_description + '</div>\n' +
                '            </div>\n' +
                '            <a href="products/' + product.product_id +
                '" class="stretched-link product-link"></a>\n' +
                '        </div>'

            $("#products").append(productCard)
        }
    } else {
        for (let i = 0; i < msg.data.length; i++) {
            let product = msg.data[i]
            let productCard = '<div class="card product-card">\n' +
                '<div class="img-container">' +
                '            <img src="storage/app/public/products/' + product.product_image_name + '"\n' +
                '                 class="card-img-top product-img" alt="изображение товара">\n' +
                '<div class="product-price">' +
                '<span class="product-price-text">' + product.product_price + ' <b>₽</b>' +
                '</span>' +
                '</div>' +
                '</div>' +
                '            <div class="card-body">\n' +
                '                <h5 class="card-title">' + product.product_name + '</h5>\n' +
                '                <hr class="bg-light">\n' +
                '                <div class="card-text">' + product.product_description + '</div>\n' +
                '            </div>\n' +
                '            <a href="products/' + product.product_id +
                '" class="stretched-link product-link"></a>\n' +
                '        </div>'
            $("#products").append(productCard)
        }
    }
}

function takeCart() {
    $('#sidebar').children('.cart-item').remove()
    $.ajax({
        url: "cart_products",
        method: "GET",
        dataType: "json",
        contentType: "application/json",
        success: (msg) => {
            loadCart(msg)
            setCartHandlers()
        }
    })
}

function loadCart(msg) {
    if (msg.user_email === "guest")
        return false

    for (let i = 0; i < msg.data.length; i++) {

        let cartItem = msg.data[i]

        let visualisedCartItem = '<div class="cart-item">\n' +
            '<button class="delete-cart-item fas fa-times"></button>' +
            '            <img src="storage/app/public/products/' + cartItem.product_image_name +
            '" class="cart-item-img" alt="product">\n' +
            '            <div class="cart-item-quantity-container cart-item-bar">\n' +
            '                <button class="lower-quantity btn quantity-editor-btn fas fa-caret-left"></button>\n' +
            '                <input type="number" data-price="' + cartItem.product_price +
            '" data-id="' + cartItem.product_id + '" class="cart-item-quantity" value="' + cartItem.product_quantity +
            '">\n' +
            '                <button class="higher-quantity btn quantity-editor-btn fas fa-caret-right"></button>\n' +
            '            </div>\n' +
            '            <div class="cart-item-price cart-item-bar">' +
            Number(cartItem.product_quantity) * Number(cartItem.product_price) + ' ' +
            '₽</div>\n' +
            '            <div class="cart-item-text">\n' +
            '                <div class="cart-item-header">' +
            cartItem.product_name +
            '</div>\n' +
            '            </div>\n' +
            '        </div>'
        $('#sidebar').append(visualisedCartItem)
    }
    checkForProducts()
}

function setConstantHandlers() {
    isCartOpened = false
    $('#openCartBtn').on('click', function () {
        if (isCartOpened === false) {
            takeCart()
            $('#sidebar').animate({width: '25rem'})
            $('.foreground').css('z-index', '999').animate({opacity: 100}, 400, 'linear', () => {
                $('body').css('overflow', 'hidden')
            })
            setTimeout(() => {
                $('.shopping-cart-open-btn').css('right', '24rem').css('background', '#538a3c')
            }, 100)
            isCartOpened = true
        } else {
            $('#sidebar').animate({width: '0'})
            $('.foreground').animate({opacity: 0}, 400, 'linear', () => {
                $('.foreground').css('z-index', '-1')
                $('body').css('overflow', 'visible')
            })
            setTimeout(() => {
                $('.shopping-cart-open-btn').css('right', '2%').css('background', '#cb9f55')
            }, 100)
            isCartOpened = false
        }
    })

    $('#submitButton').on('click', function () {
        let userName = $('#userName').val()
        let userAddress = $('#userAddress').val()
        let userPhone = $('#userPhone').val()
        let userAdditional = $('#userAdditional').val()
        if(userAdditional.length > 4000) {
            $('#modalError').text('Доп. информация слишком длинная')
            return false
        }
        if(!userName || !userPhone || !userAddress) {
            $('#modalError').text('Заполните все поля перед отправкой заказа')
            return false
        }
        $('#modalError').text('')
        $.ajax({
            url: "uorders",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify({
                user_name: userName,
                user_address: userAddress,
                user_phone: userPhone,
                user_additional: userAdditional
            }),
            success: (msg) => {
                console.log(msg)
                if(msg.status === "too much orders") {
                    $('#modalError').text('У вас слишком много активных заказов')
                    return false
                }
                if(msg.status === "not enough money") {
                    $('#modalError').text('У вас недостаточно денег')
                    return false
                }
                $('#orderModal').modal('hide')
                takeCart()
                getBalance()
            }
        })

    })
}

function setProductHandlers() {
    $('.product-quantity').on('change', function () {
        if ($(this).val() < 1)
            $(this).val(1)
        if ($(this).val() > 99)
            $(this).val(99)
    })
    $('.product-quantity').on('keyup', function () { //TODO пофиксить
        if ($(this).val() < 1)
            $(this).val(0)
        if ($(this).val() > 99)
            $(this).val(99)
    })
    $('.add-to-cart-btn').on('click', function () {
        let product_id = $(this).attr('data-id')
        let product_quantity = $(this).parent().children('.product-quantity').val()
        $.ajax({
            url: 'cart_products',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify({
                product_id: Number(product_id),
                product_quantity: Number(product_quantity)
            }),
            success: () => {
                takeCart()
            }
        })
    })
}

function setCartHandlers() {
    $('.higher-quantity').off()
    $('.higher-quantity').on('click', function () {
        let product = $(this).parent().children('.cart-item-quantity')
        if (product.val() > 98) {
            product.val(99)
            return false
        }
        product.val(Number(product.val()) + 1)
        updatePrice($(this).parent().children('.cart-item-quantity'))
        cartUpdate()
    })
    $('.lower-quantity').off()
    $('.lower-quantity').on('click', function () {
        let product = $(this).parent().children('.cart-item-quantity')
        if (product.val() < 2) {
            product.val(1)
            return false
        }
        product.val(Number(product.val()) - 1)
        updatePrice($(this).parent().children('.cart-item-quantity'))
        cartUpdate()
    })
    $('.cart-item-quantity').off()
    $('.cart-item-quantity')
        .on('keyup', function () {
            if ($(this).val() < 1)
                $(this).val(0)
            if ($(this).val() > 98)
                $(this).val(99)
            updatePrice(this)
            cartUpdate()
        })
        .on('keydown', function () {
            if ($(this).val() < 1)
                $(this).val(0)
            if ($(this).val() > 98)
                $(this).val(99)
        })
        .on('change', function () {
            let currentQuantity = Number($(this).val())
            if (currentQuantity === 0)
                $(this).val(1)
            updatePrice(this)
            cartUpdate()
        })
    $('.delete-cart-item').off()
    $('.delete-cart-item').on('click', function () {
        let product_id = $(this)
            .parent()
            .children('.cart-item-quantity-container')
            .children('.cart-item-quantity')
            .attr('data-id')
        $.ajax({
            url: 'cart_products/' + product_id,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            contentType: "application/json",
            success: () => {
                $(this).parent().remove()
                checkForProducts()
            }
        })
    })
    $("#sendOrderButton").off()
    $("#sendOrderButton").on('click', function () {
        $.ajax({
            url: "usettings",
            method: "GET",
            dataType: "json",
            contentType: "application/json",
            success: (msg) => {
                $('#userPhone').val(msg.user_phone)
                $('#userAddress').val(msg.user_address)
                $('#userName').val(msg.user_name)
            }
        })
        $('#orderModal').modal('show')
    })
}

function updatePrice(current) {
    if ($(current).val() < 1 || $(current).val() > 99)
        return false
    let quantity = $(current).val()
    let price = $(current).attr('data-price')
    let fullPrice = quantity * price
    $(current).parent().parent().children('.cart-item-price').text(fullPrice + " ₽")
}

function cartUpdate() {
    clearTimeout(update_request)
    update_request = setTimeout(function () {
        let cart_data = {}
        $('#sidebar').children('.cart-item').each(function (i) {
            let quantity_input = $(this).children('.cart-item-quantity-container').children('.cart-item-quantity')
            let product_id = Number(quantity_input.attr('data-id'))
            let product_quantity = Number(quantity_input.val())
            cart_data['product_' + product_id] = {product_id: product_id, product_quantity: product_quantity}
        })
        $.ajax({
            url: 'cart_products/0',
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify({cart_data: cart_data})
        })
    }, 2000)
}

function checkForProducts() {
    if($('#sidebar').children('.cart-item').length === 0)
        $('#sendOrderButton').css('display', 'none')
    else
        $('#sendOrderButton').css('display', 'inline-block')
}

$(document).ready(function () {
    getBalance()
    $('#userPhone').mask('+9(999)999-99-99') //Установка маски для ввода телефона
    $('#userPhone').on('click', function () { //Установка каретки в начало маски ввода номера
        $('#userPhone').focus()
    })
    updateTable()
    setConstantHandlers()
});

function updateTable() {
    $('#orders').DataTable({
        dom: '<"table-navbar"lfr>t<"table-navbar"ip>',
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json'
        },
        ajax: {
            url: "uorders",
            method: "GET",
            dataType: "json",
            contentType: "application/json",
            // Обработка json файла и создание соответствующей таблицы
            dataSrc: (json) => {
                for (let i = 0; i < json.data.length; i++) {
                    if (json.data[i]['order_status'] === "completed" || json.data[i]['order_status'] === "accepted") {
                        json.data[i]['order_delete'] = "<div class='fas fa-lock blocked-href'></div>"
                        json.data[i]['order_edit'] = "<div class='fas fa-lock blocked-href'></div>"
                    } else {
                        json.data[i]['order_delete'] = "<div class='fas fa-times row-delete-href'></div>"
                        json.data[i]['order_edit'] = "<div class='fas fa-edit table-href order-edit-href'></div>"
                    }
                    json.data[i]["order_detailed"] = "<span title='Подробная информация' " +
                        "class='fas fa-address-card table-href row-edit-href' data-id='"
                        + json.data[i]["order_id"] + "'></span>"
                    json.data[i]["created_at"] = json.data[i]["created_at"]
                        .replace('T', ' ')
                        .replace('.000000Z', '')
                }
                return json.data
            },
            // Обновление таблицы при успешном создании продукта
            complete: function () {
                setTableHandlers()
            }
        },
        order: [[3, 'desc']],
        columns: [
            {data: "order_delete", orderable: false, width: "11px"},
            {data: "order_edit", orderable: false, width: "18px"},
            {data: "order_id", orderable: false, width: "1%"},
            {data: "created_at", width: "135px"},
            {data: "order_status", width: "90px"},
            {data: "order_detailed", orderable: false, width: "175px"},
            {data: "order_address",},
            {data: "order_phone", width: "135px"}
        ],
    });
}

function setTableHandlers() {
    $('.row-edit-href').off()
    $('.row-edit-href').on('click', function () {
        $.ajax({
            url: "uorders/" + $(this).attr('data-id'),
            method: "GET",
            dataType: "json",
            contentType: "application/json",
            success: (msg) => {
                loadOrderDetails(msg)
                $('#detailModal').modal('show')
            }
        })
    })
    $('.order-edit-href').off()
    $('.order-edit-href').on('click', function () {
        openedOrder = $($(this).parent().parent().children()[5]).children('.row-edit-href').attr('data-id')
        $.ajax({
            url: "uorders/" + openedOrder + '/edit',
            method: "GET",
            dataType: "json",
            contentType: "application/json",
            success: (msg) => {
                $('#userPhone').val(msg.order_phone)
                $('#userName').val(msg.order_name)
                $('#userAddress').val(msg.order_address)
                $('#userAdditional').val(msg.order_additional)
                $('#orderModal').modal('show')
            },
            error: (msg) => {
                console.log(msg)
            }
        })
    })
    $('.row-delete-href').off()
    $('.row-delete-href').on('click', function () {
        let orderId = $($(this).parent().parent().children()[5]).children('.row-edit-href').attr('data-id')
        $.ajax({
            url: "uorders/" + orderId,
            method: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            contentType: "application/json",
            success: () => {
                $('#orders').DataTable().clear().destroy()
                updateTable()
                getBalance()
            }
        })
    })

}

function loadOrderDetails(json) {
    $('#productList').html('')
    var fullPrice = 0;
    for (let product in json.order_goods) {
        let currentProduct = json.order_goods[product]

        fullPrice += Number(currentProduct['product_quantity']) *
            Number(currentProduct['product_price'])

        let visualisedProduct = "<div class=\"product\">\n" +
            "    <div class=\"product-row\">\n" +
            "        <div class=\"product-quantity-manager\">\n" +
            "            " + currentProduct['product_quantity'] + " шт.\n" +
            "        </div>\n" +
            "        <div class=\"product-name-manager\">\n" +
            "            " + currentProduct['product_name'] + "\n" +
            "        </div>\n" +
            "    </div>\n" +
            "    <div class=\"product-cost\">\n" +
            "        " + currentProduct['product_price'] + " ₽ за шт.\n" +
            "    </div>\n" +
            "    <div class=\"product-row\">\n" +
            "        <div class=\"product-full-cost\">\n" +
            "            Полная цена: " +
            Number(currentProduct['product_quantity']) *
            Number(currentProduct['product_price']) +
            " ₽\n" +
            "        </div>\n" +
            "        <a href=\"" +
            window.location.origin + '/products/' + currentProduct['product_id'] + "\">\n" +
            "            Перейти -->\n" +
            "        </a>\n" +
            "    </div>\n" +
            "</div>\n" +
            "<hr>"

        $('#productList').append(visualisedProduct)
    }
    $('#additionalText').text(json.order_additional)
    $('#totalPrice').html(fullPrice + '<b> ₽</b>')
}

function setConstantHandlers() {
    $('#submitButton').on('click', function () {
        let orderName = $("#userName").val()
        let orderAddress = $("#userAddress").val()
        let orderPhone = $("#userPhone").val()
        let orderAdditional = $("#userAdditional").val()
        if(!orderName || !orderAddress || !orderPhone || !orderAdditional) {
            $('#editModalError').text('Заполните все поля перед сохранением')
            return false
        }
        $.ajax({
            url: "uorders/" + openedOrder,
            method: "PATCH",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify({
                order_name: orderName,
                order_address: orderAddress,
                order_phone: orderPhone,
                order_additional: orderAdditional,
            }),
            success: () => {
                $('#orderModal').modal('hide')
                $('#orders').DataTable().clear().destroy()
                updateTable()
            }
        })
    })
}

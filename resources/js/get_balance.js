function getBalance() {
    let balance = $('#balance')
    $.ajax({
        method: "GET",
        url: "balances/0",
        dataType: "json",
        contentType: "application/json",
        success: (msg) => {
            balance.html(msg['user_money'] + " <b>₽</b>")
        }
    })
}

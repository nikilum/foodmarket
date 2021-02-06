$(document).ready(function (){
    opened = false
    $('#openCartBtn').on('click', function () {
        if(opened === false) {
            $('#sidebar').animate({width: '21%'})
            $('.foreground').css('z-index', '100000').animate({opacity: 100}, 400, 'linear', () => {
                $('body').css('overflow', 'hidden')
            })
            setTimeout(() => {
                $('.shopping-cart-open-btn').css('right', '20%').css('background', '#538a3c')
            }, 100)
            opened = true
        }
        else {
            $('#sidebar').animate({width: '0'})
            $('.foreground').animate({opacity: 0}, 400, 'linear', () => {
              $('.foreground').css('z-index', '-1')
                $('body').css('overflow', 'visible')
            })
            setTimeout(() => {
                $('.shopping-cart-open-btn').css('right', '2%').css('background', '#cb9f55')
            }, 100)
            opened = false
        }
    })
    // $('').on('click', '', function () {
    //     $.ajax({
    //         url: 'cart',
    //         method: 'POST',
    //         dataType: 'json',
    //         contentType: 'application/json',
    //         data: JSON.stringify(user_info),
    //         success: (msg) => {
    //             window.location.href = window.location.origin
    //         },
    //         error: (msg) => {
    //             console.log(msg)
    //         }
    //     })
    // })
})

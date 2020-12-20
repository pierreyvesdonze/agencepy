// MAIN TITLE WITCH ANIMATION
$(document).ready(function () {
    anime({
        targets: '.witch-header .el',
        scale: [
            { value: .1, easing: 'easeOutSine', duration: 500 },
            { value: 1, easing: 'easeInOutQuad', duration: 1200 }
        ],
        delay: anime.stagger(200, { grid: [14, 5], from: 'center' })
    });
});

// ADD TO CART FUNCTION
$('.buy-witch').on('click', function(e) {

    let userSelectFrom = $(this).closest('form');
    let selectedProduct = userSelectFrom.find('select').val();
    console.log(selectedProduct)

    $.ajax(
        {
            url: Routing.generate('witch_shop_buy'),
            method: "POST",
            dataType: "json",
            data: JSON.stringify(selectedProduct),
        }).done(function (response) {
            if (null !== response) {
                console.log('ok : ' + JSON.stringify(response));
            } else {
                console.log('Problème');
            }
        }).fail(function (jqXHR, textStatus, error) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(error);
        });
})

// $('.witch-format-select').on('change', function (e) {

//     const selectProduct = $(this);
//     $('.buy-witch').on('click', function () {
//         console.log(selectProduct)
//     })
// });

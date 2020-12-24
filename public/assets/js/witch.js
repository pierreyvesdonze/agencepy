var app = {

    initWitch: function () {

        console.log('initWitch');

        /**
       * *****************************
       * L I S T E N E R S
       * *****************************
       */

        $('.witch-format-select').on('change', app.updateStock);


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

        // PRODUCT SHOP WITCH ANIMATION
        $(document).ready(function () {
            anime({
                targets: '.witch-products .right-witch-product',
                translateX: 250,
                direction: 'alternate',
                loop: false,
                easing: 'spring(1, 80, 10, 0)'
            });

            anime({
                targets: '.witch-products  .left-witch-product',
                rotate: 720 // -> '540deg'
            });
        });
    },

    /**
   * *****************************
   * F U N C T I O N S
   * *****************************
   */

    updateStock: function () {


        // const selectedProduct = $(this).find(':selected').val();
        var stockQuantity = $(this).find(':selected').data("stock");

        var stockStatus = $('#stock-status');

        if (stockQuantity == 0) {
            stockStatus.removeClass().addClass('empty-stock');
        } else if (stockQuantity > 0 && stockQuantity <= 20) {
            stockStatus.removeClass().addClass('low-stock');
        } else {
            stockStatus.removeClass().addClass('full-stock');
        }

        // console.log(stockQuantity);
        console.log(stockQuantity);
    },

    // $('.buy-witch').on('click', function(e) {

    //     e.preventDefault();

    //     let userSelectFrom = $(this).closest('form');
    //     let selectedProduct = userSelectFrom.find('select').val();
    //     console.log(selectedProduct)

    //     $.ajax(
    //         {
    //             url: Routing.generate('witch_shop_buy'),
    //             method: "POST",
    //             dataType: "json",
    //             data: JSON.stringify(selectedProduct),
    //         }).done(function (response) {
    //             if (null !== response) {
    //                 console.log('ok : ' + JSON.stringify(response));
    //             } else {
    //                 console.log('Problème');
    //             }
    //         }).fail(function (jqXHR, textStatus, error) {
    //             console.log(jqXHR);
    //             console.log(textStatus);
    //             console.log(error);
    //         });
    // })

}

// App Loading
document.addEventListener(
    'DOMContentLoaded',
    app.initWitch)

$(document).ready(function () {
    app.updateStock()
})
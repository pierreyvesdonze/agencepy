// Mise à jour des status stock & panier au chargement
$(document).ready(function () {
    let initSelectedStock = $('.witch-format-select :selected').data('stock');
    appWitch.updateStock(initSelectedStock);

    appWitch.updatePastille()
})

var appWitch = {

    initWitch: function () {

        console.log('initWitch');

        // Maj du panier
        appWitch.currentQuantity = $('.user-witch-cart-quantity').data('quantity');

        appWitch.cartPastille = $('.witch-pastille-quantity');


        /**.
       * *****************************
       * L I S T E N E R S
       * *****************************
       */

        $('.witch-format-select').on('change', appWitch.updateStock);
        $('.buy-witch').on('click', appWitch.buyWitchProduct)


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
                targets: '.witch-products .left-witch-product',
                translateZ: 250,
                direction: 'alternate',
                loop: false,
                easing: 'spring(1, 80, 10, 0)'
            });

        });

    },

    /**
   * *****************************
   * F U N C T I O N S
   * *****************************
   */

    updateStock: function (initSelectedStock) {

        var stockQuantity = $(this).find(':selected').data("stock");
        var stockStatus = $('#stock-status');

        if (stockQuantity == 0 || initSelectedStock == 0) {
            stockStatus.removeClass().addClass('empty-stock');
            stockStatus.text("Rupture de stock");
        } else if (stockQuantity > 0 && stockQuantity <= 20) {
            stockStatus.removeClass().addClass('low-stock');
            stockStatus.text("Plus que " + stockQuantity + " exemplaires");
        } else {
            stockStatus.removeClass().addClass('full-stock');
            stockStatus.text("Disponible")
        }
    },

    buyWitchProduct: function (e) {

        e.preventDefault();

        let userSelectForm = $(".witch-format-select");
        let selectedFormatId = userSelectForm.find(':selected').data("format");

        $.ajax(
            {
                url: Routing.generate('witch_shop_buy'),
                method: "POST",
                dataType: "json",
                data: JSON.stringify(selectedFormatId),
            }).done(function (response) {
                if ($.type(response) === "string") {
                    console.log(response)
                    alert(response)
                } else {
                    console.log('Ajouté au panier');
                    appWitch.updatePastille();
                }
            }).fail(function (jqXHR, textStatus, error) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(error);
            });
    },

    updatePastille: function() {
        $.ajax(
            {
                url: Routing.generate('witch_cart_pastille'),
                method: "POST",
                dataType: "json",
                data: 'rien',
            }).done(function (response) {
                console.log(response)
                appWitch.cartPastille.text(response)
            }).fail(function (jqXHR, textStatus, error) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(error);
            });
    }


}

// App Loading
document.addEventListener(
    'DOMContentLoaded',
    appWitch.initWitch)

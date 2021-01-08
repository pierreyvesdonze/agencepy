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


        /**
       * *****************************
       * L I S T E N E R S
       * *****************************
       */

        $('.witch-shop-nav').on('click', appWitch.LeftPanel);
        $('.witch-format-select').on('change', appWitch.updateStock);
        $('.buy-witch').on('click', appWitch.buyWitchProduct);
        $('.minus-plus-green').on('click', appWitch.increaseCartQuantity);
        $('.minus-plus-red').on('click', appWitch.decreaseCartQuantity);
        $('.remove-article').on('click', appWitch.removeArticleFromCart);
        $('#witch_order_save').on('keyup', appWitch.checkCardNumber)


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

        //SHOP ANIMATION
        $(document).ready(function () {

            anime({
                targets: '.container-witch-shop .product-shop.pink-selector',
                translateX: ['0%', '60%'],
                direction: 'alternate',
                loop: false,
                easing: 'spring(1, 80, 10, 0)'
            });

            anime({
                targets: '.container-witch-shop .product-shop.yellow-selector',
                translateX: ['70%', '0%'],
                direction: 'alternate',
                loop: false,
                easing: 'spring(1, 80, 10, 0)'
            });
        });

        // PRODUCT WITCH ANIMATION
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

    LeftPanel: function (params) {

        console.log('anim')

    },


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
                if ($.type(response) === "string" && response != 'Nouvel article créé') {
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

    updatePastille: function () {
        $.ajax(
            {
                url: Routing.generate('witch_cart_pastille'),
                method: "POST",
                dataType: "json",
                data: 'rien',
            }).done(function (response) {
                appWitch.cartPastille.text(response)
            }).fail(function (jqXHR, textStatus, error) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(error);
            });
    },

    increaseCartQuantity: function (e) {

        e.preventDefault();

        let product = $(this).prev('.witch-cart-quantity'),
            productId = product.data('id'),
            quantityData = $(product),
            quantityValue = parseInt(quantityData.text()),
            productPrice = product.data('price'),
            currentTotalPrice = $('.total-articles-price').val();

        // On met à jour la quantité 
        quantityValue += 1;
        quantityData.text(quantityValue)

        // On calcule le nouveau total
        var newTotalCart = parseInt(currentTotalPrice) + productPrice;

        var dataToSend = {
            'id': productId,
            'quantity': quantityValue,
            'type': 'increase',
            'currentTotal': currentTotalPrice,
            'productPrice': productPrice
        }

        $.ajax(
            {
                url: Routing.generate('witch_cart_update'),
                method: "POST",
                dataType: "json",
                data: JSON.stringify(dataToSend),
            }).done(function (response) {

                // Maj de la pastille
                appWitch.updatePastille();

                // Maj du total du panier
                $('.total-articles-price').val(newTotalCart)


            }).fail(function (jqXHR, textStatus, error) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(error);
            });
    },

    decreaseCartQuantity: function (e, isRemove = false) {

        console.log(isRemove)

        let product = $(this).next('.witch-cart-quantity'),
            productId = product.data('id'),
            quantityData = $(product),
            quantityValue = parseInt(quantityData.text()),
            productPrice = product.data('price'),
            currentTotalPrice = $('.total-articles-price').val();

        // On décrémente de un la valeur et si elle passe à 0 on alerte l'utilisateur
        quantityValue -= 1;

        // On supprime la ligne du panier en front
        if (quantityValue < 1) {
            let confirmDelete = confirm("Voulez-vous supprimer l'article de votre panier ?")
            if (confirmDelete != false) {
                product.closest('.article-cartline').remove()

                if ($('.witch-pastille-quantity').text(0)) {
                    window.location.reload()
                }

            } else {
                return false;
            }
        } else if (quantityValue === 0) {
            $('.total-articles-price').val(productPrice)
            product.closest('.article-cartline').remove()
        }

        quantityData.text(quantityValue)

        // On calcule le nouveau total
        var newTotalCart = parseInt(currentTotalPrice) - productPrice;

        var dataToSend = {
            'id': productId,
            'quantity': quantityValue,
            'type': 'decrease',
            'currentTotal': currentTotalPrice,
            'productPrice': productPrice
        }

        $.ajax(
            {
                url: Routing.generate('witch_cart_update'),
                method: "POST",
                dataType: "json",
                data: JSON.stringify(dataToSend),
            }).done(function (response) {
                console.log(response)

                // Maj de la pastille
                appWitch.updatePastille();

                // Maj du total du panier
                $('.total-articles-price').val(newTotalCart)

            }).fail(function (jqXHR, textStatus, error) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(error);
            });
    },

    removeArticleFromCart: function (e) {

        let productId = e.target.dataset.articleid;
        var articleLineToRemove = e.currentTarget.parentElement.parentElement;
        var product = articleLineToRemove.querySelector('.witch-cart-quantity');
        let articleQuantity = parseInt(product.textContent);
        let articlePrice = parseInt(product.dataset.price);
        let currentTotalPrice = $('.total-articles-price').val();
        let priceToSubstract = articlePrice * articleQuantity;

        // On demande confirmation pour la suppression de l'article et on met à jour les éléments du panier
        let confirmDelete = confirm("Voulez-vous supprimer l'article de votre panier ?")
            if (confirmDelete != false) {
                product.closest('.article-cartline').remove()

                if ($('.witch-pastille-quantity').text(0)) {
                    window.location.reload()
                }

            } else {
                return false;
            }
        
        // On calcule le nouveau total
        let newTotalPrice = currentTotalPrice - priceToSubstract;

         var dataToSend = {
             'id': productId,
             'quantity': 0,
             'type': 'decrease',
             'currentTotal': currentTotalPrice,
             'productPrice': articlePrice
         }

         $.ajax(
            {
                url: Routing.generate('witch_cart_update'),
                method: "POST",
                dataType: "json",
                data: JSON.stringify(dataToSend),
            }).done(function (response) {
                console.log(response)

                // Maj de la pastille
                appWitch.updatePastille();

                // Maj du total du panier
                $('.total-articles-price').val(newTotalPrice)

            }).fail(function (jqXHR, textStatus, error) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(error);
            });
    },

    checkCardNumber: function (params) {
        input = $('.fakeCardNumber').val();
        console.log(input)
        console.log(typeof(input))
        if ('integer' !== typeof(params.currentTarget.value)) {
            alert('Le numéro de carte bleue est invalide')
        }
    }
}

// AppWitch Loading
document.addEventListener('DOMContentLoaded', appWitch.initWitch)

var app = {

  init: function () {

    console.log('app init');

    /**
     * *****************************
     * L I S T E N E R S
     * *****************************
     */

    $('.collapsible').click(app.collapsible);
    $('.surMesure').on('click', app.surMesure);

    //ALERT MODAL
    app.close = $('.close').on('click', app.closeAlertModal);
    app.modal = $('.alert-success');
    app.modalError = $('.alert-error');
    setTimeout(function () {
      app.modal.remove();
      app.modalError.remove();
      app.close.remove();
    }, 6000);


    /*
    ***********************************
    SMOOTH SCROLL
    ***********************************
    */

    $('a[href*="#"]')
      // Remove links that don't actually link to anything
      .not('[href="#"]')
      .not('[href="#0"]')
      .click(function (event) {
        // On-page links
        if (
          location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
          &&
          location.hostname == this.hostname
        ) {
          // Figure out element to scroll to
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
          // Does a scroll target exist?
          if (target.length) {
            // Only prevent default if animation is actually gonna happen
            event.preventDefault();
            $('html, body').animate({
              scrollTop: target.offset().top
            }, 1000, function () {
              // Callback after animation
              // Must change focus!
              var $target = $(target);
              $target.focus();
              if ($target.is(":focus")) { // Checking if the target was focused
                return false;
              } else {
                $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                $target.focus(); // Set focus again
              };
            });
          }
        }
      });


  },

  /**
  * *****************************
  * F U N C T I O N S
  * *****************************
  */

  collapsible: function (e) {

    // On va chercher par le biais de input hidden les routes correspondantes, pour ne pas avoir à redéfinir le comportement de collapsible()
    let target = $('.hidden-route').data('route');
    console.log(target);

    switch (target) {
      case target = "witch-home":
        $('#collapseOne').toggleClass('active').toggleClass('collapse');

        anime({
          targets: '.flex-team',
          rotate: '1turn'
        });

        break;
      case target = "product-route":

        var stockQuantity = $('.witch-format-select').find(':selected').data("stock");

        console.log(stockQuantity)

        // On vérifie qu'il y a du stock
        if (stockQuantity > 0) {
          $('#custom-modal-alert').toggleClass('active').toggleClass('collapse');
          setTimeout(function () {
            $('#custom-modal-alert').toggleClass('collapse').toggleClass('active');
          }, 3000);
        }
        break;
    }
  },

  surMesure: function () {

    $('#surMesureContainer').toggleClass('active-mesure').toggleClass('collapse-mesure');

    anime({
      targets: '.surMesureTitle',
      scale: [
        { value: .1, easing: 'easeOutSine', duration: 300 },
        { value: 1, easing: 'easeInOutQuad', duration: 1000 }
      ],
      delay: anime.stagger(150, { grid: [14, 5], from: 'center' })
    });
  },

  closeAlertModal: function () {
    app.modal.remove();
    app.close.remove();
  },

  /**
   *SEARCH
   */
  search: function (e) {
    e.preventDefault();
    let userInput = $('.search-input').val();
    console.log('input : ' + userInput);
    $.ajax(
      {
        url: Routing.generate('searchApi'),
        method: "POST",
        dataType: "json",
        data: JSON.stringify(userInput),
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
  },
}

// App Loading
document.addEventListener('DOMContentLoaded', app.init);



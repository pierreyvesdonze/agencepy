var app = {

  init: function () {

    console.log('app init');

    /**
     * *****************************
     * L I S T E N E R S
     * *****************************
     */
    $('.collapsible').on('click', app.collapsible);
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

  collapsible: function () {

    $('#collapseOne').toggleClass('active-team').toggleClass('collapse-team');

    anime({
      targets: '.flex-team',
      rotate: '1turn'
    });
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

}

// App Loading
document.addEventListener('DOMContentLoaded', app.init);



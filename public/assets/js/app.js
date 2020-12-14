var app = {

	init: function () {

		console.log('app init');


		/**
		 * *****************************
		 * L I S T E N E R S
		 * *****************************
		 */
		$('.collapsible').on('click', app.collapsible);
	},

	/**
	 * *****************************
	 * F U N C T I O N S
	 * *****************************
	 */

	 collapsible: function() {
		 console.log('pouet')
		 $('#collapseOne').toggleClass('active-team').toggleClass('collapse-team');
	 }
	
}

// App Loading
document.addEventListener('DOMContentLoaded', app.init);


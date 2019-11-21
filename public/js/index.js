// function myFunction() {
//     var x = document.getElementById("myTopnav");
//     if (x.className === "topnav") {
//       x.className += " responsive";
//     } else {
//       x.className = "topnav";
//     }
// }

(function ($) {
	//
	// Variables
	//
	var collapseNav = document.querySelector('#open-menu');

	//
	// Methods
	//
	var openNav = function (event) {
        subMenu = document.querySelector("#sub-menu");
        
        if (subMenu.classList.contains("block")) {
            subMenu.classList.remove("block");
            subMenu.classList.add("hidden");
        } else {
            subMenu.classList.remove("hidden");
            subMenu.classList.add("block");
        }
	};

	//
	// Inits & Event Listeners
	//
	collapseNav.addEventListener('click', openNav);

})(jQuery);

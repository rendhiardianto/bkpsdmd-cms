//RESPONSIVE TOP NAV----------------------------------------------
function myFunction() {
  var x = document.getElementById("mynavBtn");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}

//DROPDOWN BUTTONS----------------------------------------------
 function toggleDropdown(menuId) {
      // Close all other dropdowns
      document.querySelectorAll(".dropdown-content").forEach(menu => {
        if (menu.id !== menuId) {
          menu.classList.remove("show");
        }
      });
    }
    // Close dropdown if clicking outside
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        document.querySelectorAll(".dropdown-content").forEach(menu => {
          menu.classList.remove("show");
        });
      }
    }
    // Mobile: toggle dropdown on click
    document.querySelectorAll(".dropbtn").forEach(toggle => {
      toggle.addEventListener("click", function(e) {
        // Only work on small screens
        if (window.innerWidth < 768) {
          e.preventDefault();
          const dropdown = this.nextElementSibling;
          dropdown.classList.toggle("show");
        }
      });
    });

    // INFOGRAPHIS SLIDESHOW----------------------------------------------
var myIndex = 0;
carousel();
function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 3000);
}
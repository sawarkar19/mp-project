$(function() {
    
    /* ------------- tooltip ---------- */
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    
});

// searchbar open and close
const searchBlock = document.querySelector(".search-block");
const searchToggle = document.querySelector(".search-toggle");
const searchCancel = document.querySelector(".search-cancel");

if (searchToggle && searchCancel) {
   searchToggle.addEventListener("click", () => {
      searchBlock.classList.add("is-active");
   });

   searchCancel.addEventListener("click", () => {
      searchBlock.classList.remove("is-active");
   });
}


// navbar overlay open close
$(document).ready(function() {
   
   const MainMenu = new bootstrap.Collapse(document.getElementById("mainNavCollapse"), {toggle:false});
   
   $("button.main-web-nav-tog").on("click",function(e) {
       e.preventDefault();
       $("header").addClass("sidebar-show");
   });
   $("#close_main_navigation").on("click",function(e) {
      e.preventDefault();
      $("header").removeClass("sidebar-show");
   });
      
   $(document).click(function(event) {
         //get the width of device in variable
         var win_width = $(window).width();
         //get the header in variable
         var $header = $('header');

         var menu_container = $(".navbar-collapse");
         var toggle_btn = $("button.main-web-nav-tog");

         //if the device width is less than equal to 991 the run the code
         if (win_width <= 991) {
            if (!menu_container.is(event.target) && !menu_container.has(event.target).length && !toggle_btn.is(event.target) && !toggle_btn.has(event.target).length) {

               //get the value of header class in variable
               let header_class = $header.hasClass("sidebar-show");
               // if header has class then run the code
               if(header_class){
                  MainMenu.hide();
                  $header.removeClass("sidebar-show");
               }
            }
         }


   });
});
 
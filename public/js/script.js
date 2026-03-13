$(document).ready(function () {

  const hamBurger = document.querySelector(".toggle-btn");

  if (hamBurger) {
    hamBurger.addEventListener("click", function () {
      document.querySelector("#sidebar").classList.toggle("expand");
      document.querySelector("nav").classList.toggle("nav-collapse");
    });
  }

  $("#dataTable1").DataTable();
});
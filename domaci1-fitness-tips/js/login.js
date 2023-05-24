// U ovom JavaScript fajlu se nalazi funkcija za prebacivanje sa Login-a na Register opciju kao i efekti pri kliku na jedan od navedenih opcija

$(function () {
    $("#login-form-link").click(function (e) {
      $("#login-form").delay(100).fadeIn(100);
      $("#register-form").fadeOut(100);
      $("#register-form-link").removeClass("active");
      $(this).addClass("active");
      e.preventDefault();
    });
    $("#register-form-link").click(function (e) {
      $("#register-form").delay(100).fadeIn(100);
      $("#login-form").fadeOut(100);
      $("#login-form-link").removeClass("active");
      $(this).addClass("active");
      e.preventDefault();
    });
  });
  
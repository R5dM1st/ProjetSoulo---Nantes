document.addEventListener("DOMContentLoaded", function () {
  function showLoginForm() {
    $("#main-content").load("templates/auth/login.html", function () {
      $("#showRegisterForm").on("click", showRegisterForm);
      $("#loginForm").on("submit", function (e) {
        e.preventDefault();
        var email = $("#email").val();
        var password = $("#password").val();
        console.log(email, password);



        ajaxRequest(
          "POST",
          "backend/index.php/login",
          function (response) {
            console.log(response);
            localStorage.setItem("session_id", response.session_id);
            localStorage.setItem("user_info", JSON.stringify(response.user))
            window.location.href = "dashbord.html";
          },
          function (errorstatus) {
            $("#error").show();
            $("#error").text("Identifiants incorrects.");
          },
          `email=${email}&password=${password}`
        );

        
      });
    });
  }

  function showRegisterForm() {
    $("#main-content").load("templates/auth/register.html", function () {
      $("#showLoginForm").on("click", showLoginForm);
      $("#registerForm").on("submit", function (e) {
        e.preventDefault();

        var email = $("#email").val();
        var nom = $("#nom").val();
        var prenom = $("#prenom").val();
        var password = $("#password").val();
        var confirmPassword = $("#password_confirmation").val();
        var emailconf = $("#email_confirmation").val();
        if (password != confirmPassword) {
          $("#error").show();
          $("#error").text("Les mots de passe ne correspondent pas.");
          return;
        }
        if (email != emailconf) {
          $("#error").show();
          $("#error").text("Les adresses email ne correspondent pas.");
          return;
        }
        if (password.length < 8) {
          $("#error").show();
          $("#error").text(
            "Le mot de passe doit contenir au moins 8 caractères."
          );
          return;
        }
        if (!email || !nom || !prenom || !password || !confirmPassword) {
          $("#error").show();
          $("#error").text("Tous les champs sont obligatoires.");
          return;
        }

        ajaxRequest(
          "POST",
          "backend/index.php/register",
          function (response) {
            showLoginForm();
          },
          function (errorstatus) {
            $("#error").show();
            $("#error").text("Une erreur est survenue.");
          },
          `email=${email}&nom=${nom}&prenom=${prenom}&password=${password}`
        );
      });
    });
  }

  showLoginForm();
});

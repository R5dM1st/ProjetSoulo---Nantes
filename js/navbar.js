const button = `<button class="bg-white hover:text-blue-600 text-black font-bold py-2 px-4 rounded transform hover:scale-110 transition duration-300 ease-in-out"></button>`;

$("#navbar").load("templates/layout/navbar.html", function () {
  console.log("navbar loaded");

  const session_id = localStorage.getItem("session_id");
  const user_info = JSON.parse(localStorage.getItem("user_info"));

  if (session_id && user_info) {
    $("#login_user").hide();
    $("#logout_user").show();
    $("#logout_user").html(
      `${user_info.nom} ${user_info.prenom} <i class="fas fa-sign-out-alt"></i>`
    );

    $("#logout_user").on("click", function () {
      localStorage.removeItem("session_id");
      localStorage.removeItem("user_info");
      window.location.href = "index.html";
    });
  }
});

(() => {
  const user = JSON.parse(localStorage.getItem("user_info"));
  const session_id = localStorage.getItem("session_id");

  if (user && session_id) {
    $("#private-box").show();
  }

  ajaxRequest(
    "GET",
    "backend/index.php/plongee/profile",
    function (response) {
      try {
        displayProfile("profile_box", response, true);
      } catch (error) {}
    },
    function (errorcode) {
      console.log(errorcode);
    },
    (data = null),
    (auth = true),
    (cache = true),
  );

  ajaxRequest(
    "GET",
    "backend/index.php/plongee/equipement",
    function (response) {
      try {
        console.log(response);
        displayEquipement("equipement_box", response, true);
      } catch (error) {}
    },
    function (errorcode) {
      console.log(errorcode);
    },
    (data = null),
    (auth = true),
    (cache = true),
  );

  $("#submit").click(() => {
    //get the selected profile
    const profile_id = $("input[name='profile']:checked").val();
    const equipement_id = $("input[name='equipement']:checked").val();
    const profondeur = $("#profondeur").val();
    const duree = $("#duree").val();
    const date = $("#date").val();
    const nom = $("#nom").val();
    const private = $("#private").is(":checked") ? 1 : 0;

    //if one of the inputs is an html element
    if (
      isHTMLElement(date) ||
      isHTMLElement(nom) ||
      isHTMLElement(profondeur) ||
      isHTMLElement(duree)
    ) {
      $("#error").show();
      showWarning("Pas cool ça");
      $("#error").text("Pas cool ça");
      return;
    }

    if (
      !profile_id ||
      !equipement_id ||
      !profondeur ||
      !duree ||
      !date ||
      !nom
    ) {
      $("#error").show();
      $("#error").text("Veuillez remplir tous les champs");
      return;
    }

    //validate the type of the data
    if (
      isNaN(profondeur) ||
      isNaN(duree) ||
      isNaN(profile_id) ||
      isNaN(equipement_id)
    ) {
      $("#error").show();
      $("#error").text("Profondeur et durée doivent être des nombres");
      return;
    }

    newConfettiScreen();

    ajaxRequest(
      "POST",
      "backend/index.php/plongee",
      function (response) {
        try {
          if (!user || !session_id) {
            console.log("redirect to Découvrez");
            loadPage(3);
          } else {
            console.log("redirect to Mes plongées");
            loadPage(1);
          }
        } catch (error) {
          console.log(error);
        }
      },
      function (errorcode) {
        $("#error").show();
        $("#error").text("Une erreur s'est produite");
      },
      `profile_id=${profile_id}&equipement_id=${equipement_id}&profondeur=${profondeur}&duree=${duree}&date=${date}&nom=${nom}&private=${private}`,
      (auth = true),
    );
  });
})();

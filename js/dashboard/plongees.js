(() => {
  $("#plongees_container h1").text("Historique des plongées");
  let currentPlongee = null;

  function loadplongees() {
    ajaxRequest(
      "GET",
      "backend/index.php/plongee",
      function (data) {
        showPlongeesList(data);
      },
      function (errorstatus) {
        console.log(errorstatus);
      },
      null,
      true
    );
  }

  function showPlongeesList(plgs) {
    const tmpl = $("#tmplt_btn_selector").find("button");
    const container = $("#plongees_container");
    for (let i = 0; i < plgs.length; i++) {
      const plongee = plgs[i];
      const btn = tmpl.clone();
      btn.html(
        `${plongee.date} - ${plongee.nom} ${
          plongee.private ? "<i class='fas fa-lock'></i>" : ""
        }`
      );
      btn.click(function () {
        showPlongee(plongee);
      });
      container.append(btn);
    }
    if (plgs.length < 1) {
      container.append(
        "<p class='text-center opacity-75'>Aucune plongée enregistrée</p>"
      );
    }
  }

  function showPlongee(plg) {
    if (currentPlongee == plg.id) {
      return;
    }
    
    currentPlongee = plg.id;
    $("#equipement_container").empty();
    $("#profile_container").empty();
    $("#plongee_param_container").empty();
    $("#plongee_container").removeClass("hidden");
    //delete the delete button :p
    $("#plongee_container button").remove();

    displayProfile("profile_container", [
      {
        nom: plg.profile_nom,
        vitesse_desc: plg.vitesse_desc,
        vitesse_asc: plg.vitesse_asc,
        respiration: plg.respiration,
      },
    ]);

    displayEquipement("equipement_container", [
      {
        nom: plg.equipement_nom,
        contenance: plg.contenance,
        pression: plg.pression,
      },
    ]);

    $("#plongee_param_container").append(`
      <table class="table">
        <thead>
          <tr>
            <th>Profondeur</th>
            <th>Durée</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>${plg.profondeur} m</td>
            <td>${plg.duree} min</td>
          </tr>
        </tbody>
      </table>
    `);

    //Add a delete button the polongee-container
    const deleteBtn = document.createElement("button");
    deleteBtn.textContent = "Supprimer";
    deleteBtn.classList =
      "bg-red-500 hover:text-white text-black font-bold py-2 px-4 rounded transform hover:scale-110 transition duration-300 ease-in-out m-4 w-max";

    deleteBtn.addEventListener("click", function () {
      ajaxRequest(
        "DELETE",
        "backend/index.php/plongee",
        function (data) {
          window.location.reload();
        },
        function (errorstatus) {
          console.log(errorstatus);
        },
        "id=" + plg.id,
        true
      );
    });

    $("#plongee_container").append(deleteBtn);

    ajaxRequest(
      "GET",
      "backend/index.php/plongee/tableau",
      function (data) {
        console.log(data);
        const chartData = convertToChartFormData(data);
        showPlongeeChart("plongee_chart_container", chartData);
        displayPlongeeTable("plongee_table_container", data);
      },
      function (errorstatus) {
        console.log(errorstatus);
      },
      "id=" + plg.id,
      true
    );
  }


  loadplongees();
})();

(() => {
  $("#plongees_container h1").text(
    "Découvrez les plongées des autres utilisateurs"
  );

  let currentPlongee = null;

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
    false
  );

  function showPlongeesList(plgs) {
    const tmpl = $("#tmplt_btn_selector").find("button");
    const container = $("#plongees_container");
    for (let i = 0; i < plgs.length; i++) {
      const plongee = plgs[i];
      const btn = tmpl.clone();
      btn.text(`${plongee.date} - ${plongee.nom}`);
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

  
})();

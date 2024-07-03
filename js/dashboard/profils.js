(() => {
  const btnclass =
    "bg-white hover:text-blue-600 text-black font-bold py-2 px-4 rounded transform hover:scale-110 transition duration-300 ease-in-out w-full";

  function createProfileButton(profile) {
    const btn = document.createElement("button");
    btn.className = btnclass;
    btn.innerText = profile.nom;
    btn.addEventListener("click", () => {
      const modal = $("#modal_profils");

      modal.removeClass("hidden");
      $("#modal_profils #closeModalBtn").click(function () {
        $("#modal_profils").addClass("hidden");
      });

      modal.find("#modalTitle").text(profile.nom);
      modal.find("#profilName").val(profile.nom);
      modal.find("#vitesseDesc").val(profile.vitesse_desc);
      modal.find("#vitesseAsc").val(profile.vitesse_asc);
      modal.find("#respiration").val(profile.respiration);
      modal.find("#profilId").val(profile.id);

      modal.find("#save").click(function () {
        ajaxRequest(
          "PUT",
          "backend/index.php/plongee/profile",
          function (response) {
            console.log(response);
            window.location.reload();
          },
          function (error) {
            console.error("Erreur lors de la requête ajax :", error);
          },
          `id=${profile.id}&nom=${encodeURIComponent(modal.find("#profilName").val())}&vitesse_descente=${modal.find("#vitesseDesc").val()}&vitesse_remontee=${modal.find("#vitesseAsc").val()}&respiration=${modal.find("#respiration").val()}`,
          true,
        );
      });

      modal.find("#delete").click(function () {
        ajaxRequest(
          "DELETE",
          "backend/index.php/plongee/profile",
          function (response) {
            console.log(response);
            window.location.reload();
          },
          function (error) {
            console.error("Erreur lors de la requête ajax :", error);
          },
          `id=${profile.id}`,
          true,
        );
      });
    });
    document.getElementById("profileList").appendChild(btn);
  }

  function createEquipmentButton(equipement) {
    const btn = document.createElement("button");
    btn.className = btnclass;
    btn.innerText = equipement.nom;
    btn.addEventListener("click", () => {
      const modal = $("#modal_equipement");

      modal.removeClass("hidden");
      $("#modal_equipement #closeModalBtn").click(function () {
        $("#modal_equipement").addClass("hidden");
      });

      modal.find("#modalTitle").text(equipement.nom);
      modal.find("#equipementName").val(equipement.nom);
      modal.find("#bottleCapacity").val(equipement.contenance);
      modal.find("#bottlePressure").val(equipement.pression);
      modal.find("#equipementId").val(equipement.id);

      modal.find("#save").click(function () {
        ajaxRequest(
          "PUT",
          "backend/index.php/plongee/equipement",
          function (response) {
            console.log(response);
            window.location.reload();
          },
          function (error) {
            console.error("Erreur lors de la requête ajax :", error);
          },
          `id=${equipement.id}&nom=${encodeURIComponent(modal.find("#equipementName").val())}&contenance=${modal.find("#bottleCapacity").val()}&pression=${modal.find("#bottlePressure").val()}`,
          true,
        );
      });

      modal.find("#delete").click(function () {
        ajaxRequest(
          "DELETE",
          "backend/index.php/plongee/equipement",
          function (response) {
            console.log(response);
            window.location.reload();
          },
          function (error) {
            console.error("Erreur lors de la requête ajax :", error);
          },
          `id=${equipement.id}`,
          true,
        );
      });
    });
    document.getElementById("equipementList").appendChild(btn);
  }

  ajaxRequest(
    "GET",
    "backend/index.php/plongee/profile",
    function (response) {
      response.forEach((profile) => {
        createProfileButton(profile);
      });
    },
    function (error) {
      console.error("Erreur lors de la requête ajax :", error);
    },
    null,
    true,
  );

  ajaxRequest(
    "GET",
    "backend/index.php/plongee/equipement",
    function (response) {
      response.forEach((equipement) => {
        createEquipmentButton(equipement);
      });
    },
    function (error) {
      console.error("Erreur lors de la requête ajax :", error);
    },
    null,
    true,
  );

  document.getElementById("profile").addEventListener("click", () => {
    const descentSpeed = document.getElementById("descentSpeed").value;
    const ascentSpeed = document.getElementById("ascentSpeed").value;
    const plongeeName = document.getElementById("plongeeName").value;
    const breathingRate = document.getElementById("breathingRate").value;

    const data = `nom=${encodeURIComponent(plongeeName)}&vitesse_descente=${encodeURIComponent(descentSpeed)}&vitesse_remontee=${encodeURIComponent(ascentSpeed)}&respiration=${encodeURIComponent(breathingRate)}`;

    ajaxRequest(
      "POST",
      "backend/index.php/plongee/profile",
      function (response) {
        console.log(response);
        window.location.reload();
      },
      function (error) {
        console.error("Erreur lors de la requête ajax :", error);
      },
      data,
      true,
    );
    setTimeout(() => {
      window.location.reload();
    }, 1000);
  });

  document.getElementById("equipement").addEventListener("click", () => {
    const equipementName = document.getElementById("equipementName").value;
    const bottleCapacity = document.getElementById("bottleCapacity").value;
    const bottlePressure = document.getElementById("bottlePre").value;

    const data = `nom=${encodeURIComponent(equipementName)}&contenance=${encodeURIComponent(bottleCapacity)}&pression=${encodeURIComponent(bottlePressure)}`;

    ajaxRequest(
      "POST",
      "backend/index.php/plongee/equipement",
      function (response) {
        console.log(response);
        window.location.reload();
      },
      function (error) {
        console.error("Erreur lors de la requête ajax :", error);
      },
      data,
      true,
    );
    setTimeout(() => {
      window.location.reload();
    }, 1000);
  });
})();

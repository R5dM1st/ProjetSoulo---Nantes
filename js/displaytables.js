function displayProfile(target, profiles, input = false) {
  $(`#${target}`).append(`
    <table class="table w-full">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Vitesse descente</th>
          <th>Vitesse montée</th>
          <th>Respiration</th>
        </tr>
      </thead>
      <tbody id=${target + "_tbody"}>
      ${profiles
        .map(
          (profile) =>
            `
        <tr>
    
          ${
            input
              ? `
          <td><label for='profile_${profile.id}_row'><input type="radio" name="profile" id='profile_${profile.id}_row'
          value="${profile.id}">
          ${profile.nom}</label></td>
          <td><label for='profile_${profile.id}_row'>${profile.vitesse_desc} m/min</label></td>
          <td><label for='profile_${profile.id}_row'>${profile.vitesse_asc} m/min</label></td>
          <td><label for='profile_${profile.id}_row'>${profile.respiration} L/min</label></td>`
              : `<td>${profile.nom}</td>
          <td>${profile.vitesse_desc} m/min</td>
          <td>${profile.vitesse_asc} m/min</td>
          <td>${profile.respiration} L/min</td>`
          }
          
          
        </tr>`
        )
        .join("")}
      </tbody>
    </table>
    `);
}

function displayEquipement(target, equipements, input = false) {
  $(`#${target}`).append(`
    <table class="table w-full">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Contenance</th>
          <th>Pression</th>
        </tr>
      </thead>
      <tbody>
      ${equipements
        .map(
          (equipement) =>
            `
        <tr>
          ${
            input
              ? `
          <td><label for='equipement_${equipement.id}_row'><input type="radio" name="equipement" id='equipement_${equipement.id}_row'
          value="${equipement.id}">
          ${equipement.nom}</label></td>
          <td><label for='equipement_${equipement.id}_row'>${equipement.contenance} L</label></td>
          <td><label for='equipement_${equipement.id}_row'>${equipement.pression} bar</label></td>`
              : `<td>${equipement.nom}</td>
          <td>${equipement.contenance} L</td>
          <td>${equipement.pression} bar</td>`
          }
        </tr>`
        )
        .join("")}
      </tbody>
    </table>
    `);
}

function displayPlongeeTable(target, plongees) {
  $(`#${target}`).empty();
  console.log($(`#${target}`).className);
  let tx = 0;
  $(`#${target}`).append(`
    <table class="table w-full">
      <thead>
        <tr>
        <th></th>
          <th>Profondeur</th>
          <th>Temps</th>
          <th>Pression ambiante</th>
          <th>Consommation</th>
          <th>Bar restant</th>
          <th>Volume restant</th>
        </tr>
      </thead>
      <tbody>
      ${plongees
        .map(
          (plongee) =>
            `<tr ${plongee.bar_restant < 50 ? "class='row-warning'" : ""} >
          <td>t${tx++}</td>
          <td>${plongee.profondeur} m</td>
          <td>${plongee.temps} min</td>
          <td>${plongee.pression_ambiante} bar</td>
          <td>${plongee.consommation} L/min</td>
          <td>${plongee.bar_restant} bar</td>
          <td>${plongee.volume} L</td>
        </tr>
        `
        )
        .join("")}
      </tbody>
    </table>
    `);
}

function convertToChartFormData($data) {
  const chartData = {
    profondeur: [],
    temps: [],
    pression_ambiante: [],
    consommation: [],
    bar_restant: [],
    volume_restant: [],
  };
  for (let i = 0; i < $data.length; i++) {
    const row = $data[i];
    chartData.profondeur.push(row.profondeur * -1);
    chartData.temps.push(row.temps);
    chartData.pression_ambiante.push(row.pression_ambiante);
    chartData.consommation.push(row.consommation);
    chartData.bar_restant.push(row.bar_restant);
    chartData.volume_restant.push(row.volume);
  }
  return chartData;
}

function showPlongeeChart(target, data) {
  $(`#${target}`).empty();
  $(`#${target}`).append("<canvas id='plongee_chart' class='w-full'></canvas>");
  var ctx = document.getElementById("plongee_chart").getContext("2d");

  let descente = [];
  let remonte = [];

  let vminprof = Math.min(...data.profondeur) - 1;

  for (let i = 0; i < data.temps.length; i++) {
    if (i == 0) {
      descente.push(vminprof);
      remonte.push(null);
      continue;
    }
    if (data.profondeur[i] < data.profondeur[i - 1]) {
      descente.push(vminprof);
      remonte.push(null);
    } else {
      if (remonte.every((el) => el === null)) {
        descente.push(vminprof);
      } else {
        descente.push(null);
      }
      remonte.push(vminprof);
    }
  }

  console.log(descente, remonte);

  var myChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: data.temps,
      datasets: [
        {
          label: "DP",
          data: descente,
          backgroundColor: "rgba(0, 0, 0, 0)",
          borderColor: "rgba(75, 192, 192, 1)",
          borderWidth: 1,
          borderDash: [5, 5],
          pointRadius: 0,
        },
        {
          label: "DTR",
          data: remonte,
          backgroundColor: "rgba(0, 0, 0, 0)",
          borderColor: "rgba(255, 206, 86, 1)",
          borderWidth: 1,
          borderDash: [5, 5],
          pointRadius: 0,
        },
        {
          label: "Profondeur (m)",
          data: data.profondeur,
          backgroundColor: "rgba(0, 0, 0, 0)",
          borderColor: "rgba(255, 99, 132, 1)",
          borderWidth: 1,
        },
        {
          label: "Pression ambiante (bar)",
          data: data.pression_ambiante,
          backgroundColor: "rgba(0, 0, 0, 0)",
          borderColor: "rgba(54, 162, 235, 1)",
          borderWidth: 1,
        },
        {
          label: "Consommation (L/min)",
          data: data.consommation,
          backgroundColor: "rgba(0, 0, 0, 0)",
          borderColor: "rgba(255, 206, 86, 1)",
          borderWidth: 1,
        },
        {
          label: "Bar restant (bar)",
          data: data.bar_restant,
          backgroundColor: "rgba(0, 0, 0, 0)",
          borderColor: "rgba(75, 192, 192, 1)",
          borderWidth: 1,
        },
        {
          label: "Volume restant (L)",
          data: data.volume_restant,
          backgroundColor: "rgba(0, 0, 0, 0)",
          borderColor: "rgba(153, 102, 255, 1)",
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: true,
          labels: {
            color: "white",
          },
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
            color: "white",
          },
        },
        x: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
            color: "white",
          },
        },
      },
      annotation: {
        annotations: {
          line1: {
            type: "line",
            mode: "horizontal",
            scaleID: "y",
            value: 0,
            borderColor: "rgb(75, 192, 192)",
            borderWidth: 2,
            label: {
              enabled: true,
              content: "Surface",
              position: "center",
            },
          },
        },
      },
    },
  });
}

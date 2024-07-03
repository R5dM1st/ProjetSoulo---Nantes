(() => {
    function convertirMinutesEnHeures(minutes) {
        const heures = Math.floor(minutes / 60);
        const minutesRestantes = minutes % 60;
        return `${heures}h ${minutesRestantes}m`;
    }

    const profondeursTraitees = new Set(); 

    function ajouterLigne(tableau, donneesLigne) {
        const profondeurActuelle = donneesLigne.prof;
        if (profondeurActuelle === null) {
            return;
        }

        if (!profondeursTraitees.has(profondeurActuelle)) {
            profondeursTraitees.add(profondeurActuelle); 
            const ligneSeparateur = tableau.insertRow();
            const celluleSeparateur = ligneSeparateur.insertCell();
            celluleSeparateur.colSpan = Object.keys(donneesLigne).length;
            celluleSeparateur.style.borderBottom = "2px solid #000";
            celluleSeparateur.textContent = `Profondeur: ${profondeurActuelle}`;
            const option = document.createElement('option');
            option.value = profondeurActuelle;
            option.textContent = profondeurActuelle;
            document.getElementById('prof_filter').appendChild(option);
        }

        const ligne = tableau.insertRow();
        Object.keys(donneesLigne).forEach(key => {
            const cellule = ligne.insertCell();
            let valeur = donneesLigne[key];
            if (key === 't') {
                valeur = convertirMinutesEnHeures(valeur);
            }
            cellule.textContent = valeur;
        });
    }

    function filtrerParProfondeur() {
        const lignesTableau = document.querySelectorAll("#tablemn60 tbody tr");
        const profondeurFiltre = document.getElementById("prof_filter").value.toLowerCase();

        lignesTableau.forEach(ligne => {
            const profondeur = ligne.cells[0].textContent.toLowerCase();
            if (profondeurFiltre === "" || profondeur === profondeurFiltre) {
                ligne.style.display = "";
            } else {
                ligne.style.display = "none";
            }
        });
    }

    document.getElementById("prof_filter").addEventListener("change", filtrerParProfondeur);

    const tableau = document.querySelector("#tablemn60");
    const corpsTableau = tableau.querySelector("tbody");

    ajaxRequest("GET", "backend/index.php/table", function (reponse) {
        reponse.forEach((donneesLigne) => {
            ajouterLigne(corpsTableau, donneesLigne);
        });
    });

    console.log(profondeursTraitees);
    console.log("Table.js chargé");
})();
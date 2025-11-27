document.addEventListener("DOMContentLoaded", () => {
    const tbody = document.getElementById("creneauxBody");

    async function fetchCreneaux() {
        try {
            const response = await fetch('api/tuteur/mesCreneaux.php');
            const data = await response.json();
            console.log("Réponse API :", data);

            if (data.success) {
                const demandesEnAttente = data.creneaux.filter(c => c.statut.toLowerCase() === "enattente");

                tbody.innerHTML = ""; // vider le tbody

                if (demandesEnAttente.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="6"><p>Aucune demande en attente.</p></td></tr>`;
                    return;
                }

                demandesEnAttente.forEach(creneau => {
                    const tr = document.createElement("tr");

                    // Vérification si un client est attribué
                    const nomClient = creneau.client_id 
                        ? `${creneau.client_prenom} ${creneau.client_nom}`
                        : 'Non attribué';

                    tr.innerHTML = `
                        <td>${nomClient}</td>
                        <td>${creneau.date_creneau}</td>
                        <td>${creneau.heure_debut}</td>
                        <td>${creneau.duree_minutes} min</td>
                        <td>${creneau.service_nom || 'Non spécifié'}</td>
                        <td>${creneau.notes || ''}</td>
                        <td>
                            <button class="accepter">Accepter</button>
                            <button class="refuser">Refuser</button>
                        </td>
                    `;

                    tr.querySelector(".accepter").addEventListener("click", () => handleAction(creneau.id, "accepter"));
                    tr.querySelector(".refuser").addEventListener("click", () => handleAction(creneau.id, "refuser"));

                    tbody.appendChild(tr);
                });

            } else {
                tbody.innerHTML = `<tr><td colspan="6">Impossible de récupérer les créneaux.</td></tr>`;
            }
        } catch (error) {
            console.error(error);
            tbody.innerHTML = `<tr><td colspan="6">Erreur lors de la récupération des créneaux.</td></tr>`;
        }
    }

    async function handleAction(creneauId, action) {
        try {
            const response = await fetch(`api/tuteur/${action}Creneau.php`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ creneau_id: creneauId })
            });
            const data = await response.json();
            alert(data.message);
            fetchCreneaux(); // Recharger la liste après action
        } catch (error) {
            console.error(error);
            alert("Erreur lors de la mise à jour du créneau.");
        }
    }

    fetchCreneaux();
});

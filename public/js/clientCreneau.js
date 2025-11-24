document.addEventListener('DOMContentLoaded', function() {
    const serviceSelect = document.getElementById('serviceSelect');
    const messageCreneaux = document.getElementById('messageCreneaux');
    const listeCreneaux = document.getElementById('listeCreneaux');
    const tableBody = listeCreneaux.querySelector('tbody');

    serviceSelect.addEventListener('change', function() {
        const serviceId = this.value;

        if (!serviceId) {
            messageCreneaux.style.display = 'block';
            messageCreneaux.innerHTML = '<p>Veuillez d\'abord sélectionner un service</p>';
            listeCreneaux.style.display = 'none';
            return;
        }

        messageCreneaux.style.display = 'block';
        messageCreneaux.innerHTML = '<p>Chargement des créneaux disponibles...</p>';
        listeCreneaux.style.display = 'none';

        // Appel à l'API client
        fetch(`api/client/getCreneaux.php?service_id=${serviceId}`)
            .then(response => response.json())
            .then(creneaux => {
                if (creneaux.error) {
                    messageCreneaux.innerHTML = `<p style="color: red;">${creneaux.error}</p>`;
                    return;
                }

                if (creneaux.length === 0) {
                    messageCreneaux.innerHTML = '<p>Aucun créneau disponible pour ce service.</p>';
                    listeCreneaux.style.display = 'none';
                    return;
                }

                messageCreneaux.style.display = 'none';
                listeCreneaux.style.display = 'block';
                afficherCreneaux(creneaux);
            })
            .catch(error => {
                console.error('Erreur:', error);
                messageCreneaux.innerHTML = '<p style="color: red;">Erreur lors du chargement des créneaux.</p>';
            });
    });

    function afficherCreneaux(creneaux) {
        tableBody.innerHTML = '';

        creneaux.forEach(creneau => {
            const row = document.createElement('tr');
            
            const dateObj = new Date(creneau.date);
            const dateFormatee = dateObj.toLocaleDateString('fr-CA');

            const dureeText = creneau.duree >= 60 
                ? `${creneau.duree / 60}h` 
                : `${creneau.duree} min`;

            row.innerHTML = `
                <td>${dateFormatee}</td>
                <td>${creneau.heure}</td>
                <td>${dureeText}</td>
                <td>${creneau.tuteur_nom}</td>
                <td>${creneau.service_nom}</td>
                <td>${creneau.commentaire || '-'}</td>
                <td>
                    <button class="btn-reserver" data-creneau-id="${creneau.id}">
                        Réserver
                    </button>
                </td>
            `;

            tableBody.appendChild(row);
        });

        document.querySelectorAll('.btn-reserver').forEach(btn => {
            btn.addEventListener('click', function() {
                const creneauId = this.getAttribute('data-creneau-id');
                reserverCreneau(creneauId);
            });
        });
    }

    function reserverCreneau(creneauId) {
        if (!confirm('Voulez-vous réserver ce créneau?')) {
            return;
        }
        
        fetch('api/client/reserverCreneau.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ creneau_id: creneauId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Recharger les créneaux pour mettre à jour l'affichage
                const serviceId = serviceSelect.value;
                if (serviceId) {
                    serviceSelect.dispatchEvent(new Event('change'));
                }
            } else {
                console.error('Erreur:', data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    }
});
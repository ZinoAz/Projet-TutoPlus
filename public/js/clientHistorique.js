document.addEventListener('DOMContentLoaded', function() {
    chargerHistorique();
});

function chargerHistorique() {
    fetch('api/client/historique.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            afficherHistorique(data.reservations);
        } else {
            afficherErreur(data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        afficherErreur('Impossible de charger l\'historique');
    });
}

function afficherHistorique(reservations) {
    const tbody = document.getElementById('listeHistorique');
    tbody.innerHTML = '';
    
    if (reservations.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">Aucune réservation trouvée.</td></tr>';
        return;
    }
    
    reservations.forEach(reservation => {
        const tr = document.createElement('tr');
        
        const date = new Date(reservation.date_creneau);
        const dateFormatee = date.toLocaleDateString('fr-CA');
        
        const [heures, minutes] = reservation.heure_debut.split(':');
        const debut = new Date();
        debut.setHours(parseInt(heures), parseInt(minutes));
        const fin = new Date(debut.getTime() + reservation.duree_minutes * 60000);
        const horaire = `${reservation.heure_debut} - ${fin.toTimeString().substring(0, 5)}`;
        
        const statut = getStatutLabel(reservation.statut);
        
        tr.innerHTML = `
            <td>${dateFormatee}</td>
            <td>${horaire}</td>
            <td>${reservation.duree_minutes} min</td>
            <td>${reservation.service_nom}</td>
            <td>${reservation.tuteur_nom}</td>
            <td><span class="statut-${reservation.statut}">${statut}</span></td>
            <td><button onclick="annulerReservation(${reservation.id})"> Annuler</button></td>
        `;
        
        tbody.appendChild(tr);
    });
}

function getStatutLabel(statut) {
    const labels = {
        'confirmee': 'Confirmée',
        'annulee': 'Annulée',
        'completee': 'Complétée',
        'reserve': 'Réservée',
        'disponible': 'Disponible',
        'enattente': 'En attente',
    };
    return labels[statut] || statut;
}

function afficherErreur(message) {
    const tbody = document.getElementById('listeHistorique');
    tbody.innerHTML = `<tr><td colspan="7" style="text-align: center; color: red;">${message}</td></tr>`;
}

function annulerReservation(id) {
    if (confirm('Annuler cette réservation ?')) {
        fetch('api/client/annulerReservation.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({id: id})
        })
        .then(r => r.json())
        .then(data => {
            alert(data.message);
            chargerHistorique();
        });
    }
}
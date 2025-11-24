document.addEventListener('DOMContentLoaded', function() {
    chargerCreneaux();
    
    document.getElementById('formRendezVous').addEventListener('submit', function(e) {
        e.preventDefault();
        ajouterCreneau();
    });
});

function ajouterCreneau() {
    const formData = {
        service_id: document.getElementById('service').value,
        date: document.getElementById('date').value,
        heure: document.getElementById('heure').value,
        duree: document.getElementById('duree').value,
        commentaire: document.getElementById('commentaire').value
    };
    
    fetch('api/tuteur/creerCreneau.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('formRendezVous').reset();
            chargerCreneaux();
        } else {
            console.error('Erreur:', data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}

function chargerCreneaux() {
    fetch('api/tuteur/mesCreneaux.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            afficherCreneaux(data.creneaux);
        }
    })
    .catch(error => console.error('Erreur:', error));
}

function afficherCreneaux(creneaux) {
    const tbody = document.getElementById('listeRendezVous');
    tbody.innerHTML = '';
    
    if (creneaux.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;"><p>Aucun créneau créé.</p></td></tr>';
        return;
    }
    
    creneaux.forEach(creneau => {
        const tr = document.createElement('tr');
        
        const date = new Date(creneau.date_creneau);
        const dateFormatee = date.toLocaleDateString('fr-CA');
        
        const [heures, minutes] = creneau.heure_debut.split(':');
        const debut = new Date();
        debut.setHours(parseInt(heures), parseInt(minutes));
        const fin = new Date(debut.getTime() + creneau.duree_minutes * 60000);
        const horaire = `${creneau.heure_debut} - ${fin.toTimeString().substring(0, 5)}`;
        
        const statut = creneau.statut === 'disponible' ? 'Disponible' : 'Réservé';
        const peutSupprimer = creneau.statut === 'disponible';
        
        tr.innerHTML = `
            <td>${dateFormatee}</td>
            <td>${horaire}</td>
            <td>${creneau.duree_minutes} min</td>
            <td>${creneau.service_nom}</td>
            <td><span class="statut-${creneau.statut}">${statut}</span></td>
            <td>${creneau.notes || '-'}</td>
            <td>
                ${peutSupprimer ? 
                    `<button class="btn-supprimer" onclick="supprimerCreneau(${creneau.id})">Supprimer</button>` 
                    : '<em>Non modifiable</em>'}
            </td>
        `;
        
        tbody.appendChild(tr);
    });
}

function supprimerCreneau(creneauId) {
    if (!confirm('Voulez-vous vraiment supprimer ce créneau?')) {
        return;
    }
    
    fetch('api/tuteur/supprimerCreneau.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ creneau_id: creneauId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            chargerCreneaux();
        } else {
            console.error('Erreur:', data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}
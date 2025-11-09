// Liste des disponibilités (stockée dans le navigateur)
let disponibilites = [];

// Charger les disponibilités au démarrage
window.onload = function() {
    chargerDisponibilites();
    afficherDisponibilites();
};

// Gérer la soumission du formulaire
document.getElementById('formRendezVous').addEventListener('submit', function(e) {
    e.preventDefault(); // Empêcher le rechargement de la page
    
    // Récupérer les valeurs du formulaire
    const service = document.getElementById('service').value;
    const duree = parseInt(document.getElementById('duree').value);
    const date = document.getElementById('date').value;
    const heureDebut = document.getElementById('heure').value;
    const notes = document.getElementById('commentaire').value;
    
    // Vérifier que la durée est minimum 30 minutes (règle métier)
    if (duree < 30) {
        alert('La durée minimum est de 30 minutes!');
        return;
    }
    
    // Calculer l'heure de fin selon la durée
    const heureFin = calculerHeureFin(heureDebut, duree);
    
    // Créer la disponibilité
    const dispo = {
        id: Date.now(), // ID unique
        service: service,
        date: date,
        heureDebut: heureDebut,
        heureFin: heureFin,
        duree: duree,
        notes: notes,
        statut: 'Disponible',
        reserve: false // Important pour la règle métier
    };
    
    // Ajouter à la liste
    disponibilites.push(dispo);
    
    // Sauvegarder (TÂCHE 007-2 : Implémenter la sauvegarde)
    sauvegarderDisponibilites();
    
    // Afficher
    afficherDisponibilites();
    
    // Réinitialiser le formulaire
    document.getElementById('formRendezVous').reset();
    
    // Message de confirmation (POSTCONDITION : Confirmation visuelle)
    alert('Disponibilité ajoutée avec succès!');
});

// Calculer l'heure de fin selon la durée en minutes
function calculerHeureFin(heureDebut, dureeMinutes) {
    const [heures, minutes] = heureDebut.split(':').map(Number);
    const totalMinutes = heures * 60 + minutes + dureeMinutes;
    const nouvelleHeure = Math.floor(totalMinutes / 60);
    const nouveauMinutes = totalMinutes % 60;
    return `${String(nouvelleHeure).padStart(2, '0')}:${String(nouveauMinutes).padStart(2, '0')}`;
}

// Formater la durée pour l'affichage
function formaterDuree(minutes) {
    if (minutes < 60) {
        return minutes + ' min';
    } else if (minutes === 60) {
        return '1h';
    } else {
        const heures = Math.floor(minutes / 60);
        const mins = minutes % 60;
        return mins === 0 ? heures + 'h' : heures + 'h' + mins;
    }
}

// Afficher toutes les disponibilités dans le tableau
function afficherDisponibilites() {
    const tbody = document.getElementById('listeRendezVous');
    tbody.innerHTML = ''; // Vider le tableau
    
    // Si aucune disponibilité
    if (disponibilites.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 2rem;">Aucune disponibilité pour le moment</td></tr>';
        return;
    }
    
    // Afficher chaque disponibilité de la table
    disponibilites.forEach(function(dispo) {
        const tr = document.createElement('tr');
        
        // Formatage de la date
        const dateFormatee = new Date(dispo.date + 'T00:00:00').toLocaleDateString('fr-CA');
        
        // Déterminer le statut et la couleur
        const statutBadge = dispo.reserve ? 
            '<span style="background:#ffc107; color:#000; padding:0.4rem 0.8rem; border-radius:20px; font-size:0.85rem;">Réservé</span>' :
            '<span style="background:#28a745; color:#fff; padding:0.4rem 0.8rem; border-radius:20px; font-size:0.85rem;">Disponible</span>';
        
        tr.innerHTML = `
            <td>${dateFormatee}</td>
            <td>${dispo.heureDebut} - ${dispo.heureFin}</td>
            <td>${formaterDuree(dispo.duree)}</td>
            <td>${dispo.service}</td>
            <td>${statutBadge}</td>
            <td>${dispo.notes || '-'}</td>
            <td>
                <button onclick="modifierDisponibilite(${dispo.id})">Modifier</button>
                <button onclick="supprimerDisponibilite(${dispo.id})" 
                    ${dispo.reserve ? 'disabled title="Impossible de supprimer un créneau réservé"' : ''}>
                    Supprimer
                </button>
            </td>
        `;
        
        tbody.appendChild(tr);
    });
}

// Supprimer une disponibilité
function supprimerDisponibilite(id) {
    // Trouver la disponibilité
    const dispo = disponibilites.find(function(d) {
        return d.id === id;
    });
    
    // RÈGLE MÉTIER : Impossibilité de supprimer un créneau réservé
    if (dispo && dispo.reserve) {
        alert('Impossible de supprimer un créneau déjà réservé par un étudiant!');
        return;
    }
    
    if (confirm('Êtes-vous sûr de vouloir supprimer cette disponibilité?')) {
        // Filtrer pour enlever la disponibilité
        disponibilites = disponibilites.filter(function(d) {
            return d.id !== id;
        });
        
        // Sauvegarder et afficher (TÂCHE 007-2)
        sauvegarderDisponibilites();
        afficherDisponibilites();
        
    }
}

// Modifier une disponibilité
function modifierDisponibilite(id) {
    const dispo = disponibilites.find(function(d) {
        return d.id === id;
    });
    
    if (dispo) {
        // Vérifier si c'est réservé
        if (dispo.reserve) {
            alert('Ce créneau est réservé. Vous pouvez uniquement modifier les notes.');
            const nouvellesNotes = prompt('Nouvelles notes:', dispo.notes);
            if (nouvellesNotes !== null) {
                dispo.notes = nouvellesNotes;
                sauvegarderDisponibilites();
                afficherDisponibilites();
            }
            return;
        }
        
        // Pré-remplir le formulaire
        document.getElementById('service').value = dispo.service;
        document.getElementById('duree').value = dispo.duree;
        document.getElementById('date').value = dispo.date;
        document.getElementById('heure').value = dispo.heureDebut;
        document.getElementById('commentaire').value = dispo.notes;
        
        // Supprimer l'ancien
        supprimerDisponibilite(id);
        
        // Scroll vers le formulaire
        window.scrollTo(0, 0);
        
        alert('ℹModifiez les informations puis cliquez sur "Ajouter la disponibilité"');
    }
}

// Filtrer les disponibilités
function filtrerRendezVous() {
    const filterService = document.getElementById('filterService').value;
    const filterStatut = document.getElementById('filterStatut').value;
    
    const tbody = document.getElementById('listeRendezVous');
    const lignes = tbody.getElementsByTagName('tr');
    
    for (let i = 0; i < lignes.length; i++) {
        const service = lignes[i].cells[3]?.textContent || '';
        const statut = lignes[i].cells[4]?.textContent || '';
        
        let afficher = true;
        
        if (filterService && !service.includes(filterService)) {
            afficher = false;
        }
        
        if (filterStatut && !statut.includes(filterStatut)) {
            afficher = false;
        }
        
        lignes[i].style.display = afficher ? '' : 'none';
    }
}

// Réinitialiser les filtres
function reinitialiserFiltres() {
    document.getElementById('filterService').value = '';
    document.getElementById('filterStatut').value = '';
    afficherDisponibilites();
}

// TÂCHE 007-2 : Sauvegarder dans le navigateur
function sauvegarderDisponibilites() {
    localStorage.setItem('disponibilitesTuteur', JSON.stringify(disponibilites));
    console.log('Modifications enregistrées (POSTCONDITION 007-2)');
}

// Charger depuis le navigateur
function chargerDisponibilites() {
    const saved = localStorage.getItem('disponibilitesTuteur');
    
    if (saved) {
        disponibilites = JSON.parse(saved);
    } else {
        // Disponibilités d'exemple (PRÉCONDITION : Calendrier interactif créé)
        disponibilites = [
            {
                id: 1,
                service: 'Programmation Web',
                date: '2025-11-15',
                heureDebut: '10:30',
                heureFin: '12:00',
                duree: 90,
                notes: "Spécialité en html et css",
                statut: 'Disponible',
                reserve: false
            {
                id: 2,
                service: 'Microsoft',
                date: '2025-11-12',
                heureDebut: '14:00',
                heureFin: '15:00',
                duree: 60,
                notes: "spececialité en c#",
                statut: 'Réservé',
                reserve: true // Ce créneau ne peut pas être supprimé
            },
            {
                id: 3,
                service: 'Programmation IOS',
                date: '2025-11-10',
                heureDebut: '09:00',
                heureFin: '09:30',
                duree: 30,
                notes: "Aide aux developement d'Applications IOS",
                statut: 'Disponible',
                reserve: false
            }
        ];
        sauvegarderDisponibilites();
    }
}
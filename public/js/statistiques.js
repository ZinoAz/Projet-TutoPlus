document.addEventListener('DOMContentLoaded', function() {
    chargerStatistiques();
});

function chargerStatistiques() {
    // MOCK DATA - Données de test
    const mockData = {
        totalCreneaux: 25,
        totalReservations: 18,
        services: {
            'Programmation Web': 8,
            'Programmation iOS': 5,
            'Programmation orientée objet': 3,
            'Réseaux locaux': 2
        },
        evolution: {
            labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven'],
            reservations: [2, 3, 5, 4, 4]
        }
    };

    // Afficher les statistiques de base
    document.getElementById('totalCreneaux').textContent = mockData.totalCreneaux;
    document.getElementById('totalReservations').textContent = mockData.totalReservations;
    
    const taux = Math.round((mockData.totalReservations / mockData.totalCreneaux) * 100);
    document.getElementById('tauxReservation').textContent = taux + '%';

    // Graphique des services (Camembert)
    creerGraphiqueServices(mockData.services);

    // Graphique d'évolution (Ligne)
    creerGraphiqueEvolution(mockData.evolution);
}

function creerGraphiqueServices(services) {
    const ctx = document.getElementById('servicesChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: Object.keys(services),
            datasets: [{
                data: Object.values(services),
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

function creerGraphiqueEvolution(evolution) {
    const ctx = document.getElementById('evolutionChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: evolution.labels,
            datasets: [{
                label: 'Réservations',
                data: evolution.reservations,
                borderColor: '#36A2EB',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - Tuto+</title>
    <link rel="stylesheet" href="css/calendar.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo-collège-ahuntsic.png" alt="Logo Collège Ahuntsic">
        </div>
        <nav class="bar de navigation">
            <a href="index.php">Accueil</a>
            <a href="index.php?action=tuteur">Mes disponibilités</a>
        </nav>
    </header>

    <main>
        <h1>Mes statistiques de tutorat</h1>

        <div class="stats-container">
            <div class="stat-card">
                <h3>Total de créneaux</h3>
                <p class="stat-number" id="totalCreneaux">0</p>
            </div>
            <div class="stat-card">
                <h3>Réservations</h3>
                <p class="stat-number" id="totalReservations">0</p>
            </div>
            <div class="stat-card">
                <h3>Taux de réservation</h3>
                <p class="stat-number" id="tauxReservation">0%</p>
            </div>
        </div>

        <div class="chart-container">
            <h2>Répartition par service</h2>
            <canvas id="servicesChart"></canvas>
        </div>

        <div class="chart-container">
            <h2>Évolution des réservations</h2>
            <canvas id="evolutionChart"></canvas>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="js/statistiques.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Tuteur - Tuto+</title>
    <link rel="stylesheet" href="css/calendar.css">
</head>
<body>
    <header>
        <?php include __DIR__ . '/includes/header.php'; ?>
        <nav class="bar de navigation">
            <a href="index.php">Accueil</a>
            <a href="index.php?action=statistiques">Mes statistiques</a>
            <a href="index.php?action=gestionDemande">Mes demandes</a>
            <a href="index.php?action=deconnexion">Déconnexion</a>
        </nav>
    </header>

    <main>
        <h1>Gestion de mes disponibilités</h1>

        <!-- Information importante -->
        <div class="info-box">
            <p><strong>Information importante :</strong> Les créneaux doivent avoir une <strong>durée minimum de 30 minutes</strong>. 
            Il est impossible de supprimer un créneau déjà réservé par un étudiant.</p>
        </div>

        <!-- Formulaire de création de rendez-vous -->
        <h2>Ajouter une disponibilité</h2>
        
        <form id="formRendezVous">
            <div class="form-row">
                <div class="form-group">
                    <label for="service">Service offert *</label>
                    <select id="service" required>
                        <option value="">Sélectionner un service</option>
                        <?php foreach ($services as $service): ?>
                            <option value="<?= htmlspecialchars($service['id']) ?>">
                                <?= htmlspecialchars($service['nom_service']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="duree">Durée du créneau *</label>
                    <select id="duree" required>
                        <option value="30">30 minutes</option>
                        <option value="60" selected>1 heure</option>
                        <option value="90">1h30</option>
                        <option value="120">2 heures</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="date">Date *</label>
                    <input type="date" id="date" required>
                </div>

                <div class="form-group">
                    <label for="heure">Heure de début *</label>
                    <input type="time" id="heure" required>
                </div>
            </div>

            <div class="form-group">
                <label for="commentaire">Notes (optionnel)</label>
                <textarea id="commentaire" rows="3" placeholder="Ex: Coder un site web pour collaboration"></textarea>
            </div>

            <button type="submit">Ajouter la disponibilité</button>
        </form>

        <!-- Liste des rendez-vous -->
        <h2>Mes créneaux de disponibilité</h2>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Horaire</th>
                    <th>Durée</th>
                    <th>Service</th>
                    <th>Statut</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="listeRendezVous">
            </tbody>
        </table>
    </main>

    <?php include 'includes/footer.php'; ?>

    <!-- LOGIQUE JS pour le calendar -->
    <script src="js/tuteurCreneau.js"></script>
</body>
</html>
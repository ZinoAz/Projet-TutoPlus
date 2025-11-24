<footer>
    <p>
        &copy; <?= date('Y') ?> Tuto+, tous droits réservés.
        <?php if (isset($_SESSION['user_nom'], $_SESSION['user_prenom'])): ?>
            — DEBUG : 
            <?= htmlspecialchars($_SESSION['user_prenom'] . ' ' . $_SESSION['user_nom']) ?>
        <?php endif; ?>
    </p>
</footer>

<!-- Version normale sans debug -->
<!-- <footer> <p>&copy; 2025 Tuto+, tous droits réservé.</p> </footer> -->
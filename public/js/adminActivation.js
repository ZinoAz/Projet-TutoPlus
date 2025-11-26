document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.toggle-actif');

    checkboxes.forEach(function (cb) {
        cb.addEventListener('change', function () {
            const id = this.dataset.id;
            const actif = this.checked ? 1 : 0;
            const checkbox = this;

            fetch('api/admin/activation.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id, actif: actif })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    alert(data.message || 'Erreur lors de la mise à jour.');
                    checkbox.checked = !checkbox.checked;
                }
            })
            .catch(err => {
                console.error('Erreur fetch activation:', err);
                alert('Erreur réseau.');
                checkbox.checked = !checkbox.checked;
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Gérer la connexion
    const loginForm = document.querySelector('.left-side form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                email: document.getElementById('email').value,
                password: document.getElementById('password').value
            };
            
            fetch('api/auth/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.user_type === 'tuteur') {
                        window.location.href = 'index.php?action=tuteur';
                    } else {
                        window.location.href = 'index.php?action=client';
                    }
                } else {
                    afficherErreur('.left-side form', data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                afficherErreur('.left-side form', 'Une erreur est survenue lors de la connexion');
            });
        });
    }

    // Gérer l'inscription client
    const btnClient = document.querySelector('button[name="register_client"]');
    if (btnClient) {
        btnClient.addEventListener('click', function(e) {
            e.preventDefault();
            inscrire('etudiant');
    });
}

    // Gérer l'inscription tuteur
    const btnTuteur = document.querySelector('button[name="register_tuteur"]');
    if (btnTuteur) {
        btnTuteur.addEventListener('click', function(e) {
            e.preventDefault();
            inscrire('tuteur');
        });
    }
});

function inscrire(type) {
    const formData = {
        nom: document.getElementById('nom').value,
        prenom: document.getElementById('prenom').value,
        email: document.getElementById('email_register').value,
        password: document.getElementById('password_register').value,
        type_utilisateur: type
    };

    // Validation simple
    if (!formData.nom || !formData.prenom || !formData.email || !formData.password) {
        afficherErreur('.right-side form', 'Veuillez remplir tous les champs');
        return;
    }

    fetch('api/auth/register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirection automatique selon le type
            if (type === 'tuteur') {
                window.location.href = 'index.php?action=tuteur';
            } else {
                window.location.href = 'index.php?action=client';
            }
        } else {
            afficherErreur('.right-side form', data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        afficherErreur('.right-side form', 'Une erreur est survenue lors de l\'inscription');
    });
}

function afficherErreur(selector, message) {
    // Supprimer les anciens messages
    const ancienMessage = document.querySelector(`${selector} .error-message`);
    if (ancienMessage) {
        ancienMessage.remove();
    }

    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    
    const form = document.querySelector(selector);
    form.insertBefore(errorDiv, form.firstChild);

    // Retirer le message après 5 secondes
    setTimeout(() => {
        errorDiv.remove();
    }, 5000);
}

function afficherSucces(selector, message) {
    // Supprimer les anciens messages
    const ancienMessage = document.querySelector(`${selector} .success-message`);
    if (ancienMessage) {
        ancienMessage.remove();
    }

    const successDiv = document.createElement('div');
    successDiv.className = 'success-message';
    successDiv.textContent = message;
    
    const form = document.querySelector(selector);
    form.insertBefore(successDiv, form.firstChild);

    // Retirer le message après 5 secondes
    setTimeout(() => {
        successDiv.remove();
    }, 5000);
}
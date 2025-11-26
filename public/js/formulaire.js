document.addEventListener("DOMContentLoaded", () => {
    const tuteurListe = document.getElementById("tuteurListe");
    const contactFormContainer = document.getElementById("contactFormContainer");
    const contactForm = document.getElementById("contactForm");
    const cancelFormBtn = document.getElementById("cancelFormBtn");

    // Fonction pour afficher le formulaire
    function showContactForm(tuteur) {
        document.getElementById("tuteurNom").textContent = `${tuteur.prenom} ${tuteur.nom}`;
        document.getElementById("tuteurEmail").value = tuteur.email;
        contactFormContainer.style.display = "block";
        
        // Scroll vers le formulaire
        contactFormContainer.scrollIntoView({ behavior: "smooth", block: "start" });
    }

    // Fonction pour masquer le formulaire
    function hideContactForm() {
        contactFormContainer.style.display = "none";
        contactForm.reset();
    }

    // Événements pour fermer le formulaire
    cancelFormBtn.addEventListener("click", hideContactForm);

    // Gestion de la soumission du formulaire
    contactForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = {
            tuteurEmail: document.getElementById("tuteurEmail").value,
            nom: document.getElementById("nom").value,
            email: document.getElementById("email").value,
            sujet: document.getElementById("sujet").value,
            message: document.getElementById("message").value
        };

        // Validation côté client
        if (!formData.nom.trim() || !formData.email.trim() || !formData.sujet.trim() || !formData.message.trim()) {
            alert("Veuillez remplir tous les champs.");
            return;
        }

        // Validation email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(formData.email)) {
            alert("Veuillez entrer une adresse email valide.");
            return;
        }

        try {
            console.log("Message à envoyer:", formData);
            alert(`Message envoyé avec succès à ${document.getElementById("tuteurNom").textContent}!`);
            hideContactForm();
        } catch (error) {
            console.error("Erreur lors de l'envoi:", error);
            alert("Erreur lors de l'envoi du message. Veuillez réessayer.");
        }
    });

    async function fetchTuteurs() {
        try {
            const response = await fetch('api/client/getAllTuteurs.php');
            
            if (!response.ok) {
                throw new Error(`Erreur HTTP: ${response.status}`);
            }
            
            const textResponse = await response.text();
            console.log("Réponse brute :", textResponse);
            
            let data;
            try {
                data = JSON.parse(textResponse);
            } catch (parseError) {
                console.error("Erreur de parsing JSON:", parseError);
                console.error("Réponse reçue:", textResponse);
                tuteurListe.innerHTML = `<tr><td colspan="4">Erreur: La réponse du serveur n'est pas au format JSON valide.</td></tr>`;
                return;
            }
            
            console.log("Données parsées :", data);

            if (data.success) {
                tuteurListe.innerHTML = "";

                if (data.tuteurs.length === 0) {
                    tuteurListe.innerHTML = `<tr><td colspan="4">Aucun tuteur trouvé.</td></tr>`;
                    return;
                }

                data.tuteurs.forEach(tuteur => {
                    const tr = document.createElement("tr");

                    tr.innerHTML = `
                        <td>${tuteur.prenom}</td>
                        <td>${tuteur.nom}</td>
                        <td>${tuteur.email}</td>
                        <td>
                            <button class="contact-btn" data-tuteur='${JSON.stringify(tuteur)}'>
                                Contacter
                            </button>
                        </td>
                    `;

                    tuteurListe.appendChild(tr);
                });

                document.querySelectorAll(".contact-btn").forEach(btn => {
                    btn.addEventListener("click", (e) => {
                        const tuteur = JSON.parse(e.target.getAttribute("data-tuteur"));
                        showContactForm(tuteur);
                    });
                });
            } else {
                tuteurListe.innerHTML = `<tr><td colspan="4">${data.message || 'Impossible de récupérer les tuteurs.'}</td></tr>`;
            }
        } catch (error) {
            console.error("Erreur complète:", error);
            tuteurListe.innerHTML = `<tr><td colspan="4">Erreur lors de la récupération des tuteurs.</td></tr>`;
        }
    }

    fetchTuteurs();
});
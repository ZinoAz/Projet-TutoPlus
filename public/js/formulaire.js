document.addEventListener("DOMContentLoaded", () => {
    const tuteurListe = document.getElementById("tuteurListe");
    const contactFormWrapper = document.querySelector(".contact-form-wrapper");
    const contactForm = document.getElementById("contactForm");
    const cancelFormBtn = document.getElementById("cancelFormBtn");

    // Fonction pour afficher le formulaire
    function showContactForm(tuteur) {
        document.getElementById("tuteurNom").textContent = `${tuteur.prenom} ${tuteur.nom}`;
        document.getElementById("tuteurId").value = tuteur.id;
        contactFormWrapper.style.display = "block";
        contactFormWrapper.scrollIntoView({ behavior: "smooth", block: "start" });
    }

    // Fonction pour masquer le formulaire
    function hideContactForm() {
        contactFormWrapper.style.display = "none";
        contactForm.reset();
    }

    // Événement pour fermer le formulaire
    cancelFormBtn.addEventListener("click", hideContactForm);

    // Gestion de la soumission du formulaire
    contactForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData();
        formData.append('tuteur_id', document.getElementById("tuteurId").value);
        formData.append('sujet', document.getElementById("sujet").value);
        formData.append('message', document.getElementById("message").value);

        try {
            const response = await fetch('api/messages/createMessage.php', {
                method: 'POST',
                body: formData
            });

            const textResponse = await response.text();
            console.log("Réponse brute de l'API:", textResponse);

            const data = JSON.parse(textResponse);
            console.log("Réponse parsée:", data);

            if (data.success) {
                const params = new URLSearchParams({
                    tuteur: document.getElementById("tuteurNom").textContent,
                    sujet: document.getElementById("sujet").value,
                    message: document.getElementById("message").value
                });
                window.location.href = `index.php?action=confirmationMessage&${params.toString()}`;
            } else {
                alert("Erreur lors de l'envoi du message: " + data.message);
            }
        } catch (error) {
            console.error("Erreur:", error);
            alert("Erreur lors de l'envoi du message.");
        }
    });

    // Récupérer et afficher les tuteurs
    async function fetchTuteurs() {
        try {
            const response = await fetch('api/client/getAllTuteurs.php');
            const data = await response.json();

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
            console.error("Erreur:", error);
            tuteurListe.innerHTML = `<tr><td colspan="4">Erreur lors de la récupération des tuteurs.</td></tr>`;
        }
    }

    fetchTuteurs();
});
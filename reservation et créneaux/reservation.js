document.addEventListener('DOMContentLoaded', function() {
    fetch('get_coachs.php')
        .then(response => response.json())
        .then(data => {
            const coachSelect = document.getElementById('coach');
            data.forEach(coach => {
                let option = document.createElement('option');
                option.value = coach.id;
                option.textContent = `${coach.prenom} ${coach.nom} (${coach.specialite})`;
                coachSelect.appendChild(option);
            });
        });

    document.getElementById('coach').addEventListener('change', function() {
        const coachId = this.value;
        fetch(`get_creneaux.php?coach_id=${coachId}`)
            .then(response => response.json())
            .then(data => {
                const creneauSelect = document.getElementById('creneau');
                creneauSelect.innerHTML = '';
                data.forEach(creneau => {
                    let option = document.createElement('option');
                    option.value = creneau.id;
                    option.textContent = `${creneau.jour} ${creneau.heure_debut}`;
                    creneauSelect.appendChild(option);
                });
            });
    });

    document.getElementById('bookingForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('reservation.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'confirmation.html';
            } else {
                window.location.href = 'error.html';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.location.href = 'error.html';
        });
    });
});

let recordButton = document.getElementById('recordButton');
let sendTextButton = document.getElementById('sendTextButton');
let textMessage = document.getElementById('textMessage');
let chatMessages = document.getElementById('chatMessages');
let audioPlayback = document.getElementById('audioPlayback');
let videoCallButton = document.getElementById('videoCallButton');
let mediaRecorder;
let audioChunks = [];
let stream;

async function getMediaStream() {
    try {
        if (!stream) {
            stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        }
        return stream;
    } catch (error) {
        console.error('Erreur lors de l\'accès au microphone:', error);
        alert('L\'accès au microphone est requis pour utiliser cette fonctionnalité.');
    }
}

// Gestion de l'enregistrement audio
recordButton.addEventListener('mousedown', async () => {
    try {
        stream = await getMediaStream();
        if (stream) {
            mediaRecorder = new MediaRecorder(stream);
            mediaRecorder.start();

            audioChunks = [];
            mediaRecorder.addEventListener('dataavailable', event => {
                audioChunks.push(event.data);
            });
        }
    } catch (error) {
        console.error('Erreur lors du démarrage de l\'enregistrement:', error);
    }
});

recordButton.addEventListener('mouseup', () => {
    if (mediaRecorder && mediaRecorder.state === "recording") {
        mediaRecorder.stop();

        mediaRecorder.addEventListener('stop', () => {
            let audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
            let audioUrl = URL.createObjectURL(audioBlob);
            appendMessage(audioUrl, 'audio', 'sent');

            // Envoyer le message vocal au serveur
            let formData = new FormData();
            formData.append('audio', audioBlob);

            fetch('upload_endpoint_url', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Message vocal envoyé avec succès !');
            })
            .catch(error => {
                console.error('Erreur lors de l\'envoi du message vocal:', error);
            });
        });
    }
});

// Gestion de l'envoi de message texte
sendTextButton.addEventListener('click', () => {
    let message = textMessage.value.trim();
    if (message) {
        appendMessage(message, 'text', 'sent');

        let formData = new FormData();
        formData.append('text', message);

        fetch('upload_text_endpoint_url', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Message texte envoyé avec succès !');
            textMessage.value = '';
        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi du message texte:', error);
        });
    } else {
        alert('Veuillez écrire un message avant de l\'envoyer.');
    }
});

// Fonction pour ajouter un message à la discussion
function appendMessage(content, type, alignment) {
    let messageElement = document.createElement('div');
    messageElement.classList.add('message', type, alignment);

    if (type === 'text') {
        messageElement.textContent = content;
    } else if (type === 'audio') {
        let audioElement = document.createElement('audio');
        audioElement.controls = true;
        audioElement.src = content;
        messageElement.appendChild(audioElement);
    }

    chatMessages.appendChild(messageElement);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Gestion de l'appel vidéo
videoCallButton.addEventListener('click', () => {
    // Logique pour démarrer un appel vidéo
    // Par exemple, en utilisant une URL de salle de conférence Jitsi
    const roomName = 'sportify_video_call';
    const jitsiUrl = `https://meet.jit.si/${roomName}`;
    window.open(jitsiUrl, '_blank', 'width=800,height=600');
});

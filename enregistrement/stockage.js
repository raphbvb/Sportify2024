const express = require('express');
const multer = require('multer');
const path = require('path');
const bodyParser = require('body-parser');
const app = express();

app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, 'uploads/');
    },
    filename: (req, file, cb) => {
        cb(null, file.fieldname + '-' + Date.now() + path.extname(file.originalname));
    }
});

const upload = multer({ storage: storage });

app.post('/upload_endpoint_url', upload.single('audio'), (req, res) => {
    res.json({ message: 'Fichier audio reçu avec succès', file: req.file });
});

app.post('/upload_text_endpoint_url', (req, res) => {
    const message = req.body.text;
    // Sauvegarder le message texte (par exemple, dans une base de données)
    res.json({ message: 'Message texte reçu avec succès', text: message });
});

app.listen(3000, () => {
    console.log('Serveur en écoute sur le port 3000');
});

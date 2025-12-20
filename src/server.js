import app from './app.js';
import { connectDB } from '../config/db.js';

// Connection à la base DB MONGO
connectDB();

app.get('/', (req, res) => {
  res.send('hello');
});

// Lancement du serveur
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`🚀 Serveur lancé sur http://localhost:${PORT}`);
});

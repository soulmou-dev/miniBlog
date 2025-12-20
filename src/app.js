import exporess from 'express';
import path from 'path';
import { fileURLToPath } from 'url';
import { engine } from 'express-handlebars';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const app = exporess();

app.use(exporess.urlencoded({ extended: true }));
app.use(exporess.json());

// Configuration du moteur de template
app.engine(
  'hbs',
  engine({
    extname: 'hbs',
    defaultLayout: 'main',
    layoutsDir: path.join(__dirname, 'views/layouts'),
    partialsDir: path.join(__dirname, 'views/partials'),
  }),
);
app.set('engine view', 'hbs');
app.set('views', path.join(__dirname, 'views'));

export default app;

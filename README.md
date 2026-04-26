# CC3 Laravel

Application Laravel de gestion medicale avec authentification, gestion des utilisateurs par role et gestion des rendez-vous.

## Installation du projet

### Prerequis

- PHP 8.2 ou plus
- Composer
- Node.js et npm
- MySQL ou MariaDB

### Etapes d'installation

1. Cloner le projet puis entrer dans le dossier:

```bash
git clone https://github.com/ayoub09alliti/CC3_laravel.git
cd CC3_laravel
```

2. Installer les dependances PHP:

```bash
composer install
```

3. Installer les dependances front:

```bash
npm install
```

4. Copier le fichier d'environnement:

```bash
cp .env.example .env
```

Sous Windows PowerShell, si `cp` ne fonctionne pas:

```powershell
Copy-Item .env.example .env
```

5. Configurer la base de donnees dans le fichier `.env`:

```env
APP_NAME="CC3 Laravel"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cc3_laravel
DB_USERNAME=root
DB_PASSWORD=
```

6. Generer la cle de l'application:

```bash
php artisan key:generate
```

7. Executer les migrations et les seeders:

```bash
php artisan migrate --seed
```

8. Lancer le serveur Vite:

```bash
npm run dev
```

9. Lancer le serveur Laravel:

```bash
php artisan serve
```

10. Ouvrir l'application:

```text
http://127.0.0.1:8000
```

## Configuration email

Par defaut, Laravel utilise ici le mailer `log` si rien n'est configure. Pour envoyer de vrais emails lors de la confirmation d'un rendez-vous, renseigner les variables SMTP dans `.env`, par exemple:

```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="no-reply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Identifiants de connexion par defaut

Ces comptes sont crees par `php artisan migrate --seed`.

### Admin

- Email: `admin@medicab.ma`
- Mot de passe: `password`

### Medecins

- `dr.martin@medicab.ma` / `password`
- `dr.benali@medicab.ma` / `password`
- `dr.zahra@medicab.ma` / `password`
- `dr.tazi@medicab.ma` / `password`

### Patient de test

- Email: `patient@medicab.ma`
- Mot de passe: `password`

D'autres patients de demonstration sont aussi injectes par le seeder.

## Documentation des endpoints

Note importante: le projet ne contient pas d'API REST JSON dediee dans `routes/api.php` a ce stade. Les endpoints ci-dessous sont les endpoints HTTP/web actuellement implementes.

### Authentification

- `GET /login`
  - Affiche le formulaire de connexion.
- `POST /login`
  - Authentifie un utilisateur.
- `GET /register`
  - Affiche le formulaire d'inscription.
- `POST /register`
  - Cree un nouveau compte utilisateur.
- `POST /logout`
  - Deconnecte l'utilisateur connecte.

### Dashboard

- `GET /dashboard`
  - Redirige vers le dashboard correspondant au role.
- `GET /patient/dashboard`
  - Dashboard patient.
- `GET /doctor/dashboard`
  - Dashboard medecin.
- `GET /admin/dashboard`
  - Dashboard administrateur.

### Rendez-vous

- `GET /appointments`
  - Liste les rendez-vous visibles pour l'utilisateur courant.
- `GET /appointments/create`
  - Redirige vers la liste avec ouverture de la modale de creation.
- `POST /appointments`
  - Cree un rendez-vous.
  - Pour un patient, le statut est force a `pending`.
- `GET /appointments/{appointment}/edit`
  - Redirige vers la liste avec ouverture de la modale de modification.
- `PUT /appointments/{appointment}`
  - Met a jour un rendez-vous.
  - Si le statut passe a `confirmed` par un admin ou un medecin, un email est envoye au patient.
- `PATCH /appointments/{appointment}/confirm`
  - Confirme rapidement un rendez-vous depuis la liste.
- `PATCH /appointments/{appointment}/cancel`
  - Annule un rendez-vous.
- `DELETE /appointments/{appointment}`
  - Supprime un rendez-vous pour l'admin.
  - Pour un utilisateur non admin, cette action annule le rendez-vous.

### Gestion admin des utilisateurs

#### Patients

- `GET /admin/users/patient`
  - Liste des patients.
- `POST /admin/users/patient`
  - Creation d'un patient.
- `PUT /admin/users/patient/{user}`
  - Modification d'un patient.
- `DELETE /admin/users/patient/{user}`
  - Suppression d'un patient.

#### Medecins

- `GET /admin/users/doctor`
  - Liste des medecins.
- `POST /admin/users/doctor`
  - Creation d'un medecin.
- `PUT /admin/users/doctor/{user}`
  - Modification d'un medecin.
- `DELETE /admin/users/doctor/{user}`
  - Suppression d'un medecin.

## Remarques fonctionnelles

- Les patients ne peuvent pas modifier un rendez-vous existant.
- Les patients creent leurs rendez-vous avec le statut `pending`.
- Les admins et medecins peuvent confirmer un rendez-vous directement depuis la liste.
- La creation et la modification des rendez-vous se font via des fenetres modales.

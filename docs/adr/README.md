# MarketHub 🎓

> Marketplace étudiante — Des services par des étudiants, pour des étudiants.

## Description

MarketHub est une plateforme full-stack permettant aux étudiants de proposer et acheter des services entre eux. Elle intègre une authentification JWT, un système de messagerie temps réel via WebSocket, et un agent IA conseiller.

## Équipe

| Membre | Rôle |
|--------|------|
| Alphonse | Chef de projet / Backend / DevOps |
| Elisabeth | Développeur Frontend Vue.js |
| Dovane | Développeur Full-stack / WebSocket |

## Stack technique

| Couche | Technologie |
|--------|-------------|
| Frontend | Vue.js 3 + TypeScript + Pinia + Tailwind CSS |
| Backend | Symfony 6 + PHP 8.2 + API REST |
| Base de données | MySQL 8 |
| Authentification | JWT (Lexik Bundle) |
| Temps réel | WebSocket natif PHP |
| DevOps | Docker Compose |

## Prérequis

- PHP 8.2+
- Node.js 20+
- Composer
- Symfony CLI
- XAMPP (MySQL)

## Installation

### 1 — Cloner le projet

```bash
git clone https://github.com/DIDIANGE2025/MarketHub.git
cd MarketHub
```

### 2 — Backend

```bash
cd backend
composer install
cp .env.example .env
# Configurer DATABASE_URL dans .env
php bin/console doctrine:migrations:migrate
```

### 3 — Frontend

```bash
cd ../frontend
npm install
```

## Lancer le projet

**Terminal 1 — Backend :**
```bash
cd backend
symfony serve --no-tls
```

**Terminal 2 — WebSocket :**
```bash
cd backend
php bin/console app:websocket-server
```

**Terminal 3 — Frontend :**
```bash
cd frontend
npm run dev
```

Ouvrir : http://localhost:5173

## Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|-------------|
| Acheteur | testuser@test.com | test1234 |
| Vendeur | vendeur@markethub.com | vendeur1234 |
| Admin | admin@markethub.com | admin1234 |

## Fonctionnalités

- ✅ Inscription / Connexion avec JWT
- ✅ Catalogue de services avec filtres
- ✅ Commande de services
- ✅ Dashboard acheteur — voir et annuler ses commandes
- ✅ Dashboard vendeur — CRUD complet de ses services
- ✅ Panel admin — gérer utilisateurs, services et commandes
- ✅ Messagerie temps réel (WebSocket)
- ✅ Agent IA — conseiller, générateur de description, matching

## API Endpoints

| Méthode | Endpoint | Description | Auth |
|---------|----------|-------------|------|
| POST | /api/auth/register | Inscription | Non |
| POST | /api/auth/login | Connexion | Non |
| GET | /api/services | Liste des services | Non |
| GET | /api/services/{id} | Détail service | Non |
| POST | /api/services | Créer service | Oui |
| PUT | /api/services/{id} | Modifier service | Oui |
| DELETE | /api/services/{id} | Supprimer service | Oui |
| POST | /api/orders | Passer commande | Oui |
| GET | /api/orders/my | Mes commandes | Oui |
| PUT | /api/orders/{id}/cancel | Annuler commande | Oui |
| POST | /api/agent/conseiller | Agent conseiller | Non |
| POST | /api/agent/description | Générateur description | Non |
| POST | /api/agent/matching | Matching services | Non |
| GET | /api/admin/stats | Statistiques | Admin |
| GET | /api/admin/users | Tous les users | Admin |
| DELETE | /api/admin/users/{id} | Supprimer user | Admin |
| GET | /api/admin/services | Tous les services | Admin |
| DELETE | /api/admin/services/{id} | Supprimer service | Admin |
| GET | /api/admin/orders | Toutes les commandes | Admin |

## Architecture

MarketHub/
├── frontend/          # Vue.js 3
│   ├── src/
│   │   ├── views/     # Pages
│   │   ├── components/# Composants
│   │   ├── stores/    # Pinia
│   │   ├── services/  # API calls
│   │   └── router/    # Routes
├── backend/           # Symfony 6
│   ├── src/
│   │   ├── Controller/# API Controllers
│   │   ├── Entity/    # Doctrine ORM
│   │   └── Command/   # WebSocket
│   └── config/        # Configuration
└── docker-compose.yml # Docker


## Conventions Git

- Branches : feature/nom, develop, main
- Commits : feat:, fix:, docs:, test:
- PR obligatoire avant merge sur develop

## Utilisation de l'IA

Ce projet a été développé avec l'assistance de Claude (Anthropic) pour :
- Débogage des problèmes JWT et cache Symfony
- Implémentation du WebSocket natif PHP
- Création des composants Vue.js
- Configuration Docker

Journal complet disponible dans `docs/Journal_IA.pdf
# MarketHub — Marketplace de services entre étudiants

## Présentation
MarketHub est une marketplace complète où les étudiants 
peuvent proposer et acheter des services : cours particuliers, 
développement, design, rédaction.

## Équipe
| Membre | Rôle |
|---|---|
| Alphonse | Chef de projet / Backend Symfony |
| Elisabeth | Développeur Frontend Vue.js |
| Dovane | Développeur Full-stack / WebSocket |

## Stack technique
| Couche | Technologie |
|---|---|
| Backend | Symfony PHP + API Platform |
| Frontend | Vue.js + TypeScript + Tailwind CSS |
| Base de données | MySQL + Doctrine ORM |
| Messagerie | WebSocket Ratchet |
| Auth | JWT + Refresh Token |
| DevOps | Docker + GitHub Actions |
| Tests | PHPUnit + Cypress |

## Fonctionnalités principales
- Recherche full-text avec filtres combinés
- Profils vendeur et acheteur
- Messagerie temps réel WebSocket
- Système d'avis et notes
- Panier et checkout
- Dashboard admin
- Paiement simulé sécurisé

## Structure du projet
MarketHub/
├── backend/          ← Symfony PHP
├── frontend/         ← Vue.js TypeScript
├── docs/
│   ├── uml/          ← Diagrammes draw.io
│   ├── wireframes/   ← Maquettes
│   └── adr/          ← Décisions techniques
├── AI_JOURNAL.md     ← Journal IA
├── docker-compose.yml
└── README.md

## Installation
### Prérequis
- Docker + Docker Compose
- Node.js 18+
- PHP 8.2+

### Lancer le projet
git clone https://github.com/votre-repo/markethub
cd markethub
docker-compose up -d

## Équipe et responsabilités
- Alphonse : Backend API + BDD + CI/CD
- Elisabeth : Frontend Vue.js + UI/UX
- Dovane : WebSocket + Dashboard Admin

## Conventions Git
- Branches : feature/nom, develop, main
- Commits : feat:, fix:, docs:, test:
- PR obligatoire avant merge sur develop

## Documentation
- Diagrammes UML → docs/uml/
- Wireframes → docs/wireframes/
- ADR Choix techniques → docs/adr/ADR-001.md
- Journal IA → AI_JOURNAL.md
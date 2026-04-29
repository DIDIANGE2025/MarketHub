# Journal d'utilisation de l'IA — MarketHub

## Règle d'utilisation
Ce journal documente honnêtement comment j'ai utilisé 
l'IA aujourd'hui, ce que j'ai compris, et ce que j'ai 
dû corriger ou refaire moi-même.

---

## Jour 1 — Conception et Architecture

### Utilisation 1 — Diagramme de cas d'utilisation
Comment :J'ai demandé à Claude de m'expliquer 
ce qu'est un diagramme de cas d'utilisation avant 
de commencer. Je ne savais pas exactement comment 
représenter les relations entre les acteurs.

Ce que j'ai fait : Claude m'a guidé pas à pas 
sur draw.io — comment ouvrir le logiciel, comment 
importer un diagramme via Suppléments > Modifier 
le diagramme. J'ai dû recommencer deux fois car 
je n'avais pas bien sélectionné tout le texte 
avant de coller le XML.

Ce que j'ai compris : Un diagramme de cas 
d'utilisation montre qui fait quoi dans le système. 
Les bonshommes sont les acteurs, les ovales sont 
les actions, les flèches montrent qui fait quoi.

**Ce que j'ai modifié :** J'ai renommé les fichiers 
moi-même et organisé les dossiers docs/uml/ sur 
mon ordinateur.

---

### Utilisation 2 — Diagramme de classes
Comment :J'ai demandé le XML en français car 
la première version était en anglais et je voulais 
que ce soit compréhensible pour la présentation.

Ce que j'ai fait : J'ai importé le diagramme 
dans draw.io. J'ai dû demander une nouvelle version 
plus simple car la première était trop complexe 
à lire.

Ce que j'ai compris : Chaque rectangle représente 
une table de la base de données. CÉ veut dire Clé 
Étrangère — c'est le lien entre deux tables. 
Par exemple user_id dans Service pointe vers 
la table Utilisateur.

Ce que j'ai modifié : J'ai exporté le fichier 
en PNG moi-même et l'ai placé dans le bon dossier.

---

### Utilisation 3 — Diagramme de séquence
Comment :Claude m'a expliqué ce qu'est un 
diagramme de séquence avec une analogie simple — 
on lit de haut en bas comme une conversation 
dans le temps.

Ce que j'ai fait : J'ai importé le XML dans 
une nouvelle page draw.io. L'acteur Acheteur 
n'avait pas la forme bonhomme UML — Claude m'a 
expliqué que ce n'était pas bloquant pour le Gate 1.

Ce que j'ai compris : Le diagramme montre 
dans quel ordre les composants se parlent — 
Frontend -API - Base de données. Les flèches 
pleines sont des envois, les pointillées 
sont des réponses.

---

### Utilisation 4 — Diagramme d'activité
Comment : Claude m'a expliqué la différence 
avec le diagramme de séquence. L'activité montre 
le chemin avec des décisions Oui/Non, la séquence 
montre l'ordre des échanges.

Ce que j'ai fait : Importé le XML dans draw.io 
sur une nouvelle page nommée Activite.

Ce que j'ai compris : Le rond noir = départ, 
le losange = décision, le rond cerclé = fin. 
C'est le flux du processus de commande du début 
à la fin.

---

### Utilisation 5 — Wireframes
Comment : Au début je voulais utiliser Figma 
avec un kit wireframe de la communauté. On a 
perdu du temps à chercher les bons composants 
dans le kit. On a finalement décidé de revenir 
sur draw.io que je maîtrisais déjà.

Ce que j'ai fait : J'ai créé 5 pages dans 
draw.io — Accueil, Catalogue, Fiche-service, 
Checkout, Messagerie. Pour chaque page j'ai 
collé le XML fourni par Claude puis sauvegardé.

Ce que j'ai compris : Un wireframe c'est 
le plan d'une page web — comme un plan 
d'architecte avant de construire. On montre 
la structure sans les couleurs ni les images. 
Basse fidélité = rapide à faire, suffisant 
pour montrer qu'on a réfléchi avant de coder.

Ce que j'ai appris en plus : Checkout veut 
dire "passer en caisse" en anglais. C'est la 
page de paiement.

---

### Utilisation 6 — ADR
Comment : Je ne savais pas ce qu'était un ADR. 
Claude m'a expliqué que c'est un document qui 
justifie pourquoi on a choisi telle technologie 
plutôt qu'une autre. Le jury veut voir qu'on 
n'a pas choisi la stack au hasard.

Ce que j'ai fait : J'ai créé le fichier 
ADR-001.md dans VS Code dans le dossier 
docs/adr/. J'ai personnalisé le document 
avec les vrais prénoms de l'équipe — 
Alphonse, Elisabeth, Dovane.

**Ce que j'ai compris :** On utilise le format 
.md (Markdown) et pas Word car le fichier 
s'affiche directement sur GitHub sans 
logiciel supplémentaire.

---

### Utilisation 7 — README
Comment : Claude m'a expliqué que le README 
est la première chose que le formateur et 
le jury lisent sur le repo Git. C'est la 
carte d'identité du projet.

Ce que j'ai fait : Créé README.md à la 
racine du dossier MarketHub dans VS Code. 
J'ai vérifié que la structure des dossiers 
dans le README correspond bien à ce que 
j'ai sur mon ordinateur.

---

## Ce que j'ai appris aujourd'hui

- La différence entre les 4 diagrammes UML
- Comment utiliser draw.io pour importer des XML
- Ce qu'est un wireframe et pourquoi c'est utile
- Ce qu'est un ADR et pourquoi le jury l'exige
- La différence entre .md et .docx pour Git
- Comment organiser un projet dans VS Code

## Ce qui était difficile

- Trouver le bon outil pour les wireframes 
  (on a essayé Figma avant de revenir sur draw.io)
- Comprendre la différence entre diagramme 
  de séquence et diagramme d'activité
- Renommer et organiser correctement 
  tous les fichiers

## Décisions prises par moi-même

- Choix de Vue.js plutôt qu'Angular car 
  plus simple pour 7 jours
- Organisation des dossiers docs/uml/wireframes/adr
- Nommage des fichiers en français pour 
  la clarté de l'équipe
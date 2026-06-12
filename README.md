# ⚕️ PharmaFEFO - Système de Gestion de Stock (Logique FEFO)

PharmaFEFO est une application web de gestion d'inventaire conçue spécifiquement pour les pharmacies et les centres de santé. Elle implémente intelligemment l'algorithme **FEFO (First Expired, First Out)** pour garantir que les médicaments dont la date de péremption est la plus proche soient sortis en premier, réduisant ainsi les pertes et assurant la sécurité des patients.

## ✨ Fonctionnalités Principales

* **🔒 Sécurité & Authentification :** Connexion sécurisée avec hachage des mots de passe (`bcrypt`) et gestion des sessions.
* **📊 Tableau de Bord Intelligent :** Vue globale sur les stocks avec un système d'alerte visuelle (Vert, Orange, Rouge) basé sur la criticité des dates de péremption.
* **📥 Entrées de Stock :** Ajout de nouveaux lots de médicaments avec traçabilité complète.
* **📤 Sorties Automatisées (FEFO) :** Lors d'une demande de sortie, l'algorithme sélectionne et déduit automatiquement les quantités des lots les plus proches de leur date d'expiration.
* **📖 Traçabilité & Historique :** Un journal détaillé de tous les mouvements (Entrées/Sorties), incluant l'utilisateur, la date, la quantité, et les motifs (notes).

## 🛠️ Stack Technique & Architecture

Ce projet a été développé en respectant des standards stricts de développement :

* **Back-end :** PHP (Vanilla), PDO (PHP Data Objects) pour la sécurité des requêtes préparées.
* **Base de données :** MySQL.
* **Front-end :** HTML5, Tailwind CSS (via CDN) pour une interface moderne et responsive, JavaScript (Vanilla) pour la gestion des fenêtres modales.
* **Architecture :** **MVC (Modèle-Vue-Contrôleur)** pour une séparation claire des responsabilités et un code maintenable.

## 📁 Structure du Projet

```text
pharmafefo/
├── config/
│   └── Database.php           # Connexion PDO à la base de données
├── public/
│   └── index.php              # Routeur principal (Point d'entrée unique)
├── src/
│   ├── Controller/            # Contrôleurs (Auth, Dashboard, Stock, History)
│   ├── Entity/                # Entités du domaine
│   └── Repository/            # Logique d'accès aux données (SQL)
└── templates/                 # Vues HTML/PHP (login, dashboard, history)

## ERD 
<img width="738" height="368" alt="image" src="https://github.com/user-attachments/assets/7c0adc66-1a67-45ad-bc6f-d23039435cde" />
## UML
<img width="321" height="346" alt="image" src="https://github.com/user-attachments/assets/d442b736-0716-41c2-b1d0-7f2fe0380236" />

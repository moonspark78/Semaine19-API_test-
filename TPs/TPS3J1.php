<?php 

/* 

--- TP Semaine 3 Jour 1 Créer l'API des catégories de l'eShop ---


        ----- Contexte

Nous avons commencé à développer le backend API d'un site e-commerce.

Pendant la journée, nous avons mis en place :

un projet Laravel dédié à notre API ;
une première route API ;
un modèle Product ;
un ProductController ;
une ProductResource ;
la récupération de produits au format JSON ;
l'utilisation de Postman pour tester nos endpoints.

Nous allons maintenant développer une deuxième ressource de l'API.

Vous allez créer la gestion des catégories de produits.


        ----- Objectif du TP

À la fin du TP, votre API devra être capable de fournir les catégories de l'eShop sous forme de JSON.

Vous devrez mettre en place :

Category
    ↓
CategoryController
    ↓
CategoryResource
    ↓
Routes API
    ↓
JSON
    ↓
Postman

Vous devrez également créer une relation entre les catégories et les produits.


        ----- Partie 1 — Créer la table categories

Adaptez une migration permettant de stocker les catégories.

Une catégorie devra au minimum posséder :

Champ	        Type	    Description
id	            bigint	    Identifiant
name	        string	    Nom de la catégorie
description	    text	    Description de la catégorie
created_at	    timestamp	Date de création
updated_at	    timestamp	Date de modification

Exemples de catégories :

Informatique
Smartphones
Audio
Gaming
Accessoires

--- Travail demandé
1. Modifier la migration.
2. Définir les colonnes.
3. Exécuter la migration.
4. Vérifier la table dans la base de données.


        ----- Partie 2 — Créer le modèle Category

Adaptez le modèle Eloquent pour le faire correspondre à la nouvelle structure de table

Egalement on oublie pas la relation correspondant à notre modèle de données :

Une catégorie peut posséder plusieurs produits.


        ----- Partie 3 — Créer quelques catégories

Vous devez disposer de quelques données permettant de tester votre API.

Vous pouvez créer par exemple :

Informatique
Gaming
Audio
Smartphones
Accessoires

Vous pouvez utiliser le mécanisme de votre choix parmi ceux déjà vus en cours pour créer ces données.

L'objectif est simplement d'avoir suffisamment de catégories pour tester votre API.




        ----- Partie 4 — Créer CategoryController

Créez un controller dédié aux catégories :

CategoryController

Ajoutez une méthode permettant de récupérer la liste des catégories.

Votre méthode devra récupérer les catégories avec Eloquent.

Elle devra ensuite retourner les données au format JSON à travers une API Resource.


        ----- Partie 5 — Créer CategoryResource

Créez :

CategoryResource

Cette Resource devra contrôler les données exposées par votre API.

Pour chaque catégorie, retournez au minimum :

{
    "id": 1,
    "name": "Informatique",
    "description": "Ordinateurs et périphériques"
}

Attention

Ne retournez pas automatiquement toutes les informations disponibles dans le modèle.

Vous devez décider quelles informations doivent être exposées par votre API.



        ----- Partie 6 — Ajouter les routes API

Créez une route permettant de récupérer les catégories.

L'endpoint devra être :

GET /api/categories

Il devra retourner une collection de CategoryResource.


        ----- Partie 7 — Tester avec Postman

Utilisez Postman pour tester votre endpoint.

Effectuez une requête :

GET http://localhost:8000/api/categories

Vous devez obtenir une réponse JSON contenant vos catégories.

Exemple :

{
    "data": [
        {
            "id": 1,
            "name": "Informatique",
            "description": "Ordinateurs et périphériques"
        },
        {
            "id": 2,
            "name": "Gaming",
            "description": "Matériel dédié au jeu vidéo"
        }
    ]
}

Vérifiez également que le code HTTP retourné est correct.


        ----- Partie 8 — Bonus : afficher les produits d'une catégorie

Une fois le fonctionnement précédent terminé, améliorez votre CategoryResource.

L'objectif est de pouvoir retourner les produits associés à une catégorie.

Par exemple :

{
    "id": 1,
    "name": "Informatique",
    "description": "Ordinateurs et périphériques",
    "products": [
        {
            "id": 1,
            "name": "Clavier mécanique",
            "price": "89.90"
        },
        {
            "id": 2,
            "name": "Souris sans fil",
            "price": "39.90"
        }
    ]
}



Attention

Vous devez réfléchir à la manière de charger la relation afin d'éviter de générer inutilement une multitude de requêtes SQL.

Utilisez les notions d'eager loading vues précédemment.


        ----- Partie 9 — Bonus : créer une route pour une catégorie

Ajoutez un endpoint permettant de récupérer une catégorie précise :

GET /api/categories/{category}

Par exemple :

GET /api/categories/2

La réponse devra utiliser CategoryResource.

Vous pourrez utiliser le Route Model Binding étudié pendant la première semaine.
*/
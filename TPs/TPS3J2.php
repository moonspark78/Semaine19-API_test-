<?php 

/* 

--- TP Semaine 3 Jour 2 Gestion sécurisée des commandes de l'eShop ---


        ----- Objectif du TP

Notre API eShop dispose désormais de plusieurs ressources et de mécanismes permettant de sécuriser son accès.

Vous allez maintenant enrichir l'application en développant une nouvelle fonctionnalité complète :

La gestion des commandes clients.

L'objectif est de réutiliser les notions étudiées aujourd'hui :

relations Eloquent ;
API Resources ;
réponses HTTP ;
validation ;
authentification avec Sanctum ;
middleware ;
autorisation ;
sécurité des routes.

À la fin du TP, notre API devra permettre à un client de créer et consulter ses commandes, tandis qu'un administrateur disposera de fonctionnalités supplémentaires.



        ----- 1. Modélisation des commandes

Nous allons ajouter deux nouvelles tables à notre base de données.

Table orders

Une commande doit contenir au minimum :

Champ	Description
id	Identifiant de la commande
user_id	Utilisateur ayant passé la commande
status	État de la commande
total	Montant total de la commande
created_at	Date de création
updated_at	Date de modification

Les statuts possibles seront :

pending
paid
shipped
delivered
cancelled
Table order_product

Une commande peut contenir plusieurs produits et un produit peut apparaître dans plusieurs commandes.

La relation nécessite donc une table pivot contenant :

Champ	Description
order_id	Commande
product_id	Produit
quantity	Quantité commandée
price	Prix du produit au moment de la commande

!!! Attention au champ price :

Le prix enregistré dans une commande doit correspondre au prix du produit au moment de l'achat.

Si le prix d'un produit est modifié ultérieurement, les anciennes commandes ne doivent pas être modifiées.


       ----- 2. Relations Eloquent

Mettez en place les relations nécessaires entre :

User
Order
Product

Une commande appartient à un utilisateur.

Un utilisateur peut posséder plusieurs commandes.

Une commande contient plusieurs produits.

Un produit peut appartenir à plusieurs commandes.

La relation entre Order et Product devra également permettre de récupérer :

la quantité commandée ;
le prix du produit au moment de la commande.


        ----- 3. Création des commandes

Créez les routes nécessaires à la gestion des commandes.

Les commandes doivent être accessibles uniquement aux utilisateurs authentifiés.

Vous devrez notamment permettre à un utilisateur connecté de :

Consulter ses commandes
GET /api/orders

L'utilisateur ne doit voir que ses propres commandes.

Consulter une commande
GET /api/orders/{order}

Un utilisateur peut consulter une commande uniquement si elle lui appartient.

Un utilisateur ne doit jamais pouvoir consulter la commande d'un autre utilisateur.

Créer une commande
POST /api/orders

La requête devra recevoir une liste de produits et les quantités souhaitées.

Exemple :

{
    "products": [
        {
            "id": 1,
            "quantity": 2
        },
        {
            "id": 4,
            "quantity": 1
        }
    ]
}




        ----- 4. Création d'une commande

Lorsqu'une commande est créée, votre application doit :

vérifier les données reçues ;
vérifier que les produits existent ;
vérifier que les quantités sont valides ;
récupérer les prix des produits ;
calculer le montant total ;
créer la commande ;
enregistrer les produits commandés ;
enregistrer les quantités ;
enregistrer le prix de chaque produit au moment de l'achat ;
retourner la commande créée.

Le statut initial d'une nouvelle commande sera :

pending


        ----- 5. Validation des données

La création d'une commande doit être correctement validée.

Les données suivantes devront notamment être vérifiées :

products
obligatoire ;
doit être un tableau ;
doit contenir au moins un produit.
Chaque produit
l'identifiant du produit est obligatoire ;
le produit doit exister dans la base de données ;
la quantité est obligatoire ;
la quantité doit être un entier ;
la quantité doit être supérieure ou égale à 1.

Une requête invalide devra retourner une réponse HTTP adaptée.


        ----- 6. API Resource

Créez une API Resource permettant de représenter une commande dans les réponses de l'API.

Une réponse pourrait avoir une structure similaire à :

{
    "id": 15,
    "status": "pending",
    "total": 278.80,
    "products": [
        {
            "id": 1,
            "name": "Clavier",
            "quantity": 2,
            "price": 89.90
        }
    ]
}

La structure exacte peut être adaptée à votre projet.

L'objectif est de ne pas retourner directement le modèle Eloquent.




        ----- 7. Authentification avec Sanctum

Toutes les routes liées aux commandes doivent être protégées.

Un utilisateur non authentifié ne doit pas pouvoir :

consulter ses commandes ;
consulter une commande ;
créer une commande.

Testez notamment le comportement suivant :

Utilisateur non authentifié
        ↓
GET /api/orders
        ↓
401 Unauthorized

Puis :

Utilisateur authentifié
        ↓
GET /api/orders
        ↓
200 OK

Utilisez Postman pour effectuer ces tests.



        ----- 8. Autorisation des commandes

La simple authentification ne suffit pas.

Un utilisateur authentifié ne doit pas pouvoir accéder aux commandes des autres utilisateurs.

Par exemple :

Jean
 └── Commande #10


Paul
 └── Commande #20

Jean doit pouvoir consulter :

GET /api/orders/10

mais pas :

GET /api/orders/20

L'accès à une commande appartenant à un autre utilisateur devra être refusé.


        ----- 9. Gestion des commandes par l'administrateur

Les administrateurs doivent disposer de fonctionnalités supplémentaires.

Ajoutez une route permettant à un administrateur de consulter l'ensemble des commandes :

GET /api/admin/orders

Un utilisateur classique ne doit pas pouvoir accéder à cette route.

Modification du statut d'une commande

Ajoutez également une route permettant à un administrateur de modifier le statut d'une commande :

PATCH /api/admin/orders/{order}

Exemple :

{
    "status": "shipped"
}

Seuls les administrateurs doivent pouvoir effectuer cette opération.

Le statut devra être validé afin qu'une valeur quelconque ne puisse pas être enregistrée.




        ----- 10. Sécurisation des routes administrateur

Les routes administrateur devront être protégées par les mécanismes de sécurité étudiés aujourd'hui.

Vous devez obtenir un comportement similaire à celui-ci :

Utilisateur classique
        ↓
/api/admin/orders
        ↓
403 Forbidden

et :

Administrateur
        ↓
/api/admin/orders
        ↓
200 OK


       ----- Bonus

Ajoutez une limitation du nombre de requêtes sur la création de commandes.

Par exemple, empêcher un utilisateur d'effectuer un nombre excessif de créations de commandes sur une courte période.


*/
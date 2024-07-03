# ReadMe - SOUSLOCEAN la tête sous l'o

## Description du Projet

### Présentation
Pour ce projet, nous étions un trinôme, qui n’avait jamais travaillé ensemble auparavant. Notre groupe se compose __Emile DUPLAIS__, __Corentin DEGUISNE__ et __Lisa CRUSSON.__ Tous les trois étudiant.e en **CIR2 à ISEN Ouest.**

Dans le but cristallisé nos compétences, nous avons comme projet de concevoir et développer une application de gestion des profils de plongée sous-marine.

Cette application devrait permettre d’afficher un profil de plongée sous-marine et de déterminer des points spécifiques de la session de plongée.

Afin de mener à bien ce projet nous avons utilisé plusieurs technologie enseignées en cours comme le __HTML__, le __CSS__ et le __JavaScript__ pour le frontend, le __PHP__ pour le backend, __PostgreSQL__ pour la base de données ou encore __AJAX__ pour la relation client/serveur.

**SOUSLOCEAN** est un site créé pour aider les plongeurs à mieux visualiser leur future expédition sous-marine ainsi qu'à centralisé toute leur informations dans l'objectif de pouvoir rapidement et facilement y avoir accès et pour les modifier à leur envie. Dans ce site, il y a aussi une partie pour comprendre davantage le déroulement d'une plongée sous-marine avec des graphiques ou encore des tableaux détaillé.

Notre projet possède une bases de données, avec une table contenant la *[table MN90](http://ffessm-ctr-aura.fr/wp-content/uploads/2019/03/MN90.pdf)* et plusieurs autres afin d'enregistrer toutes les informations du site, pour créer cette base nous avons utilisé un __MCD__ *(Modèle Conceptuel des Données)* créé avec __JMerise.__
Il est disponible dans le dossier *"img".*

### Cahier des charges
Pour nous aider à nous orienter dans notre projet en autonomie, nous avions reçu un cahier des charges. Celui-ci contenait 5 fonctionnalités à implémenter dans notre code. Ces obligations étaient à chaque fois composées d'une partie front et une partie back afin de nous faire travailler le plus de compétence possible.

1. Accueil : présentation du projet et accès direct vers les autres pages du site web.
2. Visualisation de la tables de plongées, avec des paramètres par défauts, des valeurs données ( MN90 ).
3. Saisie et enregistrement des paramètres.
4. Affichage et modification des valeurs saisie par l'utilisateur.
5. Visualisation du graphique et/ou tableau, avec des paramètres par défaut ou ceux enregistrer par l'utilisateur.

## Pré-requis
Pour pouvoir utiliser notre site web, il vous faudra :
1. Un serveur web (Apache2)
2. Un serveur PHP (7.4/8.2)
3. Un serveur PostgreSQL (11)

Le fichier `setup.sh` vous permettra d'installer les paquets nécessaires pour le bon fonctionnement de notre site web.

Le fichier `backend/config/database.php` contient les informations de connexion à la base de données, il vous faudra le modifier pour qu'il corresponde à votre base de données.

Les schemas de la base de données sont disponibles dans le dossier `backend/sql`.

## Technologie utilisé

Pour ce projet nous avons dû utilisé :
1. Frontend
    1. HTML
    2. CSS
    3. JavaScript
    4. *Ajax*
2. Bibliothèque
    1. Bootstrap
    2. JQuery
3. API
    1. PHP
    2. PostgreSQL
    4. JSON
4. Déploiement
    1. Apache2
    2. PHP 7.4/8.2
    3. PostgreSQL 11

## Remerciment
Un grand merci à **Ayoub KARINE** et **Benoît LARDEUX** d'avoir supervisé le projet.    
[Linkedin Ayoub KARINE : ](https://www.linkedin.com/in/ayoub-karine-a01ba384/)https://www.linkedin.com/in/ayoub-karine-a01ba384/    
[Linkedin Benoît LARDEUX : ](https://www.linkedin.com/in/benoit-lardeux-02653a13/)https://www.linkedin.com/in/benoit-lardeux-02653a13/

## Présentation Complémentaire
Vidéo de présentation : https://youtu.be/OW6K_9HQPZo

## Developpeurs
[Linkedin Corentin DEGUISNE : ](https://www.linkedin.com/in/corentin-deguisne/)https://www.linkedin.com/in/corentin-deguisne/    
[Linkedin Emile DUPLAIS : ](https://www.linkedin.com/in/emile-duplais/)https://www.linkedin.com/in/emile-duplais/   
[Linkedin Lisa CRUSSON : ](https://www.linkedin.com/in/lisa-crusson-69158122b/)https://www.linkedin.com/in/lisa-crusson-69158122b/   

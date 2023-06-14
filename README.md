# Développement d'une application 

## Auteurs
DARET Tom  
CLAVERIE Mathis

## Installation/configuration
> Configuration de Composer avec la commande `composer install`  

## Serveur Web local
```shell
composer start:linux
```

```composer start:windows```

## Commande de tests
```shell 
composer test:cs
```
permet de vérifier la bonne écriture des scripts

```shell
composer fix:cs
```
permet de modifier les scripts pour obtenir la bonne écriture

```shell
composer test:crud
``` 
permet de lancer les tests Crud
```shell
composer test:browse
``` 
permet de lancer les tests Browse
```shell
composer test:codecept
```
permet de lancer les tests codeception
```shell
composer test:
``` 
permet de lancer tous les tests 

## Arborescence du projet
Le projet est divisé en plusieurs programmes :

- index.php qui renvoie une page html qui reference tous les films, et proposant une navigabilité vers ces derniers, mais aussi vers un formulaire d'edition
ou de creation de film dans la BD
- image.php qui reçoit un imageId en methode GET et qui renvoie en charge utile soit l'image demandé soit une image correspondant
 à une image introuvable
- movie.php qui reçoit un movieId en methode GET et qui renvoie une page HTML correspondant à cet Id en affichant les infos les infos du film & les acteurs qui y ont participé
- people.php qui reçoit un peopleId et qui renvoie une page HTML qui donne les infos liés à l'acteur et les films dans lesquels il à joué.
- filter.php qui permet de gerer le filtre sur la page d'accueil.

## Organisation des repertoires.

les classes sont situés dans le repertoire src/, les scripts, images et feuilles de styles sont dans public/. les tests sont dans test/ .
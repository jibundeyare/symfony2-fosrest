# api est avec Symfony 2.8

## description

exemple d'api rest avec symfony 2.8

## prérequis

- [mysql 5](https://www.mysql.com/)
- [php 5.6](http://php.net/)
- [composer](https://getcomposer.org/)

Modifiez le fichier `app/config/parameters.yml` pour configurer l'accès à la base de données.

## installation

### les dépendances

Pour installer les dépendances :

    composer install

### la base de données

Sous linux ou mac os, pour recréer une base de données de zéro :

    php app/console doctrine:database:drop --force
    php app/console doctrine:database:create
    php app/console doctrine:migrations:migrate --no-interaction
    php app/console hautelook_alice:doctrine:fixtures:load --no-interaction

**ATTENTION** : ces commandes détruisent la base de données avant de la récréer. Faites un backup préalable si nécessaire.

Sous windows, examinez le fichier `reset-db.sh` et adaptez les commandes à votre OS.

## utilisation

Pour afficher la liste des routes :

    php app/console debug:router

Avec un outil comme `httpie` vous pouvez tester l'api avec les commandes suivantes :

    http GET http://epsi-arras.jibundeyare.dev/app_dev.php/api/v3/tasks
    http POST http://epsi-arras.jibundeyare.dev/app_dev.php/api/v3/tasks description='foo bar baz'
    http POST http://epsi-arras.jibundeyare.dev/app_dev.php/api/v3/tasks description='foo bar baz' deadline='2016-12-31T12:00:00+0100' done:=true
    http GET http://epsi-arras.jibundeyare.dev/app_dev.php/api/v3/tasks/51
    http PUT http://epsi-arras.jibundeyare.dev/app_dev.php/api/v3/tasks/51 description='lorem ipsum' done:=true
    http DELETE http://epsi-arras.jibundeyare.dev/app_dev.php/api/v3/tasks/52

    http GET http://epsi-arras.jibundeyare.dev/app_dev.php/api/v3/levels
    http POST http://epsi-arras.jibundeyare.dev/app_dev.php/api/v3/levels description='lorem ipsum'
    http GET http://epsi-arras.jibundeyare.dev/app_dev.php/api/v3/levels/1
    http PUT http://epsi-arras.jibundeyare.dev/app_dev.php/api/v3/levels/4 description='foo bar baz'
    http DELETE http://epsi-arras.jibundeyare.dev/app_dev.php/api/v3/levels/4

    http LINK http://epsi-arras.jibundeyare.dev/app_dev.php/api/v3/tasks/51/levels/2
    http UNLINK http://epsi-arras.jibundeyare.dev/app_dev.php/api/v3/tasks/51/levels/2
    http PUT http://epsi-arras.jibundeyare.dev/app_dev.php/api/v3/tasks/51 description='lorem ipsum' level:=null



SnowTricks
====

Projet 6 - Parcours développeur d'application PHP/Symfony - OpenClassrooms
--------------------------------------------------------------------------

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/fdc7ef9998ba41f6b44dbacad4a6cc46)](https://www.codacy.com/app/coco2053/SnowTricks?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=coco2053/SnowTricks&amp;utm_campaign=Badge_Grade)
Bonjour, ceci est le projet  de site communautaire de snowboard qui m'a permit d'apprendre le framework Symfony 4.
Les documents preparatoires (diagrammes) se trouvent dans le repertoire "diagrams".

### Installation

1. Clonez ou telechargez le repository.
1. Modifiez le fichier .env avec vos parametres de BDD et d'email.
1. Ouvrez la console dans le repertoire racine.
1. composer install -> pour installer toutes les dependances.

1. Importez le fichier "snowtricks.sql" dans votre BDD
ou
1. php bin/console doctrine:database:create -> pour créer la BDD.
1. php bin/console doctrine:migrations:migrate -> pour commencer la migration.
1. php bin/console doctrine:fixtures:load -> pour charger les fixtures.
puis
1. php bin/console server:run -> pour lancer le serveur local.
1. Vous pouvez entrer l'adresse "localhost:800" dans votre navigateur et admirer le resultat.

### Theme Bootstrap

 [https://startbootstrap.com/template-overviews/4-col-portfolio/](https://startbootstrap.com/template-overviews/4-col-portfolio/ "theme bootstrap")

 À bientôt ...



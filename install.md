# Installation

## Prérequis

>Vous aurez besoin d'installer Php7.4, Composer et Symfony
[installation composer](https://www.php.net/manual/fr/install.php)
[installation composer](https://getcomposer.org/download/)
[installation symfony](https://symfony.com/doc/current/setup.html)  
## Utiliser notre projet

Vous allez devoir récuperer notre projet pour pouvoir le lancer localement, puis utiliser composer ainsi que npm afin de récupérer les différents outils nécessaires au projet.

```
git clone https://github.com/ITA-nsasso/Environnement_test_T17.git

composer install

npm i
npm run build
```

## Base de données

Nous allons installer la base de données pour avoir le détail et l'historique

L'ORM doctrine et le maker installés grâce aux dépendances composer, vous allez pouvoir créer votre base de données, mais avant il faudra la configurer.

Pour cela, aller dans votre fichier **.env** à la racine du projet. Vous allez choisir le type de SGBD correspondant à votre SGBD et remplacer les informations nécessaires par vos informations.  
*Il est possible que vous ayez déjà un parametre pré-décommenté, il faudra le commenter et décommenter celui que vous allez utiliser*

### Exemple
```
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
DATABASE_URL="mysql://root:@127.0.0.1:3306/db_secscan?serverVersion=5.7"
# DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=13&charset=utf8"
```
Là, mysql a dû être décommenté et la ligne concernant postgresql a été mise en commentaire.

Il faut maintenant remplacer :
>db_user = votre database user   
>db_password = votre database password ou ne mettez rien si vous n'avez pas de mot de passe   
>n'oubliez pas de changer votre port si nécessaire   
>db_name = le nom de votre base de donnée   
### Installer la base de données

Une fois votre base de données lancée sur votre machine, vous pouriez passer à l'étape suivante, c'est-à-dire alimenter votre base de données.

Les entités se trouvant déjà dans le projet, il vous suffit de les migrer vers votre bases de données :

```
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```
# Utilisation

Maintenant que tous les prérequis sont atteints, les dépendences installées et la base de données configurée, vous n'avez plus qu'à configurer le server Symfony !

Vérifiez que vous utilisz la bonne version de Php grâce à la commande :

```
symfony local:php:list
```
Si ce n'est pas le cas, définir au besoin la version Php que votre système utilise. Faites de même pour définir la version Php que le projet utilise en suivant les indications données grâce à la commande précédente.

Une fois que cela est défini, lancez la commande suivante :

```
symfony server:start
```

Le server est lancé, vous n'avez plus qu'à utiliser votre navigateur préféré pour accéder à l'application !
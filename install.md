# Installation

## Prérequis

>Vous aurez besoin d'installer symfony et composer  
[installation symfony](www.google.fr)  
[installation composer](www.google.fr)
## Utiliser notre projet

Vous allez devoir récuperer notre projet pour pouvoir le lancer localement, puis mettre à jour votre composer
pour récupérer les différents outils.

```
git clone https://github.com/ITA-nsasso/Environnement_test_T17.git
composer update
```

## Base de données

Nous allons installer la base de données pour avoir le détail et l'historique

### Prérequis

```
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
```
Maintenant que vous installer l'ORM doctrine et le maker, vous allez pouvoir créer votre base de donnée mais avant.  
Il faudra la configurer, pour cela aller dans votre fichier **.env** tout en bas, vous allez choisir le type de SGBD correspondant à votre SGBD et remplacer les informations nécessaires par vos informations.  
*Il est possible que vous ayez déjà un parametre pré-décommenter, il faudra le commenter et décommenter celui que vous allez utiliser*

### Exemple
```
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
DATABASE_URL="mysql://root:@127.0.0.1:3306/db_secscan?serverVersion=5.7"
# DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=13&charset=utf8"
```
J'ai décommenter mysql et mis en commentaire la ligne postgresql
il faut maintenant remplacer
>db_user = votre database user   
>db_password = votre database password ou ne mettez rien si vous n'avez pas de mot de passe   
>n'oubliez pas de changer votre port si nécessaire   
>db_name = le nom de votre base de donnée   
### Installer la base de données

```
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```
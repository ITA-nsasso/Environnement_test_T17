# Environnement_test_T17
Brouillon pour tester les outils php (ver. php7.4)

## Prérequis
Pour installer cet environnement de test, je conseille au préalable d'avoir une verison de Php7.4.x d'installé sur votre machine, et s'assurer que Symfony est bien configuré pour utiliser cette version là (voir la commande : symfony local:php:list)  
Symfony évidemment, personnlement j'ai utilisé la version 4.25.4 mais tant que c'est la même version majeur (4.x.y) je pense qu'il ne devrait pas avoir de soucis.  

## Remarques
Ce projet a été généré et conçu dans un environnement Linux (Debian 10 - Buster). Il est possible que celà vous engendre des problèmes si vous êtes sur un autre OS, mais rien d'irréparable. Dîtes-moi si vous avez des doutes.  

## Bonnes pratiques
Par soucis de bonne pratique, dans la mesure du possible effacez les dépôts git que vous testez quand vous avez fini de bosser, ça vous évite d'avoir xMo de données utilisées inutilement après ;)  

## Installation
### Récupération du dépôt
classique déjà, se placer dans le repertoire dans lequel on souhiate cloner puis :  
```git clone https://github.com/ITA-nsasso/Environnement_test_T17.git```

### Installation des dépendances
Symfony protège ses projets des problèmes d'incompatibilité en excluant certains éléments des pushs gits.  
Parmi eux, le dossier /vendors/ qui contient tous les outils installés par le biais de  ```composer```, mais aussi le dossier /node-modules/ qui lui contient notamment les outils de projet installé via ```npm```  
  
C'est pour cela que je vais lister ici les différents outils à installer, en attendent d'éventuellement faire un script pour les installer automatiquement ¯\\__ツ \__/¯ 

#### Installation des outils Composer
Faut croire que Composer est un minimum bien fait, le ```composer.json``` permets à l'environnement de savoir quels outils lui sont nécessaires, faut juste lancer la procédure de récupération :  
  
```composer update```  

#### Installation des outils npm
Même fonctionnement que pour composer, npm a un fichier ```packages.json``` qui permets à l'environnement de trouver et installer ses dépendances :  
  
```npm i```  
  
Le plus gros est fait, il ne faut plus que faire un ```npm run build``` pour recompiler le projet avec les outils npm qui n'étaient pas installés au préalable.  

## Lancement du serveur
Si vous êtes arrivés jusque là, vous avez fini en fait. Il ne manque plus qu'à faire un ```symfony server:start``` et en admettant que la version Php utilisée correspond bien à la version du projet Symfony (voir "Prérequis"), normalement vous êtes opérationnel !  
Notre page de test se trouve pour l'instant sur le chemin **/add** (localhost:8000/add)  
  
Je vous invite à tester des dépôts git aléatoirement sur github (tant que c'est un projet contenant du php, évidemment) pour observer les différents résultats obtenus.  
Je vous donne celui là pour commencer si vous voulez, mais testez en d'autres pour comparer les différents résultats : https://github.com/ITA-nsasso/D11_Dev-Web_IV  

## Aide
Si vous encontrez des soucis pour l'installation ou l'utilisation du projet n'hésitez pas à me contacter sur discord pour me solliciter, c'est possible que j'ai raté des cas spécifiques. 

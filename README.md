# Seek & Find - Recherchez les plantes !

Prenez en photo et collectionnez tout un panel de plante pour gagner en niveau !

## :warning: Requirements :warning:

 - PhP 8.1+
 - [Wamp](https://www.wampserver.com/) avec une base de donnée MySQL 4.9+
 - [Composer](https://getcomposer.org/)
 - [NPM]()

## Before We Get Started

Pour obtenir une copie de ce projet, ouvrez votre terminal et entrer :

```
git clone https://github.com/VentoAureo230/MSPR_Plante
```
Et maintenant vous pouvez utiliser le projet en local.

## Execution :runner:

Pour exécuter le projet ouvrez votre terminal dans le dossier du projet.

1. Changez les coordonnés du .env.test pour faire correspondre à vos identifiants MySQL, puis enlevez le .test de l'extension. Wamp doit être allumé.

2. Exécutez cette suite de commande :

```
composer install
```

```
npm install --force
```

```
php bin/console assets:install
```

```
php bin/console doctrine:database:create
```

3. Exécuter les migrations précédentes (optionnel) :

```
php bin/console doctrine:migrations:migrate
```

4. Démarrer le serveur Symfony :


```
npm run build
```

```
symfony server:start
```

Utilisez `symfony server:stop` pour arrêter le serveur

5. Le site est accessible sur l'url 127.0.0.1:8000

6. Enjoy !

## Authors

Anthony Mény, Antoine Garnier, Gaetan Boucard.

Etudiant en 2ème année à l'EPSI.

## TODO

- Refonte complète et plus approfondis de l'UI / UX

## Info

- Lien du ORA : https://app.ora.pm/p/9c14b640a74f4172ac41653f493b7670?v=0&t=k

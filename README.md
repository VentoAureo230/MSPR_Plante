# Seek & Find - Jeu web de recherche de plante !

Site web de recherche de plante en extérieur via un système de photo. Cherchez et collectionnez les plantes pour gagner en niveau et chercher des plantes toujours plus rare !

## Features 

- Création d'un compte
- Archivage des plantes trouvées
- Prise de photo

## Requirements & Getting Started

- Projet développé en PhP 8.1
- [Wamp](https://www.wampserver.com/) avec une base de donnée MySQL 4.9+

Composer et NPM sont obligatoire pour pouvoir gérer les dépendances dans Symfony en PhP. Ils s'occupent des installations et mises à jour. [Composer Install](https://getcomposer.org/). [Node.js Install](https://nodejs.org/en/download/)

Pour obtenir une copie de ce projet, ouvrez votre terminal et entrer :

```
git clone https://github.com/VentoAureo230/MSPR_Plante
```

Puis dans le dossier MSPR_PLANTE éxécuter les commandes suivantes :

```
composer require symfony/runtime
```

```
composer require webpack-encore
```

```
npm install --force
```

```
npm run build
```

Puis démarrer le serveur :

```
symfony server:start
```

Et le site sera disponible sur le port [8000](https://127.0.0.1:8000/home) (si aucun autre port n'est déjà )
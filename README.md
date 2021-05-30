# Dream-Team

Bienvenue sur CAR-A-OK, votre tout nouveau service personnel de gestion d'assurance automobile en ligne. Vous pouvez y gérer facilement les papiers de votre voiture, ainsi que déclarer un sinistre, une vente et bien plus encore !

## Utilisation

### Preparation des fichier

Avant de lancé le serveur il faut d'abord s'assurer qu'un certain nombre de fichier sont créé dans la base de donné. Nous avons intentionnellement choisi de ne pas créer ces fichier à l'exécution pour s'assurer qu'aucun fichier potentiellement dangereux puissent être créé par un utilisateur malveillant. Ainsi il faudra crée les fichier et dossier suivants si il n'existe pas déjà (Si le projet a était cloner depuis notre github par exemple).

- data/
  - uploads/
  - tickets/
  - messages/
  - assurances.json
  - contracts.json
  - conversations.json
  - tickets.json
  - sell.json
  - sinistres.json
  - users.json
- logs/

Sous linux nous avons créer un script bash pour pouvoir préparer et exécuté le serveur comme il faut :

```bash
./prepare.sh
```

```bash
./start.sh
```

### Lancement du serveur

Sous windows pour lancer le serveur il avoir php d'installé et executé la commande suivante

```bash
php -S localhost:8080 ./index.php
```

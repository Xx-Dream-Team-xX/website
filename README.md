# Dream-Team

Bienvenue sur CAR-A-OK, votre tout nouveau service personnel de gestion d'assurance automobile en ligne. Vous pouvez y gérer facilement les papiers de votre voiture, ainsi que déclarer un sinistre, une vente et bien plus encore !

## Utilisation

### Preparation des fichier

Avant de lancer le serveur il faut d'abord s'assurer qu'un certain nombre de fichiers sont créés dans la base de données. Ainsi il faudra créer les fichiers et dossiers suivants s'ils n'existent pas déjà (Si le projet a été cloné depuis notre github par exemple).

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
  - verifications.json
- logs/

Sous linux nous avons créée un script bash pour pouvoir préparer et exécuter le serveur comme il faut :

```bash
./prepare.sh
```

```bash
./start.sh
```

### Lancement du serveur

Sous windows pour lancer le serveur il faut avoir php d'installé et executer la commande suivante

```bash
php -S localhost:8080 ./index.php
```

# Birdy

## TODO
- [ ] bindparam (sécuriser les requêtes)
- [x] Poster tweet (vue + contrôleur + modèle)
- [ ] modifier statut
- [ ] connecter automatiquement l'utilisateur nouvellement inscrit? (contrôleur)
- [ ] index: affichage de tweets aléatoires
- [ ] voter pour un tweet
- [ ] affichage du message d'alerte (alert-box). 3 niveaux d'alertes : bon (vert), avertissement (jaune/orange), erreur (rouge)

## Structure

birdy
├── birdy
│   ├── controler
│   |   └── mainController.php
│   ├── layout
│   |   └── layout.php
│   ├── model
│   |   ├── basemodel.class.php
│   |   └── utilisateurTable.class.php
│   └── view
│   |   ├── actionSuccess.php
│   |   └── ...
├── css
├── images
├── js
├── lib
│   ├── core
│   │   ├── context.class.php
│   │   ├── dbconnetion.class.php
│   │   └── dbconnetion.infos.php
│   ├── core.php
│   └── register.php
├── sql
|   └── database.sql
└── birdy.php
└── birdyAjax.php

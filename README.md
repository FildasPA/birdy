# Birdy

## TODO
- bindparam
-

## Modifications
- dbconnection.infos.php: les informations pour se connecter à la base de données ont été mises dans un fichier à part => masque la modification du fichier de configuration à git.
- getUserByLoginAndPass: lorsque aucun utilisateur ne correspond dans la base, renvoyait un objet 'array' interprété comme vrai/correct.

## Questions
- comment choisir un nouveau layout?
- que mettre dans lib/ ? Que mettre dans lib/core/ ?
- comment passer d'autres variables dans la variable $context?
  └─ ne peut-on passer que $_REQUEST à travers executeAction?
- si la connexion échoue parce que l'utilisateur a rentré un login/mdp erroné, un message doit s'afficher. Peut-on créer un fichier loginError qui inclut loginSuccess? (cad: est-ce logique?)
- faut-il garder le mot de passe dans la session? (sécurité?)

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

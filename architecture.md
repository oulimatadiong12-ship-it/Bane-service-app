/baneservice-app 
│── index.php                  
│── .htaccess                  
│── README.md                  
# Page d’accueil (vue publique) 
# (optionnel) Réécriture d’URL 
# Documentation projet 
│── architecture.md             # Description MVC + BDD 
│ 
├── /db 
│   ├── connexion.php           # Connexion PDO 
│   ├── schema.sql              # Script création tables 
│   └── seed.sql                # Données initiales (admin, produits, etc.) 
│ 
├── /includes 
│   ├── header.php              # Header commun 
│   ├── footer.php              # Footer commun 
│   ├── navbar.php              # Menu de navigation 
│   └── auth.php                # Vérification session / rôle 
│ 
├── /models      # Chaque table ↔ 1 fichier modèle 
│   ├── Utilisateur.php         # CRUD utilisateurs 
│   ├── Abonnement.php          # Gestion abonnements 
│   ├── PaiementAbonnement.php  # Paiements abonnements 
│   ├── Produit.php             # CRUD produits 
│   ├── Commande.php            # Commandes 
│   ├── LigneCommande.php       # Lignes de commande 
│   ├── Service.php             # Services techniques 
│   ├── RendezVous.php          # Rendez-vous 
│   ├── Intervention.php        # Interventions 
│   ├── Transaction.php         # OM / Wave 
│   └── Promotion.php           # Promotions 
│ 
├── /controllers   # Logique métier 
│   ├── UserController.php 
│   ├── AbonnementController.php 
│   ├── ProduitController.php 
│   ├── CommandeController.php 
│   ├── ServiceController.php 
│   ├── RendezVousController.php 
│   ├── InterventionController.php 
│   ├── TransactionController.php 
│   └── PromotionController.php 
│ 
├── /views 
│   ├── /public 
│   │   ├── accueil.php 
│   │   ├── produits.php 
│   │   ├── services.php 
│   │   ├── promotions.php 
│   │   ├── contact.php 
│   │   ├── apropos.php 
│   │   └── login.php 
│   │ 
│   ├── /admin 
│   │   ├── dashboard.php 
│   │   ├── produits.php 
│   │   ├── abonnements.php 
│   │   ├── commandes.php 
│   │   ├── utilisateurs.php 
│   │   ├── finances.php         # Transactions OM/Wave 
│   │   └── promotions.php 
│   │ 
│   ├── /client 
│   │   ├── dashboard.php 
│   │   ├── commandes.php 
│   │   ├── profil.php 
│   │   ├── factures.php 
│   │   └── notifications.php 
│   │ 
│   ├── /abonne 
│   │   ├── dashboard.php 
│   │   ├── abonnement.php 
│   │   └── profil.php 
│   │ 
│   └── /technicien 
│       ├── dashboard.php 
│       ├── rendezvous.php 
│       └── profil.php 
│ 
├── /design 
│   └── /blueorigin             # Maquettes Figma / CSS personnalisées 
│ 
└── /uploads 
    ├── produits/               # Images produits 
    ├── promotions/             # Images promos 
    └── utilisateurs/           # Photos de profil
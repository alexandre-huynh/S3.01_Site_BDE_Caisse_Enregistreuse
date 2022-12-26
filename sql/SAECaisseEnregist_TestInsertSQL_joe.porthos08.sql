-- =========================
-- Test insertion de données
-- =========================
-- INSERTION UTILISATEUR CLIENT
-- il faudra ajouter un client dans authentification d'abord puis table client
-- s'il faut supprimer un client, supprimer dans table client puis table authentification
INSERT INTO Authentification values (12141618, 'mdpcrypt');
INSERT INTO Authentification values (56432212, 'unmdpcrypter');
INSERT INTO Client values (0,12141618, 'Bernard', 'Jean', '0123456789', 'jean.bernard@univ-paris13.fr', '2004-02-02', 15);
INSERT INTO Client values (1,56432212, 'Hugo', 'Pierre', '2356891346', 'pierre_hugo@univ-paris13.fr', '2003-01-20', 0);

-- INSERTION UTILISATEUR ADMIN
-- même chose que client
INSERT INTO Authentification values (11131517, 'cryptmdp');
INSERT INTO Authentification values (11223344, 'passcrypt');
INSERT INTO Admin values (0,11131517, 'Blanc', 'Laurent', '0987654321', 'laurent.blanc@univ-paris13.fr', '2000-05-20', 20);
INSERT INTO Admin values (1,11223344, 'Dupont', 'Christine', '0655443322', 'christine.dupont@univ-paris13.fr', '2002-10-4', 0);

-- INSERTION UTILISATEUR SUPER-ADMIN
INSERT INTO SuperAdmin values (0,1);

-- INSERTION PRODUIT
INSERT INTO Produit values (0, 'Kinder Bueno', 'Confiserie', 0.8, 'kinder_bueno.png', '2004-5-12', 40, 20);
INSERT INTO Produit values (1, 'Cristaline (50cl)', 'Boisson', 0.5, 'cristaline_(50cl).png', '2004-4-12', 3, 10);
INSERT INTO Produit values (2, 'Coca - Cola', 'Soda', 0.8 , 'coca_-_cola.png', '2004-3-12', 10, 5);
INSERT INTO Produit values (3, 'Lays Nature', 'Confiserie', 0.6 , 'lays_nature.png', '2004-6-20', 30, 25);
INSERT INTO Produit values (4, 'Lays Barbecue', 'Confiserie', 0.7 , 'lays_barbecue.png', '2004-6-20', 20, 17);


-- INSERTION VENTE
INSERT INTO Vente values (0, 1, 0, 2, 'Coca-cola', '2004-6-12', 'Espece');
INSERT INTO Vente values (1, 1, 0, 2, 'Coca-cola', '2004-6-12', 'Espece');
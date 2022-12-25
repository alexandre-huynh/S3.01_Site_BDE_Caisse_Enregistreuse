-- =====================
-- Test suppression de données
-- =====================

-- Pour supprimer un produit, il faut supprimer les ventes associés à celle-ci.

DELETE FROM Vente 
	where id_produit = 2;

DELETE FROM Produit
	where id_produit = 2;

-- Pour supprimer un client, il faut également supprimer les ventes associés à celle-ci.

DELETE FROM Client
	where id_client = 0;

-- Pour supprimer les données d'authentification d'un client, il faut supprimer le client associé auparavant.

DELETE FROM Authentification
	where num_etudiant = 12141618;

-- Affichage 
SELECT * FROM Client;
SELECT * FROM Admin;
SELECT * FROM Produit;
SELECT * FROM Authentification;
SELECT * FROM Vente;
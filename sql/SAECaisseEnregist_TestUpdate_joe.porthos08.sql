-- =====================
-- Test Mise à jour des donnés existantes
-- =====================
UPDATE Produit SET prix = 2 WHERE id_produit = 1;

UPDATE SuperAdmin SET id_admin = 0 WHERE id_superadmin = 0;

UPDATE Client SET prenom = 'Hugo', nom = 'Pierre' WHERE id_client = 1;

-- Affichage 
SELECT * FROM Client;
SELECT * FROM Admin;
SELECT * FROM Produit;
SELECT * FROM Authentification;
SELECT * FROM Vente;

-- =====================
-- Test affichage
-- =====================
SELECT * FROM Client;
SELECT * FROM Admin;
SELECT * FROM Produit;
SELECT * FROM Authentification;
SELECT * FROM Vente;

-- TESTS REQUETES

-- affichage des clients inscrits
SELECT Nom, Prenom
  FROM Client;

-- affichage du nombre de clients inscrits
SELECT count(*) as "Nombre de clients"
  FROM Client;

-- affichage des utilisateurs clients possédant des points fidélité
SELECT num_etudiant, Nom, Prenom, pts_fidelite
  FROM Client
  WHERE pts_fidelite>0;

-- le nombre d'achats effectués par un client
SELECT id_client, Nom, count(*) as "Produits achetés"
  FROM Client join Vente using(id_client)
  GROUP BY id_client;

-- exemple de données potentielles utilisés lors
-- de l'affichage de l'historique d'un utilisateur client
-- elle affichera notamment que le client a acheté à la date x 
-- tel produit de quantité = n et pour un total prix = k
SELECT distinct id_client, date_vente, nom_produit, count(*) as "Quantité" , sum(prix) as "Total prix"
  FROM Client join Vente using(id_client) join Produit using(id_produit)
  WHERE id_client=1
  GROUP BY id_client, date_vente, nom_produit;

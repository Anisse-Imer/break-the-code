SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE couleur (
  id int(11) primary key AUTO_INCREMENT,
  code_couleur varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE tuile (
  id int(11) primary key AUTO_INCREMENT,
  numero int(11) NOT NULL,
  id_couleur int(11) NOT NULL,
  CONSTRAINT FK_tuile_id_couleur FOREIGN KEY (id_couleur) REFERENCES couleur(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE utilisateur (
  id int(11) primary key AUTO_INCREMENT,
  nom varchar(255) DEFAULT NULL,
  prenom varchar(255) DEFAULT NULL,
  pseudo varchar(255) DEFAULT NULL,
  email varchar(255) NOT NULL,
  date_naissance date DEFAULT NULL,
  password varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE types_cartes(
  id int(11) primary key AUTO_INCREMENT,
  type_carte varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE cartes(
  id int(11) primary key AUTO_INCREMENT,
  id_type_carte int(11) NOT NULL,
  valeur varchar(255),
  position varchar(255),
  id_couleur int(11),
  parite int(11),
  question varchar(255) NOT NULL,
  CONSTRAINT FK_cartes_id_type_carte FOREIGN KEY (id_type_carte) REFERENCES types_cartes(id),
  CONSTRAINT FK_cartes_id_couleur FOREIGN KEY (id_couleur) REFERENCES couleur(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE partie (
  id int(11) primary key AUTO_INCREMENT,
  id_utilisateur int(11) NOT NULL,
  premier_joueur int(11) NOT NULL,
  date_debut datetime NOT NULL,
  date_fin datetime,
  resultat tinyint(1) NOT NULL,
  tuile_joueur varchar(255) NOT NULL,
  tuile_ia varchar(255) NOT NULL,
  cartes varchar(255) NOT NULL,
  CONSTRAINT FK_partie_id_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE partie_action (
  id int(11) primary key AUTO_INCREMENT,
  id_partie int(11) NOT NULL,
  id_utilisateur int(11) NOT NULL,
  id_carte int(11) NOT NULL,
  proposition varchar(255),
  reponse varchar(255) NOT NULL,
  CONSTRAINT FK_partie_action_id_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id),
  CONSTRAINT FK_partie_action_id_partie FOREIGN KEY (id_partie) REFERENCES partie(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `couleur` (`code_couleur`) VALUES ('#0FD60B'), ('#FFFFFF'), ('#212121');

INSERT INTO `tuile` (`id`, `numero`, `id_couleur`) VALUES (NULL, '0', '2'), (NULL, '1', '2'), (NULL, '2', '2'), (NULL, '3', '2'), (NULL, '4', '2'), (NULL, '5', '1'), (NULL, '6', '2'), (NULL, '7', '2'), (NULL, '8', '2'), (NULL, '9', '2'), (NULL, '0', '3'), (NULL, '1', '3'), (NULL, '2', '3'), (NULL, '3', '3'), (NULL, '4', '3'), (NULL, '5', '1'), (NULL, '6', '3'), (NULL, '7', '3'), (NULL, '8', '3'), (NULL, '9', '3');

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `pseudo`, `email`, `date_naissance`, `password`) VALUES ('0', 'ordinateur', 'ordinateur', 'ordinateur', 'ordinateur@gmail.com', '2023-09-23', '4aa94d8feb8c12326af45850a0cfcc1333bcad017d14ddba633dcf601307eb8a');
INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `pseudo`, `email`, `date_naissance`, `password`) VALUES ('1', 'Imerzoukene', 'Anisse', 'Anisse6z', 'anissezou@gmail.com ', '2003-04-28', '');

INSERT INTO `types_cartes` (`id`, `type_carte`) VALUES (NULL, 'somme'), (NULL, 'position'), (NULL, 'nombre'), (NULL, 'voisine'), (NULL, 'suive'), (NULL, 'superieur'), (NULL, 'egaux'), (NULL, 'difference');
INSERT INTO `types_cartes` (`id`, `type_carte`) VALUES (NULL, 'position_ou_valeur');

INSERT INTO `cartes` (`id`, `id_type_carte`, `valeur`, `position`, `id_couleur`, `parite`, `question`) VALUES (NULL, '1', NULL, '0;1;2;3;4', NULL, NULL, 'Quelle est la somme des chiffres a,b,c,d,e ?');
INSERT INTO `cartes` (`id`, `id_type_carte`, `valeur`, `position`, `id_couleur`, `parite`, `question`) VALUES (NULL, '1', NULL, '1;2;3', NULL, NULL, 'Quelle est la somme des chiffres b,c,d ?');
INSERT INTO `cartes` (`id`, `id_type_carte`, `valeur`, `position`, `id_couleur`, `parite`, `question`) VALUES (NULL, '1', NULL, '0;1;2', NULL, NULL, 'Quelle est la somme des chiffres a,b,c ?');
INSERT INTO `cartes` (`id`, `id_type_carte`, `valeur`, `position`, `id_couleur`, `parite`, `question`) VALUES (NULL, '1', NULL, '2;3;4', NULL, NULL, 'Quelle est la somme des chiffres c,d,e ?');
INSERT INTO `cartes` (`id`, `id_type_carte`, `valeur`, `position`, `id_couleur`, `parite`, `question`) VALUES (NULL, '1', NULL, NULL, '2', NULL, 'Quelle est la somme de tes chiffres blancs ?');
INSERT INTO `cartes` (`id`, `id_type_carte`, `valeur`, `position`, `id_couleur`, `parite`, `question`) VALUES (NULL, '1', NULL, NULL, '3', NULL, 'Quelle est la somme de tes chiffres noirs ?');

INSERT INTO `cartes` (`id`, `id_type_carte`, `valeur`, `position`, `id_couleur`, `parite`, `question`) VALUES (NULL, '2', '0', NULL, NULL, NULL, 'Où sont tes tuiles 0 ?');
INSERT INTO `cartes` (`id`, `id_type_carte`, `valeur`, `position`, `id_couleur`, `parite`, `question`) VALUES (NULL, '2', '5', NULL, NULL, NULL, 'Où sont tes tuiles 5 ?');

INSERT INTO `cartes` (`id`, `id_type_carte`, `valeur`, `position`, `id_couleur`, `parite`, `question`) VALUES (NULL, '9', '1;2', NULL, NULL, NULL, 'Où sont tes tuiles 1 ou tes tuiles 2 ?'), (NULL, '9', '3;4', NULL, NULL, NULL, 'Où sont tes tuiles 3 ou tes tuiles 4 ?'), (NULL, '9', '8;9', NULL, NULL, NULL, 'Où sont tes tuiles 8 ou tes tuiles 9 ?'), (NULL, '9', '6;7', NULL, NULL, NULL, 'Où sont tes tuiles 6 ou tes tuiles 7 ?');

INSERT INTO `cartes` (`id`, `id_type_carte`, `valeur`, `position`, `id_couleur`, `parite`, `question`) VALUES (NULL, '3', NULL, NULL, '2', NULL, 'Combien de tuiles avec un chiffre blanc as-tu ?'), (NULL, '3', NULL, NULL, '3', NULL, 'Combien de tuiles avec un chiffre noir as-tu ?'), (NULL, '3', NULL, NULL, NULL, '0', 'Combien de tuiles avec un chiffre pair as-tu ?'), (NULL, '3', NULL, NULL, NULL, '1', 'Combien de tuiles avec un chiffre impair as-tu ?');

INSERT INTO `cartes` (`id`, `id_type_carte`, `valeur`, `position`, `id_couleur`, `parite`, `question`) VALUES (NULL, '4', NULL, NULL, NULL, NULL, 'Où sont tes tuiles voisines avec des chiffres de même couleur ?'), (NULL, '5', NULL, NULL, NULL, NULL, 'Où sont tes tuiles dont les chiffres se suivent ?'), (NULL, '6', '4', '2', NULL, NULL, 'Est-ce que le chiffre de la taille C est strictement supérieur à 4 ?'), (NULL, '7', NULL, NULL, NULL, NULL, 'Combien de tailles avec des chiffres égaux as-tu ?'), (NULL, '8', NULL, NULL, NULL, NULL, 'Quelle est la différence entre ton plus grand chiffre et ton plus petit chiffre ?');
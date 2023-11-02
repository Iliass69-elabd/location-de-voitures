-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 22 juin 2023 à 13:04
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `wlc`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AA_matricule_charges` ()   BEGIN
SELECT matricul FROM voiture;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addReservation` (IN `debut` DATE, IN `fin` DATE, IN `matricule` VARCHAR(200), IN `idClient` INT, IN `nom` VARCHAR(200), IN `prenom` VARCHAR(200), IN `modeP` VARCHAR(200), IN `Dconduct` VARCHAR(200), IN `prixUnitaire` INT)   BEGIN
DECLARE done,ctrl1,ctrl2 INT DEFAULT FALSE;
DECLARE debut_res_new DATE;
DECLARE fin_res_new DATE;
DECLARE matricule_voiture_reserver_new VARCHAR(50);
DECLARE id_client_res_fk_new INT;
DECLARE nom_client_new VARCHAR(50);
DECLARE prenom_client_new VARCHAR(50);
DECLARE duree_new INT;
DECLARE price_new float;
DECLARE mode_paiment_new VARCHAR(30);
DECLARE Dconducteur_new VARCHAR(200);
DECLARE prix_unitaire_new float;

DECLARE cursor_name CURSOR FOR
SELECT debut_res, fin_res, matricule_voiture_reserver, id_client_res_fk, nom_client, prenom_client, duree, price, mode_paiment, Dconducteur, prix_unitaire
FROM reserver;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

OPEN cursor_name;

read_loop: LOOP
    FETCH cursor_name INTO debut_res_new, fin_res_new, matricule_voiture_reserver_new, id_client_res_fk_new, nom_client_new, prenom_client_new, duree_new, price_new, mode_paiment_new, Dconducteur_new, prix_unitaire_new;

    IF done THEN
        LEAVE read_loop;
    END IF;
        IF debut_res_new NOT BETWEEN debut AND fin
        AND fin_res_new NOT BETWEEN debut AND fin
        AND matricule_voiture_reserver_new != matricule
		THEN
        INSERT INTO reserver VALUES (null,debut,fin,matricule,idClient,nom,prenom,DATEDIFF(fin,debut),(DATEDIFF(fin,debut) * prixUnitaire ),modeP,Dconduct,prixUnitaire,0);
        UPDATE voiture 
        SET voiture.status_voi ="indisponible"
        WHERE voiture.matricul = matricule;
        END IF;
END LOOP;
CLOSE cursor_name;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_charge` (IN `matricule` VARCHAR(200), IN `dateAchat` DATE, IN `avance` FLOAT, IN `reste` FLOAT, IN `prixParMois` FLOAT, IN `etat` VARCHAR(200), IN `traite` FLOAT, IN `PrixAssurance` FLOAT, IN `DateFinEchehance` DATE)   BEGIN
DECLARE MontantGlobal int(200) DEFAULT 0;
SET MontantGlobal = avance + reste ;
INSERT INTO charge (matricule_ch,dateAchat_ch,avance_ch,reste_ch,montant_global,prix_par_mois,etat,traite,prixAssurance,dateFinEchehance)
VALUES 
(matricule,dateAchat,avance,reste,MontantGlobal,prixParMois,etat,traite,PrixAssurance,DateFinEchehance);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ajouterAlerting` (IN `carteGriz` DATE, IN `Vidange` DATE, IN `VisiteTechnique` DATE, IN `Assurance` DATE, IN `Retour` DATE, IN `matricule` VARCHAR(200))   BEGIN
INSERT INTO alerte VALUES(carteGriz,Vidange,VisiteTechnique,Assurance,Retour,matricule);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `alerting` (IN `matricule` VARCHAR(200), IN `carteGrize` DATE, IN `Vidange` DATE, IN `VisiteTechnique` DATE, IN `Assurance` DATE, IN `Retour` DATE)   BEGIN
UPDATE  alerte
SET alerte.date_carte_grise = carteGrize,
alerte.date_vidange = Vidange,
alerte.date_visite_technique = VisiteTechnique,
alerte.date_assurance = Assurance,
alerte.date_retour = Retour 
WHERE alerte.matricule_voiture = matricule;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `chercher_client` (IN `c` VARCHAR(255))   BEGIN

SELECT * from client WHERE client.nom_client LIKE concat('%',c,'%') or client.prenom_client LIKE concat('%',c,'%') or client.identity_card LIKE concat('%',c,'%') or concat(nom_client," ",prenom_client)LIKE concat('%',c,'%') ;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `chercher_employe` (IN `emp` VARCHAR(255))   BEGIN

SELECT * from employee WHERE employee.family_name_emp LIKE concat('%',emp,'%') or employee.first_name_emp LIKE concat('%',emp,'%') or employee.cin_emp LIKE concat('%',emp,'%') or concat(employee.family_name_emp," ",employee.first_name_emp)LIKE concat('%',emp,'%') ;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `chercher_voiture` (IN `v` VARCHAR(255))   BEGIN

SELECT * from voiture WHERE matricul LIKE concat('%',v,'%') or mark_voi LIKE concat('%',v,'%') or price LIKE concat('%',v,'%');

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `clientReservations` (IN `idClient` INT)   BEGIN
SELECT MONTHNAME(debut_res) AS Month, COUNT(id_reserve) AS Number  FROM reserver r
JOIN client c
WHERE r.id_client_res_fk = c.id_client
AND c.id_client = idClient
GROUP BY MONTH(debut_res) ,month
ORDER BY MONTH(debut_res);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `confirmer_reservation` (IN `idRes` INT)   BEGIN
UPDATE reserver 
SET reserver.confirmer = 1 WHERE reserver.id_reserve = idRes;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `confirm_seen_voiture` (IN `matr` INT)   UPDATE voiture
SET voiture.confirm = "1" 
WHERE voiture.matricul = matr$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countClientNotReserved` (IN `avant` VARCHAR(200), IN `apres` VARCHAR(200))   BEGIN
if(avant = "" and apres = "")THEN
SELECT COUNT(DISTINCT client.id_client) as ClientNonReserver FROM client
WHERE client.id_client NOT IN (SELECT reserver.id_client_res_fk FROM reserver where reserver.debut_res = CURRENT_DATE);
else  
SELECT COUNT(DISTINCT client.id_client) as ClientNonReserver FROM client
JOIN reserver
WHERE reserver.id_client_res_fk = client.id_client
AND reserver.debut_res NOT BETWEEN avant AND apres;
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countClientReserved` (IN `avant` VARCHAR(200), IN `apres` VARCHAR(200))   BEGIN
if(avant = "" and apres = "")THEN
SELECT COUNT(DISTINCT client.id_client) as ClientReserver FROM client JOIN reserver WHERE client.id_client = reserver.id_client_res_fk and reserver.debut_res = CURRENT_DATE;
else 
SELECT COUNT(DISTINCT client.id_client) as ClientReserver FROM client JOIN reserver WHERE client.id_client = reserver.id_client_res_fk AND reserver.debut_res BETWEEN avant and apres;
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countEmploye` ()   BEGIN
SELECT COUNT(*) as TotalEmployer FROM employee;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countPriceRep` (IN `avant` VARCHAR(200), IN `apres` VARCHAR(200))   BEGIN
DECLARE TotalReparation int(20) DEFAULT 0;
IF ((SELECT COUNT(*) FROM reparation) = 0 )THEN 
    set TotalReparation = ( SELECT COUNT(reparation.cout_reparation)  FROM reparation);
ELSE
    IF((SELECT COUNT(*) FROM reparation WHERE reparation.date_reparation BETWEEN avant AND apres ) = 0 )THEN
    SET TotalReparation = 0;
    	IF (avant="" AND apres = "") THEN
        	SET TotalReparation =(SELECT SUM(reparation.cout_reparation) FROM reparation);
        END IF;
    ELSE
     SET TotalReparation = (SELECT SUM(reparation.cout_reparation) FROM reparation WHERE reparation.date_reparation BETWEEN avant AND apres);
    END IF;
END IF;
SELECT TotalReparation;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countReservation` (IN `avant` VARCHAR(200), IN `apres` VARCHAR(200))   BEGIN
if(avant = "" and apres = "")THEN
SELECT COUNT(*) as TotalReserver FROM reserver;
else 
SELECT COUNT(*) as TotalReserver FROM reserver WHERE reserver.debut_res BETWEEN avant and apres;
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countTotalClient` ()   BEGIN
SELECT COUNT(*) as Clients FROM client;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countTotalGain` (IN `avant` VARCHAR(200), IN `apres` VARCHAR(200))   BEGIN
DECLARE Total int(20) DEFAULT 0;
IF ((SELECT COUNT(*) FROM reserver) = 0 )THEN 
    set Total = ( SELECT COUNT(price)  FROM reserver);
ELSE
    IF((SELECT COUNT(*) FROM reserver WHERE reserver.debut_res BETWEEN avant AND apres ) = 0 )THEN
    SET Total = 0;
   		IF (avant="" AND apres = "") THEN
        	SET Total =(SELECT SUM(price) FROM reserver);
        END IF;
    ELSE
     SET Total = (SELECT SUM(price) FROM reserver WHERE reserver.debut_res BETWEEN avant AND apres);
    END IF;
END IF;
SELECT Total;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countTotalVoiture` ()   BEGIN
SELECT COUNT(*) as Voitures FROM voiture ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countVoitureNotReserved` (IN `avant` VARCHAR(200), IN `apres` VARCHAR(200))   BEGIN
if(avant = "" and apres = "")THEN
SELECT COUNT(DISTINCT voiture.matricul) as VoitureNonReserver FROM voiture
WHERE voiture.matricul NOT IN (SELECT matricule_voiture_reserver FROM reserver where reserver.debut_res = CURRENT_DATE);
else 
SELECT COUNT(DISTINCT voiture.matricul) as VoitureNonReserver FROM voiture 
JOIN reserver
WHERE reserver.matricule_voiture_reserver = voiture.matricul
AND reserver.debut_res NOT BETWEEN avant AND apres;
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countVoiturePlusReserver` ()   BEGIN
SELECT v.mark_voi as Voiture ,COUNT(matricule_voiture_reserver) as Reserved FROM reserver r
JOIN voiture v
WHERE r.matricule_voiture_reserver = v.matricul
GROUP BY r.matricule_voiture_reserver;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countVoitureReserved` (IN `avant` VARCHAR(200), IN `apres` VARCHAR(200))   BEGIN
if(avant = "" and apres = "")THEN
SELECT COUNT( DISTINCT voiture.matricul) as VoitureReserver FROM voiture
JOIN reserver 
WHERE voiture.matricul = reserver.matricule_voiture_reserver  and reserver.debut_res = CURRENT_DATE;
else 
SELECT COUNT( DISTINCT voiture.matricul) as VoitureReserver FROM voiture
JOIN reserver 
WHERE voiture.matricul = reserver.matricule_voiture_reserver And reserver.debut_res BETWEEN avant and apres;
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteReservation` (IN `idRes` INT)   BEGIN
DELETE FROM reserver 
WHERE id_reserve = idRes;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_charge` (IN `id` INT)   BEGIN
DELETE FROM charge WHERE id_ch = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_seen_notif` (IN `id` INT)   BEGIN
DELETE FROM notif WHERE notif.id_notif = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `dispo_voi` ()   BEGIN
DECLARE tt int;
SET tt = (select COUNT(*) FROM reserver);
IF (tt != 0) THEN
SELECT r.duree,v.matricul FROM voiture v 
JOIN reserver r 
WHERE r.matricule_voiture_reserver = v.matricul AND r.debut_res = CURRENT_DATE()  ;
ELSEIF(tt = 0) THEN
SELECT * FROM voiture;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `notif_alert` ()   BEGIN

DECLARE done INT DEFAULT FALSE;
DECLARE currentDate DATE;
DECLARE cursorDate1 DATE;
DECLARE cursorDate2 DATE;
DECLARE cursorDate3 DATE;
DECLARE cursorDate4 DATE;
DECLARE cursorDate5 varchar(100);
DECLARE cursorDate6 varchar(200);

DECLARE cursor1 CURSOR FOR
  SELECT a.date_vidange,a.date_visite_technique,a.date_assurance ,a.date_retour ,v.mark_voi,v.matricul FROM alerte a JOIN voiture v
  WHERE a.matricule_voiture = v.matricul;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
SET currentDate = CURDATE();

OPEN cursor1;
read_loop: LOOP

  FETCH cursor1 INTO cursorDate1, cursorDate2, cursorDate3, cursorDate4,cursorDate5,cursorDate6;
  IF done THEN
    LEAVE read_loop;
  END IF;
  IF DATEDIFF(cursorDate1,currentDate ) <= 7 AND DATEDIFF(cursorDate1,currentDate ) >= 0 THEN
    INSERT INTO notif(phrase_notif,matricul,type_notif) VALUES (CONCAT('La voiture ',cursorDate5,' doit avoir un nouveau vidange dans ',DATEDIFF(cursorDate1,currentDate ),' jour(s) !'),cursorDate6,"vidange");
    ELSEIF DATEDIFF(cursorDate1,currentDate ) <= 0 THEN
    INSERT INTO notif(phrase_notif,matricul,type_notif) VALUES (CONCAT('La voiture ',cursorDate5,' doit avoir un nouveau vidange  Aujoudhui !'),cursorDate6,"vidange");
    END IF;
  IF DATEDIFF(cursorDate2,currentDate) <= 7 AND DATEDIFF(cursorDate2,currentDate ) >= 0 THEN
       INSERT INTO notif(phrase_notif,matricul,type_notif) VALUES (CONCAT('La voiture ',cursorDate5,' doit avoir une visite technique  ',DATEDIFF(cursorDate2,currentDate ),' jour(s) !'),cursorDate6,"visite");
       ELSEIF DATEDIFF(cursorDate2,currentDate ) <= 0 THEN
    INSERT INTO notif(phrase_notif,matricul,type_notif) VALUES (CONCAT('La voiture ',cursorDate5,' doit avoir une visite technique   Aujoudhui !'),cursorDate6,"visite");
       END IF;
  IF DATEDIFF(cursorDate3,currentDate) <= 7 AND DATEDIFF(cursorDate3,currentDate ) >= 0 THEN
       INSERT INTO notif(phrase_notif,matricul,type_notif) VALUES (CONCAT('La voiture ',cursorDate5,' doit avoir une assurance dans ',DATEDIFF(cursorDate3,currentDate ),' jour(s) !'),cursorDate6,"assurance");
       ELSEIF DATEDIFF(cursorDate3,currentDate ) <= 0 THEN
    INSERT INTO notif(phrase_notif,matricul,type_notif) VALUES (CONCAT('La voiture ',cursorDate5,' doit avoir une nouvelle assurance  Aujoudhui !'),cursorDate6,"assurance");
       END IF;
  IF DATEDIFF(cursorDate4,currentDate) <= 7 AND DATEDIFF(cursorDate4,currentDate ) >= 0 THEN
       INSERT INTO notif(phrase_notif,matricul,type_notif) VALUES (CONCAT('La voiture ',cursorDate5,' doit revenir au local dans ',DATEDIFF(cursorDate4,currentDate ),' jour(s) !'),cursorDate6,"retour");
       ELSEIF DATEDIFF(cursorDate4,currentDate ) <= 0 THEN
    INSERT INTO notif(phrase_notif,matricul,type_notif) VALUES (CONCAT('La voiture ',cursorDate5,' doit revenir au local  Aujoudhui !'),cursorDate6,"retour");
  END IF;
END LOOP;

CLOSE cursor1;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `numReservation` ()   BEGIN
SELECT COUNT(*) as num FROM notif WHERE notif.cfr != 0 and notif.reading = "unseen";
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reservationPerDay` ()   BEGIN
SELECT COUNT(*) as Today FROM reserver
WHERE DAY(debut_res) = DAY(CURDATE());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reservationPerMonth` ()   BEGIN
SELECT COUNT(*) as ThisMonth FROM reserver 
WHERE MONTH(debut_res) = MONTH(CURDATE());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reservationPerYear` ()   BEGIN
SELECT COUNT(*) as ThisYear FROM reserver
WHERE YEAR(debut_res) = YEAR(CURDATE());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `seen_notif` (IN `idNotif` INT)   BEGIN
DECLARE cfrValue INT;

DECLARE done INT DEFAULT FALSE;
DECLARE cur CURSOR FOR 
SELECT cfr FROM notif WHERE id_notif = idNotif;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

OPEN cur;
FETCH cur INTO cfrValue;

IF cfrValue != 0 THEN
    UPDATE notif
    JOIN reserver ON notif.cfr = reserver.id_reserve
    SET notif.reading = 'seen'
    WHERE (notif.id_notif = idNotif OR notif.cfr = idNotif)
    AND notif.cfr = reserver.id_reserve
    AND reserver.confirmer = '1';
ELSEIF (cfrValue = 0) THEN
    UPDATE notif 
    JOIN voiture ON notif.matricul = voiture.matricul
    SET reading = 'seen'
    WHERE notif.id_notif = idNotif 
    AND notif.matricul = voiture.matricul
    AND voiture.confirm = "1";
END IF;

 CLOSE cur;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `showAlert` (IN `mat` VARCHAR(200))   BEGIN
SELECT a.* FROM alerte a
JOIN voiture v
WHERE v.matricul = a.matricule_voiture 
AND a.matricule_voiture = mat;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `showing_car_fin_reserver` ()   BEGIN
DECLARE currentDate date DEFAULT CURDATE();
DECLARE done INT DEFAULT FALSE;
DECLARE reservationId INT;
DECLARE expirationDate DATE;

DECLARE cursorName CURSOR FOR
SELECT id_reserve, fin_res
FROM reserver
WHERE fin_res = currentDate;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

OPEN cursorName;

read_loop: LOOP
    FETCH cursorName INTO reservationId, expirationDate;
    
    IF done THEN
        LEAVE read_loop;
    END IF;
    
    UPDATE voiture
    SET status_voi = 'disponible'
    WHERE matricul = (SELECT matricule_voiture_reserver FROM reserver WHERE reserver.id_reserve = reservationId);
    
END LOOP;

CLOSE cursorName;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `showReservation` ()   BEGIN
SELECT reserver.* , client.telephone FROM reserver 
JOIN client 
WHERE client.id_client = reserver.id_client_res_fk
ORDER BY reserver.id_reserve DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `show_charges` ()   BEGIN
SELECT * from charge;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `show_notif_indicator` ()   BEGIN
SELECT COUNT(id_notif) AS Numero FROM notif
WHERE reading = "unseen";
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `show_notif_message` ()   BEGIN
SELECT id_notif as ID,phrase_notif as MSG ,cfr,matricul,client FROM notif
WHERE reading = "unseen"
GROUP BY ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `statisticReservation` ()   BEGIN

SELECT MONTHNAME(debut_res) as month, COUNT(*) as amount FROM reserver
GROUP BY MONTH(debut_res) ,month
ORDER BY MONTH(debut_res) ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `testing_disponibility` ()   BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE matricule VARCHAR(255);
    DECLARE cur CURSOR FOR
        SELECT matricule_voiture_reserver
        FROM reserver
        WHERE fin_res = CURDATE();
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO matricule;
        IF done THEN
            LEAVE read_loop;
        END IF;

        UPDATE voiture
        SET status_voi = 'disponible'
        WHERE matricul = matricule;
    END LOOP;

    CLOSE cur;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateReserver` (IN `idRes` INT, IN `debutRes` DATE, IN `finRes` DATE, IN `matriculeRes` VARCHAR(200), IN `idClientRes` INT, IN `nomRes` VARCHAR(200), IN `prenomRes` VARCHAR(200), IN `duree` INT, IN `priceRes` FLOAT, IN `modePayRes` VARCHAR(200), IN `DconductRes` VARCHAR(200), IN `prixUni` INT, IN `confirmer` INT)   BEGIN
UPDATE reserver SET debut_res=debutRes,
fin_res=finRes,
matricule_voiture_reserver=matriculeRes,
id_client_res_fk=idClientRes,
nom_client=nomRes,
prenom_client=prenomRes,
duree=duree,
price=priceRes,
mode_paiment=modePayRes,
Dconducteur=DconductRes,
prix_unitaire=prixUni,
confirmer = confirmer
WHERE id_reserve=idRes;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_charges` (IN `idCh` INT, IN `matriculeCh` VARCHAR(200), IN `dateAchatCh` DATE, IN `avanceCh` FLOAT, IN `resteCh` FLOAT, IN `PrixParMoisCh` FLOAT, IN `etatCh` VARCHAR(200), IN `traiteCh` FLOAT, IN `PrixAssuranceCh` FLOAT, IN `dateFinEchehance` DATE)   BEGIN
UPDATE charge
SET charge.matricule_ch = matriculeCh,
charge.dateAchat_ch = dateAchatCh,
charge.avance_ch = avanceCh,
charge.reste_ch = resteCh,
charge.montant_global = avanceCh+resteCh,
charge.prix_par_mois = PrixParMoisCh,
charge.etat = etatCh,
charge.traite = traiteCh,
charge.prixAssurance = PrixAssuranceCh,
charge.dateFinEchehance = dateFinEchehance WHERE charge.id_ch = idCh;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `zzlafin` ()   BEGIN
DECLARE done INT DEFAULT FALSE;
DECLARE matv date;
DECLARE cur CURSOR FOR
	SELECT voiture.matricul FROM voiture
    JOIN reserver
    WHERE voiture.matricul = reserver.matricule_voiture_reserver
    AND reserver.fin_res = CURRENT_DATE();
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
OPEN cur;
    FETCH cur INTO matv;
    WHILE NOT done DO
    UPDATE voiture
    SET voiture.status_voi = "disponible"
    WHERE voiture.matricul = matv;
    FETCH cur INTO matv;
    END WHILE;
CLOSE cur;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `accessoire`
--

CREATE TABLE `accessoire` (
  `id_Acc` int(11) NOT NULL,
  `type_acc` varchar(60) DEFAULT NULL,
  `matricule_voiture` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `accessoire`
--

INSERT INTO `accessoire` (`id_Acc`, `type_acc`, `matricule_voiture`) VALUES
(1, 'Frein de stationnement électronique', 'DET23456'),
(2, 'Aide au stationnement automatique', 'DET23456'),
(3, 'Assistant de vision nocturne', 'DET23456'),
(4, 'Climatisation automatique', 'DET23456'),
(5, 'Ecran tactile', 'DET23456'),
(6, 'Vitres électriques anti-pincement', 'DET23456'),
(7, 'Support lombaire réglable', 'DET23456'),
(8, 'Avertissement de vérification du moteur', 'DET23456'),
(9, 'Compresseur', 'DET23456'),
(10, 'Coussins gonflables à deux phases', 'DET23456'),
(11, 'Mode de conduite', 'DET23456'),
(12, 'Régulateur de vitesse adaptatif', 'DET23456'),
(13, 'Frein de stationnement électronique', 'RQT66977'),
(14, 'Caméra à 360°', 'RQT66977'),
(15, 'Aide au stationnement automatique', 'RQT66977'),
(16, 'Assistant de vision nocturne', 'RQT66977'),
(17, 'Climatisation automatique', 'RQT66977'),
(18, 'Ecran tactile', 'RQT66977'),
(19, 'Vitres électriques anti-pincement', 'RQT66977'),
(20, 'Support lombaire réglable', 'RQT66977'),
(21, 'Avertissement de vérification du moteur', 'RQT66977'),
(22, 'Compresseur', 'RQT66977'),
(23, 'Coussins gonflables à deux phases', 'RQT66977'),
(24, 'Commande/contrôle vocal', 'RQT66977'),
(25, 'Mode de conduite', 'RQT66977'),
(26, 'Régulateur de vitesse adaptatif', 'RQT66977'),
(36, 'Frein de stationnement électronique', 'ZER12347'),
(37, 'Aide au stationnement automatique', 'ZER12347'),
(38, 'Ecran tactile', 'ZER12347'),
(39, 'Support lombaire réglable', 'ZER12347'),
(40, 'Compresseur', 'ZER12347'),
(41, 'Régulateur de vitesse adaptatif', 'ZER12347'),
(42, 'Caméra à 360°', 'DI748585'),
(43, 'Assistant de vision nocturne', 'DI748585'),
(44, 'Climatisation automatique', 'DI748585'),
(45, 'Ecran tactile', 'DI748585'),
(46, 'Coussins gonflables à deux phases', 'DI748585'),
(47, 'Commande/contrôle vocal', 'DI748585'),
(48, 'Mode de conduite', 'DI748585');

-- --------------------------------------------------------

--
-- Structure de la table `agence`
--

CREATE TABLE `agence` (
  `id_agence` int(11) NOT NULL,
  `Nom_agence` varchar(50) DEFAULT NULL,
  `ville_agence` varchar(50) DEFAULT NULL,
  `adresse_agence` varchar(50) DEFAULT NULL,
  `telephone` int(11) DEFAULT NULL,
  `email_agence` varchar(50) DEFAULT NULL,
  `logo_agence` text DEFAULT NULL,
  `if_agence` int(11) DEFAULT NULL,
  `rc` int(11) DEFAULT NULL,
  `ice` int(11) DEFAULT NULL,
  `cnss` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `agence`
--

INSERT INTO `agence` (`id_agence`, `Nom_agence`, `ville_agence`, `adresse_agence`, `telephone`, `email_agence`, `logo_agence`, `if_agence`, `rc`, `ice`, `cnss`) VALUES
(1, 'WLC', 'Marrakech', 'Rue khalid ibn el oualid ,Guéliz', 655243799, 'wlcCars2023@gmail.com', 'LOGO/logonew.png', 14751476, 74523, 869274511, 1463258);

-- --------------------------------------------------------

--
-- Structure de la table `alerte`
--

CREATE TABLE `alerte` (
  `date_carte_grise` date DEFAULT NULL,
  `date_vidange` date DEFAULT NULL,
  `date_visite_technique` date DEFAULT NULL,
  `date_assurance` date DEFAULT NULL,
  `date_retour` date DEFAULT NULL,
  `matricule_voiture` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `alerte`
--

INSERT INTO `alerte` (`date_carte_grise`, `date_vidange`, `date_visite_technique`, `date_assurance`, `date_retour`, `matricule_voiture`) VALUES
('2023-06-22', '2024-07-22', '2028-07-22', '2024-08-29', '2023-06-24', 'ZER12347');

--
-- Déclencheurs `alerte`
--
DELIMITER $$
CREATE TRIGGER `voiture_notif` AFTER UPDATE ON `alerte` FOR EACH ROW BEGIN 

IF(new.date_vidange > old.date_vidange) THEN
UPDATE notif JOIN voiture 
SET notif.reading = "seen"
WHERE notif.matricul = voiture.matricul 
AND notif.type_notif = "vidange";

ELSEIF(new.date_visite_technique > old.date_visite_technique) THEN
UPDATE notif JOIN voiture 
SET notif.reading = "seen"
WHERE notif.matricul = voiture.matricul 
AND notif.type_notif = "visite";

ELSEIF(new.date_assurance > old.date_assurance) THEN
UPDATE notif JOIN voiture 
SET notif.reading = "seen"
WHERE notif.matricul = voiture.matricul 
AND notif.type_notif = "assurance";

ELSEIF(new.date_retour > old.date_retour) THEN
UPDATE notif JOIN voiture 
SET notif.reading = "seen"
WHERE notif.matricul = voiture.matricul 
AND notif.type_notif = "retour";

END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `charge`
--

CREATE TABLE `charge` (
  `id_ch` int(11) NOT NULL,
  `matricule_ch` varchar(20) DEFAULT NULL,
  `dateAchat_ch` date DEFAULT NULL,
  `avance_ch` float DEFAULT NULL,
  `reste_ch` float DEFAULT NULL,
  `montant_global` float DEFAULT NULL,
  `prix_par_mois` float DEFAULT NULL,
  `etat` enum('payé','inpaye') DEFAULT NULL,
  `traite` float DEFAULT NULL,
  `prixAssurance` float DEFAULT NULL,
  `dateFinEchehance` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `nom_client` varchar(100) DEFAULT NULL,
  `prenom_client` varchar(100) DEFAULT NULL,
  `identity_card` varchar(50) DEFAULT NULL,
  `email_client` varchar(100) DEFAULT NULL,
  `password_client` varchar(20) DEFAULT NULL,
  `permis` varchar(50) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `phote_cin` text DEFAULT NULL,
  `photo_permis` text DEFAULT NULL,
  `telephone` int(11) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `nom_client`, `prenom_client`, `identity_card`, `email_client`, `password_client`, `permis`, `ville`, `phote_cin`, `photo_permis`, `telephone`, `token`) VALUES
(11, 'rais', 'haytam', 'EE899711', 'haytamehatyme@gmail.com', 'robberXIX2004', '13214325', 'tanger', 'Uploaded_images/MongoDB_Logo.svg.png', 'Uploaded_images/GitHub-Logo.png', 640432943, '106577645490614763615'),
(12, 'essomdi', 'soulaiman', 'EE983421', 'soulaiman17@gmail.com', 'soulaiman123', '05/450228', 'layoune', 'Uploaded_images/Screenshot (6).png', 'Uploaded_images/Screenshot (2).png', 640432943, NULL),
(14, 'Iliass', 'Elabd', NULL, 'omnigold460@gmail.com', NULL, '859633', 'marrakech', 'Uploaded_images/buisness model.png', 'Uploaded_images/Capture d’écran 2023-02-20 195408.png', 655243799, '108257059464352632860');

-- --------------------------------------------------------

--
-- Structure de la table `contrat`
--

CREATE TABLE `contrat` (
  `id_contrat` int(11) NOT NULL,
  `if_client_f` int(11) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `date_contrat` date DEFAULT NULL,
  `mat_voiture` varchar(50) DEFAULT NULL,
  `marque` varchar(50) DEFAULT NULL,
  `kilometrage` int(11) DEFAULT NULL,
  `debut_res` date DEFAULT NULL,
  `fin_res` date DEFAULT NULL,
  `prix_par_jour` int(11) DEFAULT NULL,
  `ville` varchar(50) DEFAULT 'marrakech'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `decla_infraction`
--

CREATE TABLE `decla_infraction` (
  `id_client_fk_decla` int(11) DEFAULT NULL,
  `fait_a` date DEFAULT NULL,
  `fait_le` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `directeur`
--

CREATE TABLE `directeur` (
  `id_dir` int(11) NOT NULL,
  `family_name_dir` varchar(100) DEFAULT NULL,
  `first_name_dir` varchar(100) DEFAULT NULL,
  `email_dir` varchar(200) DEFAULT NULL,
  `cin_dir` varchar(50) DEFAULT NULL,
  `password_dir` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `directeur`
--

INSERT INTO `directeur` (`id_dir`, `family_name_dir`, `first_name_dir`, `email_dir`, `cin_dir`, `password_dir`) VALUES
(1, 'Elabd', 'Iliass', 'admin@gmail.com', 'EE952017', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `employee`
--

CREATE TABLE `employee` (
  `id_emp` int(11) NOT NULL,
  `family_name_emp` varchar(100) DEFAULT NULL,
  `first_name_emp` varchar(100) DEFAULT NULL,
  `email_emp` varchar(200) DEFAULT NULL,
  `cin_emp` varchar(50) DEFAULT NULL,
  `horrair_emp` time DEFAULT NULL,
  `fonctionality` varchar(200) DEFAULT NULL,
  `salaire` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `employee`
--

INSERT INTO `employee` (`id_emp`, `family_name_emp`, `first_name_emp`, `email_emp`, `cin_emp`, `horrair_emp`, `fonctionality`, `salaire`) VALUES
(3, 'Elabd', 'Rayan', 'nagataSupra330@gmail.com', 'EE345678', '06:38:38', 'mecanicien', 15000);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `id_facture` int(11) NOT NULL,
  `date_facture` date DEFAULT NULL,
  `id_client_fkk` int(11) DEFAULT NULL,
  `designation` varchar(200) DEFAULT NULL,
  `qte` int(11) DEFAULT NULL,
  `nbr_jour` int(11) DEFAULT NULL,
  `pris_unitaire` float DEFAULT NULL,
  `montant_ht` float DEFAULT NULL,
  `tva` float DEFAULT NULL,
  `total_tcc` float DEFAULT NULL,
  `id_reserve` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE `historique` (
  `id_his` int(11) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `name_client` varchar(250) DEFAULT NULL,
  `lastname_client` varchar(250) DEFAULT NULL,
  `matricul_car` varchar(50) DEFAULT NULL,
  `mark_car` varchar(250) DEFAULT NULL,
  `model_car` varchar(250) DEFAULT NULL,
  `price_res` float DEFAULT NULL,
  `debut_res` date NOT NULL,
  `fin_res` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `notif`
--

CREATE TABLE `notif` (
  `id_notif` int(11) NOT NULL,
  `phrase_notif` varchar(500) DEFAULT NULL,
  `reading` varchar(200) DEFAULT 'unseen',
  `cfr` int(11) DEFAULT 0,
  `matricul` varchar(200) DEFAULT '0',
  `type_notif` varchar(200) DEFAULT '0',
  `client` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `notif`
--

INSERT INTO `notif` (`id_notif`, `phrase_notif`, `reading`, `cfr`, `matricul`, `type_notif`, `client`) VALUES
(3426, 'La voiture peugeot 208 doit revenir au local dans 2 jour(s) !', 'unseen', 0, 'ZER12347', 'retour', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reparation`
--

CREATE TABLE `reparation` (
  `id_rep` int(11) NOT NULL,
  `matricule_rep` varchar(20) DEFAULT NULL,
  `mark_voiture` varchar(50) DEFAULT NULL,
  `typeRep` text DEFAULT NULL,
  `cout_reparation` int(11) DEFAULT NULL,
  `date_reparation` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `reserver`
--

CREATE TABLE `reserver` (
  `id_reserve` int(11) NOT NULL,
  `debut_res` date DEFAULT NULL,
  `fin_res` date DEFAULT NULL,
  `matricule_voiture_reserver` varchar(50) NOT NULL,
  `id_client_res_fk` int(11) NOT NULL,
  `nom_client` varchar(50) NOT NULL,
  `prenom_client` varchar(50) NOT NULL,
  `duree` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `mode_paiment` varchar(30) DEFAULT NULL,
  `Dconducteur` varchar(200) DEFAULT NULL,
  `prix_unitaire` float DEFAULT NULL,
  `confirmer` int(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déclencheurs `reserver`
--
DELIMITER $$
CREATE TRIGGER `confirmed` AFTER UPDATE ON `reserver` FOR EACH ROW BEGIN 
IF NEW.confirmer <> OLD.confirmer THEN
        UPDATE notif JOIN reserver
        SET reading = "seen"
        WHERE new.id_reserve = cfr;
END IF;

UPDATE voiture
SET voiture.status_voi = "indisponible"
WHERE new.matricule_voiture_reserver = voiture.matricul
AND new.debut_res = CURRENT_DATE();

UPDATE facture
SET facture.date_facture = CURRENT_DATE(),
facture.nbr_jour = DATEDIFF(new.fin_res,new.debut_res),
facture.montant_ht = new.price,
facture.total_tcc = (new.price * 0.1) + new.price
WHERE facture.id_client_fkk = new.id_client_res_fk;

UPDATE contrat 
SET contrat.debut_res = new.debut_res,
contrat.fin_res = new.fin_res,
contrat.prix_par_jour = new.prix_unitaire
WHERE contrat.if_client_f = new.id_client_res_fk;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_notif_res` AFTER DELETE ON `reserver` FOR EACH ROW BEGIN
DELETE FROM notif 
WHERE notif.cfr = OLD.id_reserve;
UPDATE voiture
SET voiture.status_voi = "disponible"
WHERE voiture.matricul = old.matricule_voiture_reserver;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_to_facture` AFTER INSERT ON `reserver` FOR EACH ROW BEGIN
DECLARE tva,total float;
DECLARE montantht int;
set tva = new.price * 0.2;
set montantht = new.price;
set total = montantht + tva;
INSERT INTO facture( date_facture, id_client_fkk, designation, qte, nbr_jour, pris_unitaire, montant_ht, tva, total_tcc,id_reserve) VALUES (CURRENT_DATE(),new.id_client_res_fk,"Facture pour location de voiture ",1,new.duree,new.prix_unitaire,montantht,tva,total,new.id_reserve); 
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `notification_res` AFTER INSERT ON `reserver` FOR EACH ROW BEGIN
DECLARE cpt int(11) DEFAULT 0;
SET cpt = (SELECT reserver.id_reserve FROM reserver ORDER BY reserver.id_reserve DESC LIMIT 1) ;
INSERT INTO notif(phrase_notif,reading,cfr,client) VALUES 
(CONCAT(new.nom_client,cpt,' a reserver une voiture !'),'unseen',cpt,new.nom_client);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `showing_cars` AFTER INSERT ON `reserver` FOR EACH ROW BEGIN
IF(NEW.debut_res = CURRENT_DATE()) THEN
UPDATE voiture
SET voiture.status_voi = "indisponible"
WHERE NEW.matricule_voiture_reserver = voiture.matricul;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_alerte_retour` AFTER INSERT ON `reserver` FOR EACH ROW BEGIN
DECLARE cc varchar(100);
set cc = (SELECT matricule_voiture_reserver FROM reserver JOIN alerte WHERE matricule_voiture_reserver = alerte.matricule_voiture  order BY id_reserve DESC LIMIT 1
);
UPDATE alerte join reserver SET date_retour = new.fin_res WHERE alerte.matricule_voiture = cc;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_reserver` BEFORE UPDATE ON `reserver` FOR EACH ROW BEGIN
IF ( new.fin_res > old.fin_res OR new.fin_res < old.fin_res ) THEN
SET new.price = DATEDIFF(new.fin_res,new.debut_res) * new.prix_unitaire;
SET new.duree = DATEDIFF(new.fin_res,new.debut_res);
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `review`
--

CREATE TABLE `review` (
  `id_review` int(11) NOT NULL,
  `text_review` text DEFAULT NULL,
  `date_review` date DEFAULT NULL,
  `id_client_fk` int(11) DEFAULT NULL,
  `matricule_voiture` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `review`
--

INSERT INTO `review` (`id_review`, `text_review`, `date_review`, `id_client_fk`, `matricule_voiture`) VALUES
(2, 'trés belle voiture, Merci à WLC pour ce service', '2023-06-22', 14, 'DI748585');

-- --------------------------------------------------------

--
-- Structure de la table `secretaire`
--

CREATE TABLE `secretaire` (
  `id_sec` int(11) NOT NULL,
  `nom_sec` varchar(200) DEFAULT NULL,
  `prenom_sec` varchar(200) DEFAULT NULL,
  `cin_sec` varchar(200) DEFAULT NULL,
  `email_sec` varchar(200) DEFAULT NULL,
  `password_sec` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `secretaire`
--

INSERT INTO `secretaire` (`id_sec`, `nom_sec`, `prenom_sec`, `cin_sec`, `email_sec`, `password_sec`) VALUES
(1, 'secretaire', 'secretaire', 'ed367882', 'secretaire@gmail.com', 'secretaire');

-- --------------------------------------------------------

--
-- Structure de la table `stripe`
--

CREATE TABLE `stripe` (
  `secretKey` varchar(500) DEFAULT NULL,
  `publishableKey` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stripe`
--

INSERT INTO `stripe` (`secretKey`, `publishableKey`) VALUES
('sk_test_51N1GANKPXJylR4Zi2xEnJjoxAdlWO60qJ4sXcspEqiiwmV6fD9ttp8C5SODVgAq52Dw6GbelmCFiKEx7pUZA7HEN00Sjywipxn', 'pk_test_51N1GANKPXJylR4Zi8oElWbfy79ncHLssJzH93VQ06wbWYqGYX702PDB3CbzkgruljWdabpO5fxSIbiFVPO97R5aD00PSWdTYFS');

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `matricul` varchar(50) NOT NULL,
  `picture_car` text DEFAULT NULL,
  `mark_voi` varchar(100) DEFAULT NULL,
  `capacity_voi` int(20) DEFAULT NULL,
  `model_voi` varchar(200) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `type_carburent` varchar(50) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `type_voiture` varchar(20) DEFAULT NULL,
  `N_chassis` varchar(100) DEFAULT NULL,
  `km_actuel` int(11) DEFAULT NULL,
  `couleur` varchar(50) DEFAULT NULL,
  `status_voi` text DEFAULT NULL,
  `picture2` text DEFAULT NULL,
  `picture3` text DEFAULT NULL,
  `picture4` text DEFAULT NULL,
  `picture5` text DEFAULT NULL,
  `confirm` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`matricul`, `picture_car`, `mark_voi`, `capacity_voi`, `model_voi`, `price`, `type_carburent`, `description`, `type_voiture`, `N_chassis`, `km_actuel`, `couleur`, `status_voi`, `picture2`, `picture3`, `picture4`, `picture5`, `confirm`) VALUES
('DET23456', 'Uploaded_images/dacia_1.png', 'dacia', 6, 'Logan', 250, 'diesel', 'une voiture de famille ', 'moyenne', '09999987', 0, 'marron', 'disponible', 'Uploaded_images/dacia duster 4.jpeg', 'Uploaded_images/dacia duster 3.jpeg', 'Uploaded_images/dacia duster 2.jpeg', 'Uploaded_images/dacia duster 1.jpeg', 0),
('DI748585', 'Uploaded_images/merc_2.png', 'Mercedes', 5, '2020', 600, 'diesel', 'Mercedes-Benz est une marque allemande automobiles (modèles premium, de sport et de luxe), de camions, autocars et autobus indépendante fondée en 1926 par trois constructeurs : Daimler-Motoren-Gesellschaft, Mercedes et Benz & Cie.', 'grande', '15236987', 0, 'blanche', 'disponible', 'Uploaded_images/dacia duster 3.jpeg', 'Uploaded_images/téléchargé.jpeg', 'Uploaded_images/mercedes-classe-c-4_1.jpg', 'Uploaded_images/cc.jpg', 0),
('RQT66977', 'Uploaded_images/$2y$10$cEMndt9okEd4lpYJIIYR0e3WMTqTL2lh.qi8.enC8vBHXL4E7pIkmfiat_1.png', 'Fiat ', 4, '500', 250, 'diesel', 'une voiture pour les jeunes', 'petite', '12345678', 20, 'blanche', 'disponible', 'Uploaded_images/fiat 3.jpeg', 'Uploaded_images/fiat 2.jpeg', 'Uploaded_images/fiat 1.jpeg', 'Uploaded_images/4ad108257bcfb.jpg', 0),
('ZER12347', 'Uploaded_images/pijo_1.png', 'peugeot 208', 5, '2019', 300, 'essence', 'Découvrez votre PEUGEOT 208 la citadine compacte 5 Places avec sa silhouette distinctive ! Une motorisation dernière génération, écran tactile 7 HD et boîte automatique. Motorisations efficientes. Prix imbattables. Intérieur High-Tech. Design raffiné.', 'moyenne', '998376123', 0, 'orange', 'disponible', 'Uploaded_images/panda 3.webp', 'Uploaded_images/dacia duster 2.jpeg', 'Uploaded_images/4ad108257bcfb.jpg', 'Uploaded_images/dacia logan 3.jpeg', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accessoire`
--
ALTER TABLE `accessoire`
  ADD PRIMARY KEY (`id_Acc`),
  ADD KEY `matricule_voiture` (`matricule_voiture`);

--
-- Index pour la table `agence`
--
ALTER TABLE `agence`
  ADD PRIMARY KEY (`id_agence`);

--
-- Index pour la table `alerte`
--
ALTER TABLE `alerte`
  ADD UNIQUE KEY `u_alert` (`matricule_voiture`),
  ADD KEY `matricule_voiture` (`matricule_voiture`);

--
-- Index pour la table `charge`
--
ALTER TABLE `charge`
  ADD PRIMARY KEY (`id_ch`),
  ADD UNIQUE KEY `matricule_ch_2` (`matricule_ch`),
  ADD KEY `matricule_ch` (`matricule_ch`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `contrat`
--
ALTER TABLE `contrat`
  ADD PRIMARY KEY (`id_contrat`),
  ADD KEY `if_client_f` (`if_client_f`),
  ADD KEY `mat_voiture` (`mat_voiture`);

--
-- Index pour la table `decla_infraction`
--
ALTER TABLE `decla_infraction`
  ADD KEY `id_client_fk_decla` (`id_client_fk_decla`);

--
-- Index pour la table `directeur`
--
ALTER TABLE `directeur`
  ADD PRIMARY KEY (`id_dir`);

--
-- Index pour la table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id_emp`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id_facture`),
  ADD KEY `id_client_fkk` (`id_client_fkk`);

--
-- Index pour la table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`id_his`);

--
-- Index pour la table `notif`
--
ALTER TABLE `notif`
  ADD PRIMARY KEY (`id_notif`),
  ADD UNIQUE KEY `phrase_notif` (`phrase_notif`);

--
-- Index pour la table `reparation`
--
ALTER TABLE `reparation`
  ADD PRIMARY KEY (`id_rep`),
  ADD KEY `matricule_rep` (`matricule_rep`);

--
-- Index pour la table `reserver`
--
ALTER TABLE `reserver`
  ADD PRIMARY KEY (`id_reserve`),
  ADD KEY `matricule_voiture_reserver` (`matricule_voiture_reserver`),
  ADD KEY `id_client_res_fk` (`id_client_res_fk`);

--
-- Index pour la table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `id_client_fk` (`id_client_fk`),
  ADD KEY `matricule_voiture` (`matricule_voiture`);

--
-- Index pour la table `secretaire`
--
ALTER TABLE `secretaire`
  ADD PRIMARY KEY (`id_sec`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`matricul`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accessoire`
--
ALTER TABLE `accessoire`
  MODIFY `id_Acc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `agence`
--
ALTER TABLE `agence`
  MODIFY `id_agence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `charge`
--
ALTER TABLE `charge`
  MODIFY `id_ch` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `contrat`
--
ALTER TABLE `contrat`
  MODIFY `id_contrat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `directeur`
--
ALTER TABLE `directeur`
  MODIFY `id_dir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `employee`
--
ALTER TABLE `employee`
  MODIFY `id_emp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `id_facture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT pour la table `historique`
--
ALTER TABLE `historique`
  MODIFY `id_his` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notif`
--
ALTER TABLE `notif`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3448;

--
-- AUTO_INCREMENT pour la table `reparation`
--
ALTER TABLE `reparation`
  MODIFY `id_rep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `reserver`
--
ALTER TABLE `reserver`
  MODIFY `id_reserve` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT pour la table `review`
--
ALTER TABLE `review`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `secretaire`
--
ALTER TABLE `secretaire`
  MODIFY `id_sec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `accessoire`
--
ALTER TABLE `accessoire`
  ADD CONSTRAINT `accessoire_ibfk_1` FOREIGN KEY (`matricule_voiture`) REFERENCES `voiture` (`matricul`);

--
-- Contraintes pour la table `alerte`
--
ALTER TABLE `alerte`
  ADD CONSTRAINT `alerte_ibfk_1` FOREIGN KEY (`matricule_voiture`) REFERENCES `voiture` (`matricul`);

--
-- Contraintes pour la table `charge`
--
ALTER TABLE `charge`
  ADD CONSTRAINT `charge_ibfk_1` FOREIGN KEY (`matricule_ch`) REFERENCES `voiture` (`matricul`);

--
-- Contraintes pour la table `contrat`
--
ALTER TABLE `contrat`
  ADD CONSTRAINT `contrat_ibfk_1` FOREIGN KEY (`if_client_f`) REFERENCES `client` (`id_client`) ON DELETE CASCADE,
  ADD CONSTRAINT `contrat_ibfk_2` FOREIGN KEY (`mat_voiture`) REFERENCES `voiture` (`matricul`) ON DELETE CASCADE;

--
-- Contraintes pour la table `decla_infraction`
--
ALTER TABLE `decla_infraction`
  ADD CONSTRAINT `decla_infraction_ibfk_1` FOREIGN KEY (`id_client_fk_decla`) REFERENCES `client` (`id_client`);

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`id_client_fkk`) REFERENCES `client` (`id_client`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reparation`
--
ALTER TABLE `reparation`
  ADD CONSTRAINT `reparation_ibfk_1` FOREIGN KEY (`matricule_rep`) REFERENCES `voiture` (`matricul`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reserver`
--
ALTER TABLE `reserver`
  ADD CONSTRAINT `reserver_ibfk_1` FOREIGN KEY (`matricule_voiture_reserver`) REFERENCES `voiture` (`matricul`) ON DELETE CASCADE,
  ADD CONSTRAINT `reserver_ibfk_2` FOREIGN KEY (`id_client_res_fk`) REFERENCES `client` (`id_client`) ON DELETE CASCADE;

--
-- Contraintes pour la table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`id_client_fk`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`matricule_voiture`) REFERENCES `voiture` (`matricul`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

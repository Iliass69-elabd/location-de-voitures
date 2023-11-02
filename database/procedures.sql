-- DELIMITER $$
-- CREATE DEFINER=`root`@`localhost` PROCEDURE `addReservation`(IN `id` INT, IN `debut` DATE, IN `fin` DATE, IN `matricule` VARCHAR(200), IN `idClient` INT, IN `nom` VARCHAR(200), IN `prenom` VARCHAR(200), IN `price` FLOAT, IN `modeP` VARCHAR(200), IN `Dconduct` VARCHAR(200))
-- BEGIN
-- DECLARE Cexist,idCexist int(10) DEFAULT 0;
-- DECLARE msg varchar(200) DEFAULT '';
-- SET msg = 'Client nipala!!';
-- SET idCexist = (SELECT COUNT(*) FROM client WHERE id_client = idClient); 
-- IF(idCexist!=0)THEN
-- INSERT INTO reserver VALUES
-- (id,debut,fin,matricule,idClient,nom,prenom,price,modeP,Dconduct);
-- ELSE 
-- SELECT msg;
-- END IF;
-- SELECT 'Reservation faite avec succee!';
-- END$$
-- DELIMITER ;

-- DELIMITER $$
-- CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteReservation`(IN `idRes` INT)
-- BEGIN
-- DELETE FROM reserver 
-- WHERE id_reserve = idRes;
-- END$$
-- DELIMITER ;

-- DELIMITER $$
-- CREATE DEFINER=`root`@`localhost` PROCEDURE `showReservation`()
-- BEGIN
-- SELECT * FROM reserver ;
-- END$$
-- DELIMITER ;

-- DELIMITER $$
-- CREATE DEFINER=`root`@`localhost` PROCEDURE `statisticReservation`()
-- BEGIN

-- SELECT MONTHNAME(debut_res) as month, COUNT(*) as amount FROM reserver
-- GROUP BY MONTH(debut_res) ,month
-- ORDER BY MONTH(debut_res) ;
-- END$$
-- DELIMITER ;

-- DELIMITER $$
-- CREATE DEFINER=`root`@`localhost` PROCEDURE `updateReserver`(IN `idRes` INT, IN `debutRes` DATE, IN `finRes` DATE, IN `matriculeRes` VARCHAR(200), IN `idClientRes` INT, IN `nomRes` VARCHAR(200), IN `prenomRes` VARCHAR(200), IN `duree` INT, IN `priceRes` FLOAT, IN `modePayRes` VARCHAR(200), IN `DconductRes` VARCHAR(200), IN `prixUni` INT)
-- BEGIN
-- UPDATE reserver SET 
-- debut_res=debutRes,
-- fin_res=finRes,
-- matricule_voiture_reserver=matriculeRes,
-- id_client_res_fk=idClientRes,
-- nom_client=nomRes,
-- prenom_client=prenomRes,
-- duree=duree,
-- price=priceRes,
-- mode_paiment=modePayRes,
-- Dconducteur=DconductRes,
-- prix_unitaire=prixUni 
-- WHERE id_reserve=idRes;
-- END$$
-- DELIMITER ;



-- DELIMITER $$
-- CREATE DEFINER=`root`@`localhost` PROCEDURE `clientReservations`(IN `idClient` INT)
-- BEGIN
-- SELECT MONTHNAME(debut_res) AS Month, COUNT(id_reserve) AS Number  FROM reserver r
-- JOIN client c
-- WHERE r.id_client_res_fk = c.id_client
-- AND c.id_client = idClient
-- GROUP BY MONTH(debut_res) ,month
-- ORDER BY MONTH(debut_res);
-- END$$
-- DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addReservation`(IN `id` INT, IN `debut` DATE, IN `fin` DATE, IN `matricule` VARCHAR(200), IN `idClient` INT, IN `nom` VARCHAR(200), IN `prenom` VARCHAR(200), IN `price` FLOAT, IN `modeP` VARCHAR(200), IN `Dconduct` VARCHAR(200))
BEGIN
DECLARE Cexist,idCexist int(10) DEFAULT 0;
DECLARE msg varchar(200) DEFAULT '';
SET msg = 'Client nipala!!';
SET idCexist = (SELECT COUNT(*) FROM client WHERE id_client = idClient); 
IF(idCexist!=0)THEN
INSERT INTO reserver VALUES
(id,debut,fin,matricule,idClient,nom,prenom,price,modeP,Dconduct);
ELSE 
SELECT msg2;
END IF;
SELECT 'Reservation faite avec succee!';
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `clientReservations`(IN `idClient` INT)
BEGIN
SELECT MONTHNAME(debut_res) AS Month, COUNT(id_reserve) AS Number  FROM reserver r
JOIN client c
WHERE r.id_client_res_fk = c.id_client
AND c.id_client = idClient
GROUP BY MONTH(debut_res) ,month
ORDER BY MONTH(debut_res);
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `countClientNotReserved`()
BEGIN
SELECT COUNT(DISTINCT client.id_client) as ClientNonReserver FROM
client
WHERE client.id_client NOT IN (SELECT reserver.id_client_res_fk FROM reserver);
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `countClientReserved`()
BEGIN
SELECT COUNT(DISTINCT client.id_client) as ClientReserver FROM client
JOIN reserver 
WHERE client.id_client = reserver.id_client_res_fk;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `countReservation`()
BEGIN
SELECT COUNT(*) as TotalReserver FROM reserver;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `countTotalClient`()
BEGIN
SELECT COUNT(*) as Clients FROM client;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `countTotalGain`()
BEGIN
SELECT SUM(reserver.price) as Total FROM reserver;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `countTotalVoiture`()
BEGIN
SELECT COUNT(*) as Voitures FROM voiture ;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `countVoitureNotReserved`()
BEGIN
SELECT COUNT(DISTINCT voiture.matricul) as VoitureNonReserver FROM voiture
WHERE voiture.matricul NOT IN (SELECT matricule_voiture_reserver FROM reserver);
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `countVoiturePlusReserver`()
BEGIN
SELECT v.mark_voi as Voiture ,COUNT(matricule_voiture_reserver) as Reserved FROM reserver r
JOIN voiture v
WHERE r.matricule_voiture_reserver = v.matricul
GROUP BY r.matricule_voiture_reserver;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `countVoitureReserved`()
BEGIN
SELECT COUNT( DISTINCT voiture.matricul) as VoitureReserver FROM voiture
JOIN reserver 
WHERE voiture.matricul = reserver.matricule_voiture_reserver;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteReservation`(IN `idRes` INT)
BEGIN
DELETE FROM reserver 
WHERE id_reserve = idRes;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `reservationPerDay`()
BEGIN
SELECT COUNT(*) as Today FROM reserver
WHERE DAY(debut_res) = DAY(CURDATE());
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `reservationPerMonth`()
BEGIN
SELECT COUNT(*) as ThisMonth FROM reserver 
WHERE MONTH(debut_res) = MONTH(CURDATE());
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `reservationPerYear`()
BEGIN
SELECT COUNT(*) as ThisYear FROM reserver
WHERE YEAR(debut_res) = YEAR(CURDATE());
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `showReservation`()
BEGIN
SELECT * FROM reserver ;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `statisticReservation`()
BEGIN

SELECT MONTHNAME(debut_res) as month, COUNT(*) as amount FROM reserver
GROUP BY MONTH(debut_res) ,month
ORDER BY MONTH(debut_res) ;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateReserver`(IN `idRes` INT, IN `debutRes` DATE, IN `finRes` DATE, IN `matriculeRes` VARCHAR(200), IN `idClientRes` INT, IN `nomRes` VARCHAR(200), IN `prenomRes` VARCHAR(200), IN `duree` INT, IN `priceRes` FLOAT, IN `modePayRes` VARCHAR(200), IN `DconductRes` VARCHAR(200), IN `prixUni` INT)
BEGIN
UPDATE reserver SET debut_res=debutRes,fin_res=finRes,matricule_voiture_reserver=matriculeRes,id_client_res_fk=idClientRes,
nom_client=nomRes,prenom_client=prenomRes,duree=duree,price=priceRes,mode_paiment=modePayRes,
Dconducteur=DconductRes,prix_unitaire=prixUni WHERE id_reserve=idRes;
END$$
DELIMITER ;

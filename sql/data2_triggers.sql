-- Change the delimiter to handle multiple statements
DELIMITER $$

-- Trigger for adding a new car and linking it to the driver if it doesn't exist
CREATE TRIGGER ajout_voiture
BEFORE INSERT ON VOITURE
FOR EACH ROW
BEGIN
    INSERT IGNORE INTO CONDUCTEUR(NUM_CONDUCTEUR)
    SELECT NEW.NUM_CONDUCTEUR
    WHERE NOT EXISTS (
        SELECT 1
        FROM CONDUCTEUR
        WHERE NUM_CONDUCTEUR = NEW.NUM_CONDUCTEUR
    );
END$$

-- Trigger for associating a car to a new trip if it doesn't exist
CREATE TRIGGER ajout_trajet_matricule
BEFORE INSERT ON TRAJET
FOR EACH ROW
BEGIN
    INSERT IGNORE INTO VOITURE(NUM_IMMATRICULE)
    SELECT NEW.NUM_IMMATRICULE
    WHERE NOT EXISTS (
        SELECT 1
        FROM VOITURE
        WHERE NUM_IMMATRICULE = NEW.NUM_IMMATRICULE
    );
END$$

-- Trigger to verify that the departure date is before the arrival date
CREATE TRIGGER ajout_trajet_dates
BEFORE INSERT ON TRAJET
FOR EACH ROW
BEGIN
    IF NEW.DATE_ARRIVEE <= NEW.DATE_DEPART THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: DATE_ARRIVEE should be after DATE_DEPART';
    END IF;
END$$

-- Triggers to add a Passenger
CREATE TRIGGER ajout_passager_reservation
BEFORE INSERT ON RESERVATION
FOR EACH ROW
BEGIN
    INSERT IGNORE INTO PASSAGER(NUM_PASSAGER)
    SELECT NEW.NUM_PASSAGER
    WHERE NOT EXISTS (
        SELECT 1
        FROM PASSAGER
        WHERE NUM_PASSAGER = NEW.NUM_PASSAGER
    );
END$$

CREATE TRIGGER ajout_passager_proposition
BEFORE INSERT ON PROPOSITION
FOR EACH ROW
BEGIN
    INSERT IGNORE INTO PASSAGER(NUM_PASSAGER)
    SELECT NEW.NUM_PASSAGER
    WHERE NOT EXISTS (
        SELECT 1
        FROM PASSAGER
        WHERE NUM_PASSAGER = NEW.NUM_PASSAGER
    );
END$$

-- Reset the delimiter to the default
DELIMITER ;

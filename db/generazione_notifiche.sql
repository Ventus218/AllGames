
/* GENERAZIONE AUTOMATICA DELLE NOTIFICHE */

CREATE PROCEDURE generaNotificaFollow (IN newUtenteSeguace INT, IN newUtenteSeguito INT)
BEGIN

    INSERT INTO NOTIFICA(Letta, Timestamp, Ricevente, AttoreSorgente, NotificaFollow, UtenteSeguace, UtenteSeguito, NotificaMiPiace, NotificaPostCommunity, NotificaCommento, NotificaRisposta)
        VALUE (FALSE, current_timestamp(), newUtenteSeguito, newUtenteSeguace, TRUE, newUtenteSeguace, newUtenteSeguito, FALSE, FALSE, FALSE, FALSE);

END;

CREATE OR REPLACE TRIGGER generaNotificaFollow AFTER INSERT ON FOLLOW
FOR EACH ROW
CALL generaNotificaFollow(NEW.UtenteSeguace, NEW.UtenteSeguito);


CREATE PROCEDURE generaNotificaMiPiace (IN liker INT, IN post INT)
BEGIN

    DECLARE UtentePost INT;

    SET UtentePost = (SELECT P.Utente FROM POST P WHERE P.Id = post);

    INSERT INTO NOTIFICA(Letta, Timestamp, Ricevente, AttoreSorgente, NotificaFollow, NotificaMiPiace, Utente, Post, NotificaPostCommunity, NotificaCommento, NotificaRisposta)
        SELECT FALSE, current_timestamp(), UtentePost, liker, FALSE, TRUE, liker, post, FALSE, FALSE, FALSE;
END;


CREATE OR REPLACE TRIGGER generaNotificaMiPiace AFTER INSERT ON MI_PIACE
FOR EACH ROW
CALL generaNotificaMiPiace(NEW.Utente, NEW.Post);


CREATE PROCEDURE generaNotificaPostCommunity (IN post INT, IN community VARCHAR(64))
BEGIN

    DECLARE UtentePost INT;

    SET UtentePost = (SELECT P.Utente FROM POST P WHERE P.Id = post);

    INSERT INTO NOTIFICA(Letta, Timestamp, Ricevente, AttoreSorgente, NotificaFollow, NotificaMiPiace, NotificaPostCommunity, PostCommunity, NotificaCommento, NotificaRisposta)
        SELECT FALSE, current_timestamp(), PC.Utente, UtentePost, FALSE, FALSE, TRUE, post, FALSE, FALSE FROM PARTECIPAZIONE_COMMUNITY PC
        WHERE PC.Community = community AND PC.Utente != UtentePost;
END;


CREATE OR REPLACE TRIGGER generaNotificaPostCommunity AFTER INSERT ON POST
FOR EACH ROW
BEGIN
    IF NEW.Community IS NOT NULL THEN
        CALL generaNotificaPostCommunity(NEW.Id, NEW.Community);
    END IF;
END;


CREATE PROCEDURE generaNotificaCommento (IN commento INT, IN commentatore INT, IN post INT)
BEGIN

    DECLARE UtentePost INT;

    SET UtentePost = (SELECT P.Utente FROM POST P WHERE P.Id = post);

    INSERT INTO NOTIFICA(Letta, Timestamp, Ricevente, AttoreSorgente, NotificaFollow, NotificaMiPiace, NotificaPostCommunity, NotificaCommento, Commento, NotificaRisposta)
        SELECT FALSE, current_timestamp(), UtentePost, commentatore, FALSE, FALSE, FALSE, TRUE, commento, FALSE;
END;

CREATE OR REPLACE TRIGGER generaNotificaCommento AFTER INSERT ON COMMENTO
FOR EACH ROW
CALL generaNotificaCommento(NEW.Id, NEW.Commentatore, NEW.Post);


CREATE PROCEDURE generaNotificaRisposta (IN risposta INT, IN risponditore INT, IN commento INT)
BEGIN

    DECLARE UtenteCommento INT;

    SET UtenteCommento = (SELECT P.Utente FROM POST P JOIN COMMENTO C ON (P.Id = C.Post) WHERE C.Id = commento);

    INSERT INTO NOTIFICA(Letta, Timestamp, Ricevente, AttoreSorgente, NotificaFollow, NotificaMiPiace, NotificaPostCommunity, NotificaCommento, NotificaRisposta, Risposta)
        SELECT FALSE, current_timestamp(), UtenteCommento, risponditore, FALSE, FALSE, FALSE, FALSE, TRUE, risposta;
END;

CREATE OR REPLACE TRIGGER generaNotificaRisposta AFTER INSERT ON RISPOSTA
FOR EACH ROW
CALL generaNotificaRisposta(NEW.Id, NEW.Risponditore, NEW.Commento);

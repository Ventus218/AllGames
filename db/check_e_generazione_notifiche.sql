
/* GENERAZIONE AUTOMATICA DELLE NOTIFICHE */

CREATE PROCEDURE generaNotificaFollow (IN newUtenteSeguace INT, IN newUtenteSeguito INT)
BEGIN

    INSERT INTO NOTIFICA(Letta, Timestamp, Ricevente, AttoreSorgente, NotificaFollow, UtenteSeguace, UtenteSeguito, NotificaMiPiace, NotificaPostCommunity, NotificaCommento, NotificaRisposta)
        VALUE (FALSE, current_date(), newUtenteSeguito, newUtenteSeguace, TRUE, newUtenteSeguace, newUtenteSeguito, FALSE, FALSE, FALSE, FALSE);

END;

CREATE OR REPLACE TRIGGER generaNotificaFollow AFTER INSERT ON FOLLOW
FOR EACH ROW
CALL generaNotificaFollow(NEW.UtenteSeguace, NEW.UtenteSeguito);


CREATE PROCEDURE generaNotificaMiPiace (IN liker INT, IN post INT)
BEGIN

    DECLARE UtentePost INT;

    SET UtentePost = (SELECT P.Utente FROM POST P WHERE P.Id = post);

    INSERT INTO NOTIFICA(Letta, Timestamp, Ricevente, AttoreSorgente, NotificaFollow, NotificaMiPiace, Utente, Post, NotificaPostCommunity, NotificaCommento, NotificaRisposta)
        SELECT FALSE, current_date(), UtentePost, liker, FALSE, TRUE, liker, post, FALSE, FALSE, FALSE;
END;


CREATE OR REPLACE TRIGGER generaNotificaMiPiace AFTER INSERT ON MI_PIACE
FOR EACH ROW
CALL generaNotificaMiPiace(NEW.Utente, NEW.Post);


CREATE PROCEDURE generaNotificaPostCommunity (IN post INT, IN community VARCHAR(64))
BEGIN

    DECLARE UtentePost INT;

    SET UtentePost = (SELECT P.Utente FROM POST P WHERE P.Id = post);

    INSERT INTO NOTIFICA(Letta, Timestamp, Ricevente, AttoreSorgente, NotificaFollow, NotificaMiPiace, NotificaPostCommunity, PostCommunity, NotificaCommento, NotificaRisposta)
        SELECT FALSE, current_date(), PC.Utente, UtentePost, FALSE, FALSE, TRUE, post, FALSE, FALSE FROM PARTECIPAZIONE_COMMUNITY PC
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
        SELECT FALSE, current_date(), UtentePost, commentatore, FALSE, FALSE, FALSE, TRUE, commento, FALSE;
END;

CREATE OR REPLACE TRIGGER generaNotificaCommento AFTER INSERT ON COMMENTO
FOR EACH ROW
CALL generaNotificaCommento(NEW.Id, NEW.Commentatore, NEW.Post);


CREATE PROCEDURE generaNotificaRisposta (IN risposta INT, IN risponditore INT, IN commento INT)
BEGIN

    DECLARE UtenteCommento INT;

    SET UtenteCommento = (SELECT P.Utente FROM POST P JOIN COMMENTO C ON (P.Id = C.Post) WHERE C.Id = commento);

    INSERT INTO NOTIFICA(Letta, Timestamp, Ricevente, AttoreSorgente, NotificaFollow, NotificaMiPiace, NotificaPostCommunity, NotificaCommento, Commento, NotificaRisposta, Risposta)
        SELECT FALSE, current_date(), UtenteCommento, risponditore, FALSE, FALSE, FALSE, FALSE, TRUE, risposta;
END;

CREATE OR REPLACE TRIGGER generaNotificaRisposta AFTER INSERT ON RISPOSTA
FOR EACH ROW
CALL generaNotificaRisposta(NEW.Id, NEW.Risponditore, NEW.Commento);

/* CHECK FOR NOTIFICA */

CREATE PROCEDURE checkNotificaFollowConsistency(IN notifica INT)
BEGIN

    IF EXISTS   (SELECT * FROM NOTIFICA N
                WHERE N.Id = notifica AND N.NotificaFollow = TRUE AND (
                      (N.NotificaMiPiace != FALSE OR N.NotificaPostCommunity != FALSE OR N.NotificaCommento != FALSE OR N.NotificaRisposta != FALSE) OR
                      (N.Utente IS NOT NULL OR N.Post IS NOT NULL OR N.PostCommunity IS NOT NULL OR N.Commento IS NOT NULL OR N.Risposta IS NOT NULL)
                ))
    THEN
        SIGNAL SQLSTATE '45000';
    END IF;

END;

CREATE PROCEDURE checkNotificaMiPiaceConsistency(IN notifica INT)
BEGIN

    IF EXISTS   (SELECT * FROM NOTIFICA N
                WHERE N.Id = notifica AND N.NotificaMiPiace = TRUE AND (
                      (N.NotificaFollow != FALSE OR N.NotificaPostCommunity != FALSE OR N.NotificaCommento != FALSE OR N.NotificaRisposta != FALSE) OR
                      (N.UtenteSeguito IS NOT NULL OR N.UtenteSeguace IS NOT NULL OR N.PostCommunity IS NOT NULL OR N.Commento IS NOT NULL OR N.Risposta IS NOT NULL)
                ))
    THEN
        SIGNAL SQLSTATE '45000';
    END IF;

END;

CREATE PROCEDURE checkNotificaPostCommunityConsistency(IN notifica INT)
BEGIN

    IF EXISTS   (SELECT * FROM NOTIFICA N
                WHERE N.Id = notifica AND N.NotificaPostCommunity = TRUE AND (
                      (N.NotificaFollow != FALSE OR N.NotificaMiPiace != FALSE OR N.NotificaCommento != FALSE OR N.NotificaRisposta != FALSE) OR
                      (N.UtenteSeguito IS NOT NULL OR N.UtenteSeguace IS NOT NULL OR N.Utente IS NOT NULL OR N.Post IS NOT NULL OR N.Commento IS NOT NULL OR N.Risposta IS NOT NULL)
                ))
    THEN
        SIGNAL SQLSTATE '45000';
    END IF;

END;

CREATE PROCEDURE checkNotificaCommentoConsistency(IN notifica INT)
BEGIN

    IF EXISTS   (SELECT * FROM NOTIFICA N
                WHERE N.Id = notifica AND N.NotificaCommento = TRUE AND (
                      (N.NotificaFollow != FALSE OR N.NotificaMiPiace != FALSE OR N.NotificaPostCommunity != FALSE OR N.NotificaRisposta != FALSE) OR
                      (N.UtenteSeguito IS NOT NULL OR N.UtenteSeguace IS NOT NULL OR N.Utente IS NOT NULL OR N.Post IS NOT NULL OR N.NotificaPostCommunity IS NOT NULL OR N.Risposta IS NOT NULL)
                ))
    THEN
        SIGNAL SQLSTATE '45000';
    END IF;

END;


CREATE PROCEDURE checkNotificaRispostaConsistency(IN notifica INT)
BEGIN

    IF EXISTS   (SELECT * FROM NOTIFICA N
                WHERE N.Id = notifica AND N.NotificaRisposta = TRUE AND (
                      (N.NotificaFollow != FALSE OR N.NotificaMiPiace != FALSE OR N.NotificaPostCommunity != FALSE OR N.NotificaCommento != FALSE) OR
                      (N.UtenteSeguito IS NOT NULL OR N.UtenteSeguace IS NOT NULL OR N.Utente IS NOT NULL OR N.Post IS NOT NULL OR N.NotificaPostCommunity IS NOT NULL OR N.Commento IS NOT NULL)
                ))
    THEN
        SIGNAL SQLSTATE '45000';
    END IF;

END;


CREATE OR REPLACE TRIGGER checkGerarchiaNotifica_afterInsert AFTER INSERT ON NOTIFICA
    FOR EACH ROW
    BEGIN
        CALL checkNotificaFollowConsistency(NEW.Id);
        CALL checkNotificaMiPiaceConsistency(NEW.Id);
        CALL checkNotificaPostCommunityConsistency(NEW.Id);
        CALL checkNotificaCommentoConsistency(NEW.Id);
        CALL checkNotificaRispostaConsistency(NEW.Id);
    END;

CREATE OR REPLACE TRIGGER checkGerarchiaNotifica_afterUpdate AFTER UPDATE ON NOTIFICA
    FOR EACH ROW
    BEGIN
        CALL checkNotificaFollowConsistency(NEW.Id);
        CALL checkNotificaMiPiaceConsistency(NEW.Id);
        CALL checkNotificaPostCommunityConsistency(NEW.Id);
        CALL checkNotificaCommentoConsistency(NEW.Id);
        CALL checkNotificaRispostaConsistency(NEW.Id);
    END;

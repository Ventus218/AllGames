/* ADDING ON DELETE CASCADE TO IMPLEMENT COMPOSITION SEMANTIC */

alter table POST drop constraint FKAPPARTENENZA;

alter table POST add constraint FKAPPARTENENZA
     foreign key (Community)
     references COMMUNITY (Nome)
     on delete cascade;


alter table C_MULTIMEDIALE_POST drop constraint FKINTEGRAZIONE;

alter table C_MULTIMEDIALE_POST add constraint FKINTEGRAZIONE
     foreign key (Post)
     references POST (Id);
     

alter table MI_PIACE drop constraint FKPRESENZA;

alter table MI_PIACE add constraint FKPRESENZA
     foreign key (Post)
     references POST (Id)
     on delete cascade;


alter table TAG_IN_POST drop constraint FKTAGGATO;

alter table TAG_IN_POST add constraint FKTAGGATO
     foreign key (Post)
     references POST (Id)
     on delete cascade;


alter table COMMENTO drop constraint FKPOSSESSO;

alter table COMMENTO add constraint FKPOSSESSO
     foreign key (Post)
     references POST (Id)
     on delete cascade;


alter table RISPOSTA drop constraint FKRICEZIONE;

alter table RISPOSTA add constraint FKRICEZIONE
     foreign key (Commento)
     references COMMENTO (Id)
     on delete cascade;


/* ADDING ON DELETE SET NULL FOR NOTIFICA FOREIGN KEYS */

alter table NOTIFICA drop constraint FKGENERA_N_FOLLOW_FK;

alter table NOTIFICA add constraint FKGENERA_N_FOLLOW_FK
     foreign key (UtenteSeguace, UtenteSeguito)
     references FOLLOW (UtenteSeguace, UtenteSeguito)
     on delete set null;


alter table NOTIFICA drop constraint FKGENERA_N_MI_PIACE_FK;

alter table NOTIFICA add constraint FKGENERA_N_MI_PIACE_FK
     foreign key (Utente, Post)
     references MI_PIACE (Utente, Post)
     on delete set null;


alter table NOTIFICA drop constraint FKGENERA_N_POST_COMM;

alter table NOTIFICA add constraint FKGENERA_N_POST_COMM
     foreign key (PostCommunity)
     references POST (Id)
     on delete set null;


alter table NOTIFICA drop constraint FKGENERA_N_COMMENTO;

alter table NOTIFICA add constraint FKGENERA_N_COMMENTO
     foreign key (Commento)
     references COMMENTO (Id)
     on delete set null;


alter table NOTIFICA drop constraint FKGENERA_N_RISPOSTA;

alter table NOTIFICA add constraint FKGENERA_N_RISPOSTA
     foreign key (Risposta)
     references RISPOSTA (Id)
     on delete set null;


/* CHECKS FOR NOTIFICA */

CREATE PROCEDURE checkNotificaFollowConsistency(IN notifica INT)
BEGIN

    IF EXISTS   (SELECT * FROM NOTIFICA N
                WHERE N.Id = notifica AND N.NotificaFollow = TRUE AND (
                      (N.NotificaMiPiace != FALSE OR N.NotificaPostCommunity != FALSE OR N.NotificaCommento != FALSE OR N.NotificaRisposta != FALSE) OR
                      (N.Utente IS NOT NULL OR N.Post IS NOT NULL OR N.PostCommunity IS NOT NULL OR N.Commento IS NOT NULL OR N.Risposta IS NOT NULL)
                ))
    THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'checkNotificaFollowConsistency failed';
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
        SIGNAL SQLSTATE '45001' SET MESSAGE_TEXT = 'checkNotificaMiPiaceConsistency failed';
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
        SIGNAL SQLSTATE '45002' SET MESSAGE_TEXT = 'checkNotificaPostCommunityConsistency failed';
    END IF;

END;

CREATE PROCEDURE checkNotificaCommentoConsistency(IN notifica INT)
BEGIN

    IF EXISTS   (SELECT * FROM NOTIFICA N
                WHERE N.Id = notifica AND N.NotificaCommento = TRUE AND (
                      (N.NotificaFollow != FALSE OR N.NotificaMiPiace != FALSE OR N.NotificaPostCommunity != FALSE OR N.NotificaRisposta != FALSE) OR
                      (N.UtenteSeguito IS NOT NULL OR N.UtenteSeguace IS NOT NULL OR N.Utente IS NOT NULL OR N.Post IS NOT NULL OR N.PostCommunity IS NOT NULL OR N.Risposta IS NOT NULL)
                ))
    THEN
        SIGNAL SQLSTATE '45003' SET MESSAGE_TEXT = 'checkNotificaCommentoConsistency failed';
    END IF;

END;


CREATE PROCEDURE checkNotificaRispostaConsistency(IN notifica INT)
BEGIN

    IF EXISTS   (SELECT * FROM NOTIFICA N
                WHERE N.Id = notifica AND N.NotificaRisposta = TRUE AND (
                      (N.NotificaFollow != FALSE OR N.NotificaMiPiace != FALSE OR N.NotificaPostCommunity != FALSE OR N.NotificaCommento != FALSE) OR
                      (N.UtenteSeguito IS NOT NULL OR N.UtenteSeguace IS NOT NULL OR N.Utente IS NOT NULL OR N.Post IS NOT NULL OR N.PostCommunity IS NOT NULL OR N.Commento IS NOT NULL)
                ))
    THEN
        SIGNAL SQLSTATE '45004' SET MESSAGE_TEXT = 'checkNotificaRispostaConsistency failed';
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


/* AUTOMATICALLY DELETING TAG IF IT'S NOT USED IN ANY POST */

CREATE PROCEDURE deleteUnusedTags()
BEGIN

    DELETE FROM TAG
    WHERE Nome NOT IN (SELECT DISTINCT TIP.Tag FROM TAG_IN_POST TIP);

END;

CREATE OR REPLACE TRIGGER deleteUnusedTags_DELETE AFTER DELETE ON POST
FOR EACH ROW
CALL deleteUnusedTags();

/*
// TAG_IN_POST UPDATE IS NOT POSSIBLE WITH CURRENT SPECIFICATIONS
CREATE OR REPLACE TRIGGER deleteUnusedTags_UPDATE AFTER UPDATE ON TAG_IN_POST
FOR EACH ROW
CALL deleteUnusedTags(); */


/* CHECKING ACCEPTED VALUES FOR UTENTE.Genere */

ALTER TABLE UTENTE
ADD CHECK ( Genere = 'M' OR Genere = 'F' OR Genere = 'U');


/* CHECKING THAT THE USER WHICH IS POSTING INSIDE A COMMUNITY IS A MEMBER OF THE COMMUNITY */

CREATE PROCEDURE checkPostCommunityIsAllowed(IN utente INT, IN community VARCHAR(64))
BEGIN

    IF NOT EXISTS   (SELECT * FROM PARTECIPAZIONE_COMMUNITY PC
                    WHERE PC.Utente = Utente
                    AND PC.Community = community)
    THEN
        SIGNAL SQLSTATE '45005' SET MESSAGE_TEXT = 'user not allowed to post in this community';
    END IF;

END;

CREATE OR REPLACE TRIGGER checkPostCommunityIsAllowed BEFORE INSERT ON POST
    FOR EACH ROW
    BEGIN
        IF NEW.Community IS NOT NULL THEN
            CALL checkPostCommunityIsAllowed(NEW.Utente, NEW.Community);
        END IF;
    END;

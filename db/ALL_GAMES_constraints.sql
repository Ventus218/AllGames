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
        SIGNAL SQLSTATE '45001';
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
        SIGNAL SQLSTATE '45002';
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
        SIGNAL SQLSTATE '45003';
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
        SIGNAL SQLSTATE '45004';
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

CREATE PROCEDURE deleteTagIfUnused(IN tag VARCHAR(32))
BEGIN

    IF NOT EXISTS   (SELECT * FROM TAG_IN_POST T
                    WHERE T.Tag = tag)
    THEN
        DELETE FROM TAG
        WHERE Nome = tag;
    END IF;

END;

CREATE OR REPLACE TRIGGER deleteTagIfUnused_DELETE AFTER DELETE ON TAG_IN_POST
FOR EACH ROW
CALL deleteTagIfUnused(OLD.Tag);

CREATE OR REPLACE TRIGGER deleteTagIfUnused_UPDATE AFTER UPDATE ON TAG_IN_POST
FOR EACH ROW
CALL deleteTagIfUnused(OLD.Tag);


/* CHECKING ACCEPTED VALUES FOR UTENTE.Genere */

ALTER TABLE UTENTE
ADD CHECK ( Genere = 'M' OR Genere = 'F' OR Genere = 'U');

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


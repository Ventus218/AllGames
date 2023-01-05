-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 10.0.3              
-- * Generator date: Aug 17 2017              
-- * Generation date: Sun Dec 18 21:23:14 2022 
-- * LUN file: C:\Users\Alessandro Venturini\Desktop\AllGames\db\ALL_GAMES.lun 
-- * Schema: ALL_GAMES/1-1-1 
-- ********************************************* 


-- Database Section
-- ________________ 

create database ALL_GAMES;
use ALL_GAMES;


-- Tables Section
-- _____________ 

create table C_MULTIMEDIALE_POST (
     Url varchar(256) not null,
     Ordine char(1) not null,
     Post int not null,
     Video char not null,
     Immagine char not null,
     constraint IDC_MULTIMEDIALE_POST primary key (Url));

create table COMMENTO (
     Id int not null auto_increment,
     Testo varchar(512) not null,
     Timestamp datetime not null,
     Post int not null,
     Commentatore int not null,
     constraint IDCOMMENTO_ID primary key (Id));

create table COMMUNITY (
     Nome varchar(64) not null,
     UrlImmagine varchar(256) not null,
     Fondatore int not null,
     constraint IDCOMMUNITY primary key (Nome));

create table FOLLOW (
     UtenteSeguace int not null,
     UtenteSeguito int not null,
     constraint IDFOLLOW_ID primary key (UtenteSeguace, UtenteSeguito));

create table MI_PIACE (
     Post int not null,
     Utente int not null,
     constraint IDMI_PIACE_ID primary key (Utente, Post));

create table NOTIFICA (
     Id int not null auto_increment,
     Letta char not null,
     Timestamp datetime not null,
     Ricevente int not null,
     AttoreSorgente int not null,
     NotificaFollow char not null,
     UtenteSeguace int,
     UtenteSeguito int,
     NotificaMiPiace char not null,
     Utente int,
     Post int,
     NotificaPostCommunity char not null,
     PostCommunity int,
     NotificaCommento char not null,
     Commento int,
     NotificaRisposta char not null,
     Risposta int,
     constraint IDNOTIFICA primary key (Id));

create table PARTECIPAZIONE_COMMUNITY (
     Community varchar(64) not null,
     Utente int not null,
     constraint IDPARTECIPAZIONE_COMMUNITY primary key (Community, Utente));

create table POST (
     Id int not null auto_increment,
     Testo varchar(2048) not null,
     Timestamp datetime not null,
     Utente int not null,
     Community varchar(64),
     constraint IDPOST primary key (Id));

create table RISPOSTA (
     Id int not null auto_increment,
     Testo varchar(512) not null,
     Timestamp datetime not null,
     Risponditore int not null,
     Commento int not null,
     constraint IDRISPOSTA_ID primary key (Id));

create table TAG (
     Nome varchar(32) not null,
     constraint IDTAG_ID primary key (Nome));

create table TAG_IN_POST (
     Tag varchar(32) not null,
     Post int not null,
     constraint IDTAG_IN_POST primary key (Tag, Post));

create table UTENTE (
     Id int not null auto_increment,
     Username varchar(32) not null,
     PasswordHash varchar(128) not null,
     Nome varchar(32) not null,
     Cognome varchar(32) not null,
     DataNascita datetime not null,
     Genere char(1) not null,
     Email varchar(128) not null,
     Telefono varchar(32) not null,
     UrlImmagine varchar(256),
     constraint IDUTENTE primary key (Id),
     constraint IDUTENTE_1 unique (Username),
     constraint IDUTENTE_2 unique (Email));


-- Constraints Section
-- ___________________ 

alter table C_MULTIMEDIALE_POST add constraint FKINTEGRAZIONE
     foreign key (Post)
     references POST (Id);

-- Not implemented
-- alter table COMMENTO add constraint IDCOMMENTO_CHK
--     check(exists(select * from NOTIFICA
--                  where NOTIFICA.Commento = Id)); 

alter table COMMENTO add constraint FKPOSSESSO
     foreign key (Post)
     references POST (Id);

alter table COMMENTO add constraint FKCOMMENTA
     foreign key (Commentatore)
     references UTENTE (Id);

alter table COMMUNITY add constraint FKFONDAZIONE
     foreign key (Fondatore)
     references UTENTE (Id);

-- Not implemented
-- alter table FOLLOW add constraint IDFOLLOW_CHK
--     check(exists(select * from NOTIFICA
--                  where NOTIFICA.UtenteSeguace = UtenteSeguace and NOTIFICA.UtenteSeguito = UtenteSeguito)); 

alter table FOLLOW add constraint FKSEGUITO
     foreign key (UtenteSeguito)
     references UTENTE (Id);

alter table FOLLOW add constraint FKSEGUACE
     foreign key (UtenteSeguace)
     references UTENTE (Id);

-- Not implemented
-- alter table MI_PIACE add constraint IDMI_PIACE_CHK
--     check(exists(select * from NOTIFICA
--                  where NOTIFICA.Utente = Utente and NOTIFICA.Post = Post)); 

alter table MI_PIACE add constraint FKESPRESSIONE
     foreign key (Utente)
     references UTENTE (Id);

alter table MI_PIACE add constraint FKPRESENZA
     foreign key (Post)
     references POST (Id);

alter table NOTIFICA add constraint FKRICEZIONE_NOTIFICA
     foreign key (Ricevente)
     references UTENTE (Id);

alter table NOTIFICA add constraint FKATTORE_EVENTO
     foreign key (AttoreSorgente)
     references UTENTE (Id);

alter table NOTIFICA add constraint FKGENERA_N_FOLLOW_FK
     foreign key (UtenteSeguace, UtenteSeguito)
     references FOLLOW (UtenteSeguace, UtenteSeguito);

alter table NOTIFICA add constraint FKGENERA_N_FOLLOW_CHK
     check((UtenteSeguace is not null and UtenteSeguito is not null)
           or (UtenteSeguace is null and UtenteSeguito is null)); 

alter table NOTIFICA add constraint FKGENERA_N_MI_PIACE_FK
     foreign key (Utente, Post)
     references MI_PIACE (Utente, Post);

alter table NOTIFICA add constraint FKGENERA_N_MI_PIACE_CHK
     check((Utente is not null and Post is not null)
           or (Utente is null and Post is null)); 

alter table NOTIFICA add constraint FKGENERA_N_POST_COMM
     foreign key (PostCommunity)
     references POST (Id);

alter table NOTIFICA add constraint FKGENERA_N_COMMENTO
     foreign key (Commento)
     references COMMENTO (Id);

alter table NOTIFICA add constraint FKGENERA_N_RISPOSTA
     foreign key (Risposta)
     references RISPOSTA (Id);

alter table PARTECIPAZIONE_COMMUNITY add constraint FKPAR_UTE
     foreign key (Utente)
     references UTENTE (Id);

alter table PARTECIPAZIONE_COMMUNITY add constraint FKPAR_COM
     foreign key (Community)
     references COMMUNITY (Nome);

alter table POST add constraint FKPUBBLICAZIONE
     foreign key (Utente)
     references UTENTE (Id);

alter table POST add constraint FKAPPARTENENZA
     foreign key (Community)
     references COMMUNITY (Nome);

-- Not implemented
-- alter table RISPOSTA add constraint IDRISPOSTA_CHK
--     check(exists(select * from NOTIFICA
--                  where NOTIFICA.Risposta = Id)); 

alter table RISPOSTA add constraint FKRISPONDE
     foreign key (Risponditore)
     references UTENTE (Id);

alter table RISPOSTA add constraint FKRICEZIONE
     foreign key (Commento)
     references COMMENTO (Id);

-- Not implemented
-- alter table TAG add constraint IDTAG_CHK
--     check(exists(select * from TAG_IN_POST
--                  where TAG_IN_POST.Tag = Nome)); 

alter table TAG_IN_POST add constraint FKTAGGATO
     foreign key (Post)
     references POST (Id);

alter table TAG_IN_POST add constraint FKRIFERIMENTO
     foreign key (Tag)
     references TAG (Nome);


-- Index Section
-- _____________ 


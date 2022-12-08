# Documento di progettazione - **AllGames🕹️**


## Mockup
Per aiutarsi nella creazione dei mockup si è scelto di definire delle [Personas](Personas.md). 


## Database

La scelta di utilizzare un DBMS relazionale quale MySQL è dettata dallo stack XAMPP.

Di seguito i diagrammi utilizzati per realizzare il database.

### Schema ER
![Database - Schema ER](./img/db/Schema%20ER.png)

### Schema Logico
![Database - Schema Logico](./img/db/Schema%20Logico.png)
Per tutte le generalizzazioni è stato scelto di accorpare le entità e utilizzare dei selettori booleani per distinguere le sottoclassi.

### Schema Relazionale
![Database - Schema Relazionale](./img/db/Schema%20Relazionale.png)

### SQL
Grazie al tool DB-Main si è genrato automaticamente uno [script SQL](./db/ALL_GAMES_DDL.sql) per la creazione del database, // DA FARE ---> al quale sono stati aggiunti manualmente alcune query per la realizzazione dei vincoli persi durante la modellazione.

Sono inoltre stati aggiunti dei trigger per la generazione delle notifiche in maniera da rendere il tutto più efficiente e trasparente al server. <--- DA FARE //
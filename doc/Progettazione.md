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
Grazie al tool DB-Main si è genrato automaticamente uno script SQL ([ALL_GAMES_DDL](../db/ALL_GAMES_DDL.sql)) per la creazione del database.

Si sono scritti inoltre i seguenti script SQL:
- [ALL_GAMES_constraints](../db/ALL_GAMES_constraints.sql) che ha tre compiti
    - Implementa la semantica della relazione di composizione creando un vincolo di *ON DELETE CASCADE* sulle relazioni che lo necessitano.
    - Controlla la consistenza delle tuple di NOTIFICA, in quanto scegliendo di collassare verso l'alto la gerarchia si rischia di avere inserimenti inconsistenti.
    - Implementa, utlizzando un trigger che elimina il TAG se non sono più presenti TAG_IN_POST a lui relativi, il vincolo di cardinalità minima secondo il quale ogni TAG deve avere almeno un TAG_IN_POST.
- [generazione_notifiche](../db/generazione_notifiche.sql) crea dei trigger che effettuano la generazione automatica delle notifiche allo scattare degli eventi di rilievo (follow, mi piace, etc...)

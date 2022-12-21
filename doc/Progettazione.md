# Documento di progettazione - **AllGames🕹️**


## Mockup
Per aiutarsi nella creazione dei mockup si è scelto di definire delle [Personas](Personas.md). 


## Stack di sviluppo
XAMPP è lo stack più aderente alle specifiche fornite per il progetto.

Almeno durante le fasi di progettazione, sviluppo e testing risulta comodo utilizzare Docker per poter utilizzare in maniera semplice e leggera lo stack xampp.

Di seguito lo script per eseguire il container, esso espone le porte http e ssh del container, e monta come volumi una directory contenente il il sito web e una contenente gli script SQL per inizializzare il database.
```sh
docker run --name xampp -p 41061:22 -p 8080:80 -d -v <path-to-website>:/www -v <path-to-db-scripts>:/allgames/db/scripts tomsik68/xampp
```

Sembra inoltre necessario eseguire il seguente comando subito dopo aver avviato il container, risolve alcuni errori riscontrati dal DBMS.
```sh
docker exec xampp /opt/lampp/bin/mysql_upgrade
```


## Database

La scelta di utilizzare un DBMS relazionale quale MySQL (MariaDB) è dettata dallo stack XAMPP.

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

### Contenuti multimediali
Dei contenuti multimediali sul database viene salvato solamente l'URL e non i dati che invece verranno salvati sul file system.
Questo significa che se viene eliminata una tupla nel database riguardante un contenuto multimediale bisogna assicurarsi di eliminarlo anche dal file system.

## FrontEnd

La scelta di utilizzare il Bootstrap per il CSS è stata fatta principalmente per poter realizzare il sito più velocemente.

Per JavaScript non si usa alcun framework o libreria.

### JavaScript

Il file JavaScript sliding.js necessita delle classi di Bootstrap per esempio per cambiare il display a dei tag di HTML 
(oppure bisognerebbe crearsi delle classi CSS da zero che siano il più simili possibile e con lo stesso nome di quelle del bootstrap usate dagli script, il che non è un'ottima idea).

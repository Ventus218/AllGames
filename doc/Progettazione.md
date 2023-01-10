# Documento di progettazione - **AllGames🕹️**


## Mockup
Per aiutarsi nella creazione dei mockup si è scelto di definire delle [Personas](Personas.md). 


## Stack di sviluppo
XAMPP è lo stack più aderente alle specifiche fornite per il progetto.

Almeno durante le fasi di progettazione, sviluppo e testing risulta comodo utilizzare Docker per poter utilizzare in maniera semplice e leggera lo stack xampp.

Di seguito lo script per eseguire il container, esso espone le porte http e ssh del container, e monta come volumi una directory contenente il il sito web e una contenente gli script SQL per inizializzare il database.
```sh
docker run -d --name xampp \
-p <port-for-ssh-access>:22 \
-p <host-port>:80 \
-v <path-to-website-folder>:/www \
-v <path-to-db-sql-scripts-folder>:/allgames/db/scripts \
-v <path-to-sample-data-folder>:/allgames/sample-data \
tomsik68/xampp
```

Il sito sarà quindi accessibile a *localhost:\<host-port\>/www*

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

Per quanto riguarda JavaScript si è utilizzata la libreria [axios](https://axios-http.com) per avere un approccio semplificato ad ajax.

### JavaScript

Il file JavaScript slider.js necessita delle classi di Bootstrap per esempio per cambiare il display a dei tag di HTML 
(oppure bisognerebbe crearsi delle classi CSS da zero che siano il più simili possibile e con lo stesso nome di quelle del bootstrap usate dagli script, il che non è un'ottima idea).

## BackEnd

### Struttura della directory servita da Xampp
```
website
├── pagine php
├── api
│   └── file php per le api utilizzate via ajax
├── db
│   ├── classi php per la gestione del database
│   ├── model
│   │   └── classi php DAO
│   └── scripts
│       └── script php utili in fase di development
├── multimedia-db
│   └── immagini e video degli utenti
├── inc
│   ├── css
│   │   └── fogli di stile
│   ├── img
│   │   └── immagini statiche
│   ├── js
│   │   └── file javascript
│   └── php
│       └── utility php
└── templates
    └── file template php
```

Si è deciso quindi che tutte le pagine del sito raggiunte direttamente dall'utente si trovino alla radice della struttura. E' importante effettuare questa scelta per aver chiaro come gestire gli indirizzi relativi all'interno delle pagine che, in questo modo, saranno sempre relativi alla radice.

Tutte le pagine nella radice richiederanno il file bootstrap nel quale sono inizializzate le variabili che sono sempre necessarie (il database ad esempio).

### Accesso al database
Si è realizzata una classe [Database](../website/db/Database.php) che offre dei metodi molto generici per interagire con il database. L'idea è che questa classe non venga usata direttamente ma che invece funga da fondamenta alle classi [DAO](../website/db/model) e a [DatabaseHelper](../website/db/DatabaseHelper.php).

Per realizzare il pattern DAO si sono utilizzate diverse classi *DTO (Data Tranfer Object)*, una per ogni operazione eseguibile per entità.

Ad esempio siccome deve essere possibile richiedere, creare e aggiornare un utente si sono quindi create le classi `UtenteDTO`, `UtenteUpdateDTO` e `UtenteCreateDTO` (vedi [Utente.php](../website/db/model/Utente.php)). Ognuna di queste fornisce il metodo per eseguire l'operazione in questione e ne incapsula tutti i dati necessari.
Invece per quanto riguarda le community che non possono essere modificate non è stata creata la classe `CommunityUpdateDTO` (vedi [Community.php](../website/db/model/Community.php)).

Inoltre per ogni entità si è creata una classe contenente le stringhe per l'accesso agli attributi nel database, e si è cercato in tutta l'applicazione di utilizzare queste classi in maniera da tenere in unico posto queste stringhe ed evitare fastidiosi errori di scrittura o di refactoring.

In ogni caso si è scelto di accedere al database sempre attraverso la classe [DatabaseHelper](../website/db/DatabaseHelper.php) la quale incapsula le operazioni con il database, in modo da poter implementare nelle pagine php alla radice solo e unicamente la logica applicativa.

<details>
<summary> Dettagli sulle query più complesse </summary>

Per quanto riguarda le query più complesse, come quelle che necessitano join su più tabelle, oppure per quelle operazioni per cui si vuole il massimo delle prestazioni, è possibile scrivere manualmente la query ed eseguirla sulla classe [Database](../website/db/Database.php), si noti però che fintanto che è possibile selezionare gli attributi di solo un'entità allora è anche possibile trasformare il risultato nel rispettivo DTO.

Si prenda come esempio la seguente [operazione](../website/db/DatabaseHelper.php#L91) di **DatabaseHelper** per ottenere i contenuti multimediali di un dato post:
```php
public function getContenutiMultimedialiOfPost(PostDTO $post): array {

    $query = "SELECT C.*
        FROM ".Schemas::POST->value." P
        JOIN ".Schemas::CONTENUTO_MULTIMEDIALE_POST->value." C
        ON(P.".PostKeys::id." = C.".ContenutoMultimedialePostKeys::post.")
        WHERE P.".PostKeys::id." = ?
        ORDER BY C.".ContenutoMultimedialePostKeys::ordine." ASC";

    $rows = $this->db->executeQuery($query, array($post->id));

    return array_map(function($row) {
        return ContenutoMultimedialePostDTO::fromDBRow($row);
    }, $rows);
}
```
È possibile gestire i join, le condizioni e l'ordinamento senza rinunciare all'utilizzo del DTO che permette di utilizzare le classi php al posto degli array associativi che non sono tipizzati e quindi maggiormente esposti ad errori.

</details>

### Script per facilitare lo sviluppo
Si sono realizzati degli script per [autenticare un amministratore](../website/db/scripts/authenticateAdmin.php), [resettare il database](../website/db/scripts/resetDB.php) e [caricare un database di esempio](../website/db/scripts/loadSampleDB.php).

Il primo script serve a inserire un piccolo strato di sicurezza sugli altri due che, anche se non verrano serviti in fase di produzione, possono alterare definitivamente il database.

Gli altri due script facilitano la fase di sviluppo e testing in quanto consentono di avere sempre il database in uno stato ben noto e consistente.

### Gestione della sessione
In [session.php](../website/inc/php/session.php) è possibile trovare tutti i metodi per la gestione della sessione.

In particolare si è deciso che ogni pagina si occuperà, se necessario, di controllare se l'utente ha una sessione attiva e nel caso non fosse così ridirigerlo alla pagina di login. Nel caso del reindirizzamento viene inoltre settato un parametro che permetterà, una volta eseguito il login, di tornare sulla pagina inizialmente richiesta.

Si è deciso inoltre di implementare un meccanismo che consente di far scadere la sessione dell'utente dopo un certo tempo di inattività (ad esempio 30 minuti).

### Templates PHP
Si è tentato di ridurre al minimo la duplicazione del codice, infatti il feed dei post che viene presentato in diverse pagine è stato parametrizzato e fattorizzato nell'unico file [feed.php](../website/templates/feed.php).

Stessa cosa vale per il "[container](../website/templates/container.php)" ovvero le barre superiore e inferiore del sito che sono presenti nella maggior parte delle pagine.

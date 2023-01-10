# Discussione elaborato - **[AllGames🕹️](https://github.com/Ventus218/AllGames)**

## Raccolta requisiti
- Registrazione
- Login
- Gestione sicura delle password
- Pagina *feed* 
    - Post personali degli utenti seguiti
    - Post community delle persone nelle mie stesse community
    - Possibilità di mettere like
    - Commenti dei post più possibilità di aggiungerne
    - Risposte ai commenti nei post
    - Sezione notifiche
- Pagina gestione delle community
    - Fondare community
    - Ricerca community
- Il fondatore di ogni community viene memorizzato
- Pagina profilo personale
    - Post personali (più opzione per eliminare)
    - Aggiunta post (testo, zero o più contenuti multimediali, zero o più tag)
    - Numero di follow
    - Numero di follower
    - Lista community
    - Collegamento alla pagina delle impostazioni del profilo
- Pagina profilo altro utente
    - Post dell'utente
    - Numero di follow
    - Numero di follower
    - Bottone follow/unfollow
    - Lista community
- Pagina community
    - Feed community
    - Unisciti community
    - Lascia community
- Pagina impostazioni
    - Modifica password, nome utente, immagine profilo, email, numero di telefono, data di nascita e genere
    - Logout
- Per ogni post è possibile mettere mi piace (anche ai propri)
- Cliccare sul tag di un post porta ad una pagina con tutti i post con quel tag (esclusi quelli nelle community che l'utente non segue)
- Notifiche
    - Da memorizzare se è letta oppure no
    - Vengono inviate in caso di:
        - Follow al mio profilo
        - Commento ad un mio post
        - Like ad un mio post
        - Nuovo post in una community che seguo
        - Risposta ad un mio commento

### Effetti WOW
- Gestione sicura delle password
- Community
- Mi piace 👍🏻 con AJAX
- Tag (Etichette)
- Cambio password via web

## Analisi
### Diagramma dei casi d'uso
![Diagramma dei casi d'uso](img/AllGames%20-%20Diagramma%20dei%20casi%20uso.png)

### Diagramma delle classi
![Diagramma delle classi](img/AllGames%20-%20Diagramma%20delle%20classi.png)

## Progettazione
### Mockup
Per aiutarsi nella creazione dei mockup si è scelto di definire delle [Personas](https://github.com/Ventus218/AllGames/blob/main/doc/Personas.md).

- [Mockup mobile](https://github.com/Ventus218/AllGames/tree/main/doc/img/Mockup-Mobile)
- [Mockup PC](https://github.com/Ventus218/AllGames/tree/main/doc/img/Mockup-PC)

### Database
La scelta di utilizzare un DBMS relazionale quale MySQL (MariaDB) è dettata dallo stack XAMPP.

#### Schema Relazionale
<img src="img/db/Schema%20Relazionale.png" style="width: 80%; margin-left: 10%; margin-right: 10%;" alt="Schema Relazionale">

#### SQL
La realizzazione dei vincoli e la generazione delle notifiche sono stati implementati grazie a dei *TRIGGER* SQL

#### Contenuti multimediali
Dei contenuti multimediali sul database viene salvato solamente l'URL e non i dati che invece verranno salvati sul file system.

### FrontEnd
La scelta di utilizzare il Bootstrap per il CSS è stata fatta principalmente per poter realizzare il sito più velocemente.

Per quanto riguarda JavaScript si è utilizzata la libreria [axios](https://axios-http.com) per avere un approccio semplificato ad ajax.


### BackEnd
#### Struttura della directory servita da Xampp
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

#### Accesso al database
Si è realizzata una classe [Database](https://github.com/Ventus218/AllGames/blob/main/website/db/Database.php) che offre dei metodi molto generici per interagire con il database. L'idea è che questa classe non venga usata direttamente ma che invece funga da fondamenta alle classi [DAO](https://github.com/Ventus218/AllGames/tree/main/website/db/model) e a [DatabaseHelper](https://github.com/Ventus218/AllGames/blob/main/website/db/DatabaseHelper.php).

#### Script per facilitare lo sviluppo
Si sono realizzati degli script per [autenticare un amministratore](https://github.com/Ventus218/AllGames/blob/main/website/db/scripts/authenticateAdmin.php), [resettare il database](https://github.com/Ventus218/AllGames/blob/main/website/db/scripts/resetDB.php) e [caricare un database di esempio](https://github.com/Ventus218/AllGames/blob/main/website/db/scripts/loadSampleDB.php).

#### Gestione della sessione
In [session.php](https://github.com/Ventus218/AllGames/blob/main/website/inc/php/session.php) è possibile trovare tutti i metodi per la gestione della sessione.

#### Templates PHP
Si è tentato di ridurre al minimo la duplicazione del codice, infatti il feed dei post che viene presentato in diverse pagine è stato parametrizzato e fattorizzato nell'unico file [feed.php](https://github.com/Ventus218/AllGames/blob/main/website/templates/feed.php).

Stessa cosa vale per il "[container](https://github.com/Ventus218/AllGames/blob/main/website/templates/container.php)" ovvero le barre superiore e inferiore del sito che sono presenti nella maggior parte delle pagine.

## Link alla documentazione completa
- [Raccolta dei requisiti](https://github.com/Ventus218/AllGames/blob/main/doc/Requisiti.md)
- [Analisi dei requisiti](https://github.com/Ventus218/AllGames/blob/main/doc/Analisi.md)
- [Progettazione](https://github.com/Ventus218/AllGames/blob/main/doc/Progettazione.md)

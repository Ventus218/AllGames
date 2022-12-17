<?php

    enum Schemas: string {
        case UTENTE = "UTENTE";
        case COMMUNITY = "COMMUNITY";
        case PARTECIPAZIONE_COMMUNITY = "PARTECIPAZIONE_COMMUNITY";
        case FOLLOW = "FOLLOW";
        case TAG = "TAG";
        case POST = "POST";
        case TAG_IN_POST = "TAG_IN_POST";
        case CONTENUTO_MULTIMEDIALE_POST = "C_MULTIMEDIALE_POST";
    }

?>

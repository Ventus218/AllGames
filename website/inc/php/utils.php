<?php

    define('MULTIMEDIA_DB', './multimedia-db/');

    /**
    * Must be called before any output.
    * An exception can be given as parameter for debugging purposes.
    */
    function internalServerError(?string $message = null, Exception $error = null) {
        header('HTTP/1.1 500 Internal Server Error');
        if (is_null($message)) {
            $message = "Si è verificato un errore...";
        }

        if (isset($error)) {
            $message = $message."\nERROR: ".$error->__toString();
        }
        exit($message);
    }

    function authenticateAdminOrAbort() {
        /* AUTHORIZATION https://www.php.net/manual/en/features.http-auth.php */
        if (!isset($_SERVER["PHP_AUTH_USER"]) || !isset($_SERVER["PHP_AUTH_PW"])) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        }
        if ($_SERVER["PHP_AUTH_USER"] !== "admin" || $_SERVER["PHP_AUTH_PW"] !== "passw") {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        }
    }

    function dateTimeFromSQLDate(string $sqlDate): DateTime {
        $dt = new DateTime($sqlDate, new DateTimeZone("UTC"));
        $dt->setTimezone(new DateTimeZone(date_default_timezone_get()));
        return $dt;
    }

    function sqlDateFromDateTime(DateTime $dateTime): string {
        $dateTime->setTimezone(new DateTimeZone("UTC"));
        return $dateTime->format('Y-m-d H:i:s');
    }

    function getTimeAgoFrom(DateTime $d): string {
        $interval = $d->diff(new DateTime('now', $d->getTimezone()), true);

        if ($interval->y >= 2) {
            return $interval->y." anni fa";
        } else if ($interval->y == 1) {
            return $interval->y." anno fa";
        } else if ($interval->m >= 2) {
            return $interval->m." mesi fa";
        } else if ($interval->m == 1) {
            return $interval->m." mese fa";
        } else if ($interval->d >= 2) {
            return $interval->d." giorni fa";
        } else if ($interval->d == 1) {
            return $interval->d." giorno fa";
        } else if ($interval->h >= 2) {
            return $interval->h." ore fa";
        } else if ($interval->h == 1) {
            return $interval->h." ora fa";
        } else if ($interval->i >= 2) {
            return $interval->i." minuti fa";
        } else if ($interval->i == 1) {
            return $interval->i." minuto fa";
        } else if ($interval->s >= 2) {
            return $interval->s." secondi fa";
        } else if ($interval->s == 1) {
            return $interval->s." secondo fa";
        } else {
            return "adesso";
        }
    }

    function escapeSpacesForURIParam(string $param): string {
        return str_replace(" ", "%20", $param);
    }

    function getMultimediaURL(string $filename): string {
        return MULTIMEDIA_DB.$filename;
    }

    function getTypeOfMultimedia($multimedia): string {
        if (function_exists('finfo_open')) {

            $finfo = finfo_open(FILEINFO_MIME);
            $mime = finfo_file($finfo, $multimedia["tmp_name"]);
            finfo_close($finfo); 
        } else if (function_exists('mime_content_type')) {
            $mime = mime_content_type($multimedia["tmp_name"]);
        }

        return $mime;
    }

    function uploadMultimedia($multimedia){
        $multimediaName = uniqid().".".strtolower(pathinfo(basename($multimedia["name"]),PATHINFO_EXTENSION));
        $fullPath = MULTIMEDIA_DB.$multimediaName;
        
        $result = 0;
        $msg = "";
        $type="img";

        //Trovo il tipo del multimedia
        $mime = getTypeOfMultimedia($multimedia);
        $acceptedExtensions = array("jpg", "jpeg", "png");
        
        if(strstr($mime, "video/")) {
            $acceptedExtensions = array("mp4");
            $maxKB = 100000;

            //Controllo dimensione del video < 100000KB
            if ($multimedia["size"] > $maxKB * 1024) {
                $msg .= "Il file caricato pesa troppo! La dimensione massima è $maxKB KB. ";
            }

            $type = "video";

        } else if(strstr($mime, "image/")) {
            $maxKB = 5000;
            
            //Controllo dimensione dell'immagine < 5000KB
            if ($multimedia["size"] > $maxKB * 1024) {
                $msg .= "Il file caricato pesa troppo! La dimensione massima è $maxKB KB. ";
            }
        }
        
        //Controllo estensione del file
        $multimediaFileType = strtolower(pathinfo($fullPath,PATHINFO_EXTENSION));
        if(!in_array($multimediaFileType, $acceptedExtensions)){
            $msg .= "Accettate solo le seguenti estensioni: ".implode(",", $acceptedExtensions)." per il tipo: ".$type;
        }
    
        //Se non ci sono errori, sposto il file dalla posizione temporanea alla cartella di destinazione
        if(strlen($msg)==0){
            if(!move_uploaded_file($multimedia["tmp_name"], $fullPath)){
                $msg.= "Errore nel caricamento del multimedia.";
            }
            else{
                $result = 1;
                $msg = $multimediaName;
            }
        }

        return array("result" => $result, "msg" => $msg, "type" => $type);
    }

    function deleteMultimedia(string $filename): bool {
        return unlink(MULTIMEDIA_DB.$filename);
    }

    /*
        Funzione presa dalle note dei contributori della documentazione ufficiale di PHP, serve a far diventare l'array di $_FILES più "intuitivo":
        in caso di più file all'interno di $_FILES, $_FILES presenta nella prima posizione tutti i nomi dei vari file, e così via
        con questa funzione invece alla prima posizione si trovano tutte le informazioni del primo file, alla seconda quelle del secondo file ecc.
    */
    function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
    
        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
    
        return $file_ary;
    }
?>

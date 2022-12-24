<?php

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        exit("Si accettano solo richieste POST.");
    }
    require_once("./authenticateAdmin.php");
    require_once("../../inc/php/auth.php");

    require_once("../Database.php");
    foreach (glob("../model/*.php") as $file) {
        require_once($file);
    }

    require_once("./resetDB.php");

    function loadSampleDB() {
        $db = new Database("localhost", "root", "", "ALL_GAMES", 3306);

        $u_youdied = 1;
        $u_amaz = 2;
        $u_got = 3;
        $u_killer = 4;
        $u_rob = 5;
        $u_drac = 6;

        registerUtente($db, "YOU_DIED", "pass", "Alberto", "Ambrosio", new DateTime((2022-28)."-01-01"), GenereUtente::MASCHIO, "AlbertoAmbrosio@gmail.com", "3333333333", NULL, $u_youdied);
        registerUtente($db, "TheAmazonian", "pass", "Marlena", "Di Battista", new DateTime((2022-20)."-01-01"), GenereUtente::FEMMINA, "Marlena.DiBattista@virgilio.it", "3333333333", NULL, $u_amaz);
        registerUtente($db, "gothic-4ever", "pass", "Francesca", "Scorbutica", new DateTime((2022-19)."-01-01"), GenereUtente::FEMMINA, "FrancescaScorbutica@gmail.com", "3333333333", NULL, $u_got);
        registerUtente($db, "Th3Pr0Kill3r", "pass", "Francesco", "Ravioli", new DateTime((2022-10)."-01-01"), GenereUtente::MASCHIO, "FrancescoRavioli@gmail.com", "3333333333", NULL, $u_killer);
        registerUtente($db, "roberuti", "pass", "Roberto", "Malaguti", new DateTime((2022-45)."-01-01"), GenereUtente::NON_DEFINITO, "RobertoMalaguti@gmail.com", "3333333333", NULL, $u_rob);
        registerUtente($db, "Draco4ever", "pass", "Madi", "Tamane", new DateTime((2022-16)."-01-01"), GenereUtente::FEMMINA, "MadiTamane@hotmail.com", "3333333333", NULL, $u_drac);

        $comm_amantiDS = "Amanti di Dark Souls";
        $comm_retroGaming = "Retro gaming";
        $comm_tutorial = "TuttoTutorial";
        $comm_amazzoni = "Le comm_amazzoni (WoW)";

        $communitys = array(
            new CommunityCreateDTO($comm_amantiDS, "", $u_youdied), // URL MANCANTE
            new CommunityCreateDTO($comm_retroGaming, "", $u_rob), // URL MANCANTE
            new CommunityCreateDTO($comm_tutorial, "", $u_killer), // URL MANCANTE
            new CommunityCreateDTO($comm_amazzoni, "", $u_amaz) // URL MANCANTE
        );

        foreach ($communitys as $community) {
            $community->createOn($db);
        }

        $partecipazioni_community = array(
            new PartecipazioneCommunityCreateDTO($u_youdied, $comm_amantiDS),
            new PartecipazioneCommunityCreateDTO($u_got, $comm_amantiDS),
            new PartecipazioneCommunityCreateDTO($u_drac, $comm_amantiDS),
            new PartecipazioneCommunityCreateDTO($u_killer, $comm_amantiDS),
            new PartecipazioneCommunityCreateDTO($u_rob, $comm_retroGaming),
            new PartecipazioneCommunityCreateDTO($u_youdied, $comm_retroGaming),
            new PartecipazioneCommunityCreateDTO($u_killer, $comm_tutorial),
            new PartecipazioneCommunityCreateDTO($u_drac, $comm_tutorial),
            new PartecipazioneCommunityCreateDTO($u_amaz, $comm_amazzoni),
            new PartecipazioneCommunityCreateDTO($u_drac, $comm_amazzoni)
        );

        foreach ($partecipazioni_community as $p) {
            $p->createOn($db);
        }

        $follows = array(
            new FollowCreateDTO($u_amaz, $u_drac),
            new FollowCreateDTO($u_got, $u_youdied),
            new FollowCreateDTO($u_killer, $u_youdied),
            new FollowCreateDTO($u_killer, $u_amaz),
            new FollowCreateDTO($u_rob, $u_youdied),
            new FollowCreateDTO($u_drac, $u_killer),
            new FollowCreateDTO($u_drac, $u_amaz)
        );

        foreach ($follows as $f) {
            $f->createOn($db);
        }

        $tag_darksouls = "Dark Souls";
        $tag_eldenring = "Elden Ring";
        $tag_outw = "Outward";
        $tag_wow = "Wow";
        $tag_worldOf = "World of Warcraft";
        $tag_minec = "Minecraft";
        $tag_belliss = "Bellissimo";
        $tag_difficile = "Troppo difficile";
        $tag_rage = "Ragequit";
        $tag_amazz = "Amazzoni";
        $tag_giochiamo = "Giochiamo assieme";
        $tag_bug = "BUG";
        $tag_rpg = "RPG";


        $tags = array(
            new TagCreateDTO($tag_darksouls),
            new TagCreateDTO($tag_eldenring),
            new TagCreateDTO($tag_outw),
            new TagCreateDTO($tag_wow),
            new TagCreateDTO($tag_worldOf),
            new TagCreateDTO($tag_minec),
            new TagCreateDTO($tag_belliss),
            new TagCreateDTO($tag_difficile),
            new TagCreateDTO($tag_rage),
            new TagCreateDTO($tag_amazz),
            new TagCreateDTO($tag_giochiamo),
            new TagCreateDTO($tag_bug),
            new TagCreateDTO($tag_rpg)
        );

        foreach ($tags as $t) {
            $t->createOn($db);
        }

        $posts = array(
            new PostCreateDTO("Cosa pensate di Elden Ring, il nuovo gioco di FromSoftware?\nSarà il degno successore di Dark Souls?", dateTimeFromSQLDate("2022-02-26 18:31:00"), $u_youdied, $comm_amantiDS, 1),
            new PostCreateDTO("Oggi pomeriggio ci vediamo su Stwitch per la seconda live di Bloodborn", dateTimeFromSQLDate("2022-08-22 10:15:00"), $u_youdied, NULL, 2),
            new PostCreateDTO("Qualcuno vuole unirsi alla mia gilda su World of Warcraft?\nCi chiamiamo \"Le amazzoni\".", dateTimeFromSQLDate("2022-07-02 19:00:00"), $u_amaz, NULL, 3),
            new PostCreateDTO("Ci troviamo online stasera alle 19 per sconfiggere il penultimo boss!\nForza amazzoni!", dateTimeFromSQLDate("2022-10-12 15:58:00"), $u_amaz, $comm_amazzoni, 4),
            new PostCreateDTO("Guardate il mio nuovo personaggio :)", dateTimeFromSQLDate("2022-08-03 23:27:00"), $u_amaz, $comm_amazzoni, 5),
            new PostCreateDTO("Elden ring è troppo difficile, FA SCHIFO!", dateTimeFromSQLDate("2022-03-01 10:20:00"), $u_got, NULL, 6),
            new PostCreateDTO("La grafica di Uncharted 4 è fantasticaaa <3 <3", dateTimeFromSQLDate("2022-12-01 16:10:00"), $u_got, NULL, 7),
            new PostCreateDTO("Qualcuno saprebbe dirmi come sbloccare l'achievement \"Il distruttore\" su Dark Souls 3? Mi manca solo quello per fare 100%", dateTimeFromSQLDate("2022-11-10 18:40:00"), $u_killer, $comm_amantiDS, 8),
            new PostCreateDTO("Dove trovo l'Ender Dragon?", dateTimeFromSQLDate("2022-08-01 10:15:00"), $u_killer, $comm_tutorial, 9),
            new PostCreateDTO("Cerco qualcuno per giocare con me a Fortnite", dateTimeFromSQLDate("2022-08-24 15:10:00"), $u_killer, NULL, 10),
            new PostCreateDTO("HAHAHAAH CHE BUUUUG!!!!", dateTimeFromSQLDate("2022-09-15 15:20:00"), $u_killer, NULL, 11),
            new PostCreateDTO("Vorrei provare per la prima volta un RPG, qualcuno saprebbe darmi qualche consiglio?", dateTimeFromSQLDate("2022-10-08 21:40:00"), $u_drac, NULL, 12)
        );

        foreach ($posts as $p) {
            $p->createOn($db);
        }

        $taginposts = array(
            new TagInPostCreateDTO($tag_eldenring, 1),
            new TagInPostCreateDTO($tag_darksouls, 1),
            new TagInPostCreateDTO($tag_rage, 2),
            new TagInPostCreateDTO($tag_worldOf, 3),
            new TagInPostCreateDTO($tag_wow, 3),
            new TagInPostCreateDTO($tag_amazz, 3),
            new TagInPostCreateDTO($tag_amazz, 4),
            new TagInPostCreateDTO($tag_worldOf, 4),
            new TagInPostCreateDTO($tag_wow, 4),
            new TagInPostCreateDTO($tag_giochiamo, 4),
            new TagInPostCreateDTO($tag_worldOf, 5),
            new TagInPostCreateDTO($tag_wow, 5),
            new TagInPostCreateDTO($tag_belliss, 5),
            new TagInPostCreateDTO($tag_eldenring, 6),
            new TagInPostCreateDTO($tag_difficile, 6),
            new TagInPostCreateDTO($tag_rage, 6),
            new TagInPostCreateDTO($tag_belliss, 7),
            new TagInPostCreateDTO($tag_darksouls, 8),
            new TagInPostCreateDTO($tag_minec, 9),
            new TagInPostCreateDTO($tag_giochiamo, 10),
            new TagInPostCreateDTO($tag_bug, 11),
            new TagInPostCreateDTO($tag_rpg, 12)
        );

        foreach ($taginposts as $t) {
            $t->createOn($db);
        }

        $multimedias = array(
            new ContenutoMultimedialePostCreateDTO("https://images4.alphacoders.com/115/1151249.jpg", 0, 1, false, true),
            new ContenutoMultimedialePostCreateDTO("https://asset.vg247.com/Wow-History-Vanilla-07.jpg/BROK/resize/690%3E/format/jpg/quality/70/Wow-History-Vanilla-07.jpg", 0, 5, false, true),
            new ContenutoMultimedialePostCreateDTO("https://www.psu.com/wp/wp-content/uploads/2019/11/uncharted-4-review-2.jpeg", 0, 7, false, true),
            new ContenutoMultimedialePostCreateDTO("https://pressquit.com/wp-content/uploads/2016/06/Review-Uncharted-4-FI.jpg", 1, 7, false, true),
            new ContenutoMultimedialePostCreateDTO("https://d2kektcjb0ajja.cloudfront.net/images/posts/feature_images/000/000/070/large-1465604295-uc4workflow-feature2.jpg", 2, 7, false, true),
            new ContenutoMultimedialePostCreateDTO("https://preview.redd.it/9e60csttrwx81.jpg?auto=webp&s=38730f571ceac06dce9cef0fdce3e0ce65e92ddd", 3, 7, false, true),
            new ContenutoMultimedialePostCreateDTO("https://youtu.be/9angHtiHgd8", 0, 11, true, false) // Don't think a youtube video will work..
        );

        foreach ($multimedias as $m) {
            $m->createOn($db);
        }

        $mipiaces = array(
            new MiPiaceCreateDTO(1, $u_youdied),
            new MiPiaceCreateDTO(1, $u_got),
            new MiPiaceCreateDTO(1, 4),
            new MiPiaceCreateDTO(2, $u_got),
            new MiPiaceCreateDTO(2, 4),
            new MiPiaceCreateDTO(3, $u_got),
            new MiPiaceCreateDTO(3, $u_drac),
            new MiPiaceCreateDTO(4, $u_got),
            new MiPiaceCreateDTO(5, $u_youdied),
            new MiPiaceCreateDTO(5, $u_amaz),
            new MiPiaceCreateDTO(5, $u_drac),
            new MiPiaceCreateDTO(6, $u_got),
            new MiPiaceCreateDTO(7, $u_got),
            new MiPiaceCreateDTO(7, $u_killer),
            new MiPiaceCreateDTO(11, $u_killer),
            new MiPiaceCreateDTO(11, $u_drac),
            new MiPiaceCreateDTO(12, $u_rob),
            new MiPiaceCreateDTO(12, $u_amaz)
        );

        foreach ($mipiaces as $m) {
            $m->createOn($db);
        }


        $commenti = array(
            new CommentoCreateDTO("Vieni a vedere qualche mio tutorial se vuoi migliorare.", dateTimeFromSQLDate("2022-03-01 12:30:00"), 6, $u_youdied, 1),
            new CommentoCreateDTO("Cosa ne dici di provare World Of Warcraft\n Ho fondato una gilda (Le Amazzoni) che è diventata molto nota in Italia. Se vuoi possiamo aiutarti con le prime fasi di gioco!!! :)", dateTimeFromSQLDate("2022-10-09 10:32:00"), 12, $u_amaz, 2),
            new CommentoCreateDTO("Assolutamente no, lagga ed è troppo sbilanciato!", dateTimeFromSQLDate("2022-02-28 22:15:00"), 1, $u_got, 3),
            new CommentoCreateDTO("Non fa ridere..", dateTimeFromSQLDate("2022-09-15 16:15:00"), 11, $u_got, 4),
            new CommentoCreateDTO("Non provare Elden Ring.", dateTimeFromSQLDate("2022-10-09 15:30:00"), 12, $u_got, 5),
            new CommentoCreateDTO("Troppo belloooooooo °o°", dateTimeFromSQLDate("2022-02-27 10:05:00"), 1, $u_killer, 6),
            new CommentoCreateDTO("Come non detto, ci sono appena riuscito.", dateTimeFromSQLDate("2022-11-10 23:20:00"), 8, $u_killer, 7),
            new CommentoCreateDTO("Se hai la Switch prova Zelda Breath of the Wild. Tutti dicono sia molto bello e io sono d'accordo!", dateTimeFromSQLDate("2022-10-09 16:12:00"), 12, $u_killer, 8),
            new CommentoCreateDTO("Prova con Divinity 2 Ego Draconis, è un po' vecchio ma proprio per questo penso sia la scelta migliore per un neofita.", dateTimeFromSQLDate("2022-10-10 6:40:00"), 12, $u_rob, 9),
            new CommentoCreateDTO("Ci sarò!", dateTimeFromSQLDate("2022-10-12 16:21:00"), 4, $u_drac, 10)
        );

        foreach ($commenti as $c) {
            $c->createOn($db);
        }

        $risposte = array(
            new RispostaCreateDTO("Non sono io a dover migliorare, è il gioco...", dateTimeFromSQLDate("2022-03-01 12:35:00"), $u_got, 1, 1),
            new RispostaCreateDTO("Stai calmina, stava solo cercando di essere gentile...", dateTimeFromSQLDate("2022-03-01 12:58:00"), $u_killer, 1, 2),
            new RispostaCreateDTO("Grazie mille, penso proprio che entrerò anche nella vostra community :)", dateTimeFromSQLDate("2022-10-09 10:55:00"), $u_drac, 2, 3),
            new RispostaCreateDTO("Come te.. :P", dateTimeFromSQLDate("2022-09-15 16:21:00"), $u_killer, 4, 4),
            new RispostaCreateDTO("Concordo", dateTimeFromSQLDate("2022-02-27 10:28:00"), $u_amaz, 6, 5),
            new RispostaCreateDTO("Grazie!", dateTimeFromSQLDate("2022-10-09 18:02:00"), $u_drac, 8, 6),
            new RispostaCreateDTO("Sembra interessante, grazie mille!", dateTimeFromSQLDate("2022-10-10 8:20:00"), $u_drac, 9, 7),
            new RispostaCreateDTO("Grandeee!", dateTimeFromSQLDate("2022-10-12 16:30:00"), $u_amaz, 10, 8)
        );

        foreach ($risposte as $r) {
            $r->createOn($db);
        }
    }

    loadSampleDB();
?>

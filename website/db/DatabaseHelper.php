<?php
    require_once(__DIR__."/Database.php");
    require_once(__DIR__."/model/Post.php");
    require_once(__DIR__."/model/Follow.php");
    require_once(__DIR__."/model/Community.php");
    require_once(__DIR__."/model/PartecipazioneCommunity.php");
    require_once(__DIR__."/model/TagInPost.php");
    require_once(__DIR__."/model/Commento.php");
    require_once(__DIR__."/model/MiPiace.php");
    require_once(__DIR__."/model/ContenutoMultimedialePost.php");
    require_once(__DIR__."/model/Utente.php");
    require_once(__DIR__."/model/Notifica.php");
    require_once(__DIR__."/model/Tag.php");
    require_once(__DIR__."/model/TagInPost.php");
    require_once(__DIR__."/model/Risposta.php");


    /**
     * Helper class for interacting with the database from a higher level perspective.
     * Can be used to perform specific queries which can be more efficient.
    */ 
    class DatabaseHelper {
        public function __construct(private Database $db) {}

        public function getUtenteFromId(int $idUtente): ?UtenteDTO {
            return UtenteDTO::getOneByID($this->db, $idUtente);
        }

        public function getPostFeedOfUtente(int $idUtente): array {
            $queryPostsFromFollowedUsers = "SELECT P.* 
                FROM ".Schemas::POST->value." P
                JOIN ".Schemas::UTENTE->value." U
                JOIN ".Schemas::FOLLOW->value." F
                ON(P.".PostKeys::utente." = U.".UtenteKeys::id."
                    AND U.".UtenteKeys::id." = F.".FollowKeys::utenteSeguito.")
                WHERE F.".FollowKeys::utenteSeguace." = ?
                ORDER BY P.".PostKeys::timestamp." DESC";

            $queryPostsFromFollowedCommunities = "SELECT P.*
                FROM ".Schemas::POST->value." P
                JOIN ".Schemas::UTENTE->value." U
                JOIN ".Schemas::COMMUNITY->value." C
                JOIN ".Schemas::PARTECIPAZIONE_COMMUNITY->value." PC
                ON(P.".PostKeys::utente." = U.".UtenteKeys::id."
                    AND P.".PostKeys::community." = C.".CommunityKeys::nome."
                    AND C.".CommunityKeys::nome." = PC.".PartecipazioneCommunityKeys::community.")
                WHERE PC.".PartecipazioneCommunityKeys::utente." = ?
                ORDER BY P.".PostKeys::timestamp." DESC";
    
            $u = $this->db->executeQuery($queryPostsFromFollowedUsers, array($idUtente));
    
            $ids = array_map(function($row) {
                return $row['Id'];
            }, $u);
    
            $c = $this->db->executeQuery($queryPostsFromFollowedCommunities, array($idUtente));
    
            $posts = $u;
            foreach ($c as $row) {
                if (!in_array($row["Id"], $ids)) {
                    array_push($posts, $row);
                }
            }

            $posts = array_map(function($row) {
                return PostDTO::fromDBRow($row);
            }, $posts);

            // https://www.php.net/manual/en/function.usort.php
            usort($posts, function(PostDTO $post1, PostDTO $post2) {
                if ($post1->timestamp > $post2->timestamp) {
                    return -1;
                } else if ($post1->timestamp == $post2->timestamp) {
                    return 0;
                } else {
                    return 1;
                }
            });

            return $posts;
        }

        public function getPostFeedOfCommunity(string $nomeCommunity): array {
            $query = "SELECT P.*
                FROM ".Schemas::POST->value." P
                WHERE P.".PostKeys::community." = ?
                ORDER BY P.".PostKeys::timestamp." DESC";
    
            $rows = $this->db->executeQuery($query, array($nomeCommunity));
    
            $posts = array_map(function($row) {
                return PostDTO::fromDBRow($row);
            }, $rows);
            
            return $posts;
        }

        public function getPostFeedOfUserProfile(UtenteDTO $utente): array {
            $query = "SELECT P.*
                FROM ".Schemas::POST->value." P
                WHERE P.".PostKeys::utente." = ?
                ORDER BY P.".PostKeys::timestamp." DESC";
    
            $rows = $this->db->executeQuery($query, array($utente->id));
    
            $posts = array_map(function($row) {
                return PostDTO::fromDBRow($row);
            }, $rows);
            
            return $posts;
        }

        public function getPostFeedOfTag(TagDTO $tag): array {
            $query = "SELECT P.*
                FROM ".Schemas::POST->value." P
                JOIN ".Schemas::TAG_IN_POST->value." T
                ON (P.".PostKeys::id." = T.".TagInPostKeys::post.")
                WHERE T.".TagInPostKeys::tag." = ?
                ORDER BY P.".PostKeys::timestamp." DESC";
    
            $rows = $this->db->executeQuery($query, array($tag->nome));
    
            $posts = array_map(function($row) {
                return PostDTO::fromDBRow($row);
            }, $rows);
            
            return $posts;
        }

        public function getAuthorOfPost(PostDTO $post): UtenteDTO {
            return UtenteDTO::getOneByID($this->db, $post->utente);
        }

        public function getSourceUserOfNotification(NotificaDTO $notifica): UtenteDTO {
            return UtenteDTO::getOneByID($this->db, $notifica->attoreSorgente);
        }

        public function getTagsOfPost(PostDTO $post): array {
            $rows = $this->db->select(Schemas::TAG_IN_POST, array(
                'Post' => $post->id
            ));

            return array_map(function($row) {
                return TagInPostDTO::fromDBRow($row);
            }, $rows);
        }

        public function getNotificationsOfUser(int $idUtente): array {
            $queryNotificationOfUserOrdered = "SELECT *
                FROM ".Schemas::NOTIFICA->value." 
                WHERE ".NotificaKeys::ricevente." = ? 
                ORDER BY ".NotificaKeys::timestamp." DESC";

            $rows = $this->db->executeQuery($queryNotificationOfUserOrdered, array($idUtente));

            return array_map(function($row) {
                return NotificaDTO::fromDBRow($row);
            }, $rows);
        }

        public function getNewNotificationsOfUser(int $idUtente): array {
            $rows = $this->db->select(Schemas::NOTIFICA, array(
                'Ricevente' => $idUtente,
                'Letta' => 0
            ));

            return array_map(function($row) {
                return NotificaDTO::fromDBRow($row);
            }, $rows);
        }

        public function getCommentiOfPost(PostDTO $post): array {
            $query = "SELECT C.*
                FROM ".Schemas::COMMENTO->value." C
                WHERE C.".CommentoKeys::post." = ?
                ORDER BY C.".CommentoKeys::timestamp." ASC";
    
            $rows = $this->db->executeQuery($query, array($post->id));

            return array_map(function($row) {
                return CommentoDTO::fromDBRow($row);
            }, $rows);
        }

        public function getMiPiaceOfPost(PostDTO $post): array {
            $rows = $this->db->select(Schemas::MI_PIACE, array(
                'Post' => $post->id
            ));

            return array_map(function($row) {
                return MiPiaceDTO::fromDBRow($row);
            }, $rows);
        }

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

        public function usernameIsAvailable(string $username): bool {
            return null === UtenteDTO::getOneByUsername($this->db, $username);
        }

        public function emailIsAvailable(string $email): bool {
            $rows = $this->db->select(Schemas::UTENTE, array(
                UtenteKeys::email => $email
            ));
            return (sizeof($rows) === 0);
        }

        public function getCommunityFromName(string $communityName): ?CommunityDTO {
            return CommunityDTO::getOneByID($this->db, $communityName);
        }

        public function fondatoreOfCommunity(CommunityDTO $community): UtenteDTO {
            return UtenteDTO::getOneByID($this->db, $community->fondatore);
        }

        public function partecipantiOfCommunity(CommunityDTO $community): int {
            $rows = $this->db->select(Schemas::PARTECIPAZIONE_COMMUNITY, array(
                PartecipazioneCommunityKeys::community => $community->nome
            ));
            return sizeof($rows);
        }
        
        public function getPartecipazioneCommunity(UtenteDTO $utente, CommunityDTO $community): ?PartecipazioneCommunityDTO {
            return PartecipazioneCommunityDTO::getOneByID($this->db, $utente->id, $community->nome);
        }

        /**
         * Returns a dto if the partecipazione has been set. Returns null if the partecipazione has been unset.
         * @param bool $partecipa flag that indicates whether the partecipazione should be set or not. 
         * @return ?PartecipazioneCommunityDTO
         */
        public function setUtentePartecipaCommunity(UtenteDTO $utente, CommunityDTO $community, bool $partecipa): ?PartecipazioneCommunityDTO {

            $partecipazione = PartecipazioneCommunityDTO::getOneByID($this->db, $utente->id, $community->nome);

            if ($partecipa !== (null !== $partecipazione)) {
                if ($partecipa) {
                    (new PartecipazioneCommunityCreateDTO($utente->id, $community->nome))->createOn($this->db);
                    $partecipazione = PartecipazioneCommunityDTO::getOneByID($this->db, $utente->id, $community->nome);
                } else {
                    (new PartecipazioneCommunityDeleteDTO($utente->id, $community->nome))->deleteOn($this->db);
                    $partecipazione = null;
                }
            }
            return $partecipazione;
        }
        
        public function getUtentiWithSubstring(string $filter): ?array {
            $querySelectUtentiWithSubstring = "SELECT * 
                FROM ".Schemas::UTENTE->value." 
                WHERE ".UtenteKeys::username." LIKE ? 
                ORDER BY ".UtenteKeys::username." DESC";

            $rows = $this->db->executeQuery($querySelectUtentiWithSubstring, array("%".$filter."%"));

            if (sizeof($rows) == 0) {
                return null;
            }

            return array_map(function($row) {
                return UtenteDTO::fromDBRow($row);
            }, $rows);
        }

        public function getCommunityWithSubstring(string $filter): ?array {
            $querySelectCommunityWithSubstring = "SELECT * 
                FROM ".Schemas::COMMUNITY->value." 
                WHERE ".CommunityKeys::nome." LIKE ? 
                ORDER BY ".CommunityKeys::nome." DESC";

            $rows = $this->db->executeQuery($querySelectCommunityWithSubstring, array("%".$filter."%"));

            if (sizeof($rows) == 0) {
                return null;
            }

            return array_map(function($row) {
                return CommunityDTO::fromDBRow($row);
            }, $rows);
        }

        public function getCommunitiesOfUtente(UtenteDTO $utente): array {
            $query = "SELECT C.*
                FROM ".Schemas::COMMUNITY->value." C
                JOIN ".Schemas::PARTECIPAZIONE_COMMUNITY->value." PC
                ON(C.".CommunityKeys::nome." = PC.".PartecipazioneCommunityKeys::community.")
                WHERE PC.".PartecipazioneCommunityKeys::utente." = ?
                ORDER BY C.".CommunityKeys::nome." DESC";
    
            $rows = $this->db->executeQuery($query, array($utente->id));

            $communities = array_map(function($row) {
                return CommunityDTO::fromDBRow($row);
            }, $rows);

            return $communities;
        }

        public function checkIfUserFollows(UtenteDTO $follower, UtenteDTO $followed): bool {
            return null !== FollowDTO::getOneByID($this->db, $follower->id, $followed->id);
        }

        /**
         * Returns a dto if the partecipazione has been set. Returns null if the partecipazione has been unset.
         * @param bool $partecipa flag that indicates whether the partecipazione should be set or not. 
         * @return ?PartecipazioneCommunityDTO
         */
        public function setUtenteFollowUtente(UtenteDTO $follower, UtenteDTO $followed, bool $follow): ?FollowDTO {

            $f = FollowDTO::getOneByID($this->db, $follower->id, $followed->id);

            if ($follow !== (null !== $f)) {
                if ($follow) {
                    (new FollowCreateDTO($follower->id, $followed->id))->createOn($this->db);
                    $f = FollowDTO::getOneByID($this->db, $follower->id, $followed->id);
                } else {
                    (new FollowDeleteDTO($follower->id, $followed->id))->deleteOn($this->db);
                    $f = null;
                }
            }
            return $f;
        }

        public function getFollowOfUtente(UtenteDTO $utente): array {
            $query = "SELECT U.* 
                FROM ".Schemas::FOLLOW->value." F,
                ".Schemas::UTENTE->value." U 
                WHERE F.".FollowKeys::utenteSeguace." = ?
                AND U.".UtenteKeys::id." = F.".FollowKeys::utenteSeguito;
    
            $rows = $this->db->executeQuery($query, array($utente->id));
    
            return array_map(function($row) {
                return UtenteDTO::fromDBRow($row);
            }, $rows);
        }

        public function getFollowersOfUtente(UtenteDTO $utente): array {
            $query = "SELECT U.* 
                FROM ".Schemas::FOLLOW->value." F,
                ".Schemas::UTENTE->value." U 
                WHERE F.".FollowKeys::utenteSeguito." = ?
                AND U.".UtenteKeys::id." = F.".FollowKeys::utenteSeguace;
    
            $rows = $this->db->executeQuery($query, array($utente->id));
    
            return array_map(function($row) {
                return UtenteDTO::fromDBRow($row);
            }, $rows);
        }

        public function getTagFromName(string $tagName): ?TagDTO {
            return TagDTO::getOneByID($this->db, $tagName);
        }

        public function getPostFromId(int $postId): ?PostDTO {
            return PostDTO::getOneByID($this->db, $postId);
        }

        public function getRisposteOfCommento(CommentoDTO $commento): array {
            $query = "SELECT R.*
                FROM ".Schemas::RISPOSTA->value." R
                WHERE R.".RispostaKeys::commento." = ?
                ORDER BY R.".RispostaKeys::timestamp." ASC";
    
            $rows = $this->db->executeQuery($query, array($commento->id));

            return array_map(function($row) {
                return RispostaDTO::fromDBRow($row);
            }, $rows);
        }

        public function getAuthorOfCommento(CommentoDTO $commento): ?UtenteDTO {
            return UtenteDTO::getOneByID($this->db, $commento->commentatore);
        }

        public function getAuthorOfRisposta(RispostaDTO $risposta): ?UtenteDTO {
            return UtenteDTO::getOneByID($this->db, $risposta->risponditore);
        }

        public function getCommentoFromId(int $commentoId): ?CommentoDTO {
            return CommentoDTO::getOneByID($this->db, $commentoId);
        }

        public function getRispostaFromId(int $rispostaId): ?RispostaDTO {
            return RispostaDTO::getOneByID($this->db, $rispostaId);
        }

        public function commentPost(PostDTO $post, UtenteDTO $commentatore, string $testo) {
            (new CommentoCreateDTO($testo, new DateTime(), $post->id, $commentatore->id))->createOn($this->db);
        }

        public function replyCommento(CommentoDTO $commento, UtenteDTO $risponditore, string $testo) {
            (new RispostaCreateDTO($testo, new DateTime(), $risponditore->id, $commento->id))->createOn($this->db);
        }

        public function updateUtente(
            string $username,
            string $password,
            string $nome,
            string $cognome,
            DateTime $dataNascita,
            GenereUtente $genere,
            string $email,
            string $telefono,
            ?string $urlImmagine,
            UtenteDTO $utente,
        ) {
            updateUtente($this->db, $username, $password, $nome, $cognome, $dataNascita, $genere, $email, $telefono, $urlImmagine, $utente);
        }
        
        public function getNotificaFromId(int $notificaId): ?NotificaDTO {
            return NotificaDTO::getOneByID($this->db, $notificaId);
        }

        public function setNotificaLetta(NotificaDTO $notifica) {
            if (!$notifica->letta) {
                $updateDTO = NotificaUpdateDTO::from($notifica);
                $updateDTO->letta = true;
                $updateDTO->updateOn($this->db);
            }
        }

        public function getAllTags(): array {
            return TagDTO::getAllOn($this->db);
        }

        public function createPost(string $testo, int $utente, ?string $community): ?int {
            $post = new PostCreateDTO($testo, new DateTime(), $utente, $community);
            return $post->createOn($this->db);
        }

        /**
         * @param string $tag the tag to check if exists
         * 
         * @return true if the tag exists, false otherwise
         */
        public function checkIfTagExists(string $tag): bool {
            return TagDTO::getOneByID($this->db, $tag) != null;
        }

        public function getTagThatAlreadyExists(string $tag): string {
            return TagDTO::getOneByID($this->db, $tag)->nome;
        }

        public function createTag(string $tag) {
            $t = new TagCreateDTO($tag);
            $t->createOn($this->db);
        }

        public function createTagInPost(string $tag, string $post) {
            $tagInPost = new TagInPostCreateDTO($tag, $post);
            $tagInPost->createOn($this->db);
        }
        
        public function createCommunity(string $nome, string $urlImmagine, UtenteDTO $fondatore) {
            (new CommunityCreateDTO($nome, $urlImmagine, $fondatore->id))->createOn($this->db);
        }

        public function createMultimediaInPost(string $url, int $ordine, int $post, string $tipo) {
            $immagine = false;
            $video = false;

            if ($tipo === "video") {
                $video = true;
            } else if ($tipo === "img") {
                $immagine = true;
            }

            (new ContenutoMultimedialePostCreateDTO($url, $ordine, $post, $video, $immagine))->createOn($this->db);
        }

        public function deletePost(PostDTO $post) {
            $multimedias = $this->getContenutiMultimedialiOfPost($post);

            foreach ($multimedias as $m) {
                deleteMultimedia($m->url);
                ContenutoMultimedialePostDeleteDTO::from($m)->deleteOn($this->db);
            }

            PostDeleteDTO::from($post)->deleteOn($this->db);
        }

        public function checkIfMiPiaceIsActive(int $postid, int $utenteid): bool {
            return MiPiaceDTO::getOneByID($this->db, $postid, $utenteid) === null;
        }

        public function toggleMiPiaceOfPost(int $postid, int $utenteid): bool {
            if ($this->checkIfMiPiaceIsActive($postid, $utenteid)) {
                (new MiPiaceCreateDTO($postid, $utenteid))->createOn($this->db);
                return true;
            } else {
                (new MiPiaceDeleteDTO($postid, $utenteid))->deleteOn($this->db);
                return false;
            }
        }
    }
?>
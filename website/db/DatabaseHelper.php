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
            $rows = $this->db->select(Schemas::COMMENTO, array(
                'Post' => $post->id
            ));

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
         * 
         * @return ?PartecipazioneCommunityDTO
         */
        public function togglePartecipazioneCommunity(CommunityDTO $community, UtenteDTO $utente): ?PartecipazioneCommunityDTO {
            $partecipazione = PartecipazioneCommunityDTO::getOneByID($this->db, $utente->id, $community->nome);
            
            if (isset($partecipazione)) {
                PartecipazioneCommunityDeleteDTO::from($partecipazione)->deleteOn($this->db);
                $partecipazione = null;
            } else {
                (new PartecipazioneCommunityCreateDTO($utente->id, $community->nome))->createOn($this->db);
                $partecipazione = PartecipazioneCommunityDTO::getOneByID($this->db, $utente->id, $community->nome);
            }

            return $partecipazione;
        }
    }
?>
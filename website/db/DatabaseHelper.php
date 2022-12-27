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


    /**
     * Helper class for interacting with the database from a higher level perspective.
     * Can be used to perform specific queries which can be more efficient.
    */ 
    class DatabaseHelper {
        public function __construct(private Database $db) {}

        public function getPostFeedOfUtente(int $idUtente): array {
            $queryPostsFromFollowedUsers = "SELECT P.* FROM POST P JOIN UTENTE U JOIN FOLLOW F ON(P.".PostKeys::utente." = U.".UtenteKeys::id." AND U.".UtenteKeys::id." = F.".FollowKeys::utenteSeguito.") WHERE F.".FollowKeys::utenteSeguace." = ? ORDER BY P.".PostKeys::timestamp." DESC";
            $queryPostsFromFollowedCommunities = "SELECT P.* FROM POST P JOIN UTENTE U JOIN COMMUNITY C JOIN PARTECIPAZIONE_COMMUNITY PC ON(P.".PostKeys::utente." = U.".UtenteKeys::id." AND P.".PostKeys::community." = C.".CommunityKeys::nome." AND C.".CommunityKeys::nome." = PC.".PartecipazioneCommunityKeys::community.") WHERE PC.".PartecipazioneCommunityKeys::utente." = ? ORDER BY P.".PostKeys::timestamp." DESC";
    
            $u = $this->db->executeQuery($queryPostsFromFollowedUsers, array(getSessionUserId()));
    
            $ids = array_map(function($row) {
                return $row['Id'];
            }, $u);
    
            $c = $this->db->executeQuery($queryPostsFromFollowedCommunities, array(getSessionUserId()));
    
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

        public function getAuthorOfPost(PostDTO $post): UtenteDTO {
            return UtenteDTO::getOneByID($this->db, $post->utente);
        }

        public function getTagsOfPost(PostDTO $post): array {
            $rows = $this->db->select(Schemas::TAG_IN_POST, array(
                'Post' => $post->id
            ));

            return array_map(function($row) {
                return TagInPostDTO::fromDBRow($row);
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

            $query = "SELECT C.* FROM ".Schemas::POST->value." P JOIN ".Schemas::CONTENUTO_MULTIMEDIALE_POST->value." C ON(P.".PostKeys::id." = C.".ContenutoMultimedialePostKeys::post.") WHERE P.".PostKeys::id." = ? ORDER BY C.".ContenutoMultimedialePostKeys::ordine." ASC";
    
            $rows = $this->db->executeQuery($query, array($post->id));
    
            return array_map(function($row) {
                return ContenutoMultimedialePostDTO::fromDBRow($row); /// SONO DA ORDINAREEE
            }, $rows);
        }
    }
?>
<?php

    require_once("interfaces/Entity.php");

    class NotificaDTO {
        private const schema = Schemas::NOTIFICA;

        private function __construct(
            public readonly int $id,
            public readonly bool $letta,
            public readonly DateTime $timestamp,
            public readonly int $ricevente,
            public readonly int $attoreSorgente,
            public readonly bool $isNotificaFollow,
            public readonly ?int $utenteSeguace,
            public readonly ?int $utenteSeguito,
            public readonly bool $isNotificaMiPiace,
            public readonly ?int $liker,
            public readonly ?int $postPiaciuto,
            public readonly bool $isNotificaPostCommunity,
            public readonly ?int $postCommunity,
            public readonly bool $isNotificaCommento,
            public readonly ?int $commento,
            public readonly bool $isNotificaRisposta,
            public readonly ?int $risposta
        ) {}

        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(NotificaDTO::schema) as $row) {
                array_push($arr, NotificaDTO::fromDBRow($row));
            }
            return $arr;
        }

        public static function fromDBRow(array $row): NotificaDTO {
            return new NotificaDTO(
                $row["Id"],
                $row["Letta"],
                dateTimeFromSQLDate($row["Timestamp"]),
                $row["Ricevente"],
                $row["AttoreSorgente"],
                $row["NotificaFollow"],
                $row["UtenteSeguace"],
                $row["UtenteSeguito"],
                $row["NotificaMiPiace"],
                $row["Utente"],
                $row["Post"],
                $row["NotificaPostCommunity"],
                $row["PostCommunity"],
                $row["NotificaCommento"],
                $row["Commento"],
                $row["NotificaRisposta"],
                $row["Risposta"]
            );
        }
    }

    class NotificaDeleteDTO implements DeletableEntity {
        private const schema = Schemas::NOTIFICA;

        public function __construct(
            private int $id
        ) {}

        public function deleteOn(Database $db) {
            return $db->delete($this);
        }

        public function deletionPreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("DELETE FROM ".NotificaDeleteDTO::schema->value." WHERE Id = ?");
            $stmt->bind_param("i", $this->id);

            return $stmt;
        }

        public static function from(NotificaDTO $dto) {
            return new NotificaDeleteDTO(
                $dto->id
            );
        }
    }

    class NotificaUpdateDTO implements UpdatableEntity {
        private const schema = Schemas::NOTIFICA;

        public function __construct(
            private int $id,
            public bool $letta,
            public DateTime $timestamp,
            public int $ricevente,
            public int $attoreSorgente,
            public bool $isNotificaFollow,
            public ?int $utenteSeguace,
            public ?int $utenteSeguito,
            public bool $isNotificaMiPiace,
            public ?int $liker,
            public ?int $postPiaciuto,
            public bool $isNotificaPostCommunity,
            public ?int $postCommunity,
            public bool $isNotificaCommento,
            public ?int $commento,
            public bool $isNotificaRisposta,
            public ?int $risposta
        ) {}

        public function updateOn(Database $db) {
            return $db->update($this);
        }

        public function updatePreparedStatement(mysqli $db): mysqli_stmt {
            $stmt = $db->prepare("UPDATE ".NotificaUpdateDTO::schema->value." SET Letta = ?, Timestamp = ?, Ricevente = ?, AttoreSorgente = ?, NotificaFollow = ?, UtenteSeguace = ?, UtenteSeguito = ?, NotificaMiPiace = ?, Utente = ?, Post = ?, NotificaPostCommunity = ?, PostCommunity = ?, NotificaCommento = ?, Commento = ?, NotificaRisposta = ?, Risposta = ? WHERE Id = ?");
            $timestamp = sqlDateFromDateTime($this->timestamp);
            $stmt->bind_param("isiiiiiiiiiiiiiii", $this->letta, $timestamp, $this->ricevente, $this->attoreSorgente, $this->isNotificaFollow, $this->utenteSeguace, $this->utenteSeguito, $this->isNotificaMiPiace, $this->liker, $this->postPiaciuto, $this->isNotificaPostCommunity, $this->postCommunity, $this->isNotificaCommento, $this->commento, $this->isNotificaRisposta, $this->risposta, $this->id);

            return $stmt;
        }

        public static function from(NotificaDTO $dto) {
            return new NotificaUpdateDTO(
                $dto->id,
                $dto->letta,
                $dto->timestamp,
                $dto->ricevente,
                $dto->attoreSorgente,
                $dto->isNotificaFollow,
                $dto->utenteSeguace,
                $dto->utenteSeguito,
                $dto->isNotificaMiPiace,
                $dto->liker,
                $dto->postPiaciuto,
                $dto->isNotificaPostCommunity,
                $dto->postCommunity,
                $dto->isNotificaCommento,
                $dto->commento,
                $dto->isNotificaRisposta,
                $dto->risposta
            );
        }
    }
?>

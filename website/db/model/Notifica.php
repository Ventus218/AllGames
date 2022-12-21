<?php

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

        /**
         * @throws DatabaseException
         */
        public static function getAllOn(Database $db): array {
            $arr = array();
            foreach ($db->getAll(NotificaDTO::schema) as $row) {
                array_push($arr, NotificaDTO::fromDBRow($row));
            }
            return $arr;
        }

        /**
         * @throws DatabaseException
         */
        public static function getOneByID(Database $db, int $id): self {
            $row = $db->getOneByID(self::schema, array(
                'Id' => $id
            ));

            return self::fromDBRow($row);
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

    class NotificaDeleteDTO {
        private const schema = Schemas::NOTIFICA;

        public function __construct(
            private int $id
        ) {}

        /**
         * @throws DatabaseException
         */
        public function deleteOn(Database $db) {
            return $db->delete(self::schema, array(
                'Id' => $this->id
            ));
        }

        public static function from(NotificaDTO $dto) {
            return new NotificaDeleteDTO(
                $dto->id
            );
        }
    }

    class NotificaUpdateDTO {
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

        /**
         * @throws DatabaseException
         */
        public function updateOn(Database $db) {
            return $db->update(self::schema, array(
                'Id' => $this->id,
                'Letta' => $this->letta,
                'Timestamp' => sqlDateFromDateTime($this->timestamp),
                'Ricevente' => $this->ricevente,
                'AttoreSorgente' => $this->attoreSorgente,
                'NotificaFollow' => $this->isNotificaFollow,
                'UtenteSeguace' => $this->utenteSeguace,
                'UtenteSeguito' => $this->utenteSeguito,
                'NotificaMiPiace' => $this->isNotificaMiPiace,
                'Utente' => $this->liker,
                'Post' => $this->postPiaciuto,
                'NotificaPostCommunity' => $this->isNotificaPostCommunity,
                'PostCommunity' => $this->postCommunity,
                'NotificaCommento' => $this->isNotificaCommento,
                'Commento' => $this->commento,
                'NotificaRisposta' => $this->isNotificaRisposta,
                'Risposta' => $this->risposta,
            ), array(
                'Id' => $this->id
            ));
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

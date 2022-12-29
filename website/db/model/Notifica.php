<?php

    class NotificaKeys {
        public const id = 'Id';
        public const letta = 'Letta';
        public const timestamp = 'Timestamp';
        public const ricevente = 'Ricevente';
        public const attoreSorgente = 'AttoreSorgente';
        public const isNotificaFollow = 'NotificaFollow';
        public const utenteSeguace = 'UtenteSeguace';
        public const utenteSeguito = 'UtenteSeguito';
        public const isNotificaMiPiace = 'NotificaMiPiace';
        public const liker = 'Utente';
        public const postPiaciuto = 'Post';
        public const isNotificaPostCommunity = 'NotificaPostCommunity';
        public const postCommunity = 'PostCommunity';
        public const isNotificaCommento = 'NotificaCommento';
        public const commento = 'Commento';
        public const isNotificaRisposta = 'NotificaRisposta';
        public const risposta = 'Risposta';
    }

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
        public static function getOneByID(Database $db, int $id): ?self {
            $row = $db->getOneByID(self::schema, array(
                NotificaKeys::id => $id
            ));

            return isset($row) ? self::fromDBRow($row) : null;
        }

        public static function fromDBRow(array $row): NotificaDTO {
            return new NotificaDTO(
                $row[NotificaKeys::id],
                $row[NotificaKeys::letta],
                dateTimeFromSQLDate($row[NotificaKeys::timestamp]),
                $row[NotificaKeys::ricevente],
                $row[NotificaKeys::attoreSorgente],
                $row[NotificaKeys::isNotificaFollow],
                $row[NotificaKeys::utenteSeguace],
                $row[NotificaKeys::utenteSeguito],
                $row[NotificaKeys::isNotificaMiPiace],
                $row[NotificaKeys::liker],
                $row[NotificaKeys::postPiaciuto],
                $row[NotificaKeys::isNotificaPostCommunity],
                $row[NotificaKeys::postCommunity],
                $row[NotificaKeys::isNotificaCommento],
                $row[NotificaKeys::commento],
                $row[NotificaKeys::isNotificaRisposta],
                $row[NotificaKeys::risposta]
            );
        }

        /**
         * @return ?string A string rappresenting the text of the notification
         */
        public function getText(): ?string {
            
            if ($this->isNotificaFollow) {
                return "ha iniziato a seguirti!";
            }

            if ($this->isNotificaMiPiace) {
                return "ha messo mi piace ad un tuo post";
            }

            if ($this->isNotificaPostCommunity) {
                return "ha pubblicato un nuovo post in una community in cui fai parte";
            }

            if ($this->isNotificaCommento) {
                return "ha commentato un tuo post";
            }

            if ($this->isNotificaRisposta) {
                return "ha risposto ad un tuo commento";
            }

            return null;
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
                NotificaKeys::id => $this->id
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
                NotificaKeys::id => $this->id,
                NotificaKeys::letta => $this->letta,
                NotificaKeys::timestamp => sqlDateFromDateTime($this->timestamp),
                NotificaKeys::ricevente => $this->ricevente,
                NotificaKeys::attoreSorgente => $this->attoreSorgente,
                NotificaKeys::isNotificaFollow => $this->isNotificaFollow,
                NotificaKeys::utenteSeguace => $this->utenteSeguace,
                NotificaKeys::utenteSeguito => $this->utenteSeguito,
                NotificaKeys::isNotificaMiPiace => $this->isNotificaMiPiace,
                NotificaKeys::liker => $this->liker,
                NotificaKeys::postPiaciuto => $this->postPiaciuto,
                NotificaKeys::isNotificaPostCommunity => $this->isNotificaPostCommunity,
                NotificaKeys::postCommunity => $this->postCommunity,
                NotificaKeys::isNotificaCommento => $this->isNotificaCommento,
                NotificaKeys::commento => $this->commento,
                NotificaKeys::isNotificaRisposta => $this->isNotificaRisposta,
                NotificaKeys::risposta => $this->risposta,
            ), array(
                NotificaKeys::id => $this->id
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

<?php

    interface CreatableEntity {
        public function creationPreparedStatement(mysqli $db): mysqli_stmt;
    }

    interface DeletableEntity {
        public function deletionPreparedStatement(mysqli $db): mysqli_stmt;
    }

    interface UpdatableEntity {
        public function updatePreparedStatement(mysqli $db): mysqli_stmt;
    }

?>
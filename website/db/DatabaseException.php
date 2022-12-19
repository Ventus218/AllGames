<?php

    class DatabaseException extends Exception {
        // Redefine the exception so message isn't optional
        public function __construct($message) {
            parent::__construct($message);
        }

        // custom string representation of object
        public function __toString() {
            return __CLASS__ . ": {$this->message}\n";
        }

        public function customFunction() {
            echo "A custom function for this type of exception\n";
        }
    }
?>

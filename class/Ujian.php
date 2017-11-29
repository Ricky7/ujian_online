<?php

    class Ujian {

        private $db; 
        private $error; 

        function __construct($db_conn) {

            $this->db = $db_conn;

        }

        public function getLastError() {
            return $this->error;
        }
    }

?>
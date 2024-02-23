<?php 
    class Database {
        private $host = "localhost";
        private $database_name = "u175492522_pdf_system";
        private $username = "u175492522_pdf_system";
        private $password = "Pdf_system123";
        public $conn;

        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->exec("set names utf8");
            } catch(PDOException $exception){
                // Instead of echoing, throw an exception
                throw new Exception("Database could not be connected: " . $exception->getMessage());
            }
            return $this->conn;
        }
    }  
?>

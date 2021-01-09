<?php
    session_start();
    error_reporting(0);

    class Database
    {
        private $host = 'localhost';
        private $username = 'root';
        private $password = '';
        private $db = 'demoauth';
        protected $connection = null;

        /**
         * Constructor Method
         */
        public function __construct()
        {
            $this->connectDB();
        }

        /**
         * connectDB Method
         * Used for connecting with the Database
         * @return $this->connection
         */
        private function connectDB()
        {            
            try
            {
                $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->username, $this->password);                
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
            }
            catch(PDOException $exception)
            {
                echo "Connection error: " . $exception->getMessage();
                die();
            }
            
            return $this->connection;
        }

        

    }
?>
<?php
    require_once 'Database.php';
    class Registration extends Database
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function register($fname,$email,$pass,$token)
        {
            try
            {	 
                $query = $this->connection->prepare("INSERT INTO user(`user_fullname`, `user_email`,`user_password`, `token`) 
                    VALUES(:user_fullname, :user_email, :user_password, :token)");
                $query->bindparam(":user_fullname",$fname);
                $query->bindparam(":user_email",$email);
                $query->bindparam(":user_password",$pass);
                $query->bindparam(":token",$token);
                $query->execute();	
                
                $_SESSION['success'] = "User registration complete, please verify your email.";
                return true;
            }

            catch(PDOException $ex)
            {
                $_SESSION['err'] = $ex->getMessage();
                return false;
            }
        }



    }
?>
<?php
    require_once 'Database.php';
    class Registration extends Database
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function register($fname, $email, $pass, $token, $subject, $mailBody)
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

                // Send Email
                $mailStatus = $this->sendMail($email, $subject, $mailBody);
                if($mailStatus)
                {
                    $_SESSION['success'] = "User registration complete, please verify your email.";
                    return true;
                }
                else
                {
                    $_SESSION['err'] = $_SESSION['MailError'];
                    unset($_SESSION['MailError']);
                    return false;
                }               
                
            }
            catch(PDOException $ex)
            {
                $_SESSION['err'] = $ex->getMessage();
                return false;
            }
        }

        public function sendMail($recipient, $subject, $body)
        {
            require_once 'PHPMailer/class.phpmailer.php';
            require_once 'PHPMailer/class.smtp.php';

            $mail = new PHPMailer;           

            //$mail->SMTPDebug = 3;                               // Enable verbose debug output

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'YOUR_EMAIL_ADDRESS';                 // SMTP username
            $mail->Password = 'YOUR_PASSWORD';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            $mail->setFrom('YOUR_EMAIL_ADDRESS', 'YOUR_BRAND_NAME');
            $mail->addAddress($recipient);               // Add recipient
            $mail->addReplyTo('YOUR_EMAIL_ADDRESS', 'YOUR_BRAND_NAME');

            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = $subject;
            $mail->Body    = $body;

            //If email send fail, show error message, otherwise show success message (through SESSION)
            if(!$mail->send()) 
            {
                $_SESSION['MailError'] = $mail->ErrorInfo;
                return false;
            } 
            else 
            {
                
                return true;
            }

        }

        public function activate($email, $token)
        {
            try
            {	 
                $code = md5(uniqid(rand()));
                $query = $this->connection->prepare("UPDATE user SET user_status = 'active', token = :newtoken WHERE user_email = :email AND token = :token");
                $query->bindparam(":email",$email);
                $query->bindparam(":token",$token);
                $query->bindparam(":newtoken",$code);
                $query->execute();	
                
                return true; 
            }
            catch(PDOException $ex)
            {
                $_SESSION['err'] = $ex->getMessage();
                return false;
            }

        }

        public function resetPass($email, $pass, $token)
        {
            try
            {	 
                $code = md5(uniqid(rand()));
                $query = $this->connection->prepare("UPDATE user SET user_password = :pass, token = :newtoken WHERE user_email = :email AND token = :token");
                $query->bindparam(":email",$email);
                $query->bindparam(":pass",$pass);
                $query->bindparam(":token",$token);
                $query->bindparam(":newtoken",$code);
                $query->execute();	
                
                return true; 
            }
            catch(PDOException $ex)
            {
                $_SESSION['err'] = $ex->getMessage();
                return false;
            }

        }

        public function signin($email, $password)
        {
            $Query = $this->connection->prepare('SELECT * FROM user WHERE user_email = :email LIMIT 1');
            $Query->bindParam(':email', $email); 
            $Query->execute();

            if($Query->rowCount() > 0)
            {
                $data = $Query->fetch(PDO::FETCH_OBJ);

                if($data->user_status == 'active')
                {
                    if(password_verify($password, $data->user_password))
                    {
                        $_SESSION['user_id'] = $data->user_id;                        
                        return true;
                    }
                    else
                    {
                        $_SESSION['error'] = "Login Failed. Incorrect Username / Password";
                        return false;
                    }
                }
                else
                {
                    $_SESSION['error'] = "Your Account is not active. Please check your email for verification mail.";
                    return false;
                }
                                
                
            }
            else
            {
                $_SESSION['error'] = "Account does not exist.";
                return false;
            }   
        }

        public function viewData($id)
        {
           
            try
            {
                $Query = $this->connection->prepare('SELECT * FROM user WHERE user_id = :userid');
                $Query->bindParam(':userid', $id); 
                $Query->execute();

                if($Query->rowCount() > 0)
                {
                    $data = $Query->fetchAll(PDO::FETCH_OBJ);
                    return $data;
                }
                else
                {
                    return false;
                }    
            }
            catch(PDOException $Exception)
            {
                $this->errmsg = $Exception->getMessage();
                $_SESSION['err'] = "Unexpected Error Occured. Please try again Later.<br> Error: ".$this->errmsg;
                return false;
            }  
        }

        public function retriveUserData($email)
        {
            try
            {
                $Query = $this->connection->prepare('SELECT * FROM user WHERE user_email = :email LIMIT 1');
                $Query->bindParam(':email', $email); 
                $Query->execute();

                if($Query->rowCount() > 0)
                {
                    $data = $Query->fetchAll(PDO::FETCH_OBJ);
                    return $data;
                }
                else
                {
                    return false;
                }    
            }
            catch(PDOException $Exception)
            {
                $this->errmsg = $Exception->getMessage();
                $_SESSION['err'] = "Unexpected Error Occured. Please try again Later.<br> Error: ".$this->errmsg;
                return false;
            }  

        }

        public function checkMailToken($email, $token)
        {
            try
            {
                $Query = $this->connection->prepare('SELECT * FROM user WHERE user_email = :email AND token = :token LIMIT 1');
                $Query->bindParam(':email', $email); 
                $Query->bindParam(':token', $token); 
                $Query->execute();

                if($Query->rowCount() > 0)
                {
                    $data = $Query->fetchAll(PDO::FETCH_OBJ);
                    return $data;
                }
                else
                {
                    return false;
                }    
            }
            catch(PDOException $Exception)
            {
                $this->errmsg = $Exception->getMessage();
                $_SESSION['err'] = "Unexpected Error Occured. Please try again Later.<br> Error: ".$this->errmsg;
                return false;
            }  

        }

    }
?>
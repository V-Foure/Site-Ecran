<?php
    class User{

        //propriétés private
        private $id_;
        private $isAdmin_ = false;
        private $login_;
        
        //méthode public
        public function __construct($id,$isAdmin,$login){
            $this->id_ = $id;
            $this->isAdmin_ = $isAdmin;
            $this->login_ = $login;
        }

        public function seConnecter($login,$pass){
            $RequetSql = "SELECT * FROM `User` 
            WHERE 
            `login` = '".$login."' 
            AND 
            `pass` = '".$pass."';";

            $resultat = $GLOBALS["pdo"]->query($RequetSql);
            if ( $resultat->rowCount()>0){
               
                $tab = $resultat->fetch();
                $_SESSION['Connexion']=true;
                $_SESSION['id']=$tab['id'];

                $this->id_ = $tab['id'];
                $this->isAdmin_ = $tab['isAdmin'];
                $this->login_ = $tab['login'];

                return true;
            }else{
                return false;
            }
        }

        public function CreateNewUser($login,$pass){

            $RequetSql = "SELECT * FROM `User` 
            WHERE 
            `login` = '".$login."'";
            $resultat = $GLOBALS["pdo"]->query($RequetSql); 
            if ( $resultat->rowCount()>0){
                $tab = $resultat->fetch();
                $this->id_ = $tab['id'];
                $this->isAdmin_ = $tab['isAdmin'];
                $this->login_ = $tab['login'];
                $pass =  $tab['pass'];
                
            }else{

                if(empty($pass)){
                    $temp= password_hash($login, PASSWORD_DEFAULT);
                    $pass=substr($temp, 13, 3).substr($temp, 23, 3).substr($temp, 33, 3).'!';
                }
                //ETAPE 3 --------------------------
                $requetSQL = "INSERT INTO `User`
                ( `login`, `pass`, `isAdmin`) 
                VALUES 
                ('" . $login . "','" . $pass . "','0')";
                $resultat = $GLOBALS["pdo"]->query($requetSQL);
                $this->id_ = $GLOBALS["pdo"]->lastInsertId();
                $this->isAdmin_ = 0;
                $this->login_ = $login;
            }

            try {
                 $to  = $this->login_;

                 $subject = 'Bienvenu sur TP Note Ecran';

                 $message = '<html><head><title>Bienvenu sur TP Note Ecran</title></head>
                 <body>
                 <p style=" background-image: url(\'https://getwallpapers.com/wallpaper/full/9/3/7/1267865-movie-poster-wallpaper-1920x1080-for-mobile-hd.jpg\') ;height:180px;color:white;text-align: center;font-size: 100px;">TP NOTE SITE</p>
                 <p><h2 style="color:black" >Voici votre login : '.$this->login_.'<h2></p>
                 <p><h3 style="color:black">Voici votre mdp temporaire : '.$pass.' <h3></p></body>
                 </html>';

                 $headers[] = 'MIME-Version: 1.0';
                 $headers[] = 'Content-type: text/html; charset=utf-8';

                 $headers[] = 'To:  <'.$to.'>';
                 $headers[] = 'From: TP Note Ecran <no-reply@sendinblue.com>';
        
                 mail($to, $subject, $message, implode("\r\n", $headers));
             } catch (Exception  $error) {
                 $error->getMessage();
             }
        }


        

        public function setUserById($id){
            $RequetSql = "SELECT * FROM `User` 
            WHERE 
            `id` = '".$id."'";

            $resultat = $GLOBALS["pdo"]->query($RequetSql); 
            if ( $resultat->rowCount()>0){
                //echo "on a trouver le bon id";
                $tab = $resultat->fetch();
                $this->id_ = $tab['id'];
                $this->isAdmin_ = $tab['isAdmin'];
                $this->login_ = $tab['login'];
                return true;
            }else{
                return false;
            }
        }

        public function seDeConnecter(){
            session_unset();
            session_destroy();
        }

        public function isAdmin(){
            return $this->isAdmin_;
        }

        public function  getLogin(){
            return $this->login_;
        }
        
    }
?>
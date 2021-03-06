<?php
    class User{
        private $db;
        public function __construct($db){
            $this->db=$db;
        }
        public function is_logged_in(){
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                return true;
            }
        }
        public function create_hash($value){
            return $hash = crypt($value, '$2a$12.substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22)');
        }

        public function verify_hash($password,$hash){
            return $hash == crypt($password,$hash);
        }

        private function get_user_hash($username){    

            try {
    
                $stmt = $this->db->prepare('SELECT password FROM users WHERE username = :username');
                $stmt->execute(array('username' => $username));
                
                $row = $stmt->fetch();

                
                if(isset($row['password'])){
                    return $row['password'];
                }
                else{
                    return;
                }
    
            } catch(PDOException $e) {
                echo '<p class="error">'.$e->getMessage().'</p>';
            }
        }

        public function login($username,$password){    

            $hashed = $this->get_user_hash($username);
            
            if($this->verify_hash($password,$hashed) == 1){
                $stmt = $this->db->prepare('SELECT user_id FROM users WHERE username = :username');
                $stmt->execute(array('username' => $username));
                
                $row = $stmt->fetch();
                
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $row['user_id'];
                return true;
            }        
        }

        public function logout(){
            session_destroy();
          }
        public function self_user(){
            return $_SESSION['id'];
        }
    }

?>
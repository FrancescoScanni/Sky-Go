<?php
    require_once("../models/passeggero.php");
    require_once("generalFunctions.php");
    require_once("connessioneDB.php");
    

    Class Passeggero{
        private $nome;
        private $cognome;
        private $mail;
        private $telefono;
        private $data;
        private $genere;
        private $password;


        //cOSTRUTTORE PROFILO PASSEGGERO
        public function __construct($nome, $cognome, $mail, $telefono, $data, $genere, $password) {
            $this->nome = $nome;
            $this->cognome = $cognome;
            $this->mail = $mail;
            $this->telefono = $telefono;
            $this->data = $data;
            $this->genere = $genere;
            $this->password = password_hash($password, PASSWORD_DEFAULT);         
        }


        public function salva(){
            global $conn, $registrazioneSuccesso;
            $sql = "INSERT INTO passeggero (nome, cognome, genere, telefono, mail, data, password)
                    VALUES ('$this->nome', '$this->cognome', '$this->genere', $this->telefono, '$this->mail', '$this->data', '$this->password')";
            if ($conn->query($sql) === TRUE) {
                echo $registrazioneSuccesso;
                } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } 

        public static function logga($mail, $password){
            global $conn, $loginFallito;
            $sql = "SELECT * FROM passeggero WHERE Mail='$mail'";
            $output = $conn->query($sql);
            if($output->num_rows >0){
                $row=$output->fetch_assoc();
                if(password_verify($password, $row["Password"])){
                    $_SESSION['loggato']=true;
                    $_SESSION['userID']=$row['ID'];
                    header("Location: ../index.php");
                    exit;
                }else{
                    echo $loginFallito;
                }
            }
        }

        public static function logout(){
            session_destroy();
        }
    }
?>
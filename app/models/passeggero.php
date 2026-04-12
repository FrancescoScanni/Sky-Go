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

        //salvataggio
        public function salva(){
            global $conn, $registrazioneSuccesso, $giaPresente;
            $sql = "INSERT INTO passeggero (nome, cognome, genere, telefono, mail, data, password)
                    VALUES ('$this->nome', '$this->cognome', '$this->genere', $this->telefono, '$this->mail', '$this->data', '$this->password')";
            $sqlEsiste="SELECT * FROM passeggero WHERE mail='$this->mail'"; //controllo se è già presente
            $esiste=$conn->query($sqlEsiste);
            if ($esiste->num_rows==0) {
                $conn->query($sql);
                echo $registrazioneSuccesso;
                return true; 
            }
            else {
                return false;
            }
        } 

        //funzione richiamat SU accedi
        public static function logga($mail, $password){
            global $conn, $loginFallito;
            $sql = "SELECT * FROM passeggero WHERE Mail='$mail'";
            $output = $conn->query($sql);
            if($output->num_rows >0){
                $row=$output->fetch_assoc();
                //echo $row["Password"];
                //echo $password;
                if(password_verify($password, $row["Password"])){
                    $_SESSION['loggato']=true;
                    $_SESSION['userID']=$row['ID'];
                    return true;
                }else{
                    return false;
                }
            }
        }

        //logout utente
        public static function logout(){
            session_destroy();
        }
    }
?>
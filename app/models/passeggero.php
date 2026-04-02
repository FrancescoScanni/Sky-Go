<?php
    //eredito gli elementi per connettere il db
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


        public function salva($conn){

        if (str_contains($this->data, '/')) {
        $d = DateTime::createFromFormat('d/m/Y', $this->data);
        $this->data = $d ? $d->format('Y-m-d') : $this->data;
    }
    echo $this->data;
    
            $sql = "INSERT INTO passeggero (Nome,Cognome,Genere,Telefono,Mail,Data,Password) 
                    VALUES ('{$this->nome}', '{$this->cognome}', '{$this->genere}', '{$this->telefono}', '{$this->mail}', {$this->data}, '{$this->password}')";
            $conn->query($sql);
        } 


    }
?>
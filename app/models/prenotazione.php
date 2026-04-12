<?php
    require_once("../pages/connessioneDB.php");
    require_once("passeggero.php");
    class Prenotazione{
        public $dataPrenotazione;
        public $posto;
        public $IDVolo;
        public $IDPasseggero;

        public function __construct($dataPrenotazione, $posto, $IDVolo, $IDPasseggero){
            $this->dataPrenotazione = $dataPrenotazione;
            $this->posto = $posto;
            $this->IDVolo = $IDVolo;
            $this->IDPasseggero = $IDPasseggero;
        }

        public function salvaPrenotazione(){
            global $conn;
            $sql = "INSERT INTO prenotazione (DataPrenotazione, Posto, IDVolo, IDPasseggero) VALUES ('$this->dataPrenotazione', '$this->posto', '$this->IDVolo', '$this->IDPasseggero')";
            $conn->query($sql);
        }

        public function cancellaPrenotazione($conn, $IDPrenotazione){
            global $conn;
            $sql = "delete FROM prenotazione WHERE IDPrenotazione='$IDPrenotazione'";
            $conn->query($sql);
        }

        public static function recuperaPrenotazione($IDPasseggero){
            global $conn;
            $sql = "SELECT * FROM prenotazione WHERE IDPasseggero='$IDPasseggero'";
            $result = $conn->query($sql);
            return $result;
        }
    }
?>
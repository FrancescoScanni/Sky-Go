<?
    require_once("../pages/connessioneDB.php");
    class Bagaglio{
        public $peso;
        public $entità;
        public $fragile;
        public $descrizione;
        public $IDPrenotazione;
        public $IDAssicurazione;

        public function __construct($peso, $entità, $fragile, $descrizione, $IDPrenotazione, $IDAssicurazione){
            $this->peso = $peso;
            $this->entità = $entità;
            $this->fragile = $fragile;
            $this->descrizione = $descrizione;
            $this->IDPrenotazione = $IDPrenotazione;
        }

        public function salvaBagaglio(){
            global $conn;
            $sql = "INSERT INTO bagaglio (Peso, Entità, Fragile, Descrizione, IDPrenotazione, IDAssicurazione) VALUES ('$this->peso', '$this->entità', '$this->fragile', '$this->descrizione', '$this->IDPrenotazione', '$this->IDAssicurazione')";
            $conn->query($sql);
        }
    }


?>
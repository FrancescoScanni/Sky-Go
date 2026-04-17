<?php
    require_once("../pages/connessioneDB.php");
    require_once("passeggero.php");

    class Prenotazione {
        public $dataPrenotazione;
        public $posto;
        public $IDVolo;
        public $IDPasseggero;

        public function __construct($dataPrenotazione, $posto, $IDVolo, $IDPasseggero) {
            $this->dataPrenotazione = $dataPrenotazione;
            $this->posto = $posto;
            $this->IDVolo = $IDVolo;
            $this->IDPasseggero = $IDPasseggero;
        }

        // Saves the booking to the database
        public function salvaPrenotazione() {
            global $conn;
            $sql = "INSERT INTO prenotazione (DataPrenotazione, Posto, IDVolo, IDPasseggero) VALUES ('$this->dataPrenotazione', '$this->posto', '$this->IDVolo', '$this->IDPasseggero')";
            $conn->query($sql);
        }

        // Deletes a booking based on its ID
        public function cancellaPrenotazione($conn, $IDPrenotazione) {
            global $conn;
            $sql = "DELETE FROM prenotazione WHERE IDPrenotazione='$IDPrenotazione'";
            $conn->query($sql);
        }

        // Retrieves all bookings for a specific passenger
        public static function recuperaPrenotazione($IDPasseggero) {
            global $conn;
            $sql = "SELECT * FROM prenotazione WHERE IDPasseggero='$IDPasseggero'";
            $result = $conn->query($sql);
            return $result;
        }
    }
?>
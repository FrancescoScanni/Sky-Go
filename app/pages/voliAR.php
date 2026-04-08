<?php
session_start();
ini_set('memory_limit', '256M'); //pongo lomite a valori generabili per evitare overload
require_once("connessioneDB.php");
require_once("generalFunctions.php");

$err = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //ANDATA
    if (!preg_match('/^[a-zA-Z]+$/', $_POST["IATAP"])) {
        $err = true;
    } else {
        $partenza = sanitize($_POST["IATAP"]);
        if (strlen($partenza) > 3) {
            $codiciPartenza = aeroportiDaCitta($partenza);
            $codiciPartenza = aeroportiDaCitta($partenza);
        } else {
            $codiciPartenza = [$partenza];
        }
    }
    //ARRIVO
    if (!preg_match('/^[a-zA-Z]+$/', $_POST["IATAA"])) {
        $arrivoErr = "*Inserisci un aeroporto di arrivo. ";
        $err = true;
    } else {
        $arrivo = sanitize($_POST["IATAA"]);
        if (strlen($arrivo) > 3) { //se è un codice IATA, lo uso direttamente
            $codiciArrivo = aeroportiDaCitta($arrivo);
        } else {
            $codiciArrivo = [$arrivo]; //altrimenti lo considero un codice IATA
        }
    }

    $dataP = sanitize($_POST["dataP"]);
    $dataR = sanitize($_POST["dataR"]);
    $npasseggeri = sanitize($_POST["passeggeri"]);

    //chiamo API Duffer
    if(!$err){ //commenti su quello di sola andata
            global $conn;
            $key="duffel_test_4hbby9qlEb5ibuY-J_GDMMkX74UTsQPEItzMl0mhFMP"; //la mia key 
            foreach($codiciArrivo as $arrivo){
                foreach($codiciPartenza as $partenza){                        
                    $passeggeriArray = [];
                            for ($i = 0; $i < $npasseggeri; $i++) {
                                $passeggeriArray[] = ["type" => "adult"]; //indico il tipo di passeggero
                    }
                    $payload = json_encode([
                            "data" => [
                                "slices" => [
                                    //ANDATA
                                    [   
                                        "origin" => $partenza,      
                                        "destination" => $arrivo,    
                                        "departure_date" => $dataP
                                    ],
                                    //Ritorno
                                    [   
                                        "origin" => $arrivo,        
                                        "destination" => $partenza,
                                        "departure_date" => $dataR 
                                    ]
                                ],
                                "passengers" => $passeggeriArray,
                                "return_offers" => true
                            ]
                    ]);
                    $opzioniDuffel = [
                            'http' => [
                                'method' => 'POST',
                                'header' => "Authorization: Bearer " . $key . "\r\n" .
                                            "Duffel-Version: v2\r\n" .
                                            "Content-Type: application/json\r\n" .
                                            "Accept: application/json\r\n",
                                'content' => $payload,
                                'ignore_errors' => true
                            ]
                    ];

                    //chiamo url API di Duffel
                    $urlRicerca = "https://api.duffel.com/air/offer_requests";
                    $rispostaVoli = @file_get_contents($urlRicerca, false, stream_context_create($opzioniDuffel)); //richiesta effettiva

                    //decodifico i risultati e prendo solo i primi 10 per evitare di sovraccaricare la pagina
                    $datiDecodificati = json_decode($rispostaVoli, true);

                    //salvo negli arry
                    if(isset($datiDecodificati['data']['offers'])){
                            $risultatiVoli = $datiDecodificati['data']['offers'];
                            $risultati = array_slice($risultatiVoli, 0, 10);
                    }
                }
            }
        }
}

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sky&GO - Risultati Ricerca</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f8f9fa] font-sans antialiased text-gray-800">
    <nav
        class="w-full bg-white/90 backdrop-blur-sm shadow-sm py-4 px-8 flex justify-between items-center sticky top-0 z-50">
        <div class="text-2xl font-extrabold text-gray-700 tracking-wide">Sky&GO</div>
        <ul class="hidden md:flex space-x-8 font-semibold text-gray-600 text-sm">
            <a href="../index.php" class="hover:text-[#c88b80] cursor-pointer transition">Home</a>
            <a href="../index.php#hero2" class="hover:text-[#c88b80] cursor-pointer transition">Info</a>
            <a href="accedi.php" class="hover:text-[#c88b80] cursor-pointer transition">Logs</a>
            <a href="../index.php#footer" class="hover:text-[#c88b80] cursor-pointer transition">Contatti</a>
        </ul>
        <div class="space-x-4 flex items-center">
            <a href="#" class="font-semibold text-sm text-gray-700 hover:text-[#c88b80] transition">Accedi</a>
            <a href="#"
                class="bg-[#c88b80] hover:bg-[#b0786d] text-white px-5 py-2 rounded-xl font-semibold text-sm transition shadow-md">Iscriviti</a>
        </div>
    </nav>
    <div class="max-w-6xl mx-auto mt-12 mb-20 px-4">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Risultati della tua ricerca</h1>
            <p class="text-gray-500 mt-2">Ecco i voli disponibili per le date selezionate.</p>
        </div>
        <div class="bg-white shadow-lg rounded-3xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider">
                            <th class="py-4 px-6 font-semibold">Codice Volo</th>
                            <th class="py-4 px-6 font-semibold">Andata</th>
                            <th class="py-4 px-6 font-semibold">Ritorno</th>
                            <th class="py-4 px-6 font-semibold">Data</th>
                            <th class="py-4 px-6 font-semibold">Prezzo</th>
                            <th class="py-4 px-6 font-semibold text-center">Azione</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        
                        <?php

                        //voli di AR
                        if (!empty($risultati)) {
                            foreach ($risultati as $volo) {
                                $idOfferta = $volo['id'];
                                $prezzoTotale = $volo['total_amount'];
                                $valuta = $volo['total_currency'];

                                //dati andata
                                $andata = $volo['slices'][0];
                                $aereoAndata = $andata['segments'][0]; // Primo aereo andata
                                $compagniaAndata = $andata['segments'][0]['operating_carrier']['name'];
                                $codiceVoloAndata = $aereoAndata['operating_carrier']['iata_code'] . " " . $aereoAndata['operating_carrier_flight_number'];
                                $IATAPA = $aereoAndata['origin']['iata_code'];
                                $IATAAA = end($andata['segments'])['destination']['iata_code'];
                                $dataAndataStr = date("d/m/Y", strtotime($aereoAndata['departing_at']));
                                $oraPartenzaAndata = date("H:i", strtotime($aereoAndata['departing_at']));
                                $oraArrivoAndata = date("H:i", strtotime(end($andata['segments'])['arriving_at']));

                                //dati ritorno
                                $ritorno = $volo['slices'][1];
                                $aereoRitorno = $ritorno['segments'][0];
                                $compagniaRitorno = $ritorno['segments'][0]['operating_carrier']['name'];
                                $codiceVoloRitorno = $aereoRitorno['operating_carrier']['iata_code'] . " " . $aereoRitorno['operating_carrier_flight_number'];
                                $iataPartenzaRitorno = $aereoRitorno['origin']['iata_code'];
                                $iataArrivoRitorno = end($ritorno['segments'])['destination']['iata_code'];
                                
                                $dataRitornoStr = date("d/m/Y", strtotime($aereoRitorno['departing_at']));
                                $oraPartenzaRitorno = date("H:i", strtotime($aereoRitorno['departing_at']));
                                $oraArrivoRitorno = date("H:i", strtotime(end($ritorno['segments'])['arriving_at']));

                                echo '<tr class="hover:bg-gray-50 transition duration-150 ease-in-out">';
                                
                                echo '  <td class="py-4 px-6">';
                                echo '      <div class="text-xs text-gray-400 font-bold uppercase mb-1"></div>';
                                echo '      <div class="text-gray-800 font-medium">' . $codiceVoloAndata .'</div>';
                                echo '  </td>';
                                
                                echo '  <td class="py-4 px-6">';
                                echo '      <div class="text-xs text-gray-400 font-bold uppercase mb-1"></div>';
                                echo '      <div class="text-gray-800 font-medium">' . $IATAPA . ' &rarr; <br>' . $IATAAA . '</div>';
                                echo '  </td>';
                                
                                echo '  <td class="py-4 px-6">';
                                echo '      <div class="text-xs text-gray-400 font-bold uppercase mb-1"></div>';
                                echo '      <div class="text-gray-800 font-medium">' . $IATAAA . ' &rarr; <br>' . $IATAPA . '</div>';
                                echo '  </td>';
                                
                                echo '  <td class="py-4 px-6 text-sm text-gray-600">';
                                echo '      <div class="mb-1"><span class="font-bold text-gray-500">A:</span> ' . $dataAndataStr . '</div>';
                                echo '      <div><span class="font-bold text-gray-500">R:</span> ' . $dataRitornoStr . '</div>';
                                echo '  </td>';

                                echo '  <td class="py-4 px-6 font-semibold text-gray-900">€' . $volo["total_amount"] . '</td>';
                                
                                echo '  <td class="py-4 px-6 text-center">';
                                echo '      <a href="prenota.php" class="bg-[#c88b80] hover:bg-[#b0786d] text-white px-4 py-2 rounded-lg font-semibold text-sm transition shadow-md">Prenota</a>';
                                echo '  </td>';
                                echo '</tr>';

                                $_SESSION['idVolo'] = $codiceVoloAndata;
                                $_SESSION['IATAP']=$IATAPA;
                                $_SESSION['IATAA']=$IATAAA;
                                $_SESSION['dataAndata']=$dataAndataStr;
                                $_SESSION['dataRitorno']=$dataRitornoStr;
                                $_SESSION['npasseggeri']=$npasseggeri;
                                $_SESSION['prezzo']=$volo['total_amount'];   
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
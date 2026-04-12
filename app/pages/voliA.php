<?php
    session_start();
    ini_set('memory_limit', '256M'); //pongo lomite a valori generabili per evitare overload
    require_once("connessioneDB.php");
    require_once("generalFunctions.php");
    require_once("../api/apiCall.php");
    

    $err = false;
    //mostra voli solo andata
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!preg_match('/^[a-zA-Z]+$/', $_POST["IATAP"])){
            $partenzaErr = "*Inserisci un aeroporto di partenza. ";
            $err = true;
        }else{
            $partenza = sanitize($_POST["IATAP"]);
            if(strlen($partenza)> 3){
                $codiciPartenza=aeroportiDaCitta($partenza);
                $codiciPartenza = aeroportiDaCitta($partenza);
            }else{
                $codiciPartenza = [$partenza];
            }
        }

        if(!preg_match('/^[a-zA-Z]+$/', $_POST["IATAA"])){
            $arrivoErr = "*Inserisci un aeroporto di arrivo. ";
            $err = true;
        }else{
            $arrivo = sanitize($_POST["IATAA"]);
            if(strlen($arrivo)> 3){ //se è un codice IATA, lo uso direttamente
                $codiciArrivo=aeroportiDaCitta($arrivo);
            }else{
                $codiciArrivo = [$arrivo]; //altrimenti lo considero un codice IATA
            }
        }
        $dataP = sanitize($_POST["dataP"]);
        $npasseggeri =sanitize($_POST["passeggeri"]);

        //chiamata API
        if(!$err){
            $risultati=apiAndata($codiciArrivo, $codiciPartenza, $npasseggeri, $dataP, $key);         
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
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandPrimary: '#C48B7D', /* Il colore salmone/pesca dei bottoni */
                        searchBg: '#F3F5F6',     /* Il grigio chiarissimo del box di ricerca */
                        inputBg: '#E4EBEC'       /* Il grigio degli input field */
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
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
        <div id="logBox" class="flex items-center space-x-6 text-sm font-semibold text-gray-800">
                <?php
                    if(isset($_SESSION['loggato'])&& $_SESSION['loggato']===true){
                        echo $homepageLoggato2;
                    }else{
                        echo $homepageStandard2;
                    }
                ?>
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
                            <th class="py-4 px-6 font-semibold">Compagnia</th>
                            <th class="py-4 px-6 font-semibold">Partenza</th>
                            <th class="py-4 px-6 font-semibold">Arrivo</th>
                            <th class="py-4 px-6 font-semibold">Data</th>
                            <th class="py-4 px-6 font-semibold">Totale (<?php echo $npasseggeri ." pp";?>)</th>
                            <th class="py-4 px-6 font-semibold text-center">Azione</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php
                            if(!empty($risultati)){
                                foreach ($risultati as $volo){
                                    $tratta = $volo['slices'][0]; 
                                    $nomeCompagnia = $volo['owner']['name'];
                                    $aereo = $volo['slices'][0]['segments'][0];
                                    $siglaOperatore = $aereo['operating_carrier']['iata_code'];
                                    $numeroVolo = $aereo['operating_carrier_flight_number'];
                                    $codiceVolo = $siglaOperatore . " " . $numeroVolo;
                                    $partenzaAereo = $tratta['segments'][0];
                                    $arrivoAereo = end($tratta['segments']);
                                    $IATAP = $partenzaAereo['origin']['iata_code'];
                                    $IATAA = $arrivoAereo['destination']['iata_code'];
                                    $oraP = date("H:i", strtotime($partenzaAereo['departing_at']));


                                    echo '<tr class="hover:bg-gray-50 transition duration-150 ease-in-out">';
                                    echo '  <td class="py-4 px-6 font-bold text-gray-700">' .$codiceVolo. '</td>';
                                    echo '  <td class="py-4 px-6 text-gray-600">' .$nomeCompagnia. '</td>';
                                    echo '  <td class="py-4 px-6 text-gray-600">' .$IATAP. '</td>';
                                    echo '  <td class="py-4 px-6 text-gray-600">' .$IATAA. '</td>';
                                    echo '  <td class="py-4 px-6 text-gray-500 text-sm">' .$oraP. '</td>';
                                    echo '  <td class="py-4 px-6 font-bold text-[#c88b80]">€' .$volo['total_amount']. '</td>';
                                    echo '  <td class="py-4 px-6 text-center">';

                                    echo '  <a href="prenota.php" class="bg-[#c88b80] hover:bg-[#b0786d] text-white px-4 py-2 rounded-lg font-semibold text-sm transition shadow-md">Prenota</a>';
                                    $_SESSION['idVolo'] = $codiceVolo;
                                    $_SESSION['IATAP']=$IATAP;
                                    $_SESSION['IATAA']=$IATAA;
                                    $_SESSION['dataP']=$dataP;
                                    $_SESSION['npasseggeri']=$npasseggeri;
                                    $_SESSION['totale']=$volo['total_amount'];
                                    $_SESSION['oraP']=$oraP;
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
<?php
    session_start();
    require_once("connessioneDB.php");
    require_once("generalFunctions.php");

    $err = false;
    $partenzaErr = "";
    $arrivoErr = "";

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
        if(!$err){
            global $conn;
            try{
                $lista_codici_arrivo_sql = "'" . implode("', '", $codiciArrivo) . "'";
                $lista_codici_partenza_sql = "'" . implode("', '", $codiciPartenza) . "'";
                //echo json_encode([$lista_codici_partenza_sql]);
                //echo json_encode([$lista_codici_arrivo_sql]);
                
                $sql = "SELECT * FROM volo WHERE IATAP IN ($lista_codici_partenza_sql) AND IATAA IN ($lista_codici_arrivo_sql) AND DataP = '$dataP'";
                $result = $conn->query($sql);

            } catch(Exception $e){
                echo json_encode(["error" => "Qualcosa è andato storto: " . $e->getMessage()]);
                exit;
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

    <nav class="w-full bg-white/90 backdrop-blur-sm shadow-sm py-4 px-8 flex justify-between items-center sticky top-0 z-50">
        <div class="text-2xl font-extrabold text-gray-700 tracking-wide">Sky&GO</div>
        <ul class="hidden md:flex space-x-8 font-semibold text-gray-600 text-sm">
            <a href="../index.php" class="hover:text-[#c88b80] cursor-pointer transition">Home</a>
            <a href="../index.php#hero2" class="hover:text-[#c88b80] cursor-pointer transition">Info</a>
            <a href="accedi.php" class="hover:text-[#c88b80] cursor-pointer transition">Logs</a>
            <a href="../index.php#footer" class="hover:text-[#c88b80] cursor-pointer transition">Contatti</a>
        </ul>
        <div class="space-x-4 flex items-center">
            <a href="#" class="font-semibold text-sm text-gray-700 hover:text-[#c88b80] transition">Accedi</a>
            <a href="#" class="bg-[#c88b80] hover:bg-[#b0786d] text-white px-5 py-2 rounded-xl font-semibold text-sm transition shadow-md">Iscriviti</a>
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
                            <th class="py-4 px-6 font-semibold">Partenza</th>
                            <th class="py-4 px-6 font-semibold">Arrivo</th>
                            <th class="py-4 px-6 font-semibold">Data</th>
                            <th class="py-4 px-6 font-semibold">Prezzo (pp)</th>
                            <th class="py-4 px-6 font-semibold text-center">Azione</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">


                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<tr class="hover:bg-gray-50 transition duration-150 ease-in-out">';
                                echo '  <td class="py-4 px-6 font-bold text-gray-700">' .$row["ID"]. '</td>';
                                echo '  <td class="py-4 px-6 text-gray-600">' .$row["IATAP"]. '</td>';
                                echo '  <td class="py-4 px-6 text-gray-600">' .$row["IATAA"]. '</td>';
                                echo '  <td class="py-4 px-6 text-gray-500 text-sm">' .$row["DataP"]. '</td>';
                                echo '  <td class="py-4 px-6 font-bold text-[#c88b80]">€' .$row["Prezzo"]. '</td>';
                                echo '  <td class="py-4 px-6 text-center">';
                                echo '  <a href="prenota.php?ID=' . $row["ID"] . '" class="bg-[#c88b80] hover:bg-[#b0786d] text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-sm">Prenota</a>';
                                echo '  </td>';
                                echo '</tr>';
                                $_SESSION['idVolo'] = $row["ID"];
                            }
                        } else {
                            echo '<tr><td colspan="6" class="py-8 text-center text-gray-500">Nessun volo trovato per questa ricerca.</td></tr>';
                        }
                        ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
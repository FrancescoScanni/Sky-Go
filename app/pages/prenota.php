<?php
    session_start();
    require_once("generalFunctions.php");
    require_once("connessioneDB.php");
    require_once("../models/prenotazione.php");
    
    if($_SESSION['loggato'] == false){
        header("Location: accedi.php");
        exit;
    }

    //info passeggero
    $sqlPasseggero = "SELECT * FROM passeggero WHERE ID=" . $_SESSION['userID'];
    $resultPasseggero = $conn->query($sqlPasseggero);
    $rowPasseggero = $resultPasseggero->fetch_assoc(); 

    //info volo
    $idVolo= $_SESSION['idVolo'];
    $IATAP= $_SESSION['IATAP'];
    $IATAA= $_SESSION['IATAA'] ?? '';
    $dataP= $_SESSION['dataP'] ?? '';
    $oraP= $_SESSION['oraP'] ?? '';
    $npasseggeri  = $_SESSION['npasseggeri'];
    $prezzo= $_SESSION['prezzo'];


    if($_SESSION['idVolo'] == 0) {
        header("Location: voliA.php");
        exit;
    }else{
        $idVolo = $_SESSION['idVolo'];
    }
    
    $sql= "SELECT * FROM volo WHERE ID='" . $idVolo . "'";
    $result = $conn->query($sql);
    $row=$result->fetch_assoc();

    //posti d checkbox
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(isset($_GET["posti"])){
            $posti = $_GET["posti"];
            $_SESSION['posti'] = $posti;
            //echo "Posti selezionati: " . implode(", ", $posti);
        }else{
            $posti = [];
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST["posti"])){
            $posti=$_SESSION['posti'];
        }else{
            $posti=$_SESSION['posti'];
            if(empty($posti)){
                echo "<script>alert('Selezionare almeno un posto!'); window.location.href=\"prenota.php\"</script>"; 
                exit;
            }
            
        }
        $numPosti = count($posti);
        foreach($posti as $posto){
            $dataPrenotazione = date("Y-m-d");
            $IDPasseggero = $_SESSION['userID'];
            $prenotazione = new Prenotazione($dataPrenotazione, $posto, $idVolo, $IDPasseggero);
            $prenotazione->salvaPrenotazione();
            header("Location: prenotazioni.php");
        }
        echo "Prenotazione completata con successo!";
    }
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sky&GO - Essenziale</title>
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
<body class="bg-gray-100 text-gray-800 font-sans">

    <nav class="w-full bg-white/90 backdrop-blur-sm shadow-sm py-4 px-8 flex justify-between items-center sticky top-0 z-50">
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
                        echo $homepageStandard;
                    }
                ?>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto my-10 p-6 bg-white rounded-xl shadow-md flex flex-col md:flex-row gap-8">
        
        <div class="flex-1 md:border-r border-gray-200 pr-4">
            <h2 class="text-lg font-bold mb-4 border-b pb-2">Itinerario</h2>
            
            <div class="mb-6">
                <p class="text-xs text-gray-500 font-bold tracking-wider">ID: <?php echo $idVolo; ?></p>
                <p class="text-lg font-bold"><?php echo $IATAP; ?> &rarr; <?php echo $IATAA; ?></p>
                <p class="text-sm text-gray-500"><?php echo $dataP; ?> <br><?php echo $oraP; ?></p>
            </div>

            <form action="prenota.php" method="POST">
                <div class="mb-6">
                    <h3 class="font-bold mb-2">Passeggeri</h3>
                    <div class="flex justify-between text-sm py-1 border-b border-gray-50">
                        <span><?php echo $rowPasseggero['Nome']; ?> <?php echo $rowPasseggero['Cognome']; ?></span> 
                        <span class="bg-gray-200 text-xs px-2 py-1 rounded"> <?php echo "Posti scelti: " . implode(", ", $posti); ?></span>
                    </div>
                    <div class="flex justify-between text-sm py-1">
                        <span>Bagagli:</span> 
                        <span class="bg-gray-200 text-xs px-2 py-1 rounded"><input disabled type="number" value="0" placeholder="" name="bagagli" max="59" min="0" required></span>
                    </div>
                </div>
            
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between text-sm mb-1"><span>Volo</span> <span><?php $tot=$prezzo * count($posti); echo $tot; $tasse=$tot * 0.05; ?> €</span></div>
                    <div class="flex justify-between text-sm mb-1"><span>Tasse</span> <span><?php if($prezzo>0 && count($posti)>0){ echo number_format($tasse, 2);
                                                                                                    }else{ echo "0.00"; } ?> €</span></div>
                    <div class="flex justify-between font-bold border-t border-gray-300 mt-2 pt-2 text-lg">
                        <span>Totale</span> <span class="text-orange-500"><?php if($prezzo>0 && count($posti)>0){ echo number_format(($prezzo * count($posti)) + $tasse, 2);
                                                                                                    }else{ echo "0.00"; } ?> €</span>
                    </div>
                </div>

                <div class="flex justify-center mt-6">
                    <input type="submit" value="Prenota ora" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 font-semibold">
                    </input>
                </div>
            </form>
        </div>


        <form action="prenota.php" method="GET" class="flex-1">
            <h2 class="text-lg font-bold mb-6 text-center">Scegli il posto</h2>
            <div class="flex flex-col gap-2 items-center mt-4">
                <?php 
                $numero_posto = 0;
                for ($fila = 1; $fila <= 10; $fila++) { 
                ?>
                    <div class="flex gap-8 <?php if ($fila == 5) echo 'mb-6'; ?>">         
                        <div class="flex gap-1">
                            <div>
                                <input type="checkbox" name="posti[]" id="posto_<?php echo $numero_posto; ?>" value="<?php echo $numero_posto; ?>" class="peer hidden">
                                <label for="posto_<?php echo $numero_posto; ?>" class="flex items-center justify-center w-6 h-6 text-[10px] select-none bg-gray-100 border border-gray-300 rounded-sm cursor-pointer hover:bg-gray-200 peer-checked:bg-orange-400 peer-checked:border-orange-500 peer-checked:text-white transition-colors">
                                    <?php echo $numero_posto; ?>
                                </label>
                            </div>
                            <?php $numero_posto++; ?>
                                                      <div>
                                <input type="checkbox" name="posti[]" id="posto_<?php echo $numero_posto; ?>" value="<?php echo $numero_posto; ?>" class="peer hidden">
                                <label for="posto_<?php echo $numero_posto; ?>" class="flex items-center justify-center w-6 h-6 text-[10px] select-none bg-gray-100 border border-gray-300 rounded-sm cursor-pointer hover:bg-gray-200 peer-checked:bg-orange-400 peer-checked:border-orange-500 peer-checked:text-white transition-colors">
                                    <?php echo $numero_posto; ?>
                                </label>
                            </div>
                            <?php $numero_posto++; ?>
                                                        <div>
                                <input type="checkbox" name="posti[]" id="posto_<?php echo $numero_posto; ?>" value="<?php echo $numero_posto; ?>" class="peer hidden">
                                <label for="posto_<?php echo $numero_posto; ?>" class="flex items-center justify-center w-6 h-6 text-[10px] select-none bg-gray-100 border border-gray-300 rounded-sm cursor-pointer hover:bg-gray-200 peer-checked:bg-orange-400 peer-checked:border-orange-500 peer-checked:text-white transition-colors">
                                    <?php echo $numero_posto; ?>
                                </label>
                            </div>
                            <?php $numero_posto++; ?>
                        </div>
                        <div class="flex gap-1">
                            <div>
                                <input type="checkbox" name="posti[]" id="posto_<?php echo $numero_posto; ?>" value="<?php echo $numero_posto; ?>" class="peer hidden">
                                <label for="posto_<?php echo $numero_posto; ?>" class="flex items-center justify-center w-6 h-6 text-[10px] select-none bg-gray-100 border border-gray-300 rounded-sm cursor-pointer hover:bg-gray-200 peer-checked:bg-orange-400 peer-checked:border-orange-500 peer-checked:text-white transition-colors">
                                    <?php echo $numero_posto; ?>
                                </label>
                            </div>
                            <?php $numero_posto++; ?>
                            
                            <div>
                                <input type="checkbox" name="posti[]" id="posto_<?php echo $numero_posto; ?>" value="<?php echo $numero_posto; ?>" class="peer hidden">
                                <label for="posto_<?php echo $numero_posto; ?>" class="flex items-center justify-center w-6 h-6 text-[10px] select-none bg-gray-100 border border-gray-300 rounded-sm cursor-pointer hover:bg-gray-200 peer-checked:bg-orange-400 peer-checked:border-orange-500 peer-checked:text-white transition-colors">
                                    <?php echo $numero_posto; ?>
                                </label>
                            </div>
                            <?php $numero_posto++; ?>
                            
                            <div>
                                <input type="checkbox" name="posti[]" id="posto_<?php echo $numero_posto; ?>" value="<?php echo $numero_posto; ?>" class="peer hidden">
                                <label for="posto_<?php echo $numero_posto; ?>" class="flex items-center justify-center w-6 h-6 text-[10px] select-none bg-gray-100 border border-gray-300 rounded-sm cursor-pointer hover:bg-gray-200 peer-checked:bg-orange-400 peer-checked:border-orange-500 peer-checked:text-white transition-colors">
                                    <?php echo $numero_posto; ?>
                                </label>
                            </div>
                            <?php $numero_posto++; ?>
                        </div>
                    </div> 
                <?php 
                } 
                ?>
            </div> 

            <div class="flex justify-center gap-4 mt-8 text-xs text-gray-600">
                <span class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-gray-100 border border-gray-300 rounded-sm"></div> Libero
                </span>
                <span class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-gray-300 rounded-sm"></div> Occupato
                </span>
                <span class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-orange-400 rounded-sm"></div> Scelto
                </span>
            </div>

            <div class="flex justify-center mt-6">
                <input type="submit" value="Seleziona" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 font-bold transition-colors">
                </input>
            </div>
        </form>
</body>
</html>
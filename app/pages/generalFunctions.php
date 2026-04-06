<?php

    //funzione per sanitize inut da form
    function sanitize($data){
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }

    //adatto nome città ad aeroporti anche se user inserisce solo città
    function aeroportiDaCitta($citta){
        global $conn;
        $sql= "SELECT IATA FROM aeroporto WHERE Città='$citta'";
        $aeroportiCitta= $conn->query($sql);
        $codiciAeroporti = [];
        if($aeroportiCitta->num_rows > 0){ 
            //echo json_encode($aeroportiCitta->fetch_assoc());
            while($row = $aeroportiCitta->fetch_assoc()){
                //echo json_encode($row["IATA"]);
                $codiciAeroporti[] = $row["IATA"];
            }
        }
        return $codiciAeroporti;
    }    



    //banner di log riuscito/fallito
    $registrazioneSuccesso= '<div onclick="this.remove()" class="fixed top-10 right-5 z-50 animate-bounce">
                                <div class="bg-white border-l-4 border-green-500 shadow-lg p-4 flex items-center space-x-3 rounded-r-lg">
                                    <span class="text-green-500 font-bold text-xl">✓</span>
                                    <div class="text-gray-800 font-medium">Registrazione completata!</div>
                                </div>
                            </div>';

    $loginFallito= '<div onclick="this.remove()" class="fixed top-10 right-5 z-50 animate-bounce">
                        <div class="bg-white border-l-4 border-red-500 shadow-lg p-4 flex items-center space-x-3 rounded-r-lg">
                            <span class="text-red-500 font-bold text-xl">✗</span>
                            <div class="text-gray-800 font-medium">Credenziali errate!</div>
                        </div>
                    </div>';


    //banner per caselle di accesso su homepage
    $homepageStandard='<a href="pages/accedi.php" class="hover:text-brandPrimary transition">Accedi</a>
                        <a href="pages/registra.php" class="bg-brandPrimary hover:bg-opacity-90 text-white px-6 py-2.5 rounded-lg transition shadow-md">Iscriviti</a>';
    $homepageStandard2='<a href="accedi.php" class="hover:text-brandPrimary transition">Accedi</a>
                        <a href="registra.php" class="bg-brandPrimary hover:bg-opacity-90 text-white px-6 py-2.5 rounded-lg transition shadow-md">Iscriviti</a>';

    $homepageLoggato='<a href="pages/profilo.php" class="bg-brandPrimary hover:bg-opacity-90 text-white px-6 py-2.5 rounded-lg transition shadow-md">Profilo</a>
                    <a href="pages/logout.php" onclick="return confirm(\'Sei sicuro di voler uscire?\')" class="text-gray-500 hover:text-gray-800 text-sm hover:underline transition">Logout</a>';
    $homepageLoggato2='<a href="profilo.php" class="bg-brandPrimary hover:bg-opacity-90 text-white px-6 py-2.5 rounded-lg transition shadow-md">Profilo</a>
                    <a href="logout.php" onclick="return confirm(\'Sei sicuro di voler uscire?\')" class="text-gray-500 hover:text-gray-800 text-sm hover:underline transition">Logout</a>';

    //messaggio accettazione cookie
    $cookieMsg='<div id="cookieBanner" class="fixed bottom-0 left-0 right-0 bg-gray-800 text-white p-4 flex items-center justify-between z-50">
                    <span class="text-sm">Questo sito utilizza cookie per migliorare l\'esperienza dell\'utente. Continuando a navigare, accetti l\'uso dei cookie. <a href="link di iubenda" class="text-white underline">Scopri di più</a></span>
                    <a href="pages/cookieManagment.php" class="bg-brandPrimary hover:bg-opacity-90 text-white px-4 py-2 rounded-lg transition">Accetta</a>
                </div>';



    
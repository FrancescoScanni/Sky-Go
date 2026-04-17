<?php

    //function to sanitize input from forms
    function sanitize($data){
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }

    //adapts city name to airports even if the user only enters the city
    function aeroportiDaCitta($citta){
        global $conn;
        $sql= "SELECT IATA FROM aeroporto WHERE Citta='$citta'";
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



    //success/failed log banners
    $registrazioneSuccesso= '<div onclick="this.remove()" class="fixed top-10 right-5 z-50 animate-bounce">
                                <div class="bg-white border-l-4 border-green-500 shadow-lg p-4 flex items-center space-x-3 rounded-r-lg">
                                    <span class="text-green-500 font-bold text-xl">✓</span>
                                    <div class="text-gray-800 font-medium">Registration completed!</div>
                                </div>
                            </div>';

    $giaPresente= '<div onclick="this.remove()" class="fixed top-10 right-5 z-50 animate-bounce">
                                <div class="bg-white border-l-4 border-green-500 shadow-lg p-4 flex items-center space-x-3 rounded-r-lg">
                                    <div class="text-gray-800 font-medium">User already exists. Please log in</div>
                                </div>
                            </div>'; 

    $loginFallito= '<div onclick="this.remove()" class="fixed top-10 right-5 z-50 animate-bounce">
                        <div class="bg-white border-l-4 border-red-500 shadow-lg p-4 flex items-center space-x-3 rounded-r-lg">
                            <span class="text-red-500 font-bold text-xl">✗</span>
                            <div class="text-gray-800 font-medium">Invalid credentials!</div>
                        </div>
                    </div>';


    //banners for access boxes on homepage
    $homepageStandard='<a href="pages/accedi.php" class="hover:text-brandPrimary transition">Log In</a>
                        <a href="pages/registra.php" class="bg-brandPrimary hover:bg-opacity-90 text-white px-6 py-2.5 rounded-lg transition shadow-md">Sign Up</a>';
    $homepageStandard2='<a href="accedi.php" class="hover:text-brandPrimary transition">Log In</a>
                        <a href="registra.php" class="bg-brandPrimary hover:bg-opacity-90 text-white px-6 py-2.5 rounded-lg transition shadow-md">Sign Up</a>';

    $homepageLoggato='<a href="#" class="bg-brandPrimary hover:bg-opacity-90 text-white px-6 py-2.5 rounded-lg transition shadow-md">Logged In!</a>
                    <a href="pages/logout.php" onclick="return confirm(\'Are you sure you want to log out?\')" class="text-gray-500 hover:text-gray-800 text-sm hover:underline transition">Logout</a>';
    $homepageLoggato2='<a href="#" class="bg-brandPrimary hover:bg-opacity-90 text-white px-6 py-2.5 rounded-lg transition shadow-md">Logged In!</a>
                    <a href="logout.php" onclick="return confirm(\'Are you sure you want to log out?\')" class="text-gray-500 hover:text-gray-800 text-sm hover:underline transition">Logout</a>';

    //cookie acceptance message
    $cookieMsg='<div id="cookieBanner" class="fixed bottom-0 left-0 right-0 bg-gray-800 text-white p-4 flex items-center justify-between z-50">
                    <span class="text-sm">This website uses cookies to improve the user experience. By continuing to browse, you agree to our use of cookies. <a href="link to iubenda" class="text-white underline">Find out more</a></span>
                    <a href="pages/cookieManagment.php" class="bg-brandPrimary hover:bg-opacity-90 text-white px-4 py-2 rounded-lg transition">Accept</a>
                </div>';
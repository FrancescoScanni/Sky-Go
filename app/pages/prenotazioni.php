<?php
    session_start();
    require_once("generalFunctions.php");
    require_once("../models/prenotazione.php");

    $user=$_SESSION['userID'];
    $rowPrenotazione = Prenotazione::recuperaPrenotazione($user);

?>


<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sky&GO - Le tue prenotazioni</title>
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
<body class="bg-[#f8f9fa] min-h-screen font-sans">

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

  <main class="max-w-6xl mx-auto mt-14 px-6">
    <h1 class="text-3xl font-bold text-slate-800 mb-2">Le tue prenotazioni</h1>
    <p class="text-gray-500 mb-10">Ecco lo storico di tutti i voli che hai prenotato.</p>

    <div class="w-[65vw] bg-white rounded-3xl shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden">
      <table class="w-[80vw] text-left border-collapse">
        
        <thead>
          <tr class="text-xs text-gray-500 uppercase tracking-wider border-b border-gray-100 bg-white">
            <th class="px-8 py-6 font-semibold">Data Prenotazione</th>
            <th class="px-8 py-6 font-semibold">Codice Volo</th>
            <th class="px-8 py-6 font-semibold">Posto</th>
            <th class="px-8 py-6 font-semibold">Bagaglio</th>
          </tr>
        </thead>
        
        <tbody class="text-sm text-gray-700">
          <?php
            if ($rowPrenotazione && $rowPrenotazione->num_rows > 0) {
                    // Usiamo il while per estrarre ogni riga come array associativo
                    while($row = $rowPrenotazione->fetch_assoc()) {
                        echo '<tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">';
                        echo '  <td class="px-8 py-5 text-gray-400">' . $row["DataPrenotazione"] . '</td>';
                        echo '  <td class="px-8 py-5 font-bold text-slate-800">' . $row["IDVolo"] . '</td>';
                        echo '  <td class="px-8 py-5 text-gray-600">' . $row["Posto"] . '</td>';
                        echo '  <td class="px-8 py-5 text-gray-600">' . ($row["bagaglio"] ?? "No") . '</td>';
                        echo '  <td class="px-8 py-5">';
                        echo '  </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6" class="px-8 py-12 text-center text-gray-400 italic">Nessuna prenotazione trovata.</td></tr>';
                }
            
            ?>
        </tbody>
      </table>
    </div>
  </main>

</body>
</html>
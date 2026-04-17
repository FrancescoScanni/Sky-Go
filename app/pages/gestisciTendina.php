<?php
    require_once("../index.php");
    require_once("connessioneDB.php");

    $q = $_GET['q'];

    if (strlen($q) > 1) {
        global $conn;
        $sql = "SELECT nome_aeroporto FROM aeroporti WHERE nome_aeroporto LIKE '%$q%' LIMIT 5";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            // Securely prepare the name
            $nome = htmlspecialchars($row['nome_aeroporto'], ENT_QUOTES);
            
            // Print a clickable element. When clicked, it calls the JS function 'selezionaAeroporto'
            echo "<div onclick=\"selezionaAeroporto('$nome')\" class='px-4 py-3 cursor-pointer hover:bg-gray-100 text-sm text-gray-700 border-b border-gray-100 last:border-0'>";
            echo "<i class='fa-solid fa-plane text-gray-400 mr-2'></i>" . $nome;
            echo "</div>";
        }
    } else {
        echo "<div class='px-4 py-3 text-sm text-gray-500'>Enter at least 2 characters to see suggestions.</div>";        
    }
?>
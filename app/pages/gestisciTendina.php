<?php
    require_once("../index.php");
    require_once("connessioneDB.php");

    $q = $_GET['q'];

    if (strlen($q) > 1) {
        global $conn;
        $sql = "SELECT nome_aeroporto FROM aeroporti WHERE nome_aeroporto LIKE '%$q%' LIMIT 5";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
        // Prepara il nome in modo sicuro
        $nome = htmlspecialchars($row['nome_aeroporto'], ENT_QUOTES);
        
        // Stampa un elemento cliccabile. Quando cliccato, chiama la funzione JS 'selezionaAeroporto'
        echo "<div onclick=\"selezionaAeroporto('$nome')\" class='px-4 py-3 cursor-pointer hover:bg-gray-100 text-sm text-gray-700 border-b border-gray-100 last:border-0'>";
        echo "<i class='fa-solid fa-plane text-gray-400 mr-2'></i>" . $nome;
        echo "</div>";
    }
    } else {
        echo "<div class='px-4 py-3 text-sm text-gray-500'>Inserisci almeno 2 caratteri per visualizzare i suggerimenti.</div>";        
    }
?>
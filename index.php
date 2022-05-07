<?php

$dbhost = "localhost";
$username = "root";
$password = "root";
$db = "csv-import";

$mysqli = new mysqli($dbhost, $username, $password, $db);

$fileName = 'nobel-prize-winners.csv';
$file = fopen($fileName, "r");
$arrResult = array();

while($data = fgetcsv($file, null, ",")){ // Scorre il file e salva ogni riga in un array
    $arrResult[] = $data;
}

foreach ($arrResult as $row) { // Per ogni riga
    if ($row != $arrResult[0]) { // Se non è la riga iniziale (titoli delle colonne)
        if ($row[3] != null) { // Se la descrizione non è vuota

            // Variabili con i valori
            $year = $row[0];
            $discipline = $row[1];
            $winner = str_replace("'", "\'", $row[2]); // Ignora le virgolette nel nome e nella descrizione
            $description = str_replace("'", "\'", $row[3]);
    
            $insert = "INSERT INTO nobel_prize_winners(year, discipline, winner, description) VALUES('$year', '$discipline', '$winner', '$description')";
            $mysqli->query($insert); // Inserisce nel db
        }
    }
}
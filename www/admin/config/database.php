<?php
require 'constants.php';

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(mysqli_errno($connection)){
    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
    die(mysqli_error($connection));
}
// // SQL-Abfrage ausführen
// $sql = "SELECT * FROM notes";
// $result = $connection->query($sql);

// // Überprüfen, ob Ergebnisse vorhanden sind
// if ($result->num_rows > 0) {
//     // Daten ausgeben
//     while($row = $result->fetch_assoc()) {
//         echo "ID: " . $row["id"]. " - Title: " . $row["title"]. " - Description: " . $row["description"]. "<br>";
//     }
// } else {
//     echo "0 Ergebnisse gefunden";
// }

// Verbindung schließen
// $connection->close();
?>

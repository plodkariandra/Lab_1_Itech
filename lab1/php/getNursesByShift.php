<?php 
include("dbConnect.php");

$shift = $_GET['shift'];

$stmt = $db->prepare("SELECT * from `nurse` where `shift` = ?");

$stmt->execute(array($shift));

print "<table border='1'><tr><caption>Nurses that works on the $shift shift <br></caption><th> Nurses </th></tr>";
while ($row = $stmt->fetch(PDO::FETCH_KEY_PAIR)) {
    print "<tr><td>$row[name]</td></tr>";
}
?>
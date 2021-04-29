<?php 
include("dbConnect.php");

$name = $_GET['name'];

$stmt = $db->prepare("SELECT `name` from `WARD` where `ID_WARD` in (select `FID_WARD` from `NURSE_WARD` where `FID_NURSE` = (SELECT `ID_NURSE` from `NURSE` WHERE `name` = ?))");
$stmt->execute(array($name));

print "<table border='1'><tr><caption> WARDS with $name <br></caption><th> WARDS </th></tr>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    print "<tr><td>$row[name]</td></tr>";
}
?>
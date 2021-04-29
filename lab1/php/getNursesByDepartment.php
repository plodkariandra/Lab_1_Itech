<?php 
include("dbConnect.php");

$department = $_GET['name'];

$stmt = $db->prepare("SELECT `name` from `nurse` where `department` = ?");
$stmt->execute(array($department));

print "<table border='1'><tr><caption> Nurses in department $department <br></caption><th> Nurses </th></tr>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    print "<tr><td>$row[name]</td></tr>";
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="indexScript.js"></script>
    <style>
    div{
        margin: 20px;
    }
    </style>
</head>
<body>
<div>
   <label>Get wards by nurse:</label>
   </br>
   <select id="nurse">
    <?php
	echo phpinfo();
	die(0);
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

        require_once __DIR__ . "/vendor/autoload.php";
        $collection = (new MongoDB\Client)->lab2->duties;
        $cursor = $collection->find();
        $nurses = [];
        foreach ($cursor as $document) {
            foreach ($document['nurses'] as $nurse) {
                array_push($nurses, $nurse);
            }
        }
        $nurses = array_unique($nurses);
        foreach ($nurses as $nurse) {
            echo "<option value='$nurse'>$nurse</option>";
        }
    ?>
    </select>
    <input type="button" value="Select" onclick="getWards();">
    <br><table>
        <thead>
            <th style = 'border: 1px solid'>WardName</th>
        </thead>
        <tbody id="wardsTable"></tbody>
    </table>
    <br><span>Previous Response</span>
    <br><table>
        <thead>
            <th style = 'border: 1px solid'>WardName</th>
        </thead>
        <tbody id="wardsTablePrev"></tbody>
    </table>
</div>
<div>
   <label> Get duties by shift and department:</label>
   </br>
   <span>Shift</span><br>
    <select id="shift">
    <?php
        require_once __DIR__ . "/vendor/autoload.php";
        $collection = (new MongoDB\Client)->lab2->duties;
        $cursor = $collection->find();
        $shifts = [];
        foreach ($cursor as $document) {
                array_push($shifts, $document['shift']);
        }
        $shifts = array_unique($shifts);
        foreach ($shifts as $shift) {
            echo "<option value='$shift'>$shift</option>";
        }
    ?>
    </select><br>
    <span>Department</span><br>
    <select name="department" id="department">
    <?php
        require_once __DIR__ . "/vendor/autoload.php";
        $collection = (new MongoDB\Client)->lab2->duties;
        $cursor = $collection->find();
        $departments = [];
        foreach ($cursor as $document) {
                array_push($departments, $document['department']);
        }
        $departments = array_unique($departments);
        foreach ($departments as $department) {
            echo "<option value='$department'>$department</option>";
        }
    ?>
    </select>
    <input type="button" value="Select" onclick="getDuties();">
    <br><table>
        <thead>
            <th style = 'border: 1px solid'>Shift</th>
            <th style = 'border: 1px solid'>Date</th>
            <th style = 'border: 1px solid'>Nurse</th>
            <th style = 'border: 1px solid'>Department</th>
            <th style = 'border: 1px solid'>Ward</th>
        </thead>
        <tbody id="dutiesTable"></tbody>
    </table>
    <br><span>Previous Response</span>
    <br><table>
        <thead>
            <th style = 'border: 1px solid'>Shift</th>
            <th style = 'border: 1px solid'>Date</th>
            <th style = 'border: 1px solid'>Nurse</th>
            <th style = 'border: 1px solid'>Department</th>
            <th style = 'border: 1px solid'>Ward</th>
        </thead>
        <tbody id="dutiesTablePrev"></tbody>
    </table>
</div>
<div>
    <label>Get nurses by department:</label>
    </br>
   <select id="department2">
    <?php
        require_once __DIR__ . "/vendor/autoload.php";
        $collection = (new MongoDB\Client)->dbforlab->duties;
        $cursor = $collection->find();
        $departments = [];
        foreach ($cursor as $document) {
                array_push($departments, $document['department']);
        }
        $departments = array_unique($departments);
        foreach ($departments as $department) {
            echo "<option value='$department'>$department</option>";
        }
    ?>
    </select>
    <input type="button" value="GET" onclick="getNurses();">
    <br><table>
        <thead>
            <th style = 'border: 1px solid'>Nurses</th>
        </thead>
        <tbody id="nursesTable"></tbody>
    </table>
    <br><span>Previous Response</span>
    <br><table>
        <thead>
            <th style = 'border: 1px solid'>Nurses</th>
        </thead>
        <tbody id="nursesTablePrev"></tbody>
    </table>
</div>
</body>
</html>
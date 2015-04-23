
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$json_output = '{';
$json_output .= '"nodes": ';
$json_output .= '[';

$sql1 = "SELECT id, attribute_value, x1.x, y1.y from (select id as id1,attribute_value as x from node_table where attribute = 'x') AS x1, (select id as id2,attribute_value as y from node_table where attribute = 'y') AS y1, node_table WHERE attribute='title' and x1.id1 = node_table.id and y1.id2 = node_table.id";
$result1 = $conn->query($sql1);

for($x = 0 ; $x < $result1->num_rows ; $x++)
{
	$row1 = mysqli_fetch_assoc($result1);

	if($x != 0) {$json_output .= ',';};
	$json_output .= '{';
	$json_output .= '"id": ';
	$json_output .= '"' . $row1["id"] . '"';
	$json_output .= ', "label": ';
	$json_output .= '"' . $row1["id"] . '"';
	$json_output .= ', "title": ';
	$json_output .= '"' . $row1["attribute_value"] . '"';
	$json_output .= ', "x": ';
	$json_output .= '"' . $row1["x"] . '"';
	$json_output .= ', "y": ';
	$json_output .= '"' . $row1["y"] . '"';
	$json_output .= ', "value": ';
	$json_output .= '"20"';
	$json_output .= '}';
}

$json_output .= ']';
$json_output .= ',';
$json_output .= '"edges": ';
$json_output .= '[';

$sql = "SELECT from1, to1 FROM edge_table";
$result = $conn->query($sql);

for($x = 0 ; $x < $result->num_rows ; $x++)
{
	$row = mysqli_fetch_assoc($result);

	if($x != 0) {$json_output .= ',';};
	$json_output .= '{';
	$json_output .= '"from": ';
	$json_output .= '"' . $row["from1"] . '"';

	$json_output .= ', "to": ';
	$json_output .= '"' . $row["to1"] . '"';
	
	//$json_output .= ', "value": ';
	//$json_output .= '"' . $row['relation1'] . '"';
	$json_output .= '}';
}

$json_output .= ']';
$json_output .= '}';

echo $json_output;

$conn->close();
?> 

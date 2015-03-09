
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

$sql = "SELECT from1, to1, relation1 FROM visual1";
$result = $conn->query($sql);

$json_output = '{';
$json_output .= '"nodes": ';
$json_output .= '[';

$sql1 = "SELECT from1 FROM (SELECT from1 FROM visual1 UNION SELECT to1 FROM visual1) AS nodes";
$result1 = $conn->query($sql1);

for($x = 0 ; $x < $result1->num_rows ; $x++)
{
	$row1 = mysqli_fetch_assoc($result1);

	if($x != 0) {$json_output .= ',';};
	$json_output .= '{';
	$json_output .= '"id": ';
	$json_output .= '"' . $row1["from1"] . '"';
	$json_output .= '}';
}

$json_output .= ']';
$json_output .= ',';
$json_output .= '"edges": ';
$json_output .= '[';

for($x = 0 ; $x < $result->num_rows ; $x++)
{
	$row = mysqli_fetch_assoc($result);

	if($x != 0) {$json_output .= ',';};
	$json_output .= '{';
	$json_output .= '"from": ';
	$json_output .= '"' . $row["from1"] . '"';

	$json_output .= ', "to": ';
	$json_output .= '"' . $row["to1"] . '"';
	
	$json_output .= ', "relation": ';
	$json_output .= '"' . $row['relation1'] . '"';
	$json_output .= '}';
}

$json_output .= ']';
$json_output .= '}';

echo $json_output;

//echo json_encode($json_output);
//echo json_encode(array('json' => $json_output));

$conn->close();
?> 

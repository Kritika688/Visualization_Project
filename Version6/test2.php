
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

$node1 = $_POST['node'];	
$node1 = $node1[0];

$json_output = '{';
$json_output .= '"nodes": ';
$json_output .= '[';

$sql1 = "SELECT nodes.to1, N.attribute_value, x1.x, y1.y FROM ((SELECT to1 FROM edge_table WHERE from1 LIKE '".$node1."' OR to1 LIKE '".$node1."') UNION (SELECT from1 FROM edge_table WHERE to1 LIKE '".$node1."' OR from1 LIKE '".$node1."') UNION (SELECT id FROM node_table WHERE id LIKE '".$node1."')) AS nodes, (select id as id1,attribute_value as x from node_table1 where attribute = 'x') AS x1, (select id as id2,attribute_value as y from node_table1 where attribute = 'y') AS y1, node_table N WHERE N.id = nodes.to1 AND N.attribute = 'title' AND N.id=x1.id1 AND N.id=y1.id2";

$result1 = $conn->query($sql1);

for($x = 0 ; $x < $result1->num_rows ; $x++)
{
	$row1 = mysqli_fetch_assoc($result1);

	if($x != 0) {$json_output .= ',';};
	$json_output .= '{';
	$json_output .= '"id": ';
	$json_output .= '"' . $row1["to1"] . '"';
	if($node1 == $row1["to1"])
	{
		$json_output .= ', "color": ';
		$json_output .= '"pink"';
	}

	$json_output .= ', "title": ';
	$json_output .= '"' . $row1["attribute_value"] . '"';
	$json_output .= '}';
}

$json_output .= ']';
$json_output .= ',';
$json_output .= '"edges": ';
$json_output .= '[';

$sql = "SELECT * FROM edge_table WHERE from1 LIKE '".$node1."' OR to1 LIKE '".$node1."'";
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
	
	// change value to relation if highlight not required  #848484
	/*$json_output .= ', "value": ';
	$json_output .= '"' . $row['relation1'] . '"';*/
	
	$json_output .= ', "color": ';
	$json_output .= '"#86c5da"';
	
	$json_output .= '}';
}

$json_output .= ']';
$json_output .= '}';

echo $json_output;
$conn->close();
?> 


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

$node2 = $_POST['node'];	
$node2 = $node2[0];

$sql = "SELECT attribute, attribute_value FROM node_table WHERE id LIKE '".$node2."'";
$result2 = $conn->query($sql);

$info_output = '<br>';

for($x = 0 ; $x < $result2->num_rows ; $x++)
{
	$row1 = mysqli_fetch_assoc($result2);
	$info_output .=  $row1["attribute"] ;
	$info_output .= ' : ';
	$info_output .=  $row1["attribute_value"] ;
	$info_output .= '<br>';
}

echo $info_output;
$conn->close();
?> 

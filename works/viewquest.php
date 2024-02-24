<html>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "jsonofquestion";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$ID = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM questions WHERE id = ?");
$stmt->bind_param("i", $ID); // "i" denotes the type of the parameter, i.e., integer
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$rowTx = $row["questionText"];
$rowTy = $row["questionType"];
$rowCA = $row["corrAns"];
echo $rowTx.'<br>'.$rowTy.'<br>'.$rowCA.'<br>';

$stmt = $conn->prepare("SELECT * FROM feedback WHERE questionID = ?");
$stmt->bind_param("i", $ID); // "i" denotes the type of the parameter, i.e., integer
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
  echo $row["questionID"].":";
  echo $row["feedback"].'<br>';
  if($rowTy == 2 or $rowTy == 3) {
    if($row["feedback"]==$rowCA){echo "Correct".'<br>';}
    else{echo "False".'<br>';}
  }//make for other types of questions.
}
?>

</body>
</html>
<!DOCTYPE html>
<html>
<body>
<style>
body{
  background-color: brown;
  color: white;
}
.grid{
  display: grid;
}
.container{
  display: grid;
  grid-template-rows: auto;
}
</style>
<div class="container">
<form method="post" class="editPost">
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "jsonofquestion";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$ID = 0;
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && is_numeric($_GET['id'])) {
  $ID = intval($_GET['id']);
  $stmt = $conn->prepare("SELECT * FROM questions WHERE id = ?");
  $stmt->bind_param("i", $ID);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  $rowTx = htmlspecialchars($row["questionText"]);
  $rowTy = htmlspecialchars($row["questionType"]);
  
  echo "<div class='grid'>"."Question:";
  echo '<input name="rowTx" value="'.$rowTx.'"">'.'<br>';
  echo "Question Type:";
  echo '<input name="rowTy" value="'.$rowTy.'"">'.'<br>';
  echo '</div>';

  $stmt = $conn->prepare("SELECT * FROM corrans WHERE questionID = ?");
  $stmt->bind_param("i", $ID);
  $stmt->execute();
  $result = $stmt->get_result();
  echo "<div class='grid'>"."Correct Answers:";
  while($row = $result->fetch_assoc()) {
    echo '<input name="corrAns'.$row["ID"].'" value="'.htmlspecialchars($row['corrAns']).'"">';
  }echo '<br>'.'</div>';

  echo "<div class='grid'>"."Possible Answers:";
  $stmt = $conn->prepare("SELECT * FROM possans WHERE questionID = ?");
  $stmt->bind_param("i", $ID);
  $stmt->execute();
  $result = $stmt->get_result();
  while($row = $result->fetch_assoc()) {
    echo '<input name="possAns'.$row["ID"].'" value="'.htmlspecialchars($row["possAns"]).'"">';
  }echo '<br>';
  echo "</div>".'<input type="submit">';
}
?>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $rowTx = htmlspecialchars($_POST['rowTx']);
  if(isset($_POST['rowTy']) && is_numeric($_POST['rowTy'])){
  $rowTy = intval($_POST['rowTy']);
  }

  // Add security checks and prepared statements similar to GET method
}
?>
<div>
</body>
</html>

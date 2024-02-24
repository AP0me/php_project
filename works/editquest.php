<html>
<body>
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

$ID = $_GET['id'];
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $stmt = $conn->prepare("SELECT * FROM questions WHERE id = ?;");
  $stmt->bind_param("i", $ID); // "i" denotes the type of the parameter, i.e., integer
  $stmt->execute();
  $result = $stmt->get_result();

  $row = $result->fetch_assoc();

  $rowTx = $row["questionText"];
  $rowTy = $row["questionType"];
  $rowCA = $row["corrAns"];

  echo '<input name="rowTx" value="'.$rowTx.'"">'.'<br>'.'<input name="rowTy" value="'.$rowTy.'"">'.'<br>'.'<input name="rowCA" value="'.$rowCA.'"">'.'<br>';
  
  $stmt = $conn->prepare("SELECT * FROM possans WHERE questionID = ?");
  $stmt->bind_param("i", $ID); // "i" denotes the type of the parameter, i.e., integer
  $stmt->execute();
  $result = $stmt->get_result();
  while($row = $result->fetch_assoc()) {
    echo '<input name="possAns'.$row["ID"].'" value="'.$row["possAns"].'"">';
  }
  echo '<input type="submit">';
}
?>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $rowTx = $_POST['rowTx'];
  $rowTy = $_POST['rowTy'];
  $rowCA = $_POST['rowCA'];

  $stmt = $conn->prepare("SELECT * FROM questions WHERE id = ?");
  $stmt->bind_param("i", $ID); // "i" denotes the type of the parameter, i.e., integer
  $stmt->execute();
  $result = $stmt->get_result();  
  while($row = $result->fetch_assoc()) {
    $possAns=$row["possAns"];
    $rowID=$row["ID"];
    $newposs=$_POST['possAns'.$row["ID"]];
    $stmt = $conn->prepare("UPDATE possans SET questionID=?, possAns=?, questionType=? WHERE ID=?");
    $stmt->bind_param("isis", $ID, $newposs, $rowTy, $rowID);
    $stmt->execute();
    $result2 = $stmt->get_result();  
  }

  if (empty($rowTx) || empty($rowTy) || empty($rowCA)){echo "\$qute or \$type or \$repl is empty";}
  else{
    $stmt = $conn->prepare("UPDATE questions SET questionText=?, questionType=?, corrAns=? WHERE ID=?;");
    $stmt->bind_param("isis", $$rowTx, $rowTy, $rowCA, $ID);
    $stmt->execute();
    $result = $stmt->get_result();  
    echo 'done: <a href="editquest.php?id='.$ID.'">Refresh</a><br><a href="allquest.php?id='.$ID.'">Back</a>';
  }
}
?>
</body>
</html>
<html>
<body>
<style>
body{
  background-color: brown;
}
.container0{
  display: grid;
  gap: 0.5em;
  grid-template-columns: 1fr 1fr;
}
.container1{
  display: grid;
  gap: 1em;
  grid-template-columns: 1fr 1fr 1fr;
  background-color: darkblue;
}
.container1>div{
  background-color: white;
}
.container2{
  display: grid;
  gap: 1em;
  grid-template-columns: 1fr 1fr;
  background-color: darkblue;
}
.container2>div{
  background-color: white;
}
</style>
<div class="container0">
  <div class="container1">
  <div>Question</div>
  <div>Type</div>
  <div>Corrections</div>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "jsonofquestion";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

function tuASCII($input){
  $res="";
  $inputList = str_split($input);
  for($i=0; $i<count($inputList); $i++){
    $inputListOrdStr=strval(ord($inputList[$i]));
    if(count(str_split($inputListOrdStr))<3){
      $inputListOrdStr="0".$inputListOrdStr;
    }
    $res=$res.$inputListOrdStr;
  }
  return $res;
}
function fromASCII($asciiList){
  $res="";
  $asciiList=str_split($asciiList,3);
  for($i=0; $i<count($asciiList); $i++){
    $letter=chr(intval($asciiList[$i]));
    $res=$res.$letter;
  }
  return $res;
}

if(gettype(intval($_GET['id']))=='integer'){
    $ID = $_GET['id'];
}

$stmt = $conn->prepare("SELECT * FROM questions WHERE id = ?");
$stmt->bind_param("i", $ID); // "i" denotes the type of the parameter, i.e., integer
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();

$rowTx = fromASCII($row["questionText"]);
$rowTy = $row["questionType"];

$rowCA=[];
$stmt = $conn->prepare("SELECT * FROM corrans WHERE questionID = ?;");
$stmt->bind_param("i", $ID); // "i" denotes the type of the parameter, i.e., integer
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()) {
  array_push($rowCA, fromASCII($row['corrAns']));
}
$rowCAI = implode(";", $rowCA);
echo '<div>'.$rowTx.'</div>'.'<div>'.$rowTy.'</div>'.'<div>'.$rowCAI.'</div>';

echo '</div><div class="container2">
<div>Possible Answer</div>
<div>Is Correct/Incorrect</div>';
$stmt = $conn->prepare("SELECT * FROM corrans WHERE questionID = ?;");
$stmt->bind_param("i", $ID); // "i" denotes the type of the parameter, i.e., integer
$stmt->execute();

while($row = $result->fetch_assoc()) {
  echo '<div>'.fromASCII($row["possAns"]).'</div>';
  if($rowTy == 1 or $rowTy == 2 or $rowTy == 5) {
    if(in_array(fromASCII($row["possAns"]), $rowCA)){echo '<div>'."Correct".'</div>';}
    else{echo '<div>'."Incorrect".'</div>';}
  }
}
echo "</div>";
?>
</body>
</html>
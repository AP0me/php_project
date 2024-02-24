<!DOCTYPE html>
<html>
<body>

<form method="post" class="addquestform">
  <p>0-"QCD", 1-"True/False", 2-"numerical answer", 3-"or short answer"</p>
  <input type="submit" value="Add Question"><br>
  <input type="text" placeholder="question Text" name="questionText">
  <input type="number" placeholder="type" name="Type">
  <input type="text" placeholder="corrAns" name="corrAns">
  <br>
</form>
<button  onclick="addRepl(this)">Add Possible Answer</button>
<script>
var i=0;
function addRepl(elem){
  elem.setAttribute("onChange", "kkk");
  queform=document.querySelector(".addquestform");
  queform.innerHTML+='<input type="text" placeholder="possAns" name="possAns'+i+'">';
  i=i+1;
}
</script>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "jsonofquestion";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $qute = $_POST['questionText'];
  $type = $_POST['Type'];
  $corr = $_POST['corrAns'];
  $poss=[];
  for ($i = 0; isset($_POST['possAns'.$i]); $i++){
    array_push($poss, $_POST['possAns'.$i]);
  }
  echo $corr.'<br>';
  
  if (empty($qute) || empty($type) || empty($corr)){echo "\$qute or \$type or \$repl is empty";}
  else{
    $sql = "INSERT INTO questions (questionText, questionType, corrAns) VALUES ('$qute', '$type', '$corr');";
    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully".'<br>';
    }else {echo "Error: " . $sql . "<br>" . $conn->error;}
    
    for ($i=0; $i<count($poss); $i++) {
      $currposs=$poss[$i];
      echo $currposs;
      $sql = "INSERT INTO possans (questionID, possAns, questionType) VALUES ((SELECT MAX(ID) FROM questions), '$poss[$i]', '$type');";
      if ($conn->query($sql) === TRUE) {
        echo "New record created successfully".'<br>';
      }else {echo "Error: " . $sql . "<br>" . $conn->error;}
    }
  }
}
?>

</body>
</html>
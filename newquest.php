<!DOCTYPE html>
<html>
<body>
<style>
body{
  background-color: brown;
  color: white;
}
.addquestform{
  display: grid;
  grid-template-columns: 1fr;
  grid-template-rows: auto;
  gap: 1em;
  background-color: gray;
}
.submitquest{
  background-color: blue;
}
.textgroup{
  display: grid;
  grid-template-columns: 5fr 1fr;
}
.infogroup{
  display: grid;
  grid-template-columns: 5fr 1fr;
}
</style>
<form method="post" class="addquestform">
  <div class="infogroup">
    <p>1-"QCD", 2-"True/False", 3-"numerical answer", 4-"or short answer", 5-"MCQ"</p>
    <input type="submit" value="Add Question" class="submitquest">
  </div>
  <div class="textgroup">
    <textarea type="text" placeholder="question Text" name="questionText"></textarea>
    <input type="number" placeholder="Question Type: 1-5" name="Type">
  </div>
  <br>
</form>
<button  onclick="addRepl(this)">Add Possible Answer</button>
<button  onclick="addCorr(this)">Add Correct Answer</button>
<script>
var i=0;
function addRepl(elem){
  queform=document.querySelector(".addquestform");
  queform.innerHTML+='<input type="text" placeholder="possAns" name="possAns'+i+'">';
  i=i+1;
}
var k=0;
function addCorr(elem){
  queform=document.querySelector(".addquestform");
  queform.innerHTML+='<input type="text" placeholder="corrAns" name="corrAns'+k+'">';
  k=k+1;
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
    $letter=chr($asciiList[$i]);
    $res=$res.$letter;
  }
  return $res;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $qute = tuASCII($_POST['questionText']);
  if(gettype(intval($_POST['Type']))=='integer'){
    $type = $_POST['Type'];
  }
  $corr=[];
  for ($i = 0; isset($_POST['corrAns'.$i]); $i++){
    array_push($corr, tuASCII($_POST['corrAns'.$i]));
  }
  $poss=[];
  for ($i = 0; isset($_POST['possAns'.$i]); $i++){
    array_push($poss, tuASCII($_POST['possAns'.$i]));
  }
  
  if (empty($qute) || empty($type) || empty($corr)){echo "\$qute $qute or \$type $type or \$corr $corr is empty";}
  else{
    $stmt = $conn->prepare("INSERT INTO questions (questionText, questionType, corrAns) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $qute, $type, $corr); // "s" for string, "i" for integer
    if ($stmt->execute(); === TRUE) {
    }else {echo "Error: " . $sql . "<br>" . $conn->error;}

    for ($i=0; $i<count($corr); $i++) {
      $currcorr = $corr[$i];
      echo $currcorr;
      $sql = "INSERT INTO corrans (questionID, corrAns) VALUES ((SELECT MAX(ID) FROM questions), '$corr[$i]');";
      if ($conn->query($sql) === TRUE) {
      }else {echo "Error: " . $sql . "<br>" . $conn->error;}
    }
    
    for ($i=0; $i<count($poss); $i++) {
      $currposs=$poss[$i];
      echo $currposs;
      $sql = "INSERT INTO possans (questionID, possAns, questionType) VALUES ((SELECT MAX(ID) FROM questions), '$poss[$i]', '$type');";
      if ($conn->query($sql) === TRUE) {
      }else {echo "Error: " . $sql . "<br>" . $conn->error;}
    }
  }
}
?>

</body>
</html>
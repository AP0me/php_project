<!DOCTYPE html>
<html>
<style>
    body{
        background-color: brown;
    }
    .container{
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
        justify-content: space-evenly;
        background-color: brown;
        gap: 1em;
    }
    .container>div{
        background-color: white;
    }
    .NewQ{
        background-color: white;
    }
</style>
<body>
<a class="NewQ" href="newquest.php">Create New</a><hr>
<div class="container">
    <div>ID</div>
    <div>Question</div>
    <div>Type</div>
    <div>Correction</div>
    <div>View Link</div>
    <div>Edit Link</div>
</div>
<script>
document.body.onload = function(){
    container=document.querySelector('.container');
    rowID=document.querySelectorAll('.rowID');
    rowTx=document.querySelectorAll('.rowTx');
    rowTy=document.querySelectorAll('.rowTy');
    rowCA=document.querySelectorAll('.rowCA');

    function appendColumn(container, value, columnNum){
        for (i=0; i<value.length; i++){
            div=document.createElement('div');
            div.style.order=i*6+columnNum;
            div.innerHTML=value[i].value;
            container.appendChild(div);
        }
    }
    appendColumn(container, rowID, 0);
    appendColumn(container, rowTx, 1);
    appendColumn(container, rowTy, 2);
    appendColumn(container, rowCA, 3);
    for (i=0; i<rowID.length; i++){
        div=document.createElement('div');
        div.style.order=i*6+4;
        a=document.createElement('a');
        a.innerHTML='View Link';
        a.href="viewquest.php?id="+rowID[i].value;
        div.appendChild(a);
        container.appendChild(div);

        div=document.createElement('div');
        div.style.order=i*6+5;
        a=document.createElement('a');
        a.innerHTML='Edit Link';
        a.href="editquest.php?id="+rowID[i].value;
        div.appendChild(a);
        container.appendChild(div);
    }
};

</script>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "jsonofquestion";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM questions;";
$result = $conn->query($sql);
$k=0;
while($row = $result->fetch_assoc()) {
    echo '<input class="rowID" id='.$k.' type="hidden" value="'.$row['ID'].'">';
    echo '<input class="rowTx" id='.$k.' type="hidden" value="'.$row['questionText'].'">';
    echo '<input class="rowTy" id='.$k.' type="hidden" value="'.$row['questionType'].'">';
    echo '<input class="rowCA" id='.$k.' type="hidden" value="'.$row['corrAns'].'">';
    $k=$k+1;
}
?>

</body>
</html>
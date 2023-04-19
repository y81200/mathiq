<?php
include "dbconnect.php";
$sql = "SELECT * FROM kr_keyword";
$result = mysqli_query($connect, $sql); 
$keyword = $_POST["keyword"];
$ext = 0;
while($row = mysqli_fetch_array($result)){
    if($row['keyword'] == $keyword){
        echo "네, 있습니다.";
        $ext = -1;
        break;
    }
    else{
        continue;
    }
}
if($ext == 0){
    echo "아뇨, 없습니다.";
}
?>
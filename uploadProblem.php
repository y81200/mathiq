<?php 
include "dbconnect.php";
$result = mysqli_query($connect,"SELECT MAX(seq) FROM math_pb_table");
$row = mysqli_fetch_assoc($result);
$num_last = 1 + $row['MAX(seq)'];

$mp_text = $_POST["mp_text2"];


$mp_text = str_replace("\\", "$", $mp_text);



$tempFile = $_FILES['mp_db_img']['tmp_name'];
$fileTypeExt = explode("/", $_FILES['mp_db_img']['type']);
if($fileTypeExt[0] == null){
	echo("<script>alert(\"파일이 없습니다. 파일을 업로드 하세요.\");</script>");
	echo("<script>location.replace('./index.php');</script>");
}
$resFile = "./db_imgs/img_".$num_last.".png";
$imageUpload = move_uploaded_file($tempFile, $resFile);
$sql = "INSERT INTO math_pb_table (mp_txt) VALUES('".$mp_text."')";
$result2 = mysqli_query($connect, $sql);
if($result2 == false){
	echo("<script>alert(\"업로드 실패\");</script>");
	echo("<script>location.replace('./index.php');</script>");
}else{
	echo("<script>alert(\"업로드가 완료 되었습니다.\");</script>");
	echo("<script>location.replace('./index.php');</script>");
}
?>
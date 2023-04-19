<?php
//이미지 저장
if(file_exists("./img/mp_user.png") == true){
    unlink("./img/mp_user.png");
}
$tempFile = $_FILES['mp_img']['tmp_name'];
$fileTypeExt = explode("/", $_FILES['mp_img']['type']);
if($fileTypeExt[0] == null){
	echo("<script>alert(\"파일이 없습니다. 파일을 업로드 하세요.\");</script>");
	echo("<script>location.replace('./index.html');</script>");
}
$resFile = "./img/mp_user.png";
$imageUpload = move_uploaded_file($tempFile, $resFile);

//db 연결
include "dbconnect.php";
$sql = "SELECT * FROM kr_keyword";
$result = mysqli_query($connect, $sql); 


$mp_text = $_POST["mp_text"];


//가져온 텍스트에서 키워드 추출
$kw[0]=null;
$include_kw[0]=null;
$seqnum = 0;
while($row = mysqli_fetch_array($result)){
    if(strpos($mp_text, $row['keyword']) !== false){
        $kw[$seqnum] = $row['keyword'];
        $seqnum++;
    }
    else{
        continue;
    }
}

//키워드갯수만큼 루프, 배열에 문제번호 저장
$i=0;
foreach($kw as $values){
    $sql2 = "SELECT seq FROM math_pb_table WHERE mp_txt LIKE '%$values%'";
    $result2 = mysqli_query($connect, $sql2);
    while($row2 = mysqli_fetch_array($result2)){
        $include_kw[$i] = $row2['seq'];
        $i++;
    }
}

//저장된 문제번호로 순위 추출 후 이미지 넣기
function ranking($ikw){
    $arr = array_count_values($ikw);//1->1 2->3 3->1...
    $most = max($arr);//최댓값 = 3->7 3번이 7개, first 값은 7
    $arr_key = array_keys($arr, $most);//키워드가 있는 숫자가 같으면 여러개 생성        3개 있는 문제번호
    $k=10;//상위 10개만 출력
    while($k > 0){
        $arr_key = array_keys($arr, $most);//arr에서 가장 많은 문제 번호
        foreach($arr_key as $values){ 
            //각 문제 번호
            if($k <= 0){
                break;
            } 
            print_imgs($values);
            echo ("<br>");
            $k--;
        }
        $most--;
    }

}

//이미지 가져와서 출력
function print_imgs($arr_k){//문제번호
    include "dbconnect.php";
    $query = "SELECT * FROM math_pb_table WHERE seq = $arr_k";
    $result3 = mysqli_query($connect, $query);
    while($row3 = mysqli_fetch_array($result3)){
        $d = $row3['mp_txt']."다음 문제의 답을 풀고 자세한 설명을 해줘.";//검색된 문제의 텍스트
        $d = str_replace("$", "\\", $d);
    }
        echo ("<div>");
        echo ("<img src=\"./db_imgs/img_".$arr_k.".png\" alt=\"검색된 문제\" style=\"width:500px; height:300px;\">");
        echo ("<details><summary>chatGPT에게 답 물어보기</summary>");
        echo ("<form action=\"gpt-run.php\" method=\"post\" target=\"myFrameans".$arr_k."\">");
        echo ("<textarea readonly id=\"gpt_ans".$arr_k."\" name=\"prompt\" style=\"display:none\">".$d."</textarea>");   
        echo ("<input class=\"file-label\" type=\"submit\" value=\"물어보기\">");     //submit
        echo ("</form>");
        echo ("<p>문제가 길고 어려우면 풀이가 나오지 않을수도 있습니다.</p>");
        echo ("<div class=\"framebox\">");
        echo ("<iframe name=\"myFrameans".$arr_k."\"></iframe>");
        echo ("</div>");
        echo ("<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>");
        echo ("</details>");
        echo ("</div>");
    }

//가져온 문제 텍스트 가져오기
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>검색결과</title>
        <link rel="stylesheet" href="styles.css">
        
    </head>
    <body>
        <div id="root">
            <div class="header">
                <h1 class="title">
                    <a href="./index.php"><img src="./img/logo.png" alt="로고" class="logo"></a>
                    검색 결과
                </h1>
            </div>            
            <hr>
            <div class="contents" id="search">
                <div class="upload-box">
                        <img src="./img/mp_user.png" alt="사용자 이미지" width="500" class="preview">  
                    <details  style="background-size: auto;"><summary>chatGPT에게 답 물어보기</summary>
                        <form action="gpt-run.php" method="post" target="myFrameans">
                            <textarea id="prompt" name="prompt" cols="40" rows="3" required style="display:none">
                            <?php echo $mp_text; echo ("다음 문제의 답을 풀고 자세한 설명을 해줘. 또한 유사한 문제를 3개 알려줘.");?></textarea>
                            <input class="file-label" type="submit" value="물어보기">
                        </form>
                        <p>문제가 길고 어려우면 풀이가 나오지 않을수도 있습니다.</p>
                        <div class="framebox">
                            <iframe name="myFrameans"></iframe>
                        </div>
                        <br><br><br><br><br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br>
                    </details>
                    <br>
                    <details>
                        <br>
                        <summary id="see_reqpb">검색 결과 보기</summary>
                            <?php ranking($include_kw); ?>
                    </details>
                    <label class="file-label" for="return">다시 검색하기</label>
                    <button class="file" id="return" onclick="location.href='./index.php'"></button>
                </div>
            </div>
        </div>
        <script src="apikey.js"></script>
    </body>
</html>
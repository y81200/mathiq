<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>MATHIQ | 이미지로 유사수학문제 검색</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div id="root">
            <div class="header">
                <h1 class="title">
                    <img src="./img/logo.png" alt="로고" class="logo" onclick="window.location.reload()" style="cursor:pointer;"></a>
                    이미지로 유사수학문제 검색
                    <img src="./img/manage.png" alt="관리자" class="logo2" onclick="manage()" style="cursor:pointer;"></a>
                </h1>
            </div>            
            <hr>
            <div class="contents">
                <div id="main" class="upload-box">
                    <div id="drop-file" class="drag-file">
                        <img src="./img/imgsearch.png" alt="파일 아이콘" class="image" >
                        <p class="message">파일을 업로드 하세요!</p>
                        <img id="abc" src="" alt="미리보기 이미지" class="preview">
                    </div>
                    <p>업로드 후 확인창이 뜬 후에 진행해주세요!</p>
                    <label class="file-label" for="chooseFile" id="imgup"> 이미지 업로드 </label>
                    <label class="file-label" for="searchmath" id="pbsc" style="display:none"> 문제 풀이 </label>
                    <form name="myHiddenForm" action="search.php" method="POST" enctype="multipart/form-data">
                        <textarea readonly name="mp_text" id="text_id" cols="50" rows="10" style="display:none"></textarea>
                        <input class="file" name="mp_img" id="chooseFile" type="file" onchange="dropFile.handleFiles(this.files)" 
                            accept="image/png, image/jpeg, image/gif" name="imgFile" />
                        <input type="submit" class="file" id="searchmath">
                    </form> 
                    <form name="reqform" action="UploadProblem.php" method="post" enctype="multipart/form-data">
                        <textarea name="mp_text2" id="text_id2" cols="50" rows="10" style="display:none"></textarea>
                        <input class="file" name="mp_db_img" id="chooseFile2" type="file" onchange="dropFile.handleFiles(this.files)"
                            accept="image/png, image/jpeg, image/gif" name="imgFile" />
                        <input class="file" id="searchmath2" type="submit"/>
                    </form> 
                    <label class="file-label" for="chooseFile2" id="flcs" style="display:none"> 이미지 업로드 </label>
                    <form action="is_kw_ext.php" method="post" target="kw_ext">
                        <input class="file" id="kwsbm" type="submit">
                        <p><textarea id="keyword" name="keyword" required style="display:none">여기에 키워드 입력</textarea></p>
                    </form>
                    <label class="file-label" for="kwsbm" id="kwsblb" style="display:none"> 키워드 검색 </label>
                    <br>
                    <iframe id="yes_no" name="kw_ext" width="160" height="40" style="display:none"></iframe>
                    <label class="file-label" for="searchmath2" id="pbup" style="display:none"> 문제 등록 </label>
                </div>
            </div>
        </div>
        <script src="apikey.js"></script>
        <script id="hw" type="text/javascript" src="script.js"></script>
    </body>
</html>
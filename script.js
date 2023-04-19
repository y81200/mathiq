let mp_text;
let num = 0;
const API_KEY = configs.apikey;

function manage() {
  document.title = "관리자 페이지";
  document.getElementById("flcs").style.display = "block";
  document.getElementById("keyword").style.display = "block";
  document.getElementById("kwsblb").style.display = "block";
  document.getElementById("yes_no").style.display = "block";
  document.getElementById("text_id2").style.display = "block";

  document.getElementById("imgup").style.display = "none";
  document.getElementById("pbsc").style.display = "none";
  num = 1;
}


function DropFile(dropAreaId, fileListId) {
    let dropArea = document.getElementById(dropAreaId);
    let fileList = document.getElementById(fileListId);
    function preventDefaults(e) {
      e.preventDefault();
      e.stopPropagation();
    }
  
    function highlight(e) {
      preventDefaults(e);
      dropArea.classList.add("highlight");
    }
  
    function unhighlight(e) {
      preventDefaults(e);
      dropArea.classList.remove("highlight");
    }
  
    function handleDrop(e) {
      unhighlight(e);
      let dt = e.dataTransfer;
      let files = dt.files;
  
      handleFiles(files);
  
      const fileList = document.getElementById(fileListId);
      if (fileList) {
        fileList.scrollTo({ top: fileList.scrollHeight });
      }
    }
  
    function handleFiles(files) {
      files = [...files];
      files.forEach(previewFile);
    }
  
    function previewFile(file) {
      console.log(file);
      renderFile(file);
    }
  
    function renderFile(file) {
      let reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onloadend = function () {
        let img = dropArea.getElementsByClassName("preview")[0];
        img.src = reader.result;
        mathpix(img.src);
        img.style.display = "block";
      }; 
    }
    

function mathpix(base64source){
  fetch("https://api.mathpix.com/v3/text", {
      method: "POST",
      headers: {
          "content-type": "application/json",
          "app_id": "yth6565_gmail_com_b615c7_f4e2f0",//사용자 아이디
          "app_key": API_KEY//사용자 키
      },
      body: JSON.stringify({
          src: base64source,
          formats: ["text", "data"],
          data_options: {
              include_asciimath: true
          }
      })
  })
  .then((response) => {return response.json()})
  .then((json)=>{
    
    data = json.text;

    mp_text=data;

    document.getElementById("text_id").innerHTML = mp_text;    
    document.getElementById("text_id2").innerHTML = mp_text; 
    
    alert ("변환이 완료되었습니다.");
    if(num == 0){
      document.getElementById("pbsc").style.display = "block";

    }
    else{
      document.getElementById("pbup").style.display = "block";
    }
    num=0;
    console.log(json)
  })
  .catch((error) => console.log("error:", error));
}
    
    dropArea.addEventListener("dragenter", highlight, false);
    dropArea.addEventListener("dragover", highlight, false);
    dropArea.addEventListener("dragleave", unhighlight, false);
    dropArea.addEventListener("drop", handleDrop, false);
  
    return {
      handleFiles
    };
  }

  const dropFile = new DropFile("drop-file", "files");
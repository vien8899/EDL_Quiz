function start_exam(_user_id,_class_quiz_id,_quiz_id,_quiz_title,_quiz_time){
    var error = false;
    Swal.fire({
        // title: 'Please',
        html: '<h2 class="phetsarath">ກະລຸນາລໍຖ້າ !</h2><h4 class="phetsarath">ກໍາລັງໂຫຼດຂໍ້ມູນ</h4>',
        timer: 500,
        allowOutsideClick:false,
        didOpen: () => {
          Swal.showLoading()
        }
    }).then(() => {
        if(error){
            Swal.fire({icon:'error',html:'<span class=phetsarath>ບໍ່ສາມາດທໍາການສອບເສັງ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງໂຫຼດຂໍ້ມຸນ!</span>'});
        }else{
            location.href = "main?page=do_exam";
        }
    });
    Swal.stopTimer();
    var param = {
        user_id:_user_id,
        class_quiz_id:_class_quiz_id,
        quiz_id:_quiz_id,
        quiz_title:_quiz_title,
        quiz_time:_quiz_time
    }
    // console.log(param);
    var http = new XMLHttpRequest();
    http.open("POST",'controller/do_exam_controller.php',true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function(){
        if(this.readyState === XMLHttpRequest.DONE && this.status === 200){
            // console.log(this.responseText);
            var res = JSON.parse(this.responseText);
            if(res.success){
                var exam_data = JSON.stringify(res.exam_data);
                var exam_data_encoded = CryptoJS.AES.encrypt(exam_data,"exam").toString();
                sessionStorage.setItem("exam_data",exam_data_encoded);
            }else{
                error = true;
            }
            Swal.resumeTimer();
        }
    }
    var _param = encode(JSON.stringify(param));
    http.send("start_exam="+_param);
}
function encode(text) {
    return text
      .replace(/&/g, "#amp;")
      .replace(/"/g, "#quot;")
      .replace(/\+/g, "#plus;")
      .replace(/'/g, "#039;");
}
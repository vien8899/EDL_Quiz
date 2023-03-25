<?php 
    require_once "controller/do_exam_controller.php"; 
?>
<link rel="stylesheet" href="assets/css/do-exam-style.css">
<div class="page-content">
    <div class="timer phetsarath center">
        <i class="fas fa-solid fa-stopwatch"></i> ເວລາຍັງເຫຼືອ <span id="time-lb"></span>
    </div>
    <div class="subj-info">
        <div class="subj-frame">
            <span class="phetsarath f14">ຫົວຂໍ້ເສັງ: </span><span id="subj_name" class="phetsarath f14"></span>
        </div>
        <div class="submit-btn">
            <button onclick="btn_submit_clicked()" type="button" class="top-btn btn btn-success phetsarath f12">ສົ່ງບົດເສັງ</button>
        </div>
    </div>
    <div class="quiz-content">
        <div class="question">
            <div class="question-body" id="quest_body"></div>
        </div>
        <div class="answer">
            <div><p class="phetsarath f12">ຄໍາຕອບ: <span class="phetsarath f12 lb-score" id="lb_score"></span></p></div>
            <div id="ans"></div>
        </div>
        <div class="question-box">
            <div><p class="phetsarath f12">ຄໍາຖາມທັງໝົດ:</p></div>
            <div class="question-btn" id="question_btn"></div>
            <div class="save-btn center">
                <button onclick="btn_submit_clicked()" type="button" class="btn btn-success phetsarath f12">ສົ່ງບົດເສັງ</button>
            </div>
        </div>
        <div class="bottom-btn">
            <button onclick="previous_quest()" id="btn_prevoius" type="button" class="btn btn-primary phetsarath f12"><i class="fas fa-solid fa-arrow-left"></i> ກັບຄືນ</button>
            <button onclick="next_quest()" id="btn_next" type="button" class="btn btn-primary phetsarath f12">ຂໍ້ຕໍ່ໄປ <i class="fas fa-solid fa-arrow-right"></i></button>
        </div>
    </div>
</div>
<script src="assets/js/crypto-js.js"></script>
<script src="assets/js/custom_js/do_exam.js"></script>
<script src="module/ckeditor/ckeditor.js"></script>

<!-- countdown control section-->
<script>
    if(sessionStorage.getItem('exam_data')==undefined){
        window.location.href = "./main";
    }
    var exam_data_key = sessionStorage.getItem('exam_data');
    var exam_data = JSON.parse(CryptoJS.AES.decrypt(exam_data_key, "exam").toString(CryptoJS.enc.Utf8));
    var exam_duration = parseInt(exam_data.quiz_time);
    
    var counter_key = sessionStorage.getItem('counter_key');
    var countDownDate = new Date(exam_data.start_time);
    if(counter_key == null){
        countDownDate.setTime(countDownDate.getTime()+(exam_duration*60*1000));
        var encrypted = CryptoJS.AES.encrypt(countDownDate.toString(), "counter1122").toString();
        sessionStorage.setItem('counter_key',encrypted);
    }else{
        var counter = CryptoJS.AES.decrypt(counter_key, "counter1122").toString(CryptoJS.enc.Utf8);
        countDownDate = new Date(counter);
    }
    const zeroPad = (num, places) => String(num).padStart(places, '0');
    var x = setInterval(function() {

    // Get today's date and time
    var now = new Date().getTime();
    
    // Find the distance between now and the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = (hours*60)+Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Output the result in an element with id="demo"
    document.getElementById("time-lb").innerHTML = zeroPad(minutes,2) + " : " + zeroPad(seconds,2);
    
    // If the count down is over, write some text 
    if (distance < 0) {
        timeout_submit();
        clearInterval(x);
        document.getElementById("time-lb").innerHTML = "00:00";
    }
    }, 1000);

</script>
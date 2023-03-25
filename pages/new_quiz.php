<?php
require_once "controller/new_quiz_controller.php";
$user_id = @$user_data['id'];
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<link rel="stylesheet" href="assets/css/new_quiz_style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath">
      <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i>
      <a href="template?page=quizes" class="home-link">ຫົວຂໍ້ສອບເສັງ</a> <i class="fas fa-chevron-right"></i>
      ເພີ່ມຫົວຂໍ້ສອບເສັງ
    </h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ເພີ່ມຫົວຂໍ້ສອບເສັງໃໝ່</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                    <label id="quiz_time_lb" class="col-form-label phetsarath f12 quiz_time_lb">ເວລາເສັງ: 30 ນາທີ</label>
                    <input onchange="update_quiz_time(this.value)" type="range" step="5" class="form-range" min="5" max="180" id="quiz-time" value="30">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-form-label phetsarath f12">ຫົວຂໍ້ສອບເສັງ*</label>
                  <div class="col-sm-12">
                    <input id="quiz-title" type="text" class="inp form-control phetsarath f12" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-form-label phetsarath f12">ຄໍາອະທິບາຍການສອບເສັງ*</label>
                  <div class="col-sm-12">
                    <textarea id="quiz-caption" class="inp form-control phetsarath f12" rows="12"></textarea>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row submit">
              <div class="col-md-12 center">
                <button onclick="save()" type="submit" name="save_ans_choice" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                  ບັນທຶກ
                  <i class="fas fa-save btn-icon-append"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function update_quiz_time(value){
    document.getElementById('quiz_time_lb').innerHTML = "ເວລາເສັງ: "+value+" ນາທີ";
  }
  function save(){
    if($('#quiz-title').val()==""){
      Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາປ້ອນຫົວຂໍ້ສອບເສັງ!</span>'});
    }else if($('#quiz-caption').val()==""){
      Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາປ້ອນຄໍາອະທິບາຍການສອບເສັງ!</span>'});
    }else{
      var param = {
        quiz_time: $('#quiz-time').val(),
        quiz_title: $('#quiz-title').val(),
        quiz_caption: $('#quiz-caption').val(),
        user_id: '<?=$user_id?>'
      }
      var http = new XMLHttpRequest();
      http.open("POST", 'controller/new_quiz_controller.php', true);
      http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      http.onreadystatechange = function() {
          if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // console.log(this.responseText);
            eval(this.responseText);
          }
      }
      var _param = encode(JSON.stringify(param));
      http.send("new_quiz=" + _param);
      }
  }
</script>
<?php
    require_once "controller/exam_preview_controller.php";
    if(isset($_GET['test_id'])){
        $test_id = $_GET['test_id'];
    }else{
        ?>
            <script>window.location.href = 'template?page=score_report'</script>
        <?php
    }
?>
<link rel="stylesheet" href="assets/css/exam_preview_style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath">
      <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i>
      <a href="template?page=score_report" class="home-link">ຜົນການສອບເສັງ</a> <i class="fas fa-chevron-right"></i>
      <!-- ຄໍາຕອບຂອງນັກສອບເສັງ -->
      <span id="quiz_title"></span>
    </h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <div class="subj-info">
        <span class="subj-frame">
            <span class="phetsarath f14">ລະຫັດເສັງ: </span><span id="test_number" class="phetsarath f14"></span>
        </span>
    </div>
    <div class="ans">
        <div class="quest-content" id="quest_content"></div>
    </div>
  </div>
</div>
<script>
    var param = {
        test_id:'<?=$test_id?>'
    }
</script>
<script src="assets/js/crypto-js.js"></script>
<script src="assets/js/custom_js/exam_preview.js"></script>
<script src="module/ckeditor/ckeditor.js"></script>

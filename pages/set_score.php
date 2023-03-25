<?php
date_default_timezone_set("Asia/Vientiane");
require_once "controller/quiz_overview_controller.php";
$user_id = @$user_data['id'];
$user_name = @$user_data['username'];
if(isset($_GET['quiz_no'])){
    $quiz_no = $_GET['quiz_no'];
}else{
    echo "<script>window.location.href='template?page=quiz_overview'</script>";
}
?>
<link rel="stylesheet" href="assets/css/set-score-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
    <div class="page-title">
        <h5 class="phetsarath">
            <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i>
            <a href="template?page=quiz_overview" class="home-link">ຂໍ້ມູນບົດເສັງ</a> <i class="fas fa-chevron-right"></i>
            ກວດບົດເສັງ
        </h5>
    </div>
</div>
<div class="page-wrapper">
    <div class="content-wrapper">
        <div class="quiz-info">
            <span class="quiz-frame">
                <span class="phetsarath f14">ລະຫັດສອບເສັງ: <?=$quiz_no?></span>
            </span>
        </div>
        <div class="questions" id="questions">
        </div>
    </div>
</div>
<script>
    var user_id = <?=$user_id?>;
    var quiz_no = '<?=$quiz_no?>';
    var user_name = '<?=$user_name?>';
    var param = {
        quiz_no:'<?=$quiz_no?>'
    }
</script>
<script src="assets/js/crypto-js.js"></script>
<script src="assets/js/custom_js/set_score.js"></script>
<?php
    
    $quiz_id = $_GET['quiz_id'];

    require_once "controller/demo_exam_controller.php";
    $quiz_info = getQuizInfo($quiz_id)->fetchAll(PDO::FETCH_ASSOC)[0];
?>
<link rel="stylesheet" href="assets/css/invite-style.css">
<script src="assets/js/crypto-js.js"></script>
<div class="page-content">
    <div class="title">
        <h1 class="phetsarath center">ແນະນໍາການສອບເສັງ</h1>
    </div>
    <div class="subj-info phetsarath">
        <div class="subj-name phetsarath">ຫົວຂໍ້ສອບເສັງ : <?=$quiz_info['quiz_title']?></div>
        <div class="phetsarath">ຈໍານວນຄໍາຖາມ : <?=$quiz_info['ques_num']?> ຄໍາຖາມ</div>
        <div class="phetsarath">ເວລາສອບເສັງ : <?=$quiz_info['quiz_time']?> ນາທີ</div>
        <div class="phetsarath">ຄະແນນເຕັມ : <?=$quiz_info['full_point']?> ຄະແນນ</div>
    </div>
    <div class="test-info phetsarath">
        <u>ໝາຍເຫດ:</u><br>
        <?=nl2br(htmlspecialchars_decode($quiz_info['quiz_caption'],ENT_QUOTES))?>
    </div>
    <div class="content-footer">
        <h3 class="phetsarath center">ຂໍໃຫ້ທຸທ່ານໂຊດີ !</h3>
    </div>
    <div class="action-btn center">
        <button onclick="start_exam('<?=$user_data['id']?>','<?=$quiz_id?>','<?=$quiz_info['quiz_title']?>','<?=$quiz_info['quiz_time']?>')" type="button" class="btn btn-success phetsarath">ເລີ່ມຕົ້ນສອບເສັງ</button>
        <button type="button" onclick="window.location.href='main';" class="btn btn-danger phetsarath">ຍົກເລີກ</button>
    </div>
</div>
<!-- <script src="assets/js/custom_js/start_exam.js"></script> -->
<script src="assets/js/custom_js/start_demo_exam.js"></script>
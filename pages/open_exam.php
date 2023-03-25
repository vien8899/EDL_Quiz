<?php
require_once "controller/open_exam_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath">
    <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a>
    <i class="fas fa-chevron-right"></i> ຫ້ອງສອບເສັງ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      $user_id = @$user_data['id'];
    //   $data = load_member($_GET['class_id'],$filter)->fetchAll(PDO::FETCH_ASSOC);
        $class_data = load_classroom()->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຫ້ອງສອບເສັງ</h4>
            <div class="grid-margin transparent">
                <div class="row">
                    <?php
                        foreach($class_data as $class){
                            ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 stretch-card transparent">
                                    <div onclick="window.location.href='template?page=open_exam&sub_page=exam_subjects&class_id=<?=$class['class_id']?>'" class="deskboard-card card card-dark-blue pointer">
                                        <div class="card-body">
                                            <h3 class="phetsarath col-white">ຫ້ອງເສັງ <?=$class['class_des']?></h3>
                                            <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                                <span class="display-5 text-info">
                                                    <img src="assets/svg/file.svg" width="70">
                                                </span>
                                                <h1 class="ml-auto col-white"><?=$class['quiz_num']?></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>

</script>
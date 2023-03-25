<?php
require_once "controller/open_exam_controller.php";
$class_id = "";
if(isset($_GET['class_id'])){
    $class_id = $_GET['class_id'];
}else{
    echo "<script>window.location.href = 'template?page=open_exam'</script>";
}
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath">
    <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a>
    <i class="fas fa-chevron-right"></i>
    <a href="template?page=open_exam" class="home-link"> ເປີດສອບເສັງ</a>
    <i class="fas fa-chevron-right"></i> ຫົວບົດເສັງ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
        $user_id = @$user_data['id'];
        if(isset($_POST['open_test'])){
            $quiz_id = $_POST['id'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            open_test($quiz_id,$start_time,$end_time,$user_id,$class_id);
        }
        $quiz_data = load_quiz($class_id)->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຫົວບົດເສັງ</h4>
            <div class="grid-margin transparent">
                <div class="row">
                    <?php
                        foreach($quiz_data as $quiz){
                            ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 stretch-card transparent">
                                    <div class="deskboard-card card" style="background-color:darkorange">
                                        <div class="card-body">
                                            <h3 class="phetsarath col-white"><?=$quiz['quiz_title']?></h3>
                                            <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                                <span class="display-5 text-info pointer">
                                                    <img src="assets/svg/quiz2.svg" width="70">
                                                </span>
                                                <!-- <h1 class="ml-auto col-white">test</h1> -->
                                                <div class="ml-auto">
                                                    <div class="quiz_time phetsarath">ເວລາເສັງ <?=$quiz['quiz_time']?> ນາທີ</div>
                                                    <?php 
                                                        if($quiz['is_open']==0){
                                                            ?>
                                                            <div class="btn-open-test" data-bs-toggle="modal" data-id="<?=$quiz['quiz_id']?>" data-bs-target="#open_exam" >
                                                                <button type="button" class="btn btn-primary phetsarath">ເປີດສອບເສັງ</button>
                                                            </div>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <div class="btn-close-test">
                                                                <button type="button" class="btn btn-warning phetsarath">ປິດສອບເສັງ</button>
                                                            </div>
                                                            <?php
                                                        }
                                                    ?>
                                                </div>
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
<?php
     include_once("modals/open_exam_modal.php");
?>
<script>
    var open_exam = document.getElementById('open_exam');
    open_exam.addEventListener('show.bs.modal', function(event) {
        var quiz_data = $(event.relatedTarget);
        var quiz_id = quiz_data.data('id');
        var modal = $(this);
        modal.find('.modal-body #quiz_id').val(quiz_id);
    });
</script>
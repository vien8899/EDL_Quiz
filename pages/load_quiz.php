<?php
require_once "controller/question_controller.php";
require_once "controller/load_quiz_controller.php";
$class_id = 0;
if (isset($_GET['class_des'])) {
  $class_des_param = "&class_des=" . $_GET['class_des'];
  $class_des = $_GET['class_des'];
}
if (isset($_GET['class_id'])) {
  $class_id_param = "&class_id=" . $_GET['class_id'];
  $class_id = $_GET['class_id'];
}

?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<link rel="stylesheet" href="assets/css/select-class-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath">
      <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i>
      <a href="template?page=classroom" class="home-link">ຫ້ອງເສັງ</a> <i class="fas fa-chevron-right"></i>
      <a href="template?page=classroom&sub_page=class_quiz_prepare<?= @$class_id_param . @$class_des_param ?>" class="home-link">ຫົວຂໍ້ເສັງ</a>
      <i class="fas fa-chevron-right"></i> ເລືອກຫົວຂໍ້ເສັງ
    </h5>
  </div>
</div>

<div class="page-wrapper">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ກະລຸນາເລືອກຫົວຂໍ້ເສັງ</h4>
            <div class="content">
                <?php
                $quiz_data = get_quiz_data($class_id);
                $data = $quiz_data->fetchAll(PDO::FETCH_ASSOC);
                ?>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="phetsarath">ຫົວຂໍ້ເສັງ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $quiz) {
                    ?>
                      <tr>
                        <td class="col-id">
                          <div class="form-check">
                            <input name="cb_quiz[]" class="form-check-input cb_subject" type="checkbox" value="<?= $quiz['quiz_id'] ?>" id="cb<?= $quiz['quiz_id'] ?>">
                            <label class="form-check-label phetsarath" for="cb<?= $quiz['quiz_id'] ?>">
                              <?= $quiz['quiz_title'] ?> <span style="color: red;"><i class="fas fa-solid fa-trophy"></i> <?=$quiz['total_score']?></span> 
                              ເວລາເສັງ <?=$quiz['quiz_time']?> ນາທີ
                            </label>
                          </div>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="submit-btn">
                <button onclick="save()" type="submit" name="save_ans_choice" class="btn btn-primary btn-icon-text phetsarath none-outline none-select">
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
    function save(){
      var quizes = document.getElementsByName('cb_quiz[]');
      var quizes_checked = [];
      quizes.forEach(quiz=>{
        if(quiz.checked){
          quizes_checked.push(quiz.value);
        }
      });
      if(quizes_checked.length==0){
        Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາເລືອກຫົວຂໍ້ເສັງໃດໜຶ່ງ!</span>'})
      }else{
        var param = {
          class_id:'<?=$class_id?>',
          class_des:'<?=$class_des?>',
          quizes:quizes_checked
        };
        var http = new XMLHttpRequest();
        http.open("POST", 'controller/load_quiz_controller.php', true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
              eval(this.responseText);
            }
        }
        var _param = JSON.stringify(param);
        http.send("load_quiz=" + _param);
      }
    }
  </script>
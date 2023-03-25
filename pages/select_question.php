<?php
require_once "controller/select_question_controller.php";
$quiz_id = 0;
if (isset($_GET['quiz_title'])) {
  $quiz_title_param = "&quiz_title=" . $_GET['quiz_title'];
  $quiz_title = $_GET['quiz_title'];
}
if (isset($_GET['quiz_id'])) {
  $quiz_id_param = "&quiz_id=" . $_GET['quiz_id'];
  $quiz_id = $_GET['quiz_id'];
}
$subj_id = isset($_GET['subj_id'])?$_GET['subj_id']:0;

?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<link rel="stylesheet" href="assets/css/select-class-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath">
      <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i>
      <a href="template?page=quizes" class="home-link">ຫົວຂໍ້ສອບເສັງ</a> <i class="fas fa-chevron-right"></i>
      <a href="template?page=quizes&sub_page=quiz_preview&quiz_id=<?=$quiz_id?>&quiz_title=<?=$quiz_title?>" class="home-link">ລາຍລະອຽດຫົວຂໍ້ເສັງ</a> <i class="fas fa-chevron-right"></i>
      ເລືອກຄໍາຖາມສອບເສັງ
    </h5>
  </div>
</div>

<div class="page-wrapper">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ກະລຸນາເລືອກຄໍາຖາມສອບເສັງ</h4>
            <div class="top-content">
              <select onchange="cb_subject_changed(this.value)" class="form-select phetsarath" aria-label="Default select">
                <option value="0" <?=($subj_id==0)?"selected":""?> >---ສະແດງທັງໝົດ---</option>
                  <?php
                    $subjects = load_subject()->fetchAll(PDO::FETCH_ASSOC);
                      foreach($subjects as $subject){
                        ?>
                          <option value='<?=$subject['subj_id']?>' <?=($subj_id==$subject['subj_id'])?"selected":""?> ><?=$subject['subj_name']?></option>
                        <?php
                      }
                  ?>
              </select>
            </div>
            <div class="content">
                <?php
                $data = load_question($quiz_id,$subj_id)->fetchAll(PDO::FETCH_ASSOC);
                ?>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="phetsarath">ຄໍາຖາມສອບເສັງ</th>
                      <!-- <th></th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $question) {
                    ?>
                      <tr>
                        <td class="col-id">
                          <div class="form-check">
                            <input name="cb_question[]" class="form-check-input cb_question" type="checkbox" value="<?= $question['question_id'] ?>" id="cb<?= $question['question_id'] ?>">
                            <label class="form-check-label phetsarath" for="cb<?= $question['question_id'] ?>">
                              <?= strip_tags(htmlspecialchars_decode($question['title'], ENT_QUOTES)); ?>
                            </label>
                          </div>
                        </td>
                        <!-- <td>
                          <button onclick="view_question('<?= encode($question['question']) ?>','<?= encode($question['ans_choice']) ?>','<?= encode($question['subj_name']) ?>',<?= encode($question['question_type']) ?>)" type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline">
                            <i class="fas fa-eye"></i>
                          </button>
                        </td> -->
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
    function cb_subject_changed(value){
      if(value==0){
        window.location.href = "template?page=quizes&sub_page=select_question<?=$quiz_id_param.$quiz_title_param?>";
      }else{
        window.location.href = "template?page=quizes&sub_page=select_question<?=$quiz_id_param.$quiz_title_param?>&subj_id="+value;
      }
    }
    function save() {
      var questions = document.getElementsByName('cb_question[]');
      var questions_checked = [];
      questions.forEach(question => {
        if (question.checked) {
          questions_checked.push(question.value);
        }
      });
      //   console.log(subjects_checked.length);
      if (questions_checked.length == 0) {
        Swal.fire({
          icon: 'info',
          html: '<span class=phetsarath>ກະລຸນາເລືອກຄໍາຖາມໃດໜຶ່ງ!</span>'
        })
      } else {
        var param = {
          quiz_id: '<?= @$quiz_id ?>',
          quiz_title: '<?= @$quiz_title ?>',
          user_id: '<?= $user_data['id'] ?>',
          selected_question: questions_checked
        };
        var http = new XMLHttpRequest();
        http.open("POST", 'controller/select_question_controller.php', true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
          if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // console.log(this.responseText);
            eval(this.responseText);
          }
        }
        var _param = JSON.stringify(param);
        http.send("load_question=" + _param);
      }
    }

    function view_question(_question,_ans_choice,_subj_name,_question_type){
      var param = {
        question:_question,
        ans_choice:_ans_choice,
        question_type:_question_type
      };
      var http = new XMLHttpRequest();
      http.open("POST", 'modals/question_view_modal.php', true);
      http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      http.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
          Swal.fire({
            html: this.responseText
          })
        }
      }
      var _param = JSON.stringify(param);
      http.send("question_data=" + _param);
    }
  </script>
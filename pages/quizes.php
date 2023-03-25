<?php
require_once "controller/quiz_controller.php";

?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath">
      <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i>
      <a href="template?page=subject" class="home-link">ວິຊາເສັງ</a> <i class="fas fa-chevron-right"></i>
      ຫົວຂໍ້ສອບເສັງ
    </h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      $user_id = @$user_data['id'];
      if(isset($_POST['del_quiz'])){
        del_quiz($_POST['id'],$user_id);
      }
      if(isset($_POST['set_question_num'])){
        set_question_num($_POST['q_num'],$_POST['quiz_id'],$user_id);
      }
      $quiz_data = load_data($user_id,$permission['view_all_quiz']);
      $data = $quiz_data->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຂໍ້ມູນຫົວຂໍ້ສອບເສັງ</h4>
            <div class="top-content">
              <div>
                <button onclick="window.location.href='template?page=quizes&sub_page=new_quiz'" type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath">
                  <i class="ti-plus btn-icon-prepend"></i> ເພີ່ມໃໝ່
                </button>
              </div>

              <div class="paginate">
                <?php
                $current_page = 1;
                $row_num = $quiz_data->rowCount();
                include_once 'paginate.php';
                ?>

              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-id phetsarath">ຫົວຂໍສອບເສັງ</th>
                    <th class="phetsarath">ຄະແນນເຕັມ</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $limit_start = ($current_page - 1) * $limit_row;
                  for ($i = $limit_start; $i < ($limit_start + 10); $i++) {
                    if ($i == $row_num) {
                      break;
                    }
                  ?>
                    <tr>
                      <td class="col-id phetsarath"><?=$data[$i]['quiz_title']?> </td>
                      <td class="phetsarath">
                        <span style="color: red;"><i class="fas fa-solid fa-trophy"></i> <?=$data[$i]['total_score']?></span>
                      </td>
                      <td>
                        <button onclick="window.location.href='template?page=quizes&sub_page=update_quiz&quiz_id=<?=$data[$i]['quiz_id']?>'" type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button onclick="window.location = 'template?page=quizes&sub_page=quiz_preview&quiz_id=<?=$data[$i]['quiz_id'].'&quiz_title='.$data[$i]['quiz_title']?>'" 
                        type="button" class="btn btn-secondary btn-icon-text btn-rounded none-select none-outline">
                          <?=$data[$i]['question_num']?> <i class="ti-themify-favicon-alt"></i>
                        </button>
                        <?php if($data[$i]['status']==1){?>
                        <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" data-id="<?=$data[$i]['quiz_id']?>" data-bs-toggle="modal" data-bs-target="#confirm_dialog" data-bs-backdrop="static">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
  include_once("modals/confirm_dialog.php");
  include_once("modals/set_quiz_num_modal.php");
?>
<script>
    var confirm_dialog = document.getElementById('confirm_dialog');
    confirm_dialog.addEventListener('show.bs.modal',function(event){
        var quiz_data = $(event.relatedTarget);
        var quiz_id = quiz_data.data('id');
        var modal = $(this);
        modal.find('.modal-body #id').val(quiz_id);
        document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການລຶບຂໍ້ມູນແມ່ນບໍ່";
        document.getElementById('btn_yes').setAttribute("name","del_quiz");
    });
    var question_num = document.getElementById('question_num');
    question_num.addEventListener('show.bs.modal',function(event){
        var question_data = $(event.relatedTarget);
        var quiz_num = question_data.data('quiz-num');
        var _question_num = question_data.data('question-num');
        var quiz_id = question_data.data('id');
        document.getElementById('question_num_lb').innerHTML = "ຈໍານວນຄໍາຖາມ: "+quiz_num+" ຄໍາຖາມ";
        document.getElementById('_question_num').max = parseInt(_question_num);
        document.getElementById('_question_num').value = quiz_num;
        document.getElementById('quiz_id').value = quiz_id;
    });
</script>
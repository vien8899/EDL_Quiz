<?php
require_once "controller/quiz_question_controller.php";
// template?page=subject&sub_page=quiz&subj_id=4&subj_name=ກົນຈັກ
if(isset($_GET['subj_id'])){
  $subj_id = $_GET['subj_id'];
  $subj_name = $_GET['subj_name'];
}else{
  ?>
    <script>window.location.href = 'template?page=subject'</script>
  <?php
}
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath">
      <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i>
      <a href="template?page=subject" class="home-link">ວິຊາເສັງ</a> <i class="fas fa-chevron-right"></i>
      <a href="template?page=subject&sub_page=quiz&subj_id=<?=$subj_id?>&subj_name=<?=$subj_name?>" class="home-link">ຫົວຂໍ້ສອບເສັງ</a> <i class="fas fa-chevron-right"></i>
      ຄໍາຖາມສອບເສັງ
    </h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
    if (isset($_GET['quiz_id'])) {
      $quiz_id_param = "&quiz_id=" . $_GET['quiz_id'];
    }
    if (isset($_GET['quiz_title'])) {
      $quiz_title_param = "&quiz_title=" . $_GET['quiz_title'];
    }
    if (isset($_GET['subj_id'])) {
      $subj_id_param = "&subj_id=" . $_GET['subj_id'];
    }
    $user_id = @$user_data['id'];
    if (isset($_POST['del_subject'])) {
      del_subject($_POST['id']);
    }
    if (isset($_POST['del_question'])) {
      del_question($_POST['id']);
    }
    $data = load_data($_GET['quiz_id'])->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຄໍາຖາມສອບເສັງ (<?= isset($_GET['quiz_title']) ? $_GET['quiz_title'] : '' ?>)</h4>
            <div class="top-content">
              <div>
                <button type="button" onclick="window.location.href='template?page=subject&sub_page=select_question<?= @$quiz_id_param . @$quiz_title_param . @$subj_id_param ?>&subj_name=<?=$subj_name?>'" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath">
                  <i class="ti-import"></i>
                </button>
              </div>

              <div class="paginate">
                <?php
                $current_page = 1;
                $row_num = load_data($_GET['quiz_id'])->rowCount();
                include_once 'paginate.php';
                ?>

              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-id phetsarath" width="60">ລະຫັດ</th>
                    <th class="phetsarath">ຄໍາຖາມສອບເສັງ</th>
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
                      <td class="col-id"><?= $data[$i]['quiz_question_id'] ?></td>
                      <td class="phetsarath"><?php echo strip_tags(htmlspecialchars_decode($data[$i]['title'], ENT_QUOTES)); ?></td>
                      <td>
                        <button onclick="view_question('<?= encode($data[$i]['question']) ?>','<?= encode($data[$i]['ans_choice']) ?>','<?= encode($data[$i]['subj_name']) ?>',<?=encode($data[$i]['question_type'])?>)" type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline">
                          <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" data-id="<?= $data[$i]['quiz_question_id'] ?>" data-bs-toggle="modal" data-bs-target="#confirm_dialog" data-bs-backdrop="static">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                        <!-- <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" data-id="<?= $data[$i]['id'] ?>" data-bs-toggle="modal" data-bs-target="#confirm_dialog" data-bs-backdrop="static">
                          <i class="fas fa-trash-alt"></i>
                        </button> -->
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
// include_once("modals/add_subject_modal.php"); 
include_once("modals/confirm_dialog.php");
?>
<script>
  var confirm_dialog = document.getElementById('confirm_dialog');
  confirm_dialog.addEventListener('show.bs.modal', function(event) {
    var question_data = $(event.relatedTarget);
    var id = question_data.data('id');
    var modal = $(this);
    modal.find('.modal-body #id').val(id);
    document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການລຶບຂໍ້ມູນແມ່ນບໍ່";
    document.getElementById('btn_yes').setAttribute("name", "del_question");
  });

  function view_question(_question,_ans_choice,_subj_name,_question_type){
    var param = {
      question:_question,
      ans_choice:_ans_choice,
      subj_name:_subj_name,
      question_type:_question_type
    };
    var http = new XMLHttpRequest();
    http.open("POST", 'modals/question_view_modal.php', true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        // console.log(this.responseText);
        Swal.fire({
          html: this.responseText
        })
      }
    }
    var _param = JSON.stringify(param);
    http.send("question_data=" + _param);
  }
</script>
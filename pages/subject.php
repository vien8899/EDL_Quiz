<?php
require_once "controller/subject_controller.php";

?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ວິຊາເສັງ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      $user_id = @$user_data['id'];
      if(isset($_POST['new_subject'])){
        add_subject($_POST['subj_name'],$user_id);
      }
      if(isset($_POST['update_subject'])){
        update_subject($_POST['subj_id'],$_POST['subj_name'],$user_id);
      }
      if(isset($_POST['del_subject'])){
        del_subject($_POST['id']);
      }
      $data = load_subject()->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຂໍ້ມູນຫ້ອງວິຊາເສັງ</h4>
            <div class="top-content">
              <div>
                <button type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath" data-toggle="modal" data-target="#addsubject" data-backdrop="static">
                  <i class="ti-plus btn-icon-prepend"></i> ເພີ່ມໃໝ່
                </button>
              </div>

              <div class="paginate">
                <?php
                $current_page = 1;
                $row_num = load_subject()->rowCount();
                include_once 'paginate.php';
                ?>

              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-id phetsarath" width="60">ລະຫັດ</th>
                    <th class="phetsarath">ຊື່ວິຊາເສັງ</th>
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
                      <td class="col-id"><?=$data[$i]['subj_id']?></td>
                      <td class="phetsarath"><?=$data[$i]['subj_name']?></td>
                      <td>
                        <button type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline" data-subj_id="<?=$data[$i]['subj_id']?>" data-subj_name="<?=$data[$i]['subj_name']?>" data-bs-toggle="modal" data-bs-target="#editsubject" data-bs-backdrop="static">
                          <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button onclick="window.location.href='template?page=question&subj_id=<?=$data[$i]['subj_id']?>'"  type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline" id="log">
                          <i class="fas fa-solid fa-scroll"></i> <?=$data[$i]['ques_num']?>
                        </button>
                        <?php
                          $ques_num = intval($data[$i]['ques_num']);
                          if($ques_num==0){
                            ?>
                              <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" data-id="<?=$data[$i]['subj_id']?>" data-bs-toggle="modal" data-bs-target="#confirm_dialog" data-bs-backdrop="static">
                                <i class="fas fa-trash-alt"></i>
                              </button>
                            <?php
                          }
                        ?>
                        
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
  include_once("modals/add_subject_modal.php"); 
  include_once("modals/update_subject_modal.php");
  include_once("modals/confirm_dialog.php");
?>
<!-- @include('modal.newclass')
@include('modal.editclass')
@include('modal.log') -->
<script>

var edit_subject = document.getElementById('editsubject')
edit_subject.addEventListener('show.bs.modal', function(event) {
  var subject_data = $(event.relatedTarget);
  var subj_id = subject_data.data('subj_id');
  var subj_name = subject_data.data('subj_name');
  var modal = $(this);
  modal.find('.modal-body #subj_id').val(subj_id);
  modal.find('.modal-body #subj_name').val(subj_name);
});
var confirm_dialog = document.getElementById('confirm_dialog');
confirm_dialog.addEventListener('show.bs.modal',function(event){
  var subject_data = $(event.relatedTarget);
  var subj_id = subject_data.data('id');
  var modal = $(this);
  modal.find('.modal-body #id').val(subj_id);
  document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການລຶບຂໍ້ມູນແມ່ນບໍ່";
  document.getElementById('btn_yes').setAttribute("name","del_subject");
});
  // function show_log(log_id) {
  //   console.log(log_id);
  //   console.log("{{$log_data}}");
  //   $('#actionlog').modal('show');
  // }
</script>
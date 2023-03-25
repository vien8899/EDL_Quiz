<?php
require_once "controller/class_quiz_prepare_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath">
      <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> 
      <a href="template?page=classroom" class="home-link">ຫ້ອງເສັງ</a> <i class="fas fa-chevron-right"></i> ຫົວຂໍ້ເສັງ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      if(isset($_GET['class_des'])){
        $class_des_param = "&class_des=".$_GET['class_des'];
      }
      if(isset($_GET['class_id'])){
        $class_id_param = "&class_id=".$_GET['class_id'];
        $class_id = $_GET['class_id'];
      }else{
        echo "<script>window.location.href = 'template?page=classroom'</script>";
      }
      $user_id = @$user_data['id'];
      if(isset($_POST['del_quiz'])){
        del_quiz($_POST['id']);
      }
      $quiz_data = get_class_quiz_data($class_id);
      $data = $quiz_data->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຂໍ້ມູນຫົວຂໍ້ເສັງ ຫ້ອງ-<?=isset($_GET['class_des'])?$_GET['class_des']:''?></h4>
            <div class="top-content">
              <div>
                <button type="button" onclick="window.location.href='template?page=classroom&sub_page=load_quiz<?=@$class_id_param.@$class_des_param?>'" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath">
                  <i class="ti-import"></i>
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
                    <th class="col-id phetsarath">ຫົວຂໍ້ເສັງ</th>
                    <th class="phetsarath">ຄະແນນເຕັມ</th>
                    <th class="phetsarath">ຈໍານວນຄໍາຖາມ</th>
                    <th class="phetsarath">ເວລາ</th>
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
                      <td class="col-id phetsarath"><?=$data[$i]['quiz_title']?></td>
                      <td class="phetsarath"><?=$data[$i]['total_score']?></td>
                      <td class="phetsarath"><?=$data[$i]['question_num']?></td>
                      <td class="phetsarath"><?=$data[$i]['quiz_time']?> ນາທີ</td>
                      <td>
                        <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" data-id="<?=$data[$i]['id']?>" data-bs-toggle="modal" data-bs-target="#confirm_dialog" data-bs-backdrop="static">
                          <i class="fas fa-trash-alt"></i>
                        </button>
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
?>
<script>
  var confirm_dialog = document.getElementById('confirm_dialog');
  confirm_dialog.addEventListener('show.bs.modal',function(event){
    var subject_data = $(event.relatedTarget);
    var id = subject_data.data('id');
    var modal = $(this);
    modal.find('.modal-body #id').val(id);
    document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການລຶບຂໍ້ມູນແມ່ນບໍ່";
    document.getElementById('btn_yes').setAttribute("name","del_quiz");
  });
</script>
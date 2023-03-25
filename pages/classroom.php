<?php
require_once "controller/classroom_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ຫ້ອງເສັງ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      $user_id = @$user_data['id'];
      if(isset($_POST['new_class'])){
        add_class($_POST['class_des'],$user_id);
      }
      if(isset($_POST['update_class'])){
        update_class($_POST['id'],$_POST['class_des'],$user_id);
      }
      if(isset($_POST['del_class'])){
        del_classroom($_POST['id']);
      }
      $data = load_data()->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຂໍ້ມູນຫ້ອງສອບເສັງ</h4>
            <div class="top-content">
              <div>
                <button type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath" data-toggle="modal" data-target="#addclass" data-backdrop="static">
                  <i class="ti-plus btn-icon-prepend"></i> ເພີ່ມໃໝ່
                </button>
              </div>

              <div class="paginate">
                <?php
                $current_page = 1;
                $row_num = load_data()->rowCount();
                include_once 'paginate.php';
                ?>

              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-id phetsarath" width="60">ລະຫັດ</th>
                    <th class="phetsarath">ຫ້ອງເສັງ</th>
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
                      <td class="col-id"><?=$data[$i]['id']?></td>
                      <td class="phetsarath"><?=$data[$i]['class_des']?></td>
                      <td>
                        <button type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline" data-id="<?=$data[$i]['id']?>" data-class_des="<?=$data[$i]['class_des']?>" data-bs-toggle="modal" data-bs-target="#editclass" data-bs-backdrop="static">
                          <i class="fas fa-pencil-alt"></i>
                        </button>
                        <!-- <i class="fa-duotone fa-chalkboard-user"></i> -->
                        <button onclick="window.location.href='template?page=classroom&sub_page=class_member&class_id=<?=$data[$i]['id']?>&class_des=<?php echo htmlspecialchars($data[$i]['class_des'],ENT_QUOTES, 'UTF-8'); ?>';" type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline">
                          <i class="fas fa-user-friends btn-icon-prepend"></i><?=$data[$i]['member']?>
                        </button>
                        <button onclick="window.location.href='template?page=classroom&sub_page=class_tc&class_id=<?=$data[$i]['id']?>&class_des=<?php echo htmlspecialchars($data[$i]['class_des'],ENT_QUOTES, 'UTF-8'); ?>';" type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline">
                          <i class="fas fa-user-friends"></i>
                          <i class="fas fa-chalkboard btn-icon-prepend"></i><?=$data[$i]['tc']?>
                        </button>
                          <button onclick="window.location = 'template?page=classroom&sub_page=class_quiz_prepare&class_id=<?=$data[$i]['id']?>&class_des=<?php echo htmlspecialchars($data[$i]['class_des'],ENT_QUOTES, 'UTF-8'); ?>';"  type="button" class="btn btn-secondary btn-icon-text btn-rounded none-select none-outline" id="log">
                            <i class="ti-book btn-icon-prepend"></i><?=$data[$i]['quiz_num']?>
                          </button>
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
  include_once("modals/add_classroom_modal.php"); 
  include_once("modals/update_classroom_modal.php");
  include_once("modals/confirm_dialog.php");
?>
<script>
  var edit_class = document.getElementById('editclass')
  edit_class.addEventListener('show.bs.modal', function(event) {
    var class_data = $(event.relatedTarget);
    var class_id = class_data.data('id');
    var class_des = class_data.data('class_des');
    var modal = $(this);
    modal.find('.modal-body #class_id').val(class_id);
    modal.find('.modal-body #class_des').val(class_des);
  });
  var confirm_dialog = document.getElementById('confirm_dialog');
  confirm_dialog.addEventListener('show.bs.modal',function(event){
    var class_data = $(event.relatedTarget);
    var class_id = class_data.data('id');
    var modal = $(this);
    modal.find('.modal-body #id').val(class_id);
    document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການລຶບຂໍ້ມູນແມ່ນບໍ່";
    document.getElementById('btn_yes').setAttribute("name","del_class");
  });
</script>
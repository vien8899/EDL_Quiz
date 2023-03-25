<?php
require_once "controller/classroom_controller.php";
require_once "controller/position_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ຕໍາແໜ່ງ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      $user_id = @$user_data['id'];
      if(isset($_POST['new_position'])){
        add_position($_POST['position']);
      }
      if(isset($_POST['update_position'])){
        update_position($_POST['position_id'],$_POST['position_des']);
      }
      if(isset($_POST['del_position'])){
        del_position($_POST['id']);
      }
    //   $data = load_data()->fetchAll(PDO::FETCH_ASSOC);
      $position = get_position();
      $data = $position->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຂໍ້ມູນຕໍາແໜ່ງ</h4>
            <div class="top-content">
              <div>
                <?php if($permission['manage_position']){?>
                <button type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath" data-toggle="modal" data-target="#addposition" data-backdrop="static">
                  <i class="ti-plus btn-icon-prepend"></i> ເພີ່ມໃໝ່
                </button>
                <?php } ?>
              </div>

              <div class="paginate">
                <?php
                $current_page = 1;
                $row_num = $position->rowCount();
                include_once 'paginate.php';
                ?>

              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-id phetsarath" width="60">ລະຫັດ</th>
                    <th class="phetsarath">ຕໍາແໜ່ງ</th>
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
                      <td class="col-id"><?=$data[$i]['position_id']?></td>
                      <td class="phetsarath"><?=$data[$i]['position_des']?></td>
                      <td>
                        <?php if($permission['manage_position']){ ?>
                        <button type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline" data-id="<?=$data[$i]['position_id']?>" data-position_des="<?=$data[$i]['position_des']?>" data-bs-toggle="modal" data-bs-target="#updateposition" data-bs-backdrop="static">
                          <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" data-id="<?=$data[$i]['position_id']?>" data-bs-toggle="modal" data-bs-target="#confirm_dialog" data-bs-backdrop="static">
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
  include_once("modals/add_position_modal.php"); 
  include_once("modals/update_position_modal.php");
  include_once("modals/confirm_dialog.php");
?>
<script>
  var position = document.getElementById('updateposition')
  position.addEventListener('show.bs.modal', function(event) {
    var position_data = $(event.relatedTarget);
    var position_id = position_data.data('id');
    var position_des = position_data.data('position_des');
    var modal = $(this);
    modal.find('.modal-body #position_id').val(position_id);
    modal.find('.modal-body #position_des').val(position_des);
  });
  var confirm_dialog = document.getElementById('confirm_dialog');
  confirm_dialog.addEventListener('show.bs.modal',function(event){
    var position_data = $(event.relatedTarget);
    var position_id = position_data.data('id');
    var modal = $(this);
    modal.find('.modal-body #id').val(position_id);
    document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການລຶບຂໍ້ມູນແມ່ນບໍ່";
    document.getElementById('btn_yes').setAttribute("name","del_position");
  });
</script>
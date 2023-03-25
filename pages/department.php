<?php
require_once "controller/department_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ຂໍ້ມູນຝ່າຍ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      $user_id = @$user_data['id'];
      if(isset($_POST['new_department'])){
        add_department($_POST['dep_name'],$user_id);
      }
      if(isset($_POST['update_department'])){
        update_department($_POST['dep_id'],$_POST['dep_name'],$user_id);
      }
      if(isset($_POST['del_department'])){
        del_department($_POST['id']);
      }
      $data = load_data()->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຂໍ້ມູນຝ່າຍ</h4>
            <div class="top-content">
              <div class="top-act">
                <?php if($permission['manage_dep']){ ?>
                <button type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath" data-toggle="modal" data-target="#adddepartment" data-backdrop="static">
                  <i class="ti-plus btn-icon-prepend"></i> ເພີ່ມໃໝ່
                </button>
                <?php } ?>
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
                    <th class="phetsarath">ຊື່ຝ່າຍ</th>
					<th class="phetsarath">ຈຳນວນພະແນກໃນຝ່າຍ</th>
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
                      <td class="col-id"><?=$data[$i]['dep_id']?></td>
                      <td class="phetsarath"><?=$data[$i]['dep_name']?></td> 
					  <td class="phetsarath"><?=$data[$i]['number_of_dept']?></td>
                      <td>
                        <?php if($permission['manage_dep']){ ?>
                        <button type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline" data-dep_id="<?=$data[$i]['dep_id']?>" data-dep_name="<?=$data[$i]['dep_name']?>" data-bs-toggle="modal" data-bs-target="#editdepartment" data-bs-backdrop="static">
                          <i class="fas fa-pencil-alt"></i>
                        </button>
						
						<?php if($data[$i]['number_of_dept']==0){?>
                        <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" data-id="<?=$data[$i]['dep_id']?>" data-bs-toggle="modal" data-bs-target="#confirm_dialog" data-bs-backdrop="static">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                        <?php }} ?>
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
  include_once("modals/add_department_modal.php"); 
  include_once("modals/update_department_modal.php");
  include_once("modals/confirm_dialog.php");
?>
<script>
  var edit_class = document.getElementById('editdepartment')
  edit_class.addEventListener('show.bs.modal', function(event) {
    var dep_data = $(event.relatedTarget);
    var dep_id = dep_data.data('dep_id');
    var dep_name = dep_data.data('dep_name');
    var modal = $(this);
    modal.find('.modal-body #dep_id').val(dep_id);
    modal.find('.modal-body #dep_name').val(dep_name);
  });
  var confirm_dialog = document.getElementById('confirm_dialog');
  confirm_dialog.addEventListener('show.bs.modal',function(event){
    var dep_data = $(event.relatedTarget);
    var dep_id = dep_data.data('id');
    var modal = $(this);
    modal.find('.modal-body #id').val(dep_id);
    document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການລຶບຂໍ້ມູນແມ່ນບໍ່";
    document.getElementById('btn_yes').setAttribute("name","del_department");
  });
</script>
<?php
  require_once "controller/user_group_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ກຸ່ມຜູ້ໃຊ້ງານລະບົບ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
  <?php
      if(isset($_POST['add_user_group'])){
        add_user_group($_POST['group_des']);
      }
      if(isset($_POST['update_user_group'])){
        update_user_group($_POST['user_group_id'],$_POST['user_group_des']);
      }
      if(isset($_POST['del_user_group'])){
        del_user_group($_POST['id']);
      }
      $dep_id = 0;
      if(isset($_GET['dep_id'])){
        $dep_id = $_GET['dep_id'];
      }
      $user_id = @$user_data['id'];
      $user_group_id =  @$user_data['user_group_id'];
      if(isset($_POST['del_question'])){
        del_question($_POST['id']);
      }
      $data = load_user_group_data();
      $user_group = $data->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຂໍ້ມູນກຸ່ມຜູ້ໃຊ້ງານລະບົບ</h4>
            <div class="top-content">
              <div class="top-act">
                <?php if($permission['manage_user_group']){ ?>
                <button type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath" data-bs-toggle="modal" data-bs-target="#add_user_group" data-bs-backdrop="static">
                  <i class="ti-plus btn-icon-prepend"></i> ເພີ່ມໃໝ່
                </button>
                <?php } ?>
              </div>

              <div class="paginate">
                <?php
                $current_page = 1;
                $row_num = $data->rowCount();
                include_once 'paginate.php';
                ?>

              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-id phetsarath" width="60">ລະຫັດ</th>
                    <th class="phetsarath">ກຸ່ມຜູ້ໃຊ້ງານລະບົບ</th>
                    <th class="phetsarath">ສະມາສິກ</th>
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
                      <td class="col-id"><?=$user_group[$i]['user_group_id']?></td>
                      <td class="phetsarath"><?=htmlspecialchars_decode($user_group[$i]['group_des'],ENT_QUOTES)?></td>
                      <td class="phetsarath"><i class="fas fa-solid fa-user"></i> <?=$user_group[$i]['member']?></td>
                      <td>
                        <?php 
                          if($user_group[$i]['read_only']==0 && $permission['manage_user_group'] ){ 
                            
                        ?>
                          <div style="width: 39.5px; float:left; height:36.25px; margin-right:5px; padding-top:5px;">
                            <?php if($permission['manage_permission'] && ($user_group[$i]['user_group_id']!=$user_group_id)){ ?>
                              <button type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline"
                              onclick="window.location.href='template?page=user_group&sub_page=group_permission&user_group_id=<?=$user_group[$i]['user_group_id']?>'">
                                <i class="fas fa-solid fa-user-shield"></i>
                              </button>
                            <?php } ?>
                          </div>
                        <button type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline"
                          data-user_group_id="<?=$user_group[$i]['user_group_id']?>"
                          data-group_des="<?=$user_group[$i]['group_des']?>" 
                          data-bs-toggle="modal" data-bs-target="#update_user_group" data-bs-backdrop="static">
                          <i class="fas fa-pencil-alt"></i>
                        </button>
                        <?php if($user_group[$i]['user_group_id']!=$user_group_id){ ?>
                        <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" data-id="<?=$user_group[$i]['user_group_id']?>" data-bs-toggle="modal" data-bs-target="#confirm_dialog" data-bs-backdrop="static">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                        <?php } } ?>                  
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
  include_once("modals/add_usergroup_modal.php");
  include_once("modals/update_usergroup_modal.php");
?>

<script>
  var confirm_dialog = document.getElementById('confirm_dialog');
  confirm_dialog.addEventListener('show.bs.modal',function(event){
    var unit_data = $(event.relatedTarget);
    var unit_id = unit_data.data('id');
    var modal = $(this);
    modal.find('.modal-body #id').val(unit_id);
    document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການລຶບຂໍ້ມູນແມ່ນບໍ່";
    document.getElementById('btn_yes').setAttribute("name","del_user_group");
  });
  var user_group = document.getElementById('update_user_group');
  user_group.addEventListener('show.bs.modal',function(event){
    var user_group_data = $(event.relatedTarget);
    var user_group_id = user_group_data.data('user_group_id');
    var user_group_des = user_group_data.data('group_des');
    var modal = $(this);
    modal.find('.modal-body #user_group_id').val(user_group_id);
    modal.find('.modal-body #user_group_des').val(user_group_des);
  });
</script>
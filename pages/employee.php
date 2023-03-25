<?php
require_once "controller/employee_controller.php";

?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ຂໍ້ມູນພະນັກງານ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      $user_id = @$user_data['id'];
      if(isset($_POST['del_emp'])){
        del_emp($_POST['id']);
      }
      if(isset($_POST['update_usergroup'])){
        set_user_group($_POST['user_id'],$_POST['user_group_id']);
      }
      if(isset($_POST['update_pwd'])){
        $password = $_POST['password'];
        if($password!="edlquiz"){
          update_pwd($_POST['u_id'],$password);
        }
      }
      $dep_id = isset($_GET['dep_id'])?$_GET['dep_id']:0;
      $unit_id = isset($_GET['unit_id'])?$_GET['unit_id']:0;
      $url_param = (isset($_GET['dep_id']) ? "&dep_id=" . $_GET['dep_id'] : "").(isset($_GET['unit_id']) ? "&unit_id=" . $_GET['unit_id'] : "");
      $emp = load_employee($dep_id,$unit_id);
      $data = $emp->fetchAll(PDO::FETCH_ASSOC);
      $user_group = json_encode(get_user_group()->fetchAll(PDO::FETCH_ASSOC));
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຂໍ້ມູນພະນັກງານ</h4>
            <div class="top-content">
              <div class="top-act">
                <?php if($permission['manage_em']){ ?>
                <button onclick="window.location.href='template?page=employee&sub_page=new_employee<?=$url_param?>'" type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath">
                  <i class="ti-plus btn-icon-prepend"></i> ເພີ່ມໃໝ່
                </button>
                <?php } ?>
                <select onchange="cb_depart_changed(this.value)" class="form-select phetsarath" aria-label="Default select">
                    <option value="0" <?=($dep_id==0)?"selected":""?> >---ສະແດງທັງໝົດ---</option>
                    <?php
                      $departments = load_department()->fetchAll(PDO::FETCH_ASSOC);
                      foreach($departments as $department){
                        ?>
                          <option value='<?=$department['dep_id']?>' <?=($dep_id==$department['dep_id'])?"selected":""?> ><?=$department['dep_name']?></option>
                        <?php
                      }
                    ?>
                </select>
                <select onchange="cb_unit_changed(this.value)" class="form-select phetsarath" aria-label="Default select">
                    <option value="0" <?=($unit_id==0)?"selected":""?> >---ສະແດງທັງໝົດ---</option>
                    <?php
                      $unit_data = get_unit($dep_id)->fetchAll(PDO::FETCH_ASSOC);
                      foreach($unit_data as $unit){
                        ?>
                          <option value='<?=$unit['dep_id'].','.$unit['unit_id']?>' <?=($unit_id==$unit['unit_id'])?"selected":""?> ><?=$unit['unit_des']?></option>
                        <?php
                      }
                    ?>
                </select>
              </div>

              <div class="paginate">
                <?php
                $current_page = 1;
                $row_num = $emp->rowCount();
                include_once 'paginate.php';
                ?>

              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-id phetsarath" width="30">ລຳດັບ</th>
                    <th class="phetsarath">ຊື່ພະນັກງານ</th>
                    <th class="phetsarath" width="50">ອາຍຸ (ປີ)</th>
                    <th class="phetsarath">ເບິໂທ</th>
                    <th class="phetsarath">ຝ່າຍ</th>
                    <th class="phetsarath">ພະແນກ</th>
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
                        <td class="col-id" style="font-size: larger;">
                            <?php
							
								echo ($current_page*10)-10 + $i+1;
								/*
                                if($data[$i]['gender']=="male"){
                                    echo('<i class="fas fa-solid fa-mars" style="color:dodgerblue"></i>');
                                }elseif($data[$i]['gender']=="female"){
                                    echo('<i class="fas fa-solid fa-venus" style="color:mediumvioletred"></i>');
                                }else{
                                    echo('<i class="fas fa-solid fa-venus-mars"></i>');
                                }
								*/
                            ?>
                        </td>
                        <td class="phetsarath">
                            <label style="width: 20px; font-size: larger;">
                                <?=($data[$i]['user_type']==2)?'<i class="fas fa-solid fa-graduation-cap"></i>':''?>
                            </label>
                            <?=$data[$i]['fullname']?>
                        </td>
                        <td style="text-align: center;"><?=$data[$i]['age']?></td>
                        <td><?=$data[$i]['tel']?></td>
                        <td class="phetsarath"><?=$data[$i]['dep_name']?></td>
                        <td class="phetsarath"><?=$data[$i]['unit_des']?>
                          <!-- unit -->
                        </td>
                        <td>
                          <?php if($permission['change_user_pwd'] || $permission['manage_em'] ){ ?>
                          <div style="width: 39.5px; float:left; height:36.25px; margin-right:5px;">
                            <button type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline"
                            data-id="<?=$data[$i]['id']?>"
                            data-bs-toggle="modal" data-bs-target="#update_pwd" data-bs-backdrop="static">
                              <i class="fas fa-solid fa-key"></i>
                            </button>
                          </div>
                          <?php } ?>
                          <div style="width: 39.5px; float:left; height:36.25px; margin-right:5px;">
                          <?php if($permission['manage_em']){
                            if($data[$i]['user_type']!=2){  ?>
                            <button type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline" 
                            data-id="<?=$data[$i]['id']?>"
                            data-user_group_id="<?=$data[$i]['user_group_id']?>" data-bs-toggle="modal" data-bs-target="#update_usergroup" data-bs-backdrop="static">
                              <i class="fas fa-solid fa-user-shield"></i>
                            </button>
                          <?php } ?>
                          </div>
                        <button onclick="window.location.href='template?page=employee&sub_page=update_employee<?=$url_param?>&emp_id=<?=$data[$i]['id']?>'" type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline">
                          <i class="fas fa-pencil-alt"></i>
                        </button>
                        <?php if($user_id!=$data[$i]['id']){ ?>
                        <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" data-id="<?=$data[$i]['id']?>" data-bs-toggle="modal" data-bs-target="#confirm_dialog" data-bs-backdrop="static">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                        <?php 
                            } 
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
  include_once("modals/confirm_dialog.php");
  include_once("modals/user_group_modal.php");
  include_once("modals/update_user_password_modal.php");
?>
<script>
  function cb_depart_changed(value){
    if(value == 0){
      window.location.href = "template?page=employee";
    }else{
      window.location.href = "template?page=employee&dep_id="+value;
    }
  }
  function cb_unit_changed(value){
    var data = value.split(',');
    console.log(data);
    if(data[0]==0){
      if(<?=$dep_id?>==0){
        window.location.href = "template?page=employee";
      }else{
        window.location.href = "template?page=employee&dep_id="+'<?=$dep_id?>';
      }
    }else{
      window.location.href = "template?page=employee&dep_id="+data[0]+"&unit_id="+data[1];
    }
  }
  var confirm_dialog = document.getElementById('confirm_dialog');
  confirm_dialog.addEventListener('show.bs.modal',function(event){
    var dep_data = $(event.relatedTarget);
    var dep_id = dep_data.data('id');
    var modal = $(this);
    modal.find('.modal-body #id').val(dep_id);
    document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການລຶບຂໍ້ມູນແມ່ນບໍ່";
    document.getElementById('btn_yes').setAttribute("name","del_emp");
  });
  var user_group_modal = document.getElementById('update_usergroup');
  user_group_modal.addEventListener('show.bs.modal',function(event){
    var user_data = $(event.relatedTarget);
    var user_id = user_data.data('id');
    var user_group_id = user_data.data('user_group_id');
    var user_group = JSON.parse('<?=$user_group?>');
    var user_group_str = ``;
    for(data of user_group){
      var selected = '';
      if(data.user_group_id==user_group_id)
        selected = 'selected';
      user_group_str +=`<option value='`+data.user_group_id+`' `+selected+`>`+data.group_des+`</option>`;
    }
    var modal = $(this);
    modal.find('.modal-body #user_id').val(user_id);
    document.getElementById('user_group').innerHTML = user_group_str;
  });
  var update_pwd_modal = document.getElementById('update_pwd');
  update_pwd_modal.addEventListener('show.bs.modal',function(event){
    var user_data = $(event.relatedTarget);;
    var user_id = user_data.data('id');
    var modal = $(this);
    modal.find('.modal-body #u_id').val(user_id);
  });
</script>
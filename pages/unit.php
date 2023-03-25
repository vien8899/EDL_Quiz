<?php
  require_once "controller/unit_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ຂໍ້ມູນພະແນກ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
  <?php
      if(isset($_POST['add_unit'])){
        add_unit($_POST['dep'],$_POST['unit_des']);
      }
      if(isset($_POST['update_unit'])){
        update_uint($_POST['unit_id'],$_POST['unit_des'],$_POST['dep']);
      }
      if(isset($_POST['del_unit'])){
        del_unit($_POST['id']);
      }
      $dep_id = 0;
      if(isset($_GET['dep_id'])){
        $dep_id = $_GET['dep_id'];
      }
      $user_id = @$user_data['id'];
      if(isset($_POST['del_question'])){
        del_question($_POST['id']);
      }
      $subj_id = 0;
      $data = load_unit_data($dep_id);
      $unit_data = $data->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຂໍ້ມູນພະແນກ</h4>
            <div class="top-content">
              <div class="top-act">
                <?php if($permission['manage_unit']){ ?>
                <button type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath" data-bs-toggle="modal" data-bs-target="#add_unit" data-bs-backdrop="static">
                  <i class="ti-plus btn-icon-prepend"></i> ເພີ່ມໃໝ່
                </button>
                <?php } ?>
                <select onchange="cb_dep_changed(this.value)" class="form-select phetsarath" aria-label="Default select">
                    <option value="0" <?=($subj_id==0)?"selected":""?> >---ສະແດງທັງໝົດ---</option>
                    <?php
                      $dep_data = get_dep_data()->fetchAll(PDO::FETCH_ASSOC);
                      foreach($dep_data as $dep){
                        ?>
                          <option value='<?=$dep['dep_id']?>' <?=($dep_id==$dep['dep_id'])?"selected":""?> ><?=$dep['dep_name']?></option>
                        <?php
                      }
                    ?>
                </select>
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
                    <th class="phetsarath">ຊື່ພະແນກ</th>
                    <th class="phetsarath">ຂຶ້ນກັບຝ່າຍ</th>
					<th class="phetsarath">ຈຳນວນພະນັກງານ</th>
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
                      <td class="col-id"><?=$unit_data[$i]['unit_id']?></td>
                      <td class="phetsarath"><?=htmlspecialchars_decode($unit_data[$i]['unit_des'],ENT_QUOTES)?></td>
                      <td class="phetsarath"><?=$unit_data[$i]['dep_name']?></td>
					  <td class="phetsarath"><?=$unit_data[$i]['number_of_staff']?></td>
                      <td>
                        <?php if($permission['manage_unit']){ ?>
                        <button type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline" 
                          data-id="<?=$unit_data[$i]['unit_id']?>" 
                          data-dep_id="<?=$unit_data[$i]['dep_id']?>" 
                          data-des="<?=$unit_data[$i]['unit_des']?>" 
                          data-bs-toggle="modal" 
                          data-bs-target="#update_unit" 
                          data-bs-backdrop="static">
                          <i class="fas fa-pencil-alt"></i>
                        </button>
						
						<?php if($unit_data[$i]['number_of_staff']==0){?>
                        <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" data-id="<?=$unit_data[$i]['unit_id']?>" data-bs-toggle="modal" data-bs-target="#confirm_dialog" data-bs-backdrop="static">
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
  include_once("modals/confirm_dialog.php");
  include_once("modals/add_unit_modal.php");
  include_once("modals/update_unit_modal.php");
?>

<script>
  var confirm_dialog = document.getElementById('confirm_dialog');
  confirm_dialog.addEventListener('show.bs.modal',function(event){
    var unit_data = $(event.relatedTarget);
    var unit_id = unit_data.data('id');
    var modal = $(this);
    modal.find('.modal-body #id').val(unit_id);
    document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການລຶບຂໍ້ມູນແມ່ນບໍ່";
    document.getElementById('btn_yes').setAttribute("name","del_unit");
  });
  var add_unit = document.getElementById('add_unit')
  add_unit.addEventListener('show.bs.modal', function(event) {
    var dep_id = '<?=$dep_id?>';
    var modal = $(this);
    var dep_data = JSON.parse('<?=json_encode($dep_data);?>');
    var dep_select = document.getElementById('dep');
      var dep_str = ``;
      for(index in dep_data){
        var dep = dep_data[index];
        var selected = "";
        if(dep_id == dep.dep_id){
          selected = "selected";
        }
        dep_str +=` <option value='`+dep.dep_id+`' `+selected+`>`+dep.dep_name+`</option>`;
      }
      dep_select.innerHTML = dep_str;
  });
  var update_unit = document.getElementById('update_unit');
  update_unit.addEventListener('show.bs.modal', function(event) {
    var unit_data = $(event.relatedTarget);
    var dep_id = unit_data.data('dep_id');
    var unit_id = unit_data.data('id');
    var unit_des = unit_data.data('des');
    var modal = $(this);
    var dep_data = JSON.parse('<?=json_encode($dep_data);?>');
    var dep_select = document.getElementById('dep_update');
    var dep_str = ``;
    for(index in dep_data){
      var dep = dep_data[index];
      var selected = "";
      if(dep_id == dep.dep_id){
          selected = "selected";
      }
      dep_str +=` <option value='`+dep.dep_id+`' `+selected+`>`+dep.dep_name+`</option>`;
    }
    dep_select.innerHTML = dep_str;
    modal.find('.modal-body #unit_id').val(unit_id);
    modal.find('.modal-body #unit_des').val(unit_des);
  });
  function cb_dep_changed(value){
    if(value == 0){
      window.location.href = "template?page=unit";
    }else{
      window.location.href = "template?page=unit&dep_id="+value;
    }
  }
</script>
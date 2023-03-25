<?php
require_once "controller/class_member_controller.php";
require_once "controller/select_tc_controller.php";
$class_id = 0;
$dep_id = isset($_GET['dep_id'])?$_GET['dep_id']:0;
$unit_id = isset($_GET['unit_id'])?$_GET['unit_id']:0;
$search_text = isset($_POST['search'])?$_POST['txt_search']:'';
$filter = (($dep_id!=0)?" AND d.dep_id = $dep_id":"").(($unit_id!=0)?" AND u.unit_id=$unit_id":"").(($search_text!='')?" AND fullname LIKE '%$search_text%'":"");
if (isset($_GET['class_des'])) {
  $class_des_param = "&class_des=" . $_GET['class_des'];
  $class_des = $_GET['class_des'];
}
if (isset($_GET['class_id'])) {
  $class_id_param = "&class_id=" . $_GET['class_id'];
  $class_id = $_GET['class_id'];
}
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<link rel="stylesheet" href="assets/css/class-member-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> <a href="template?page=classroom" class="home-link">ຫ້ອງເສັງ</a>
    <i class="fas fa-chevron-right"></i> <a href="template?page=class_tc<?=@$class_id_param.@$class_des_param?>" class="home-link">ຄະນະກໍາມະການຄຸມຫ້ອງເສັງ</a>
    <i class="fas fa-chevron-right"></i> ເລືອກຜູ້ຄຸມຫ້ອງເສັງ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      $user_id = @$user_data['id'];
      $member_data = get_tc_data($class_id,$filter);
      $menbers = $member_data->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ເລືອກຜູ້ຄຸມຫ້ອງເສັງ</h4>
            <div class="top-content">
              <form action="" method="POST" class="top-act">
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
                <input class="txt-search phetsarath f12" id="txt-search" type="text" name="txt_search" placeholder="Search" value="<?=$search_text?>">
                <input type="submit" class="btn-search btn btn-secondary phetsarath" value="ຄົ້ນຫາ" name="search">
              </form>
            <div class="paginate">
                <?php           
                $current_page = 1;
                $row_num = $member_data->rowCount();
                include_once 'paginate.php';
                ?>
            </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-id" width="60">
                        <div class="chb-check-all center">
                        &nbsp;<input onClick="toggle(this)" class="form-check-input" type="checkbox" value="" id="check-all">
                        </div>
                    </th>
                    <th class="phetsarath">ນັກສອບເສັງ</th>
                    <th class="phetsarath">ພະແນກ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $limit_start = ($current_page - 1) * $limit_row;
                  for ($i = $limit_start; $i < ($limit_start + $limit_row); $i++) {
                    if ($i == $row_num) {
                      break;
                    }
                  ?>
                    <tr>
                        <td class="col-id center">
                            &nbsp;<input name="cb_member[]" class="form-check-input cb_member" type="checkbox" value="<?= $menbers[$i]['id'] ?>" id="cb<?= $menbers[$i]['id'] ?>">
                        </td>
                        <td class="phetsarath">
                            <label class="form-check-label lb-fullname" for="cb<?= $menbers[$i]['id'] ?>">
                                <?=$menbers[$i]['fullname']?>
                            </label>
                        </td>
                        <td class="phetsarath">
                            <label class="form-check-label lb-department" for="cb<?= $menbers[$i]['id'] ?>">
                                <?=($menbers[$i]['dep_name']).(($menbers[$i]['unit_des']==null)?'':'->ຝ່າຍ'.$menbers[$i]['unit_des'])?>
                            </label>
                        </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>

            </div>
            <div class="submit-btn">
                <button onclick="save()" type="submit" name="save_ans_choice" class="btn btn-primary btn-icon-text phetsarath none-outline none-select">
                        ບັນທຶກ
                  <i class="fas fa-save btn-icon-append"></i>                                                                             
                </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function cb_depart_changed(value){
    if(value == 0){
      window.location.href = "template?page=classroom&sub_page=select_tc<?= $class_id_param.$class_des_param?>";
    }else{
      window.location.href = "template?page=classroom&sub_page=select_tc<?= $class_id_param.$class_des_param?>&dep_id="+value;
    }
  }
  function cb_unit_changed(value){
    var data = value.split(',');
    console.log(data);
    if(data[0]==0){
      if(<?=$dep_id?>==0){
        window.location.href = "template?page=classroom&sub_page=select_tc<?= $class_id_param.$class_des_param?>";
      }else{
        window.location.href = "template?page=classroom&sub_page=select_tc<?= $class_id_param.$class_des_param?>&dep_id="+'<?=$dep_id?>';
      }
    }else{
      window.location.href = "template?page=classroom&sub_page=select_tc<?= $class_id_param.$class_des_param?>&dep_id="+data[0]+"&unit_id="+data[1];
    }
  }
    function toggle(source){
        var chb = document.getElementsByName('cb_member[]');
        for(let i=0; i < chb.length; i++){
            chb[i].checked = source.checked;
        }
    }
    function save(){
        var member = document.getElementsByName('cb_member[]');
        var tc_checked = [];
        member.forEach(_member=>{
            if(_member.checked){
                tc_checked.push(_member.value);
            }
        });
        if(tc_checked.length == 0){
            Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາເລືອກຜູ້ຄຸມຫ້ອງເສັງ!</span>'});
        }else{
            var param = {
                class_id:'<?=$class_id?>',
                class_des:'<?=$class_des?>',
                selected_tc:tc_checked
            };
            var http = new XMLHttpRequest();
            http.open("POST", 'controller/class_tc_controller.php', true);
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    eval(this.responseText);
                }
            }
            var _param = JSON.stringify(param);
            http.send("submit_tc=" + _param);
            }
    }
</script>
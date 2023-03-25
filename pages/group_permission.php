<?php
  require_once "controller/group_permission_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i><a href="template?page=user_group" class="home-link">ກຸ່ມຜູ້ໃຊ້ງານລະບົບ</a> <i class="fas fa-chevron-right"></i> ສິດການໃຊ້ງານລະບົບ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <?php
                $user_group_id = isset($_GET['user_group_id'])?$_GET['user_group_id']:0;
                $permission_data = json_decode(get_permission($user_group_id));
            ?>
            <h4 class="card-title phetsarath">ສິດການໃຊ້ງານລະບົບ <?='('.$permission_data->user_group_des.')'?></h4>
            <div class="permission-body">

              <div class="accordion" id="accordionPermission">
                <?php
                  foreach($permission_data->permission as $permission){
                ?>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="heading<?=$permission->module_group_id?>">
                    <button class="accordion-button collapsed phetsarath none-select none-outline" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$permission->module_group_id?>" aria-expanded="true" aria-controls="collapse<?=$permission->module_group_id?>">
                      <?=$permission->module_group_des?>
                    </button>
                  </h2>
                  <div id="collapse<?=$permission->module_group_id?>" class="accordion-collapse collapse" aria-labelledby="heading<?=$permission->module_group_id?>" data-bs-parent="#accordionPermission">
                    <div class="accordion-body">
                      <?php
                        foreach($permission->module as $module){
                      ?>
                          <div class="checkbox">
                            <label class="phetsarath">
                              <input id="check<?=$permission->module_group_id?>" name="check<?=$permission->module_group_id?>" type="checkbox" class="check<?=$permission->module_group_id?>" value="<?=$module->module_id?>" <?=($module->allow==1)?'checked':''?>> <?=$module->module_des?>
                            </label>
                          </div>
                      <?php
                        }
                      ?>
                      <div class="action-btn">
                        <button type="button" class="btn btn-primary phetsarath">
                          <label class="phetsarath" style="margin: 0px;">
                            <input type="checkbox" hidden onchange="checkAll('check<?=$permission->module_group_id?>',this)"> ເລືອກທັງໝົດ
                          </label>
                        </button>
                        <button onclick="set_permission('<?=$permission->module_group_id?>')" type="button" class="btn btn-success phetsarath">ບັນທຶກ</button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function checkAll(name,cb){
    var _prop = '';
    if(cb.checked)
    _prop = 'checked';
    $("."+name).prop('checked',_prop);
  }
  function set_permission(module_group_id){
    var name = "check"+module_group_id;
    var chb = $("."+name);
    var permission_data = {
      "user_group_id":"<?=$user_group_id?>",
      "module_group_id":module_group_id,
      "module":[]
    };
    for(let module of chb){
      if(module.checked){
        permission_data.module.push(module.value);
      }
    }
    // if(permission_data.module.length!=0){
      var is_success = false;
      Swal.fire( {
          html: '<h2 class="phetsarath">ກະລຸນາລໍຖ້າ !</h2><h4 class="phetsarath">ກໍາລັງໂຫຼດຂໍ້ມູນ</h4>',
          timer: 300,
          allowOutsideClick: false,
          didOpen: () => {
              Swal.showLoading()
          }
      }).then( () => {
        if(is_success){
          Swal.fire('<span class=phetsarath>ບັນທຶກສໍາເລັດ!</span>', '', 'success');
        }else{
          Swal.fire('<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>', '', 'error');
        }
      });
      Swal.stopTimer();
      var http = new XMLHttpRequest();
      http.open( "POST", 'controller/group_permission_controller.php', true );
      http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
      http.onreadystatechange = function () {
        if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
          if(this.responseText){
            is_success = true;
          }
          Swal.resumeTimer();
        }else{
          Swal.resumeTimer();
        }
      }
      var param = JSON.stringify(permission_data);
      http.send( "set_permission=" + param );
    // }
  }
</script>
<?php
  require_once "controller/personal_info_controller.php";
  $user_id = $user_data['id'];
  $personal_data = get_personal_info($user_id)->fetch(PDO::FETCH_ASSOC);
?>
<div class="modal fade" id="personal_info" tabindex="-1" role="dialog" aria-labelledby="personal_info">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color);
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title phetsarath">ຂໍ້ມູນສ່ວນຕົວ</h4>
                <button id="close_btn" type="button" class="close none-outline" data-bs-dismiss="modal" aria-label="Close" style="padding: 0px; margin: 0px -10px 0px 0px;"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body" style="display: block;">
                    <div class="center">
                        <img src="assets/svg/user.svg" alt="profile" width="100"/>
                    </div>
                    <div class="name phetsarath center"><?=$personal_data['fullname']?></div>
                    <div class="usercode phetsarath center">ລະຫັດພະນັກງານ: <?=$personal_data['user_code']?></div>
                    <div class="dep phetsarath center">ພະແນກ: <?=$personal_data['dep_name'].'-'.$personal_data['unit_des']?></div>
                    <div class="btn-password-change center" id="pwd-btn">
                        <button onclick="toggle()" type="button" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                            ປ່ຽນລະຫັດຜ່ານ
                            <i class="fas fa-solid fa-key btn-icon-append"></i>                                                                          
                        </button>
                    </div>
                    <div class="password-frame">
                        <div class="change-password-form" id="pwd-form">
                                <input type="password" class="form-control phetsarath center none-select none-outline mb-1" id="old_pwd" name="old_pwd" placeholder="ລະຫັດຜ່ານເກົ່າ" required>
                                <input type="password" class="form-control phetsarath center none-select none-outline mb-1" id="new_pwd" name="new_pwd" placeholder="ລະຫັດຜ່ານໃໝ່" required>
                            <div class="form-btn center">
                                <button onclick="change_password('<?=$user_id?>')" type="button" name="update_personal_info" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                                    ບັນທຶກ
                                    <i class="fas fa-save btn-icon-append"></i>                                                                             
                                </button>
                                <button onclick="toggle()" type="button" class="cus-btn btn btn-warning btn-icon-text phetsarath none-outline none-select">
                                    ຍົກເລີກ
                                    <i class="fas fa-times btn-icon-append"></i>                                                                            
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
               
                <!-- <div class="modal-footer" style="justify-content:center;">
                    <button type="submit" name="update_personal_info" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                        ບັນທຶກ
                        <i class="fas fa-save btn-icon-append"></i>                                                                             
                    </button>
                    <button type="button" class="cus-btn btn btn-warning btn-icon-text phetsarath none-outline none-select" data-bs-dismiss="modal">
                        ຍົກເລີກ
                        <i class="fas fa-times btn-icon-append"></i>                                                                            
                    </button>
                </div> -->
            </form>
        </div>
    </div>
</div>
<script src="assets/js/jquery-1.9.1.min.js"></script>
<script src="assets/js/custom_js/personal_info.js"></script>
<script>
    var show_frame = false;
    document.getElementById('pwd-form').hidden = true;
    $(document).ready(function(){ 
        $('#personal_info').modal({
            backdrop:'static'
        });
    });
</script>
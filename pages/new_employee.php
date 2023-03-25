<?php
require_once "controller/employee_controller.php";
$dep_id = isset($_GET['dep_id']) ? $_GET['dep_id'] : 0;
$unit_id = isset($_GET['unit_id']) ? $_GET['unit_id'] : 0;
$dep_id_param = isset($_GET['dep_id']) ? "&dep_id=" . $_GET['dep_id'] : "";
$url_param = (isset($_GET['dep_id']) ? "&dep_id=" . $_GET['dep_id'] : "").(isset($_GET['unit_id']) ? "&unit_id=" . $_GET['unit_id'] : "");
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<link rel="stylesheet" href="assets/css/new_employee_style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath">
      <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a>
      <i class="fas fa-chevron-right"></i>
      <a href="template?page=employee<?= $url_param ?>" class="home-link">ຂໍ້ມູນພະນັກງານ</a>
      <i class="fas fa-chevron-right"></i>
      ເພີ່ມຂໍ້ມູນພະນັກງານ
    </h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
    $user_id = @$user_data['id'];
    ?>
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ເພີ່ມຂໍ້ມູນພະນັກງານ</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-form-label phetsarath f12">ລະຫັດພະນັກງານ*</label>
                  <div class="col-sm-12">
                    <input id="user_code" type="text" class="inp form-control phetsarath f12" onInput="edValueKeyPress()" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-form-label phetsarath f12">ຊື່ ແລະ ນາມສະກຸນ*</label>
                  <div class="col-sm-12">
                    <input id="fullname" type="text" class="inp form-control phetsarath f12" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ເພດ</label>
                  <div class="col-sm-9">
                    <select id="gender" class="inp form-control phetsarath f12">
                      <option value="male">ຊາຍ</option>
                      <option value="female">ຍິງ</option>
                      <option value="other">ອື່ນໆ</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ວັນເດືອນປີເກີດ</label>
                  <div class="col-sm-9">
                    <label class="lb">
                      <input type="date" id="date_of_birth" name="date_of_birth" onchange="date_changed(this.value)">
                      <button class="btn-calendar" id="calendar_text">
                        <div id="date-of-birth-lb" class="phetsarath f12">ວັນເດືອນປີເກີດ</div>
                        <div class="calender-ico"><img src="assets/svg/calendar.svg" width="20"></div>
                      </button>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ຂຶ້ນກັບຝ່າຍ</label>
                  <div class="col-sm-9">
                    <select onchange="dep_selected()" id="dep" class="inp form-control phetsarath f12">
                      <?php
                      $departments = load_department()->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($departments as $depart) {
                      ?>
                        <option value='<?= $depart['dep_id'] ?>' <?= ($dep_id == $depart['dep_id']) ? 'selected' : '' ?>><?= $depart['dep_name'] ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ພະແນກ</label>
                  <div class="col-sm-9">
                    <select id="unit" class="inp form-control phetsarath f12">
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ວິຊາສະເພາະ*</label>
                  <div class="col-sm-9">
                    <input id="tech_knowledge" type="text" class="inp form-control inp phetsarath f12" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ລະດັບວິຊາສະເພາະ*</label>
                  <div class="col-sm-9">
                    <input id="degree" type="text" class="inp form-control inp phetsarath f12" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ຕໍາແໜ່ງ</label>
                  <div class="col-sm-9">
                    <select id="position" class="inp form-control phetsarath f12">
                      <?php
                      $positions = get_position()->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($positions as $position) {
                      ?>
                        <option value='<?= $position['position_id'] ?>' ><?= $position['position_des'] ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ເບີໂທ</label>
                  <div class="col-sm-9">
                    <input id="tel" type="text" class="inp form-control inp phetsarath f12" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 phetsarath f12" for="txt-address">ທີ່ຢູ່</label>
                  <div class="col-sm-9">
                    <textarea id="address" class="inp form-control phetsarath f12" id="txt-address" rows="5"></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 phetsarath f12"></label>
                  <div class="col-sm-5">
                    <div class="form-check">
                      <label class="form-check-label phetsarath f12">
                        <input onchange="rd_admin_changed(this.value)" type="radio" class="form-check-input" name="user_type" id="student" value="2" checked>
                        ນັກສອບເສັງ
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-check">
                      <label class="form-check-label phetsarath f12">
                        <input onchange="rd_admin_changed(this.value)" type="radio" class="form-check-input" name="user_type" id="admin" value="1">
                        ຜູ້ຄຸມລະບົບ
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ຊື່ເຂົ້າໃຊ້ລະບົບ*</label>
                  <div class="col-sm-9">
                    <input id="username" type="text" class="form-control phetsarath f12" />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ລະຫັດຜ່ານ*</label>
                  <div class="col-sm-9">
                    <input id="password" type="password" class="form-control" />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ຢືນຢັນລະຫັດຜ່ານ*</label>
                  <div class="col-sm-9">
                    <input id="confirm_password" type="password" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="col-md-6" id="user-group-frame">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ກຸ່ມຜູ້ໃຊ້ງານລະບົບ</label>
                  <div class="col-sm-9">
                    <select id="user_group" class="inp form-control phetsarath f12">
                      <?php
                      $user_group_data = get_user_group()->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($user_group_data as $user_group) {
                      ?>
                        <option value='<?= $user_group['user_group_id'] ?>' ><?= $user_group['group_des'] ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row submit">
              <div class="col-md-12 center">
                <button onclick="save()" type="submit" name="save_ans_choice" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                  ບັນທຶກ
                  <i class="fas fa-save btn-icon-append"></i>
                </button>
                <button onclick="window.location.href='template?page=employee<?= $url_param ?>'" type="submit" name="save_ans_choice" class="cus-btn btn btn-danger btn-icon-text phetsarath none-outline none-select">
                  ຍົກເລີກ
                  <i class="fas fa-solid fa-trash btn-icon-append"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/custom_js/new_employee.js"></script>
  <script>
  
  function edValueKeyPress() {
    var staff_id = document.getElementById("user_code");
    var s = staff_id.value;
	
    var textLogin = document.getElementById("username");
    textLogin.value = s;
	}
  
    var unit_id = <?=$unit_id?>;
    var _url_param = encode('<?=$url_param?>');
  </script>
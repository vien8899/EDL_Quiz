<?php
require_once "controller/employee_controller.php";
$dep_id = isset($_GET['dep_id']) ? $_GET['dep_id'] : 0;
$unit_id = isset($_GET['unit_id']) ? $_GET['unit_id'] : 0;
$dep_id_param = isset($_GET['dep_id']) ? "&dep_id=" . $_GET['dep_id'] : "";
$url_param = (isset($_GET['dep_id']) ? "&dep_id=" . $_GET['dep_id'] : "") . (isset($_GET['unit_id']) ? "&unit_id=" . $_GET['unit_id'] : "");
$emp_id = 0;
if (isset($_GET['emp_id'])) {
  $emp_id = $_GET['emp_id'];
} else {
?>
  <script>
    window.location.href = 'template?page=employee<?= $dep_id_param ?>?>'
  </script>
<?php
}
$user_id = @$user_data['id'];
$emp_data = get_emp_by_id($emp_id)->fetchAll(PDO::FETCH_ASSOC)[0];
$unit_id = $emp_data['unit_id'];
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
      ແກ້ໄຂຂໍ້ມູນພະນັກງານ
    </h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ແກ້ໄຂຂໍ້ມູນພະນັກງານ</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-form-label phetsarath f12">ລະຫັດພະນັກງານ*</label>
                  <div class="col-sm-12">
                    <input id="user_code" type="text" class="inp form-control phetsarath f12" value="<?= $emp_data['user_code'] ?>" onInput="edValueKeyPress()" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-form-label phetsarath f12">ຊື່ ແລະ ນາມສະກຸນ*</label>
                  <div class="col-sm-12">
                    <input id="fullname" type="text" class="inp form-control phetsarath f12" value="<?= $emp_data['fullname'] ?>" />
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
                      <option value="male" <?= ($emp_data['gender'] == 'male') ? "selected" : '' ?>>ຊາຍ</option>
                      <option value="female" <?= ($emp_data['gender'] == 'female') ? "selected" : '' ?>>ຍິງ</option>
                      <option value="other" <?= ($emp_data['gender'] == 'other') ? "selected" : '' ?>>ອື່ນໆ</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ວັນເດືອນປີເກີດ</label>
                  <div class="col-sm-9">
                    <label class="lb">
                      <input type="date" id="date_of_birth" name="date_of_birth" <?= ($emp_data['date_of_birth'] == "") ? "" : "value='" . $emp_data['date_of_birth'] . "'" ?> onchange="date_changed(this.value)">
                      <button class="btn-calendar" id="calendar_text">
                        <div id="date-of-birth-lb" class="phetsarath f12"><?= ($emp_data['date_of_birth'] == "") ? "ວັນເດືອນປີເກີດ" : date("d/m/Y", strtotime($emp_data['date_of_birth'])) ?></div>
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
                        <option value='<?= $depart['dep_id'] ?>' <?= ($emp_data['dep_id'] == $depart['dep_id']) ? 'selected' : '' ?>><?= $depart['dep_name'] ?></option>
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
                    <input id="tech_knowledge" type="text" class="inp form-control inp phetsarath f12" value="<?=$emp_data['technical_knowledge']?>"/>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ລະດັບວິຊາສະເພາະ*</label>
                  <div class="col-sm-9">
                    <input id="degree" type="text" class="inp form-control inp phetsarath f12" value="<?=$emp_data['degree']?>" />
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
                        <option value='<?= $position['position_id'] ?>' <?= ($emp_data['position_id'] == $position['position_id']) ? 'selected' : '' ?> ><?= $position['position_des'] ?></option>
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
                    <input id="tel" type="text" class="inp form-control inp phetsarath f12" value="<?=$emp_data['tel']?>"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 phetsarath f12" for="txt-address">ທີ່ຢູ່</label>
                  <div class="col-sm-9">
                    <textarea id="address" class="inp form-control phetsarath f12" id="txt-address" rows="5"><?=$emp_data['address']?></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 phetsarath f12"></label>
                  <div class="col-sm-5">
                    <div class="form-check">
                      <label class="form-check-label phetsarath f12">
                        <input onchange="rd_admin_changed(this.value)" type="radio" class="form-check-input" name="user_type" id="student" value="2" <?= ($emp_data['user_type'] == 2) ? "checked" : "" ?>>
                        ນັກສອບເສັງ
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-check">
                      <label class="form-check-label phetsarath f12">
                        <input onchange="rd_admin_changed(this.value)" type="radio" class="form-check-input" name="user_type" id="admin" value="1" <?= ($emp_data['user_type'] == 1) ? "checked" : "" ?>>
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
                    <input id="username" type="text" class="form-control phetsarath f12"  value="<?= $emp_data['username'] ?>" />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ລະຫັດຜ່ານ*</label>
                  <div class="col-sm-9">
                    <input id="password" type="password" class="form-control" value="edlquiz"/>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label phetsarath f12">ຢືນຢັນລະຫັດຜ່ານ*</label>
                  <div class="col-sm-9">
                    <input id="confirm_password" type="password" class="form-control" value="edlquiz" />
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
                        <option value='<?= $user_group['user_group_id'] ?>' <?= ($emp_data['user_group_id'] == $user_group['user_group_id']) ? 'selected' : '' ?>><?= $user_group['group_des'] ?></option>
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
  <script>
  
	function edValueKeyPress() {
		var staff_id = document.getElementById("user_code");
		var s = staff_id.value;
		
		var textLogin = document.getElementById("username");
		textLogin.value = s;
	}
	
    var unit_id = <?= $unit_id ?>;
    var _url_param = encode('<?= $url_param ?>');
    var user_type_data = '<?=$emp_data['user_type']?>';
    var _em_id = '<?=$emp_data['id']?>';
    var _old_em_data = <?=json_encode($emp_data)?>;
  </script>
  <script src="assets/js/custom_js/update_employee.js"></script>
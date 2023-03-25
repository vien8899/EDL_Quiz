<?php
date_default_timezone_set("Asia/Vientiane");
require_once "controller/quiz_overview_controller.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ຂໍ້ມູນບົດເສັງ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    <?php
      $user_id = @$user_data['id'];
      $ans_data = load_test_quiz($user_id);
      $data = $ans_data->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຂໍ້ມູນບົດເສັງ</h4>
            <div class="top-content">
              <div class="top-act">
                <!--
				<button type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath" data-toggle="modal" data-target="#adddepartment" data-backdrop="static">
                  <i class="ti-filter btn-icon-prepend"></i> Filter<span style="color: red;">*</span>
                </button>
				-->
              </div>

              <div class="paginate">
                <?php
                $current_page = 1;
                $row_num = $ans_data->rowCount();
                include_once 'paginate.php';
                ?>

              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-id phetsarath" width="60">ລະຫັດເສັງ</th>
                    <th class="phetsarath">ຫ້ອງເສັງ</th>
                    <th class="phetsarath">ຫົວຂໍ້ເສັງ</th>
                    <th class="phetsarath">ເລີ່ມຕົ້ນເສັງ</th>
                    <th class="phetsarath">ສົ່ງຂໍ້ສອບ</th>
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
                      <td class="col-id"><?=$data[$i]['test_number']?></td>
                      <td class="phetsarath"><?=$data[$i]['class_des']?></td>
                      <td class="phetsarath"><?=$data[$i]['quiz_title']?></td>
                      <td class="phetsarath"><?=date("d-m-Y h:i a", strtotime($data[$i]['start_time']))?></td>
                      <td class="phetsarath"><?=date("d-m-Y h:i a", strtotime(($data[$i]['submit_time']==null)?$data[$i]['start_time']:$data[$i]['submit_time']))?></td>
                      <td>
                        <button onclick="window.location.href='template?page=quiz_overview&sub_page=set_score&quiz_no=<?=$data[$i]['test_number']?>'" type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline" >
                          <i class="ti-cup menu-icon"></i>
                        </button>
                      </td>
                    </tr>
                     <?php 
                    } 
                    ?>
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
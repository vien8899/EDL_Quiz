<?php
date_default_timezone_set("Asia/Vientiane");
require_once "controller/report_controller.php";
$has_filter = false;
$exam_date = '';
if(isset($_POST['apply_filter'])){
  $report_filter['class_id']=$_POST['class'];
  $report_filter["quiz_id"] = $_POST['quiz'];
  $report_filter["exam_date"] = $_POST['exam_date_param'];
  $report_filter["remark"] = $_POST['remark'];
  $_SESSION['report_filter']=$report_filter;
}

if(isset($_SESSION['report_filter'])){
  $report_filter = $_SESSION['report_filter'];
  if($report_filter['class_id']==0 && $report_filter["quiz_id"]==0 && $report_filter["exam_date"]=='' && $report_filter["remark"]==''){
    $has_filter = false;
  }else{
    $has_filter = true;
    if($report_filter["exam_date"]!=''){
      $exam_date = date("d/m/Y", strtotime($report_filter['exam_date']));
    }
  }
}

$filter_data = $has_filter?$_SESSION['report_filter']:[];
// print_r($filter_data);
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<style>
  td{
    line-height: 2 !important;
  }
  .fixed_header{
    table-layout: fixed;
    border-collapse: collapse;
  }
  thead{
    border-bottom: 2px solid var(--main-color);
  }
  .fixed_header tbody{
    display:block;
    overflow-y:auto;
    max-height: 65vh;
    width: fit-content !important;
  }
  .fixed_header thead tr{
    display:block;
  }
  .col-check{
    width: 60px;
  }
  .col-name{
    width: 200px;
  }
  .col-title{
    width: fit-content;
    min-width: 100px;
  }
  .col-score{
    width: 100px;
  }
  .table>:not(:first-child) {
    border-top: none !important;
  }
</style>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ຜົນການສອບເສັງ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
    
    <?php
      $quiz_data = load_score_report($filter_data);
      // print_r($quiz_data);
      $data = $quiz_data->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຜົນການສອບເສັງ</h4>
            <div class="top-content">
              <div class="top-act">
                <button type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath" data-toggle="modal" data-target="#report_filter" data-backdrop="static">
                  <i class="ti-filter btn-icon-prepend"></i> Filter<span style="color: red;"><?=$has_filter?'*':''?></span>
                </button>
                <?php if($permission['print_exam_report']){?>
                <button type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath" data-toggle="modal" data-target="#param" data-backdrop="static">
                  <i class="fas fa-solid fa-print btn-icon-prepend"></i>Print Result
                </button>
				
				<button type="button" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath" data-toggle="modal" data-target="#param_exp" data-backdrop="static">
                  <i class="fas fa-file-excel btn-icon-prepend"></i>Export to Excel
                </button>
                <?php } ?>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table fixed_header">
                <thead>
                  <tr>
                    <th class="col-check">
                        <div class="chb-check-all center">
                        &nbsp;<input onClick="toggle(this)" type="checkbox" value="" id="check-all">
                        </div>
                    </th>
                    <th class="phetsarath col-name">ນັກສອບເສັງ</th>
                    <th class="phetsarath center col-title" id="col-title">ຫົວຂໍ້ເສັງ</th>
                    <th class="phetsarath center col-score" >ຄະແນນ</th>
                    <th class="phetsarath" >ວັນທີເສັງ</th>
                    <th ></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $index = 0;
                  foreach($data as $item){
                  ?>
                    <tr>
                      <td class="col-check center">
                            &nbsp;<input name="cb_student[]" class="cb_member" type="checkbox" value="<?= $index ?>" id="cb<?= $item['test_id'] ?>">
                      </td>
                      <td class="phetsarath col-name">
                        <label for="cb<?= $item['test_id'] ?>" class="phetsarath"><?=$item['fullname']?></label>
                      </td>
                      <td class="phetsarath center col-title" id="col-b-title"><?=$item['quiz_title']?> <?=($item['remark']=="")?"":"(".$item['remark'].")"?></td>
                      <td class="phetsarath center col-score"><?=$item['point']?>/<?=$item['full_point']?></td>
                      <td class="phetsarath"><?=date("d-m-Y", strtotime($item['start_time']))?></td>
                      <td>
                        <?php if($permission['view_answer']){ ?>
                        <button onclick="window.location.href = 'template?page=score_report&sub_page=exam_preview&test_id=<?=$item['test_id']?>'" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline" >
                            <i class="fas fa-eye"></i>
                        </button>
                        <?php } ?>
                      </td>
                    </tr>
                     <?php 
                      $index ++;
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
<?php
include_once("modals/report_filter_modal.php");
include_once("modals/print_param_modal.php");
include_once("modals/print_param_exp_modal.php");

?>
<script src="assets/js/custom_js/report_filter.js"></script>
<script src="assets/js/custom_js/score_report.js"></script>
<script src="assets/js/custom_js/score_report_exp.js"></script>
<script>
  var data = JSON.parse('<?=json_encode($data)?>');
  var exam_date = '<?=$exam_date?>';
  function toggle(source){
    var chb = document.getElementsByName('cb_student[]');
    for(let i=0; i < chb.length; i++){
      chb[i].checked = source.checked;
    }
  }
  $( document ).ready(function() {
    if(data.length!=0){
      var col_title = document.getElementById('col-title');
      var col_b_title = document.getElementById('col-b-title');
      col_title.style.width = col_b_title.offsetWidth;
    }
  });
</script>

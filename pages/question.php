<?php
  require_once "controller/question_controller.php";
  require_once "controller/app_module.php";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<!-- <script src="assets/js/jquery-1.9.1.min.js"></script> -->
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> ຄໍາຖາມສອບເສັງ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
  <?php
      $subj_id = 0;
      if(isset($_GET['subj_id'])){
        $subj_id = $_GET['subj_id'];
      }
      $user_id = @$user_data['id'];
      if(isset($_POST['del_question'])){
        del_question($_POST['id']);
      }
      $question_data = load_data($subj_id,$user_id,$permission['view_all_question']);
      $data = $question_data->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ຂໍ້ມູນຄໍາຖາມສອບເສັງ</h4>
            <div class="top-content">
              <div class="top-act">
                <button type="button" onclick="window.location.href='template?page=question&sub_page=new_question<?=($subj_id==0)?'':'&subj_id='.$subj_id?>'" class="btn-newclass btn btn-primary btn-icon-text none-select none-outline phetsarath">
                  <i class="ti-plus btn-icon-prepend"></i> ເພີ່ມໃໝ່
                </button>
                <select onchange="cb_subject_changed(this.value)" class="form-select phetsarath" aria-label="Default select">
                    <option value="0" <?=($subj_id==0)?"selected":""?> >---ສະແດງທັງໝົດ---</option>
                    <?php
                      $subjects = load_subject()->fetchAll(PDO::FETCH_ASSOC);
                      foreach($subjects as $subject){
                        ?>
                          <option value='<?=$subject['subj_id']?>' <?=($subj_id==$subject['subj_id'])?"selected":""?> ><?=$subject['subj_name']?></option>
                        <?php
                      }
                    ?>
                </select>
              </div>

              <div class="paginate">
                <?php
                $current_page = 1;
                $row_num = $question_data->rowCount();
                include_once 'paginate.php';
                ?>

              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-id phetsarath" width="60">ລະຫັດ</th>
                    <th class="phetsarath">ຄໍາຖາມ</th>
                    <th class="phetsarath">ວິຊາ</th>
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
                      <td class="col-id"><?=$data[$i]['question_id']?></td>
                      <td class="phetsarath">
                        <?php
                          $des = strip_tags(htmlspecialchars_decode($data[$i]['title'],ENT_QUOTES));
                          if (strlen($des) > 100){
                            $des = substr($des, 0, 97) . '...';
                            echo $des;
                          }else{
                            echo $des;
                          }
                            
                        ?>
                      </td>
                      <td class="phetsarath">
                        <?=$data[$i]['subj_name']?>
                      </td>
                      <td>
                        <button onclick="window.location.href='template?page=question&sub_page=update_question<?=($subj_id==0)?'':'&subj_id='.$subj_id?>&question_id=<?=$data[$i]['question_id']?>'" type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline">
                          <i class="fas fa-pencil-alt"></i>
                        </button>
                        <!-- <button  onclick="view_question('<?=encode($data[$i]['question'])?>','<?=encode($data[$i]['ans_choice'])?>','<?=encode($data[$i]['subj_name'])?>',<?=encode($data[$i]['question_type'])?>)" 
                        type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline">
                          <i class="fas fa-eye"></i>
                        </button> -->
                        <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" data-id="<?=$data[$i]['question_id']?>" data-bs-toggle="modal" data-bs-target="#confirm_dialog" data-bs-backdrop="static">
                          <i class="fas fa-trash-alt"></i>
                        </button>                       
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
?>

<script>
  var confirm_dialog = document.getElementById('confirm_dialog');
  confirm_dialog.addEventListener('show.bs.modal',function(event){
    var class_data = $(event.relatedTarget);
    var class_id = class_data.data('id');
    var modal = $(this);
    modal.find('.modal-body #id').val(class_id);
    document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການລຶບຂໍ້ມູນແມ່ນບໍ່";
    document.getElementById('btn_yes').setAttribute("name","del_question");
  });
  function view_question(_question,_ans_choice,_subj_name,_question_type){
    var param = {
      question:_question,
      ans_choice:_ans_choice,
      subj_name:_subj_name,
      question_type:_question_type
    };
    var http = new XMLHttpRequest();
    http.open("POST", 'modals/question_view_modal.php', true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
				if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
          // console.log(this.responseText);
          Swal.fire({html:this.responseText})
				}
		}
    var _param = JSON.stringify(param);
    http.send("question_data=" + _param);
  }
  function cb_subject_changed(value){
    if(value == 0){
      window.location.href = "template?page=question";
    }else{
      window.location.href = "template?page=question&subj_id="+value;
    }
  }
</script>
<?php
    // require_once "controller/subject_controller.php";
    require_once "controller/question_controller.php";
    include_once("controller/app_module.php");
    $subj_id = isset($_GET['subj_id'])?$_GET['subj_id']:0;
    $subj_id_param = isset($_GET['subj_id'])?"&subj_id=".$_GET['subj_id']:"";
    $question_id = 0;
    if(isset($_GET['question_id'])){
        $question_id = $_GET['question_id'];
    }else{
        ?>
            <script>window.location.href = 'template?page=question<?=$subj_id_param?>'</script>
        <?php
    }
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<link rel="stylesheet" href="assets/css/new-question-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<script src="module/ckeditor/ckeditor.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> <a href="template?page=question<?=$subj_id_param?>" class="home-link">ຄໍາຖາມສອບເສັງ</a> <i class="fas fa-chevron-right"></i> ແກ້ໄຂຄໍາຖາມ</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
  <?php
      $user_id = @$user_data['id'];
      $question_data = load_question($question_id)->fetchAll(PDO::FETCH_ASSOC)[0];
      $ans_choice = [];
      if($question_data['question_type']==0){
        $ans_choice = json_decode($question_data['ans_choice']);
      }
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ແກ້ໄຂຄໍາຖາມ</h4>
            <div class="top-content">
                <div class="question-type">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" name="question_type" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" <?=($question_data['question_type']==0)?"checked":""?> >
                        <label onclick="is_ans_choice(true)" class="rd btn btn-outline-primary first none-select none-outline" for="btnradio1">
                            <i class="ti-check-box"></i>
                            <i class="ti-control-stop"></i>
                            <i class="ti-layout-width-full"></i>
                        </label>
                        <input type="radio" name="question_type" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" <?=($question_data['question_type']==1)?"checked":""?>>
                        <label onclick="is_ans_choice(false)" class="rd btn btn-outline-primary none-select none-outline" for="btnradio2">
                            ........
                            <i class="ti-themify-favicon-alt"></i></label>
                    </div>
                </div>
                <div class="subjection-selection">
                    <div class="subj-label phetsarath">
                        ເລືອກວິຊາເສັງ
                    </div>
                    <?php
                        $subjects = load_subject()->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <select class="form-select none-select none-outline subject phetsarath" aria-label="Default select" name="subject" id="subject">
                        <?php
                        foreach($subjects as $subject){
                          ?>
                          <option class='phetsarath' value='<?=$subject['subj_id']?>' <?=($subj_id==$subject['subj_id'])?'selected':''?> ><?=$subject['subj_name']?></option>
                          <?php
                        }
                    ?>
                    </select>
                </div>
            </div>
            
            <div class="question" id="question">
              <label for="txt_question" class="phetsarath">ຄໍາຖາມສອບເສັງ</label>
              <textarea name="txt_question" id="txt_question" class="phetsarath txt_question" rows="10"><?=$question_data['question']?></textarea>
            </div>
            <!-- ປາລາໄນ -->
            <div class="div-ans-choice" id="div-ans-choice" <?=($question_data['question_type']==1)?"hidden":""?>>
              <div class="ans-choice" id="ans-choice">
                <div class="choice-item">
                  <div class="choice-caption phetsarath">ຄໍາຕອບທີ 1</div>
                  <textarea name="txt_choice1" id="txt_choice1" class="phetsarath"><?=($question_data['question_type']==0)?$ans_choice[0]:""?></textarea>
                </div>
                <div class="choice-item">
                  <div class="choice-caption phetsarath">ຄໍາຕອບທີ 2</div>
                  <textarea name="txt_choice2" id="txt_choice2" class="phetsarath"><?=($question_data['question_type']==0)?$ans_choice[1]:""?></textarea>
                </div>
                <div class="choice-item">
                  <div class="choice-caption phetsarath">ຄໍາຕອບທີ 3</div>
                  <textarea name="txt_choice3" id="txt_choice3" class="phetsarath"><?=($question_data['question_type']==0)?$ans_choice[2]:""?></textarea>
                </div>
                <div class="choice-item">
                  <div class="choice-caption phetsarath">ຄໍາຕອບທີ 4</div>
                  <textarea name="txt_choice4" id="txt_choice4" class="phetsarath"><?=($question_data['question_type']==0)?$ans_choice[3]:""?></textarea>
                </div>
              </div>
              <div class="correct-ans">
                <label for="correct_ans" class="phetsarath">ຄໍາຕອບທີ່ຖືກຕ້ອງ</label>
                <select class="form-select none-select none-outline subject phetsarath" aria-label="Default select" name="correct_ans" id="correct_ans">
                    <?php
                        $correct_ans = ($question_data['question_type']==0)?$question_data['correct_ans']:'';
                    ?>
                  <option class='phetsarath' value='0' <?=($correct_ans==0)?"selected":""?>>ຄໍາຕອບທີ 1</option>
                  <option class='phetsarath' value='1' <?=($correct_ans==1)?"selected":""?>>ຄໍາຕອບທີ 2</option>
                  <option class='phetsarath' value='2' <?=($correct_ans==2)?"selected":""?>>ຄໍາຕອບທີ 3</option>
                  <option class='phetsarath' value='3' <?=($correct_ans==3)?"selected":""?>>ຄໍາຕອບທີ 4</option>
                </select>
              </div>
              <div class="submit-btn">
                <button onclick="save_ans_choice()" type="submit" name="save_ans_choice" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                        ບັນທຶກ
                  <i class="fas fa-save btn-icon-append"></i>                                                                             
                </button>
              </div>
            </div>
            <!-- ອັດຕະໄນ -->
            <div class="div-ans" id="div-ans" <?=($question_data['question_type']==0)?"hidden":""?> >
              <div class="correct_ans">
                <div class="choice-caption phetsarath">ຄໍາຕອບທີຖືກຕ້ອງ</div>
                <input id="txt_correct_ans" type="number" name="txt_correct_ans" class="txt-correct-ans" value="<?=($question_data['question_type']==1)?$question_data['correct_ans']:''?>">
              </div>
              <div class="submit-btn">
                <button onclick="save_ans()" type="submit" name="save_ans" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
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
</div>

<script>
  var div_ans = document.getElementById('div-ans');
  var div_ans_choice = document.getElementById('div-ans-choice');
  function is_ans_choice(val){
    div_ans.hidden = val;
    div_ans_choice.hidden = !val;
  }
	CKEDITOR.replace( 'txt_question',{
        height: 200,
        language: 'en'
    });
  CKEDITOR.disableAutoInline = true;
  CKEDITOR.inline('txt_choice1');
  CKEDITOR.inline('txt_choice2');
  CKEDITOR.inline('txt_choice3');
  CKEDITOR.inline('txt_choice4');
  function save_ans_choice(){
    var _question = encode(CKEDITOR.instances.txt_question.getData());
    // console.log(_question);
    var param = {
        question_id:'<?=$question_id?>',
        question:CKEDITOR.instances.txt_question.getData(),
        ans1:CKEDITOR.instances.txt_choice1.getData(),
        ans2:CKEDITOR.instances.txt_choice2.getData(),
        ans3:CKEDITOR.instances.txt_choice3.getData(),
        ans4:CKEDITOR.instances.txt_choice4.getData(),
        correct_ans:$('select#correct_ans').val(),
        subj_id:$('select#subject').val(),
        user_id:'<?=$user_id?>',
        subj_id_param:'<?=$subj_id_param?>'
    };
    // console.log(encode(JSON.stringify(param)));
    var http = new XMLHttpRequest();
    http.open("POST", 'controller/question_controller.php', true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
				if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
          // console.log(this.responseText);
          eval(this.responseText);
				}
		}
    var _param = encode(JSON.stringify(param));
    http.send("update_question_choice=" + _param);
  }
  function save_ans(){
    var txt_ans = document.getElementById('txt_correct_ans');
    if(CKEDITOR.instances.txt_question.getData()=="" || txt_ans.value == ""){
      Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບຖ້ວນ!</span>'});
    }else{
        var param = {
            question_id:'<?=$question_id?>',
            question: CKEDITOR.instances.txt_question.getData(),
            correct_ans:txt_ans.value,
            subj_id:$('select#subject').val(),
            user_id:'<?=$user_id?>',
            subj_id_param:'<?=$subj_id_param?>'
        }
        // console.log(encode(JSON.stringify(param)));
        var http = new XMLHttpRequest();
        http.open("POST", 'controller/question_controller.php', true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                // console.log(this.responseText);
                eval(this.responseText);
            }
      }
      var _param = encode(JSON.stringify(param));
      http.send("update_question=" + _param);
    }
  }
  // CKEDITOR.replace( 'txt_choice1',{
  //       height: 60,
  //       language: 'en'
  // });
  // CKEDITOR.replace( 'txt_choice2',{
  //       height: 60,
  //       language: 'en'
  // });
  // CKEDITOR.replace( 'txt_choice3',{
  //       height: 60,
  //       language: 'en'
  // });
  // CKEDITOR.replace( 'txt_choice4',{
  //       height: 60,
  //       language: 'en'
  // });
//   var edit_class = document.getElementById('editclass')
//   edit_class.addEventListener('show.bs.modal', function(event) {
//     var class_data = $(event.relatedTarget);
//     var class_id = class_data.data('id');
//     var class_des = class_data.data('class_des');
//     var modal = $(this);
//     modal.find('.modal-body #class_id').val(class_id);
//     modal.find('.modal-body #class_des').val(class_des);
//   });
//   var confirm_dialog = document.getElementById('confirm_dialog');
//   confirm_dialog.addEventListener('show.bs.modal',function(event){
//     var class_data = $(event.relatedTarget);
//     var class_id = class_data.data('id');
//     var modal = $(this);
//     modal.find('.modal-body #id').val(class_id);
//     document.getElementById('title').innerHTML = "ທ່ານຕ້ອງການລຶບຂໍ້ມູນແມ່ນບໍ່";
//     document.getElementById('btn_yes').setAttribute("name","del_class");
//   });
</script>
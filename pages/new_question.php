<?php
    require_once "controller/subject_controller.php";
    include_once("controller/app_module.php");
    $subj_id = isset($_GET['subj_id'])?$_GET['subj_id']:0;
    $subj_id_param = isset($_GET['subj_id'])?"&subj_id=".$_GET['subj_id']:"";
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<link rel="stylesheet" href="assets/css/new-question-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<script src="module/ckeditor/ckeditor.js"></script>
<div class="header-page">
  <div class="page-title">
    <h5 class="phetsarath"><a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a> <i class="fas fa-chevron-right"></i> <a href="template?page=question<?=$subj_id_param?>" class="home-link">ຄໍາຖາມສອບເສັງ</a> <i class="fas fa-chevron-right"></i> ເພີ່ມຄໍາຖາມໃໝ່</h5>
  </div>
</div>
<div class="page-wrapper">
  <div class="content-wrapper">
  <?php
      $user_id = @$user_data['id'];
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ເພີ່ມຄໍາຖາມໃໝ່</h4>
            <div class="top-content content-new-ques">
                <div class="question-type">
                  <div class="question-type-label phetsarath">
                    ເລືອກປະເພດຄໍາຖາມ
                  </div>
                  <select onchange="type_selected(this.value)" class="form-select none-select none-outline ques-type phetsarath" name="question_type" id="question_type">
                    <option value="0">ປາລາໄນ</option>
                    <option value="1">ປາລາໄນ (ມີຫຼາຍຄໍາຕອບ)</option>
                    <option value="2">ອັດຕະໄນ</option>
                  </select>
                    <!-- <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" name="question_type" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                        <label onclick="is_ans_choice(true)" class="rd btn btn-outline-primary first none-select none-outline" for="btnradio1">
                            <i class="ti-check-box"></i>
                            <i class="ti-control-stop"></i>
                            <i class="ti-layout-width-full"></i>
                        </label>
                        <input type="radio" name="question_type" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                        <label onclick="is_ans_choice(false)" class="rd btn btn-outline-primary none-select none-outline" for="btnradio2">
                            ........
                            <i class="ti-themify-favicon-alt"></i></label>
                    </div> -->
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
                <div class="full-point">
                  <div class="full-point-lable phetsarath">ຄະແນນ</div>
                  <input id="full_score" class="txt-score phetsarath" type="number" value="1" min="1">
                </div>
            </div>
            <div class="question-title">
              <label for="txt_question_title" class="phetsarath">ຫົວຂໍ້ຄໍາຖາມສອບເສັງ*</label>
              <textarea name="txt_question_title" id="txt_question_title" class="phetsarath txt_question_title" rows="3"></textarea>
            </div>
            <div class="question" id="question">
              <label for="txt_question" class="phetsarath">ຄໍາຖາມສອບເສັງ</label>
              <textarea name="txt_question" id="txt_question" class="phetsarath txt_question" rows="10"></textarea>
            </div>
            <!-- question type 0 -->
            <div class="div-ans-choice" id="ques-0">
              <div class="ans-choice" id="ans-ques-0">
                <div class="choice-item">
                  <div>
                    <div class="choice-caption phetsarath">ຄໍາຕອບທີ 1*</div>
                    <textarea name="txt_choice" id="txt_choice1" class="phetsarath"></textarea>
                  </div>
                </div>
                <div class="choice-item">
                  <div>
                    <div class="choice-caption phetsarath">ຄໍາຕອບທີ 2*</div>
                    <textarea name="txt_choice" id="txt_choice2" class="phetsarath"></textarea>
                  </div>
                </div>
              </div>
              <div class="add-ans">
                <button onclick="add_ans_q_0()" type="button" class="btn-add-ans btn btn-secondary"><i class="fas fa-solid fa-plus"></i></button>
              </div>
              <div class="correct-ans">
                <label for="correct_ans" class="phetsarath">ຄໍາຕອບທີ່ຖືກຕ້ອງ</label>
                <select class="form-select none-select none-outline subject phetsarath" aria-label="Default select" name="correct_ans" id="correct_ans">
                  <option class='phetsarath' value='0'>ຄໍາຕອບທີ 1</option>
                  <option class='phetsarath' value='1'>ຄໍາຕອບທີ 2</option>
                </select>
              </div>
              <div class="submit-btn">
                <button onclick="save_question(0,'<?=$user_id?>','<?=$subj_id_param?>')" type="submit" name="save_ans_choice" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                        ບັນທຶກ
                  <i class="fas fa-save btn-icon-append"></i>                                                                             
                </button>
              </div>
            </div>
            <!-- question type 1 -->
            <div class="div-ans-choice" id="ques-1">
              <div class="ans-choice" id="ans-ques-1">
                <div class="choice-item">
                  <div>
                    <div class="choice-caption phetsarath">ຄໍາຕອບທີ 1*</div>
                    <textarea name="txt_multi_choice" id="txt_multi_choice1" class="phetsarath"></textarea>
                  </div>
                  <div>
                    <input value="0" type="radio" class="btn-check" name="choice1" id="choice1-true" autocomplete="off" checked>
                    <label class="btn-choice btn btn-outline-success phetsarath" for="choice1-true">ຖືກ</label>
                    <input type="radio" class="btn-check" name="choice1" id="choice1-false" autocomplete="off">
                    <label class="btn-choice btn btn-outline-danger phetsarath" for="choice1-false">ຜິດ</label>
                  </div>
                </div>
                <div class="choice-item">
                  <div>
                    <div class="choice-caption phetsarath">ຄໍາຕອບທີ 2*</div>
                    <textarea name="txt_multi_choice" id="txt_multi_choice2" class="phetsarath"></textarea>
                  </div>
                  <div>
                    <input value="1" type="radio" class="btn-check" name="choice2" id="choice2-true" autocomplete="off">
                    <label class="btn-choice btn btn-outline-success phetsarath" for="choice2-true">ຖືກ</label>
                    <input type="radio" class="btn-check" name="choice2" id="choice2-false" autocomplete="off">
                    <label class="btn-choice btn btn-outline-danger phetsarath" for="choice2-false">ຜິດ</label>
                  </div>
                </div>
              </div>
              <div class="add-ans">
                <button onclick="add_ans_q_1()" type="button" class="btn-add-ans btn btn-secondary"><i class="fas fa-solid fa-plus"></i></button>
              </div>
              <div class="submit-btn">
                <button onclick="save_question(1,'<?=$user_id?>','<?=$subj_id_param?>')" type="submit" name="save_ans_choice" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                        ບັນທຶກ
                  <i class="fas fa-save btn-icon-append"></i>                                                                             
                </button>
              </div>
            </div>
            <!-- question type 2 -->
            <div class="div-ans" id="ques-2">
              <div class="form-check">
                <input type="checkbox" value="1" name="show_question_content" id="show_question_content">
                <label class="phetsarath" for="show_question_content">
                  ສະແດງເນື້ອໃນຄໍາຖາມ
                </label>
              </div>
              <!-- <div class="correct_ans">
                <div class="choice-caption phetsarath">ຄໍາຕອບທີຖືກຕ້ອງ</div>
                <input id="txt_correct_ans" type="number" name="txt_correct_ans" class="txt-correct-ans">
              </div> -->
              <div class="submit-btn">
                <button onclick="save_question(2,'<?=$user_id?>','<?=$subj_id_param?>')" type="submit" name="save_ans" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
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
<script src="assets/js/custom_js/question.js"></script>
<script>
  var ques_0 = document.getElementById('ques-0');
  var ques_1 = document.getElementById('ques-1');
  var ques_2 = document.getElementById('ques-2');
  ques_1.hidden = true;
  ques_2.hidden = true;
  // var div_ans = document.getElementById('div-ans');
  // var div_ans_choice = document.getElementById('div-ans-choice');
  // div_ans.hidden = true;
  // function is_ans_choice(val){
  //   div_ans.hidden = val;
  //   div_ans_choice.hidden = !val;
  // }
	CKEDITOR.replace( 'txt_question',{
        height: 200,
        language: 'en'
    });
  CKEDITOR.disableAutoInline = true;
  CKEDITOR.inline('txt_choice1');
  CKEDITOR.inline('txt_choice2');
  CKEDITOR.inline('txt_multi_choice1');
  CKEDITOR.inline('txt_multi_choice2');
  CKEDITOR.inline('txt_question_title');
  // function save_ans_choice(){
  //   // var _question = encode(CKEDITOR.instances.txt_question.getData());
  //   // console.log(CKEDITOR);
  //   for(var instanceName in CKEDITOR.instances) {
  //     // console.log( CKEDITOR.instances[instanceName].element.$.name );
  //     var name = CKEDITOR.instances[instanceName].element.$.name;
  //     if(name=="txt_multi_choice"){
  //       var instance_id = CKEDITOR.instances[instanceName].element.$.id;
  //       var rd_name = instance_id.substring(10,instance_id.length);
  //       var correct_ans = document.getElementsByName(rd_name);
  //       if(correct_ans[0].checked){
  //         console.log("true");
  //       }else{
  //         console.log("false");
  //       }
  //     }
  //     // console.log( CKEDITOR.instances[instanceName].element.$.id );
  //     // console.log(instanceName);
  //     // console.log(CKEDITOR.instances[instanceName]);
  //   } 
  //   // CKEDITOR.instances.foreach(item=>{
  //   //   console.log(item);
  //   // });
  //   // var param = {
  //   //   question:CKEDITOR.instances.txt_question.getData(),
  //   //   ans1:CKEDITOR.instances.txt_choice1.getData(),
  //   //   ans2:CKEDITOR.instances.txt_choice2.getData(),
  //   //   ans3:CKEDITOR.instances.txt_choice3.getData(),
  //   //   ans4:CKEDITOR.instances.txt_choice4.getData(),
  //   //   correct_ans:$('select#correct_ans').val(),
  //   //   subj_id:$('select#subject').val(),
  //   //   user_id:'<?=$user_id?>'
  //   // };
  //   // // console.log(encode(JSON.stringify(param)));
  //   // var http = new XMLHttpRequest();
  //   // http.open("POST", 'controller/question_controller.php', true);
  //   // http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  //   // http.onreadystatechange = function() {
	// 	// 		if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
  //   //       // console.log(this.responseText);
  //   //       eval(this.responseText);
	// 	// 		}
	// 	// }
  //   // var _param = encode(JSON.stringify(param));
  //   // http.send("question_choice=" + _param);
  // }
  // function save_ans(){
  //   var txt_ans = document.getElementById('txt_correct_ans');
  //   if(CKEDITOR.instances.txt_question.getData()=="" || txt_ans.value == ""){
  //     Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບຖ້ວນ!</span>'});
  //   }else{
  //     var param = {
  //       question: CKEDITOR.instances.txt_question.getData(),
  //       correct_ans:txt_ans.value,
  //       subj_id:$('select#subject').val(),
  //       user_id:'<?=$user_id?>'
  //     }
  //     // console.log(encode(JSON.stringify(param)));
  //     var http = new XMLHttpRequest();
  //     http.open("POST", 'controller/question_controller.php', true);
  //     http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  //     http.onreadystatechange = function() {
  //         if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
  //           // console.log(this.responseText);
  //           // eval(this.responseText);
  //         }
  //     }
  //     var _param = encode(JSON.stringify(param));
  //     http.send("question=" + _param);
  //   }
  // }
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
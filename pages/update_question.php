<?php
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
      $ans_choice = json_decode($question_data['ans_choice']);
      $question_type =  $question_data['question_type'];
      $subj_id = $question_data['subj_id'];
      $ans_choice = json_decode($question_data['ans_choice']);
      $correct_ans = json_decode($question_data['correct_ans']);
      // print_r($ans_choice);
    ?>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="cus-card card">
          <div class="card-body">
            <h4 class="card-title phetsarath">ແກ້ໄຂຄໍາຖາມ</h4>
            <div class="top-content content-new-ques">
                <div class="question-type">
                  <div class="question-type-label phetsarath">
                    ເລືອກປະເພດຄໍາຖາມ
                  </div>
                  <select onchange="type_selected(this.value)" class="form-select none-select none-outline ques-type phetsarath" name="question_type" id="question_type" disabled>
                    <option value="0" <?=($question_type==0)?'selected':''?>>ປາລາໄນ</option>
                    <option value="1" <?=($question_type==1)?'selected':''?>>ປາລາໄນ (ມີຫຼາຍຄໍາຕອບ)</option>
                    <option value="2" <?=($question_type==2)?'selected':''?>>ອັດຕະໄນ</option>
                  </select>
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
                  <input id="full_score" class="txt-score phetsarath" type="number" value="<?=$question_data['full_point']?>" min="1">
                </div>
            </div>
            <div class="question-title">
              <label for="txt_question_title" class="phetsarath">ຫົວຂໍ້ຄໍາຖາມສອບເສັງ*</label>
              <textarea name="txt_question_title" id="txt_question_title" class="phetsarath txt_question_title" rows="3"><?=$question_data['title']?></textarea>
            </div>
            <div class="question" id="question">
              <label for="txt_question" class="phetsarath">ຄໍາຖາມສອບເສັງ</label>
              <textarea name="txt_question" id="txt_question" class="phetsarath txt_question" rows="10"><?=$question_data['question']?></textarea>
            </div>
            <!-- question type 0 -->
            <div class="div-ans-choice" id="ques-0">
              <div class="ans-choice" id="ans-ques-0">
                <?php
                  if($question_type==0){
                    foreach ($ans_choice as $key => $value) {
                      if(!empty($value)){
                        if($key>1){
                          ?>
                          <div class="choice-item" id="choice<?=($key+1)?>">
                          <div><div class="choice-caption phetsarath">ຄໍາຕອບທີ <?=($key+1)?>*</div>
                          <textarea name="txt_choice" id="txt_choice<?=($key+1)?>" class="phetsarath"><?=$value?></textarea></div>
                          <button onclick="remove_choice_q_0('txt_choice<?=($key+1)?>','choice<?=($key+1)?>','item<?=($key+1)?>')" type="button" class="btn-remove-choice btn btn-light">
                          <i class="fas fa-solid fa-trash"></i></button>
                          </div>
                          <?php
                        }else{
                          ?>
                          <div class="choice-item">
                            <div>
                              <div class="choice-caption phetsarath">ຄໍາຕອບທີ <?=($key+1)?>*</div>
                              <textarea name="txt_choice" id="txt_choice<?=($key+1)?>" class="phetsarath"><?=$value?></textarea>
                            </div>
                          </div>
                          <?php
                        }
                      }
                    }
                  }else{
                    ?>
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
                    <?php
                  }
                ?>
              </div>
              <div class="add-ans">
                <button onclick="add_ans_q_0()" type="button" class="btn-add-ans btn btn-secondary"><i class="fas fa-solid fa-plus"></i></button>
              </div>
              <div class="correct-ans">
                <label for="correct_ans" class="phetsarath">ຄໍາຕອບທີ່ຖືກຕ້ອງ</label>
                <select class="form-select none-select none-outline subject phetsarath" aria-label="Default select" name="correct_ans" id="correct_ans">
                  <?php
                    if($question_type==0){
                      foreach ($ans_choice as $key => $value) {
                        if(!empty($value)){
                          ?>
                          <option id="item<?=($key+1)?>" class='phetsarath' value='<?=$key?>' <?=($key==$correct_ans[0])?'selected':''?>>ຄໍາຕອບທີ <?=($key+1)?></option>
                          <?php
                        }
                      }
                    }else{
                      ?>
                      <option class='phetsarath' value='0'>ຄໍາຕອບທີ 1</option>
                      <option class='phetsarath' value='1'>ຄໍາຕອບທີ 2</option>
                      <?php
                    }
                  ?>
                </select>
              </div>
              <div class="submit-btn">
                <button onclick="update_question(0,'<?=$user_id?>','<?=$question_id?>','<?=$subj_id_param?>')" type="submit" name="save_ans_choice" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                        ບັນທຶກ
                  <i class="fas fa-save btn-icon-append"></i>                                                                             
                </button>
              </div>
            </div>
            <!-- question type 1 -->
            <div class="div-ans-choice" id="ques-1">
              <div class="ans-choice" id="ans-ques-1">
                <?php
                  if($question_type==1){
                    foreach ($ans_choice as $key => $value) {
                      if(!empty($value)){
                        if($key>1){
                          ?>
                          <div class="choice-item" id="multi-choice<?=($key+1)?>">
                            <div>
                              <div class="choice-caption phetsarath">ຄໍາຕອບທີ <?=($key+1)?>*</div>
                              <textarea name="txt_multi_choice" id="txt_multi_choice<?=($key+1)?>" class="phetsarath"><?=$value?></textarea>
                            </div>
                            <div>
                              <input value="<?=$key?>" type="radio" class="btn-check" name="choice<?=($key+1)?>" id="choice<?=($key+1)?>-true" autocomplete="off" <?=in_array($key,$correct_ans)?'checked':''?>>
                              <label class="btn-choice btn btn-outline-success phetsarath" for="choice<?=($key+1)?>-true">ຖືກ</label>
                              <input type="radio" class="btn-check" name="choice<?=($key+1)?>" id="choice<?=($key+1)?>-false" autocomplete="off" >
                              <label class="btn-choice btn btn-outline-danger phetsarath" for="choice<?=($key+1)?>-false">ຜິດ</label>
                              <button onclick="remove_choice_q_1('txt_multi_choice<?=($key+1)?>','multi-choice<?=($key+1)?>')" type="button" class="btn-remove-choice btn btn-light">
                              <i class="fas fa-solid fa-trash"></i></button>
                            </div>
                          </div>
                          <?php
                        }else{
                          ?>
                          <div class="choice-item">
                            <div>
                              <div class="choice-caption phetsarath">ຄໍາຕອບທີ <?=($key+1)?>*</div>
                              <textarea name="txt_multi_choice" id="txt_multi_choice<?=($key+1)?>" class="phetsarath"><?=$value?></textarea>
                            </div>
                            <div>
                              <input value="<?=$key?>" type="radio" class="btn-check" name="choice<?=($key+1)?>" id="choice<?=($key+1)?>-true" autocomplete="off" <?=in_array($key,$correct_ans)?'checked':''?> >
                              <label class="btn-choice btn btn-outline-success phetsarath" for="choice<?=($key+1)?>-true">ຖືກ</label>
                              <input type="radio" class="btn-check" name="choice<?=($key+1)?>" id="choice1-false" autocomplete="off" >
                              <label class="btn-choice btn btn-outline-danger phetsarath" for="choice<?=($key+1)?>-false">ຜິດ</label>
                            </div>
                          </div>
                          <?php
                        }
                      }
                    }
                  }else{
                    ?>
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
                    <?php
                  }
                ?>
              </div>
              <div class="add-ans">
                <button onclick="add_ans_q_1()" type="button" class="btn-add-ans btn btn-secondary"><i class="fas fa-solid fa-plus"></i></button>
              </div>
              <div class="submit-btn">
                <button onclick="update_question(1,'<?=$user_id?>','<?=$question_id?>','<?=$subj_id_param?>')" type="submit" name="save_ans_choice" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                        ບັນທຶກ
                  <i class="fas fa-save btn-icon-append"></i>                                                                             
                </button>
              </div>
            </div>
            <!-- question type 2 -->
            <div class="div-ans" id="ques-2">
              <div class="form-check">
                <input type="checkbox" value="1" name="show_question_content" id="show_question_content" <?=($question_data['show_ques_content']==1)?'checked':''?>>
                <label class="phetsarath" for="show_question_content">
                  ສະແດງເນື້ອໃນຄໍາຖາມ
                </label>
              </div>
              <!-- <div class="correct_ans">
                <div class="choice-caption phetsarath">ຄໍາຕອບທີຖືກຕ້ອງ</div>
                <input id="txt_correct_ans" type="number" name="txt_correct_ans" class="txt-correct-ans">
              </div> -->
              <div class="submit-btn">
                <button onclick="update_question(2,'<?=$user_id?>','<?=$question_id?>','<?=$subj_id_param?>')" type="submit" name="save_ans" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
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
  <?php
  if($question_type==0){
    echo "ques_1.hidden = true;
    ques_2.hidden = true;";
  }elseif($question_type==1){
    echo "ques_0.hidden = true;
    ques_1.hidden = false;
    ques_2.hidden = true;";
  }else{
    echo "ques_0.hidden = true;
    ques_1.hidden = true;
    ques_2.hidden = false;";
  }
  ?>
  // ques_1.hidden = true;
  // ques_2.hidden = true;
	CKEDITOR.replace( 'txt_question',{
        height: 200,
        language: 'en'
    });
  CKEDITOR.disableAutoInline = true;
  <?php
    if($question_type==0){
      foreach ($ans_choice as $key => $value) {
        if(!empty($value)){
          ?>
          CKEDITOR.inline('txt_choice<?=($key+1)?>');
          <?php
        }
      }
    }else{
      if($question_type==1){
        foreach ($ans_choice as $key => $value) {
          if(!empty($value)){
            ?>
            CKEDITOR.inline('txt_multi_choice<?=($key+1)?>');
            <?php
          }
        }
      }else{
        ?>
        CKEDITOR.inline('txt_multi_choice1');
        CKEDITOR.inline('txt_multi_choice2');
        <?php
      }
      ?>
      CKEDITOR.inline('txt_choice1');
      CKEDITOR.inline('txt_choice2');
      <?php
    }
  ?>
  CKEDITOR.inline('txt_question_title');
</script>